<?php 

$başlık=$_GET['başlık'];
$dosya='etkinlikler.json';

$veriler=json_decode(file_get_contents($dosya), true);

$yeniveriler = array_filter($veriler, function($veri) use ($başlık) {
    return $veri['başlık'] !== $başlık;
});

$yeniveriler = array_values($yeniveriler);  

file_put_contents($dosya, json_encode($yeniveriler, JSON_PRETTY_PRINT));


header("Location:EditPage.php");

?>
