
// Fonction qui permet de switch entre la partie connexion et inscription dans la page d'accueil
$(document).ready(function () {
	// Lorsque le bouton signUp est cliqué on ajoute la classe right panel active au container 
	$("#signUp").click(function () {
		$("#container").addClass("right-panel-active");
	});
	// Lorsque le bouton signIn est cliqué on retire la classe right panel active au container 
	$("#signIn").click(function () {
		$("#container").removeClass("right-panel-active");
	});
});


const txtanim = document.querySelector(".bodywriter");

        // Texte statique au lieu de l'animation dynamique
        txtanim.innerHTML = 'Votre nouvel espace réservé à <span class="switch">votre sécurité</span><br><br>Notre plateforme intuitive et sécurisée qui vous permet de gérer facilement votre accès aux salles de sport près de chez vous.';

        // Mise à jour statique de la partie "switch"
        const buySpan = document.querySelector('.switch');
        if (buySpan) {
            buySpan.innerHTML = 'votre sécurité'; // Valeur statique
        };