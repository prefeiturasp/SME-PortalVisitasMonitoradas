<?php

namespace Classes\Cpt;


class CptCadastroTransporte extends Cpt
{
    public function __construct(){
        $this->cptSlug = self::getCptSlugExtend();
        $this->name = self::getNameExtend();
        $this->todosOsItens = self::getTodosOsItensExtend();
        $this->dashborarIcon = self::getDashborarIconExtendExtend();

        add_action('init', array($this, 'register'));

        //Alterando e Exibindo as colunas no Dashboard que vem por padrão na classe CPT
        //add_filter('manage_posts_columns', array($this, 'exibe_cols'), 10, 2);

        add_filter('manage_' . $this->cptSlug . '_posts_columns', function($columns) {
            if ($post_type == $this->cptSlug) {
                unset($cols['tags'], $cols['author'],$cols['categories'],$cols['comments'], $cols['categoria'], $cols['featured_thumb']);
            }
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => 'Nome da empresa',
                'telefone' => 'Telefone da empresa',
                'date' => 'Data',              
            );
    
            return $columns;
        });

        add_action('manage_' . $this->cptSlug . '_posts_custom_column', array($this, 'cols_content'));
        add_filter('manage_edit-' . $this->cptSlug . '_sortable_columns', array($this, 'cols_sort'));
        add_filter('request', array($this, 'orderby'));
    }


    //Exibindo as informações correspondentes de cada coluna
	public function cols_content($col)
	{
		global $post;
		switch ($col) {
			case 'telefone':
				$telefone = get_field('telefone', $post->ID);
				echo $telefone;
				break;
			
		}
	}


    /**
     * Alterando as configurações que vem por padrão na classe CPT (Adicionando suporte a thumbnail)
     */
    public function register()
    {
        $labels = array(
            'name' => _x($this->name, 'post type general name'),
            'singular_name' => _x($this->name, 'post type singular name'),
            'all_items' => _x( $this->todosOsItens, 'Admin Menu todos os itens'),
            'add_new' => _x('Cadastrar Transporte ', 'Novo item'),
            'add_new_item' => __('Novo cadastro'),
            'edit_item' => __('Editar cadastro'),
            'new_item' => __('Novo cadastro'),
            'view_item' => __('Ver cadastro'),
            'search_items' => __('Procurar cadastros'),
            'not_found' => __('Nenhum cadastro encontrado'),
            'not_found_in_trash' => __('Nenhum cadastro encontrado na lixeira'),
            'parent_item_colon' => '',
            'menu_name' => $this->name
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'public_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'transporte', 'with_front' => false ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon'   => 'dashicons-car',
            'exclude_from_search' => true,
            'show_in_rest' => true,
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('revisions'),
        );

        register_post_type($this->cptSlug, $args);
        
        remove_post_type_support( $this->cptSlug, 'editor' );

        flush_rewrite_rules();
    }
}