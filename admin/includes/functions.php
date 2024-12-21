<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama_toko = $_POST['nama_toko'];
    $alamat = $_POST['alamat'];
    $latitude = filter_var($_POST['latitude'], FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($_POST['longitude'], FILTER_VALIDATE_FLOAT);
    $deskripsi = $_POST['deskripsi'];
    $kontak = $_POST['kontak'];
    $waktu_buka = $_POST['waktu_buka'];
    $kategori = $_POST['kategori'];  // Ambil kategori dari form (yang baru)

    if ($latitude === false || $longitude === false) {
        echo "Latitude atau Longitude tidak valid.";
        exit;
    }

    // Jika $id ada, berarti akan melakukan UPDATE
    if ($id) {
        $query = "UPDATE penjual SET 
                  nama_toko='$nama_toko', 
                  alamat='$alamat', 
                  latitude='$latitude', 
                  longitude='$longitude', 
                  deskripsi='$deskripsi', 
                  kontak='$kontak', 
                  waktu_buka='$waktu_buka',
                  kategori='$kategori'  -- Update kategori
                  WHERE id=$id";
    } else {
        // Jika tidak ada $id, berarti akan melakukan INSERT
        $query = "INSERT INTO penjual (nama_toko, alamat, latitude, longitude, deskripsi, kontak, waktu_buka, kategori) 
                  VALUES ('$nama_toko', '$alamat', '$latitude', '$longitude', '$deskripsi', '$kontak', '$waktu_buka', '$kategori')";
    }

    // Menjalankan query
    if ($conn->query($query)) {
        // Redirect setelah query berhasil
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM penjual WHERE id=$id");
    header("Location: admin_dashboard.php");
    exit();
}
?>
