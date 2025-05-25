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
                <a href="/Proje/EditPage.php">Biletchi </a>
            </div>
            <div class="admin-topbar-mid">
                <a href="/Proje/EditPage.php">Etkinlik / Duyuru Düzenleme</a>
            </div>
            <div class="admin-topbar-right">
                <a href="/Proje/AdminPage.php">Üye Yönetimi</a>
            </div>
        </div>  

        <?php
        $jsonDosya = "duyurular.json";
        $etkinlikler = json_decode(file_get_contents($jsonDosya), true);

        if (isset($_GET['duyuruBaşlık'])) {
            $arananBaşlık = $_GET['duyuruBaşlık'];
            $etkinlik = null;

            foreach ($etkinlikler as $e) {
                if ($e['duyuruBaşlık'] === $arananBaşlık) {
                    $etkinlik = $e;
                    break;
                }
            }

            if (!$etkinlik) {
                echo "Etkinlik bulunamadı.";
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eskiBaşlık = $_POST['eski_başlık'];

            foreach ($etkinlikler as &$e) {
                if ($e['duyuruBaşlık'] === $eskiBaşlık) {
                    $e['duyuruBaşlık'] = $_POST['başlık'];
                    $e['duyuruTarih'] = $_POST['tarih'];
                    $e['duyuruŞehir'] = $_POST['şehir'];
                    $e['duyuruTür'] = $_POST['tür'];
                    $e['duyuruİçerik'] = $_POST['içerik'];
                    break;
                }
            }

            file_put_contents($jsonDosya, json_encode($etkinlikler, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            
            header("Location:/Proje/EditPage.php");
        }
        ?>

        <div class="body-ekle">
            <div class="ekle">
                <?php if (isset($etkinlik)): ?>
                <form method="post">
                    <input type="hidden" name="eski_başlık" value="<?= htmlspecialchars($etkinlik['duyuruBaşlık']) ?>">

                    <div class="input-ekle">
                        <input type="text" name="başlık" placeholder="Duyuru Başlığı" value="<?= htmlspecialchars($etkinlik['duyuruBaşlık']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="tarih" placeholder="Duyuru Tarihi" value="<?= htmlspecialchars($etkinlik['duyuruTarih']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="şehir" placeholder="Duyuru Şehri" value="<?= htmlspecialchars($etkinlik['duyuruŞehir']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="tür" placeholder="Duyuru Türü" value="<?= htmlspecialchars($etkinlik['duyuruTür']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="içerik" placeholder="Duyuru İçeriği" value="<?= htmlspecialchars($etkinlik['duyuruİçerik']) ?>">
                    </div>

                    <button type="submit" class="btn">Duyuru Güncelle</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html> 

