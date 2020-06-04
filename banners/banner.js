// The individual refresh buttons
refreshBtns = document.getElementsByClassName("refresh-icon");
iframes = document.getElementsByClassName("iframe");
for (let i = 0; i < refreshBtns .length; i++) {
    refreshBtns[i].onclick = function(){iframes[i].src += '';};
}
// popUp feedback window
let mailResult = document.getElementById('mailResult');
let span2 = document.getElementsByClassName("closePopUp")[0];
span2.onclick = function() {mailResult.classList.remove("visible");}
window.onclick = function(event) {
    if (event.target == mailResult) {mailResult.classList.remove("visible");} 
}