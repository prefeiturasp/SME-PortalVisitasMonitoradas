<?php
namespace Classes\TemplateHierarchy\LoopEvento;
use Classes\TemplateHierarchy\ArchiveAgendaDre\ArchiveAgendaDre;
//namespace Classes\TemplateHierarchy\ArchiveAgendaDre;
class LoopEventoAgenda extends LoopEvento
{
	public function __construct()
	{
		$this->init();
	}
	public function init()
	{
		$this->montaHtmlEventoAgenda();
	}
	public function montaHtmlEventoAgenda(){
		if (have_posts()):
			while (have_posts()): the_post();
			?>
				<div class="row m-0 w-100">
					<div class="event-content col-md-5 my-4">						
						<?php
							$dataPrincipal = get_field('data');
							$dataPrincipal = explode('/', $dataPrincipal);
							
							$agenda = get_field('agenda');
							$datas = '';
							$i = 0;
							if($agenda){
								foreach($agenda as $evento){
									$data = explode(' ', $evento['data_hora']);
									if($i == 0){
										$datas .= '&quot;' . str_replace('/', '\/', $data[0]) . '&quot;';
									} else {
										$datas .= ',&quot;' . str_replace('/', '\/', $data[0]) . '&quot;';
									}
									$i++;
								}
							}							
						?>
						<input type="hidden" name="array_datas_agenda" id="array_datas_agenda" value="[<?= $datas; ?>]">
						<input type="hidden" name="data_principal" id="data_principal" value="<?= $dataPrincipal[2] . $dataPrincipal[1] . $dataPrincipal[0]; ?>">
						<?php new ArchiveAgendaDre('aaa'); ?>
						<a href="<?= get_home_url(); ?>/inscricoes/?eventoid=<?= get_the_id(); ?>" class="btn visitas-btn mt-4">Fazer inscrição</a>
					</div>
				</div>				
			<?php
			endwhile;
		endif;
		wp_reset_query();
	}	
}