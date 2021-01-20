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

    //title, content ve state varmı yok mu diye kontrol ediyoruz.
	if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['state']))
	{
        //yazı kaydetme sorgumuzu yazıyoruz.
        $insert=$db->prepare("INSERT INTO posts SET
		user_id=:user_id,
		title=:title,
		content=:content,
		date=:date,
		state=:state
		");

    //sorgumuzu çalıştırıyoruz
	$insert=$insert->execute(array(
		'user_id' => $_SESSION['user_id'],
		'title' => $_POST['title'],
		'content' => $_POST['content'],
		'date' => date("Y-m-d h:i:s"),
		'state' => $_POST['state']

	));

    //mesajımızı yazıyoruz
	$_SESSION['message'] = 'Yazınız oluşturulmuştur.';
	$_SESSION['message_type'] = 'success';
	header("location:posts.php");
	}
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

    <title>Yazı Ekleme</title>
</head>

<body>
    <?php include ("nav.php"); ?>

    <div class="col-6 offset-3 mt-5">
        <h1>Yazı Ekleme</h1>
        <div>
            <?php
    //mesaj var mı yok mu diye kontrol ediyoruz
                if(isset($_SESSION['message']))  
                {  
                    //mesaj varsa oluşturdugumuz mesajı burada gösteriyoruz.
                     echo '<label class="text-'.$_SESSION['message_type'].'">'.$_SESSION['message'].'</label>';
                     //mesajımızı yazdırdıktan siliyoruz
					 unset($_SESSION['message']);
					 unset($_SESSION['message_type']);
                }  
                ?>
                <!-- yazı kaydetme formu başlangıç -->
            <form method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" name="title" id="title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <input type="text" class="form-control" name="content" id="content" required>
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label">Durum</label>
                    <select class="form-select" name="state" id="state" required>
                        <option value="Paylaşıldı" selected>Paylaşıldı</option>
                        <option value="Taslak">Taslak</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Oluştur</button>
            </form>
            <!-- yazı kaydetme formu bitiş -->
        </div>
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