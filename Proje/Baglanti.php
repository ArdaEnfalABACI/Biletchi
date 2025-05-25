<?php
    $vt_sunucu="localhost";
    $vt_kullanici="root";
    $vt_sifre="";
    $vt_adi="biletchi";

    $baglanti=mysqli_connect($vt_sunucu, $vt_kullanici, $vt_sifre, $vt_adi);

    if(!$baglanti){
        die("Veritabanına Bağlanılamadı".mysqli_connect_error());
    }
?>