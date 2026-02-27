<?php
namespace Classes\TemplateHierarchy\LoopSingle;
class LoopSingleNoticiaPrincipal extends LoopSingle
{
	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		$this->montaHtmlNoticiaPrincipal();
	}
	public function montaHtmlNoticiaPrincipal(){
		if (have_posts()):
			while (have_posts()): the_post();
				echo '<article class="col-lg-8 col-sm-12 border-bottom content-article">';
				echo '<h2 class="titulo-noticia-principal mb-3" id="'.get_post_field( 'post_name', get_post() ).'">'.get_the_title().'</h2>';
				//echo $this->getSubtitulo(get_the_ID(), 'h3');
				echo '<h3>';
					if(get_field('insira_o_subtitulo', get_the_ID()) != ''){
						the_field('insira_o_subtitulo', get_the_ID());
					}else if (get_field('insira_o_subtitulo', get_the_ID()) == ''){
						 echo get_the_excerpt(get_the_ID()); 
					}
		echo '</h3>';
				
				$this->getDataPublicacaoAlteracao();
				$this->getMidiasSociais();
				the_content();
				//$this->getArquivosAnexos();
				//$this->getCategorias(get_the_ID());
				the_tags( '<div class="custom-tags-noticias">', '', '</div>' );
				echo '</article>';
			endwhile;
		endif;
		wp_reset_query();
	}
	public function getDataPublicacaoAlteracao(){
		//padrão de horario G\hi
		echo '<span class="display-autor">Publicado em: '.get_the_date('d/m/Y G\hi').' | Atualizado em: '.get_the_modified_date('d/m/Y').'</span>';
	}

	public function getMidiasSociais(){
		/*Utilizando as classes de personalização do Plugin Add This*/
		if (STM_URL === 'http://localhost/furuba-educacao-intranet'){
			echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_d2ly"]');
		}else {
			echo do_shortcode('[addthis tool="addthis_inline_share_toolbox_q0q4"]');
		}
	}
	public function getArquivosAnexos(){
		$unsupported_mimes  = array( 'image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/tiff', 'image/x-icon' );
		$all_mimes          = get_allowed_mime_types();
		$accepted_mimes     = array_diff( $all_mimes, $unsupported_mimes );

		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'post_mime_type'    => $accepted_mimes,
			'posts_per_page' => -1,
			'post_parent' => get_the_ID(),
			'orderby'	=> 'ID',
			'order'	=> 'ASC',
			'exclude'     => get_post_thumbnail_id()
		) );
		if ( $attachments ) {
			echo '<section id="arquivos-anexos">';
			echo '<h2>Arquivos Anexos</h2>';
			foreach ( $attachments as $attachment ) {
				echo '<article>';
				echo '<p><a target="_blank" style="font-size:26px" href="'.$attachment->guid.'"><i class="fa fa-file-text-o fa-3x" aria-hidden="true"></i> Ir para '. $attachment->post_title.'</a></p>';
				echo '<article>';
			}
			echo '</section>';
		}
	}
	public function getCategorias($id_post){
		$categorias = get_the_category($id_post);
		foreach ($categorias as $categoria){
			$category_link = get_category_link( $categoria->term_id );
			echo '<a href="'.$category_link.'"><span class="badge badge-pill badge-light border p-2 m-2 font-weight-normal">ir para '.$categoria->name.'</span></a>';
		}
	}
}
