<?php session_start();
$link = mysqli_connect('localhost', 'root', 'akUad@1ah', 'latihan'); ?>
<html>

<head>
    <link rel="stylesheet" href="indexstyle.css">
</head>

<body>

    <?php
    if (isset($_GET['logout'])) {
        unset($_SESSION['user']);
        echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
    } else if (isset($_SESSION['user'])) {
        echo "<div id='welcome-message'>Selamat Datang, " . $_SESSION['user'] . "<img src='face2.gif' width='25px' height='25px' alt='face'></div>";
        echo "<br><br>     
                <div class='menu-links' align='center'>
                    <div class='menu-box'><a href='index.php'>Home</a></div>
                    <div class='menu-box'><a href='index.php?mahasiswa'>Data Mahasiswa</a></div>
                    <div class='menu-box'><a href='index.php?logout'>Logout</a></div>
                </div><br><br>";
        if (isset($_GET['mahasiswa'])) {
            include "mahasiswa.php";
        } else {
            include "coba.php";
        }
    } else {
        include "login.php";
    }
    ?>
</body>

</html>