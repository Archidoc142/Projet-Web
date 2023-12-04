const navBtn = document.getElementById("nav-menu-btn");
const onglets = document.querySelector(".nav-buttons");

navBtn.addEventListener('click', () => {
    onglets.classList.toggle('none');
});