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

  let inputsProfile = document.querySelectorAll("main#profile input");
  let selectLangue = document.getElementById("selectLangue");
  let copieSelectLangue = document.getElementById("id_langue");
  let btnEnregistrer = document.getElementById("boutonEnregistrer");
  let formulaire = document.querySelector("form");
  
  btnModifProfile.addEventListener("click", function() {
    let readOnly;
    if (btnModifProfile.innerHTML == 'Modifier le profil') {
      btnEnregistrer.classList.remove("hidden");
      btnModifProfile.innerHTML = 'Arrêter la modification';
      readOnly = false;

      selectLangue.disabled = false;
    }
    else {
      btnModifProfile.innerHTML = 'Modifier le profil'
      readOnly = true;
      selectLangue.disabled = true;
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
}
