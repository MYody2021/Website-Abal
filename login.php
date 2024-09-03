<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginstyle.css">
    <style>
        img.moving-img-bottom {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            animation: jalankiri 8s linear infinite;
        }

        @keyframes jalankiri {
            from {
                transform: translateX(1600%);
            }

            to {
                transform: translateX(-1600%);
            }
        }
    </style>
</head>

<?php
session_start();

if (isset($_POST['login'])) {
    $usr = trim($_POST['user']);
    $pas = trim($_POST['pass']);

    if ($usr == '' or $pas == '') {
        $errorMessage = "Data Tidak Boleh Kosong";
    } else if ($usr == 'admin' and $pas == 'admin') {
        $_SESSION['user'] = "Administrator";

        echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
    } else {
        $sql = "SELECT count(*) FROM mahasiswa WHERE nim='$usr' AND nama_mahasiswa='$pas'";
        $data = mysqli_fetch_row(mysqli_query($link, $sql));
        if ($data[0] != 0) {
            $_SESSION['user'] = $pas;
            echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
        } else {
            $errorMessage = "Username dan Password Salah";
        }
    }
}
?>

<body>
    <table border='0'>
        <tr>
            <td class="centered" colspan="2">
                <section>
                    <form class='loginform' method='POST' action=''>
                        <div class="apanih">
                            <h2><img src="133.gif" width="30px" height="20px"> LOGIN <img src="133.gif" width="30px"
                                    height="20px"></h2>
                        </div>
                        <div class="running-text-container">
                            <div class="running-text">
                                Minimal login coy...
                            </div>
                        </div>
                        <div class="moving-container-tank">
                            <div class="moving-container">
                                <img class="moving-img" src="tank11.gif" alt="Tank" width="100px">
                                <img class="moving-img" src="peluru111.gif" width="100px">
                            </div>
                        </div>

                        <input type="text" name="user" placeholder="Username">
                        <input type="password" name="pass" placeholder="Password">
                        <input type="submit" name='login' value='LOGIN'>
                        <?php if (isset($errorMessage)): ?>
                            <p class="error-message">
                                <?php echo $errorMessage; ?>
                            </p>
                        <?php endif; ?>
                    </form>
                </section>
            </td>
        </tr>
    </table>
    <img class="moving-img-bottom" src="duck.gif" alt="Tank" width="50px">
</body>

</html>