<html>
    <head>
    <script src ="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="ProjeJS.js"></script>

    <link rel="stylesheet" type="text/css" href="Css/ProjeCSS.css">

    </head>
    <body style="background:url('images/photo-collage.png.png');
    background-position:center">  
        
        <div class="topbar">

            <div class="left">
                <i class="fa-solid fa-ticket"></i>
                <a href="/Proje/index.php">Biletchi </a>
                
            </div>
            <div class="right">
                <a href="/Proje/RegisterPage.php">Üye Ol</a>
                <a href="/Proje/LoginPage.php" >Üye Girişi</a>
            </div>
        </div>

        <div class="body-login">
            <div class="login">
                <form action="/Proje/LoginPage.php" method="post">
                    <h1>Giriş Yap</h1>
                    <div class="input-box">
                        <input type="email" placeholder="E-Mail" name="mail">
                        <i class='bx bxl-gmail'></i>
                    </div>
                    
                    <div class="input-box">
                        <input type="password" placeholder="Şifre" name="sifre">
                        <i class='bx bxs-lock-alt'></i>
                    </div>

                    <button type="submit" class="btn">Giriş Yap</button>

                    <div class="login-link">
                        <p>Biletchi hesabınız yoksa hemen kayıt olun.
                            <a href="/Proje/RegisterPage.php">Kayıt Ol</a>
                        </p>
    
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
session_start(); 
include("Baglanti.php");   

if(isset($_POST["mail"], $_POST["sifre"])) {

    $mail = $_POST["mail"];
    $sifre = $_POST["sifre"];

    if($mail == "admin@localhost" && $sifre == "12345") {
        header("Location:/Proje/AdminPage.php");
        exit;
    }

    $sql = "SELECT * FROM kayit WHERE mail='$mail' AND sifre='$sifre'";
    $sorgu = mysqli_query($baglanti, $sql);

    if(mysqli_num_rows($sorgu) > 0) {
        $veri = mysqli_fetch_assoc($sorgu);
        if ($veri['onay_durumu'] === "onaylandı") {
            $_SESSION['adsoyad'] = $veri['adsoyad'];
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Yönetici Onayı Bekleniyor.');</script>";
        }
    } else {
        echo "<script>alert('Bilgilerinizi kontrol ediniz.');</script>";
    }
}
?>
