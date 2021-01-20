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
    
    //email ve password var mı diye kontrol ediyoruz
	if(isset($_POST['email']) && isset($_POST['password']))
	{
		$email =$_POST["email"];
		$password =$_POST["password"];       

    //email ve password a göre kayıtlı kullanıcı varsa çekmek için sorgumuzu yazıyoruz
        $query=$db->prepare("SELECT * FROM users
        WHERE email=:email and
        password=:password");
    
    //sorgumuzu çalıştırıyoruz
      $query->execute(array(
        'email' => $email,
        'password' => $password
      ));

      //sorgumuzdan 1 kayıt dönüp dönmedigini kontrol ediyoruz
		if ($query->rowCount()==1){
      //bigileri çekiyoruz
            $user=$query->fetch(PDO::FETCH_ASSOC);

            //bilgileri session a kaydediyoruz
				$_SESSION['user_id']=$user['id'];
				$_SESSION['user_name']=$user['name'];
				$_SESSION['user_email']=$user['email'];
        
        //mesajımızı yazdırmak için kaydediyoruz.
                $_SESSION['message'] = 'İşlem başarılı';
                $_SESSION['message_type'] = 'success';
                //dashboard a yönlendiriyoruz
                header("location:dashboard.php"); 
				
		}else{
      //hata varsa hata mesajını kaydediyoruz
            $_SESSION['message'] = 'Kullanıcı adı veya şifre hatalı.';
            $_SESSION['message_type'] = 'danger';
            //index e yönlendiriyoruz
            header("location:index.php");
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

    <title>Giriş Yap</title>
  </head>
  <body>
    <div class="col-6 offset-3 mt-5">
    <h1>Giriş Yap</h1>
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
                <!-- Kullanıcı Giriş Formu Başlangıç -->
        <form method="post">
        <div class="mb-3">
    <label for="email" class="form-label">Eposta Adresi</label>
    <input type="email" class="form-control" name="email" id="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Şifre</label>
    <input type="password" class="form-control" name="password" id="password" required>
  </div>
  <button type="submit" class="btn btn-primary">Giriş Yap</button>
    </form>
    <!-- Kullanıcı Giriş Formu Bitiş -->
    <!-- Kullanıcı Kayıt Ol Linki -->
    Üye değilseniz üye olmak için <a href="register.php">Kayıt Ol</a>
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