<?php

namespace Classes\TemplateHierarchy\ArchiveAgendaDre;


use Classes\Lib\Util;

class ArchiveAgendaAjaxCalendarioDre extends Util
{
	
    
	public function __construct()
	{
		$this->page_id = get_the_ID();
		
	}

	public function montaHtmlListaEventos(){

		if ($_POST['data_pt_br'] && $_POST['data_event_select']) {

			$data_recebida_ao_clicar = $_POST['data_pt_br'];
			$event_select =  $_POST['data_event_select'];

			if ($data_recebida_ao_clicar && $event_select) {
				$this->montaQueryAgenda($data_recebida_ao_clicar, $event_select);
			}
		}

	}

	public function montaQueryAgenda($data_recebida_ao_clicar, $event_select){
		$id = get_the_ID();
		$count = 0;
		$dateCompare = substr($data_recebida_ao_clicar, 6, 2) . '/' . substr($data_recebida_ao_clicar, 4, 2) . '/' . substr($data_recebida_ao_clicar, 0, 4);
		$args = array(
			'post_type' => 'evento',
			'p' => $event_select,
			//'meta_key'     => 'data_do_evento',
			//'meta_value'   => $data_recebida_ao_clicar, // change to how "event date" is stored
			//'meta_compare' => '=',
			'posts_per_page' => -1
		);
		$query = new \WP_Query( $args );

		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			?>
			<article class="col-lg-12 col-xs-12">
				<div class="agenda mb-4 agenda-new">
										
					<?php
						$eventos = get_field('agenda');
						
						//echo "<pre>";
						//print_r($eventos);
						//echo "</pre>";
					?>
					<?php 
						foreach($eventos as $evento): 
							$data_hora = explode(' ', $evento['data_hora']);
					?>
						
						<?php if($dateCompare == $data_hora[0]) : ?>

							<div class="agenda mb-4 agenda-new <?= $this->page_id; ?>">
								
								<div class="order_hri">
									<?php
										//converte campo hora por extenso para ordenar
										
										echo $hri = date('His',$data_hora[1]);
									?>
								</div>

								<div class="horario d-inline"><?= $data_hora[1]; ?></div> | <?= $evento['convites_disponiveis']; ?> convites disponíveis
								<div class="local"><strong>Status:</strong> <?= $evento['status']; ?></div>
								
							</div>

						<?php 
							$count++;
							endif; ?>

					<?php endforeach; ?>
					
					
					
					<?php //} 
						echo'<script>
						//limpa div a cada click
						jQuery(".agenda-ordenada").html("");
						//ordena por hora
						jQuery(".agenda").sort(function(a, b) {

						  if (a.textContent < b.textContent) {
							return -1;
						  } else {
							return 1;
						  }
						}).appendTo(".agenda-ordenada");
						//oculta campo hora
						jQuery(".order_hri").hide();
						</script>';
						?></div>
				</div>
				
			</article>
		<?php

		endwhile;
		elseif($count == 0):
			echo '<p class="agenda agenda-new"><strong>Não existem eventos cadastrados nesta data</strong></p>';
		else:
			echo '<p class="agenda agenda-new"><strong>Não existem eventos cadastrados nesta data</strong></p>';
		endif;
		wp_reset_postdata();

		if($count == 0){
			echo '<p class="agenda agenda-new"><strong>Não existem eventos cadastrados nesta data</strong></p>';
		}

	}

}