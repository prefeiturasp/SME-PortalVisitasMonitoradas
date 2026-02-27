<?php

namespace Classes\TemplateHierarchy\LoopParceiro;

class LoopParceiroCabecalho extends LoopParceiro
{

	public function __construct()
	{
		$this->cabecalhoDetalheParceiro();
	}

	public function cabecalhoDetalheParceiro(){
		?>
			<div class="bg-cabecalho">
				<div class="container">
					<div class="row">

						<div class="col-12">
							<div class="logo-part">
								<?php 
									$logo = get_field('foto_principal_parceiro');
									$img_url = '';
									if(is_numeric($logo)){
										$img_url = wp_get_attachment_image_url($logo, 'parceiros');
									} else {
										$img_url = $logo;
									}
								?>
								<img src="<?= $img_url; ?>" alt="logo <?= get_the_title(); ?>">
							</div>
						</div>

						<div class="col-md-5">

							<div class="title-event">
								<h1 class="bannerhome-title"><?= get_the_title(); ?></h1>
							</div>

							<div class="row bannerhome-infoline mt-2">
								<div class="col-sm-12">						
									<?php
										$logradouro = get_field('logradouro_parceiro');
										$numero = get_field('numero_parceiro');
										$bairro = get_field('bairro_parceiro');
										$cidade = get_field('cidade_parceiro');
									?>
									<div class="infoline-ajust">
										<img src="<?= get_template_directory_uri(); ?>/classes/assets/img/map-pin.png" alt="icone mapa"> 
										<span class="info-local-banner"><?= "$logradouro, $numero - $bairro - $cidade"; ?></span>
									</div>
								</div>
							</div>
							

						</div>

						<div class="col-md-6 offset-md-1 infos-part">
							<?php
								$site = get_field('site_do_parceiro');
								$face = get_field('url_facebook_parceiro');
								$insta = get_field('url_instagram_parceiro');
								$tel = get_field('telefone_parceiro');
							?>
							<?php if($site): ?>
								<p><a href="<?= $site; ?>" target="_blank"><?= $site; ?></a></p>
							<?php endif; ?>

							<?php if($face || $insta): ?>
								<p class="social">
									<?php if($face): ?>
										<a href="<?= $face; ?>" target="_blank">Facebook</a>
									<?php endif; ?>

									<?php if($insta): ?>
										&nbsp;<a href="<?= $insta; ?>" target="_blank">Instagram</a>
									<?php endif; ?>
								</p>
							<?php endif; ?>

							<?php if($tel): ?>
								<p><?= $tel; ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>				
			</div>
		<?php
       
	}
}