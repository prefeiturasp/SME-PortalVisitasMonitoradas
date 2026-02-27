<?php

namespace Classes;


use Classes\TemplateHierarchy\ArchiveAgendaDre\ArchiveAgendaAjaxCalendarioDre;
use Classes\TemplateHierarchy\ArchiveAgendaDre\ArchiveAgendaGetDatasEventosDre;

class LoadDependences
{
	public function __construct()
	{
		$this->loadDependencesPublic();
		$this->loadDependencesAdmin();
	}

	public function loadDependencesPublic(){
		//if (!is_admin()){
			add_action('init', array($this, 'custom_formats_public'));
		//}
	}
	public function loadDependencesAdmin(){
		if (is_admin()){
			//add_action('init', array($this, 'custom_formats_admin'));
		}
	}

	public function custom_formats_public(){
        // Página Home
        if(!is_admin()){
            wp_enqueue_script( 'js_home', STM_THEME_URL . 'classes/assets/js/home.js', array( 'jquery' ), 1, true );
            wp_register_style('pagina-home', STM_THEME_URL . 'classes/assets/css/home.css', null, null, 'all');
            wp_enqueue_style('pagina-home');
        }

        // Página Busca Home
        if(!is_admin()){
            wp_enqueue_script( 'js_busca_home', STM_THEME_URL . 'classes/assets/js/busca.js', array( 'jquery' ), 1, true );
            wp_enqueue_script( 'js_query_ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js', array( 'jquery' ), 1, true );
            wp_enqueue_script( 'js_multiselect', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js', array( 'jquery' ), 1, true );
            wp_enqueue_script( 'js_validate', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js', array( 'jquery' ), 1, true );
            wp_register_style('css_query_ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css', null, null, 'all');
            wp_enqueue_style('css_query_ui');
            wp_register_style('css_multiselec', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css', null, null, 'all');
            wp_enqueue_style('css_multiselec');
            wp_register_style('pagina-busca-home', STM_THEME_URL . 'classes/assets/css/busca.css', null, null, 'all');
            wp_enqueue_style('pagina-busca-home');
        }

		// Página Inicial
		if(!is_admin()){
			wp_register_style('pagina-inicial', STM_THEME_URL . 'classes/assets/css/pagina-inicial.css', null, null, 'all');
			wp_enqueue_style('pagina-inicial');
		}

		// Página Login
		if(!is_admin()){
			wp_register_style('pagina-login', STM_THEME_URL . 'classes/assets/css/pagina-login.css', null, null, 'all');
			wp_enqueue_style('pagina-login');

			//wp_register_script('pagina-login',  STM_THEME_URL . 'classes/assets/js/pagina-login.js', array ('jquery'), false, false);
			//wp_enqueue_script('pagina-login');
		}

		wp_register_script('jquery-steps',  STM_THEME_URL . 'classes/assets/js/jquery.steps.js', array ('jquery'), false, false);
		wp_enqueue_script('jquery-steps');

		wp_register_script('jquery-steps-config',  STM_THEME_URL . 'classes/assets/js/jquery.steps.config.js', array ('jquery'), false, false);
		wp_enqueue_script('jquery-steps-config');

		wp_register_script('jquery-mask',  STM_THEME_URL . 'classes/assets/js/jquery.mask.min', array ('jquery'), false, false);
		wp_enqueue_script('jquery-mask');
				
		//construtor
		if(!is_admin()){
			wp_register_style('construtor', STM_THEME_URL . 'classes/assets/css/construtor.css');
			wp_enqueue_style('construtor');
		}		

		// Agenda do Secretário
		wp_register_style('agenda-secretario', STM_THEME_URL . 'classes/assets/css/agenda-secretario.css', null, null, 'all');
		wp_enqueue_style('agenda-secretario');
		wp_register_script('moment_with_locales',  STM_THEME_URL . 'classes/assets/js/ion.calendar-2.0.2/js/moment-with-locales.js', array ('jquery'), false, false);
		wp_register_script('ion_calendar',  STM_THEME_URL . 'classes/assets/js/ion.calendar-2.0.2/js/ion.calendar.js', array ('jquery'), false, false);
		wp_enqueue_script('moment_with_locales');
		wp_enqueue_script('ion_calendar');

		wp_register_script('ajax-agenda-secretario',  STM_THEME_URL . 'classes/assets/js/ajax-agenda-secretario.js', array ('jquery'), false, false);
		wp_enqueue_script('ajax-agenda-secretario');
		wp_localize_script('ajax-agenda-secretario', 'bloginfo', array('ajaxurl' => admin_url('admin-ajax.php')));
		
		// Breadcrumb
		wp_register_style('breadcrumb', STM_THEME_URL . 'classes/assets/css/breadcrumb.css', null, null, 'all');
		wp_enqueue_style('breadcrumb');

		// Loop Single
		wp_register_style('loop-single', STM_THEME_URL . 'classes/assets/css/loop-single.css', null, null, 'all');
		wp_enqueue_style('loop-single');

		//add_action('wp_ajax_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendario(), 'montaHtmlListaEventos' ));
	   	//add_action('wp_ajax_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendarioNew(), 'montaHtmlListaEventos' ));
				
		//add_action('wp_ajax_nopriv_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendario(), 'montaHtmlListaEventos'));

		add_action('wp_ajax_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendarioDre(), 'montaHtmlListaEventos' ));				
		add_action('wp_ajax_nopriv_montaHtmlListaEventos', array(new ArchiveAgendaAjaxCalendarioDre(), 'montaHtmlListaEventos'));

		//add_action('wp_ajax_recebeDadosAjax', array(new ArchiveAgendaGetDatasEventos(), 'recebeDadosAjax' ));
		//add_action('wp_ajax_nopriv_recebeDadosAjax', array(new ArchiveAgendaGetDatasEventos(), 'recebeDadosAjax'));

		//add_action('wp_ajax_recebeDadosAjax', array(new ArchiveAgendaGetDatasEventosNew(), 'recebeDadosAjax' ));
		//add_action('wp_ajax_nopriv_recebeDadosAjax', array(new ArchiveAgendaGetDatasEventosNew(), 'recebeDadosAjax'));

	}

	public function custom_formats_admin(){


	}
}

new LoadDependences();