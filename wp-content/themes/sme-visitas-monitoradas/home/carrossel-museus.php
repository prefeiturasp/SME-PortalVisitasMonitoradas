<?php
if( have_rows('construtor_home') ):
    while ( have_rows('construtor_home') ) : the_row();
        if( get_row_layout() == 'adicionar_evento'):
            echo get_sub_field('carousel_eventos_home').'<br>';
            echo '<hr>';
        elseif( get_row_layout() == 'adiconar_newsletter'):
            echo get_sub_field('titulo').'<br>';
            echo '<hr>';
        endif;
    endwhile;
endif;

$new_query = new WP_Query( array(
    'posts_per_page' => 10,
    'post_type'      => 'evento',
    'orderby' => 'date',
    'order' => 'ASC',
    'tax_query' => array(
        array (
            'taxonomy' => 'tipo-espaco',
            'field' => 'slug',
            'terms' => 'cinemas',
        )
    ),
) );

while ( $new_query->have_posts() ) : $new_query->the_post();

    the_title('');

endwhile;
wp_reset_postdata();
?>
<div class="row mt-2 mb-2">
    <div class="carousel-multiple-title col-sm-6">
        <h2>Museus ></h2>
    </div>
    <div class="col-sm-6 text-right">
        <a class="" href="#carousel-museus" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="" href="#carousel-museus" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>
<div class="row mt-2 mb-3">
    <div class="divhr mt-2 mb-2"></div>
</div>
<div class="p-3 m-n3 overflow-hidden">
    <div id="carousel-museus" class="carousel carousel-museus slide carousel-multiple" data-ride="carousel" data-interval="9999" data-pause="hover"
         data-maximum-items-per-slide="4">
        <div class="row position-relative">
            <div class="row carousel-inner mx-0">
                <div class="carousel-item col-sm-6 col-md-4 col-lg-3 active">
                    <div class="content-carousel">
                        <div class="content-carousel-img">
                            <div class="pills-inner">
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Livre
                                </span>
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Ação
                                </span>
                            </div>
                            <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="">
                        </div>
                        <div class="inner-content-carousel">
                            <div class="data-content-carousel mt-2 mb-2">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="">
                                20,21 - Junho
                            </div>
                            <div class="title-content-carousel mt-2 mb-2">
                                homem-Aranha: Sem Volta para Casa
                            </div>
                            <div class="desc-content-carousel mt-2 mb-2">
                                Shopping Iguatemi, Jardim Paulistano
                            </div>
                            <div class="pills mt-3 mb-3">
                                <span class="pill-out">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Parceiro
                                </span>
                            </div>
                            <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-sm-6 col-md-4 col-lg-3">
                    <div class="content-carousel">
                        <div class="content-carousel-img">
                            <div class="pills-inner">
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Livre
                                </span>
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Ação
                                </span>
                            </div>
                            <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="">
                        </div>
                        <div class="inner-content-carousel">
                            <div class="data-content-carousel mt-2 mb-2">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="">
                                20,21 - Junho
                            </div>
                            <div class="title-content-carousel mt-2 mb-2">
                                homem-Aranha: Sem Volta para Casa
                            </div>
                            <div class="desc-content-carousel mt-2 mb-2">
                                Shopping Iguatemi, Jardim Paulistano
                            </div>
                            <div class="pills mt-3 mb-3">
                                <span class="pill-out">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Parceiro
                                </span>
                            </div>
                            <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-sm-6 col-md-4 col-lg-3">
                    <div class="content-carousel">
                        <div class="content-carousel-img">
                            <div class="pills-inner">
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Livre
                                </span>
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Ação
                                </span>
                            </div>
                            <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="">
                        </div>
                        <div class="inner-content-carousel">
                            <div class="data-content-carousel mt-2 mb-2">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="">
                                20,21 - Junho
                            </div>
                            <div class="title-content-carousel mt-2 mb-2">
                                homem-Aranha: Sem Volta para Casa
                            </div>
                            <div class="desc-content-carousel mt-2 mb-2">
                                Shopping Iguatemi, Jardim Paulistano
                            </div>
                            <div class="pills mt-3 mb-3">
                                <span class="pill-out">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Parceiro
                                </span>
                            </div>
                            <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-sm-6 col-md-4 col-lg-3">
                    <div class="content-carousel">
                        <div class="content-carousel-img">
                            <div class="pills-inner">
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Livre
                                </span>
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Ação
                                </span>
                            </div>
                            <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="">
                        </div>
                        <div class="inner-content-carousel">
                            <div class="data-content-carousel mt-2 mb-2">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="">
                                20,21 - Junho
                            </div>
                            <div class="title-content-carousel mt-2 mb-2">
                                homem-Aranha: Sem Volta para Casa
                            </div>
                            <div class="desc-content-carousel mt-2 mb-2">
                                Shopping Iguatemi, Jardim Paulistano
                            </div>
                            <div class="pills mt-3 mb-3">
                                <span class="pill-out">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Parceiro
                                </span>
                            </div>
                            <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-sm-6 col-md-4 col-lg-3">
                    <div class="content-carousel">
                        <div class="content-carousel-img">
                            <div class="pills-inner">
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Livre
                                </span>
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Ação
                                </span>
                            </div>
                            <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="">
                        </div>
                        <div class="inner-content-carousel">
                            <div class="data-content-carousel mt-2 mb-2">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="">
                                20,21 - Junho
                            </div>
                            <div class="title-content-carousel mt-2 mb-2">
                                homem-Aranha: Sem Volta para Casa
                            </div>
                            <div class="desc-content-carousel mt-2 mb-2">
                                Shopping Iguatemi, Jardim Paulistano
                            </div>
                            <div class="pills mt-3 mb-3">
                                <span class="pill-out">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Parceiro
                                </span>
                            </div>
                            <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-sm-6 col-md-4 col-lg-3">
                    <div class="content-carousel">
                        <div class="content-carousel-img">
                            <div class="pills-inner">
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Livre
                                </span>
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Ação
                                </span>
                            </div>
                            <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="">
                        </div>
                        <div class="inner-content-carousel">
                            <div class="data-content-carousel mt-2 mb-2">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="">
                                20,21 - Junho
                            </div>
                            <div class="title-content-carousel mt-2 mb-2">
                                homem-Aranha: Sem Volta para Casa
                            </div>
                            <div class="desc-content-carousel mt-2 mb-2">
                                Shopping Iguatemi, Jardim Paulistano
                            </div>
                            <div class="pills mt-3 mb-3">
                                <span class="pill-out">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Parceiro
                                </span>
                            </div>
                            <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-sm-6 col-md-4 col-lg-3">
                    <div class="content-carousel">
                        <div class="content-carousel-img">
                            <div class="pills-inner">
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Livre
                                </span>
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Ação
                                </span>
                            </div>
                            <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="">
                        </div>
                        <div class="inner-content-carousel">
                            <div class="data-content-carousel mt-2 mb-2">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="">
                                20,21 - Junho
                            </div>
                            <div class="title-content-carousel mt-2 mb-2">
                                homem-Aranha: Sem Volta para Casa
                            </div>
                            <div class="desc-content-carousel mt-2 mb-2">
                                Shopping Iguatemi, Jardim Paulistano
                            </div>
                            <div class="pills mt-3 mb-3">
                                <span class="pill-out">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Parceiro
                                </span>
                            </div>
                            <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                        </div>
                    </div>
                </div>
                <div class="carousel-item col-sm-6 col-md-4 col-lg-3">
                    <div class="content-carousel">
                        <div class="content-carousel-img">
                            <div class="pills-inner">
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Livre
                                </span>
                                <span class="pill">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Ação
                                </span>
                            </div>
                            <img class="img-capa" src="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/wp-content/uploads/2022/07/homemaranha.jpg" alt="">
                        </div>
                        <div class="inner-content-carousel">
                            <div class="data-content-carousel mt-2 mb-2">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="">
                                20,21 - Junho
                            </div>
                            <div class="title-content-carousel mt-2 mb-2">
                                homem-Aranha: Sem Volta para Casa
                            </div>
                            <div class="desc-content-carousel mt-2 mb-2">
                                Shopping Iguatemi, Jardim Paulistano
                            </div>
                            <div class="pills mt-3 mb-3">
                                <span class="pill-out">
                                    <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                    Parceiro
                                </span>
                            </div>
                            <button type="button" class="btn visitas-btn btn-block">inscreva-se</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>