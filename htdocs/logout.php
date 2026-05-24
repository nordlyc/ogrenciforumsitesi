<?php
// Önce mevcut oturuma bağlanma
session_start();

// Tüm oturum değişkenlerini temizleme
$_SESSION = array();

// Oturumu tamamen sonlandırma
session_destroy();

// Kullanıcıyı ana sayfaya veya giriş sayfasına yönlendirme
header("Location: login.php");
exit;
?>