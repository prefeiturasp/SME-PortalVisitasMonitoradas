<?php
/*
 * Template Name: Página Busca
 * Description: Página Abas, página que exibe título, texto, contato e categoria de botões
 */
?>

<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-4">

                <?php
                    $sites = array();
                    $allResults = array();
                    $i = 0;

                    // Pega o site atual
                    $siteAtual[] = get_current_blog_id();

                    $allSites = array();
                    $allSites[] = 1; // Portal
                    $allSites[] = 8; // DRE Butanta
                    $allSites[] = 20; // DRE Campo Limpo
                    $allSites[] = 9; // DRE Capela Socorro
                    $allSites[] = 10; // DRE Freguesia
                    $allSites[] = 11; // DRE Guainases
                    $allSites[] = 12; // DRE Ipiranga
                    $allSites[] = 13; // DRE Itaquera
                    $allSites[] = 14; // DRE Jacana
                    $allSites[] = 15; // DRE Penha
                    $allSites[] = 16; // DRE Pirituba
                    $allSites[] = 17; // DRE Santo Amaro
                    $allSites[] = 18; // DRE Sao Mateus
                    $allSites[] = 19; // DRE Sao Miguel
                    $allSites[] = 5; // CME
                    $allSites[] = 4; // CAE
                    $allSites[] = 6; // CACSFUNDEB
                    $allSites[] = 7; // CRECE

                    // remove o site atual da listagem
                    $diff = array_diff( $allSites, $siteAtual );
                                          
                    // Inclui o site atual como primeiro da lista
                    $sites[] = (object) array('blog_id' => $siteAtual[0]);

                    // Nova ordenacao de sites
                    foreach($diff as $site){
                        $sites[] = (object) array('blog_id' => $site);
                    }

                    echo "<pre>";
                    print_r($sites);
                    echo "</pre>";

                    $types = array('page', 'programa-projeto', 'card', 'post');

                    if($_GET['tipoconteudo'] && $_GET['tipoconteudo'] != ''){
                        $arr = preg_split('/(?<=[a-z])(?=[0-9]+)/i', $_GET['tipoconteudo']);
                        if($arr[0] == 'page'){
                            $types = array('page', 'programa-projeto', 'card');
                        } else {
                            $types = array($arr[0]);
                        }
                        $sites = array();                      
                        $sites[] = (object) array('blog_id' => $arr[1]);
                    }

                    if($_GET['site'] && $_GET['site'] != ''){
                        $sites = array();                      
                        $sites[] = (object) array('blog_id' => $_GET['site']);
                    }

                    foreach ( $sites as $site ) {
                        
                        switch_to_blog( $site->blog_id );

                        if(isset($_GET['termo'])):
                                $query = $_GET['termo'];

                                
                                foreach($types as $type){
                                    
                                    $args = array( 
                                        's' => $query,
                                        'posts_per_page' => -1,
                                        'post_type' => $type,
                                    );

                                    if($_GET['periodo'] && $_GET['periodo'] != ''){
                                        $periodo = $_GET['periodo'];
                                        if($periodo === '1'){
                                            $args['date_query'] = array(
                                                'after'     => '1 hour ago'
                                            );
                                        } elseif($periodo === '24'){
                                            $args['date_query'] = array(
                                                'after'     => '1 day ago'
                                            );
                                        } elseif($periodo === '168'){
                                            $args['date_query'] = array(
                                                'after'     => '1 week ago'
                                            );
                                        } elseif($periodo === '5040'){
                                            $args['date_query'] = array(
                                                'after'     => '1 month ago'
                                            );
                                        } elseif($periodo === '1839600'){
                                            $args['date_query'] = array(
                                                'after'     => '1 year ago'
                                            );
                                        }
                                    }

                                    if($_GET['ano'] && $_GET['ano'] != ''){
                                        $args['date_query'] = array(
                                            'year'     => $_GET['ano'],
                                        );
                                    }

                                    // Incluir subtitulo da busca de noticias
                                    
                                    if($type == 'post'){
                                        $args['s_meta_keys'] = array('insira_o_subtitulo');
                                    }
                        
                                    $the_query = new WP_Query( $args );
                                    

                                    // The Loop
                                    if ( $the_query->have_posts() ) {
                                        //echo '<ul>';
                                        //echo '<h3>Site: ' . $site->path . '</h3>';
                                        while ( $the_query->have_posts() ) {
                                            $the_query->the_post();
                                            //echo '<li>' . get_the_title() . ' - ' . $site->path . '( ' . get_post_type() . ' )' . '</li>';
                                            $allResults[$i]['titulo'] = get_the_title();
                                            
                                            if( get_field('insira_o_subtitulo') ){
                                                $allResults[$i]['resumo'] = get_field('insira_o_subtitulo');
                                            } else {
                                                $allResults[$i]['resumo'] = get_the_excerpt();
                                            }
                                            
                                            $allResults[$i]['url'] = get_the_permalink();
                                            $allResults[$i]['type'] = get_post_type();
                                            $allResults[$i]['image'] = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                                            $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
                                            $allResults[$i]['alt']  = get_post_meta ( $thumbnail_id, '_wp_attachment_image_alt', true );
                                            $allResults[$i]['data']  = get_the_time('d/m/Y G\hi');
                                            $allResults[$i]['site_url'] = get_site_url();
                                            $allResults[$i]['site_nome'] = get_bloginfo('title');

                                            $i++;
                                        }
                                        //echo '</ul>';
                                    } else {
                                        // no posts found
                                    }
                                    /* Restore original Post Data */
                                    wp_reset_postdata();

                                }

                        endif;
                                
                        restore_current_blog();
                    }

                    //$type = array_column($allResults, 'type');
                    //array_multisort($type, SORT_DESC, $allResults);

                    //echo "<pre>";
                    //print_r($allResults);
                    //echo "</pre>";

                    $pagina = ! empty( $_GET['pagina'] ) ? (int) $_GET['pagina'] : 1;
                    $total = count( $allResults ); //total items in array    
                    $limit = 10; //per page    
                    $totalPages = ceil( $total/ $limit ); //calculate total pages
                    $pagina = max($pagina, 1); //get 1 page when $_GET['page'] <= 0
                    $pagina = min($pagina, $totalPages); //get last page when $_GET['page'] > $totalPages
                    $offset = ($pagina - 1) * $limit;
                    if( $offset < 0 ) $offset = 0;

                    $allResults = array_slice( $allResults, $offset, $limit );
                    if($allResults):
                        foreach($allResults as $result):
                        ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    
                                    <?php if($result['image'] && $result['image'] != ''): ?>
                                        <figure>
                                            <?php $alt = $result['alt'] != '' ? $result['alt'] : $result['titulo']; ?>
                                            <img class="img-fluid rounded float-left" src="<?=$result['image'];?>" alt="<?=$alt;?>" width="100%">
                                        </figure>
                                    <?php else: ?>
                                        <figure>
                                            <img class="img-fluid rounded float-left" src="https://educacao.sme.prefeitura.sp.gov.br/wp-content/uploads/2020/06/placeholder-sme.jpg" width="100%">
                                        </figure>
                                    <?php endif; // Imagem ?>
                                    
                                </div>
                                <div class="col-sm-8">
                                    <h2><a href="<?=$result['url'];?>"> <?=$result['titulo'];?></a></h2>								
                                    <p><?=$result['resumo'];?></p>   <!--Mostra resumo-->
                                                                    
                                    <?php if($result['type'] != ''): ?>
                                        <strong>Tipo:</strong> 
                                        <span class="tagcolor">
                                            <?php $tipopost = $result['type'];
                                            if( $tipopost == "post" ) echo  'Notícia';
                                            if( $tipopost == "programa-projeto" ) echo  'Página';
                                            if( $tipopost == "card" ) echo  'página';
                                            if( $tipopost == "page" ) echo  'Página'; ?>
                                        </span><br>
                                    <?php endif; ?>
                                    
                                    <span><strong>Publicado em:</strong> <?=$result['data'];?> </span> -

                                    <span><strong>Site:</strong>
                                        <a href="<?=$result['site_url'];?>">
                                            <?=$result['site_nome'];?>
                                        </a>
                                    </span><br>

                                </div>

                            </div>
                            <hr>
                        <?php
                        endforeach;
                    else:
                    ?>
                        <div class="no-results">
                            <h2 class="search-title">
                                <span class="azul-claro-acervo"><strong>0</strong></span><strong> 
                                    resultados</strong>
                            </h2>
                            <img src="<?php echo get_template_directory_uri(); ?>/img/search-empty.png" alt="Imagem ilustrativa para nenhum resultado de busca encontrado" />
                            <p>Não há conteúdo disponível para o termo buscado. Por favor faça uma nova busca.</p>
                        </div>
                        

                    <?php
                    endif;
                    
                    //echo "<pre>";
                    //print_r($allResults);
                    //echo "</pre>";

                    //echo 'Total Resultados: '. $total;
                    //echo "<br>";
                    //echo 'Paginas: '. $totalPages;
                    //echo "<br>";
                    //echo 'Paginas Atual: '. $pagina;
                    //echo "<br>";
                    //echo $offset;
                    //echo "<br>";
                    //echo "<br>";

                    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    $new_url = preg_replace('/&?pagina=[^&]*/', '', $actual_link);

                    //echo $new_url;
                    
                ?>
                
                <?php if($allResults && $totalPages > 1):?>
                    <div style="width:100%;text-align: center;">
                        <div class="pagination <?=ceil($GLOBALS['i']/$GLOBALS['paginacao']) > 1 && $GLOBALS['i'] !== $GLOBALS['paginacao'] ? 'ok' : 'dddnone';?>">
                            <a href="<?php echo $new_url . '&pagina=' . ($pagina - 1);?>" class="anterior <?=$pagina > 1 ? 'ok' : 'dnone';?>">Anterior</a><!--Ir para o anterior-->
                            <a class="aaa paginationA " href="<?php echo $new_url . '&pagina=1'?>">&laquo;</a><!--Ir para o primeiro-->                       
                            
                            
                            <a class="1bbb paginationB <?=$pagina >= 4 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 3);?>"><?=$pagina - 3;?></a>
                            <a class="2bbb paginationB <?=$pagina >= 3 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 2);?>"><?=$pagina - 2;?></a>
                            <a class="3ccc paginationB <?=$pagina >= 2 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina - 1);?>"><?=$pagina - 1;?></a>

                            
                            <a class="eee paginationA active" href="<?php echo $new_url . '&pagina=' . $pagina;?>"><?=$pagina;?></a>

                            <a class="4bbb paginationB <?=$totalPages > $pagina + 1 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 1);?>"><?=$pagina + 1;?></a>
                            <a class="5bbb paginationB <?=$totalPages > $pagina + 2  ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 2);?>"><?=$pagina + 2;?></a>
                            <a class="6ccc paginationB <?=$totalPages > $pagina + 3 ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . ($pagina + 3);?>"><?=$pagina + 3;?></a>

                            <a class="paginationB <?=$totalPages > 1 && $pagina != $totalPages ? 'ok' : 'dnone';?>" href="<?php echo $new_url . '&pagina=' . $totalPages;?>"><?=$totalPages;?></a>
                                                
                            <a class="d paginationA" href="<?php echo $new_url . '&pagina=' . $totalPages;?>">»</a><!--Ir para o ultimo-->
                            <a href="<?php echo $new_url . '&pagina=' . ($pagina + 1);?>" class="proximo <?=$pagina != $totalPages  ? 'ok' : 'dnone';?>">Próximo</a><!--Ir para o próximo-->
                        </div>
                    </div>
                <?php endif; ?>
                

            </div>

            <div class="col-md-4 mb-5">
                <form action="<?php echo get_the_permalink(); ?>">                    

                    <div class="form-group border-filtro">
                        <label for="usr"><strong>
                                <h2>Refine a sua busca</h2>
                            </strong></label>
                    </div>

                    <div class="form-group">
                        <label for="usr"><strong>Busque por um termo</strong></label>
                        <input class='form-control' type='text' name="termo" placeholder='Buscar' value="<?=$_GET['termo']?>"></input>
                        
                        <input id="enviar-busca-home" name="enviar-busca-home" type="hidden" class="btn btn-outline-secondary bt-search-topo" value="Buscar"> </input>
                        
                    </div>

                    <div class="form-group">
                        <label for="sel1"><strong>Filtre por tipo de conteúdo</strong></label>
                        <select name="tipoconteudo" onCha class="form-control" id="sel1c">
                            <option value="">Selecione o tipo</option>
                            <option <?=$_GET['tipoconteudo'] == 'page1' ? "selected" : '' ?> value="page1">Página em SME Portal Educação</option>
                            <option <?=$_GET['tipoconteudo'] == 'post1' ? "selected" : '' ?> value="post1">Notícia em SME Portal Educação</option>
                            <option <?=$_GET['tipoconteudo'] == 'page8' ? "selected" : '' ?> value="page8">Página em DRE Butantã</option>
                            <option <?=$_GET['tipoconteudo'] == 'post8' ? "selected" : '' ?> value="post8">Notícia em DRE Butantã</option>
                            <option <?=$_GET['tipoconteudo'] == 'page20' ? "selected" : '' ?> value="page20">Página em DRE Campo Limpo</option>
                            <option <?=$_GET['tipoconteudo'] == 'post20' ? "selected" : '' ?> value="post20">Notícia em DRE Campo Limpo</option>
                            <option <?=$_GET['tipoconteudo'] == 'page9' ? "selected" : '' ?> value="page9">Página em DRE Capela do Socorro</option>
                            <option <?=$_GET['tipoconteudo'] == 'post9' ? "selected" : '' ?> value="post9">Notícia em DRE Capela do Socorro</option>
                            <option <?=$_GET['tipoconteudo'] == 'page10' ? "selected" : '' ?> value="page10">Página em DRE Freguesia/Brasilândia</option>
                            <option <?=$_GET['tipoconteudo'] == 'post10' ? "selected" : '' ?> value="post10">Notícia em DRE Freguesia/Brasilândia</option>
                            <option <?=$_GET['tipoconteudo'] == 'page11' ? "selected" : '' ?> value="page11">Página em DRE Guaianases</option>
                            <option <?=$_GET['tipoconteudo'] == 'post11' ? "selected" : '' ?> value="post11">Notícia em DRE Guaianases</option>
                            <option <?=$_GET['tipoconteudo'] == 'page12' ? "selected" : '' ?> value="page12">Página em DRE Ipiranga</option>
                            <option <?=$_GET['tipoconteudo'] == 'post12' ? "selected" : '' ?> value="post12">Notícia em DRE Ipiranga</option>
                            <option <?=$_GET['tipoconteudo'] == 'page13' ? "selected" : '' ?> value="page13">Página em DRE Itaquera</option>
                            <option <?=$_GET['tipoconteudo'] == 'post13' ? "selected" : '' ?> value="post13">Notícia em DRE Itaquera</option>
                            <option <?=$_GET['tipoconteudo'] == 'page14' ? "selected" : '' ?> value="page14">Página em DRE Jaçanã/Tremembé</option>
                            <option <?=$_GET['tipoconteudo'] == 'post14' ? "selected" : '' ?> value="post14">Notícia em DRE Jaçanã/Tremembé</option>
                            <option <?=$_GET['tipoconteudo'] == 'page15' ? "selected" : '' ?> value="page15">Página em DRE Penha</option>
                            <option <?=$_GET['tipoconteudo'] == 'post15' ? "selected" : '' ?> value="post15">Notícia em DRE Penha</option>
                            <option <?=$_GET['tipoconteudo'] == 'page16' ? "selected" : '' ?> value="page16">Página em DRE Pirituba</option>
                            <option <?=$_GET['tipoconteudo'] == 'post16' ? "selected" : '' ?> value="post16">Notícia em DRE Pirituba</option>
                            <option <?=$_GET['tipoconteudo'] == 'page17' ? "selected" : '' ?> value="page17">Página em DRE Santo Amaro</option>
                            <option <?=$_GET['tipoconteudo'] == 'post17' ? "selected" : '' ?> value="post17">Notícia em DRE Santo Amaro</option>
                            <option <?=$_GET['tipoconteudo'] == 'page18' ? "selected" : '' ?> value="page18">Página em DRE São Mateus</option>
                            <option <?=$_GET['tipoconteudo'] == 'post18' ? "selected" : '' ?> value="post18">Notícia em DRE São Mateus</option>
                            <option <?=$_GET['tipoconteudo'] == 'page19' ? "selected" : '' ?> value="page19">Página em DRE São Miguel</option>
                            <option <?=$_GET['tipoconteudo'] == 'post19' ? "selected" : '' ?> value="post19">Notícia em DRE São Miguel</option>
                            <option <?=$_GET['tipoconteudo'] == 'page5' ? "selected" : '' ?> value="page5">Página em CME Conselho</option>
                            <option <?=$_GET['tipoconteudo'] == 'page4' ? "selected" : '' ?> value="page4">Página em CAE Conselho</option>
                            <option <?=$_GET['tipoconteudo'] == 'page6' ? "selected" : '' ?> value="page6">Página em CACSFUNDEB Conselho</option>
                            <option <?=$_GET['tipoconteudo'] == 'page7' ? "selected" : '' ?> value="page7">Página em CRECE Conselho</option>
                        </select>
                        <script>
                            jQuery('#sel1c').on('change', function() {                                
                                var site = this.value.replace(/[^0-9]/g,'');
                                //console.log( site );

                                //jQuery("#sel3sites option:selected").removeAttr("selected");
                                jQuery("#sel3sites").val(site);
                            });
                        </script>
                    </div>

                    <div class="form-group">
                        <label for="sel2"><strong>Filtre por um período</strong></label>
                        <select name="periodo" class="form-control" id="sel2">	
                            <option value="">Todos os períodos</option>
                            <option <?=$_GET['periodo'] == '1' ? 		"selected" : 'n' ?> value="1">Última hora</option>
                            <option <?=$_GET['periodo'] == '24' ? 		"selected" : 'n' ?> value="24">Últimas 24 horas</option>
                            <option <?=$_GET['periodo'] == '168' ? 		"selected" : 'n' ?> value="168">Última semana</option>
                            <option <?=$_GET['periodo'] == '5040' ? 	"selected" : 'n' ?> value="5040">Último mês</option>
                            <option <?=$_GET['periodo'] == '1839600' ?  "selected" : 'n' ?> value="1839600">Último ano</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sel3"><strong>Filtre por ano</strong></label>
                        <select name="ano" class="form-control" id="sel3">                               
                            <?php 
                                $ano_agora = date('Y');
                                $date_range = range(2013, $ano_agora);
                                $anosArray = $date_range;

                                echo '<div class="transportX" style="display:none;"><option value="">Todos os anos</option>';				
                                    (sort($anosArray));
                                    
                                    foreach ((array_unique($anosArray)) as $ano) {
                                        $ano == $_GET['ano'] ? $isselected = 'selected' : $isselected = '';
                                        echo '<option '.$isselected.' value="'.$ano.'">'.$ano.'</option>';			
                                    }
                                echo '</div>';
                            ?>
                        </select>
                    </div>

                    <div class="form-group">

						<label for="sel3sites"><strong>Filtre por site</strong></label>
						<select name="site" class="form-control" id="sel3sites">

							<option value="">Todos os sites</option>
							<option <?=$_GET['site'] == '1' ? "selected" : '' ?> value="1">SME Portal Educação</option>
                            <option <?=$_GET['site'] == '8' ? "selected" : '' ?> value="8">DRE Butantã</option>
                            <option <?=$_GET['site'] == '20' ? "selected" : '' ?> value="20">DRE Campo Limpo</option>
                            <option <?=$_GET['site'] == '9' ? "selected" : '' ?> value="9">DRE Capela do Socorro</option>
                            <option <?=$_GET['site'] == '10' ? "selected" : '' ?> value="10">DRE Freguesia/Brasilândia</option>
                            <option <?=$_GET['site'] == '11' ? "selected" : '' ?> value="11">DRE Guaianases</option>
                            <option <?=$_GET['site'] == '12' ? "selected" : '' ?> value="12">DRE Ipiranga</option>
                            <option <?=$_GET['site'] == '13' ? "selected" : '' ?> value="13">DRE Itaquera</option>
                            <option <?=$_GET['site'] == '14' ? "selected" : '' ?> value="14">DRE Jaçanã/Tremembé</option>
                            <option <?=$_GET['site'] == '15' ? "selected" : '' ?> value="15">DRE Penha</option>
                            <option <?=$_GET['site'] == '16' ? "selected" : '' ?> value="16">DRE Pirituba</option>
                            <option <?=$_GET['site'] == '17' ? "selected" : '' ?> value="17">DRE Santo Amaro</option>
                            <option <?=$_GET['site'] == '18' ? "selected" : '' ?> value="18">DRE São Mateus</option>
                            <option <?=$_GET['site'] == '19' ? "selected" : '' ?> value="19">DRE São Miguel</option>
                            <option <?=$_GET['site'] == '5' ? "selected" : '' ?> value="5">CME Conselho</option>
                            <option <?=$_GET['site'] == '4' ? "selected" : '' ?> value="4">CAE Conselho</option>
                            <option <?=$_GET['site'] == '6' ? "selected" : '' ?> value="6">CACSFUNDEB Conselho</option>
                            <option <?=$_GET['site'] == '7' ? "selected" : '' ?> value="7">CRECE Conselho</option>
                        </select>
					</div>

                    <div class="form-group mb-3">
                        <script>
                            function limpaFiltro() {
                                setTimeout(() => {
                                    window.location = window.location.pathname + "?termo=<?=$_GET['termo'];?>";
                                }, 100);
                            }
                        </script>
                        <button onclick="limpaFiltro()" type="button" class="btn btn-refinar btn-sm float-left">Limpar filtros</button>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Refinar busca</button>

                    </div>

                </form>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
