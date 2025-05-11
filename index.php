<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Data Absensi</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Data Absensi</h2>
    <a href="tambah.php" class="btn">+ Tambah Absen</a>
    <table>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Aksi</th>
      </tr>
      <?php
      $result = $conn->query("SELECT * FROM absen");
      $no = 1;
      while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>$no</td>
                <td>{$row['nama']}</td>
                <td>{$row['tanggal']}</td>
                <td>{$row['keterangan']}</td>
                <td>
                  <a href='edit.php?id={$row['id']}'>Edit</a> |
                  <a href='hapus.php?id={$row['id']}' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                </td>
              </tr>";
        $no++;
      }
      ?>
    </table>
  </div>
</body>
</html>
