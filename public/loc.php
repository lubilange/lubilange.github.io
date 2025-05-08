<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Localisation des écoles proches</title>
  <style>
    /* Mise en page globale */
    body {
      display: flex;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    /* Panneau latéral */
    #sidebar {
      width: 30%;
      background: #ddd;
      padding: 15px;
      height: 100vh;
      overflow-y: auto;
    }

    /* Barre de recherche */
    #search {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 20px;
      outline: none;
      margin-bottom: 15px;
    }

    /* Liste des écoles */
    .school {
      display: flex;
      align-items: center;
      background: white;
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .school img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .school-info {
      flex: 1;
    }

    .school-name {
      font-weight: bold;
    }

    /* Carte */
    #map {
      flex: 1;
      height: 100vh;
    }
  </style>

  <!-- Leaflet.js -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>

  <!-- Panneau latéral -->
  <div id="sidebar">
    <input type="text" id="search" placeholder="Rechercher école...">
    <div id="school-list"></div>
  </div>

  <!-- Carte -->
  <div id="map"></div>

  <script>
    // Création de la carte
    const map = L.map('map').setView([51.5074, -0.1278], 13);

    // Ajout du fond OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Liste des écoles enregistrées (Exemple)
    const schools = [
      { id: 1, name: "Institut Salama", address: "Av Amisi, Q Golf", lat: 51.505, lon: -0.09, img: "https://via.placeholder.com/50" },
      { id: 2, name: "Institut Madini", address: "Av Amisi, Q Golf", lat: 51.507, lon: -0.11, img: "https://via.placeholder.com/50" },
      { id: 3, name: "Institut Flora", address: "Av Amisi, Q Golf", lat: 51.509, lon: -0.13, img: "https://via.placeholder.com/50" },
      { id: 4, name: "Institut Salama", address: "Av Amisi, Q Golf", lat: 51.503, lon: -0.12, img: "https://via.placeholder.com/50" },
    ];

    // Affichage des écoles dans la liste et sur la carte
    const schoolList = document.getElementById('school-list');

    schools.forEach(school => {
      // Ajout du marqueur sur la carte
      const marker = L.marker([school.lat, school.lon]).addTo(map)
        .bindPopup(`<strong>${school.name}</strong><br>${school.address}`);

      // Création de l'élément de liste
      const schoolItem = document.createElement('div');
      schoolItem.classList.add('school');
      schoolItem.innerHTML = `
        <img src="${school.img}" alt="École">
        <div class="school-info">
          <div class="school-name">${school.name}</div>
          <div>${school.address}</div>
        </div>
      `;

      // Lorsque l'on clique sur une école dans la liste, centrer la carte dessus
      schoolItem.addEventListener('click', () => {
        map.setView([school.lat, school.lon], 15);
        marker.openPopup();
      });

      schoolList.appendChild(schoolItem);
    });

    // Filtrage de la recherche
    document.getElementById('search').addEventListener('input', function() {
      const searchText = this.value.toLowerCase();
      document.querySelectorAll('.school').forEach(schoolItem => {
        const name = schoolItem.querySelector('.school-name').innerText.toLowerCase();
        if (name.includes(searchText)) {
          schoolItem.style.display = "flex";
        } else {
          schoolItem.style.display = "none";
        }
      });
    });
  </script>

</body>
</html>
