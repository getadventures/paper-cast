'use strict';
const input=document.getElementById('q');
const cards=[...document.querySelectorAll('.cards article')];
const topics=[...document.querySelectorAll('.topic')];
const none=document.getElementById('none');
const status=document.getElementById('status');
function search(){
 const q=input.value.trim().toLocaleLowerCase();let count=0;
 cards.forEach(card=>{const text=(card.innerText+' '+(card.dataset.keys||'')).toLocaleLowerCase();const match=!q||text.includes(q);card.hidden=!match;if(match)count++;});
 topics.forEach(topic=>{topic.hidden=![...topic.querySelectorAll('.cards article')].some(card=>!card.hidden);});
 none.hidden=count!==0;status.textContent=q?count+' matching article'+(count===1?'':'s'):'Search across all help articles';
}
input.addEventListener('input',search);
document.addEventListener('keydown',event=>{if(event.key==='/'&&document.activeElement!==input&&!event.ctrlKey&&!event.metaKey){event.preventDefault();input.focus();}if(event.key==='Escape'&&document.activeElement===input){input.value='';search();input.blur();}});
