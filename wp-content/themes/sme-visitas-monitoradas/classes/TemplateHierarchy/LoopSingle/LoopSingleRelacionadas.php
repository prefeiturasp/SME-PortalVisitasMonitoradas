<?php

namespace Classes\TemplateHierarchy\LoopSingle;


class LoopSingleRelacionadas extends LoopSingle
{
	private $id_post_atual;
	protected $args_relacionadas;
	protected $query_relacionadas;

	public function __construct($id_post_atual)
	{
		$this->id_post_atual = $id_post_atual;
		//$this->init();
		$this->my_related_posts();
	}

	/*public function init(){
		$this->getQueryRelacionadas();
		$this->montaHtmlRelacionadas();
		

	}

	public function getQueryRelacionadas(){
		$categories = get_the_category($this->id_post_atual);

		if ($categories) {
			$category_ids = array();
			foreach ($categories as $individual_category) {
				$category_ids[] = $individual_category->term_id;
			}
		}

			$this->args_relacionadas = array(
                'category__in' => $category_ids,
                'posts_per_page' => 5,
                'caller_get_posts'=>1,
				//'orderby'        => 'rand',
                'exclude'=> $this->id_post_atual,
                'post_in'  => get_the_tag_list($this->id_post_atual)
		);
		$this->query_relacionadas = get_posts($this->args_relacionadas);
	}

	public function montaHtmlRelacionadas(){

		$container_mais_noticias_tags = array('section');
		$container_mais_noticias_css = array('col-lg-8 col-sm-12 mt-5');
		$this->abreContainer($container_mais_noticias_tags, $container_mais_noticias_css);
		echo '<h2 class="fonte-vintequatro mb-4 pb-2 font-weight-bold">RELACIONADAS</h2>';

		foreach ($this->query_relacionadas as $query){
			?>
			<div class="row mb-5">
				<div class="col-lg-12">
					<?php
					$thumb = get_the_post_thumbnail_url($query->ID);
					$url = get_the_permalink($query->ID);
					$post_thumbnail_id = get_post_thumbnail_id( $query->ID );
					$image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);
					if ($thumb){
						echo '<figure class=" m-0">';
						echo '<img src="'.$thumb.'" class="img-fluid rounded float-left mr-4 w-25" alt="'.$image_alt.'"/>';
						echo '</figure>';
					}
					?>
					<h4 class="fonte-dezoito font-weight-bold mb-2">
                        <a class="text-decoration-none text-dark" href="<?= $url ?>">
							<?= $query->post_title ?>
						</a>
					</h4>
					<?php
					echo $this->getSubtitulo($query->ID, 'p', 'fonte-dezesseis mb-2')
					?>
					<?= $this->getComplementosRelacionadas($query->ID); ?>
				</div>
			</div>
			<?php
		}

		$this->fechaContainer($container_mais_noticias_tags);

	}*/

	public function getComplementosRelacionadas($id_post){
		$dt_post = get_the_date('d/m/Y g\hi');
		$categoria = get_the_category($id_post)[0]->name;

		return '<p class="fonte-doze font-italic mb-0">Publicado em: '.$dt_post.' - em '.$categoria.'</p>';


	}
	
	public function my_related_posts() {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'posts_per_page' => 5,
			'post_in' => get_the_tag_list(),
			'paged' => $paged
		);
		
		$the_query = new \WP_Query( $args );
		echo '<div class="container">';
		echo '<div class="row mt-4">';
		echo '<div class="col-sm-8" id="outrasNoticias"><h2>Relacionadas</h2>';
		echo '<div class="row">';
		while ( $the_query->have_posts() ) : $the_query->the_post();

			// Busca a imagem destaca / primeira imagem / imagem padrao -- functions.php
			$thumbs = get_thumb(get_the_ID());   
		?>
			
			<div class="col-sm-4 mb-4">
				<img src="<?php echo $thumbs[0]; ?>" alt="<?php echo $thumbs[1]; ?>" class="img-fluid rounded">			
			</div>
			<div class="col-sm-8 mb-4">
				<h3 class="fonte-dezoito font-weight-bold mb-2 aaa">
					<a class="text-decoration-none text-dark" href="<?php echo get_the_permalink(get_the_ID()); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<?php
				echo $this->getSubtitulo($query->ID, 'p', 'fonte-dezesseis mb-2')
				?>
				<?= $this->getComplementosRelacionadas($query->ID); ?>
				
			</div>
			
		<?php
		endwhile;
			
		echo '</div></div></div></div>';
		
		wp_reset_postdata();
		
		?>
		<div class="paginacao-atual">
			<?php
			echo paginate_links( array(
				'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'current' => $paged,
				'total'   => $the_query->max_num_pages,
				'end_size'  => 1,
				'mid_size'  => 2,
				'show_all' => false,
				'prev_next' => true,
				'prev_text' => __('<<'),
				'next_text' => __('>>'),
				'add_fragment' => '#outrasNoticias'
			) );
			?>
		</div>
		<?php
		
		//paginacao2($the_query);
	}
	

}