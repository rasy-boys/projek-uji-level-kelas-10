<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'konek.php';
if($_SESSION['status_login'] != true){
    echo '<script>window.location="index.php"</script>';
}

$query = mysqli_query($conn, "SELECT * FROM tbluser WHERE user_id ='".$_SESSION['id']."' ");
$d = mysqli_fetch_object($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> RSTORE</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <style media ="screen">
        a {
            color: inherit;
            text-decoration: none;
        }
        header {
            background-color: #C70039 ;
            color: #fff;
        }
        header h1 {
            float: left;
            padding: 10px 0;
        }
        header ul {
            float: right;
        }
        header ul li {
            display: inline-block;
            padding: 20px 0 20px 15px;
        }
        .container {
            width: 80%;
            margin:  0 auto;
        }
        .container:after {
            content: '';
            display: block;
            clear: both;
        }
        .section {
            padding: 25px 0;
        }
        .box {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            box-sizing: border-box;
            margin: 10px 0 25px 0;
        }
        .lg {
            padding: 8px 15px;
            background-color: #C70039 ;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="halaman.php">RSTORE</a></h1>
            <ul>
                
                <li><a href="profil-user.php">PROFIL</a></li>
                <li><a href="halaman.php">BACK</a></li>
               
            </ul>
        </div>
    </header>

    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>PROFIL</h3>
            <div class="box">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?php echo isset($d->namalengkap) ? $d->namalengkap : ''; ?>" required>
                    <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo isset($d->user_name) ? $d->user_name : ''; ?>" required>
                    <input type="text" name="hp" placeholder="No Hp" class="input-control" value="<?php echo isset($d->user_telp) ? $d->user_telp : ''; ?>" required>
                    <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo isset($d->user_email) ? $d->user_email : ''; ?>" required>
                    <input type="text" name="alamat" placeholder="Alamat" class="input-control" value="<?php echo isset($d->user_address) ? $d->user_address : ''; ?>" required>
                    <input type="submit" name="submit" value="ubah profil" class="lg">
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                    $nama = ucwords($_POST["nama"]);
                    $user = $_POST["user"];
                    $hp = $_POST["hp"];
                    $email = $_POST["email"];
                    $alamat = ucwords($_POST["alamat"]);

                    $update = mysqli_query($conn, "UPDATE tbluser SET 
                                    user_name = '$user', 
                                    namalengkap = '$nama', 
                                    user_telp = '$hp', 
                                    user_email = '$email', 
                                    user_address = '$alamat' 
                                    WHERE user_id = '".$_SESSION['id']."' ");

                    if ($update) {
                        echo "<script>alert('Profil berhasil diubah');</script>";
                        echo "<script>window.location='profil-user.php'</script>";
                    } else {
                        echo "<script>alert('Profil gagal diubah');</script>";
                        echo "<script>window.location='profil-user.php'</script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <h3>Ubah Password</h3>
            <div class="box">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="password" name="pass1" placeholder="Password Baru" class="input-control" required >
                    <input type="password" name="pass2" placeholder="Konfirmasi Password Baru" class="input-control" required>
                    <input type="submit" name="ubah_password" value="ubah password" class="lg">
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ubah_password"])) {
                    $pass1 = $_POST["pass1"];
                    $pass2 = $_POST["pass2"];

                    if ($pass1 != $pass2) {
                        echo "<script>alert('Konfirmasi password baru tidak sesuai');</script>";
                    } else {
                        
                        $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);

                        
                        $u_pass = mysqli_query($conn, "UPDATE tbluser SET 
                                        password = '$hashed_password'
                                        WHERE user_id = '".$_SESSION['id']."' ");

                        if ($u_pass) {
                            echo "<script>alert('Password berhasil diubah');</script>";
                            echo "<script>window.location='profil-user.php'</script>";
                        } else {
                            echo "<script>alert('Password gagal diubah');</script>";
                            echo "<script>window.location='profil-user.php'</script>"; 
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2024 - RSTORE.</small>
        </div>
    </footer>
</body>
</html>
