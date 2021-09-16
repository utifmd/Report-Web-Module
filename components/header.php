<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button
            class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarRightAlignExample"
            aria-controls="navbarRightAlignExample" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarRightAlignExample">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"> 
                <a class="nav-link" href="./" tabindex="-1">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" data-mdb-toggle="modal"
                    data-mdb-target="#staticBackdrop" style="cursor:pointer">
                <?php if(isset($_SESSION['isSignedIn'])) echo "Sign Out";
                    else echo "Sign In"; ?>
                </a>
            </li>
        </ul>
        </div>
    </div>
</nav>

<div class="p-5 text-center">
    <h1 class="mb-3"><?php echo $app_name; ?></h1>
    <h4 class="mb-3">Aplikasi Laporan Registrasi Poliklinik</h4>
</div>