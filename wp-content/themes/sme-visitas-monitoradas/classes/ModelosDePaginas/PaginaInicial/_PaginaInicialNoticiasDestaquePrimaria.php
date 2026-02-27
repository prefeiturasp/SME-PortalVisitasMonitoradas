<?php

namespace Classes\ModelosDePaginas\PaginaInicial;


class PaginaInicialNoticiasDestaquePrimaria extends PaginaInicial
{

	public function __construct()
	{
		$this->montaQueryNoticiasHomePrincipal();
		$this->montaHtmlLoopNoticiaPrincipal();

	}

	public function montaQueryNoticiasHomePrincipal()
	{
		$this->args_noticas_home_principal = array(
			'post_type' => 'post',
			'meta_query' => array(
				//'relation' => '', // Optional argument.
				array(
					'relation' => 'AND',
					array(
						'key'	 	=> 'deseja_que_este_post_apareca_na_home',
						'value'	  	=> 'sim',
						'compare' 	=> '=',
					),
					array(
						'key'	  	=> 'posicao_de_destaque_deste_post',
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
				)
			),
			'orderby' => 'date',
			'order' => 'DESC',
			'cat' => $this->getCamposPersonalizados('escolha_a_categoria_de_noticias_a_exibir')->term_id,
			'posts_per_page' => 1,
		);
		$this->query_noticias_home_principal = new \WP_Query($this->args_noticas_home_principal);

	}

	public function montaHtmlLoopNoticiaPrincipal()
	{
		echo '<section class="col-lg-6 col-xs-12 mb-xs-4">';
		if ($this->query_noticias_home_principal->have_posts()) : while ($this->query_noticias_home_principal->have_posts()) : $this->query_noticias_home_principal->the_post();
			$this->id_noticias_home_principal = get_the_ID();

			$post_thumbnail_id = get_post_thumbnail_id( $this->id_noticias_home_principal );
			$image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);
			$image_url = get_the_post_thumbnail_url();
			?>

            <article class="card h-100 rounded border-0">
				<?php if (has_post_thumbnail()) {
					echo '<figure class="mb-0">';
					echo '<img width="740" height="350" class="card-img desc-img-home" src="'.$image_url.'" alt="'.$image_alt.'"/>';
					echo '</figure>';
				} else {
					echo '<figure>';
					echo '<img src="https://dummyimage.com/535x325/4F4F4F/4F4F4F" class="card-img" alt="Imagem de Exemplo">';
					echo '</figure>';
				}
				?>
                <article class="card-img-overlay bg-home-desc h-auto rounded-bottom container-img-noticias-destaques-primaria">
                    <h3 class="fonte-catorze font-weight-bold">
                        <a class="text-white" href="<?= get_the_permalink() ?>">
							<?= get_the_title() ?>
                        </a>
                    </h3>


					<?php
					if ($this->getSubtitulo(get_the_ID(), 'p') ){
						echo '<section class="card-text text-white fonte-doze">';
						echo $this->getSubtitulo(get_the_ID(), 'p');
						echo '</section>';
					}
					?>
                </article>
            </article>
		<?php
		endwhile;
		endif;
		echo '</section>';
		wp_reset_postdata();

	}



}