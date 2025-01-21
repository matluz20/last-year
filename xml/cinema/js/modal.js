// ajout film 
var modal1 = document.getElementById("modal1"); // Utilisez le bon ID de la première fenêtre modale
var modalTrigger1 = document.getElementById("open-modal-button1"); // Utilisez le bon ID du bouton déclencheur de la première fenêtre modale

function openModal1() {
  modal1.style.display = "block";
}

function closeModal1() {
  modal1.style.display = "none";
}

modalTrigger1.addEventListener("click", openModal1);

window.addEventListener("click", function (event) {
  if (event.target === modal1) { // Utilisez le bon ID de la première fenêtre modale
    closeModal1();
  }
});


window.addEventListener('DOMContentLoaded', (event) => {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('openModal1')) {
    openModal1();
  }
});

// check film
function openModal() {
  document.getElementById("modal2").style.display = "block";
}

function closeModal() {
  document.getElementById("modal2").style.display = "none";
}

document.getElementById("open-modal-button2").addEventListener("click", openModal);

window.addEventListener("click", function (event) {
  if (event.target === document.getElementById("modal2")) {
    closeModal();
  }
});


// add seance
var modal3 = document.getElementById("modal3"); // Utilisez le bon ID de la troisième fenêtre modale
var modalTrigger2 = document.getElementById("open-modal-button3"); // Utilisez le bon ID du bouton déclencheur de la première fenêtre modale

function openModal3() {
  modal3.style.display = "block"; // Assurez-vous d'utiliser modal3 pour ouvrir la troisième fenêtre modale
}

function closeModal3() {
  modal3.style.display = "none"; // Assurez-vous d'utiliser modal3 pour fermer la troisième fenêtre modale
}

modalTrigger2.addEventListener("click", openModal3);

window.addEventListener("click", function (event) {
  if (event.target === modal3) { // Utilisez le bon ID de la troisième fenêtre modale
    closeModal3();
  }
});


// window.addEventListener('DOMContentLoaded', (event) => {
//   const urlParams = new URLSearchParams(window.location.search);
//   if (urlParams.has('openModal3')) {
//     openModal3(); // Ouvrir la troisième fenêtre modale si le paramètre "openModal3" est présent dans l'URL
//   }
// });

window.addEventListener('DOMContentLoaded', (event) => {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('openModal3')) {
    openModal3(); // Ouvrir la troisième fenêtre modale si le paramètre "openModal3" est présent dans l'URL

    // Pré-remplissage du champ "titre" si le paramètre "titre" est présent dans l'URL
    const titreParam = urlParams.get('titre');
    if (titreParam) {
      const titreInput = document.querySelector('#seance-form input[name="titre"]');
      if (titreInput) {
        titreInput.value = decodeURIComponent(titreParam);
      }
    }
  }
});



