<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Localisation des écoles proches</title>
  <style>
    /* Définir la hauteur de la carte */
    #map {
      height: 100vh;
    }
  </style>
  <!-- Inclure Leaflet.js pour OpenStreetMap -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
  <h1>Ecoles proches de votre position</h1>
  <div id="map"></div>
  
  <script>
    // Créer la carte avec un centre par défaut
    const map = L.map('map').setView([51.5074, -0.1278], 13); // Londres par défaut

    // Ajouter le fond de carte OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Fonction pour obtenir les écoles dans toute la ville
    function getNearbySchools(lat, lng) {
      const overpassUrl = `https://overpass-api.de/api/interpreter?data=[out:json];(node["amenity"="school"](around:20000,${lat},${lng}););out;`; // Recherche d'écoles dans un rayon de 20 km
      fetch(overpassUrl)
        .then(response => response.json())
        .then(data => {
          if (data.elements.length > 0) {
            data.elements.forEach(school => {
              const schoolLocation = [school.lat, school.lon];
              
              // Créer le nom de l'école et un bouton "Explorer"
              const schoolInfo = `
                <strong>${school.tags.name || "Ecole inconnue"}</strong><br>
                <a href="details.html?school_id=${school.id}" class="explore-btn">Explorer</a>
                <img class="image ph"
              `;
              
              // Ajouter un marqueur pour chaque école
              L.marker(schoolLocation).addTo(map)
                .bindPopup(schoolInfo) // Afficher le nom de l'école et le bouton
                .openPopup();
            });
          } else {
            alert("Aucune école trouvée dans ce rayon.");
          }
        })
        .catch(error => console.error("Erreur lors de la récupération des données : ", error));
    }

    // Vérifier si la géolocalisation est disponible
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const userLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };

          // Mettre à jour la carte avec la position de l'utilisateur
          map.setView(userLocation, 13);

          // Ajouter un marqueur sur la position de l'utilisateur
          L.marker(userLocation).addTo(map)
            .bindPopup("Vous êtes ici !")
            .openPopup();

          // Obtenir les écoles proches
          getNearbySchools(userLocation.lat, userLocation.lng);
        },
        () => {
          alert("Impossible de récupérer votre position.");
        }
      );
    } else {
      alert("La géolocalisation n'est pas supportée par ce navigateur.");
    }
  </script>
</body>
</html>
