<?php
declare(strict_types=1);

/**
 * Theme loader. Themes only render data; database and CMS logic stay in Core.
 */
final class ThemeManager
{
    private PDO $pdo;
    private string $directory;

    public function __construct(PDO $pdo, string $directory)
    {
        $this->pdo = $pdo;
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR);
    }

    public function active(): array
    {
        $statement = $this->pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'active_theme' LIMIT 1");
        try {
            $statement->execute();
            $slug = (string) ($statement->fetchColumn() ?: 'paper-cast');
        } catch (PDOException $exception) {
            $slug = 'paper-cast';
        }

        return $this->get($slug) ?? $this->get('paper-cast') ?? [];
    }

    public function get(string $slug): ?array
    {
        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            return null;
        }

        $folder = $this->directory . DIRECTORY_SEPARATOR . $slug;
        $manifest = $folder . DIRECTORY_SEPARATOR . 'theme.json';
        if (!is_dir($folder) || !is_file($manifest)) {
            return null;
        }

        $data = json_decode((string) file_get_contents($manifest), true);
        if (!is_array($data) || empty($data['name'])) {
            return null;
        }

        return $data + ['slug' => $slug, 'directory' => $folder];
    }

    public function all(): array
    {
        $themes = [];
        foreach (glob($this->directory . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) ?: [] as $folder) {
            $slug = basename($folder);
            $theme = $this->get($slug);
            if ($theme !== null) {
                $themes[] = $theme;
            }
        }
        return $themes;
    }

    public function view(array $theme, string $view): string
    {
        if (!preg_match('/^[a-z0-9-]+$/', $view)) {
            throw new RuntimeException('Invalid theme view.');
        }

        $file = $theme['directory'] . DIRECTORY_SEPARATOR . $view . '.php';
        if (!is_file($file)) {
            throw new RuntimeException('Theme view not found: ' . $view);
        }
        return $file;
    }

    public function activate(string $slug): bool
    {
        if ($this->get($slug) === null) {
            return false;
        }

        $statement = $this->pdo->prepare(
            "INSERT INTO settings (setting_key, setting_value) VALUES ('active_theme', :value)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)"
        );
        return $statement->execute(['value' => $slug]);
    }
}
