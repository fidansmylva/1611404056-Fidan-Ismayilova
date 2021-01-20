<?php
//baglantıyı include edip ekliyoruz
include ("conn.php");
//session başlatıyoruz
ob_start();
session_start();

//id var mı yok mu diye kontrol ediyoruz
if(!isset($_GET['id']) || $_GET['id']==''){
    header("location:posts.php");
}

//yazıyı çekiyoruz
$post=$db->query("SELECT * FROM posts WHERE id = ".$_GET['id'])->fetch(PDO::FETCH_ASSOC);

$title=$post['title'];
$content=$post['content'];
$state=$post['state'];

//giriş yapan kullanıcı yazıyı paylaşan mı diye kontrol ediyoruz
if($post['user_id']!=$_SESSION['user_id']){
    //yazıyı paylaşan kişi giriş yapan kullanıcı degil ise kullanıcının yazılarına yönlendiriyoruz
    header("location:posts.php");
    exit;
}

//burada silme işlemi yapıyoruz

//silme sorugumuzu yazıyoruz
$query = $db->prepare("DELETE FROM posts WHERE id = :id");
//sorugumuzu çalıştırıyoruz
$delete = $query->execute(array(
     "id" => $_GET['id']
));

//yazı sayfasına yönlendiriyoruz
header("location:posts.php");