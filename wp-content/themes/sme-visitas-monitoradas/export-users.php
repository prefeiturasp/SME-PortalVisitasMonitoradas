<?php
require_once("../../../wp-load.php");
$date = date('d_m_y_h_i_s');
$fileName = $date . '_usuarios_portal.xlsx';
 
if($_GET['funcao'] == 'all'){
	$blogusers = get_users( array( 'fields' => array( 'id', 'user_login', 'user_email' ) ) );
} else {
	$blogusers = get_users( 
		array( 
			'fields' => array( 'id', 'user_login', 'user_email' ),
			'role__in' => array( $_GET['funcao'] )
		)
	);
}

$usuarios = array();
$usuarios[] = array(
	'<style bgcolor="#8EA9DB">ID</style>',
	'<style bgcolor="#8EA9DB">Login</style>',
	'<style bgcolor="#8EA9DB">E-mail</style>',
	'<style bgcolor="#8EA9DB">Função</style>',
	'<style bgcolor="#8EA9DB">Grupo</style>',
	'<style bgcolor="#8EA9DB">Setor</style>'
);

function convertFunc($funcao){
	switch ($funcao):
		case 'administrator':
			return 'Administrador';
			break;
		case 'contributor':
			return 'Colaborador';
			break;
		case 'editor':
			return 'Editor';
			break;
		default:
			return $funcao;
	endswitch;
}

foreach($blogusers as $user){
	$user_meta = get_userdata($user->id);
	$user_roles = $user_meta->roles;
	$setor = get_field('setor_novo', 'user_'. $user->id );
	$grupos = get_field('grupo', 'user_'. $user->id );
	$grupoTitle = '';
	$i = 0;
	if($grupos && $grupos != '' && $grupos[0] != ''){
		foreach($grupos as $grupo){
			$title = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim( get_the_title($grupo) )));
			if($i == 0){				
				$grupoTitle .= $title;
			} else {
				$grupoTitle .= ', ' . $title;
			}
			$i++;
		}				
	}

	$setor = get_the_title($setor);
	$func = $user_roles[0];

	if($setor == '')
		$setor = '<center>-</center>';

	if($grupoTitle == '')
		$grupoTitle = '<center>-</center>';

	if($func == '')
		$func = '<center>-</center>';

	$usuarios[] = array(
		$user->id,
		$user->user_login,
		$user->user_email,
		convertFunc($func),
		$grupoTitle,
		$setor
	);

}

$xlsx = Classes\Lib\SimpleXLSXGen::fromArray( $usuarios );
$xlsx->downloadAs($fileName); // or downloadAs('books.xlsx') or $xlsx_content = (string) $xlsx 

exit();