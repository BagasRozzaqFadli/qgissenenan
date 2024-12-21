<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama_toko = $_POST['nama_toko'];
    $alamat = $_POST['alamat'];
    $latitude = filter_var($_POST['latitude'], FILTER_VALIDATE_FLOAT);
    $longitude = filter_var($_POST['longitude'], FILTER_VALIDATE_FLOAT);
    $deskripsi = $_POST['deskripsi'];
    $kontak = $_POST['kontak'];
    $waktu_buka = $_POST['waktu_buka'];
    $kategori = $_POST['kategori'];

    if ($latitude === false || $longitude === false) {
        echo "Latitude atau Longitude tidak valid.";
        exit;
    }

    // Query untuk update data
    $query = "UPDATE penjual SET 
              nama_toko='$nama_toko', 
              alamat='$alamat', 
              latitude='$latitude', 
              longitude='$longitude', 
              deskripsi='$deskripsi', 
              kontak='$kontak', 
              waktu_buka='$waktu_buka',
              kategori='$kategori' 
              WHERE id=$id";
    
    if ($conn->query($query)) {
        header("Location: ../admin_dashboard.php");
        exit();
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>
