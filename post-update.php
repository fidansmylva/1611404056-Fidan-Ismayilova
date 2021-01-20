<?php
//baglantıyı include edip ekliyoruz
include ("conn.php");
//session başlatıyoruz
ob_start();
session_start();

if(!isset($_GET['id']) || $_GET['id']==''){
    header("location:posts.php");
}

//güncellenecek yazıyı çekiyoruz
$post=$db->query("SELECT * FROM posts WHERE id = ".$_GET['id'])->fetch(PDO::FETCH_ASSOC);

$title=$post['title'];
$content=$post['content'];
$state=$post['state'];

//güncellenecek yazıyı giriş yapan kullanıcının yazıp yazmadıgını kontrol ediyoruz
if($post['user_id']!=$_SESSION['user_id']){
    //yazıyı giriş yapan kullanıcı yazmadıysa yazılar sayfasına yönlendiriyoruz
    header("location:posts.php");
}

//title, content ve state varmı yok mu diye kontrol ediyoruz.
if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['state']))
{
    $title=$_POST['title'];
$content=$_POST['content'];
$state=$_POST['state'];

//güncelleme sorgumuzu yazıyoruz
$query=$db->prepare("UPDATE posts SET
		title=:title,
		content=:content,
		state=:state
        WHERE id=:id
		");

//soruguyu çalıştırıyoruz
	$update=$query->execute(array(
		'title' => $title,
		'content' => $content,
		'state' => $state,
		'id' => $post['id']
    ));

	if( $update ){
        //güncelleme işlemi başarılıysa mesaj yazdırıyoruz
        $_SESSION['message'] = 'Bilgileriniz Güncellenmiştir.';
	$_SESSION['message_type'] = 'success';
    }else{
        //güncelleme işlemi başarılı degilse mesaj yazdırıyoruz
        $_SESSION['message'] = 'Bir Sorun oluştu tekrar deneyiniz.';
		$_SESSION['message_type'] = 'danger';
    }
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

    <title>Yazı Güncelleme</title>
</head>

<body>
    <?php include ("nav.php"); ?>

    <div class="col-6 offset-3 mt-5">
        <h1>Yazı Güncelleme</h1>
        <div>
            <?php
            //mesaj var mı yok mu diye kontrol ediyoruz
                if(isset($_SESSION['message']))  
                {
                    //mesaj varsa oluşturdugumuz mesajı burada gösteriyoruz
                     echo '<label class="text-'.$_SESSION['message_type'].'">'.$_SESSION['message'].'</label>';
                     //mesajımızı yazdırdıktan siliyoruz
					 unset($_SESSION['message']);
					 unset($_SESSION['message_type']);
                }  
                ?>
            <!-- yazı güncelleme formu başlangıç -->
            <form method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <input type="text" class="form-control" name="content" id="content" value="<?php echo $content; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label">Durum</label>
                    <select class="form-select" name="state" id="state" required>
                        <option value="Paylaşıldı" <?php if($state=='Paylaşıldı') echo 'selected'; ?> >Paylaşıldı</option>
                        <option value="Taslak" <?php if($state=='Taslak') echo 'selected'; ?>>Taslak</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Güncelle</button>
            </form>
            <!-- yazı güncelleme formu bitiş -->
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