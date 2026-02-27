<?php

namespace Classes\TemplateHierarchy\LoopEvento;

use Classes\Lib\Util;

class LoopEvento extends Util
{

	public function __construct()
	{
		$this->init();
	}

	public function init(){
		$container_geral_tags = array('section', 'section');
		$container_geral_css = array('container', 'row event-detail');
		$this->abreContainer($container_geral_tags, $container_geral_css);

		new LoopEventoCabecalho();
		new LoopEventoPrincipal();
		new LoopEventoAgenda();
		new LoopEventoParceiro();
		new LoopEventoRelacionados();

		$this->fechaContainer($container_geral_tags);
	}



}