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

//giriş yapan kullanıcının bilgilerini çekiyoruz
$user=$db->query("SELECT * FROM users WHERE id = ".$_SESSION['user_id'])->fetch(PDO::FETCH_ASSOC);

        $name =$user["name"];
		$email =$user["email"];
        $password =$user["password"];

        //name, email ve password varmı yok mu diye kontrol ediyoruz.
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']))
	{
        $name =$_POST["name"];
		$email =$_POST["email"];
        $password =$_POST["password"];  
        
        //email adresi degiştirildi mi diye kontrol ediyoruz
        if($_POST["email"]!=$user['email'])
        {
            //degiştirilen email adresi daha önceden alımışmı diye kontrol etmek için sorgumuzu yazıp kaydı çekiyoruz.
		$query=$db->prepare("SELECT * FROM users
		WHERE email=:email");
//sorgumuzu çalıştırıyoruz
	$query->execute(array(
		'email' => $email
	));

    //sorgumuzdan kaç tane kayıt döndügüne göre kontrol ediyoruz
    $user_control=$query->rowCount();
}else{
    // email adresi degiştirilmemişte diger işlemleri yapmadan devam ediyoruz
    $user_control=0;
}

//kontrolümüzden dönen degeri kontrol ediyoruz
	if($user_control!=1){

        //kullanıcı güncelleme sorgumuzu yazıyoruz
        $query=$db->prepare("UPDATE users SET
		name=:name,
		email=:email,
		password=:password
        WHERE id=:id
		");

//sorgumuzu çalıştırıyoruz
	$update=$query->execute(array(
		'name' => $name,
		'email' => $email,
		'password' => $password,
		'id' => $user['id']
    ));
    
    //işlem başarılımı diye kontrol ediyoruz
    if ( $update ){
   
        //session daki kullanıcı bilgilerini güncelliyoruz
				$_SESSION['user_name']=$name;
				$_SESSION['user_email']=$email;

                //bildiri mesajımızı oluşturuyoruz
	$_SESSION['message'] = 'Bilgileriniz Güncellenmiştir.';
	$_SESSION['message_type'] = 'success';
   
}else{
    $_SESSION['message'] = 'Bir Sorun oluştu tekrar deneyiniz.';
		$_SESSION['message_type'] = 'danger';
}
	
	}else{
		$_SESSION['message'] = 'Eposta Adresi ile daha önceden üye olunmuştur.';
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

    <title>Bilgi Güncelleme</title>
</head>

<body>
<?php include ("nav.php"); ?>

    <div class="col-6 offset-3 mt-5">
        <h1>Bilgi Güncelleme</h1>
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
                <!-- kullanıcı güncelleme formu başlangıç -->
            <form method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Ad Soyad</label>
                    <input type="name" class="form-control" name="name" id="name" value="<?php echo $name; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Eposta Adresi</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" name="password" id="password"
                        value="<?php echo $password; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Güncelle</button>
            </form>
            <!-- kullanıcı güncelleme formu bitiş -->
            <!-- hesap silme butonu -->
                <a href="user-delete.php" class="btn btn-danger" style="margin-top: 150px; margin-left:800px;">Hesabı Sil</a>
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