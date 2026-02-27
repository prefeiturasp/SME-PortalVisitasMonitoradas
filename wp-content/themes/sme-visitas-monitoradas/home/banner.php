<?php
$eventoDestaques = get_field('evento_em_destaque_na_home');
//echo '<pre>';
//var_dump($eventoDestaques);
//echo '</pre>';
/*foreach ($eventoDestaques as $eventoDestaque){
   $eventID = $eventoDestaque->ID;
   $img = get_field('foto_do_evento', $eventID);
   ?>
    <img src="<?php echo $img['url'] ?>" alt=" <?php echo $eventoDestaque->post_title; ?>">
    <?php
}*/
?>

<div id="bannerhome" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover">
    <ul class="carousel-indicators carousel-indicators-banner">
        <?php
        $countSliderIndicator = 0;
        foreach ($eventoDestaques as $eventoDestaque){
            ?>
            <li data-target="#bannerhome" data-slide-to="<?php echo $countSliderIndicator; ?>" class="<?php if($countSliderIndicator === 0){echo 'active';} ?>"></li>
            <?php
            $countSliderIndicator++;
        }
        ?>
    </ul>
    <div class="carousel-inner">
        <?php
        $countSlider = 0;
        foreach ($eventoDestaques as $eventoDestaque){
            $eventID = $eventoDestaque->ID;
            $img = get_field('foto_do_evento', $eventID);
            ?>
            <div class="carousel-item bannerhome-item <?php if($countSlider === 0){echo 'active';} ?>">
                <img class="bannerhome-img" src="<?php echo $img['url'] ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                <div class="bannerhome-content">
                    <div class="row mt-3 mb-3">
                        <div class="col-sm-10">
                            <div class="bannerhome-title"><?php echo $eventoDestaque->post_title; ?></div>
                        </div>
                        <div class="col-sm-2 jcc text-right">
                            <button type="button" class="btn visitas-btn">inscreva-se</button>
                        </div>
                    </div>
                    <div class="row bannerhome-infoline  mt-3 mb-3">
                        <div class="col-sm-3">
                            <div class="infoline-ajust">
                                <?php
                                if( have_rows('agenda', $eventID) ):
                                    while( have_rows('agenda', $eventID) ) : the_row();
                                        $date_variable = get_sub_field('data_hora');
                                        $date_format_in = 'd/m/Y g:i a';
                                        $date_format_out = 'd/m/Y';
                                        $date = DateTime::createFromFormat( $date_format_in, $date_variable );
                                        ?>
                                        <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                        <span><?php echo $date->format( $date_format_out ); ?></span>
                                        <?php
                                    endwhile;
                                else :
                                endif;
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="infoline-ajust">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                <span>Shopping Iguatemi, Jardim Paulistano</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-sm-12">
                            <span class="pill">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                <?php
                                $faixas = get_field('faixa_etaria', $eventID);
                                echo $faixas->name;
                                ?>
                            </span>
                            <span class="pill">
                                <img src="<?php echo get_template_directory_uri().'/img/image-icon.png'; ?>" alt="<?php echo $eventoDestaque->post_title; ?>">
                                <?php
                                $faixas = get_field('faixa_etaria', $eventID);
                                echo $faixas->name;
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $countSlider++;
        }
        ?>
    </div>
    <a class="carousel-control-prev" href="#bannerhome" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#bannerhome" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>




