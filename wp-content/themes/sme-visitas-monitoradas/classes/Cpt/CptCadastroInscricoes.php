<?php

namespace Classes\Cpt;

function convert_dre($dre){
    switch ($dre) {
        case 'dre-bt':
            return "DRE Butantã";
            break;
        case 'dre-cs':
            return "DRE Capela do Socorro";
            break;
        case 'dre-cl':
            return "DRE Campo Limpo";
            break;
        case 'dre-fb':
            return "DRE Freguesia/Brasilândia";
            break;
        case 'dre-gn':
            return "DRE Guaianases";
            break;
        case 'dre-ip':
            return "DRE Ipiranga";
            break;
        case 'dre-it':
            return "DRE Itaquera";
            break;
        case 'dre-jt':
            return "DRE Jaçanã/Tremembé";
            break;
        case 'dre-pe':
            return "DRE Penha";
            break;
        case 'dre-pi':
            return "DRE Pirituba";
            break;
        case 'dre-sa':
            return "DRE Santo Amaro";
            break;
        case 'dre-sma':
            return "DRE São Mateus";
            break;
        case 'dre-smi':
            return "DRE São Miguel";
            break;
        default:
            return $dre;
    }
}

function convert_status($status){
    switch ($status) {
        case 'nova':
            return "Nova inscrição";
            break;
        case 'andamento':
            return "Inscrição em andamento";
            break;
        case 'confirmada':
            return "Inscrição confirmada";
            break;
        case 'negado':
            return "Inscrição negada";
            break;
        default:
           return $status;
    }
}


class CptCadastroInscricoes extends Cpt
{
    public function __construct(){
        $this->cptSlug = self::getCptSlugExtend();
        $this->name = self::getNameExtend();
        $this->todosOsItens = self::getTodosOsItensExtend();
        $this->dashborarIcon = self::getDashborarIconExtendExtend();

        add_action('init', array($this, 'register'));

        //Alterando e Exibindo as colunas no Dashboard que vem por padrão na classe CPT
        //add_filter('manage_' . $this->cptSlug . '_posts_columns', array($this, 'exibe_cols_inscri'), 5, 2);
        

        add_filter('manage_' . $this->cptSlug . '_posts_columns', function($columns) {
            if ($post_type == $this->cptSlug) {
                unset($cols['tags'], $cols['author'],$cols['categories'],$cols['comments'], $cols['categoria'], $cols['featured_thumb']);
            }
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => 'Evento',
                'dre' => 'DRE',
                'ue' => 'Unidade Escolar',            
                'date' => 'Data',
                'transporte' => 'Tipo de transporte',
                'status' => 'Status',
            );
    
            return $columns;
        });

        add_action('manage_' . $this->cptSlug . '_posts_custom_column', array($this, 'cols_content'));
        add_filter('manage_edit-' . $this->cptSlug . '_sortable_columns', array($this, 'cols_sort'));
        add_filter('request', array($this, 'orderby'));
        
    }

    

    //Exibindo as colunas no Dashboard
    public function exibe_cols_inscri($cols, $post_type)
    {

        if ($post_type == $this->cptSlug) {
            unset($cols['tags'], $cols['author'],$cols['categories'],$cols['comments'], $cols['categoria'], $cols['featured_thumb']);
        }
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => 'Evento',
            'dre' => 'DRE',
            'ue' => 'Unidade Escolar',            
            'date' => 'Data',
            'transporte' => 'Tipo de transporte',
            'status' => 'Status',
        );

        return $columns;
			
    }

    //Exibindo as informações correspondentes de cada coluna
	public function cols_content($col)
	{
		global $post;
		switch ($col) {
			case 'ue':
				$ue = get_field('nome_ue', $post->ID);
				echo $ue;
				break;

			case 'dre':
				$dre = get_field('dre_selected', $post->ID);
                if($dre){
                    echo get_the_title($dre);
                }              
                
				break;

			case 'transporte':
				$transporte = get_field('tipo_transporte', $post->ID);
                
				if($transporte == 'dre'){
                    echo "DRE";
                }elseif($transporte == 'parceiro'){
                    echo "Parceiro";
                }elseif($transporte == 'proprio-ue'){
                    echo "Próprio UE";
                }

				break;

            case 'status':
                $status = get_field('status', $post->ID);
                if(is_array($status)){
                    echo $status['label'];
                } else {
                    echo convert_status($status);
                }
                break;
		}
	}

    // Permitindo a ordenação das colunas exibidas no Dashboard
	function cols_sort($cols)
	{
		$cols['data_evento'] = 'Data do Evento';
		$cols['hora_evento'] = 'Hora do Evento';
		$cols['local_evento'] = 'Local do Evento';
		return $cols;
	}

    function orderby($vars)
	{
		if (is_admin()) {
			if (isset($vars['orderby']) && $vars['orderby'] == 'data_evento') {
				$vars['orderby'] = 'menu_order';
			}

			if (isset($vars['orderby']) && $vars['orderby'] == 'hora_evento') {
				$vars['orderby'] = 'menu_order';
			}

			if (isset($vars['orderby']) && $vars['orderby'] == 'local_evento') {
				$vars['orderby'] = 'menu_order';
			}
		}
		return $vars;
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
            'add_new' => _x('Cadastrar Inscrição ', 'Novo item'),
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
            'rewrite' => array( 'slug' => 'agendamento', 'with_front' => false ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon'   => 'dashicons-tickets',
            'exclude_from_search' => false,
            'show_in_rest' => true,
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports' => array('revisions', 'author'),
        );

        register_post_type($this->cptSlug, $args);
        
        remove_post_type_support( $this->cptSlug, 'editor' );

        flush_rewrite_rules();
    }
}