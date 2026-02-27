<?php
namespace Classes\ModelosDePaginas\Inscricoes;


use Classes\Lib\Util;

class Inscricoes extends Util{

    public function __construct(){		
		$this->montaHtmlIncricoes();
	}

    public function montaHtmlIncricoes(){
            $user_id = get_current_user_id();
            $dre = get_field('dre', 'user_' . $user_id);

            $posts = get_posts(array(
                'numberposts'   => 1,
                'post_type'     => 'editores_portal',
                'meta_query'    => array(        
                    array(
                        'key'       => 'dre',
                        'value'     => $dre,
                        'compare'   => 'LIKE'
                    ),
                ),
            ));

            if($posts){
                $dre = $posts[0]->ID;
            }

            $infos = get_field('endereco', 'user_' . $user_id);
            $user_meta = get_user_meta( $user_id );
            $current_user = wp_get_current_user();
            //echo "<pre>";
            //print_r($current_user->data->user_email);
            //echo "</pre>";
        ?>

            <div class="title-bg py-5 mb-4">
                <div class="container">
                    <h1><?= get_the_title($_GET['eventoid']); ?></h1>

                    <div class="infoline-ajust">
                        <img src="<?= get_template_directory_uri(); ?>/classes/assets/img/calendar.png" alt="icone calendário"> 
                        <span class="info-date-banner">
                            
                            <?php
                                $datas = get_field('agenda', $_GET['eventoid']);

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

                    <div class="row bannerhome-infoline mt-2">
                        <div class="col-sm-12">						
                            <?php
                                $parceiro = get_field('parceiro', $_GET['eventoid']);
                                $nomeParceiro = get_the_title($parceiro);
                                $bairroParceiro = get_field('bairro_parceiro', $parceiro);
                            ?>
                            <div class="infoline-ajust">
                                <img src="<?= get_template_directory_uri(); ?>/classes/assets/img/map-pin.png" alt="icone mapa"> 
                                <span class="info-local-banner"><?= $nomeParceiro . ', ' . $bairroParceiro; ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

		    <div class="container">
                <div class="col-md-10 offset-md-1">
                    <p><a href="<?= get_the_permalink($_GET['eventoid']); ?>" class="return-link">< Voltar para o evento</a></p>
                    <div class="inscricoes">

                        <form id="example-form" action="<?= get_the_permalink() . '?eventoid=' . $_GET['eventoid'];?>" method="POST">
                            <div>

                                <h3>Agendamento <br>e transporte</h3>
                                <section>
                                    <label for="nome_ue">Nome da UE:</label>
                                    <?php 
                                        if( $_POST['nome_ue'] != '' && isset($_POST['nome_ue']) ){
                                            $ue = $_POST['nome_ue'];
                                        } else {
                                            $ue = $user_meta['endereco_nome_da_ue'][0];
                                        }
                                    ?>
                                    <input id="nome_ue" name="nome_ue" value="<?= $ue; ?>" type="text" class="required form-control">
                                    <?php 
                                        if($_POST['dre'] && $_POST['dre'] != ''){
                                            $dre = $_POST['dre'];
                                        }
                                    ?>
                                    <label for="dre">DRE:</label>
                                    <select id="dre" name="dre" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                        $params = array(
                                            'post_type' => 'editores_portal',
                                            'posts_per_page' => -1,
                                            'orderby' => 'title',
	                                        'order'   => 'ASC',
                                        );
                                        $grupos_dres = new \WP_Query( $params );

                                        // The Loop
                                        if ( $grupos_dres->have_posts() ) {
                                            
                                            while ( $grupos_dres->have_posts() ) {
                                                $grupos_dres->the_post();
                                            ?>
                                                <option value="<?= get_the_ID(); ?>" <?= $dre == get_the_ID() ? "selected" : ''; ?>><?= get_the_title(); ?></option>                                            
                                            <?php
                                            }
                                            
                                        } 
                                        /* Restore original Post Data */
                                        wp_reset_postdata();
                                        ?>                                        
                                    </select>

                                    <?php 
                                        if( $_POST['telefone_ue'] != '' && isset($_POST['telefone_ue']) ){
                                            $tel = $_POST['telefone_ue'];
                                        } else {
                                            $tel = $user_meta['endereco_telefone'][0];
                                        }
                                    ?>

                                    <label for="telefone_ue">Telefone da UE:</label>
                                    <input id="telefone_ue" name="telefone_ue" value="<?= $tel; ?>" type="text" class="required form-control tel-mask" placeholder="(00) 0000-0000">

                                    <?php
                                        $agenda = get_field('agenda', $_GET['eventoid']);                                        
                                    ?>
                                    
                                    <div class="row">
                                        <div class="col">
                                            <label for="data_hora">Data/Horário da visita:</label>
                                            <select id="data_hora" name="data_hora" class="required form-control">
                                                <option value="">Selecione</option>
                                                <?php
                                                    foreach($agenda as $key => $horario){
                                                        if($horario['status'] == 'Disponível'){
                                                            echo "<option value='" . $horario['data_hora'] . " [$key] (" . $horario['convites_disponiveis'] . ")'>" . $horario['data_hora'] . "</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    
                                    <?php
                                        $tipo_evento = get_field('tipo_do_evento', $_GET['eventoid']);
                                        if($tipo_evento != 'escola'):
                                    ?>
                                        <hr>
                                        
                                        <?php $select_transporte = $_POST['select_transporte']; ?>
                                        <label for="select_transporte">UE precisa de transporte da DRE ou Parceiro?:</label>
                                        <select id="select_transporte" name="select_transporte" class="form-control">
                                            <option value="1" <?= $select_transporte == '1' ? "selected" : ''; ?>>Sim</option>
                                            <option value="0" <?= $select_transporte == '0' ? "selected" : ''; ?>>Não</option>
                                        </select>

                                        <div id="info-transporte" <?= $transporte == '0' ? "style='display: none;'" : ''; ?>>
                                            <p><strong>Horários:</strong></p>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="saida_oni">Saída do ônibus para a Visita:</label>
                                                    <input type="time" id="saida_oni" name="saida_oni" class="required form-control" value="<?= $_POST['saida_oni']; ?>">
                                                </div>
                                                <div class="col">
                                                    <label for="retorno_oni">Retorno à UE:</label>
                                                    <input type="time" id="retorno_oni" name="retorno_oni" class="required form-control" value="<?= $_POST['retorno_oni']; ?>">
                                                </div>
                                            </div>

                                            <?php 
                                                if( $_POST['end_ue'] != '' && isset($_POST['end_ue']) ){
                                                    $end_ue = $_POST['end_ue'];
                                                } else {
                                                    $end_ue = $user_meta['endereco_logradouro'][0] . ', ' . $user_meta['endereco_numero'][0] . ' - ' . $user_meta['endereco_bairro'][0];
                                                }
                                            ?>

                                            <label for="end_ue">Endereço da UE:</label>
                                            <input id="end_ue" name="end_ue" type="text" value="<?= $end_ue; ?>" class="required form-control">

                                            <label for="ponto_ue">Ponto de referência da UE:</label>
                                            <input id="ponto_ue" name="ponto_ue" type="text" class="required form-control" value="<?= $_POST['ponto_ue']; ?>">
                                        
                                        </div>
                                    <?php endif; ?>

                                </section>

                                <h3>Dados dos <br>educadores</h3>
                                <section>
                                    
                                    <?php 
                                        if( $_POST['nome_resp'] != '' && isset($_POST['nome_resp']) ){
                                            $nome_resp = $_POST['nome_resp'];
                                        } else {
                                            $nome_resp = $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0];
                                        }
                                    ?>

                                    <label for="nome_resp">Nome do responsável:</label>
                                    <input id="nome_resp" name="nome_resp" type="text" value="<?= $nome_resp; ?>" class="required form-control">

                                    <label for="contato_resp">Contato do responsável:</label>
                                    <input id="contato_resp" name="contato_resp" type="text" class="required form-control tel-mask" value="<?= $_POST['contato_resp']; ?>" placeholder="(00) 0000-0000">
                                    
                                    <?php 
                                        if( $_POST['email_resp'] != '' && isset($_POST['email_resp']) ){
                                            $email_resp = $_POST['email_resp'];
                                        } else {
                                            $email_resp = $current_user->data->user_email;
                                        }
                                    ?>

                                    <label for="email_resp">E-mail do responsável:</label>
                                    <input id="email_resp" name="email_resp" type="text" value="<?= $email_resp; ?>" class="required form-control">

                                    <hr>

                                    <label for="nome_edu">Nome do educador 1:</label>
                                    <input id="nome_edu" name="nome_edu" type="text" class="required form-control" value="<?= $_POST['nome_edu']; ?>">

                                    <label for="contato_edu">Contato do educador 1:</label>
                                    <input id="contato_edu" name="contato_edu" type="text" class="required form-control tel-mask" value="<?= $_POST['contato_edu']; ?>" placeholder="(00) 0000-0000">

                                    <label for="nome_edu_2">Nome do educador 2 (opcional):</label>
                                    <input id="nome_edu_2" name="nome_edu_2" type="text" class="form-control" value="<?= $_POST['nome_edu_2']; ?>">

                                    <label for="contato_edu_2">Contato do educador 2 (opcional):</label>
                                    <input id="contato_edu_2" name="contato_edu_2" type="text" class="form-control tel-mask" value="<?= $_POST['contato_edu_2']; ?>" placeholder="(00) 0000-0000">
                                    
                                </section>

                                <h3>Dados dos estudantes e expectativa da visita</h3>
                                <section>

                                    <div class="row">
                                        <div class="col">
                                            <label for="estudantes">Número de estudantes:</label>
                                            <input type="number" name="estudantes" id="estudantes" class="required form-control" value="<?= $_POST['estudantes']; ?>">
                                            
                                        </div>
                                        <div class="col">
                                            <?php
                                                //echo "<pre>";
                                                //print_r($_POST['ciclo']);
                                                //echo "</pre>";
                                            ?>
                                            <label for="ciclo">Ciclo/ano:</label>
                                            <select class="required form-control" required id="ciclo" multiple="multiple" name="ciclo[]">
                                                
                                                <?php
                                                $ano_series = get_terms( array(
                                                    'taxonomy' => 'ano-serie',
                                                    'hide_empty' => false,
                                                ) );
                                               
                                                foreach ($ano_series as $ano_serie){
                                                    
                                                        if( in_array($ano_serie->term_id, $_POST['ciclo']) ):
                                                        ?>
                                                            <option value="<?php echo $ano_serie->term_id; ?>" selected><?php echo $ano_serie->name; ?></option>
                                                        <?php
                                                        else:
                                                        ?>
                                                            <option value="<?php echo $ano_serie->term_id; ?>"><?php echo $ano_serie->name; ?></option>
                                                        <?php
                                                        endif;
                                                }       
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <label for="faixa">Faixas etárias:</label>
                                    <select class="required form-control" id="faixa" multiple="multiple" name="faixa[]">
                                        <?php
                                        $faixa_etarias = get_terms( array(
                                            'taxonomy' => 'faixa-etaria',
                                            'hide_empty' => false,
                                        ) );
                                        foreach ($faixa_etarias as $faixa_etaria){
                                                    
                                                if( in_array($faixa_etaria->term_id, $_POST['faixa']) ):
                                                ?>
                                                    <option value="<?php echo $faixa_etaria->term_id; ?>" selected><?php echo $faixa_etaria->name; ?></option>
                                                <?php
                                                else:
                                                ?>
                                                    <option value="<?php echo $faixa_etaria->term_id; ?>"><?php echo $faixa_etaria->name; ?></option>
                                                <?php
                                                endif;
                                        }
                                        
                                        ?>
                                    </select>
                                    
                                    <hr>
                                    <?php $pcd = $_POST['pcd']; ?>
                                    <label for="pcd">Existem pessoas com deficiência?</label>
                                    <select id="pcd" name="pcd" class="required form-control">
                                        <option value="" disabled selected>Informar</option>
                                        <option value="1" <?= $pcd == '1' ? "selected" : ''; ?>>Sim</option>
                                        <option value="0" <?= $pcd == '0' ? "selected" : ''; ?>>Não</option>
                                    </select>

                                    <div id="info-pcd" <?= $transporte == '0' ? "style='display: none;'" : "style='display: block;'"; ?>>

                                        <label for="tipo_pcd">Deficiências listadas:</label>
                                        <select class="required form-control" id="tipo_pcd" multiple="multiple" name="tipo_pcd[]">
                                            <?php
                                            $tipo_pcds = get_terms( array(
                                                'taxonomy' => 'tipo-pcd',
                                                'hide_empty' => false,
                                            ) );
                                            foreach ($tipo_pcds as $tipo_pcd){
                                                    
                                                if( in_array($tipo_pcd->term_id, $_POST['tipo_pcd']) ):
                                                ?>
                                                    <option value="<?php echo $tipo_pcd->term_id; ?>" selected><?php echo $tipo_pcd->name; ?></option>
                                                <?php
                                                else:
                                                ?>
                                                    <option value="<?php echo $tipo_pcd->term_id; ?>"><?php echo $tipo_pcd->name; ?></option>
                                                <?php
                                                endif;
                                            }                                            
                                            ?>
                                        </select>

                                        <label for="pcd_outras">Outras deficiências:</label>
                                        <input id="pcd_outras" name="pcd_outras" type="text" class="form-control" value="<?= $_POST['pcd_outras']; ?>">

                                        <label for="pcd_obs">Observações:</label>
                                        <textarea id="pcd_obs" name="pcd_obs" class="form-control"><?= $_POST['pcd_obs']; ?></textarea>
                                    </div>

                                    <input type="hidden" name="sucesso" id="sucesso" value="0">
                                    <?php $current_user = wp_get_current_user(); ?>
                                
                                    <input type="hidden" name="user_inscri" value="<?= $current_user->user_firstname . ' '. $current_user->user_lastname; ?>">

                                </section>
                                
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>

        <?php

            $dh_select = explode(']', (explode('[', $_POST['data_hora'])[1]))[0];
            $dispo = get_post_meta($_GET['eventoid'], 'agenda_' . $dh_select . '_status', true);

            
            if($_POST['nome_ue'] && $dispo == 'Disponível'){
                $new_post = array(
                    'post_title'    => get_the_title($_GET['eventoid']),
                    'post_status'   => 'pending',           // Choose: publish, preview, future, draft, etc.
                    'post_type' => 'agendamento'  // Use a custom post type if you want to
                );
                //save the new post and return its ID
                $pid = wp_insert_post($new_post);

                if($_POST['nome_ue'] && $_POST['nome_ue'] != ''){
                    $nome_ue = $_POST['nome_ue'];
                    update_post_meta($pid, 'nome_ue', $nome_ue);
                }
                
                if($_POST['dre'] && $_POST['dre'] != ''){
                    $dre = $_POST['dre'];
                    update_post_meta($pid, 'dre_selected', $dre);
                }

                if($_POST['telefone_ue'] && $_POST['telefone_ue'] != ''){
                    $telefone_ue = $_POST['telefone_ue'];
                    update_post_meta($pid, 'telefone_ue', $telefone_ue);
                }

                if($_POST['data_hora'] && $_POST['data_hora'] != ''){
                    $data_hora = $_POST['data_hora'];
                    //$datetime1 = new \DateTime($data_hora);
                    update_post_meta($pid, 'data_horario', $data_hora);
                    update_post_meta($pid, 'data_horario_copia', $data_hora);

                    $dh_select = explode(']', (explode('[', $_POST['data_hora'])[1]))[0];
                    update_post_meta($_GET['eventoid'], 'agenda_' . $dh_select . '_status', 'Esgotado');

                    $data = substr($data_hora, 0, 10);
                    $date = \DateTime::createFromFormat('d/m/Y', $data);
                    $date = $date->format('Ymd');

                    //update_field('data_escolhida', $date, $pid);
                    update_post_meta($pid, 'data_escolhida', $date);
                }

                $duracao_visita = get_field('duracao_visita', $_GET['eventoid']);
                if($duracao_visita && $duracao_visita != ''){
                    update_post_meta($pid, 'duracao', $duracao_visita);
                }

                if($_POST['select_transporte'] && $_POST['select_transporte'] != ''){
                    $select_transporte = $_POST['select_transporte'];                    
                    update_post_meta($pid, 'transporte', $select_transporte);
                }

                $tipo_transporte = get_field('tipo_de_transporte', $_GET['eventoid']);
                if($tipo_transporte && $tipo_transporte != ''){
                    update_post_meta($pid, 'tipo_transporte', $tipo_transporte->slug);
                }

                if($_POST['saida_oni'] && $_POST['saida_oni'] != ''){
                    $saida_oni = $_POST['saida_oni'];                    
                    update_post_meta($pid, 'saida_onibus', $saida_oni);
                }

                if($_POST['retorno_oni'] && $_POST['retorno_oni'] != ''){
                    $retorno_oni = $_POST['retorno_oni'];                    
                    update_post_meta($pid, 'retorno_ue', $retorno_oni);
                }

                if($_POST['end_ue'] && $_POST['end_ue'] != ''){
                    $end_ue = $_POST['end_ue'];                    
                    update_post_meta($pid, 'endereco_ue', $end_ue);
                    update_post_meta($pid, 'endereco_ue_copia', $end_ue);
                }

                $parceiro = get_field('parceiro', $_GET['eventoid']);                               

                if($parceiro){
                    $nomeParceiro = get_the_title($parceiro);
                    $endParceiro = get_field('logradouro_parceiro', $parceiro);
                    $numParceiro = get_field('numero_parceiro', $parceiro);
                    $bairroParceiro = get_field('bairro_parceiro', $parceiro);

                    $endereco = '';
                    if($endParceiro)
                        $endereco .= $endParceiro;

                    if($numParceiro)
                        $endereco .= ', ' . $numParceiro;

                    if($bairroParceiro)
                        $endereco .= ' - ' . $bairroParceiro;        
                    
                    update_post_meta($pid, 'end_destino', $endereco);
                }

                if($_POST['ponto_ue'] && $_POST['ponto_ue'] != ''){
                    $ponto_ue = $_POST['ponto_ue'];                    
                    update_post_meta($pid, 'ponto_referencia', $ponto_ue);
                }

                if($_POST['nome_resp'] && $_POST['nome_resp'] != ''){
                    $nome_resp = $_POST['nome_resp'];                    
                    update_post_meta($pid, 'nome_responsavel', $nome_resp);
                    update_post_meta($pid, 'nome_responsavel_copia', $nome_resp);
                }

                if($_POST['contato_resp'] && $_POST['contato_resp'] != ''){
                    $contato_resp = $_POST['contato_resp'];                    
                    update_post_meta($pid, 'contato_responsavel', $contato_resp);
                }

                if($_POST['email_resp'] && $_POST['email_resp'] != ''){
                    $email_resp = $_POST['email_resp'];                    
                    update_post_meta($pid, 'email_responsavel', $email_resp);
                }

                if($_POST['nome_edu'] && $_POST['nome_edu'] != ''){
                    $nome_edu = $_POST['nome_edu'];                    
                    update_post_meta($pid, 'nome_educador', $nome_edu);
                }

                if($_POST['contato_edu'] && $_POST['contato_edu'] != ''){
                    $contato_edu = $_POST['contato_edu'];                    
                    update_post_meta($pid, 'contato_educador', $contato_edu);
                }

                if($_POST['nome_edu_2'] && $_POST['nome_edu_2'] != ''){
                    $nome_edu_2 = $_POST['nome_edu_2'];                    
                    update_post_meta($pid, 'nome_educador_2', $nome_edu_2);
                }

                if($_POST['contato_edu_2'] && $_POST['contato_edu_2'] != ''){
                    $contato_edu_2 = $_POST['contato_edu_2'];                    
                    update_post_meta($pid, 'contato_educador_2', $contato_edu_2);
                }

                if($_POST['estudantes'] && $_POST['estudantes'] != ''){
                    $estudantes = $_POST['estudantes'];                    
                    update_post_meta($pid, 'num_estudantes', $estudantes);
                }

                if($_POST['ciclo'] && $_POST['ciclo'] != ''){
                    $ciclo = $_POST['ciclo'];                    
                    update_post_meta($pid, 'ciclo_ano', $ciclo);
                }

                if($_POST['faixa'] && $_POST['faixa'] != ''){
                    $faixa = $_POST['faixa'];                    
                    update_post_meta($pid, 'faixa_etaria', $faixa);
                }

                if($_POST['pcd'] && $_POST['pcd'] != ''){
                    $pcd = $_POST['pcd'];                    
                    update_post_meta($pid, 'pcd', $pcd);
                }

                if($_POST['tipo_pcd'] && $_POST['tipo_pcd'] != ''){
                    $tipo_pcd = $_POST['tipo_pcd'];                    
                    update_post_meta($pid, 'deficiencias_listadas', $tipo_pcd);
                }

                if($_POST['pcd_outras'] && $_POST['pcd_outras'] != ''){
                    $pcd_outras = $_POST['pcd_outras'];                    
                    update_post_meta($pid, 'outras_deficiencias', $pcd_outras);
                }

                if($_POST['pcd_obs'] && $_POST['pcd_obs'] != ''){
                    $pcd_obs = $_POST['pcd_obs'];                    
                    update_post_meta($pid, 'observacoes', $pcd_obs);
                }

                update_post_meta($pid, 'status', 'nova');
                update_post_meta($pid, 'evento', $_GET['eventoid']);
                update_post_meta($pid, 'parceiro', $parceiro);

                if($_POST['sucesso'] == 1){
                
                    echo '<script type="text/javascript">
                        window.location = "' . get_permalink( $_GET['eventoid'] ) . '?cadastro=1"
                    </script>';
                }
                
            } elseif($_POST['nome_ue'] && $dispo != 'Disponível') { ?>
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire(
                        'Horário Indisponível',
                        'Desculpe, o dia e horário escolhido não estão mais disponíveis, por gentileza escolha um novo horário.',
                        'error'
                    );
                </script>
            <?php }

            
            

	}
}