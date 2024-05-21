
window.addEventListener("load",openMain,"false");
function openMain () {
    document.getElementById("defaultOpen").click();
}
function openTab(evt, userType) {
var i, tabcontent, tablinks;
tabcontent = document.getElementsByClassName("hidden-div");
for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
}
tablinks = document.getElementsByClassName("tab");
for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
}
document.getElementById(userType+"div").style.display = "block";
evt.currentTarget.className += " active";
}