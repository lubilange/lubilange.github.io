<?php
$pdo = new PDO('mysql:host=localhost;dbname=school_registration', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$search = $_GET['q'] ?? '';
if ($search) {
  $db = $pdo->prepare("SELECT * FROM schools WHERE name LIKE :search");
  $db->execute(['search' => '%' . $search . '%']);
} else {
  $db = $pdo->prepare("SELECT * FROM schools");
  $db->execute();
}
$schools = $db->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Carte des écoles</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
    }

    #container {
      display: flex;
      height: 100vh;
    }

    #sidebar {
      width: 300px;
      overflow-y: auto;
      border-right: 1px solid #ccc;
      padding: 10px;
      box-sizing: border-box;
      background: #f9f9f9;
      transition: left 0.3s ease;
    }

    #map {
      flex-grow: 1;
    }

    .school-item {
      cursor: pointer;
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      transition: background 0.3s;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .school-item:hover {
      background: #f0f0f0;
    }

    .school-item img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 50%;
    }

    /* Responsive */
    #toggleSidebar {
      display: none;
      position: fixed;
      top: 10px;
      left: 10px;
      z-index: 999;
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      font-size: 16px;
    }

    @media (max-width: 768px) {
      #toggleSidebar {
        display: block;
      }

      #container {
        flex-direction: column;
      }

      #sidebar {
        position: fixed;
        left: -100%;
        top: 0;
        height: 100%;
        width: 80%;
        z-index: 998;
      }

      #sidebar.active {
        left: 0;
      }

      #map {
        height: 100vh;
        width: 100%;
      }
    }
  </style>
</head>

<body>

  <button id="toggleSidebar">☰ Écoles</button>

  <div id="container">
    <!-- Sidebar -->
    <div id="sidebar">
      <h3>Liste des écoles</h3>
      <div id="schoolList">
        <?php foreach ($schools as $school): ?>
          <div class="school-item"
            data-name="<?= htmlspecialchars($school['name']) ?>"
            data-address="<?= htmlspecialchars($school['address'] ?? '') ?>"
            data-image="<?= htmlspecialchars($school['EcoleImage'] ?? 'default.jpg') ?>">
            <img src="<?= htmlspecialchars($school['EcoleImage'] ?? 'default.jpg') ?>" alt="École" />
            <div>
              <strong><?= htmlspecialchars($school['name']) ?></strong><br>
              <?= htmlspecialchars($school['address'] ?? 'Adresse non disponible') ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Carte -->
    <div id="map"></div>
  </div>

  <script>
    // Toggle sidebar on mobile
    document.getElementById('toggleSidebar').addEventListener('click', () => {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('active');
    });

    const map = L.map('map').setView([-11.659, 27.479], 12); // Lubumbashi par défaut

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Icône rouge personnalisée
    const redIcon = L.icon({
      iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
      iconSize: [32, 32],
      iconAnchor: [16, 32],
      popupAnchor: [0, -32]
    });

    // Position utilisateur
    let userMarker;
    if (navigator.geolocation) {
      navigator.geolocation.watchPosition(position => {
        const userLat = position.coords.latitude;
        const userLon = position.coords.longitude;

        if (userMarker) {
          userMarker.setLatLng([userLat, userLon]);
        } else {
          userMarker = L.marker([userLat, userLon], {
            icon: redIcon
          }).addTo(map);
          userMarker.bindPopup("📍 Vous êtes ici").openPopup();
        }

        map.setView([userLat, userLon], 14);
      }, error => {
        console.error("Erreur géolocalisation : ", error);
      }, {
        enableHighAccuracy: true,
        maximumAge: 1000,
        timeout: 10000
      });
    }

    // Marqueurs écoles
    const schoolItems = document.querySelectorAll('.school-item');
    let delay = 0;

    schoolItems.forEach((item) => {
      const name = item.dataset.name;
      const image = item.dataset.image;
      const address = item.dataset.address;
      if (!address) return;

      setTimeout(() => {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
          .then(response => response.json())
          .then(data => {
            if (data.length > 0) {
              const lat = parseFloat(data[0].lat);
              const lon = parseFloat(data[0].lon);

              const marker = L.marker([lat, lon]).addTo(map);
              marker.bindPopup(`
              <strong>${name}</strong><br>
              <img src="${image}" alt="École" style="width:50px;height:50px;border-radius:50%;"><br>
              ${address}
            `);

              item.addEventListener('click', () => {
                map.setView([lat, lon], 15);
                marker.openPopup();
                // Cacher la sidebar sur mobile après clic
                document.getElementById('sidebar').classList.remove('active');
              });
            }
          })
          .catch(error => console.error("Erreur géocodage pour :", address, error));
      }, delay);
      delay += 1000;
    });
  </script>
</body>

</html>