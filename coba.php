<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="cobastyle.css">
</head>

<body>

    <?php
    session_start();

    $link = mysqli_connect('localhost', 'root', 'akUad@1ah', 'latihan');

    if (isset($_POST['simpan']) && $_SESSION['user'] == 'Administrator') {
        $id = $_POST['id_matkul'];
        $nama = $_POST['nama_matkul'];
        $sks = $_POST['jumlah_sks'];
        $dosen = $_POST['nama_dosen'];
        mysqli_query($link, "INSERT INTO matakuliah (id_matkul, nama_matkul, jumlah_sks, nama_dosen) VALUES ('$id','$nama', '$sks', '$dosen')");
        echo "<meta http-equiv='refresh' content='0; url=index.php?coba'>";
    } elseif (isset($_POST['edit']) && $_SESSION['user'] == 'Administrator') {
        $id = $_POST['id_matkul'];
        $nama = $_POST['nama_matkul'];
        $sks = $_POST['jumlah_sks'];
        $dosen = $_POST['nama_dosen'];
        mysqli_query($link, "UPDATE matakuliah SET nama_matkul='$nama', jumlah_sks='$sks', nama_dosen='$dosen' WHERE id_matkul='$id'");
        echo "<meta http-equiv='refresh' content='0; url=index.php?coba'>";
    } elseif (isset($_GET['edit']) && $_SESSION['user'] == 'Administrator') {
        $id = $_GET['kode'];
        $sql = "SELECT * FROM matakuliah WHERE id_matkul = '$id'";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_row($result);
        echo "<form action='' method='POST'>
            <table cellpadding='10'>
                <tr><td>ID MATKUL</td><td><input type='text' name='id_matkul' value='$data[0]'></td></tr>
                <tr><td>NAMA MATKUL</td><td><input type='text' name='nama_matkul' value='$data[1]'></td></tr>
                <tr><td>SKS</td><td><input type='text' name='jumlah_sks' value='$data[2]'></td></tr>
                <tr><td>DOSEN PENGAMPU</td><td><input type='text' name='nama_dosen' value='$data[3]'></td></tr>
                <tr><td></td><td><input type='submit' name='edit' value='Simpan'></td></tr>
            </table>
        </form><br>";
    } elseif (isset($_GET['delete']) && $_SESSION['user'] == 'Administrator') {
        $id = $_GET['kode'];
        mysqli_query($link, "DELETE FROM matakuliah WHERE id_matkul = '$id'");
        echo "<meta http-equiv='refresh' content='0; url=index.php?coba'>";
    } else {
        if ($_SESSION['user'] == 'Administrator') {
            // Tampilkan form input hanya untuk Administrator
            ?>
            <form action="" method="POST">
                <table cellpadding='10'>
                    <tr>
                        <td>ID MATKUL</td>
                        <td><input type="text" name="id_matkul"></td>
                    </tr>
                    <tr>
                        <td>NAMA MATKUL</td>
                        <td><input type="text" name="nama_matkul"></td>
                    </tr>
                    <tr>
                        <td>SKS</td>
                        <td><input type="text" name="jumlah_sks"></td>
                    </tr>
                    <tr>
                        <td>DOSEN PENGAMPU</td>
                        <td><input type="text" name="nama_dosen"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="simpan" value="Simpan"></td>
                    </tr>
                </table>
            </form><br>
            <?php
        }
    }

    $sql = "SELECT * FROM matakuliah ORDER BY id_matkul";
    echo "<table border='10' cellpadding='15'>
<tr bgcolor='#ccc'><td><b>ID MATKUL</b></td><td><b>NAMA MATKUL</b></td><td><b>SKS</b></td><td><b>DOSEN PENGAMPU</b></td>";
    if ($_SESSION['user'] == 'Administrator') {
        echo "<td><b>OPERASI</b></td></tr>";
    }
    if ($result = mysqli_query($link, $sql)) {
        while ($data = mysqli_fetch_row($result)) {
            echo "<tr>";
            echo "<td>$data[0]</td>"; 
            echo "<td>$data[1]</td>";
            echo "<td>$data[2]</td>";
            echo "<td>$data[3]</td>";
            if ($_SESSION['user'] == 'Administrator') {
                echo "<td>";
                echo "<a href='index.php?coba&edit&kode=$data[0]'><b>EDIT</b></a>";
                echo " ";
                echo "<a href='index.php?coba&delete&kode=$data[0]'><b>DELETE</b></a>";
                echo "</td>";
            }
        }
    }
    echo "</table>";
    ?>

</body>

</html>