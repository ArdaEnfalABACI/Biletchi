<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Biletchi</title>
    <link rel="stylesheet" type="text/css" href="Css/ProjeCSS.css">
</head>
<body style="background-color: gainsboro;">

<div class="topbar">

    <div class="left">
        <i class="fa-solid fa-ticket"></i>
        <a href="/Proje/index.php">Biletchi</a>
    </div>

    <div class="right">
        <?php if (isset($_SESSION['adsoyad'])): ?>
            <span>Hoşgeldin <?= htmlspecialchars($_SESSION['adsoyad']) ?></span>
            <a href="javascript:void(0);" class="sepet-toggle"><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="/Proje/logout.php">Çıkış</a>
        <?php else: ?>
            <a href="/Proje/RegisterPage.php">Üye Ol</a>
            <a href="/Proje/LoginPage.php">Üye Girişi</a>
        <?php endif; ?>
    </div>
</div>

    <div class="header">
        <div class="slider">
            <img src="./images/img1.jpg">
        </div>
        <div class="slide-button">
            <i class="fa-solid fa-arrow-left fa-2x" onclick="back()"></i>
            <i class="fa-solid fa-arrow-right fa-2x" onclick="next()"></i> 
        </div>
        <h1>Eğlencenin Parçası Ol!</h1>
    </div>

    <?php

    $apiKey = 'e2e696c34417b931cfbd3ca2b7bae91e';

    function getCoordinates($city, $apiKey) {
    $url = "https://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($city) . "&limit=1&appid=" . $apiKey;
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    return isset($data[0]) ? [$data[0]['lat'], $data[0]['lon']] : [null, null];
    }

    function getWeatherForecastAverage($lat, $lon, $targetTimestamp, $apiKey) {
        $url = "https://api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$lon&appid=$apiKey&units=metric&lang=tr";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (!isset($data['list'])) return null;

        $targetDate = date('Y-m-d', $targetTimestamp);
        $temps = [];
        $description = null;

        foreach ($data['list'] as $forecast) {
            $forecastDate = substr($forecast['dt_txt'], 0, 10);
            if ($forecastDate === $targetDate) {
                $temps[] = $forecast['main']['temp'];
                if (!$description) {
                    $description = $forecast['weather'][0]['description'];
                }
            }
        }

    if (count($temps) > 0) {
        $avgTemp = array_sum($temps) / count($temps);
        return $description . ', ' . round($avgTemp) . '°C ort.';
    }

    return null;
}



    $json = file_get_contents('etkinlikler.json');
    $etkinlikler = json_decode($json, true);

    $tumTurler = array_unique(array_column($etkinlikler, 'tür'));
    sort($tumTurler);

    $tümŞehirler = array_unique(array_column($etkinlikler,'şehir'));
    sort($tümŞehirler);

    $seciliTur = $_GET['tur'] ?? null;
    $seciliSiralama = $_GET['sirala'] ?? null;
    $seciliŞehir = $_GET['sehir'] ?? null;


    if ($seciliTur) {
        $etkinlikler = array_filter($etkinlikler, function ($etkinlik) use ($seciliTur) {
            return $etkinlik['tür'] === $seciliTur;
        });
    }
    if ($seciliŞehir) {
        $etkinlikler = array_filter($etkinlikler, function ($etkinlik) use ($seciliŞehir) {
            return $etkinlik['şehir'] === $seciliŞehir;
        });
    }

    function duzeltTarih($tarih) {
        $aylar = [
            'Ocak' => 'January', 'Şubat' => 'February', 'Mart' => 'March',
            'Nisan' => 'April', 'Mayıs' => 'May', 'Haziran' => 'June',
            'Temmuz' => 'July', 'Ağustos' => 'August', 'Eylül' => 'September',
            'Ekim' => 'October', 'Kasım' => 'November', 'Aralık' => 'December'
        ];

        if (strpos($tarih, '/') !== false) return strtotime($tarih);

        foreach ($aylar as $tr => $en) {
        $tarih = str_replace($tr, $en, $tarih);
        }
        return strtotime($tarih);
    }
    if ($seciliSiralama) {
        usort($etkinlikler, function ($a, $b) use ($seciliSiralama) {
            if ($seciliSiralama == 'tarih') {
                return duzeltTarih($a['zaman']) - duzeltTarih($b['zaman']);
            } elseif ($seciliSiralama == 'fiyat') {
                return $a['fiyat'] - $b['fiyat'];
            } elseif ($seciliSiralama == 'kontenjan') {
                return $a['kontenjan'] - $b['kontenjan'];
            }
            return 0;
        });
    }

    $duyuruJson = file_get_contents('duyurular.json');
    $duyuruListesi = json_decode($duyuruJson, true);

    if ($seciliŞehir) {
        $duyuruListesi = array_filter($duyuruListesi, function ($duyuru) use ($seciliŞehir) {
            return $duyuru['duyuruŞehir'] === $seciliŞehir;
        });
    }

    if ($seciliTur) {
        $duyuruListesi = array_filter($duyuruListesi, function ($duyuru) use ($seciliTur) {
            return $duyuru['duyuruTür'] === $seciliTur;
        });
    }

    usort($duyuruListesi, function ($a, $b) {
        return duzeltTarih($a['duyuruTarih']) - duzeltTarih($b['duyuruTarih']);
    });

    ?>

    <section class="events">
        <h1 class="heading">Etkinlikler</h1>

        <div class="menü">
            <form class="menü-form" method="get">
                <label class="tür-menü">
                    <select name="tur" onchange="this.form.submit()">
                        <option value="">Tüm Türler</option>
                        <?php foreach ($tumTurler as $tur): ?>
                            <option value="<?= htmlspecialchars($tur) ?>" <?= $seciliTur === $tur ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tur) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="sıralama-menü">
                    <select name="sirala" onchange="this.form.submit()">
                        <option value="">Sıralama</option>
                        <option value="tarih" <?= $seciliSiralama == 'tarih' ? 'selected' : '' ?>>Tarihe Göre</option>
                        <option value="fiyat" <?= $seciliSiralama == 'fiyat' ? 'selected' : '' ?>>Fiyata Göre</option>
                        <option value="kontenjan" <?= $seciliSiralama == 'kontenjan' ? 'selected' : '' ?>>Kontenjana Göre</option>
                    </select>
                </label>

                <label class="şehir-menü">
                    <select name="sehir" onchange="this.form.submit()">
                        <option value="">Tüm Şehirler</option>
                        <?php foreach ($tümŞehirler as $şehir): ?>
                            <option value="<?= htmlspecialchars($şehir) ?>" <?= $seciliŞehir === $şehir ? 'selected' : '' ?>>
                                <?= htmlspecialchars($şehir) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </form>
        </div>

        <div class="event-box-container">
            <?php
                foreach ($etkinlikler as $etkinlik) {
                $tarihTimestamp = duzeltTarih($etkinlik['zaman']);
                list($lat, $lon) = getCoordinates($etkinlik['şehir'], $apiKey);

                $havaDurumu = '';
                if ($lat && $lon && $tarihTimestamp && $tarihTimestamp > time()) {
                    $weatherData = getWeatherForecastAverage($lat, $lon, $tarihTimestamp, $apiKey);
                    if ($weatherData) {
                        $havaDurumu = $weatherData;
                    }
                }


                echo '<div class="event-box">';
                echo    '<p class="event-name">' . htmlspecialchars($etkinlik["başlık"]) . '</p>';
                echo    '<img src="' . htmlspecialchars($etkinlik["resim"]) . '" alt="">';
                echo    '<div class="box-content">';
                echo        '<div class="box-info">';
                echo            '<i class="fa-solid fa-location-dot"></i>';
                echo            '<span class="place">' . htmlspecialchars($etkinlik["konum"]) . '</span>';
                echo            '<p class="place"><i class="fa-solid fa-calendar-days"></i> ' . htmlspecialchars($etkinlik["zaman"]) . '</p>';
                echo            '<p class="place"><i class="fa-solid fa-clock"></i> ' . htmlspecialchars($etkinlik["saat"]) . '</p>';
                if ($havaDurumu !== '') {
                    echo    '<p class="place"><i class="fa-solid fa-cloud-sun"></i> Tahmini Hava: ' . htmlspecialchars($havaDurumu) . '</p>';
                }
                echo            '<p class="place"><i class="fa-solid fa-tag"></i> ' . htmlspecialchars($etkinlik["tür"]) . '</p>';
                echo            '<p class="place"><i class="fa-solid fa-table-list"></i> Kalan Kontenjan : ' . htmlspecialchars($etkinlik["kontenjan"]) . '</p>';
                echo            '<button class="price" onclick="handleCartClick(\'' . htmlspecialchars($etkinlik["başlık"]) . '\')">'
                                . htmlspecialchars($etkinlik["fiyat"]) . ' <em><i class="fa-solid fa-turkish-lira-sign"></i></em></button>';
                echo        '</div>';
                echo    '</div>';
                echo '</div>';
            }

            ?>
        </div>
    </section>

<?php
    echo '<section class="duyurular">';
    echo    '<h1 class="heading">Duyurular</h1>';
    echo    '<div class="duyurular-container">';

    if (empty($duyuruListesi)) {
        echo '<p style="padding: 10px; font-style: italic; font-size:30px;">Filtreye uygun duyuru bulunamadı.</p>';
    } else {
        foreach ($duyuruListesi as $duyuru) {
            echo '<div class="duyuru-box">';
            echo    '<p class="duyuru-name">' . htmlspecialchars($duyuru['duyuruBaşlık']) . '</p>';
            echo    '<div class="duyuru-content">';
            echo        '<div class="duyuru-info">';
            echo            '<p>' . htmlspecialchars($duyuru['duyuruİçerik']) . '</p>';
            echo        '</div>';
            echo    '</div>';
            echo '</div>';
        }
    }
    echo    '</div>';
    echo '</section>';
?>
    <script>
        window.userLoggedIn = <?= isset($_SESSION['adsoyad']) ? 'true' : 'false' ?>;
    </script>

    <script src="./JS/slayt.js"></script>
    <script src="./JS/sepet.js"></script>

<div class="sepet-panel">
    <h3>Sepet</h3>
    <div class="sepet-icerik"></div>
</div>
    
</div>
</body>
</html>