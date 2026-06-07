<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leaflet Local Test</title>

    <!-- Local Leaflet CSS -->
    <link rel="stylesheet" href="../dist/leaflet.css">

    <style>
      #map {
        width: 100%;
        height: 500px;
      }
    </style>
</head>
<body>
    <h1>Leaflet Local Map</h1>
    <div id="map"></div>

    <!-- Local Leaflet JS -->
    <script src="../dist/leaflet.js"></script>

    <script>
      // Center somewhere (e.g. Yangon)
      const map = L.map('map').setView([16.8, 96.15], 13);

      // OpenStreetMap tiles (still from internet, but free)
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);

      // Test marker
      L.marker([16.8, 96.15]).addTo(map)
        .bindPopup('Hello from Leaflet!')
        .openPopup();
    </script>
</body>
</html>