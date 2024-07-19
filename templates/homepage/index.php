<?php ob_start();?>
<!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?=HTTP.'/assets/la.jpg'?>" alt="Los Angeles" class="d-block" style="width:100%">
        </div>
        <div class="carousel-item">
            <img src="<?=HTTP.'/assets/chicago.jpg'?>" alt="Chicago" class="d-block" style="width:100%">
        </div>
        <div class="carousel-item">
            <img src="<?=HTTP.'/assets/ny.jpg'?>" alt="New York" class="d-block" style="width:100%">
        </div>
    </div>

    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="container-fluid mt-3">
    <h3><?=$title?></h3>
    <p>
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad alias atque cupiditate debitis, dolores enim, harum incidunt minus nobis nostrum officia officiis perspiciatis porro possimus quidem reiciendis rerum velit.
    </p>
</div>
<?php $content = ob_get_clean();?>
<?php require_once DOCROOT .'/templates/layout.php';?>
