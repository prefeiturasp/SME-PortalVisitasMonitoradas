<?php
/*
 * Template Name: Inscrições
 * Description: Página de Incrições de eventos
 */

use Classes\ModelosDePaginas\Inscricoes\Inscricoes;

get_header();

$inscricoes = new Inscricoes();

get_footer();