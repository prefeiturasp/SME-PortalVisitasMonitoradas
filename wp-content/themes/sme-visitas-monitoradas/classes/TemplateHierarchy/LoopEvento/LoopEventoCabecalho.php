<?php

namespace Classes\TemplateHierarchy\LoopEvento;

use Classes\TemplateHierarchy\Search\SearchFormSingle;

class LoopEventoCabecalho extends LoopEvento
{

	public function __construct()
	{
		$this->cabecalhoDetalheEvento();
	}

	public function cabecalhoDetalheEvento(){
		?>
			<div class="col-md-5 mt-5">
				
				<div class="title-event">
					<h1 class="bannerhome-title"><?= get_the_title(); ?></h1>
				</div>

				<div class="pills mt-3 mb-3">
					<?php
						// Faixa Etaria
						$faixa = get_field('faixa_etaria');
						$cor = get_field('cor', 'faixa-etaria_'.$faixa->term_id);
						$corTexto = get_field('cor_texto', 'faixa-etaria_'.$faixa->term_id);
						$icone = get_field('icone_tax', 'faixa-etaria_'.$faixa->term_id);
						if(!$icone){
							$icone = "/wp-content/uploads/2022/07/livre.png";
						}
					?>
					<?php if($faixa): ?>
						<span class="pill-out" style="background: <?= $cor; ?>; color: <?= $corTexto; ?>;">
							<img src="<?= $icone; ?>" alt="<?= $faixa->name; ?>">
							<?= $faixa->name; ?>
						</span>
					<?php endif; ?>

					<?php
						// Espacos
						$espacos = get_field('tipo_de_espaco');												
						
					?>
					<?php
						if($espacos):
							foreach($espacos as $espaco):
								$icone = get_field('icone_tax', 'tipo-espaco_'.$espaco->term_id);														
								if(!$icone){
									$icone = "/wp-content/uploads/2022/07/teatro.png";
								}
							?>
								<span class="pill-out espacos">
									<img src="<?= $icone; ?>" alt="<?= $espaco->name; ?>">
									<?= $espaco->name; ?>
								</span>
							<?php
							endforeach;
						endif;
					?>
					
					<?php
						// Tipo Transporte
						$transporte = get_field('tipo_de_transporte');
						//print_r($transporte);										
						
					?>

					<?php if($transporte): ?>
						<span class="pill-out transporte">
							<img src="<?= get_template_directory_uri(); ?>/classes/assets/img/transporte.png" alt="<?= $transporte->name; ?>">
							<?= $transporte->name; ?>
						</span>
					<?php endif; ?>
				</div>

				<div class="infoline-ajust">
					<img src="<?= get_template_directory_uri(); ?>/classes/assets/img/calendar.png" alt="icone calendário"> 
					<span class="info-date-banner">
						
						<?php
							$datas = get_field('agenda', $eventID);

							$dataNum = '';
							$dataNumCompare = array();
							$i = 0;
							foreach($datas as $data){
								if($i == 0 && !in_array(substr($data['data_hora'], 0, 2), $dataNumCompare) ){
									$dataNum .= substr($data['data_hora'], 0, 2);
								} elseif( !in_array(substr($data['data_hora'], 0, 2), $dataNumCompare) ) {
									$dataNum .= ', ' . substr($data['data_hora'], 0, 2);
								}
								$dataNumCompare[] = substr($data['data_hora'], 0, 2);
								$i++;
							}
							$dataNumCompare = array();

							$last = end($datas);
							$lastMont = substr($data['data_hora'], 3, 2);
							$mes = convertMonth($lastMont);
							echo $dataNum . ' - ' . $mes;										
						?> 
					</span>
				</div>

				<div class="row bannerhome-infoline mt-2">					
					<div class="col-12">
						<img src="<?= get_template_directory_uri(); ?>/classes/assets/img/timer-icon.png" alt="icone mapa"> 						
						<span class="info-date-banner">Duração: <?= get_field('duracao_visita', $eventID); ?> horas</span>
					</div>
				</div>

				<div class="row bannerhome-infoline mt-2">
					<?php
						$vagas = 0;
						foreach($datas as $data){
							if($data['status'] == 'Disponível')
								$vagas = $vagas + $data['convites_disponiveis'];
						}

						//echo "<pre>";
						//print_r($vagas);
						//echo "</pre>";
					?>
					<div class="col-12">
						<img src="<?= get_template_directory_uri(); ?>/classes/assets/img/users-icon.png" alt="icone mapa"> 						
						<span class="info-date-banner"><?= $vagas; ?> vagas disponíveis</span>
					</div>
				</div>

				<div class="row bannerhome-infoline mt-2">
					<div class="col-sm-12">						
						<?php
							$parceiro = get_field('parceiro', $eventID);
							$nomeParceiro = get_the_title($parceiro);
							$bairroParceiro = get_field('bairro_parceiro', $parceiro);
						?>
						<div class="infoline-ajust">
							<img src="<?= get_template_directory_uri(); ?>/classes/assets/img/map-pin.png" alt="icone mapa"> 
							<span class="info-local-banner"><?= $nomeParceiro . ', ' . $bairroParceiro; ?></span>
						</div>
					</div>
				</div>
				<?php 
					$inscricoes = get_field('inscricoes'); 
					if($inscricoes):
				?>
						<div class="info-end mt-3">
							<p>Inscrições até <?= $inscricoes; ?> ou até o encerramento das vagas.</p>
						</div>
				<?php
					endif;
				?>
				
				<a href="<?= get_home_url(); ?>/inscricoes/?eventoid=<?= get_the_id(); ?>" class="btn visitas-btn my-4">Fazer inscrição</a>

			</div>

			<div class="col-md-6 offset-md-1">
				<?php 
					$img = get_field('foto_do_evento');
					$alt = $img['alt'];
					if(!$alt)
						$alt = get_the_title();
				?>
				<?php if($img): ?>
					<img src="<?= $img['url'] ?>" alt="<?= $alt; ?>" srcset="">
				<?php endif; ?>
			</div>
		
		<?php
       
	}
}