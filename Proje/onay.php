<?php
include("Baglanti.php");

$kayitno=$_GET["id"];

$sorgu=$baglanti->query("update kayit set onay_durumu='onaylandı' where id=$kayitno");

if($sorgu){
    echo "<script>
    alert('Onaylandı');
    window.location.href='AdminPage.php'
    </script>";
}

else{
    echo "Onaylanamadı";
}

?>