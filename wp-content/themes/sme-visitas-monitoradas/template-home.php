<?php
/*
 * Template Name: Home Visitas Monitoradas
 * Description: Página Home de Visitas Monitoradas
 */

get_header();

?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><?php include_once 'home/busca.php';?></div>
    </div>
    <div class="row">
        <div class="col-sm-12 mb-5"><?php include_once 'home/banner.php';?></div>
    </div>
    <div class="row">
        <div class="col-sm-12 mt-3 mb-3"><?php include 'home/carrossel-cinemas.php';?></div>
    </div>
    <div class="row">
        <div class="col-sm-12 mt-3 mb-3"><?php include 'home/carrossel-museus.php';?></div>
    </div>
</div>
<?php

get_footer();



