<?php


namespace Classes\Usuarios\Parceiro;

class Parceiro
{

	public function __construct()
	{

		$this->addRole();
		//$this->removeRole();
	}

	public function removeRole(){
		remove_role('parceiro');
	}

	public function addRole(){

		add_role(
			'parceiro',
			__( 'Parceiro' ),
			array(
				'read'         => false,  // true allows this capability
				'edit_posts'   => false,
				'publish_posts' => false
			)
		);
	}

}

new Parceiro();