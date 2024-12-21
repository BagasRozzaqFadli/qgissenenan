<?php
$result = $conn->query("SELECT * FROM penjual");
?>
<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Toko</th>
            <th>Alamat</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Deskripsi</th>
            <th>Kontak</th>
            <th>Waktu Buka</th>
            <th>Kategori</th> <!-- Mengubah kategori_menu menjadi kategori -->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama_toko'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['latitude'] ?></td>
                <td><?= $row['longitude'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td><?= $row['kontak'] ?></td>
                <td><?= $row['waktu_buka'] ?></td>
                <td><?= $row['kategori'] ?></td> <!-- Mengubah kategori_menu menjadi kategori -->
                <td>
                    <a href="?edit=<?= $row['id'] ?>&nama_toko=<?= $row['nama_toko'] ?>&alamat=<?= $row['alamat'] ?>&latitude=<?= $row['latitude'] ?>&longitude=<?= $row['longitude'] ?>&deskripsi=<?= $row['deskripsi'] ?>&kontak=<?= $row['kontak'] ?>&waktu_buka=<?= $row['waktu_buka'] ?>&kategori=<?= $row['kategori'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</a>
                    <a href="../map.php?lat=<?= $row['latitude'] ?>&lon=<?= $row['longitude'] ?>&zoom=18" class="btn btn-info btn-sm" target="_blank">View Location</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
