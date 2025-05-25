<?php
include("Baglanti.php");

$kayitno=$_GET["id"];

$sorgu=$baglanti->query("delete from kayit where id=$kayitno");

if($sorgu){
    echo "<script>
    alert('Kayıt Silindi');
    window.location.href='AdminPage.php'
    </script>";
}
else{
    echo "Kayıt Silinemedi";
}

?>
