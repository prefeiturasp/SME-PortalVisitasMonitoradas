<?php
namespace Classes\TemplateHierarchy\LoopEvento;
class LoopEventoParceiro extends LoopEvento
{
	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		$this->montaHtmlEventoParceiro();
	}
	public function montaHtmlEventoParceiro(){
	?>
		<div class="row m-0 w-100">
			<div class="col-12 my-4">
				<hr>
			</div>
			<div class="col-md-5">
				<?php
					$parceiro = get_field('parceiro');
					$nomeParceiro = get_the_title($parceiro);
					$logo = get_field('foto_principal_parceiro', $parceiro);
					$descricao = get_field('descricao_parceiro', $parceiro);
					$site = get_field('site_do_parceiro', $parceiro);
				?>

				<?php if($logo): ?>
					<a href="<?= get_the_permalink($parceiro); ?>"><img src="<?= $logo; ?>" alt="Logo <?= $nomeParceiro; ?>"></a>
				<?php endif; ?>

				<h3><?= $nomeParceiro; ?></h3>

				<?php if($descricao): ?>
					<?= $descricao; ?>
				<?php endif; ?>

				<?php if($site): ?>
					<p><img src="<?= get_template_directory_uri(); ?>/classes/assets/img/site-icon.png" alt="icone cursor do mouse"> <a href="<?= $site; ?>"><?= $site; ?></a></p>
				<?php endif; ?>

			</div>
		</div>		
	<?php
	}	
}