<?php
require_once("../../../wp-load.php");
$date = date('d_m_y_h_i_s');
$fileName = $date . '_grupos_visitas.xlsx';
 
$agendamentos = array();
$agendamentos[] = array(
	'<style bgcolor="#8EA9DB">ID</style>',
	'<style bgcolor="#8EA9DB">DRE</style>',
	'<style bgcolor="#8EA9DB">Total de ônibus</style>',
	'<style bgcolor="#8EA9DB">Ônibus disponíveis</style>'
	
);

$args = array(
	'post_type' => 'editores_portal',
	'posts_per_page' => -1,
	'post_status' => 'any',
	'meta_query' => array()
);

if($_GET['s'] && $_GET['s'] != ''){
	$args['s'] = $_GET['s'];
}



$user = wp_get_current_user();

if($user->roles[0] != 'administrator'){		
	// pega o grupo que o usuario pertence
	$grupos = get_user_meta($user->ID, 'grupo');
	$args['post__in'] = $grupos[0];
}



// The Query
$the_query = new \WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		
		
		$agendamentos[] = array(
			get_the_ID(),
			str_replace('&#8217;', '’', get_the_title()),			
			get_field('qtd_onibus'),
			get_field('qtd_disponivel'),
		);
	}
	
}
wp_reset_postdata();

//echo "<pre>";
//print_r($agendamentos);
//echo "</pre>";

$xlsx = Classes\Lib\SimpleXLSXGen::fromArray( $agendamentos );
$xlsx->downloadAs($fileName); // or downloadAs('books.xlsx') or $xlsx_content = (string) $xlsx 

exit();