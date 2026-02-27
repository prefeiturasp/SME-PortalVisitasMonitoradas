<?php get_header(); ?>

<div class="container-fluid p-0 mb-5">
	<form action="<?= get_home_url(); ?>">
		<div class="filtro-busca">
		<div class="filter-sidebar">
			<div class="container">
				<div class="row my-3 mx-0">
					<div class="col-12 text-left"><span class="btn-filtros-close"><img src="https://visitas.rafaelhsouza.com.br/img/fechar.png" alt="Fechar"> Fechar</span></div>
				</div>
				<div class="row mt-4 mb-3">
					<div class="col-12 mt-3 mb-2"><h3 class="title-top-filter">Filtro Avançado</h3></div>
					<div class="col-12 mt-3 mb-2">
						<h4 class="title-ad-filter">Tipos de transporte</h4>
						<select class="form-control" id="tipodetransporte" multiple="multiple" name="tipodetransporte[]">
							<?php
							$tipo_transportes = get_terms( array(
								'taxonomy' => 'tipo-transporte',
								'hide_empty' => false,
							) );
							$transportes = $_GET['tipodetransporte'];
							foreach ($tipo_transportes as $tipo_transporte){
								?>
									<?php if(in_array($tipo_transporte->slug, $transportes)): ?>
										<option value="<?php echo $tipo_transporte->slug; ?>" selected><?php echo $tipo_transporte->name; ?></option>
									<?php else: ?>
										<option value="<?php echo $tipo_transporte->slug; ?>"><?php echo $tipo_transporte->name; ?></option>
									<?php endif; ?>
								<?php
							}
							?>
						</select>
					</div>
					<div class="col-12 mt-3 mb-2">
						<h4 class="title-ad-filter">Gênero</h4>
						<select class="form-control" id="tipogenero"  multiple="multiple" name="tipogenero[]">
							<?php
							$generos = get_terms( array(
								'taxonomy' => 'genero',
								'hide_empty' => false,
							) );
							$generosSelect = $_GET['tipogenero'];
							foreach ($generos as $genero){
								?>
								<?php if(in_array($genero->slug, $generosSelect)): ?>
										<option value="<?php echo $genero->slug; ?>" selected><?php echo $genero->name; ?></option>
									<?php else: ?>
										<option value="<?php echo $genero->slug; ?>"><?php echo $genero->name; ?></option>
									<?php endif; ?>
								
								<?php
							}
							?>
						</select>
					</div>
					<div class="col-12 mt-3 mb-2">
						<h4 class="title-ad-filter">Tipo de evento</h4>
						<select class="form-control" id="tipoevento"  multiple="multiple" name="tipoevento[]">
							
							<option value="escola" <?php if(in_array('escola', $_GET['tipoevento'])){ echo 'selected';} ?>>Cultura Visita</option>
							<option value="externo" <?php if(in_array('externo', $_GET['tipoevento'])){ echo 'selected';} ?>>Visitas Monitoradas</option>
								
						</select>
					</div>					
					<div class="col-12 mt-3 mb-2">
						<h4 class="title-ad-filter">Acessibilidade</h4>
						<div class="custom-control custom-checkbox">
							<?php if($_GET['acessivel']): ?>
								<input type="checkbox" id="eventosacessiveis" name="acessivel" class="custom-control-input" checked>
							<?php else: ?>
								<input type="checkbox" id="eventosacessiveis" name="acessivel" class="custom-control-input">
							<?php endif; ?>
							<label class="custom-control-label" for="eventosacessiveis">Eventos acessíveis</label>
						</div>
					</div>
					<div class="col-12 mt-4 mb-2">
						<button type="button" class="btn-limpar-filtros">Limpar filtros</button>
						<button type="submit" class="btn-aplicar-filtros">Aplicar filtros</button>
					</div>
				</div>
			</div>
		</div>
		<div class="container mt-5 mb-5">
			<div class="row">
				<div class="col-sm-10">
					<div class="row mb-2 form-input">
						<div class="col-sm-3 pr-2 pl-2">
							<div class="form-group icon-group">
								<span class="icon-control icon-control-busca"></span>
								<input type="text" class="form-control icon-control-inpt" placeholder="Busque um evento" name="s">
							</div>
						</div>
						<div class="col-sm-3 pr-2 pl-2">
							<div class="form-group icon-group">
								<i class="fa fa-map-o icon-control" aria-hidden="true"></i>
								<input type="text" id="TipoParceiros" class="form-control icon-control-inpt" placeholder="Busque por parceiro" name="parceiro" value="<?= $_GET['parceiro']; ?>">
								
							</div>
						</div>
						<div class="col-sm-3 pr-2 pl-2">
							<div class="form-group icon-group" >
								<span class="icon-control icon-control-calendario"></span>
								<input type="text" id="inputDate" class="form-control icon-control-inpt" placeholder="Quando?" name="data" value="<?= $_GET['data']; ?>">
							</div>
						</div>
						<div class="col-sm-3 pr-2 pl-2">
							<div class="form-group icon-group">
								<span class="icon-control icon-control-classificacao"></span>
								<select class="form-control icon-control-inpt" id="exampleFormControlSelect1" name="classificacao">
									<option selected value=''>Classificação</option>
									<?php
									$faixaetarias = get_terms( array(
										'taxonomy' => 'faixa-etaria',
										'hide_empty' => false,
									) );
									foreach ($faixaetarias as $faixa_etaria){
										if($faixa_etaria->slug == $_GET['classificacao']):

										
									?>
										
										<option value="<?php echo $faixa_etaria->slug; ?>" selected><?php echo $faixa_etaria->name; ?></option>
										<?php
										else:
											?>
											<option value="<?php echo $faixa_etaria->slug; ?>"><?php echo $faixa_etaria->name; ?></option>
										<?php
										endif;
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 pr-2 pl-2">
							<span class="pill-all">Todos</span>
							<?php
							$tipo_espacos = get_categories('taxonomy=tipo-espaco&type=evento');
							$espacos = array_filter($_GET['espaco']);

							foreach ($tipo_espacos as $tipo_espaco){
								$termoidimage = $tipo_espaco->taxonomy . '_' . $tipo_espaco->term_id;
								$imageTax = get_field('icone_tax', $termoidimage);
								?>
								<?php if(in_array($tipo_espaco->slug, $espacos)): ?>

									<span class="pill-one pill-icon active-pill" data-local="<?php echo $tipo_espaco->slug; ?>">
										<img src="<?php echo $imageTax; ?>" alt="<?php echo $tipo_espaco->slug; ?>">
										<?php echo $tipo_espaco->name; ?>
										<input type="hidden" name="espaco[]" value='<?php echo $tipo_espaco->slug; ?>' id="<?php echo $tipo_espaco->slug; ?>">
									</span>

								<?php else: ?>

									<span class="pill-one pill-icon" data-local="<?php echo $tipo_espaco->slug; ?>">
										<img src="<?php echo $imageTax; ?>" alt="<?php echo $tipo_espaco->slug; ?>">
										<?php echo $tipo_espaco->name; ?>
										<input type="hidden" name="espaco[]" value='' id="<?php echo $tipo_espaco->slug; ?>">
									</span>

								<?php endif; ?>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="row">
						<div class="col-sm-12 mb-2 text-right pr-0 pl-0">
							<button type="submit" class="btn-buscar">Buscar eventos</button>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-right pr-0 pl-0">
							<span class="btn-filtros"><img src="https://visitas.rafaelhsouza.com.br/img/filtro.png" alt="Filtros">Filtros</span>
						</div>
					</div>
				</div>
			</div>

		</div>
		</div>
	</form>
</div>

    <div class="container">
        <div class="row">
		
			<?php //if($_GET['s'] && $_GET['s'] != ''): ?>

				<?php
					$paged = get_query_var('paged') ? get_query_var('paged') : 1;					
						
					$args = array(
						'post_type' => 'evento',
						'posts_per_page' => 12,
						'paged' => $paged,
						'tax_query'	=> array(),
						'order' => 'ASC',
						'orderby'       => 'meta_value_num',
        				'meta_key'      => 'data', //ACF date field
						'meta_query' => array(
							'relation' => 'AND',
							
						)
					);

					if($_GET['s'])
						$args['s'] = $_GET['s'];

					$parceiro = $_GET['parceiro'];

					if($parceiro && $parceiro != ''){
						$idParceiros = array();
						$the_query = new WP_Query( 
							array( 
							  'posts_per_page' => -1, 
							  's' => esc_attr( $parceiro ), 
							  'post_type' => 'parceiros' 
							) 
						);

						if( $the_query->have_posts() ) :
							while( $the_query->have_posts() ): $the_query->the_post();
								$idParceiros[] = get_the_ID();
							endwhile;
							wp_reset_postdata();  
						endif;

						$args['meta_query'][] = array(
							'key'   => 'parceiro',
							'value' => $idParceiros,
						);
					}

					$data = $_GET['data'];

					if($data && $data != ''){
						$searchData = explode('/', $data);
						$dtInicial = $searchData[1] . '-' . $searchData[0] . '-01';
						$dtFinal = $searchData[1] . '-' . $searchData[0] . '-31';
						

						$args['meta_query'][] = array(
							'key' => 'data', // Check the start date field
							'value' => date($dtInicial), // Set today's date (note the similar format)
							'compare' => '>=', // Return the ones greater than today's date
							'type' => 'DATE' // Let WordPress know we're working with date
						);
						$args['meta_query'][] = array(
							'key' => 'data', // Check the start date field
							'value' => date($dtFinal), // Set today's date (note the similar format)
							'compare' => '<=', // Return the ones greater than today's date
							'type' => 'DATE' // Let WordPress know we're working with date
						);
					}

					if($_GET['classificacao'] && $_GET['classificacao'] != '')
						$args['tax_query'][] = array(							
								'taxonomy' => 'faixa-etaria',   // taxonomy name
								'field' => 'slug',           // term_id, slug or name
								'terms' => $_GET['classificacao'], 
						);

					$espacos= array_filter($_GET['espaco']);
					if($espacos)
						$args['tax_query'][] = array(							
								'taxonomy' => 'tipo-espaco',   // taxonomy name
								'field' => 'slug',           // term_id, slug or name
								'terms' => $espacos, 	
						);

					if($_GET['tipodetransporte'] && $_GET['tipodetransporte'] != '')
						$args['tax_query'][] = array(							
								'taxonomy' => 'tipo-transporte',   // taxonomy name
								'field' => 'slug',           // term_id, slug or name
								'terms' => $_GET['tipodetransporte'], 
						);

					if($_GET['tipogenero'] && $_GET['tipogenero'] != '')
						$args['tax_query'][] = array(							
								'taxonomy' => 'genero',   // taxonomy name
								'field' => 'slug',           // term_id, slug or name
								'terms' => $_GET['tipogenero'], 
						);
					
					if($_GET['acessivel'] && $_GET['acessivel'] != '')
						$args['meta_query'][] = array(
							'key'   => 'evento_acessivel',
							'value' => '1',
						);

					if($_GET['tipoevento'] && $_GET['tipoevento'] != '')
						$args['meta_query'][] = array(
							'key'   => 'tipo_do_evento',
							'value' => $_GET['tipoevento'],
						);
						

					//echo "<pre>";
					//print_r($espacos);
					//echo "</pre>";
					


					// The Query
					$the_query = new WP_Query( $args );
					
					// The Loop
					if ( $the_query->have_posts() ) {
						
						while ( $the_query->have_posts() ) :
							$the_query->the_post();
						?>
							<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
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
						endwhile;
					?>
						<div class="container my-5">
							<div class="row">
								<div class="col-sm-12">
									<div class="pagination-prog text-center">
										<?php wp_pagenavi( array( 'query' => $the_query ) ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php
						//wp_pagenavi();
					} else {
					?>
						<div class="container">
							<h2 class="text-center mb-4">0 resultados encontrados</h2>
							<img src="https://acervodigital.sme.prefeitura.sp.gov.br/wp-content/themes/acervodigital/images/search-empty.png" alt="nenhum resultado encontrado" class="d-block mb-5" style="margin: 0 auto;">
						</div>

					<?php
					}
					/* Restore original Post Data */
					wp_reset_postdata();
				
				?>
				

			<?php //else: ?>
				
			<?php //endif; ?>

        </div>
    </div>
<?php get_footer(); ?>