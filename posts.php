<?php
//baglantıyı include edip ekliyoruz
include ("conn.php");
//session başlatıyoruz
ob_start();
session_start();

//giriş yapılı kullanıcı olup olmadıgını kontrol ediyoruz.
if(!isset($_SESSION['user_id'])){
	header("location:index.php");
}

//kullanıcının yazılarını çekiyoruz
$posts=$db->query("SELECT * FROM posts WHERE posts.user_id = ".$_SESSION['user_id']." ORDER BY posts.date DESC");
?>
<!doctype html>
<html lang="tr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Yazılar</title>
</head>

<body>
<?php include ("nav.php"); ?>

    <div class="col-6 mt-5 offset-3">
        <div class="col-12">
            <a href="post-insert.php" class="btn btn-primary">Yazı Ekle</a>
        </div>
        <?php
        //yazılarımızı listeliyoruz başlangıç
                foreach($posts as $post){
                    echo '<div class="card mt-3">
                    <div class="card-body">
                        <h4 class="card-title">'.$post['title'].'</h4>
                        <h6 class="">'.date("h:i d-m-Y", strtotime($post['date'])).'</h6>
                        <p class="card-text">'.$post['content'].'</p>
                        <a href="post-update.php?id='.$post['id'].'" class="btn btn-primary">Düzenle</a>
                        <a href="post-delete.php?id='.$post['id'].'" class="btn btn-danger">Sil</a>
                    </div>
                </div>';

                }
                //bitiş
            ?>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
</body>

</html>