// Gestion du mode édition du profil utilisateur
window.addEventListener('DOMContentLoaded', function() {
    // Sélection des éléments du DOM
    const btnModifier = document.getElementById('btn-modifier'); // Bouton "Modifier"
    const form = document.getElementById('profil-identite-form'); // Formulaire d'édition
    const view = document.getElementById('profil-identite-view'); // Vue affichage infos
    const btnAnnuler = document.getElementById('btn-annuler'); // Bouton "Annuler"
    // Vérifie que tous les éléments existent
    if (!btnModifier || !form || !view || !btnAnnuler) return;

    // Quand on soumet le formulaire, on met à jour les infos affichées
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById('profil-nom').textContent = document.getElementById('input-nom').value;
        document.getElementById('profil-email').textContent = 'E-mail : ' + document.getElementById('input-email').value;
        document.getElementById('profil-tel').textContent = 'Téléphone : ' + document.getElementById('input-tel').value;
        document.getElementById('profil-autre').textContent = document.getElementById('input-autre').value;
        form.style.display = 'none'; // Cache le formulaire
        view.style.display = 'flex'; // Affiche la vue
    });

    // Quand on clique sur "Modifier", on affiche le formulaire
    btnModifier.addEventListener('click', function() {
        form.style.display = 'flex';
        view.style.display = 'none';
    });

    // Quand on clique sur "Annuler", on cache le formulaire sans sauvegarder
    btnAnnuler.addEventListener('click', function() {
        form.style.display = 'none';
        view.style.display = 'flex';
    });
});
