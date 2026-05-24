<?php
session_start();
$conn = new mysqli("localhost", "root", "", "forum");

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Türkçe karakter sorunu olmaması için
$conn->set_charset("utf8mb4");
?>