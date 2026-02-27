<div class="container">
    <div class="row">
        <div class="col">
            <form action ="https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br/avaliacao?evento_id=<?= $_GET['evento_id']; ?>" method="POST" id="form-feedback" class="form-feedback">

                <div class="row">
                    <div class="col-12 mb-4 text-center">
                        <h2><?= get_the_title($_GET['evento_id']); ?></h2>
                    </div>
                    <div class="col-12">
                        <p class="m-0"><strong>As demandas pedagógicas foram atendidas? (obrigatório)</strong><br>1 (Não foram atendidas) e 4 (Foram plenamente atendidas)</p>
                    </div>
                    <div class="col-12">
                        <div class="rate">                            
                            <input type="radio" id="quest1_4" name="demandas" value="4" />
                            <label for="quest1_4" title="text">4 stars</label>

                            <input type="radio" id="quest1_3" name="demandas" value="3" />
                            <label for="quest1_3" title="text">3 stars</label>
                            
                            <input type="radio" id="quest1_2" name="demandas" value="2" />
                            <label for="quest1_2" title="text">2 stars</label>
                            
                            <input type="radio" id="quest1_1" name="demandas" value="1" />
                            <label for="quest1_1" title="text">1 star</label>
                        </div>
                        <span id="demandasError" class="error" style="display: none">Este campo é obrigatório.</span>                       
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <p class="m-0"><strong>Como foi o transporte utilizado para a visita? (obrigatório)</strong><br>1 (Pouco satisfatório) e 4 (Muito satisfatório)</p>                        
                    </div>
                    <div class="col-12">
                        <div class="rate">
                            <input type="radio" id="quest2_4" name="transporte_uti" value="4" />
                            <label for="quest2_4" title="text">4 star</label>

                            <input type="radio" id="quest2_3" name="transporte_uti" value="3" />
                            <label for="quest2_3" title="text">3 stars</label>

                            <input type="radio" id="quest2_2" name="transporte_uti" value="2" />
                            <label for="quest2_2" title="text">2 stars</label>

                            <input type="radio" id="quest2_1" name="transporte_uti" value="1" />
                            <label for="quest2_1" title="text">1 stars</label>
                        </div>
                        <span id="transporteError" class="error" style="display: none">Este campo é obrigatório.</span>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <p class="m-0"><strong>Como foi a relação com o parceiro? (obrigatório)</strong><br>1 (Pouco satisfatória) e 4 (Muito satisfatória)</p>                    
                    </div>
                    <div class="col-12">
                        <div class="rate">
                            <input type="radio" id="star4" name="relacao" value="4" />
                            <label for="star4" title="text">4 star</label>

                            <input type="radio" id="star3" name="relacao" value="3" />
                            <label for="star3" title="text">3 stars</label>

                            <input type="radio" id="star2" name="relacao" value="2" />
                            <label for="star2" title="text">2 stars</label>

                            <input type="radio" id="star1" name="relacao" value="1" />
                            <label for="star1" title="text">1 stars</label>                            
                        </div>
                        <span id="relacaoError" class="error" style="display: none">Este campo é obrigatório.</span>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <p><strong></strong></p>
                        <p class="m-0"><strong>A UE repetiria a visita em uma nova edição? (obrigatório)</strong><br>1 (Não repetiria) e 4 (Com certeza repetiria)</p> 
                    </div>
                    <div class="col-12">
                        <div class="rate">
                            <input type="radio" id="quest4_4" name="repetir" value="4" />
                            <label for="quest4_4" title="text">4 star</label>

                            <input type="radio" id="quest4_3" name="repetir" value="3" />
                            <label for="quest4_3" title="text">3 stars</label>

                            <input type="radio" id="quest4_2" name="repetir" value="2" />
                            <label for="quest4_2" title="text">2 stars</label>

                            <input type="radio" id="quest4_1" name="repetir" value="1" />
                            <label for="quest4_1" title="text">1 stars</label>
                        </div>
                        <span id="repetirError" class="error" style="display: none">Este campo é obrigatório.</span>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <label for="exampleFormControlTextarea1"><strong>Comentários gerais (opcional)</strong></label>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="comentarios" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <input type="button" class="btn btn-cancel" value="Cancelar" onclick="verifyCancel()">
                    <input class="btn visitas-btn" id="btnSubmit" type="submit" value="Enviar">
                </div>
                
            </form>
        </div>
    </div>
</div>

<?php
    unset($_SESSION['feedback']);
    if( $_GET['evento_id'] != '' && $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $evento = $_GET['evento_id'];

        update_post_meta($evento, 'aval_resp', 1);

        if($_POST['demandas'] && $_POST['demandas'] != ''){
            $demandas = $_POST['demandas'];
            update_post_meta($evento, 'demandas_pedago', $demandas);
        }

        if($_POST['transporte_uti'] && $_POST['transporte_uti'] != ''){
            $transporte = $_POST['transporte_uti'];
            update_post_meta($evento, 'transporte_util', $transporte);
        }

        if($_POST['relacao'] && $_POST['relacao'] != ''){
            $relacao = $_POST['relacao'];
            update_post_meta($evento, 'rel_parceiro', $relacao);
        }

        if($_POST['repetir'] && $_POST['repetir'] != ''){
            $repetir = $_POST['repetir'];
            update_post_meta($evento, 'repetir_visita', $repetir);
        }

        if($_POST['comentarios'] && $_POST['comentarios'] != ''){
            $comentarios = $_POST['comentarios'];
            update_post_meta($evento, 'comentarios_gerais', $comentarios);
        }

        session_start();
        $_SESSION['feedback'] = true;
    }