<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_alat';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

// Update data
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    if (!empty($_FILES['foto']['tmp_name'])) {
        $foto = file_get_contents($_FILES['foto']['tmp_name']);
        $stmt = $conn->prepare("UPDATE barang SET nama=?, foto=? WHERE id=?");
        $stmt->bind_param("sbi", $nama, $null, $id);
        $stmt->send_long_data(1, $foto);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("UPDATE barang SET nama=? WHERE id=?");
        $stmt->bind_param("si", $nama, $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: index.php");
    exit;
}

// Ambil data alat
$stmt = $conn->prepare("SELECT nama FROM barang WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nama);
if (!$stmt->fetch()) {
    $stmt->close();
    header("Location: index.php");
    exit;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Edit Alat</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f8;
    margin: 0; padding: 20px;
  }
  h1 { text-align: center; color: #333; }
  form {
    background: white;
    max-width: 400px;
    margin: 20px auto;
    padding: 15px 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  }
  input[type="text"], input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
  }
  button {
    background: #28a745;
    border: none;
    padding: 10px 15px;
    color: white;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
  }
  button:hover {
    background: #1e7e34;
  }
  a {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #007bff;
    text-decoration: none;
  }
  a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<h1>Edit Alat</h1>

<form method="POST" enctype="multipart/form-data">
  <label for="nama">Status</label>
  <input type="text" name="nama" id="nama" required value="<?= htmlspecialchars($nama) ?>" />

  <label for="foto">Ganti Foto (biarkan kosong jika tidak ingin ganti)</label>
  <input type="file" name="foto" id="foto" accept="image/*" />

  <button type="submit" name="update">Update</button>
</form>

<a href="index.php">Kembali ke Daftar</a>

</body>
</html>
