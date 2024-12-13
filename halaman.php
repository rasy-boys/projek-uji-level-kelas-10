<?php
    include 'konek.php';
    $kontak = mysqli_query($conn, "SELECT  admin_address, admin_telp, admin_email  FROM tbladmin WHERE admin_id= 5" );
    $a = mysqli_fetch_object($kontak);

    // Ambil ID kategori dari parameter URL
    $category_id = isset($_GET['id']) ? $_GET['id'] : null;

    // Ubah kueri produk untuk memperhitungkan kategori yang dipilih
    $product_query = "SELECT * FROM tblproduct WHERE product_status=1";
    if ($category_id) {
        $product_query .= " AND product_category_id = $category_id";
    }
    $product_query .= " ORDER BY product_id DESC LIMIT 8";
    $product = mysqli_query($conn, $product_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSTORE</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
   
    <style media="screen">
        /* CSS yang ada di sini */
        <style media="screen">
        a {
            color: inherit;
            text-decoration: none;
        }
        header {
            background-color: #C70039;
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
            margin: 0 auto;
        }
        .container:after {
            content: '';
            display: block;
            clear: both;
        }
        .section {
            padding: 25px 0;
        }

        footer {
            padding: 25px 0;
            background-color: #333;
            color: #fff;
            text-align: center;
        }

        .footer p {
            margin-bottom: 10px;
        }

        .footer small{
            margin-top: 25px;
            display: inline-block;
        }

        .box {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            box-sizing: border-box;
            margin: 10px 0 25px 0;
        }

        .box:after{
            content:'';
            display: block;
            clear: both;
            justify-content: space-between; 
        }
     
        .search {
            padding: 15px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            text-align: center;
        }

        .search input[type=text]{
            width: 60%;
            padding: 10px;
        }

        .search input[type=button]{
            padding: 12px 15px;
            background-color: #C70039 ;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .col-5{
            width: 20%;
            height: 100px;
            text-align: center;
            float: left;
            padding: 10px;
            box-sizing: border-box;
            border: none; 
        }

        .col-4{
            width: 25%;
            height: 320px;
            border: 1px solid #ccc;
            float: left;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
            display: flex; 
            flex-direction: column;
        }

        .col-4 img{
            width: 100%;
        }

        .col-4 .nama{
            color: #666;
            margin-bottom: 6px;
        }

        .col-4 .harga{
            font-weight: bold;
            float: right;
            display: flex; 
            justify-content: space-between; 
            color: #C70039 ;
        }

        .col-4 .hover{
            box-shadow: #0056b3;

          
        }

        
   @media screen and (max-width: 768px){
        .container {
            width: 90%;
        }
        .col-5{
            width: 50%;
            margin-bottom: 10px;
        }
        .col-4{
            width: 50%;

   }
}
    </style>
</head>
<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="halaman.php">RSTORE</a></h1>
            <ul>
                <li><a href="produk.php">PRODUK</a></li>
                <li><a href="profil-user.php">PROFIL</a></li>
            
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </header>

    <!-- search form -->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search"  placeholder="Cari produk..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <input type="submit" name="submit" value="cari produk" class="lg">
            </form>
        </div>
    </div>

    <!-- Category -->
    <div class="section">
        <div class="container">
            <h3>Kategori</h3>
            <div class="box">
                <?php
                    $kategori = mysqli_query($conn, "SELECT * FROM tblcategory ORDER BY category_id DESC");
                    if (mysqli_num_rows($kategori) > 0) {
                        while ($row = mysqli_fetch_array($kategori)) {
                ?>
                <a href="produk.php?id=<?php echo $row['category_id'] ?>">
                    <div class="col-5">
                        <img src="../store/img/<?php echo $row['category_image']?>" width="50px" style="margin-bottom:5px;">
                        <p class="nama"> <?php echo substr($row['category_name'], 0, 30)?></p>
                    </div>
                </a>
                <?php }}else{ ?>
                <p>Kategori tidak ada</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Produk -->
    <div class="section">
        <div class="container">
            <h3>Produk terbaru</h3>
            <div class="box">
                <?php
                    if(mysqli_num_rows($product) > 0){
                        while ($row = mysqli_fetch_array($product)){
                ?>
                <a href="detail-produk.php?id=<?php echo $row['product_id'] ?>">
                    <div class="col-4">
                        <img src="../store/produk/<?php echo $row['product_image']?>" >
                        <p class="nama"> <?php echo substr($row['product_name'],0,30)?></p>
                        <p class="harga">Rp. <?php echo number_format($row['product_price'])?></p>
                    </div>
                </a>
                <?php }}else{ ?>
                <p>Produk tidak ada</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer">
            <div class="container">
                <h4> Alamat </h4>
                <p><?php echo $a->admin_address ?> </p>

                <h4> No telpon </h4>
                <p> <?php echo $a->admin_telp ?></p>

                <h4> Email </h4>
                <p> <?php echo $a->admin_email ?></p>
                <small>Copyright &copy; 2024 - RSTORE.</small>
            </div>
        </div>
    </footer>


</body>
</html>
