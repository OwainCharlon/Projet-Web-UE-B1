// LA fonction toggleVisibleClass va permettre de créer mon menu burger

function toggleVisibleClass(){

	document.querySelector("header nav ul").classList.toggle("visible");
}

document.querySelector("#burger").addEventListener("click",toggleVisibleClass);

function openNav() {
document.getElementById("myNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
document.getElementById("myNav").style.width = "0%";
}
