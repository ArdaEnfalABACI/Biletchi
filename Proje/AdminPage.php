<html>
    <head>

    <link rel="stylesheet" type="text/css" href="Css/ProjeCSS.css">

    </head>
    <body style="background-color: gainsboro">
         <div class="admin-topbar">

            <div class="admin-topbar-left">
                <i class="fa-solid fa-ticket"></i>
                <a href="#" >Biletchi </a>
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

$sorgu=$baglanti->query("select * from kayit");

echo " <br>
<table>

<tr align='center'>
<th> Kayıt No </th>
<th> Mail </th>
<th> Ad Soyad </th>
<th> Onay Durumu </th>
<th> Düzenle </th>

</tr>";

while($satır=$sorgu->fetch_object()){
echo"
<tr align='center'>
<td>$satır->id </td>
<td>$satır->mail </td>
<td>$satır->adsoyad </td>
<td>$satır->onay_durumu </td>
<td> <a class='onayla' href='onay.php?id=$satır->id'>onayla</a> - <a class='sil' href='sil.php?id=$satır->id'>sil</a> </td>

</tr>
";

}
echo"</table>";

$toplam=$sorgu->num_rows;

$sorgu-> free_result();

$baglanti->close();

echo"<br> Toplam $toplam Kayıt Bulundu.";

?>