// Récupérer la référence de la fenêtre modale
var modal = document.getElementById("modal");

// Récupérer la référence de l'élément qui ouvre la fenêtre modale
var modalTrigger = document.getElementById("modal-btn");

// Récupérer la référence de l'élément pour fermer la fenêtre modale
var closeBtn = document.getElementsByClassName("close")[0];

// Fonction pour ouvrir la fenêtre modale
function openModal() {
  modal.style.display = "block";
}

// Fonction pour fermer la fenêtre modale
function closeModal() {
  modal.style.display = "none";
}

// Écouter l'événement clic pour ouvrir la fenêtre modale
modalTrigger.addEventListener("click", openModal);

// Écouter l'événement clic pour fermer la fenêtre modale en cliquant sur le bouton de fermeture
closeBtn.addEventListener("click", closeModal);
