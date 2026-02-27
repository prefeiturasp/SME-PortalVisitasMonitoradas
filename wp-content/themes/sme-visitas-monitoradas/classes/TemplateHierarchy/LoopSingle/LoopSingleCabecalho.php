<?php

namespace Classes\TemplateHierarchy\LoopSingle;

use Classes\TemplateHierarchy\Search\SearchFormSingle;

class LoopSingleCabecalho extends LoopSingle
{

	public function __construct()
	{
		$this->cabecalhoDetalheNoticia();
	}

	public function cabecalhoDetalheNoticia(){
		?>
		<div class="col-lg-6 col-sm-6 d-flex justify-content-lg-start justify-content-center">
			<h1 id='Noticias' class="titulos_internas mb-lg-5">Notícias</h1>
			aaaa
		</div>
        <?php
        SearchFormSingle::searchFormHeader();
	}
}