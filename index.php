<?php
$host = 'localhost';
$user = 'root'; // Sesuaikan jika bukan root
$pass = '';     // Sesuaikan jika ada password
$db = 'db_alat';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Upload foto dan simpan ke database
if (isset($_POST['upload'])) {
    $nama = $_POST['nama'];
    $foto = file_get_contents($_FILES['foto']['tmp_name']);

    $stmt = $conn->prepare("INSERT INTO barang (nama, foto) VALUES (?, ?)");
    $null = NULL;
    $stmt->bind_param("sb", $nama, $null);
    $stmt->send_long_data(1, $foto);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal upload: " . $stmt->error;
    }
}

// Hapus data alat
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM barang WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// Ambil semua alat
$result = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Daftar Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
      padding: 20px;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    form {
      background: #fff;
      max-width: 400px;
      margin: 0 auto 30px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    input[type="text"], input[type="file"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
    table {
      width: 90%;
      margin: auto;
      border-collapse: collapse;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: center;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    img {
      width: 80px;
      height: auto;
      border-radius: 5px;
    }
    .btn {
      padding: 6px 10px;
      margin: 0 4px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .edit {
      background-color: #28a745;
      color: white;
    }
    .delete {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>

<h1>Daftar Alat</h1>

<form method="POST" enctype="multipart/form-data">
  <label for="nama">Nama Alat</label>
  <input type="text" name="nama" id="nama" required>

  <label for="foto">Foto Alat</label>
  <input type="file" name="foto" id="foto" accept="image/*" required>

  <label for="nama">Status</label>
  <input type="text" name="nama" id="nama" required>

  <button type="submit" name="upload">Upload</button>
</form>

<table>
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Foto</th>
    <th>Status</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['nama']) ?></td>
    <td><img src="foto.php?id=<?= $row['id'] ?>" alt="Foto Alat" /></td>
    <td>
      <a href="edit.php?id=<?= $row['id'] ?>" class="btn edit">Edit</a>
      <a href="index.php?hapus=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Hapus alat ini?')">Hapus</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
