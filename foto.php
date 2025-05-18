<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_alat';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT foto FROM barang WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($foto);
    $stmt->fetch();
    $stmt->close();

    if ($foto) {
        header("Content-Type: image/jpeg");
        echo $foto;
        exit;
    }
}
http_response_code(404);
echo "Gambar tidak ditemukan";
