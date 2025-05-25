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

                <form action="/Proje/RegisterPage.php" method="post">
                    <h1>Kayıt Ol</h1>
                    <div class="input-box">
                        <input type="email" name="mail" placeholder="E-Mail" required>
                        <i class='bx bxl-gmail'></i>
                    </div>
    
                    <div class="input-box">
                        <input type="text" name="isim" placeholder="Adınız Soyadınız" required>
                        <i class='bx bx-user'></i>
                    </div>
    
                    <div class="input-box">
                        <input type="password" name="sifre" placeholder="Şifre" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
    
                    <button type="submit" class="btn">Kayıt Ol</button>


                    <div class="login-link">
                        <p>Biletchi hesabınız varsa giriş yapabilirsiniz.
                            <a href="/Proje/LoginPage.php">Giriş Yap</a>
                        </p>
    
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
include("Baglanti.php");

if(isset($_POST["mail"], $_POST["isim"], $_POST["sifre"])){

    $mail=$_POST["mail"];
    $adsoyad=$_POST["isim"];
    $sifre=$_POST["sifre"];

    
    $kontrol="select * from kayit where mail = '$mail'";
    $sonuc=mysqli_query($baglanti,$kontrol);

    if(mysqli_num_rows($sonuc)>0){
        echo "<script>
        alert('Bu Email Kullanımda')
        </script>";
    }
    else{
        $ekle="INSERT INTO kayit (mail, adsoyad, sifre) VALUES ('".$mail."', '".$adsoyad."', '".$sifre."')";

        if($baglanti->query($ekle)===TRUE){
            header("Location:/Proje/LoginPage.php");
   
        }
    }
}

?>
