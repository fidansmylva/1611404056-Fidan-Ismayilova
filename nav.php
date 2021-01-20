<nav class="navbar navbar-expand-lg navbar-light bg-light mx-3">
    <!-- giriş yapan kullanıcının adını yazdırıyoruz -->
        <a class="navbar-brand" href="./">Merhaba <?php echo $_SESSION['user_name']; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="posts.php">Yazılar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user-update.php">Bilgilerim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Çıkış Yap</a>
                </li>
            </ul>
        </div>
    </nav>