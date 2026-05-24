<?php
include "config.php";

// Admin kontrolü
if(isset($_SESSION['role']) && $_SESSION['role'] == 1){
    $id = intval($_GET['id']);
    $post_id = intval($_GET['post']);
    
    $conn->query("DELETE FROM comments WHERE id = $id");
    header("Location: post_view.php?id=$post_id");
} else {
    die("Bu işlem için yetkiniz yok.");
}
?>