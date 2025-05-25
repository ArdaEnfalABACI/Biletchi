<link rel="stylesheet" type="text/css" href="Css/ProjeCSS.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?php
session_start();

$sepet = $_SESSION['sepet'] ?? [];

$etkinliklerDosya = "etkinlikler.json";
$etkinlikler = json_decode(file_get_contents($etkinliklerDosya), true);

// Etkinlikleri başlığa göre eşleştir
$etkinlikMap = [];
foreach ($etkinlikler as &$etkinlik) {
    $etkinlikMap[$etkinlik['başlık']] = &$etkinlik; // DİKKAT: referans (&) ile bağla
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($sepet as $item) {
        $baslik = $item['başlık'];
        $adet = (int)$item['adet'];

        if (isset($etkinlikMap[$baslik])) {
            // Mevcut kontenjanı kontrol et ve azalt
            $mevcutKontenjan = (int)$etkinlikMap[$baslik]['kontenjan'];
            $etkinlikMap[$baslik]['kontenjan'] = max(0, $mevcutKontenjan - $adet);
        }
    }

    // Güncellenmiş etkinlikleri dosyaya kaydet
    file_put_contents($etkinliklerDosya, json_encode($etkinlikler, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Sepeti temizle
    unset($_SESSION['sepet']);

    // Başarılı mesaj ve yönlendirme
    echo "<script>alert('Ödeme başarılı!'); window.location.href = '/Proje/index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ödeme Sayfası</title>
</head>
<body>

<div class="odeme-container">
    <h2>Sepetiniz</h2>

    <?php if (empty($sepet)): ?>
        <p>Sepetiniz boş.</p>
    <?php else: ?>
        <form method="post">
            <?php
            $toplam = 0;
            foreach ($sepet as $item):
                $ad = htmlspecialchars($item['başlık']);
                $adet = (int)$item['adet'];
                $fiyat = $item['fiyat'];
                $araToplam = $fiyat * $adet;
                $toplam += $araToplam;
            ?>
                <div class="urun">
                    <span><?= $ad ?> (x<?= $adet ?>)</span>
                    <span><?= $araToplam ?> ₺</span>
                </div>
            <?php endforeach; ?>

            <div class="toplam">Toplam: <?= $toplam ?> ₺</div>
            <button type="submit" class='sepet-button'>Ödeme Yap</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
