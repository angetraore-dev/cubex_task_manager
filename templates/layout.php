<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= HTTP .'/assets/requirements/coolX.png'?>">
    <link rel="stylesheet" href="<?= HTTP .'/assets/css/style.css'?>">
    <title class="text-uppercase"><?= SITE_NAME ." - ". $title ?></title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />

</head>
<body>
<header class="text-uppercase fw-bold fs-6" style="border-bottom: gold 1px solid !important;">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!--<img src="#" width="36" height="30" alt="logo_cubex_sa" class="d-inline-block align-text-top" >-->
            <a class="navbar-brand text-white" href="<?=HTTP?>">
                <img src="<?= HTTP.'/asets/requirements/scdX.png'?>" width="36" height="30" alt="logo_cubex_sa" class="d-inline-block align-text-top" >
                 <!--<i class="bi bi-home"></i> cubex sa-->
            </a>
            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 1): ?>
                    <ul class="navbar-nav ms-auto me-0">
                        <li class="nav-item">
                            <span class="nav-link" style="color: gold"><?= 'admin ' .$_SESSION['username'] ?></span>
                        </li>

                        <li class="nav-item">
                            <a href="<?=HTTP.'/logout'?>" class="nav-link">logout</a>
                        </li>

                    </ul>
                <?php elseif (isset($_SESSION['user_id']) && $_SESSION['role'] == 2):?>

                    <ul class="navbar-nav ms-auto me-0">
                        <li class="nav-item">
                            <span class="nav-link"><?= 'responsible ' .$_SESSION['username'] ?></span>
                        </li>

                        <li class="nav-item">
                            <a href="<?=HTTP.'/logout'?>" class="nav-link">logout</a>
                        </li>

                    </ul>
                <?php else:?>

                    <ul class="navbar-nav ms-auto me-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?=HTTP.'/home'?>">home</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?=HTTP.'/login'?>" class="nav-link">sign in</a>
                        </li>

                    </ul>
                <?php endif;?>

            </div>

        </div>
    </nav>
</header>
<div class="main min-vh-100">
    <?= $content ?>
</div>
<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 fw-bold">© 2024 atdevs.ci +225 0507 333 944</p>

    <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
    </a>

    <ul class="nav col-md-4 justify-content-end">
        <li class="nav-item"><a href="#" class="nav-link px-2">Home</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2">Features</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2">Pricing</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2">FAQs</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2">About</a></li>
    </ul>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?= HTTP.'/assets/jquery/jquery.js'?>"></script>
<script type="text/javascript" src="<?= HTTP .'/assets/bootstrap/dist/js/bootstrap.bundle.js'?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--DataTables Scripts
<script src="<=HTTP.'/assets/datatables.net/js/dataTables.js'?>"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>

-->
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<!--<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>-->
<script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>
<!-- End dataTables -->

<script type="text/javascript" src="<?=HTTP.'/assets/js/atdevs.js'?>"></script>

</body>
</html>