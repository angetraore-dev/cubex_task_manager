<?php ob_start();?>
    <h3>Dashboard Page <?= $_SESSION['username'] .' ' .$_SESSION['role']?></h3>
<?php $content = ob_get_clean(); ?>
<?php require_once DOCROOT .'/templates/layout.php';?>