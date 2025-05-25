<?php 

$başlık=$_GET['duyuruBaşlık'];
$dosya='duyurular.json';

$veriler=json_decode(file_get_contents($dosya), true);

$yeniveriler = array_filter($veriler, function($veri) use ($başlık) {
    return $veri['duyuruBaşlık'] !== $başlık;
});

$yeniveriler = array_values($yeniveriler);  

file_put_contents($dosya, json_encode($yeniveriler, JSON_PRETTY_PRINT));
    

header("Location:EditPage.php");

?>
