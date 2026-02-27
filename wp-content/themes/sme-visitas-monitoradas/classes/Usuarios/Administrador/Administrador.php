<?php

namespace Classes\Usuarios\Administrador;


class Administrador
{
	const ROLE = 'administrator';
	private $role_object;

	public function __construct()
	{
		$this->getRole();
		$this->addCap();
		add_action('admin_init', array($this, 'escondeMenu' ));
	}

	public function getRole(){
		// get the the role object
		if (current_user_can(self::ROLE)) {
			$this->role_object = get_role(self::ROLE);
		}
	}

	public function addCap(){

		// add $cap capability to this role object
		if (current_user_can(self::ROLE)) {
			$this->role_object->add_cap('edit_theme_options');

			$this->role_object->add_cap( 'read' );

			$this->role_object->add_cap( 'read_card');
			$this->role_object->add_cap( 'read_private_cards' );
			$this->role_object->add_cap( 'edit_card' );
			$this->role_object->add_cap( 'edit_cards' );
			$this->role_object->add_cap( 'edit_others_cards' );
			$this->role_object->add_cap( 'edit_published_cards' );
			$this->role_object->add_cap( 'publish_cards' );
			$this->role_object->add_cap( 'delete_card' );
			$this->role_object->add_cap( 'delete_others_cards' );
			$this->role_object->add_cap( 'delete_private_cards' );
			$this->role_object->add_cap( 'delete_published_cards' );
			$this->role_object->add_cap( 'manage_cards' );
			$this->role_object->add_cap( 'edit_cards' );
			$this->role_object->add_cap( 'delete_cards' );
			$this->role_object->add_cap( 'assign_cards' );
			
			$this->role_object->add_cap( 'read_contato');
			$this->role_object->add_cap( 'read_private_contatos' );
			$this->role_object->add_cap( 'edit_contato' );
			$this->role_object->add_cap( 'edit_contatos' );
			$this->role_object->add_cap( 'edit_others_contatos' );
			$this->role_object->add_cap( 'edit_published_contatos' );
			$this->role_object->add_cap( 'publish_contatos' );
			$this->role_object->add_cap( 'delete_contato' );
			$this->role_object->add_cap( 'delete_others_contatos' );
			$this->role_object->add_cap( 'delete_private_contatos' );
			$this->role_object->add_cap( 'delete_published_contatos' );
			$this->role_object->add_cap( 'manage_contatos' );
			$this->role_object->add_cap( 'edit_contatos' );
			$this->role_object->add_cap( 'delete_contatos' );
			$this->role_object->add_cap( 'assign_contatos' );

			$this->role_object->add_cap( 'read_botao');
			$this->role_object->add_cap( 'read_private_botoes' );
			$this->role_object->add_cap( 'edit_botao' );
			$this->role_object->add_cap( 'edit_botoes' );
			$this->role_object->add_cap( 'edit_others_botoes' );
			$this->role_object->add_cap( 'edit_published_botoes' );
			$this->role_object->add_cap( 'publish_botoes' );
			$this->role_object->add_cap( 'delete_botao' );
			$this->role_object->add_cap( 'delete_others_botoes' );
			$this->role_object->add_cap( 'delete_private_botoes' );
			$this->role_object->add_cap( 'delete_published_botoes' );
			$this->role_object->add_cap( 'manage_botoes' );
			$this->role_object->add_cap( 'edit_botoes' );
			$this->role_object->add_cap( 'delete_botoes' );
			$this->role_object->add_cap( 'assign_botoes' );

			$this->role_object->add_cap( 'manage_imagens' );
			$this->role_object->add_cap( 'edit_imagens' );
			$this->role_object->add_cap( 'delete_imagens' );
			$this->role_object->add_cap( 'assign_imagens' );

			$this->role_object->add_cap( 'delete_users' );
			$this->role_object->add_cap( 'create_users' );
			$this->role_object->add_cap( 'list_users' );
			$this->role_object->add_cap( 'remove_users' );

			$this->role_object->add_cap( 'read_concurso');
			$this->role_object->add_cap( 'read_private_concursos' );
			$this->role_object->add_cap( 'edit_concurso' );
			$this->role_object->add_cap( 'edit_concursos' );
			$this->role_object->add_cap( 'edit_others_concursos' );
			$this->role_object->add_cap( 'edit_published_concursos' );
			$this->role_object->add_cap( 'publish_concursos' );
			$this->role_object->add_cap( 'delete_concurso' );
			$this->role_object->add_cap( 'delete_others_concursos' );
			$this->role_object->add_cap( 'delete_private_concursos' );
			$this->role_object->add_cap( 'delete_published_concursos' );
			$this->role_object->add_cap( 'manage_concursos' );
			$this->role_object->add_cap( 'edit_concursos' );
			$this->role_object->add_cap( 'delete_concursos' );
			$this->role_object->add_cap( 'assign_concursos' );

			$this->role_object->add_cap( 'add_users' );
			$this->role_object->add_cap( 'promote_users' );
			$this->role_object->add_cap( 'enroll_users' );
			$this->role_object->add_cap( 'manage_network_users' );
		}
	}

	
	public function escondeMenu(){

		$usuario = wp_get_current_user();

		if ($usuario->roles[0] === self::ROLE) {

			$menu_completo = get_field('menu_completo', 'user_'. $usuario->data->ID );

			if(!$menu_completo){
				remove_menu_page('edit.php'); // Posts
				remove_menu_page('upload.php'); // Midia
				remove_menu_page('edit.php?post_type=acf-field-group'); // Paginas
				remove_menu_page( 'wpcf7' );
				remove_menu_page('edit-comments.php');
				remove_menu_page('tools.php');
				remove_menu_page('themes.php');
				remove_menu_page( 'plugins.php' );
				remove_menu_page( 'options-general.php' );
				remove_menu_page( 'loco' );
				remove_menu_page( 'WP-Optimize' );
				remove_menu_page( 'wp-mail-smtp' );
				remove_menu_page( 'loginwp-settings' );
				remove_menu_page( 'flamingo' );
				remove_menu_page( 'tutorial_slug' );
				remove_menu_page( 'acf-options-alerta-da-pagina-inicial' );
			}

		}

	}

}

new Administrador();