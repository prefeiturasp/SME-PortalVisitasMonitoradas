<?php

    function inverteData($data){
        if(count(explode("/",$data)) > 1){
            return implode("-",array_reverse(explode("/",$data)));
        }elseif(count(explode("-",$data)) > 1){
            return implode("/",array_reverse(explode("-",$data)));
        }
    }

    $status_icon = array(
        'nova' => '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Nova inscrição"><i class="fa fa-bookmark" aria-hidden="true"></i></span>',
        'andamento' => '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Inscrição em andamento"><i class="fa fa-clock-o" aria-hidden="true"></i></span>',
        'confirmada' => '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Inscrição confirmada"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>',
        'negado' => '<span class="d-inline-block negado" tabindex="0" data-toggle="tooltip" title="Inscrição negada"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>',
        'cancelada' => '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Cancelado pela UE"><i class="fa fa-ban text-danger"></i></span>',
        'realizada' => '<span class="d-inline-block realizada" tabindex="0" data-toggle="tooltip" title="Visita realizada"><i class="fa fa-flag" aria-hidden="true"></i></span>',
    );
?>

<div class="container">
    <div class="row">

        <div class="col-12 my-4">
            <form action="<?= get_the_permalink(); ?>" class="mb-4">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <p class="m-0"><strong>Busque por título ou palavra-chave</strong></p>
                        <label for="inputEmail4" class="d-none">Busque por título ou palavra-chave</label>
                        <input name="term" type="text" class="form-control" id="inputEmail4" placeholder="Busque por título ou palavra-chave" value="<?= $_GET['term']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <p class="m-0"><strong>Busque por periodo</strong></p>
                        <div class="form-row">
                            <div class="col-6">                                
                                <input type="date" id="data_init" name="data_init" class="form-control" value="<?= $_GET['data_init']; ?>">
                                <small><label for="data_init" class="label_data">Data inicial</label></small>
                            </div>
                            <div class="col-6">                                
                                <input type="date" id="data_final" name="data_final" class="form-control" value="<?= $_GET['data_final']; ?>">
                                <small><label for="data_final" class="label_data">Data final</label></small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12 p-0 d-flex justify-content-end">
                        <a href="<?= get_the_permalink(); ?>" class="btn btn-card m-0 mr-2">Limpar filtros</a>
                        <button type="submit" class="btn btn-card m-0">Pesquisar</button>
                    </div>

                </div>                
            </form>
        </div>

        <div class="col-12">
            <?php
                function wcmo_get_current_user_roles() {
                    if( is_user_logged_in() ) {
                    $user = wp_get_current_user();
                    $roles = ( array ) $user->roles;                    
                        return $roles[0];
                    } else {
                        return array();
                    }
                }

                $current_user = wcmo_get_current_user_roles();
                
                if($current_user == 'parceiro'){
                    $parceiros_ativos = get_field('unidades_parceiras', 'user_' . get_current_user_id());
                }
            ?>
        </div>

        <div class="col-12">
            <?php                      
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'agendamento',
                    'posts_per_page' => 5,
                    'paged' => $paged,
                    'post_status' => array('publish', 'pending', 'draft'),
                    'meta_key'      => 'data_escolhida', //ACF date field 
                    'orderby' => 'meta_value',                  
                    'meta_query' => array(
                        'relation' => 'AND'
                    )
                );

                if($current_user != 'parceiro'){
                    $args['author'] = get_current_user_id();
                } else {                    
                    if($parceiros_ativos && is_array($parceiros_ativos)){
                        $args['meta_query']['relation'] = 'OR';
                        foreach($parceiros_ativos as $parceiro){
                            $args['meta_query'][] = array(
                                'key' => 'parceiro', 
                                'value' => $parceiro,
                                'compare' => 'LIKE'
                            );
                        }
                    } else {
                        $args['author'] = 99999;
                    }
                    
                }


                if($_GET['term'] != ''){
                    $args['s'] = $_GET['term'];
                }

                if($_GET['data_init'] && $_GET['data_init'] != ''){
                    $args['meta_query'][] = array(
                        'key' => 'data_escolhida', // Check the start date field
                        'value' => date($_GET['data_init']), // Set today's date (note the similar format)
                        'compare' => '>=', // Return the ones greater than today's date
                        'type' => 'DATE' // Let WordPress know we're working with date
                    );
                }

                if($_GET['data_final'] && $_GET['data_final'] != ''){
                    $args['meta_query'][] = array(
                        'key' => 'data_escolhida', // Check the start date field
                        'value' => date($_GET['data_final']), // Set today's date (note the similar format)
                        'compare' => '<=', // Return the ones greater than today's date
                        'type' => 'DATE' // Let WordPress know we're working with date
                    );
                }

                //print_r($args);
                

                // The Query
                $the_query = new WP_Query( $args );

                // The Loop
                if ( $the_query->have_posts() ) :
            ?>
                <table class="table table-default table-hover table-responsive-lg">
                    <thead>
                        <?php if($current_user == 'parceiro'): ?>                            
                            <tr>
                                <th scope="col">Evento</th>
                                <th scope="col">Data/hora agendamento</th>                                
                                <th scope="col">Nº de inscritos</th>
                                <th scope="col">Transporte</th>
                                <th scope="col">Status</th>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <th scope="col">Evento</th>
                                <th scope="col">Data/hora agendamento</th>
                                <th scope="col">Transporte</th>
                                <th scope="col">Status</th>
                                <th scope="col">Cancelar</th>
                                <th scope="col">Avaliar</th>
                            </tr>
                        <?php endif; ?>
                    </thead>
                    <tbody> 

            <?php
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        
                        $get_data = get_field('data_horario');
                        $data_hora = explode( '[', $get_data );
                        $data = substr($get_data, 0, 10);
                        $data = inverteData($data);

                        $tipo_transporte = '';
                        $transporte = get_field('transporte');
                        if($transporte){
                            $tipo_transporte = get_field('tipo_transporte');
                            if($tipo_transporte == 'dre'){
                                $tipo_transporte = 'DRE';
                            } else {
                                $tipo_transporte = 'Parceiro';
                            }
                        } else {
                            $tipo_transporte = 'Próprio UE';
                        }

                        $status = get_field('status');
                        if(is_array($status)){
                            $status = $status['value'];
                        }

                        $avaliacao = get_field('aval_resp');
                        
                        $hoje = date('Y-m-d');
                        
                        // Use strtotime() function to convert
                        // date into dateTimestamp
                        $dateTimestamp1 = strtotime($data);
                        $dateTimestamp2 = strtotime($hoje);
                        
                        // data do evento menor que data atual
                        // evento ainda nao avaliado
                        // Status foi confirmado                        
                        if($dateTimestamp1 < $dateTimestamp2 && !$avaliacao && $status == 'confirmada'){
                            $avaliar = '<a href="' . get_home_url() . '/avaliacao/?id_evento=' . get_the_ID() . '" class="btn btn-outline-info btn-sm">Avaliar</a>';
                        } elseif($dateTimestamp1 < $dateTimestamp2 && $avaliacao && $status == 'confirmada'){
                            $avaliar = '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Este evento já foi avaliado"><i class="fa fa-star" aria-hidden="true"></i></span>';
                        } else {
                            $avaliar = '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Este evento não pode ser avaliado"><i class="fa fa-ban text-danger"></i></span>';
                        }

                        $date1 = new DateTime($data);
                        $date2 = new DateTime($hoje);
                        $days = $date2->diff($date1)->format('%a');

                        if($dateTimestamp1 > $dateTimestamp2 && $days > 7 && $status == 'confirmada'){
                            $cancelar = '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Cancelar inscrição para este evento">
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmUpdate(' . get_the_ID() .')"><i class="fa fa-ban" aria-hidden="true"></i></button>
                            </span>';
                        } else {
                            $cancelar = '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Este inscrição não pode ser cancelada">
                                <button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-ban" aria-hidden="true"></i></button>
                            </span>';
                        }
                        if($current_user == 'parceiro'){
                            if($dateTimestamp1 < $dateTimestamp2 && !$avaliacao && $status == 'confirmada'){
                                $status = 'realizada';
                            }
                            echo '<tr>';
                            echo '<td scope="row"><span id="title_' . get_the_ID() . '">' . get_the_title() . '</span></td>';
                            echo '<td>' . $data_hora[0] . '</td>';                            
                            echo '<td class="text-center">' . get_field('num_estudantes') . '</td>';
                            echo '<td>' . $tipo_transporte . '</td>';
                            echo '<td class="text-center">' . $status_icon[$status] . '</td>';
                        echo '</tr>';
                        } else {
                            echo '<tr>';
                            echo '<td scope="row"><span id="title_' . get_the_ID() . '">' . get_the_title() . '</span></td>';
                            echo '<td>' . $data_hora[0] . '</td>';
                            echo '<td>' . $tipo_transporte . '</td>';
                            echo '<td class="text-center">' . $status_icon[$status] . '</td>';
                            echo '<td class="text-center">' . $cancelar . '</td>';
                            echo '<td class="text-center">' . $avaliar . '</td>';
                        echo '</tr>';
                        }
                        
                    }
            ?>
                    </tbody>
                </table>

                <div class="container my-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pagination-prog text-center">
                                <?php wp_pagenavi( array( 'query' => $the_query ) ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php
            
                else:
                    echo "<h3>Nenhuma inscrição encontrada.</h3>";
                endif;
                /* Restore original Post Data */
                wp_reset_postdata();
            ?>
            
        </div>
    </div>
</div>