<?php
use Classes\TemplateHierarchy\LoopParceiro\LoopParceiro;
get_header();
$loop_single = new LoopParceiro();
//contabiliza visualizações de noticias
//setPostViews(get_the_ID()); /*echo getPostViews(get_the_ID());*/
get_footer();