
// Fonction permettant de renvoyer vers la page racine
function goBack() {
  window.location.href = "/";
}


//condition pour que tous les champs soient remplis
     document.getElementById('paymentForm').addEventListener('submit', function(event) {
     var cardHolderInput = document.getElementById('cardHolder');
     var cardHolderValue = cardHolderInput.value.trim();
     var nameErrorElement = document.getElementById('nameError');
     if (cardHolder === '') {
         nameErrorElement.innerText = 'Le nom doit être saisi.';
         cardHolderInput.classList.add('is-invalid');
         event.preventDefault(); // Empêche la soumission du formulaire
         } else {
         nameErrorElement.innerText = '';
         cardHolderInput.classList.remove('is-invalid');
         }
     });



document.getElementById('cardNumber').addEventListener('input', function() {
var cardNumberInput = document.getElementById('cardNumber');
var cardNumberValue = cardNumberInput.value.trim();
var cardNumberErrorElement = document.getElementById('cardNumberError');

// Vérifier si la valeur dépasse 16 chiffres
if (cardNumberValue.length !== 16) {
cardNumberInput.value = cardNumberValue.slice(0, 16); // Tronquer la valeur à 16 chiffres
}

// Vérifier si la valeur contient exactement 16 chiffres
if (cardNumberValue.length < 16) {
cardNumberErrorElement.innerText = 'Le numéro de carte doit contenir exactement 16 chiffres.';
cardNumberInput.classList.add('is-invalid');
} else {
cardNumberErrorElement.innerText = '';
cardNumberInput.classList.remove('is-invalid');
}
});





document.getElementById('cvv').addEventListener('input', function() {
var cvvInput = document.getElementById('cvv');
var cvvValue = cvvInput.value.trim();
var cvvErrorElement = document.getElementById('cvvError');

// Vérifier si la valeur dépasse 3 chiffres
if (cvvValue.length > 3) {
cvvInput.value = cvvValue.slice(0, 3); // Tronquer la valeur à 3 chiffres
}

// Vérifier si la valeur contient exactement 3 chiffres
if (cvvValue.length !== 3) {
cvvErrorElement.innerText = 'Le code CVV/CVC doit contenir exactement 3 chiffres.';
cvvInput.classList.add('is-invalid');
} else {
cvvErrorElement.innerText = '';
cvvInput.classList.remove('is-invalid');
}
});


 //script pour la validation de la date
         document.getElementById('expirationDate').addEventListener('input', function() {
     var expirationDateInput = document.getElementById('expirationDate');
     var expirationDateValue = expirationDateInput.value.trim();
     var errorElement = document.getElementById('expirationDateError');

     // Supprimer tous les caractères non numériques
     expirationDateValue = expirationDateValue.replace(/\D/g, '');

     // Limiter la taille à 4 caractères (MM/YY)
     expirationDateValue = expirationDateValue.slice(0, 4);

     // Ajouter le format MM/YY
     if (expirationDateValue.length > 2) {
         expirationDateValue = expirationDateValue.slice(0, 2) + '/' + expirationDateValue.slice(2);
     }

     // Mettre à jour la valeur du champ
     expirationDateInput.value = expirationDateValue;

     // Vérifier si la valeur est vide ou ne correspond pas au format MM/YY
     if (expirationDateValue === '' || !/^\d{2}\/\d{2}$/.test(expirationDateValue)) {
         errorElement.innerText = 'La date d\'expiration doit être au format MM/YY.';
         expirationDateInput.classList.add('is-invalid');
     } else {
         errorElement.innerText = '';
         expirationDateInput.classList.remove('is-invalid');
     }
 });


 document.getElementById('paymentForm').addEventListener('submit', function(event) {
     var cardTypeInput = document.getElementById('cardType');
     var cardHolderInput = document.getElementById('cardHolder');
     var cardNumberInput = document.getElementById('cardNumber');
     var expirationDateInput = document.getElementById('expirationDate');
     var cvvInput = document.getElementById('cvv');

     // Vérifier si tous les champs sont vides
     if (
         cardTypeInput.value.trim() === '' ||
         cardHolderInput.value.trim() === '' ||
         cardNumberInput.value.trim() === '' ||
         expirationDateInput.value.trim() === '' ||
         cvvInput.value.trim() === ''
     ) {
         // Empêcher l'envoi du formulaire
         event.preventDefault();
     }
 });
