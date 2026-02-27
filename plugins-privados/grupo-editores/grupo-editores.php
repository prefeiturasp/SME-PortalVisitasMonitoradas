<?php
/*
Plugin Name: Grupos Editores
Description:  Plugin Criado para controlar os editores dos portais
Author: Felipe Viana
Version: 1.0.0
Author URI: https://www.amcom.com.br/
*/

// Post Type Grupos
function wporg_custom_post_type() {
    register_post_type('editores_portal',
        array(
            'labels'      => array(
                'name'          => __( 'Grupos', 'textdomain' ),
                'singular_name' => __( 'Grupo', 'textdomain' ),
            ),
            'public'      => true,
            'has_archive' => true,
			'rewrite'     => array( 'slug' => 'editores_portal' ), // my custom slug
            'menu_position'=> 20,
			'capabilities' => array(
				'edit_post'          => 'activate_plugins',
				'read_post'          => 'activate_plugins',
				'delete_post'        => 'activate_plugins',
				'edit_posts'         => 'add_grupo',
				'edit_others_posts'  => 'activate_plugins',
				'delete_posts'       => 'activate_plugins',
				'publish_posts'      => 'activate_plugins',
				'read_private_posts' => 'activate_plugins',
				'create_posts' => 'activate_plugins'
			),
        )
    );
}
add_action('init', 'wporg_custom_post_type');



// Controle de paginas permitidas
function wpse_user_can_edit( $user_id, $page_id ) {

    // ID da pagina corrente da lista
    $page = get_post( $page_id );
    $todasPaginas = array();
 	
    // pega as informacoes do usuario logado
    $user = wp_get_current_user($user_id);

    $post_author_id = get_post_field( 'post_author', $page_id );

    if($post_author_id == $user_id){
        return true;
    }

    // usuarios que ficam foram da regra
	$allowed_roles = array( 'administrator' );
	if ( array_intersect( $allowed_roles, $user->roles ) ) {
        // se estiverem na lista todas as paginas sao permitidas para edicao
        return true;
    }
    $variable = array();
    // pega o grupo que o usuario pertence
    $variable = get_field('grupo', 'user_' . $user_id);

    // verifica se esta liberado para editar todas paginas
    if($variable && $variable != ''){
        foreach($variable as $permitido){
            $todasPaginas[] = get_field('todas_as_paginas', $permitido);            
        }
    }

    

    $liberar = 1;

	if(in_array($liberar, $todasPaginas) && $todasPaginas != ''){
		return true;
	} else {	
        
        $permitidas = array();
        

        $dres_open = array();
        if($variable){
            foreach($variable as $dre){
                $dres_open[] = get_field('dre', $dre);
            }
        }
        

        $dres_open = array_flatten($dres_open);
        $dres_open = array_unique($dres_open);
        
        $dre_publi = get_field('dre_selected', $id_pot);
        
        
        //echo "<pre>";
        //print_r($dre_publi);
        //echo "</pre>";

        //$result = array_merge($unidades, $id_pot);

        // se a pagina corrente esta na lista de paginas do grupo libera para edicao
        if( in_array($dre_publi, $variable) ||  in_array($dre_publi['value'], $variable)){
			return true;
		} else {
			return false;
		}
	} 
	
 }

 //
 add_filter( 'map_meta_cap', function ( $caps, $cap, $user_id, $args ) {

    global $post;
    
    if(isset($post->post_type)){
        if ($post->post_type == 'attachment'){
            return $caps;
        }

        if ($post->post_type == 'transporte'){
            return $caps;
        }
    } 

    // capability atribuida
    $to_filter = [ 'edit_post', 'delete_post', 'edit_page', 'delete_page', 'edit_contato', 'delete_contato' ];

    // If the capability being filtered isn't of our interest, just return current value
    if ( ! in_array( $cap, $to_filter, true ) ) {
        return $caps;
    }

    // First item in $args array should be page ID
    if ( ! $args || empty( $args[0] ) || ! wpse_user_can_edit( $user_id, $args[0] ) ) {
        // User is not allowed, let's tell that to WP
        return [ 'do_not_allow' ];
    }
    // Otherwise just return current value
    return $caps;

}, 10, 4 );

add_filter('manage_editores_portal_posts_columns', function($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'DRE',                    
    );
	$columns = array_merge($columns, ['qtd_total' => __('Total de ônibus', 'textdomain')]);
	$columns = array_merge($columns, ['qtd_dispo' => __('Ônibus disponíveis', 'textdomain')]);
    unset($columns['date']); 
    return $columns;
});
 
add_action('manage_editores_portal_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'qtd_total') {
		$qtd_total = get_post_meta($post_id, 'qtd_onibus', true);
		echo $qtd_total;
	}

    if ($column_key == 'qtd_dispo') {
		$qtd_disponivel = get_post_meta($post_id, 'qtd_disponivel', true);
		echo $qtd_disponivel;
	}
}, 10, 2);

add_action( 'admin_notices', 'export_bus' );
function export_bus() {
    global $typenow;
    if ($typenow == 'editores_portal') {

        global $_GET;        

        ?>

        <div class="alignright">
            <form method='get' action="<?= get_template_directory_uri(); ?>/export-grupos.php">
				<?php if($_GET['s'] && $_GET['s'] != ''): ?>
					<input type="hidden" name="s" value="<?= $_GET['s']; ?>">
				<?php endif; ?>				
                <input type="submit" name='export' class="button button-primary button-large button-export" id="xlsxExport" value="Exportar"/>
            </form>
        </div>

        <?php
    }
}