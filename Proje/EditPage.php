<html>
    <head>
    <script src="ProjeJS.js"></script>

    <link rel="stylesheet" type="text/css" href="Css/ProjeCSS.css">
    </head>

    <body style="background-color: gainsboro;">
         <div class="admin-topbar">

            <div class="admin-topbar-left">
                <i class="fa-solid fa-ticket"></i>
                <a href="#">Biletchi </a>
            </div>
            <div class="admin-topbar-mid">
                <a href="/Proje/EditPage.php">Etkinlik / Duyuru Düzenleme</a>
            </div>
            <div class="admin-topbar-right">
                <a href="/Proje/AdminPage.php">Üye Yönetimi</a>
            </div>
        </div>  

    </body>
</html>

<?php 
include("Baglanti.php");


echo "<br>
<table>

<tr align='center'>
<th> Başlık </th>
<th> Konum </th>
<th> Tarih </th>
<th> Saat </th>
<th> Tür </th>
<th> Kontenjan </th>
<th> Fiyat </th>
<th> Düzenle </th>

</tr>";

$file_url = "etkinlikler.json";
$data = file_get_contents($file_url);
$data = json_decode($data);

foreach ($data as $data){
echo"   
<tr align='center'>
<td>{$data ->başlık}</td>
<td>{$data ->konum}</td>
<td>{$data ->zaman}</td>
<td>{$data ->saat}</td>
<td>{$data ->tür}</td>
<td>{$data ->kontenjan}</td>
<td>{$data ->fiyat}</td>
<td> <a class='düzenle' href='etkinlikDüzenle.php?başlık=".urlencode("$data->başlık")."'> düzenle</a> - <a class='sil' href='etkinlikSil.php?başlık=".urlencode("$data->başlık")."'>sil</a></td>

</tr>
";
}

echo"</table> <br>";

echo "<a class='etkinlik-ekle' href='ekle.php'>Etkinlik Ekle</a>";


echo "<br>
<table>

<tr align='center'>
<th> Duyuru Başlığı </th>
<th> Duyuru Tarihi </th>
<th> İlgili Şehir </th>
<th> İlgili Tür </th>
<th> Düzenle </th>
</tr>";

$duyuru_file_url ="duyurular.json";
$veri = file_get_contents($duyuru_file_url);
$veri = json_decode($veri);

foreach ($veri as $veri){
echo"   
<tr align='center'>
<td>{$veri ->duyuruBaşlık}</td>
<td>{$veri ->duyuruTarih}</td>
<td>{$veri ->duyuruŞehir}</td>
<td>{$veri ->duyuruTür}</td>

<td> <a class='düzenle' href='duyuruDüzenle.php?duyuruBaşlık=".urlencode("$veri->duyuruBaşlık")."'> düzenle</a> - <a class='sil' href='duyuruSil.php?duyuruBaşlık=".urlencode("$veri->duyuruBaşlık")."'>sil</a></td>

</tr>
";
}
echo"</table> <br>";
echo "<a class='etkinlik-ekle' href='duyuruEkle.php'>Duyuru Ekle</a>";

?>


