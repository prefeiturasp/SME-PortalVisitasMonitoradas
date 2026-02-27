<?php
use Classes\Header\Header;
?>
<!doctype html>
<html lang="pt-br">
<head>
	<?php
	if (function_exists('get_field')){
        $tituloPagina = get_field("insira_o_title_desejado");
	    $descriptionPagina = get_field("insira_a_description_desejada");
    }
	if (is_front_page()) {
		if (trim($tituloPagina != "")) { ?>
            <title><?php echo $tituloPagina ?></title>
		<?php } else { ?>
            <title><?php echo STM_SITE_NAME ?> - Home</title>
		<?php }

		if (trim($descriptionPagina != "")) { ?>
            <meta name="description" content="<?php echo $descriptionPagina ?>."/>
		<?php } else { ?>
            <meta name="description" content="<?php echo STM_SITE_NAME ?>. <?php echo STM_SITE_DESCRIPTION ?>"/>
		<?php }
	} elseif (is_category() || is_tax()) {
		$queried_object = get_queried_object();
		$taxonomy = $queried_object->taxonomy;
		$term_id = $queried_object->term_id;
		
        if (function_exists('get_field')){
            $tituloCategoria = get_field('insira_o_title_desejado', $taxonomy . '_' . $term_id);
            $descriptionCategoria = get_field("insira_a_description_desejada", $taxonomy . '_' . $term_id);
        }

		if (trim($tituloCategoria != "")) { ?>
            <title><?php echo $tituloCategoria ?></title>
		<?php } else { ?>
            <title><?php wp_title('', true, '-'); ?> - <?php echo STM_SITE_NAME ?></title>
		<?php }

		if (trim($descriptionCategoria != "")) { ?>
            <meta name="description"
                  content="<?php echo $descriptionCategoria ?>."/>
		<?php } else { ?>
            <meta name="description" content="<?php echo STM_SITE_NAME ?>. <?php echo STM_SITE_DESCRIPTION ?>"/>
		<?php }

	} else {
		if (trim($tituloPagina != "")) { ?>
            <title><?php echo $tituloPagina ?></title>
		<?php } else { ?>
            <title><?php wp_title('', true, '-'); ?> - <?php echo STM_SITE_NAME ?></title>
		<?php }

		if (trim($descriptionPagina != "")) { ?>
            <meta name="description" content="<?php echo $descriptionPagina ?>."/>
		<?php } else { ?>
            <meta name="description"
                  content="<?php wp_title('', true, '-'); ?> - <?php echo STM_SITE_DESCRIPTION ?>"/>
		<?php }
	}
	?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Secretaria Municipal de Educação de São Paulo">

	<?php wp_head() ?>

    <?php
        $analytics = get_field('codigo','conf-analytics');
        if($analytics && $analytics != ''){
            echo $analytics;
        }
    ?>

</head>

<body>

<section id="main" role="main">
    <header class="pref-menu fonte-dez">

            <section class="row cabecalho-acessibilidade" style='display: none;'>
                <section class="container">
                    <section class="row">
                        <article class="col-lg-8 col-xs-12 d-none d-lg-flex justify-content-start">
                            <ul class="list-inline list-inline-mob my-3">
                                <?php
                                $slug_titulo = new Header();
                                ?>
                                <li class="list-inline-item"><a accesskey="1" id="1" href="#<?= $slug_titulo->getSlugTitulo() ?>" >Ir ao Conteúdo <span class="span-accesskey">1</a></li>
                                <li class="list-inline-item"><a accesskey="2" id="2" href="#irmenu"  >Ir para menu principal <span class="span-accesskey">2</span></a></li>
                                <li class="list-inline-item"><a accesskey="3" id="3" href="#search-front-end"  >Ir para busca <span class="span-accesskey">3</span></a></li>
                                <li class="list-inline-item"><a accesskey="4" id="4" href="#irrodape"  >Ir para rodapé <span class="span-accesskey">4</span></a></li>
                                <li class="list-inline-item"><a href="<?= STM_URL ?>/acessibilidade/" accesskey="5">Acessibilidade <span class="span-accesskey">5</span> </a></li>
                            </ul>
                        </article>

                        <article class="col-lg-4 col-xs-12 d-flex justify-content-md-end justify-content-start">
                            <?php dynamic_sidebar('Rodape Esquerda') ?>
                        </article>

                    </section>
                </section>

            </section>

            <section class="row cabecalho-cinza-claro d-none d-lg-block">

                <section class="container">
                    <section class="row">
                        <article class="col-8 col-lg-6 col-xs-12 d-flex justify-content-start">
                            <ul class="list-inline my-3">
                                <li class="list-inline-item"><a class="text-white" href="http://esic.prefeitura.sp.gov.br/Account/Login.aspx">Acesso à informação e-sic <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span> </a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://www.prefeitura.sp.gov.br/cidade/secretarias/ouvidoria/fale_com_a_ouvidoria/index.php?p=227268">Ouvidoria <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                                <li class="list-inline-item"><a class="text-white" href="http://transparencia.prefeitura.sp.gov.br/">Portal da Transparência <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                                <li class="list-inline-item"><a class="text-white" href="https://sp156.prefeitura.sp.gov.br/portal/servicos">SP 156 <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                            </ul>
                        </article>
                        <article class="col-4 col-lg-6 col-xs-12 d-flex justify-content-end align-items-center">
                            <?php 
                                if (function_exists('have_rows')){
                                    // Verifica se existe Redes Sociais
                                    if( have_rows('redes_sociais', 'conf-rodape') ):
                                        
                                        echo '<ul class="list-inline mt-2 mb-2 midias-sociais">';						
                                        
                                            while( have_rows('redes_sociais', 'conf-rodape') ) : the_row();
                                                
                                                $rede_url = get_sub_field('url_rede'); 
                                                $rede_texto = get_sub_field('texto_alternativo');
                                                $rede_topo = get_sub_field('tipo_de_icone_topo');
                                                $rede_t_imagem = get_sub_field('imagem_topo');
                                                $rede_t_icone = get_sub_field('icone_topo');                                            
                                                
                                            ?>
                                                
                                                <li class="list-inline-item">
                                                    <a class="text-white" href="<?php echo $rede_url; ?>">
                                                        <?php if($rede_topo == 'imagem' && $rede_t_imagem != '') : ?>
                                                            <img src="<?php echo $rede_t_imagem; ?>" alt="<?php echo $rede_texto; ?>" width="16" height="16">
                                                        <?php elseif($rede_topo == 'icone' && $rede_t_icone != ''): ?>
                                                            <i class="fa <?php echo $rede_t_icone; ?>" aria-hidden="true" title="<?php echo $rede_texto; ?>"><span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></i>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php
                                                

                                            // End loop.
                                            endwhile;

                                        echo '</ul>';
                                    
                                    endif;
                                }
                            ?>
                        </article>
                    </section>
                </section>
            </section>

        <section class='logo-principal'>
            <div class="container mt-3">
                <div class="row">
                    <?php
                    // Traz o Logotipo cadastrado no Admin
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $image = wp_get_attachment_image_src($custom_logo_id, 'full');
                    
                    ?>
                    <div class="col-12 col-lg-2">                        
                        <a class="brand" href="<?php echo STM_URL ?>">
                            <img class="logo-visitas" src="<?php echo $image[0] ?>" width="<?php echo $image[1] ?>" height="<?php echo $image[2] ?>" alt="Visitas monitoradas">
                        </a>
                    </div>
                    <div class="col-6 d-lg-none d-flex align-items-center py-2">
                        <span class="btn-menu d-block d-lg-none"><i class="fa fa-bars" aria-hidden="true"></i></span>
                    </div>
                    <div class="col-6 col-lg-10 text-right d-flex justify-content-end align-items-center">
                        <div class="menu-line d-none d-lg-block">
                            <span class="link-menu active"><a href="/">Home</a></span>
                            <?php
                            $menuLocations = get_nav_menu_locations();
                            $menuID = $menuLocations['primary'];
                            $primaryNav = wp_get_nav_menu_items($menuID);
                            foreach ( $primaryNav as $navItem ) {
                                ?>
                                <span class="link-menu"><a href="<?php echo $navItem->url ?>"><?php echo $navItem->title ?></a></span>
                                <?php
                            }
                            ?>
                        </div>
                        
                        <?php $current_user = wp_get_current_user(); ?>
                        <div class="navbar-nav">
                            <?php if ( is_user_logged_in() ) : ?>                            
                                <div class="nav-item dropdown profile-menus">
                                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
                                        <img src="/wp-content/uploads/2022/07/login.png" alt="login" width="24" height="24">
                                        <span><?= $current_user->user_firstname; ?></span> <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <img src="/wp-content/uploads/2022/07/login.png" alt="login" width="24" height="24">
                                        <p><?= $current_user->user_firstname; ?></p>
                                        <div class="dropdown-divider"></div>
                                        <a href="<?= get_home_url(); ?>/wp-admin/profile.php" class="dropdown-item">Perfil</a>                                        
                                        <a href="<?= get_home_url(); ?>/minhas-inscricoes/" class="dropdown-item">Minhas inscrições</a>                          
                                        <a href="<?= wp_logout_url(); ?>" class="dropdown-item">Sair</a>
                                    </div>
                                </div>
                            <?php else : ?>
                                <a href="<?= get_home_url(); ?>/login" class="ml-3 btn btn-outline-dark">Login</a>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </section>
		

    </header>

    

    <div class="menu-sidebar">
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col-12 text-left"><span class="btn-menu-close"><img src="https://visitas.rafaelhsouza.com.br/img/fechar.png" alt="Fechar" width="24" height="24"> Fechar</span></div>
            </div>
            <div class="row mt-4 mb-3">
                <ul>
                    <li class="link-menu active"><a href="/">Home</a></li>
                    <?php
                        $menuLocations = get_nav_menu_locations();
                        $menuID = $menuLocations['primary'];
                        $primaryNav = wp_get_nav_menu_items($menuID);
                        foreach ( $primaryNav as $navItem ) {
                            ?>
                            <li class="link-menu"><a href="<?php echo $navItem->url ?>"><?php echo $navItem->title ?></a></li>
                            <?php
                        }
                    ?>
                </ul>
                <ul class="my-3 menu-aces">                    
                    <li><a accesskey="1" id="1" href="#<?= $slug_titulo->getSlugTitulo() ?>" >Ir ao Conteúdo <span class="span-accesskey">1</a></li>
                    <li><a accesskey="2" id="2" href="#irmenu"  >Ir para menu principal <span class="span-accesskey">2</span></a></li>
                    <li><a accesskey="3" id="3" href="#search-front-end"  >Ir para busca <span class="span-accesskey">3</span></a></li>
                    <li><a accesskey="4" id="4" href="#irrodape"  >Ir para rodapé <span class="span-accesskey">4</span></a></li>
                    <li><a href="<?= STM_URL ?>/acessibilidade/" accesskey="5">Acessibilidade <span class="span-accesskey">5</span> </a></li>
                </ul>
                <ul class="list-inline my-3">
                    <li class="list-inline-item"><a href="http://esic.prefeitura.sp.gov.br/Account/Login.aspx">Acesso à informação e-sic <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span> </a></li>
                    <li class="list-inline-item"><a href="https://www.prefeitura.sp.gov.br/cidade/secretarias/ouvidoria/fale_com_a_ouvidoria/index.php?p=227268">Ouvidoria <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                    <li class="list-inline-item"><a href="http://transparencia.prefeitura.sp.gov.br/">Portal da Transparência <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                    <li class="list-inline-item"><a href="https://sp156.prefeitura.sp.gov.br/portal/servicos">SP 156 <span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></a></li>
                </ul>

                <div class="social-mobile">
                <?php 
                    if (function_exists('have_rows')){
                        // Verifica se existe Redes Sociais
                        if( have_rows('redes_sociais', 'conf-rodape') ):
                            
                            echo '<ul class="list-inline mt-2 mb-2 midias-sociais">';						
                            
                                while( have_rows('redes_sociais', 'conf-rodape') ) : the_row();
                                    
                                    $rede_url = get_sub_field('url_rede'); 
                                    $rede_texto = get_sub_field('texto_alternativo');
                                    $rede_topo = get_sub_field('tipo_de_icone_topo');
                                    $rede_t_imagem = get_sub_field('imagem_topo');
                                    $rede_t_icone = get_sub_field('icone_topo');                                            
                                    
                                ?>
                                    
                                    <li class="list-inline-item">
                                        <a class="text-white" href="<?php echo $rede_url; ?>">
                                            <?php if($rede_topo == 'imagem' && $rede_t_imagem != '') : ?>
                                                <img src="<?php echo $rede_t_imagem; ?>" alt="<?php echo $rede_texto; ?>" width="16" height="16">
                                            <?php elseif($rede_topo == 'icone' && $rede_t_icone != ''): ?>
                                                <i class="fa <?php echo $rede_t_icone; ?>" aria-hidden="true" title="<?php echo $rede_texto; ?>"><span class="esconde-item-acessibilidade">(Link para um novo sítio)</span></i>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php
                                    

                                // End loop.
                                endwhile;

                            echo '</ul>';
                        
                        endif;
                    }
                ?>
                </div>
            </div>
        </div>
    </div>

<?php //new \Classes\Breadcrumb\Breadcrumb(); ?>