<?php
    $titulo = get_sub_field('titulo_principal');
    $titulo_result = get_sub_field('titulo_resultados');
    $descri_result = get_sub_field('descricao_resultados');
?>
<div class="container">
    <div class="row">
        <?php if( $titulo && empty($_GET) ): ?>
            <div class="col-12">
                <h1 class="text-center mb-4 mt-5"><?= $titulo; ?></h1>
            </div>
        <?php endif; ?>
        <?php if( $titulo_result && !empty($_GET) ): ?>
            <div class="offset-md-3 col-md-6 col-12 results-text">
                <h1 class="text-center mb-4 mt-5"><?= $titulo_result; ?></h1>
                <p><?= $descri_result; ?></p>
            </div>
        <?php endif; ?>
        <div class="offset-md-2 col-md-8 col-12">

            <form action="<?= get_the_permalink(); ?>" class="mb-4">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="inputEmail4" class="d-none">Busque por título ou palavra-chave</label>
                        <input name="term" type="text" class="form-control" id="inputEmail4" placeholder="Busque por título ou palavra-chave" value="<?= $_GET['term']; ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputState" class="d-none">Filtrar por</label>
                        <select id="inputState" class="form-control" name="filtro">
                            <option value="" selected>Filtrar por</option>
                            <option value="titulo" <?php if($_GET['filtro'] == 'titulo'){ echo 'selected'; }?>>Título</option>
                            <option value="conteudo" <?php if($_GET['filtro'] == 'conteudo'){ echo 'selected'; }?>>Palavra</option>
                        </select>
                        <?php if(!empty($_GET)) :?>
                            <span class="d-block text-right clear-search"><a href="<?= get_the_permalink(); ?>">Limpar filtros</a></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-card m-0">Pesquisar</button>
                    </div>

                </div>                
            </form>
            
            <?php if(empty($_GET)): ?>
                <div class="embed-container my-5">
                    <?= get_sub_field('video'); ?>
                </div>
            <?php endif; ?>

            <h2 class="text-center mb-5">Dúvidas Frequentes</h2>

            <div id="accordion" class="my-3 accordion-faq">

                <?php
                $args = array(
                    'post_type' => 'faq-duvidas',
                    'posts_per_page' => -1,
                );
                if($_GET['term'] != '' && $_GET['filtro'] == ''){
                    $args['s'] = $_GET['term'];
                } elseif($_GET['term'] != '' && $_GET['filtro'] == 'titulo'){
                    $args['search_prod_title'] = $_GET['term'];
                } elseif($_GET['term'] != '' && $_GET['filtro'] == 'conteudo'){
                    $args['search_prod_content'] = $_GET['term'];
                }

                // aplicar o filtro por tipo de conteudo
                if($_GET['filtro'] == 'titulo'){
                    add_filter( 'posts_where', 'title_filter', 10, 2 );
                } elseif($_GET['filtro'] == 'conteudo'){
                    add_filter( 'posts_where', 'content_filter', 10, 2 );
                }
                
                $the_query = new WP_Query( $args );

                // remover o filtro por tipo de conteudo
                if($_GET['filtro'] == 'titulo'){
                    remove_filter( 'posts_where', 'title_filter', 10, 2 );
                } elseif($_GET['filtro'] == 'conteudo'){
                    remove_filter( 'posts_where', 'content_filter', 10, 2 );
                }
                
                ?>

                <?php if ( $the_query->have_posts() ) : ?>

                    <!-- pagination here -->

                    <!-- the loop -->
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <div class="card sanfona">
                            <div class="card-header" id="heading<?= get_the_ID(); ?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed card-link" data-toggle="collapse" data-target="#collapse<?= get_the_ID(); ?>" aria-expanded="true" aria-controls="collapse<?= get_the_ID(); ?>">
                                    <?= get_the_title(); ?>
                                </button>
                            </h5>
                            </div>

                            <div id="collapse<?= get_the_ID(); ?>" class="collapse" aria-labelledby="heading<?= get_the_ID(); ?>" data-parent="#accordion">
                            <div class="card-body">
                                <?= get_the_content(); ?>
                            </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <!-- end of the loop -->

                    <!-- pagination here -->

                    <?php wp_reset_postdata(); ?>

                <?php else : ?>
                    <p><?php _e( 'Desculpe, nenhuma dúvida frequente encontrada.' ); ?></p>
                <?php endif; ?>
                
            </div>

        </div>
    </div>
</div>