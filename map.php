<?php
include 'db.php';

// Fetch all data from penjual table
$query = "SELECT * FROM penjual";
$result = $conn->query($query);

// Store data in an array for use in JavaScript
$data_penjual = [];
while ($row = $result->fetch_assoc()) {
    $data_penjual[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Lokasi Toko Makanan</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Full screen style for map */
        html, body {
            margin: 0;
            height: 100%;
        }
        #map {
            height: 95%; /* Map will occupy 95% of the height */
        }
        #coordinates {
            height: 5%;
            text-align: center;
            line-height: 5vh;
            font-size: 16px;
            font-weight: bold;
            background-color: #f8f9fa;
            border-top: 1px solid #ccc;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <div id="coordinates">Koordinat: -</div>
    <div id="notification" style="display: none; position: fixed; bottom: 10px; left: 50%; transform: translateX(-50%); background-color: #4caf50; color: white; padding: 10px 20px; border-radius: 5px; z-index: 1000;">Koordinat telah disalin ke clipboard </div>


    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-6.6, 110.66], 13); // Koordinat default (Jepara)

        // Tambahkan tile dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Ambil parameter lat, lon, dan zoom dari URL
        var urlParams = new URLSearchParams(window.location.search);
        var lat = parseFloat(urlParams.get('lat'));
        var lon = parseFloat(urlParams.get('lon'));
        var zoom = parseInt(urlParams.get('zoom')) || 15; // Default zoom 15 jika tidak ada parameter

        // Jika parameter lat dan lon ada, zoom ke lokasi tersebut
        if (!isNaN(lat) && !isNaN(lon)) {
            map.setView([lat, lon], zoom); // Zoom in ke lokasi dengan level zoom yang ditentukan
            var marker = L.marker([lat, lon]).addTo(map);
            marker.bindPopup("Lokasi Toko: " + lat + ", " + lon);
        }


        // Data penjual dari PHP
        var dataPenjual = <?= json_encode($data_penjual) ?>;

        // Tambahkan marker untuk setiap toko
        dataPenjual.forEach(function(penjual) {
            var marker = L.marker([penjual.latitude, penjual.longitude]).addTo(map);
            marker.bindPopup(
                `<b>${penjual.nama_toko}</b><br>
                ${penjual.alamat}<br>
                <i>${penjual.deskripsi}</i><br>
                Kontak: ${penjual.kontak || 'Tidak tersedia'}<br>
                Jam Buka: ${penjual.waktu_buka || 'Tidak tersedia'}`
            );
        });

        // Menangkap koordinat dari cursor
        var coordinatesElement = document.getElementById('coordinates');
        map.on('mousemove', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            coordinatesElement.textContent = `Koordinat: ${lat}, ${lng}`;
        });

        map.on('mouseout', function() {
            coordinatesElement.textContent = 'Koordinat: -';
        });

        // Fitur menyalin koordinat saat area peta ditekan
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            var coordinates = `${lat}, ${lng}`;

            // Salin koordinat ke clipboard
            navigator.clipboard.writeText(coordinates).then(function() {
                var notification = document.getElementById('notification');
                notification.style.display = 'block';
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 2000); // Notifikasi hilang setelah 2 detik
            });

        });


        // Menambahkan Polygon dari file GeoJSON BatasSenenFood.geoJSON
        fetch('BatasSenenFood.geoJSON')
            .then(response => response.json())
            .then(data => {
                // Menambahkan layer GeoJSON ke peta
                L.geoJSON(data, {
                    onEachFeature: function (feature, layer) {
                        if (feature.properties && feature.properties.popupContent) {
                            layer.bindPopup(feature.properties.popupContent);
                        }
                    }
                }).addTo(map);
            })
            .catch(error => {
                console.error('Error loading GeoJSON:', error);
            });
    </script>
</body>
</html>
