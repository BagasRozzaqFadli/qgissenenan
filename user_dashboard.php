<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki role 'user'
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['user', 'admin'])) {
    // Jika bukan 'user' atau 'admin', arahkan ke halaman login
    header("Location: pengguna/login.php");
    exit();
}

include 'db.php';

// Ambil kategori unik dari tabel penjual
$kategori_query = "SELECT DISTINCT kategori FROM penjual";
$kategori_result = $conn->query($kategori_query);
$kategori_list = [];
while ($row = $kategori_result->fetch_assoc()) {
    $kategori_list[] = $row['kategori'];
}

// Mengambil data warung makan berdasarkan kategori yang dipilih
$kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : ''; // Mendapatkan kategori yang dipilih dari URL
$query = "SELECT * FROM penjual";
if ($kategori_filter) {
    $query .= " WHERE kategori = '" . $conn->real_escape_string($kategori_filter) . "'";
}
$result = $conn->query($query);

// Store data in an array for use in JavaScript
$data_penjual = [];
while ($row = $result->fetch_assoc()) {
    $data_penjual[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Peta Warung Makan</title>
    <!-- Menambahkan CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Full screen style for map */
        html, body {
            margin: 0;
            height: 100%;
        }
        #map {
            height: 400px; /* Map Preview height */
            cursor: pointer;
        }
        .detail-warung {
            margin-top: 20px;
        }
        #coordinates {
            height: auto;
            text-align: center;
            line-height: 1.5em;
            font-size: 16px;
            font-weight: bold;
            background-color: #f8f9fa;
            border-top: 1px solid #ccc;
            margin-top: 10px;
            position: static;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar dengan Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SenenFood</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['Nama_Pengguna'])): ?>
                    <li class="nav-item">
                        <span class="nav-link">Halo, <?= htmlspecialchars($_SESSION['Nama_Pengguna']); ?></span>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="user_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pengguna/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-4">
        <h1>Dashboard Pengguna - Peta Lokasi Warung Makan Desa Senenan</h1>

        <!-- Filter Kategori -->
        <div class="mb-4">
            <form method="get" action="user_dashboard.php">
                <label for="kategori" class="form-label">Pilih Kategori Warung:</label>
                <select name="kategori" id="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori_list as $kategori): ?>
                        <option value="<?= htmlspecialchars($kategori) ?>" <?= $kategori_filter == $kategori ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kategori) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <!-- Map Preview -->
        <div id="map"></div>
        <div id="coordinates">Koordinat: -</div>

        <div class="detail-warung">
            <h4>Daftar Warung Makan</h4>
            <ul class="list-group">
                <?php foreach ($data_penjual as $penjual): ?>
                    <li class="list-group-item">
                        <b><?= $penjual['nama_toko'] ?></b><br>
                        <?= $penjual['alamat'] ?><br>
                        <p><i><?= $penjual['deskripsi'] ?></i></p>
                        <p><b>Kontak:</b> <?= $penjual['kontak'] ?: 'Tidak tersedia' ?></p>
                        <p><b>Jam Buka:</b> <?= $penjual['waktu_buka'] ?: 'Tidak tersedia' ?></p>
                        <button class="btn btn-info btn-sm" onclick="viewLocation(<?= $penjual['latitude'] ?>, <?= $penjual['longitude'] ?>, '<?= $penjual['nama_toko'] ?>')">Lihat Lokasi</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-6.6, 110.66], 13); // Koordinat default (Jepara)

        // Tambahkan tile dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

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

        // Fungsi untuk menampilkan lokasi yang dipilih dengan zoom in
        function viewLocation(lat, lon, namaToko) {
            map.setView([lat, lon], 18); // Zoom level 18 untuk zoom in sangat dekat
            var marker = L.marker([lat, lon]).addTo(map);
            marker.bindPopup("Lokasi Toko: " + namaToko + "<br>Koordinat: " + lat + ", " + lon).openPopup();
        }

        // Menampilkan marker untuk warung-warung yang terfilter pada kategori
        var warungData = <?= json_encode($data_penjual); ?>;
        warungData.forEach(function(warung) {
            L.marker([warung.latitude, warung.longitude]).addTo(map)
                .bindPopup("Toko: " + warung.nama_toko + "<br>Alamat: " + warung.alamat)
                .openPopup();
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

    </script>
</body>
</html>
