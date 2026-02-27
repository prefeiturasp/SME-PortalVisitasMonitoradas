<?php
require_once("../../../wp-load.php");
$date = date('d_m_y_h_i_s');
//$date = generateRandomStringExcel();
$fileName = $date . '_inscricoes_visitas.xlsx';
 
$agendamentos = array();
$agendamentos[] = array(
	'<style bgcolor="#8EA9DB">ID</style>',
	'<style bgcolor="#8EA9DB">Evento</style>',
	'<style bgcolor="#8EA9DB">Número de convites</style>',
	'<style bgcolor="#8EA9DB">Tipo de transporte</style>',
	'<style bgcolor="#8EA9DB">Data da visita</style>',
	'<style bgcolor="#8EA9DB">Dia da semana</style>',
	'<style bgcolor="#8EA9DB">Horário da visita</style>',
	'<style bgcolor="#8EA9DB">Duração da visita</style>',
	'<style bgcolor="#8EA9DB">DRE</style>',
	'<style bgcolor="#8EA9DB">Nome da UE</style>',
	'<style bgcolor="#8EA9DB">Ano/Ciclo</style>',
	'<style bgcolor="#8EA9DB">Telefone</style>',	
	'<style bgcolor="#8EA9DB">Nome do responsável</style>',
	'<style bgcolor="#8EA9DB">Contato do responsável</style>',
	'<style bgcolor="#8EA9DB">Demandas atendidas</style>',
	'<style bgcolor="#8EA9DB">Transporte utilizado</style>',
	'<style bgcolor="#8EA9DB">Relação com parceiro</style>',
	'<style bgcolor="#8EA9DB">Repetiria a visita</style>',
	'<style bgcolor="#8EA9DB">Comentarios gerais</style>',
);

$tipoTransporte = array(
	'dre' => 'DRE',
	'parceiro' => 'Parceiro',
	'proprio-ue' => 'Próprio UE'
);

$args = array(
	'post_type' => 'agendamento',
	'posts_per_page' => -1,
	'post_status' => 'any',
	'meta_query' => array()
);

if($_GET['s'] && $_GET['s'] != ''){
	$args['s'] = $_GET['s'];
}

if($_GET['m'] && $_GET['m'] != ''){
	$mesAno = $_GET['m'];	
	$args['monthnum'] = substr($mesAno, -2);
	$args['year'] = substr($mesAno, 0, 4);
}

$user = wp_get_current_user();

if($_GET['search_dre'] && $_GET['search_dre'] != '' && $_GET['search_dre'] != 'all'){
	$args['meta_query'][] = 
		array(
			'key'     => 'dre_selected',
			'value' => $_GET['search_dre'],
		
	);
} elseif($user->roles[0] != 'administrator'){		
	// pega o grupo que o usuario pertence
	$grupos = get_user_meta($user->ID, 'grupo');
	//$grupos = get_field('grupo', 'user_' . $user->ID);

	//$dres_open = array();
	foreach($grupos[0] as $dre){
		$dres_open[] = get_post_meta($dre, 'dre');			
	}

	$dres_open = array_flatten($dres_open);
	$dres_open = array_unique($dres_open);

	$args['meta_query'][] = array(					
		'key'     => 'dre',
		'value'   => $dres_open,
	);
}

if( $_GET['transporte'] && $_GET['transporte'] != '' )  {
			
	if($_GET['transporte'] == 'sim'){
		$args['meta_query'][] = array(					
			'key'     => 'transporte',
			'value' => '1',
		);
	} else {
		$args['meta_query'][] = array(
			'relation' => 'OR',
			array(
				'key'     => 'transporte',
				'value'   => 0,
				'compare' => '='
			),
			array(
				'key'     => 'transporte',
				'compare' => 'NOT EXISTS',
			)
		);
		
	}
	
}

if( $_GET['ciclo'] && $_GET['ciclo'] != '' )  {
	$args['meta_query'][] = array(					
		'key'     => 'ciclo_ano',
		'value' => $_GET['ciclo'],
		'compare' => 'LIKE'
	);
}

if( $_GET['faixa'] && $_GET['faixa'] != '' )  {
	$args['meta_query'][] = array(					
		'key'     => 'faixa_etaria',
		'value' => $_GET['faixa'],
		'compare' => 'LIKE'
	);
}

// The Query
$the_query = new \WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$data = getEventDate(get_field('data_horario'));
		$hora = getEventHour(get_field('data_horario'));
		$diaSemana = diaSemana($data[0]);
		$dre = get_field('dre');
		if(array_key_exists('label', $dre)){
			$dre = $dre['label'];
		} else {
			$dre = convert_dre_name($dre);
		}

		if(get_field('dre_selected')){
			$dre = get_the_title(get_field('dre_selected'));
		}

		$cicloAno = '';
		$i = 0;
		$ciclos = get_field('ciclo_ano');
		foreach($ciclos as $ciclo){
			if($i == 0){
				$cicloAno .= get_term($ciclo)->name;
			} else {
				$cicloAno .= ', ' . get_term($ciclo)->name;
			}
			$i++;		
		}

		if(get_field('aval_resp')){
			$demandas = get_field('demandas_pedago');
			$transporte = get_field('transporte_util');
			$rel_parceiro = get_field('rel_parceiro');
			$repetir = get_field('repetir_visita');
			$comentarios = get_field('comentarios_gerais');
		} else {
			$demandas = '';
			$transporte = '';
			$rel_parceiro = '';
			$repetir = '';
			$comentarios = '';
		}

		$agendamentos[] = array(
			get_the_ID(),
			str_replace('&#8217;', '’', get_the_title()),
			get_field('num_estudantes'),
			$tipoTransporte[get_field('tipo_transporte')],
			$data[0],
			$diaSemana,
			$hora[0],
			get_field('duracao') . ' horas',
			$dre,
			get_field('nome_ue'),
			$cicloAno,
			get_field('telefone_ue'),
			get_field('nome_responsavel'),
			get_field('contato_responsavel'),
			$demandas,
			$transporte,
			$rel_parceiro,
			$repetir,
			$comentarios,
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