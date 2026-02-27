<?php

namespace Classes\TemplateHierarchy\LoopParceiro;

class LoopParceiroCta extends LoopParceiro
{

	public function __construct()
	{
		$this->ctaParceiro();
	}

	public function ctaParceiro(){
		?>
			
			<div class="container">
				<div class="row">

					<div class="col-12">
						<div class="cta-part">
							<h3 class="title-cta">Seja parceiro do Visitas Monitoradas</h3>
							<p>Acesse mais detalhes através do botão abaixo.</p>
							<a href="<?= get_home_url('', 'seja-parceiro'); ?>" class="btn btn-cta">Seja Parceiro</a>
						</div>
					</div>
					
				</div>
			</div>				
			
		<?php
       
	}
}