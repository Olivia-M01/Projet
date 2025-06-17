// Affichage/fermeture du menu profil
const btn = document.getElementById('profileMenuBtn');
const dropdown = document.getElementById('profileDropdown');
btn.addEventListener('click', function(e) {
    e.stopPropagation();
    dropdown.classList.toggle('show');
});
document.addEventListener('click', function(e) {
    if (!dropdown.contains(e.target)) {
        dropdown.classList.remove('show');
    }
});