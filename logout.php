<?php
//çıkış yaparken sessionu başlatıp herşeyi siliyoruz ve index e yönlendiriyoruz.
session_start();
session_destroy();
header("location:./");
?>