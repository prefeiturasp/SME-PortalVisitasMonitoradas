<?php

namespace Classes\ModelosDePaginas\Login;

class LoginForm
{

	public function __construct()
	{
		$this->montaHtmlForm();
	}

	public function montaHtmlForm(){
		
		// Se ja estiver conectado
		//if (is_user_logged_in() && !is_admin()):
			//echo "<h2>Você já está conectado!</h2>";
		//else:
		// Inclui o formulario de login
		?>
			<div class='core_login_form'>
				<p class="m-0">Bem-vindas ao</p>
				<h2>Visitas Monitoradas</h2>				
				<?php
					// Mensagem de erro exibida na tela
					$page_showing = basename($_SERVER['REQUEST_URI']);

					if (strpos($page_showing, 'failed') !== false) {
						echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  							<strong>ERRO:</strong> Usuário e/ou senha inválidos.
  							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    						<span aria-hidden="true">&times;</span>
  							</button>
						</div>';
					} elseif (strpos($page_showing, 'blank') !== false ) {						
						echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
							<strong>ERRO:</strong> Usuário e/ou senha estão vazios.
  							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    						<span aria-hidden="true">&times;</span>
  							</button>
						</div>';
					}

					if($_GET['eventoid'] && $_GET['eventoid'] != ''){
						$url = home_url() . '/inscricoes/?eventoid=' . $_GET['eventoid'];
					} else {
						$url = home_url();
					}
				
					$args = array(
					'redirect' => $url, // Apos login redireciona para a home
					'id_username' => 'user', // ID no input de usuario
					'id_password' => 'pass', // ID no input da senha
					'label_username' => __( 'Usuário' ),
					'remember'       => false,
					);
					
					wp_login_form( $args ); // Inclui o formulario de login
					
				?>

			</div>
		<?php
			//endif;		
	}

}