<html>

<body>

<head>
    <link rel="stylesheet" href="mhsstyle.css">
</head>

<?php
$link = mysqli_connect('localhost', 'root', 'akUad@1ah', 'latihan');

if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama_mahasiswa'];
    $kelamin = $_POST['jenis_kelamin'];
    $nohp = $_POST['no_hp'];
    $profil = $_FILES['foto_profil']['name'];
    $profil_tmp = $_FILES['foto_profil']['tmp_name'];

    move_uploaded_file($profil_tmp, "photo/" . $profil);

    mysqli_query($link, "INSERT INTO mahasiswa (nim, nama_mahasiswa, jenis_kelamin, no_hp, foto_profil) VALUES ('$nim','$nama','$kelamin','$nohp','$profil')");
    echo "<meta http-equiv='refresh' content='0; url=index.php?mahasiswa''>";
} else if (isset($_POST['edit'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama_mahasiswa'];
    $kelamin = $_POST['jenis_kelamin'];
    $nohp = $_POST['no_hp'];
    $profil = $_FILES['foto_profil']['name'];
    $profil_tmp = $_FILES['foto_profil']['tmp_name'];

    move_uploaded_file($profil_tmp, "photo/" . $profil);

    mysqli_query($link, "UPDATE mahasiswa SET nama_mahasiswa='$nama', jenis_kelamin='$kelamin', no_hp='$nohp', foto_profil='$profil' WHERE nim='$nim'");
    echo "<meta http-equiv='refresh' content='0; url=index.php?mahasiswa''>";
} else if (isset($_GET['edit'])) {
    $nim = $_GET['kode'];
    $sql = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $data = mysqli_fetch_row(mysqli_query($link, $sql));
    echo "<form enctype='multipart/form-data' action='' method='POST'>
        <table cellpadding='10'>
            <tr><td>NIM</td><td><input type='text' name='nim' value='$data[0]'></td></tr>
            <tr><td>NAMA</td><td><input type='text' name='nama_mahasiswa' value='$data[1]'></td></tr>
            <tr><td>JENIS KELAMIN</td><td>
                    <input type='radio' name='jenis_kelamin' value='Laki-laki' " . ($data[2] == 'Laki-laki' ? 'checked' : '') . "> Laki-laki
                    <input type='radio' name='jenis_kelamin' value='Perempuan' " . ($data[2] == 'Perempuan' ? 'checked' : '') . "> Perempuan
                </td></tr>
            <tr><td>NOMOR TELEPON</td><td><input type='text' name='no_hp' value='$data[3]'></td></tr>
            <tr><td>FOTO PROFIL</td><td><input type='file' name='foto_profil' value='$data[4]'></td></tr>
            <tr><td></td><td><input type='submit' name='edit' value='Simpan'></td></tr>
        </table>
    </form><br>";
} else if (isset($_GET['delete'])) {
    $nim = $_GET['kode'];
    mysqli_query($link, "DELETE FROM mahasiswa WHERE nim = '$nim'");
    echo "<meta http-equiv='refresh' content='0; url=index.php?mahasiswa''>";
} else {
    ?>
    <form enctype='multipart/form-data' action="" method="POST">
        <table cellpadding='10' border='0'>
            <tr>
                <td>NIM</td>
                <td><input type="text" name="nim"></td>
            </tr>
            <tr>
                <td>NAMA</td>
                <td><input type="text" name="nama_mahasiswa"></td>
            </tr>
            <tr>
                <td>JENIS KELAMIN</td>
                <td>
                    <input type='radio' name='jenis_kelamin' value='Laki-laki'> Laki-laki
                    <input type='radio' name='jenis_kelamin' value='Perempuan'> Perempuan
                </td>
            </tr>
            <tr>
                <td>NOMOR TELEPON</td>
                <td><input type="text" name="no_hp"></td>
            </tr>
            <tr>
                <td>FOTO PROFIL</td>
                <td><input type="file" name="foto_profil"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="simpan" value="Simpan"></td>
            </tr>
        </table>
    </form><br>
<?php }

$sql = "SELECT * FROM mahasiswa order by NIM";
echo "
<table align='center' border='10' cellpadding='15'>
<tr bgcolor='#ccc' weight='20px'><td><b>NIM</b></td><td><b>NAMA</b></td><td><b>JENIS KELAMIN</b></td><td><b>NOMOR TELEPON</b></td><td><b>FOTO PROFIL</b></td><td><b>OPERASI</b></td></tr>";
if ($result = mysqli_query($link, $sql)) {
    while ($data = mysqli_fetch_row($result)) {
        if ($_SESSION['user'] == 'Administrator') {
            echo "<tr align='center'>";
            echo "<td>$data[0]</td>";
            echo "<td>$data[1]</td>";
            echo "<td>$data[2]</td>";
            echo "<td>$data[3]</td>";
            echo "<td align='center'><img src='photo/$data[4]' alt='Foto Profil' style='width: 100px; height: 100px;'></td>";
            echo "<td>";
            echo "<a href='index.php?mahasiswa&edit&kode=$data[0]'>Edit</a>";
            echo " ";
            echo "<a href='index.php?mahasiswa&delete&kode=$data[0]'>Delete</a>";
            echo "</td>";
        } else if ($data[0] == $_SESSION['user']) {
            echo "<tr align='center'>";
            echo "<td>$data[0]</td>";
            echo "<td>$data[1]</td>";
            echo "<td>$data[2]</td>";
            echo "<td>$data[3]</td>";
            echo "<td align='center'><img src='photo/$data[4]' alt='Foto Profil' style='width: 100px; height: 100px;'></td>";
            echo "<td>";
            echo "<a href='index.php?mahasiswa&edit&kode=$data[0]'>Edit</a>";
        } else {
            echo "<tr align='center'>";
            echo "<td>$data[0]</td>";
            echo "<td>$data[1]</td>";
            echo "<td>$data[2]</td>";
            echo "<td>$data[3]</td>";
            echo "<td align='center'><img src='photo/$data[4]' alt='Foto Profil' style='width: 100px; height: 100px;'></td>";
        }
    }
}
echo "</table>";
?>
</body>

</html>
