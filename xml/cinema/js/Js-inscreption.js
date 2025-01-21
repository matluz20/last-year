
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


// Effet d'écriture style machine à écrire présent dans la page d'inscription/connexion

// Déclaration de la variable txtanim qui récupère l'emplacement où sera le futur texte généré
const txtanim = document.querySelector(".bodywriter");
// Déclaration de la variable textAnime créant une nouvelle instance de l'objet Typewriter de la librairie que nous avons importé dans notre fichier php concernant l'inscription
var textAnime = new Typewriter(txtanim, {
	// Modification de la vitesse de suppression 
	deleteSpeed: 30,
	loop: true
})

// Affectation des propriétés du texte writer
textAnime
.pauseFor(2000)
	.changeDelay(50)
	.typeString('Ton  espace reservé à ')
	.pasteString('<span class="switch">la création</span>')
	.typeString(' des films proposés dans votre cinéma !')
	.pauseFor(500)
	.typeString('<br><br>Notre plateforme sécurisée vous offre la possibilité de gerer les diffusion des films en quelques clicks !.')
	.pauseFor(300)
	.typeString('<br><br>rejoignez-nous dès maintenant  !')
	.pauseFor(2000)
	.start()

// Déclaration d'une variable booléenne qui servira à créer une transition entre achat et vente sur la page d'accueil
let isBuying = true;

// Utilisation de Set Interval qui permet de réaliser la transition toutes les x secondes en définissant x ici 2000 milisecondes
setInterval(() => {
	const buySpan = document.querySelector('.switch');
	if (buySpan) {
		if (isBuying) {
			buySpan.innerHTML = 'la modification ';
		} else {
			buySpan.innerHTML = 'la mise a jour';
		}
	}
	isBuying = !isBuying;
}, 2000);