window.onload = function() {
  //Section profil
  let inputsProfile = document.querySelectorAll("main#profile input");
  let btnModifProfile = document.getElementById("modifierProfil");
  
  btnModifProfile.addEventListener("click", function() {
    let readOnly;
    if (btnModifProfile.innerHTML == 'Modifier le profil') {
      document.getElementById("boutonEnregistrer").classList.remove("hidden");
      btnModifProfile.innerHTML = 'En cours de modification...'
      readOnly = false;
    }
    else {
      btnModifProfile.innerHTML = 'Modifier le profil'
      readOnly = true;
    }

    inputsProfile.forEach(function(element) {
      element.readOnly = readOnly;
    });
  });
}