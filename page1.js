// Google Maps - Carte centrée sur Kinshasa avec un marqueur personnalisé
// Cette fonction est appelée automatiquement par l'API Google Maps grâce au paramètre callback=initMap
function initMap() {
  // Coordonnées du centre de la carte (Kinshasa)
  var kinshasa = { lat: -4.325, lng: 15.322 };
  // Création de la carte Google Maps dans la div #map
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15, // Niveau de zoom adapté à la ville
    center: kinshasa, // Centre la carte sur Kinshasa
    mapTypeControl: false, // Désactive le contrôle du type de carte
    streetViewControl: false, // Désactive Street View
    fullscreenControl: false // Désactive le bouton plein écran
  });
  // Ajout d'un marqueur à l'emplacement de Kinshasa
  var marker = new google.maps.Marker({
    position: kinshasa,
    map: map,
    title: 'Kintacos Kinshasa', // Texte affiché au survol du marqueur
    // icon: 'fond/logo.png' // Décommente cette ligne pour utiliser ton logo comme icône personnalisée
  });
}
