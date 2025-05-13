<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Produk</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form input[type="text"],
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        form input[type="submit"] {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background: #218838;
        }

        img {
            max-height: 80px;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .preview {
            max-width: 100%;
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Upload Produk</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label>Nama Produk:</label>
        <input type="text" name="nama_produk" required>

        <label>Gambar Produk:</label>
        <input type="file" name="gambar_produk" id="gambarInput" accept="image/*" required>
        <img id="previewImg" class="preview" src="#" alt="Preview Gambar">

        <input type="submit" name="submit" value="Upload Produk">
    </form>

    <h2>Daftar Produk</h2>
    <table>
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM produk ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    $gambar_url = 'upload/' . htmlspecialchars($row['gambar_produk']);
            ?>
                <tr>
                    <td><img src="<?= $gambar_url ?>" alt="Produk"></td>
                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                </tr>
            <?php
                endwhile;
            else:
                echo '<tr><td colspan="2">Belum ada produk.</td></tr>';
            endif;
            ?>
        </tbody>
    </table>
</div>

<script>
    const input = document.getElementById('gambarInput');
    const preview = document.getElementById('previewImg');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            preview.style.display = 'block';
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });
</script>

</body>
</html>
