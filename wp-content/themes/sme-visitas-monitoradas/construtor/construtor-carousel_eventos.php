<?php
$idTaxEvento = get_sub_field('escolha_evento');
$term = get_term( $idTaxEvento );
?>

<div class="container mt-5 mb-5 p-0">

    <div class="row mt-2 mb-2 ml-0 mr-0">
        <div class="carousel-multiple-title col-sm-6">
            <h2 class="title-carousel-eventos"><?php echo $term->name; ?></h2>
        </div>
    </div>

    <div class="row mt-2 mb-3 ml-0 mr-0">
        <div class="divhr mt-2 mb-2"></div>
    </div>

    <div class="row">
        <div class="col-12">
            <section class="regular slider">
                
                <?php
                    $new_query = new WP_Query( array(
                        'posts_per_page' => 10,
                        'post_type'      => 'evento',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'tax_query' => array(
                            array (
                                'taxonomy' => 'tipo-espaco',
                                'field' => 'id',
                                'terms' => $idTaxEvento,
                            )
                        ),
                    ) );
                    
                    while ( $new_query->have_posts() ) : $new_query->the_post();
                        ?>

                        
                            <div class="content-carousel">
                                <div class="content-carousel-img">
                                    <?php
                                        $imagem = get_field('foto_do_evento');
                                        $showImage = $imagem['sizes']['home-thumb'];
                                        if(!$showImage){
                                            $showImage = 'http://via.placeholder.com/250x241';
                                        }
                                    ?>
                                    <img class="img-capa" src="<?= $showImage; ?>" alt="<?php echo the_title(); ?>"  width="250" height="241">
                                </div>
                                <div class="inner-content-carousel">
                                    <?php
                                        $datas = get_field('agenda');

                                        $dataNum = '';
                                        $dataNumCompare = array();
                                        $i = 0;
                                        foreach($datas as $data){
                                            if($i == 0 && !in_array(substr($data['data_hora'], 0, 2), $dataNumCompare) ){
                                                $dataNum .= substr($data['data_hora'], 0, 2);
                                            } elseif( !in_array(substr($data['data_hora'], 0, 2), $dataNumCompare) ) {
                                                $dataNum .= ', ' . substr($data['data_hora'], 0, 2);
                                            }
                                            $dataNumCompare[] = substr($data['data_hora'], 0, 2);
                                            $i++;
                                        }
                                        $dataNumCompare = array();
            
                                        $last = end($datas);
                                        $lastMont = substr($data['data_hora'], 3, 2);
                                        $mes = convertMonth($lastMont);
                                                                            
                                    ?>
                                    <div class="data-content-carousel mt-2 mb-2"><?= $dataNum . ' - ' . $mes;	; ?></div>
                                    <div class="title-content-carousel mt-2 mb-2"><?php the_title(); ?></div>
                                    <?php
                                        $parceiro = get_field('parceiro');
                                        $nomeParceiro = get_the_title($parceiro);
                                        $bairroParceiro = get_field('bairro_parceiro', $parceiro);
                                    ?>
                                    <?php if($parceiro): ?>
                                        <div class="desc-content-carousel mt-2 mb-2"><?= $nomeParceiro . ', ' . $bairroParceiro; ?></div>
                                    <?php endif; ?>
                                    
                                    <div class="pills mt-3 mb-3">
                                        <?php
                                            // Faixa Etaria
                                            $faixa = get_field('faixa_etaria');
                                            $cor = get_field('cor', 'faixa-etaria_'.$faixa->term_id);
                                            $corTexto = get_field('cor_texto', 'faixa-etaria_'.$faixa->term_id);
                                            $icone = get_field('icone_tax', 'faixa-etaria_'.$faixa->term_id);
                                            if(!$icone){
                                                $icone = "/wp-content/uploads/2022/07/livre.png";
                                            }
                                        ?>
                                        <?php if($faixa): ?>
                                            <span class="pill-out" style="background: <?= $cor; ?>; color: <?= $corTexto; ?>;">
                                                <img src="<?= $icone; ?>" alt="<?= $faixa->name; ?>" width="15" height="15">
                                                <?= $faixa->name; ?>
                                            </span>
                                        <?php endif; ?>

                                        <?php
                                            // Faixa Etaria
                                            $espacos = get_field('tipo_de_espaco');												
                                            
                                        ?>
                                        <?php
                                            if($espacos):
                                                foreach($espacos as $espaco):
                                                    $icone = get_field('icone_tax', 'tipo-espaco_'.$espaco->term_id);														
                                                    if(!$icone){
                                                        $icone = "/wp-content/uploads/2022/07/teatro.png";
                                                    }
                                                ?>
                                                    <span class="pill-out">
                                                        <img src="<?= $icone; ?>" alt="<?= $espaco->name; ?>" width="15" height="15">
                                                        <?= $espaco->name; ?>
                                                    </span>
                                                <?php
                                                endforeach;
                                            endif;
                                        ?>
                                        
                                        <?php
                                            // Tipo Transporte
                                            $transporte = get_field('tipo_de_transporte');
                                            //print_r($transporte);										
                                            
                                        ?>

                                        <?php if($transporte): ?>
                                            <span class="pill-out">
                                                <img src="/wp-content/uploads/2022/07/busque-por-parceiro.png" alt="<?= $transporte->name; ?>" width="15" height="15">
                                                <?= $transporte->name; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <a href="<?= get_the_permalink(); ?>" class="btn visitas-btn btn-block">inscreva-se</a>
                                </div>
                            </div>
                        
                        <?php

                    endwhile;
                    wp_reset_postdata();
                ?>
                
            </section>
        </div>
    </div>
</div>

<script>
    jQuery(document).on('ready', function() {

        jQuery('.slider').on('init', function(event, slick){
            var maxHeight = 0;
            jQuery('.slick-slide', this).each(function(){
                var slideHeight = jQuery(this).height();
                if (slideHeight > maxHeight) {
                maxHeight = slideHeight;
                }
            });
            jQuery('.slick-slide', this).css('height', maxHeight + 'px');
        });

        jQuery(".regular").slick({
            dots: false,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 2,
            centerPadding:'50px',
            prevArrow:'<img src="/wp-content/uploads/2022/07/arrow-left.png" alt="erquerda" class="arrow-left">',
            nextArrow: '<img src="/wp-content/uploads/2022/07/arrow-right.png" alt="direita">',
            centerMode: false
        });
    });
</script>