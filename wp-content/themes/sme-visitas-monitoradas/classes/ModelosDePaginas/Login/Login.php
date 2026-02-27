<?php

namespace Classes\ModelosDePaginas\Login;


use Classes\Lib\Util;

class Login extends Util
{
	
	public function __construct()
	{

		$this->montaHtmlLogin();
		//contabiliza visualizacoes de noticias
		//setPostViews(get_the_ID()); /*echo getPostViews(get_the_ID());*/

	}

	public function montaHtmlLogin(){
		$imagem = get_field('imagem');
		?>

		<div class="container-fluid container-forms" style="background-image: url('<?= $imagem; ?>');">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-5 offset-md-7">
						<?php							
							new LoginForm();				
						?>
					</div>
				</div>
			</div>			
		</div>
		<?php
	}
}