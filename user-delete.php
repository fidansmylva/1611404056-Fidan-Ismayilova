<?php
//baglantıyı include edip ekliyoruz
include ("conn.php");
//session başlatıyoruz
ob_start();
session_start();

//burada kullanıcı silme işlemi yapıyoruz

//sorgumuzu yazıyoruz
$query = $db->prepare("DELETE FROM posts WHERE id = :id");
//sorgumuzu çalıştırıyoruz
$delete = $query->execute(array(
     "id" => $_SESSION['user_id']
));

//yönlendirme işlemi yapıyoruz
header("location:posts.php");