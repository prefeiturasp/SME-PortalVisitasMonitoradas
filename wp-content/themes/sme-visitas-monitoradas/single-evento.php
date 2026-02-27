<?php
use Classes\TemplateHierarchy\LoopEvento\LoopEvento;
get_header();
$loop_single = new LoopEvento();
//contabiliza visualizações de noticias
//setPostViews(get_the_ID()); /*echo getPostViews(get_the_ID());*/
get_footer();