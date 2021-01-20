<?php 
try {
	//PDO baglantı bilgilerimi giriyoruz
	$host='localhost';
	$dbname='odev';
	$username='root';
	$password='';
	//PDO baglantımızı yapıyoruz
	$db=new PDO("mysql:host={$host};dbname={$dbname};charset=utf8",$username,$password);
	$db->exec("SET CHARSET UTF8");
}

catch (PDOExpception $e) {
//verirse hata mesajını yazıdırıyoruz.
	echo $e->getMessage();
}
?>