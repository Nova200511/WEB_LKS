<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Absen</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Tambah Data Absen</h2>
    <form method="POST">
      <input type="text" name="nama" placeholder="Nama" required><br>
      <input type="date" name="tanggal" required><br>
      <select name="keterangan" required>
        <option value="">-- Pilih Keterangan --</option>
        <option>Hadir</option>
        <option>Izin</option>
        <option>Sakit</option>
        <option>Alpha</option>
      </select><br>
      <button type="submit" name="simpan">Simpan</button>
    </form>
    <a href="index.php">← Kembali</a>
  </div>
</body>
</html>

<?php
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $tanggal = $_POST['tanggal'];
  $keterangan = $_POST['keterangan'];
  $conn->query("INSERT INTO absen (nama, tanggal, keterangan) VALUES ('$nama', '$tanggal', '$keterangan')");
  header("Location: index.php");
}
?>
