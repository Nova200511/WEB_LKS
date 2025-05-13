<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];

    $gambar = $_FILES['gambar_produk']['name'];
    $tmp = $_FILES['gambar_produk']['tmp_name'];
    $size = $_FILES['gambar_produk']['size'];

    $upload_dir = __DIR__ . '/upload/';
    $gambar_nama = time() . '_' . basename($gambar); // agar nama unik
    $gambar_path = $upload_dir . $gambar_nama;

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $type = mime_content_type($tmp);

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // buat folder jika belum ada
    }

    if (in_array($type, $allowed_types)) {
        if ($size <= 2 * 1024 * 1024) {
            if (move_uploaded_file($tmp, $gambar_path)) {
                $sql = "INSERT INTO produk (nama_produk, gambar_produk) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $nama_produk, $gambar_nama);

                if ($stmt->execute()) {
                    echo "<script>alert('Produk berhasil di-upload!'); window.location = 'index.php';</script>";
                } else {
                    echo "Database error: " . $stmt->error;
                }
            } else {
                echo "Gagal memindahkan file.";
            }
        } else {
            echo "Ukuran file terlalu besar (maks 2MB).";
        }
    } else {
        echo "Format file tidak diizinkan.";
    }
}
?>
