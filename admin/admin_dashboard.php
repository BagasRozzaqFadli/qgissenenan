<?php
include 'includes/header.php';
include 'includes/functions.php';
?>

<div class="container mt-5">
    <h1>Map Peletakan Koordinat Warung Makan Desa Senenan</h1>
    <iframe src="../map.php" title="Preview Map" style="width: 100%; height: 400px; border: none;"></iframe>
    
    <!-- Tombol untuk menampilkan/menghapus form -->
    <button id="toggleFormBtn" class="btn btn-primary mt-3">
        <?= isset($_GET['edit']) ? 'Edit Data Warung Makan' : 'Tambah Data Warung Makan'; ?>
    </button>

    <!-- Form untuk CRUD yang dapat disembunyikan -->
    <div id="crudForm" class="mt-3">
        <?php 
        if (isset($_GET['edit'])) {
            include 'includes/edit_table.php'; // Menampilkan form untuk edit
        } else {
            include 'includes/form.php'; // Menampilkan form untuk tambah
        }
        ?>
    </div>

    <?php include 'includes/table.php'; ?>
</div>

<script>
    // Menambahkan fungsi untuk toggle form
    document.getElementById('toggleFormBtn').addEventListener('click', function() {
        var form = document.getElementById('crudForm');
        var currentDisplay = form.style.display;
        
        // Mengatur form untuk ditampilkan atau disembunyikan
        if (currentDisplay === 'none' || currentDisplay === '') {
            form.style.display = 'block';
            this.textContent = 'Sembunyikan Form'; // Mengubah teks tombol
        } else {
            form.style.display = 'none';
            this.textContent = 'Tambah Data Warung Makan'; // Mengubah teks tombol kembali
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
