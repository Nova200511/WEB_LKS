<?php include 'db.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM absen WHERE id=$id")->fetch_assoc();

if (isset($_POST['update'])) {
  $nama = $_POST['nama'];
  $tanggal = $_POST['tanggal'];
  $keterangan = $_POST['keterangan'];
  $conn->query("UPDATE absen SET nama='$nama', tanggal='$tanggal', keterangan='$keterangan' WHERE id=$id");
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Absen</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Edit Data Absen</h2>
  <form method="POST">
    <input type="text" name="nama" value="<?= $data['nama'] ?>" required><br>
    <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required><br>
    <select name="keterangan" required>
      <option <?= $data['keterangan'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
      <option <?= $data['keterangan'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
      <option <?= $data['keterangan'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
      <option <?= $data['keterangan'] == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
    </select><br>
    <button type="submit" name="update">Update</button>
  </form>
  <a href="index.php">← Kembali</a>
</div>
</body>
</html>
