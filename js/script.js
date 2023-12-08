window.onload = function() {
  const navBtn = document.getElementById("nav-menu-btn");
  const onglets = document.querySelector(".nav-buttons");

  navBtn.addEventListener('click', () => {
      onglets.classList.toggle('none');
  });

  jsMyProfile();
}

function jsMyProfile() {
  //Section profil
  let btnModifProfile = document.getElementById("modifierProfil");

  if (!btnModifProfile) {
    return;
  }

  let inputsProfile = document.querySelectorAll("main#profile form > .grid input");
  let selectLangue = document.getElementById("selectLangue");
  let copieSelectLangue = document.getElementById("id_langue");
  let btnEnregistrer = document.getElementById("boutonEnregistrer");
  let labelPhoto = document.getElementById("labelPhoto");
  let photo = document.getElementById("photo");
  let imgPhoto = document.querySelector("main#profile .myProfile > .grid img");
  let formulaire = document.querySelector("form");


  let btnChangeMdp = document.getElementById("btnChangeMdp");
  let changeMdpBox = document.getElementById("changeMdpBox");
  let changeMdpConfirm = document.getElementById("changeMdpConfirm");
  let changeMdpAnnuler = document.getElementById("changeMdpAnnuler");
  
  btnModifProfile.addEventListener("click", function() {
    let readOnly;
    if (btnModifProfile.innerHTML == 'Modifier le profil') {
      labelPhoto.classList.remove("hidden");
      btnEnregistrer.classList.remove("hidden");
      btnChangeMdp.classList.remove("hidden");

      btnModifProfile.innerHTML = 'Arrêter la modification';
      readOnly = false;

      selectLangue.disabled = false;

      photo.type = "text";

      formulaire.classList.add("modifying");
    }
    else {
      labelPhoto.classList.add("hidden");
      btnChangeMdp.classList.add("hidden");

      btnModifProfile.innerHTML = 'Modifier le profil'
      readOnly = true;
      selectLangue.disabled = true;

      photo.type = "hidden";
      formulaire.classList.remove("modifying");
    }

    inputsProfile.forEach(function(element) {
      element.readOnly = readOnly;
    });

  });

  btnEnregistrer.addEventListener("click", function(event) {
    if (!confirm("Êtes-vous certains de vouloir enregistrer les modifications?")) {
      event.preventDefault();
    }
  });

  selectLangue.addEventListener("change", function() {
    copieSelectLangue.value = selectLangue.value;
  });

  photo.addEventListener("change", function() {
    imgPhoto.src = photo.value;
  });

  btnChangeMdp.addEventListener("click", function() {
    changeMdpBox.classList.remove("hidden");
  });

  changeMdpAnnuler.addEventListener("click", function() {
    changeMdpBox.classList.add("hidden");
  });
}
