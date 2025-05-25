<html>
    <head>
    <script src ="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="ProjeJS.js"></script>

    <link rel="stylesheet" type="text/css" href="Css/ProjeCSS.css">
    </head>

    <body style="background-color: gainsboro;">
         <div class="admin-topbar">

            <div class="admin-topbar-left">
                <i class="fa-solid fa-ticket" ></i>
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
        $jsonDosya = "etkinlikler.json";
        $etkinlikler = json_decode(file_get_contents($jsonDosya), true);

        if (isset($_GET['başlık'])) {
            $arananBaşlık = $_GET['başlık'];
            $etkinlik = null;

            foreach ($etkinlikler as $e) {
                if ($e['başlık'] === $arananBaşlık) {
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
                if ($e['başlık'] === $eskiBaşlık) {
                    $e['başlık'] = $_POST['başlık'];
                    $e['konum'] = $_POST['konum'];
                    $e['şehir'] = $_POST['şehir'];
                    $e['zaman'] = $_POST['zaman'];
                    $e['saat'] = $_POST['saat'];
                    $e['tür'] = $_POST['tür'];
                    $e['kontenjan'] = $_POST['kontenjan'];
                    $e['fiyat'] = $_POST['fiyat'];
                    $e['resim'] = $_POST['resim'];
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
                    <input type="hidden" name="eski_başlık" value="<?= htmlspecialchars($etkinlik['başlık']) ?>">

                    <h4>Etkinlik Resmi :</h4>
                    <select name="resim">
                        <?php
                        $resimKlasoru = "images/";
                        $dosyalar = array_diff(scandir($resimKlasoru), ['.', '..']);
                        foreach ($dosyalar as $dosya) {
                            $dosyaYolu = $resimKlasoru . $dosya;
                            $secili = ($etkinlik['resim'] === $dosyaYolu) ? 'selected' : '';
                            echo "<option value='$dosyaYolu' $secili>$dosya</option>";
                        }
                        ?>
                    </select>

                    <div class="input-ekle">
                        <input type="text" name="başlık" placeholder="Etkinlik Başlığı" value="<?= htmlspecialchars($etkinlik['başlık']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="konum" placeholder="Etkinlik Konumu" value="<?= htmlspecialchars($etkinlik['konum']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="şehir" placeholder="Etkinlik Şehri" value="<?= htmlspecialchars($etkinlik['şehir']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="zaman" placeholder="Etkinlik Zamanı" value="<?= htmlspecialchars($etkinlik['zaman']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="saat" placeholder="Etkinlik Saati" value="<?= htmlspecialchars($etkinlik['saat']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="tür" placeholder="Etkinlik Türü" value="<?= htmlspecialchars($etkinlik['tür']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="kontenjan" placeholder="Etkinlik Kontejanı" value="<?= htmlspecialchars($etkinlik['kontenjan']) ?>">
                    </div>

                    <div class="input-ekle">
                        <input type="text" name="fiyat" placeholder="Etkinlik Fiyatı" value="<?= htmlspecialchars($etkinlik['fiyat']) ?>">
                    </div>

                    <button type="submit" class="btn">Etkinliği Güncelle</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html> 

