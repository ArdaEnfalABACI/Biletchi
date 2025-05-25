<html>
    <head>
    <script src ="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="ProjeJS.js"></script>

    <link rel="stylesheet" type="text/css" href="Css/ProjeCSS.css">
    </head>

    <body style="background-color: gainsboro;">
         <div class="admin-topbar">

            <div class="admin-topbar-left">
                <i class="fa-solid fa-ticket"></i>
                <a href="/Proje/AdminPage.php">Biletchi </a>
            </div>
            <div class="admin-topbar-mid">
                <a href="/Proje/EditPage.php">Etkinlik / Duyuru Düzenleme</a>
            </div>
            <div class="admin-topbar-right">
                <a href="/Proje/AdminPage.php">Üye Yönetimi</a>
            </div>
        </div>  

        <div class="body-ekle">
            <div class="ekle">
                <form action="/Proje/duyuruEkle.php" method="post" enctype="multipart/form-data">

                    <div class="input-ekle">
                    <input type="text" placeholder="Duyuru Başlığı" name="başlık">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Duyuru Tarihi" name="tarih">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Duyuru Şehri" name="şehir">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Duyuru Türü" name="tür">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Duyuru İçeriği" name="içerik">
                    </div>

                    <button type="submit" class="btn">Duyuru Ekle</button>

                </form>
            </div>
 
        </div>
    </body>
</html> 


<?php 

include("Baglanti.php");

if (isset($_POST["başlık"],$_POST["tarih"], $_POST["şehir"], $_POST["tür"] , $_POST["içerik"])){

$başlık = $_POST['başlık'];
$tarih=$_POST['tarih'];
$şehir = $_POST['şehir'];
$tür = $_POST['tür'];
$içerik = $_POST['içerik'];

$etkinlik = [
    'duyuruBaşlık' => $başlık,
    'duyuruTarih' => $tarih,
    'duyuruŞehir' => $şehir,
    'duyuruTür' => $tür,
    'duyuruİçerik' => $içerik
];

$jsonDosya='duyurular.json';
if (file_exists($jsonDosya)) {
    $veri = json_decode(file_get_contents($jsonDosya), true);
    if (!is_array($veri)) {
        $veri = [];
    }   
} else {
    $veri = [];
}
$veri[] = $etkinlik;

file_put_contents($jsonDosya, json_encode($veri, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header("Location:/Proje/EditPage.php");

}
?>  