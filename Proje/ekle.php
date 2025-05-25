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
                <form action="/Proje/ekle.php" method="post" enctype="multipart/form-data">
                    <h4>Ektinlik Resmi : </h4>
                    <input type="file" name="resim">

                    <div class="input-ekle">
                    <input type="text" placeholder="Etkinlik Başlığı" name="başlık">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Etkinlik Konumu" name="konum">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Etkinlik Şehri" name="şehir">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Etkinlik Zamanı" name="zaman">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Saati" name="saat">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Etkinlik Türü" name="tür">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Etkinlik Kontejanı" name="kontenjan">
                    </div>

                    <div class="input-ekle">
                    <input type="text" placeholder="Etkinlik Fiyatı" name="fiyat">
                    </div> 

                    <button type="submit" class="btn">Etkinlik Ekle</button>

                </form>
            </div>
 
        </div>
    </body>
</html> 


<?php 

include("Baglanti.php");

if (isset($_POST["başlık"], $_POST["konum"], $_POST["şehir"], $_POST["zaman"], $_POST["saat"], $_POST["tür"], $_POST["kontenjan"], $_POST["fiyat"])){

$başlık = $_POST['başlık'];
$konum = $_POST['konum'];
$şehir = $_POST['şehir'];
$zaman = $_POST['zaman'];
$saat = $_POST['saat'];
$tür = $_POST['tür'];
$kontenjan = $_POST['kontenjan'];
$fiyat = $_POST['fiyat']; 

$resimAdi = '';

if (isset($_FILES['resim']) && $_FILES['resim']['error'] === 0) {
    $uploadDir = 'images/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $dosyaAdi = basename($_FILES['resim']['name']);
    $hedefYol = $uploadDir . $dosyaAdi;

    if (move_uploaded_file($_FILES['resim']['tmp_name'], $hedefYol)) {
        $resimAdi = $hedefYol;
    }
}

$etkinlik = [
    'başlık' => $başlık,
    'konum' => $konum,
    'şehir' => $şehir,
    'zaman' => $zaman,
    'saat' => $saat,
    'tür' => $tür,
    'kontenjan' => $kontenjan,
    'fiyat' => $fiyat,
    'resim' => $resimAdi
];

$jsonDosya='etkinlikler.json';
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