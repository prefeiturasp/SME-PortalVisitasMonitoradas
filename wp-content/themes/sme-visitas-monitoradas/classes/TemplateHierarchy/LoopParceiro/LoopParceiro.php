<?php

namespace Classes\TemplateHierarchy\LoopParceiro;

use Classes\Lib\Util;

class LoopParceiro extends Util
{

	public function __construct()
	{
		$this->init();
	}

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container-fluid', 'row part-detail');
		$this->abreContainer($container_geral_tags, $container_geral_css);

		new LoopParceiroCabecalho();		
		new LoopParceiroRelacionados();
		new LoopParceiroCta();

		$this->fechaContainer($container_geral_tags);
	}



}