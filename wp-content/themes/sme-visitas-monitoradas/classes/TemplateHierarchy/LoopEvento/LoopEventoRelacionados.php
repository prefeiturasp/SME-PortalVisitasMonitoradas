<?php
namespace Classes\TemplateHierarchy\LoopEvento;
class LoopEventoRelacionados extends LoopEvento
{
	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		$this->montaHtmlEventoRelacionados();
	}
	public function montaHtmlEventoRelacionados(){
	?>

<?php
$idTaxEvento = get_sub_field('escolha_evento');
$term = get_term( $idTaxEvento );
$id_current = get_the_id();
?>
<div class="container mt-5 mb-5">
    <?php
    $parceiro = get_field('parceiro');
	$arrow_query = new \WP_Query( array(
		'posts_per_page' => 10,
		'post_type'      => 'evento',
		'orderby' => 'date',
		'order' => 'ASC',
		"meta_key" => "parceiro",
		"meta_value" => $parceiro,
		'post__not_in' => [$id_current]
	) );
    $count_arrow = 0;
    while ( $arrow_query->have_posts() ) : $arrow_query->the_post();
        $count_arrow++;
    endwhile;
    wp_reset_postdata();
    ?>

	<?php if($count_arrow > 0): ?>

		<div class="row mt-2 mb-2">
			<div class="carousel-multiple-title col-sm-6">
				<h2 class="title-carousel-eventos">Eventos relacionados</h2>
			</div>
			<div class="col-sm-6 text-right">
				<a class="<?php if($count_arrow < 5){ echo 'd-none';} ?>" href="#<?php echo $term->slug; ?>" data-slide="prev">
					<img src="/wp-content/uploads/2022/07/arrow-left.png" alt="esquerda">
				</a>
				<a class="<?php if($count_arrow < 5){ echo 'd-none';} ?>" href="#<?php echo $term->slug; ?>" data-slide="next">
					<img src="/wp-content/uploads/2022/07/arrow-right.png" alt="direita">
				</a>
			</div>
		</div>
		<div class="row mt-2 mb-3">
			<div class="divhr mt-2 mb-2"></div>
		</div>
		<div class="p-3 m-n3 overflow-hidden">
			<div id="<?php echo $term->slug; ?>" class="carousel <?php echo $term->slug; ?> slide carousel-multiple" data-ride="carousel" data-interval="<?php if($count_arrow < 5){ echo 'd-none';}else{echo '99999';} ?>" data-pause="hover"
				data-maximum-items-per-slide="4">
				<div class="row position-relative">
					<div class="row carousel-inner mx-0">
						<?php
						if( have_rows('construtor_home') ):
							while ( have_rows('construtor_home') ) : the_row();
								if( get_row_layout() == 'adicionar_evento'):
									echo get_sub_field('carousel_eventos_home').'<br>';
									echo '<hr>';
								elseif( get_row_layout() == 'adiconar_newsletter'):
									echo get_sub_field('titulo').'<br>';
									echo '<hr>';
								endif;
							endwhile;
						endif;
						$parceiro = get_field('parceiro');
						$new_query = new \WP_Query( array(
							'posts_per_page' => 10,
							'post_type'      => 'evento',
							'orderby' => 'date',
							'order' => 'ASC',
							"meta_key" => "parceiro",
							"meta_value" => $parceiro,
							'post__not_in' => [$id_current]
						) );
						$count_evento = 0;
						while ( $new_query->have_posts() ) : $new_query->the_post();
							?>
							<div class="carousel-item col-sm-6 col-md-4 col-lg-3 <?php if($count_evento === 0){echo 'active';} ?>">
							<div class="content-carousel">
										<div class="content-carousel-img">
											<?php
												$imagem = get_field('foto_do_evento');
												$showImage = $imagem['sizes']['home-thumb'];
												if(!$showImage){
													$showImage = 'http://via.placeholder.com/250x241';
												}
											?>
											<img class="img-capa" src="<?= $showImage; ?>" alt="<?php echo the_title(); ?>">
										</div>
										<div class="inner-content-carousel">
											<?php
												$datas = get_field('agenda');

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
																					
											?>
											<div class="data-content-carousel mt-2 mb-2"><?= $dataNum . ' - ' . $mes;	; ?></div>
											<div class="title-content-carousel mt-2 mb-2"><?php the_title(); ?></div>
											<?php
												$parceiro = get_field('parceiro');
												$nomeParceiro = get_the_title($parceiro);
												$bairroParceiro = get_field('bairro_parceiro', $parceiro);
											?>
											<?php if($parceiro): ?>
												<div class="desc-content-carousel mt-2 mb-2"><?= $nomeParceiro . ', ' . $bairroParceiro; ?></div>
											<?php endif; ?>
											
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
													// Faixa Etaria
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
															<span class="pill-out">
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
													<span class="pill-out">
														<img src="/wp-content/uploads/2022/07/busque-por-parceiro.png" alt="<?= $transporte->name; ?>">
														<?= $transporte->name; ?>
													</span>
												<?php endif; ?>
											</div>
											
											<a href="<?= get_the_permalink(); ?>" class="btn visitas-btn btn-block">inscreva-se</a>
										</div>
									</div>
							</div>
							<?php
							$count_evento++;
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
		</div>

	<?php endif; ?>
	
</div>
<script>
    jQuery(function () {
        jQuery(".<?php echo $term->slug; ?>").on("slide.bs.carousel", function (e) {
            var itemsPerSlide = parseInt(jQuery(this).attr('data-maximum-items-per-slide')),
                totalItems = jQuery(".carousel-item", this).length,
                reserve = 1,//do not change
                $itemsContainer = jQuery(".carousel-inner", this),
                it = (itemsPerSlide + reserve) - (totalItems - e.to);

            if (it > 0) {
                for (var i = 0; i < it; i++) {
                    jQuery(".carousel-item", this)
                        .eq(e.direction == "left" ? i : 0)
                        // append slides to the end/beginning
                        .appendTo($itemsContainer);
                }
            }
        });
    });
</script>



	<?php
	}	
}