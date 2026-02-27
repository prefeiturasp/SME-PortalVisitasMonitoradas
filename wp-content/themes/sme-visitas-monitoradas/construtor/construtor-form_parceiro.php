<div class="container">
    <div class="row">

        <div class="col-12 form_contato mt-0">
            <form id="example-form" class="form_parceiro" action="<?= get_the_permalink();?>" method="POST" enctype="multipart/form-data">
                <div>

                    <h3>Informações <br>Gerais</h3>
                    <section>
                        <p>Informe dados gerais sobre sua organização</p>

                        <label for="nome_parceiro">Nome do espaço:*</label>                        
                        <input id="nome_parceiro" name="nome_parceiro" placeholder="Informe" type="text" class="required form-control">
                        <span class="input_require">* Campo obrigatório</span>

                        <label for="descricao_parceiro">Descrição:*</label> 
                        <textarea name="descricao_parceiro" id="descricao_parceiro" class="required form-control" cols="30" rows="10" placeholder="Sobre o parceiro..."></textarea>
                        <span class="input_require">* Campo obrigatório</span>

                        <label for="site_parceiro">Site do parceiro:</label>
                        <input id="site_parceiro" name="site_parceiro" placeholder="Informe" type="text" class="form-control">
                                                                                              
                        <div class="row">
                            <div class="col-12 col-md">
                                <label for="face_parceiro">Facebook:</label>
                                <input id="face_parceiro" name="face_parceiro" placeholder="Informe" type="text" class="form-control">
                            </div>
                            <div class="col-12 col-md">
                                <label for="insta_parceiro">Instagram:</label>
                                <input id="insta_parceiro" name="insta_parceiro" placeholder="Informe" type="text" class="form-control">
                            </div>
                        </div> 
                    
                        <label for="video_parceiro">Video institucional (URL):</label>
                        <input id="video_parceiro" name="video_parceiro" placeholder="Informe" type="text" class="form-control">

                        <label for="logo_parceiro">Logo (foto de divulgação institucional):*</label>
                        <input type="file" class="form-control-file" name="logo_parceiro" id="logo_parceiro">
                        <span class="input_require">* Campo obrigatório</span>

                    </section>

                    <h3>Endereço <br>e contato</h3>
                    <section>

                    <p>Agora, informe os dados de contato e localização da sua organização</p>

                        
                        
                        <div class="row">
                            <div class="col-12 col-md-9">
                                <label for="end_parceiro">Logradouro:*</label>
                                <input id="end_parceiro" name="end_parceiro" type="text" value="" class="required form-control">
                                <span class="input_require">* Campo obrigatório</span>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="num_end_parceiro">Número:*</label>
                                <input id="num_end_parceiro" name="num_end_parceiro" type="text" value="" class="required form-control">
                                <span class="input_require">* Campo obrigatório</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="comp_end_parceiro">Complemento:</label>
                                <input id="comp_end_parceiro" name="comp_end_parceiro" type="text" value="" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="bairro_end_parceiro">Bairro:*</label>
                                <input id="bairro_end_parceiro" name="bairro_end_parceiro" type="text" value="" class="required form-control">
                                <span class="input_require">* Campo obrigatório</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="cidade_end_parceiro">Cidade:*</label>
                                <input id="cidade_end_parceiro" name="cidade_end_parceiro" type="text" value="" class="required form-control">
                                <span class="input_require">* Campo obrigatório</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="estado_end_parceiro">Estado:*</label>
                                <input id="estado_end_parceiro" name="estado_end_parceiro" type="text" value="" class="required form-control">
                                <span class="input_require">* Campo obrigatório</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="cep_parceiro">CEP:*</label>
                                <input id="cep_parceiro" name="cep_parceiro" type="text" value="" class="required form-control">
                                <span class="input_require">* Campo obrigatório</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="tel_parceiro">Telefone:</label>
                                <input id="tel_parceiro" name="tel_parceiro" type="text" value="" class="form-control">
                            </div>
                        </div>
                        
                    </section>

                    <h3>Informações <br>do responsável</h3>
                    <section>
                        <p>Para entrarmos em contato com você, solicitamos suas as informações abaixo, que não serão divulgadas publicamente</p>
                        <label for="nome_resp">Nome:*</label>
                        <input id="nome_resp" name="nome_resp" type="text" value="" class="required form-control">
                        <span class="input_require">* Campo obrigatório</span>
                        
                        <label for="cargo_resp">Cargo:*</label>
                        <input id="cargo_resp" name="cargo_resp" type="text" value="" class="required form-control">
                        <span class="input_require">* Campo obrigatório</span>

                        <label for="email_resp">E-mail:*</label>
                        <input id="email_resp" name="email_resp" type="text" value="" class="required form-control">
                        <span class="input_require">* Campo obrigatório</span>

                        <label for="cel_resp">Celular/WhatsApp:</label>
                        <input id="cel_resp" name="cel_resp" type="text" value="" class="form-control">

                        <div class="form-check">
                            <input class="form-check-input w-auto" type="checkbox" name="aceite_compa" value="" id="aceite_compa">
                            <label class="form-check-label" for="aceite_compa">
                                Aceita compartilhar seus dados com a equipe do Visitas Monitoradas?
                            </label>
                        </div>

                        <input type="hidden" name="sucesso" id="sucesso" value="1">
                        

                    </section>

                    
                </div>
            </form>
        </div>
        
    </div>
</div>

<?php
    if( 'POST' == $_SERVER['REQUEST_METHOD'] ) {        
    
        // Add the content of the form to $post as an array
        $new_post = array(
            'post_title'    => $_POST['nome_parceiro'],            
            'post_status'   => 'pending',           // Choose: publish, preview, future, draft, etc.
            'post_type' => 'parceiros'  // Use a custom post type if you want to
        );
        //save the new post and return its ID
        $pid = wp_insert_post($new_post);

        if($pid){
            session_start();
            $_SESSION['success'] = true;
        }    
        
        // Info Gerais
        if($_POST['descricao_parceiro'] && $_POST['descricao_parceiro'] != ''){
            $descricao = $_POST['descricao_parceiro'];
            update_post_meta($pid, 'descricao_parceiro', $descricao);
        }

        if($_POST['site_parceiro'] && $_POST['site_parceiro'] != ''){
            $site_parceiro = $_POST['site_parceiro'];
            update_post_meta($pid, 'site_do_parceiro', $site_parceiro);
        }

        if($_POST['face_parceiro'] && $_POST['face_parceiro'] != ''){
            $face_parceiro = $_POST['face_parceiro'];
            update_post_meta($pid, 'url_facebook_parceiro', $face_parceiro);
        }

        if($_POST['insta_parceiro'] && $_POST['insta_parceiro'] != ''){
            $insta_parceiro = $_POST['insta_parceiro'];
            update_post_meta($pid, 'url_instagram_parceiro', $insta_parceiro);
        }

        if($_POST['video_parceiro'] && $_POST['video_parceiro'] != ''){
            $video_parceiro = $_POST['video_parceiro'];
            update_post_meta($pid, 'video_parceiro', $video_parceiro);
        }

        // Endereco
        if($_POST['end_parceiro'] && $_POST['end_parceiro'] != ''){
            $end_parceiro = $_POST['end_parceiro'];
            update_post_meta($pid, 'logradouro_parceiro', $end_parceiro);
        }

        if($_POST['num_end_parceiro'] && $_POST['num_end_parceiro'] != ''){
            $num_end_parceiro = $_POST['num_end_parceiro'];
            update_post_meta($pid, 'numero_parceiro', $num_end_parceiro);
        }

        if($_POST['comp_end_parceiro'] && $_POST['comp_end_parceiro'] != ''){
            $comp_end_parceiro = $_POST['comp_end_parceiro'];
            update_post_meta($pid, 'complemento_parceiro', $comp_end_parceiro);
        }

        if($_POST['cidade_end_parceiro'] && $_POST['cidade_end_parceiro'] != ''){
            $cidade_end_parceiro = $_POST['cidade_end_parceiro'];
            update_post_meta($pid, 'cidade_parceiro', $cidade_end_parceiro);
        }

        if($_POST['estado_end_parceiro'] && $_POST['estado_end_parceiro'] != ''){
            $estado_end_parceiro = $_POST['estado_end_parceiro'];
            update_post_meta($pid, 'estado_parceiro', $estado_end_parceiro);
        }

        if($_POST['tel_parceiro'] && $_POST['tel_parceiro'] != ''){
            $tel_parceiro = $_POST['tel_parceiro'];
            update_post_meta($pid, 'telefone_parceiro', $tel_parceiro);
        }

        if($_POST['bairro_end_parceiro'] && $_POST['bairro_end_parceiro'] != ''){
            $bairro_end_parceiro = $_POST['bairro_end_parceiro'];
            update_post_meta($pid, 'bairro_parceiro', $bairro_end_parceiro);
        }

        if($_POST['cep_parceiro'] && $_POST['cep_parceiro'] != ''){
            $cep_parceiro = $_POST['cep_parceiro'];
            update_post_meta($pid, 'cep_parceiro', $cep_parceiro);
        }

        // Responsavel
        if($_POST['nome_resp'] && $_POST['nome_resp'] != ''){
            $nome_resp = $_POST['nome_resp'];
            update_post_meta($pid, 'nome_responsavel_parceiro', $nome_resp);
        }

        if($_POST['cargo_resp'] && $_POST['cargo_resp'] != ''){
            $cargo_resp = $_POST['cargo_resp'];
            update_post_meta($pid, 'cargo_responsavel_parceiro', $cargo_resp);
        }

        if($_POST['email_resp'] && $_POST['email_resp'] != ''){
            $email_resp = $_POST['email_resp'];
            update_post_meta($pid, 'email_responsavel_parceiro', $email_resp);
        }

        if($_POST['cel_resp'] && $_POST['cel_resp'] != ''){
            $cel_resp = $_POST['cel_resp'];
            update_post_meta($pid, 'celular_whatsapp_responsavel_parceiro', $cel_resp);
        }

        
        if ($_FILES["logo_parceiro"]) {
            
            $tipo = $_FILES["logo_parceiro"]['type'];
            $formatos = array(
                'image/jpg',
                'image/jpeg',
                'image/png',                
            );

            if(in_array($tipo, $formatos)){
                
                if ( ! function_exists( 'wp_handle_upload' ) ) {
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                }
 
                $upload_overrides = array( 'test_form' => false );
                $movefile = wp_handle_upload( $_FILES["logo_parceiro"], $upload_overrides ); 
                
                // $filename should be the path to a file in the upload directory.
                $filename = $movefile['file'];
                
                // The ID of the post this attachment is for.
                $parent_post_id = $pid;
                
                // Check the type of file. We'll use this as the 'post_mime_type'.
                $filetype = wp_check_filetype( basename( $filename ), null );
                
                // Get the path to the upload directory.
                $wp_upload_dir = wp_upload_dir();
                
                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );
                
                // Insert the attachment.
                $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
                
                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                wp_update_attachment_metadata( $attach_id, $attach_data );

                if($attach_id && $attach_id != ''){                    
                    update_post_meta($pid, 'foto_principal_parceiro', $attach_id);
                }
                
            }

        } 
    
    }