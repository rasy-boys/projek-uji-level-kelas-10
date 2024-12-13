<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | RSTORE</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style media="screen">
    .container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  flex-direction: column;
}

.box-login {
  width: 300px; 
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
</style>
</head>
<body>
    <div class="container">
        <h1>RSTORE</h1>
        <div class="box-login">
            <h2>Registrasi</h2>
            <form action="" method="POST">
                <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control">
                <input type="text" name="username" placeholder="Username" class="input-control">
                <input type="password" name="password" placeholder="Password" class="input-control">
                <input type="text" name="hp" placeholder="No Hp" class="input-control" >
                <input type="email" name="email" placeholder="Email" class="input-control">
                <input type="text" name="alamat" placeholder="Alamat" class="input-control">
                <input type="submit" name="register" value="Register" class="lg">
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['register'])){
        session_start();
        include 'konek.php'; // Hubungkan ke file yang berisi koneksi database

        // Ambil data dari formulir registrasi
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $hp = mysqli_real_escape_string($conn, $_POST['hp']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

        
        $cek_username = mysqli_query($conn, "SELECT * FROM tbluser WHERE user_name='$username'");

        if (mysqli_num_rows($cek_username) > 0) {
            echo '<script>alert("Username sudah digunakan!")</script>';
        } else {
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            $insert_user = mysqli_query($conn, "INSERT INTO tbluser (namalengkap, user_name, password, user_telp, user_email, user_address) VALUES ('$nama', '$username', '$hashed_password', '$hp', '$email', '$alamat')");

            if ($insert_user) {
                echo "<script>alert('Registrasi berhasil ');</script>";
                echo '<script>window.location="index.php"</script>';
            } else {
                echo '<script>alert("Registrasi gagal!")</script>';
            }
        }
    }
    ?>
</body>
</html>
