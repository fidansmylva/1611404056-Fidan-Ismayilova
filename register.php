<?php
//baglantıyı include edip ekliyoruz
include ("conn.php");
//session başlatıyoruz
ob_start();
session_start();

//giriş yapılı kullanıcı olup olmadıgını kontrol ediyoruz.
if(isset($_SESSION['user_id'])){
  //giriş yapmış kullanıcı varsa dashboard yönlendiriyoruz
    header("location:dashboard.php");
}

 //name, email ve password var mı diye kontrol ediyoruz
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']))
	{
		$name =$_POST["name"];
		$email =$_POST["email"];
		$password =$_POST["password"];  
    
    //email adresi daha önceden alınmış mı diye kontrol etmek için sorgumuzu yazıyoruz
		$query=$db->prepare("SELECT * FROM users
		WHERE email=:email");

//sorgumuzu çalıştırıyoruz
	$query->execute(array(
		'email' => $email
	));

	$user_control=$query->rowCount();

  //email adresi alınmış mı diye kontrol ediyoruz
	if($user_control!=1){

    //email adresi daha önceden alınmamışsa kayır için sorgumuzu oluşturuyoruz
        $insert=$db->prepare("INSERT INTO users SET
		name=:name,
		email=:email,
		password=:password
		");

//sorgumuzu çalıştırıyoruz
	$insert=$insert->execute(array(
		'name' => $_POST['name'],
		'email' => $_POST['email'],
		'password' => $_POST['password']

	));

  //mesajımızı kaydediyoruz
	$_SESSION['message'] = 'Kaydınız oluşturulmuştur.<br>Giriş yapabilirsiniz.';
	$_SESSION['message_type'] = 'success';
	header("location:index.php");
	
	}else{
    //email adresi daha önceden alınmışsa mesajımızı kaydediyoruz
		$_SESSION['message'] = 'Eposta Adresi daha önceden alınmış.';
		$_SESSION['message_type'] = 'danger';
            header("location:register.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Kayıt Ol</title>
  </head>
  <body>
    <div class="col-6 offset-3 mt-5">
    <h1>Kayıt Ol</h1>
    <div>
    <?php
    //mesaj olup olmadıgını kontrol ediyoruz
                if(isset($_SESSION['message']))  
                {  
                  //mesajımızı yazdırıyoruz
                     echo '<label class="text-'.$_SESSION['message_type'].'">'.$_SESSION['message'].'</label>';
                     //mesajımızı siliyoruz
                     unset($_SESSION['message']);
					 unset($_SESSION['message_type']);
                }  
                ?>
                <!-- Kullanıcı Kayıt Ol Formu Başlangıç -->
        <form method="post">
        <div class="mb-3">
    <label for="name" class="form-label">Ad Soyad</label>
    <input type="name" class="form-control" name="name" id="name" required>
  </div>
        <div class="mb-3">
    <label for="email" class="form-label">Eposta Adresi</label>
    <input type="email" class="form-control" name="email" id="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Şifre</label>
    <input type="password" class="form-control" name="password" id="password" required>
  </div>
  <button type="submit" class="btn btn-primary">Kayıt Ol</button>
    </form>
    <!-- Kullanıcı Kayıt Ol Formu Bitiş -->
    <!-- Kullanıcı Giriş Yap Linki -->
    Üye iseniz giriş yapmak için <a href="index.php">Giriş Yap</a>
    </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
  </body>
</html>