<div class="container mt-4">
    <form method="POST">
        <input type="hidden" name="id" value="<?= $_GET['edit'] ?? '' ?>">
        <div class="form-group">
            <label for="nama_toko">Nama Toko</label>
            <input type="text" name="nama_toko" class="form-control" value="<?= $_GET['nama_toko'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control" required><?= $_GET['alamat'] ?? '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="number" name="latitude" class="form-control" value="<?= $_GET['latitude'] ?? '' ?>" step="any" required>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="number" name="longitude" class="form-control" value="<?= $_GET['longitude'] ?? '' ?>" step="any" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control"><?= $_GET['deskripsi'] ?? '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="kontak">Kontak</label>
            <input type="text" name="kontak" class="form-control" value="<?= $_GET['kontak'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="waktu_buka">Waktu Buka</label>
            <input type="text" name="waktu_buka" class="form-control" value="<?= $_GET['waktu_buka'] ?? '' ?>">
        </div>

        <!-- Dropdown untuk kategori -->
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" class="form-control" required>
                <?php
                // Query untuk mendapatkan kategori yang sudah ada dari database
                include '../db.php';
                $result = $conn->query("SELECT DISTINCT kategori FROM penjual WHERE kategori IS NOT NULL");
                
                // Menyimpan kategori yang ada di database ke dalam array
                $existing_categories = [];
                while ($row = $result->fetch_assoc()) {
                    $existing_categories[] = $row['kategori'];
                }

                // Daftar kategori tetap
                $default_categories = ['Warung Makan', 'Restoran', 'Kafe', 'Bakery', 'Warkop'];

                // Gabungkan kategori yang ada di database dan kategori tetap, tanpa duplikasi
                $all_categories = array_unique(array_merge($existing_categories, $default_categories));

                // Loop untuk menampilkan kategori di dropdown
                foreach ($all_categories as $kategori) {
                    $selected = ($_GET['kategori'] ?? '') === $kategori ? 'selected' : '';
                    echo "<option value='{$kategori}' {$selected}>{$kategori}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
