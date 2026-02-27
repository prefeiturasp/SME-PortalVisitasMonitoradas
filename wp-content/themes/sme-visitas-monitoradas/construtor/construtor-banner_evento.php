<?php
$eventoDestaques= get_sub_field('evento_em_destaque');
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-12">
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
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <div class="infoline-ajust">
                                            <span class="info-date-banner">
                                                <?php
                                                    $datas = get_field('agenda', $eventID);

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
                                                    echo $dataNum . ' - ' . $mes;										
                                                ?> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="bannerhome-title"><?php echo $eventoDestaque->post_title; ?></div>
                                    </div>
                                    <div class="col-sm-3 text-right">
                                        <a href="<?= get_the_permalink($eventID); ?>" class="btn visitas-btn">Fazer inscrição</a>
                                    </div>
                                </div>
                                <div class="row bannerhome-infoline">
                                    <div class="col-sm-12">
                                        <?php
											$parceiro = get_field('parceiro', $eventID);
											$nomeParceiro = get_the_title($parceiro);
											$bairroParceiro = get_field('bairro_parceiro', $parceiro);
										?>
                                        <div class="infoline-ajust">
                                            <span class="info-local-banner"><?= $nomeParceiro . ', ' . $bairroParceiro; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                <div class="col-sm-12">
                                    <?php
                                        // Faixa Etaria
                                        $faixa = get_field('faixa_etaria', $eventID);
                                        $cor = get_field('cor', 'faixa-etaria_'.$faixa->term_id);
                                        $corTexto = get_field('cor_texto', 'faixa-etaria_'.$faixa->term_id);
                                        $icone = get_field('icone_tax', 'faixa-etaria_'.$faixa->term_id);
                                        if(!$icone){
                                            $icone = "/wp-content/uploads/2022/07/livre.png";
                                        }
                                    ?>
                                    <?php if($faixa): ?>
                                        <span class="pill" style="background: <?= $cor; ?>; color: <?= $corTexto; ?>;">
                                            <img src="<?= $icone; ?>" alt="<?= $faixa->name; ?>">
                                            <?= $faixa->name; ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php
                                        // Espacos
                                        $espacos = get_field('tipo_de_espaco', $eventID);												
                                        
                                    ?>
                                    <?php
                                        if($espacos):
                                            foreach($espacos as $espaco):
                                                $icone = get_field('icone_tax', 'tipo-espaco_'.$espaco->term_id);														
                                                if(!$icone){
                                                    $icone = "/wp-content/uploads/2022/07/teatro.png";
                                                }
                                            ?>
                                                <span class="pill pill-azul">
                                                    <img src="<?= $icone; ?>" alt="<?= $espaco->name; ?>">
                                                    <?= $espaco->name; ?>
                                                </span>
                                            <?php
                                            endforeach;
                                        endif;
                                    ?>
                                    <?php
                                        // Tipo Transporte
                                        $transporte = get_field('tipo_de_transporte', $eventID);
                                        //print_r($transporte);										
                                        
                                    ?>

                                    <?php if($transporte): ?>
                                        <span class="pill pill-cinza">
                                            <img src="/wp-content/uploads/2022/07/parceiros.png" alt="<?= $transporte->name; ?>">
                                            <?= $transporte->name; ?>
                                        </span>
                                    <?php endif; ?>                                 
                                    
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
        </div>
    </div>
</div>

