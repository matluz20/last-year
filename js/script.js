// Fonction déclenché pour activer le mode nuit
function toggleDarkMode() {
    // Récupère l'icone du mode nuit et lui ajoute / enlève la classe fill 
    var nightimg = document.querySelector('#nightimg');
    nightimg.classList.toggle('fill');

    // Vérifie si nightimg possède la classe fill
    if (nightimg.classList == "fill") {
        // change l'image avec sa version rempli
        nightimg.src = "/image/night-fill.svg"
        // Change les couleurs présente dans le fichier color.css
        document.documentElement.style.setProperty('--main', 'black');
        document.documentElement.style.setProperty('--secondary', 'grey');
        document.documentElement.style.setProperty('--titleh2', '#fff');
        document.documentElement.style.setProperty('--card', 'grey');
        document.documentElement.style.setProperty('--header', 'grey');
        document.documentElement.style.setProperty('--header-text', 'black');
        document.documentElement.style.setProperty('--secondaryborder', 'grey');
    }
    else {
        // change l'image avec sa version vide
        nightimg.src = "/image/night-empty.svg"
        // Change les couleurs présente dans le fichier color.css
        document.documentElement.style.setProperty('--main', '#fff');
        document.documentElement.style.setProperty('--secondary', '#004FFF');
        document.documentElement.style.setProperty('--titleh2', 'black');
        document.documentElement.style.setProperty('--card', '#fff');
        document.documentElement.style.setProperty('--header', '#004FFF');
        document.documentElement.style.setProperty('--header-text', '#fff');
        document.documentElement.style.setProperty('--secondaryborder', '#360ed4');
    }

}



// Ouvre la fenetre modal
function openModal(articleId, accountId) {
    // Mettre à jour la valeur de l'élément caché pour l'ID de l'article
    var hiddenArticleInput = document.getElementById('id_articles');
    hiddenArticleInput.value = articleId;

    // Mettre à jour la valeur de l'élément caché pour l'ID du compte
    var hiddenAccountInput = document.getElementById('id_compte');
    hiddenAccountInput.value = accountId;

    // Ouvrir la fenêtre modale
    var modal = document.getElementById('myModal');
    modal.style.display = "block";
}






// Ferme la fenetre modal
function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = "none";
}



function openModal2(articleId, accountId) {
    // Mettre à jour la valeur de l'élément caché pour l'ID de l'article
    var hiddenArticleInput = document.getElementById('id_articles');
    hiddenArticleInput.value = articleId;

    // Mettre à jour la valeur de l'élément caché pour l'ID du compte
    var hiddenAccountInput = document.getElementById('id_compte');
    hiddenAccountInput.value = accountId;

    // Ouvrir la fenêtre modale
    var modal = document.getElementById('myModal2');
    modal.style.display = "block";
}


