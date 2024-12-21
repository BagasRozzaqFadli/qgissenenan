<?php
include '../db.php';

// Ambil data berdasarkan ID dari URL
$id = $_GET['edit'] ?? null;
if ($id) {
    $result = $conn->query("SELECT * FROM penjual WHERE id = $id");
    $row = $result->fetch_assoc();
}
?>

<div class="container mt-3">
    <h2>Edit Data Warung Makan</h2>
    <form method="POST" action="includes/process_edit.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?? '' ?>">
        
        <div class="form-group">
            <label for="nama_toko">Nama Toko</label>
            <input type="text" name="nama_toko" class="form-control" value="<?= $row['nama_toko'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control" required><?= $row['alamat'] ?? '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="number" name="latitude" class="form-control" value="<?= $row['latitude'] ?? '' ?>" step="any" required>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="number" name="longitude" class="form-control" value="<?= $row['longitude'] ?? '' ?>" step="any" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control"><?= $row['deskripsi'] ?? '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="kontak">Kontak</label>
            <input type="text" name="kontak" class="form-control" value="<?= $row['kontak'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="waktu_buka">Waktu Buka</label>
            <input type="text" name="waktu_buka" class="form-control" value="<?= $row['waktu_buka'] ?? '' ?>">
        </div>

        <!-- Dropdown untuk kategori -->
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="Warung Makan" <?= $row['kategori'] === 'Warung Makan' ? 'selected' : ''; ?>>Warung Makan</option>
                <option value="Restoran" <?= $row['kategori'] === 'Restoran' ? 'selected' : ''; ?>>Restoran</option>
                <option value="Kafe" <?= $row['kategori'] === 'Kafe' ? 'selected' : ''; ?>>Kafe</option>
                <option value="Bakery" <?= $row['kategori'] === 'Bakery' ? 'selected' : ''; ?>>Bakery</option>
                <option value="Warkop" <?= $row['kategori'] === 'Warkop' ? 'selected' : ''; ?>>Warkop</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    </form>
</div>
