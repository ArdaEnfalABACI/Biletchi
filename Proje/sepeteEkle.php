<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = $_POST['başlık'] ?? '';
    
    $etkinlikler = json_decode(file_get_contents('etkinlikler.json'), true);
    
    foreach ($etkinlikler as $etkinlik) {
        if ($etkinlik['başlık'] === $baslik) {
            $fiyat = $etkinlik['fiyat'];
            break;
        }
    }
    
    if ($etkinlik['kontenjan'] <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Etkinlik kontenjanı dolmuştur.']);
        exit;
    }

    if (!isset($fiyat)) {
        echo json_encode(['status' => 'error', 'message' => 'Etkinlik bulunamadı.']);
        exit;
    }

    if (!isset($_SESSION['sepet'])) {
        $_SESSION['sepet'] = [];
    }

    // Aynı ürün varsa adet artır
    $bulundu = false;
    foreach ($_SESSION['sepet'] as &$item) {
        if ($item['başlık'] === $baslik) {
            $item['adet']++;
            $bulundu = true;
            break;
        }
    }

    if (!$bulundu) {
        $_SESSION['sepet'][] = [
            'başlık' => $baslik,
            'adet' => 1,
            'fiyat' => $fiyat
        ];
    }

    echo json_encode(['status' => 'ok', 'message' => 'Ürün sepete eklendi.']);
}

?>
