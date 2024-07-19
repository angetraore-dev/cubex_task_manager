<?php
$title = 'Err 404';
ob_start();
?>
    <div class="row my-4">
        <div class="col-sm-12 jumbotron text-center  my-4" style="min-height: 620px;">
            <h1 class="text-danger"><i class="alert-warning"></i> Error 404</h1>
            <p class="text-mutted my-4">Page not found on this server</p>
            <p><a href="<?=HTTP?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Retour</a></p>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>
<?php require_once 'layout.php';?>