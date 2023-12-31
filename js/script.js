window.onload = function() {
  const navBtn = document.getElementById("nav-menu-btn");
  const onglets = document.querySelector(".nav-buttons");

  navBtn.addEventListener('click', () => {
      onglets.classList.toggle('none');
  });

  jsMyProfile();

  jsPorts();

  jsArticle();

  jsTelevision();

  const deleteFavBtns = document.querySelectorAll(".favori-buttons button");
  
  deleteFavBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      if(!confirm("Voulez-vous vraiment supprimer ce favori?"))
      {
        e.preventDefault();
      }
    })
  })

}

function jsArticle() {
  let mainArticle = document.querySelector("main#article");
  let boutonAjoutEval = document.getElementById("boutonAjoutEval");
  
  if (!mainArticle || !boutonAjoutEval) {
    return;
  }
  
  let faireEvaluationPopup = document.getElementById("faireEvaluationPopup");
  let boutonAnnulerEval = document.getElementById("boutonAnnulerEval");

  boutonAjoutEval.addEventListener("click", function() {
    faireEvaluationPopup.classList.remove("hidden");
  });

  boutonAnnulerEval.addEventListener("click", function() {
    faireEvaluationPopup.classList.add("hidden");
  });

  const btnFavori = document.getElementById('addFavorite');

  btnFavori.addEventListener('click', () => {
    alert("Modification des favoris");
  });

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

      photo.classList.remove("hidden");

      formulaire.classList.add("modifying");
    }
    else {
      labelPhoto.classList.add("hidden");
      btnChangeMdp.classList.add("hidden");

      btnModifProfile.innerHTML = 'Modifier le profil'
      readOnly = true;
      selectLangue.disabled = true;

      photo.classList.add("hidden");
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

function jsPorts() {
  let main = document.querySelector("main#port");

  if (!main) {
    return;
  }

  let cellulesPort = document.querySelectorAll(".portDiv");

  cellulesPort.forEach(addClickPortListener);

  document.querySelector("#portModelesPopup .button").addEventListener("click", function() {
    document.getElementById("portModelesPopup").classList.add("hidden");
  });
}

function addClickPortListener(element) {
  element.addEventListener("click", fetchTeleviseurs);
}

async function fetchTeleviseurs(event) {
  let idPort = event.currentTarget.firstElementChild.value;
  let portName = event.currentTarget.lastElementChild.innerHTML;

  let listeModelePopup = document.getElementById("portModelesPopup");
  let listeModeleDiv = document.getElementById("listeModeleDiv");
  let listeModeleDivUl = document.querySelector("#listeModeleDiv ul");

  let response = await fetch("fetchTeleviseurs.php", { 
    method: 'POST', 
    headers: { 'Content-Type': 'application/json' }, 
    body: JSON.stringify({ 'idPort': idPort })
  });

  const modeles = await response.json();

  listeModeleDivUl.innerHTML = "";

  listeModeleDiv.firstElementChild.innerHTML = "Téléviseurs ayant un port " + portName + " ou plus :";

  if (modeles.length > 0) {
    modeles.forEach(function(element) {
      let infos = element.split(";");

      let li = document.createElement("li");
      let a = document.createElement("a");

      a.href = "article?modele=" + infos[0];
      a.innerHTML = infos[1];

      li.insertBefore(a, li.firstChild);

      listeModeleDivUl.appendChild(li);
    });
  }
  else {
    listeModeleDivUl.innerHTML = "Aucun modèle correspondant";
  }

  listeModelePopup.classList.remove("hidden");
}

function jsTelevision() {
  let main = document.getElementById("mainTelevision");

  if (!main) {
    return;
  }

  let cookieSearch = getCookie("televisionParameters");

  if (cookieSearch && window.location.href.split("/").pop() == 'television') {
    if (confirm("Reprendre là où vous en étiez à votre dernière recherche?")) {
      window.location.href = "television?" + cookieSearch;
    }
    else
    {
      document.cookie = 'televisionParameters=; Max-Age=-99999999;';
    }
  }
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}