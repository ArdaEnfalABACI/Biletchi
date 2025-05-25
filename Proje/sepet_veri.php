<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($_SESSION['sepet'] ?? []);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($_SESSION['sepet'])) {
        $_SESSION['sepet'] = [];
    }

    if ($data['action'] === 'update' && isset($data['index'], $data['adet'])) {
        $_SESSION['sepet'][$data['index']]['adet'] = (int) $data['adet'];
    }

    if ($data['action'] === 'remove' && isset($data['index'])) {
        array_splice($_SESSION['sepet'], $data['index'], 1);
    }

    echo json_encode(['status' => 'ok']);
}
?>