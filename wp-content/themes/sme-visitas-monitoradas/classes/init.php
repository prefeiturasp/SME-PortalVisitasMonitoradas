<?php
/* Inicialização das Classes */

require_once __ROOT__.'/classes/LoadDependences.php';
require_once __ROOT__.'/classes/Lib/Util.php';
require_once __ROOT__.'/classes/Lib/SimpleXLSXGen.php';

require_once __ROOT__.'/classes/Header/Header.php';

require_once __ROOT__.'/classes/Usuarios/Editor/Editor.php';
require_once __ROOT__.'/classes/Usuarios/Colaborador/Colaborador.php';
require_once __ROOT__.'/classes/Usuarios/Administrador/Administrador.php';
require_once __ROOT__.'/classes/Usuarios/Parceiro/Parceiro.php';
require_once __ROOT__.'/classes/Usuarios/Dre/Dre.php';
require_once __ROOT__.'/classes/Usuarios/EnviarParaRevisao.php';
require_once __ROOT__.'/classes/Usuarios/CamposAdicionais.php';

//tutorial
require_once __ROOT__.'/classes/tutorial/tutorial.php';

require_once __ROOT__.'/classes/Cpt/Cpt.php';
require_once __ROOT__.'/classes/Cpt/CptPosts.php';
require_once __ROOT__.'/classes/Cpt/CptPages.php';
require_once __ROOT__.'/classes/Cpt/CptEventos.php';
require_once __ROOT__.'/classes/Cpt/CptCadastroParceiros.php';
require_once __ROOT__.'/classes/Cpt/CptCadastroInscricoes.php';
require_once __ROOT__.'/classes/Cpt/CptFaq.php';
require_once __ROOT__.'/classes/Cpt/CptCadastroTransporte.php';

require_once __ROOT__.'/classes/TemplateHierarchy/Page.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Tag.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingle.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleCabecalho.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleMenuInterno.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleNoticiaPrincipal.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleMaisRecentes.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopSingle/LoopSingleRelacionadas.php';

require_once __ROOT__.'/classes/TemplateHierarchy/LoopEvento/LoopEvento.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopEvento/LoopEventoCabecalho.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopEvento/LoopEventoPrincipal.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopEvento/LoopEventoAgenda.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopEvento/LoopEventoParceiro.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopEvento/LoopEventoRelacionados.php';

require_once __ROOT__.'/classes/TemplateHierarchy/LoopParceiro/LoopParceiro.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopParceiro/LoopParceiroCabecalho.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopParceiro/LoopParceiroRelacionados.php';
require_once __ROOT__.'/classes/TemplateHierarchy/LoopParceiro/LoopParceiroCta.php';

require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaDre/ArchiveAgendaDre.php';
require_once __ROOT__.'/classes/TemplateHierarchy/ArchiveAgendaDre/ArchiveAgendaAjaxCalendarioDre.php';

require_once __ROOT__.'/classes/TemplateHierarchy/Search/GetTipoDePost.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/SearchForm.php';
require_once __ROOT__.'/classes/TemplateHierarchy/Search/LoopSearch.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/SearchFormSingle.php';
require_once __ROOT__ .'/classes/TemplateHierarchy/Search/LoopSearchSingle.php';

require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicial.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialIconesDetectMobile.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialIcones.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/Mobile/PaginaInicialIconesMobile.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaquePrimaria.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNoticiasDestaqueSecundarias.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialTwitter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialNewsletter.php';
require_once __ROOT__.'/classes/ModelosDePaginas/PaginaInicial/PaginaInicialFacebook.php';
require_once __ROOT__.'/classes/ModelosDePaginas/Layout/construtor.php';

require_once __ROOT__.'/classes/ModelosDePaginas/Login/Login.php';
require_once __ROOT__.'/classes/ModelosDePaginas/Login/LoginForm.php';
require_once __ROOT__.'/classes/ModelosDePaginas/Login/LoginRecuperar.php';

require_once __ROOT__.'/classes/ModelosDePaginas/Inscricoes/Inscricoes.php';

require_once __ROOT__.'/classes/Breadcrumb/Breadcrumb.php';

require_once __ROOT__.'/classes/Cpt/CptMediaImages.php';

/* Inicialização CPTs */
$cptPostsExtend = new \Classes\Cpt\CptPosts();
$cptPagessExtend = new \Classes\Cpt\CptPages();

$taxonomiaMediaImages = new \Classes\Cpt\CptMediaImages();

// Eventos
$cptEventos = new \Classes\Cpt\Cpt('evento', 'evento', 'Eventos', 'Todos os Eventos', 'Eventos', 'Eventos', null, null, null, 'dashicons-calendar-alt', true);
$cptEventosExtend = new \Classes\Cpt\CptEventos();

// Cadastro Parceiros
$cptCadastroParceiros = new \Classes\Cpt\Cpt('parceiros', 'parceiros', 'Parceiros', 'Todos os Cadastro', 'Parceiros', 'Parceiros', null, null, null, 'dashicons-businessman', true);
$cptCadastroParceirosExtend = new \Classes\Cpt\CptCadastroParceiros();

// Inscrições
$cptCadastroInscricoes = new \Classes\Cpt\Cpt('agendamento', 'agendamento', 'Inscrições', 'Todos as Incrições', 'Inscrições', 'Inscrições', null, null, null, 'dashicons-businessman', true);
$cptCadastroInscricoesExtend = new \Classes\Cpt\CptCadastroInscricoes();

$cptCadastroTransporte = new \Classes\Cpt\Cpt('transporte', 'transporte', 'Transporte', 'Todos as Empresas', 'Transporte', 'Transporte', null, null, null, 'dashicons-businessman', true);
$cptCadastroTransporteExtend = new \Classes\Cpt\CptCadastroTransporte();

$cptFaq = new \Classes\Cpt\Cpt('faq-duvidas', 'faq-duvidas', 'FAQ', 'Todos as dúvidas', 'FAQ', 'FAQ', null, null, null, 'dashicons-businessman', true);
$cptFaqExtend = new \Classes\Cpt\CptFaq();