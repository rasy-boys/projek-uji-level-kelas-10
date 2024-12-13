<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | RSTORE</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <style media="screen">
       body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-image: url('img/background2.jpg');
    background-repeat: no-repeat;
    background-size: cover; 
    background-position: center; 
}

        .container {
            display: flex;
            align-items: center;
            flex-direction: column; 
        }
        .lg {
            padding: 8px 15px;
            background-color: #C70039;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .box-login {
            text-align: center;
            max-width: 400px; 
        }
        .register-button {
  display: inline-block;
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-top: 10px; 
}

.register-button:hover {
  background-color: #45a049;
}

  

    </style>
</head>
<body id="bg-login">
    <div class="container">
        <h1>RSTORE</h1> 
        <div class="box-login">
            <h2>Login</h2>
            <form action="" method="POST">
                <input type="text" name="user" placeholder="Username" class="input-control">
                <input type="password" name="pass" placeholder="Password" class="input-control">
                <input type="submit" name="submit" value="Login" class="lg">
            </form>
            <?php
                session_start();
                include 'konek.php';

                if (isset($_POST['submit'])) {
                    $user = mysqli_real_escape_string($conn, $_POST['user']);
                    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

                   
                    $cek_user = mysqli_query($conn, "SELECT * FROM tbluser WHERE user_name='$user'");

                    if (mysqli_num_rows($cek_user) > 0) {
                        $data = mysqli_fetch_assoc($cek_user);
                        if (password_verify($pass, $data['password'])) {
                            $_SESSION['status_login'] = true;
                            $_SESSION['user_global'] = $data;
                            $_SESSION['id'] = $data['user_id'];
                           
                            header("Location: halaman.php");
                            exit();
                        } else {
                            echo '<script>alert("Username dan password salah!")</script>';
                        }
                    } else {
                        echo '<script>alert("Username tidak ditemukan!")</script>';
                    }
                }
            ?>
            <div class="register-button">
              <a href="register.php">Belum punya akun? Daftar disini</a>
            </div>
        </div>
    </div>
</body>
</html>
