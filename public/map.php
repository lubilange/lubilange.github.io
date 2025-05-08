<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Localisation des écoles</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    #map {
      height: 100vh; /* Utilisation de toute la hauteur de la fenêtre */
      width: 100%;
    }

    .search-container {
      position: absolute;
      top: 20px;
      left: 20px;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 10px;
      border-radius: 5px;
      z-index: 1000;
    }

    .search-container input {
      padding: 8px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>

  <!-- Zone de recherche pour l'adresse -->
  <div class="search-container">
    <input type="text" id="search" placeholder="Entrez votre adresse...">
  </div>

  <!-- Carte -->
  <div id="map"></div>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>
    // Initialisation de la carte Leaflet
    var map = L.map('map').setView([51.505, -0.09], 13); // Latitude et Longitude par défaut (Londres)

    // Ajout des tuiles de la carte OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Fonction pour ajouter un marqueur sur la carte à une position donnée
    function addSchoolMarker(lat, lon, schoolName) {
      var marker = L.marker([lat, lon]).addTo(map);
      marker.bindPopup("<b>" + schoolName + "</b>").openPopup();
    }

    // Exemple d'écoles à localiser (coordonnées fictives)
    var schools = [
      { name: "École A", lat: 51.505, lon: -0.09 },
      { name: "École B", lat: 51.51, lon: -0.1 },
      { name: "École C", lat: 51.49, lon: -0.08 }
    ];

    // Ajout des marqueurs pour chaque école
    schools.forEach(function(school) {
      addSchoolMarker(school.lat, school.lon, school.name);
    });

    // Fonction de géocodage pour rechercher une adresse et centrer la carte
    var geocoder = new L.Control.Geocoder.nominatim();
    var searchInput = document.getElementById("search");

    searchInput.addEventListener("input", function() {
      var query = searchInput.value;

      if (query.length > 3) {
        geocoder.geocode(query, function(results) {
          if (results.length > 0) {
            var bestResult = results[0];
            map.setView(bestResult.center, 13); // Centrer la carte sur le lieu trouvé
            L.marker(bestResult.center).addTo(map).bindPopup("<b>Vous êtes ici</b>").openPopup();
          }
        });
      }
    });

    // Fonction pour localiser la position actuelle de l'utilisateur
    function locateUser() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var lon = position.coords.longitude;

          // Centrer la carte sur la position de l'utilisateur
          map.setView([lat, lon], 13);

          // Ajouter un marqueur à la position de l'utilisateur
          L.marker([lat, lon]).addTo(map)
            .bindPopup("<b>Vous êtes ici</b>")
            .openPopup();
        }, function() {
          alert("Impossible de localiser votre position.");
        });
      } else {
        alert("La géolocalisation n'est pas supportée par votre navigateur.");
      }
    }

    // Assurez-vous d'utiliser https:// pour un bon fonctionnement de la géolocalisation
    if (window.location.protocol !== 'https:') {
      alert('Veuillez utiliser HTTPS pour que la géolocalisation fonctionne correctement.');
    }

    // Appeler la fonction pour localiser l'utilisateur au chargement de la page
    locateUser();

  </script>

</body>
</html>
