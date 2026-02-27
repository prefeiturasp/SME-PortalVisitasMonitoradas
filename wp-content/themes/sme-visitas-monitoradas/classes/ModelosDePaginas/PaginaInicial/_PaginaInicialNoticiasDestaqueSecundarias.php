<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialNoticiasDestaqueSecundarias extends PaginaInicial
{

    private $cont;

	public function __construct()
	{
		$noticias_secundarias_tags = array('section');
		$noticias_secundarias_css = array('col-lg-6 col-xs-12');
		$this->abreContainer($noticias_secundarias_tags, $noticias_secundarias_css);
		$this->montaQueryNoticiasHomeSecundarias(2);
		$this->montaHtmlLoopNoticias();
		$this->montaQueryNoticiasHomeSecundarias(3);
		$this->montaHtmlLoopNoticias();
		$this->montaHtmlBotaoMaisNoticias();
		$this->fechaContainer($noticias_secundarias_tags);

		$this->cont = 0;
	}

	public function montaQueryNoticiasHomeSecundarias($posicao_destaque)
	{
		$this->args_noticas_home_secundarias = array(
			'post_type' => 'post',
			'meta_query' => array(
				array(
					'relation' => 'AND',
					array(
						'key'	 	=> 'deseja_que_este_post_apareca_na_home',
						'value'	  	=> 'sim',
						'compare' 	=> '=',
					),
					array(
						'key'	  	=> 'posicao_de_destaque_deste_post',
						'value'	  	=> $posicao_destaque,
						'compare' 	=> 'IN',
					),
				)
			),
			'orderby' => 'date',
			'order' => 'DESC',
			'cat' => $this->getCamposPersonalizados('escolha_a_categoria_de_noticias_a_exibir')->term_id,
			'posts_per_page' => 1,
			'post__not_in' => array($this->id_noticias_home_principal),
		);
		$this->query_noticias_home_secundarias = new \WP_Query($this->args_noticas_home_secundarias);
	}



	public function montaHtmlLoopNoticias()
	{



		if ($this->query_noticias_home_secundarias->have_posts()) : while ($this->query_noticias_home_secundarias->have_posts()) : $this->query_noticias_home_secundarias->the_post();
			$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
			$image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);
			$image_url = get_the_post_thumbnail_url();
			if (!$this->cont){
			    $css_divisao = 'border-bottom';
            }else{
				$css_divisao = '';
            }
			?>

			<article class="row mb-4 b-home <?= $css_divisao?>">

					<?php if (has_post_thumbnail()) {
					    echo '<div class="col-12 col-md-5 mb-1">';
						//the_post_thumbnail('large', array('class' => 'img-fluid rounded float-left mr-4', 'alt'=> $image_alt));
						echo '<img class="img-fluid rounded float-left mr-4 img-noticias-destaques-secundarias desc2-img-home" src="'.$image_url.'" alt="'.$image_alt.'"/>';
						echo '</div>';
					}
					?>
                    <div class="col-12 col-md-7">
                        <h3 class="fonte-catorze font-weight-bold">
                            <a class="text-dark" href="<?= get_the_permalink() ?>">
                                <?= get_the_title() ?>
                            </a>
                        </h3>
							<?php
							
							?>
                        <?php
						 if ($this->getSubtitulo(get_the_ID(), 'span') ){
                            echo '<section class="fonte-doze">';
							$content = $this->getSubtitulo(get_the_ID(), 'span');
							$resumo = substr($content, 0, 200).'...';
							echo $resumo;
							echo '</section>';
						}	
                        /*if ($this->getSubtitulo(get_the_ID(), 'p') ){
                            echo '<section class="fonte-doze">';
							echo $this->getSubtitulo(get_the_ID(), 'p');
							echo '</section>';
						}*/
                        ?>
                    </div>

			</article>
		<?php
			$this->cont = $this->cont + 1;
		endwhile;
		endif;
		wp_reset_postdata();
		?>

		<?php

	}

}