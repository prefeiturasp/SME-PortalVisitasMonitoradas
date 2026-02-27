</section>
<!--main-->
<?php
$agendamentos = array();
$args = array(
	'post_type' => 'agendamento',
	'posts_per_page' => -1,
	'post_status' => 'any',
	'meta_query' => array()
);

if($_GET['s'] && $_GET['s'] != ''){	
	$args['s'] = $_GET['s'];
}

if($_GET['m'] && $_GET['m'] != ''){
	$mesAno = $_GET['m'];	
	$args['monthnum'] = substr($mesAno, -2);
	$args['year'] = substr($mesAno, 0, 4);
}

$user = wp_get_current_user();

if($_GET['search_dre'] && $_GET['search_dre'] != ''){
	$args['meta_query'][] = 
		array(
			'key'     => 'dre',
			'value' => $_GET['search_dre'],
			'compare' => 'LIKE'
		
	);
} elseif($user->roles[0] != 'administrator'){		
	// pega o grupo que o usuario pertence
	$grupos = get_user_meta($user->ID, 'grupo');
	//$grupos = get_field('grupo', 'user_' . $user->ID);

	//$dres_open = array();
	foreach($grupos[0] as $dre){
		$dres_open[] = get_post_meta($dre, 'dre');			
	}

	$dres_open = array_flatten($dres_open);
	$dres_open = array_unique($dres_open);

	$args['meta_query'][] = array(					
		'key'     => 'dre',
		'value'   => $dres_open,
	);
}

if( $_GET['transporte'] && $_GET['transporte'] != '' )  {
			
	if($_GET['transporte'] == 'sim'){
		$args['meta_query'][] = array(					
			'key'     => 'transporte',
			'value' => '1',
		);
	} else {
		$args['meta_query'][] = array(
			'relation' => 'OR',
			array(
				'key'     => 'transporte',
				'value'   => 0,
				'compare' => '='
			),
			array(
				'key'     => 'transporte',
				'compare' => 'NOT EXISTS',
			)
		);
		
	}
	
}

if( $_GET['ciclo'] && $_GET['ciclo'] != '' )  {
	$args['meta_query'][] = array(					
		'key'     => 'ciclo_ano',
		'value' => $_GET['ciclo'],
		'compare' => 'LIKE'
	);
}

if( $_GET['faixa'] && $_GET['faixa'] != '' )  {
	$args['meta_query'][] = array(					
		'key'     => 'faixa_etaria',
		'value' => $_GET['faixa'],
		'compare' => 'LIKE'
	);
}


//$regex = '/[0-9]+:[0-9]+/i';
//preg_match($regex, '25/10/2022 09:00 [0] (45)', $matches);
//$hora = $matches;
//echo "<pre>";
//print_r($args);
//echo "</pre>";

$tipoTransporte = array(
	'dre' => 'DRE',
	'parceiro' => 'Parceiro',
	'proprio-ue' => 'Próprio UE'
);

// The Query
$the_query = new \WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$data = getEventDate(get_field('data_horario'));
		$hora = getEventHour(get_field('data_horario'));
		$diaSemana = diaSemana($data[0]);
		$dre = get_field('dre');
		if(array_key_exists('label', $dre)){
			$dre = $dre['label'];
		} else {
			$dre = convert_dre_name($dre);
		}

		$cicloAno = '';
		$i = 0;
		$ciclos = get_field('ciclo_ano');
		foreach($ciclos as $ciclo){
			if($i == 0){
				$cicloAno .= get_term($ciclo)->name;
			} else {
				$cicloAno .= ', ' . get_term($ciclo)->name;
			}
			$i++;		
		}

		$agendamentos[] = array(
			get_the_ID(),
			get_the_title(),
			get_field('num_estudantes'),
			$tipoTransporte[get_field('tipo_transporte')],
			$data[0],
			$diaSemana,
			$hora[0],
			get_field('duracao') . ' horas',
			$dre,
			get_field('nome_ue'),
			$cicloAno,
			get_field('telefone_ue'),
			get_field('nome_responsavel'),
			get_field('contato_responsavel'),
		);
	}
	
}
wp_reset_postdata();

//echo "<pre>";
//print_r($agendamentos);
//echo "</pre>";


	$api_url = 'https://hom2-smeintegracaoapi.sme.prefeitura.sp.gov.br/api/AutenticacaoVisitas/login';
	
	// Conversao do body para JSON
    $body = wp_json_encode( array(
        'login' => '7990375'
    ) );

    $response = wp_remote_post( $api_url ,
            array(
                'headers' => array( 
                    'x-api-eol-key' => 'fe8c65abfac596a39c40b8d88302cb7341c8ec99', // Chave da API
                    
                ),
                'body' => '{"login=6718213"}', // Body da requisicao
            ));

    $user = json_decode($response);
	

	

	$curl = curl_init();

curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://hom2-smeintegracaoapi.sme.prefeitura.sp.gov.br/api/AutenticacaoVisitas/login',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => array('login' => '8029156'),
				CURLOPT_HTTPHEADER => array(
								'x-api-eol-key: fe8c65abfac596a39c40b8d88302cb7341c8ec99'
				),
));

$response = curl_exec($curl);

curl_close($curl);
$escola = json_decode($response);

	//echo "<pre>";
	//print_r($escola);
	//echo "</pre>";

?>
<footer style="background: #363636; color: #fff;">
	<div class="container pt-3 pb-3" id="irrodape">
		<div class="row">
			<div class="col-sm-3 align-middle d-flex align-items-center logo-rodape">
			<a href="https://www.capital.sp.gov.br/"><img src="<?php the_field('logo_prefeitura','conf-rodape'); ?>" alt="<?php bloginfo('name'); ?>" width="255" height="85"></a>
			</div>
			<div class="col-sm-3 align-middle bd-contact">
				<p class='footer-title'><?php the_field('nome_da_secretaria','conf-rodape'); ?></p>
				<?php the_field('endereco_da_secretaria','conf-rodape'); ?>
			</div>
			<div class="col-sm-3 align-middle">
				<p class='footer-title'>Contatos</p>
				<p><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:<?php the_field('telefone','conf-rodape'); ?>"><?php the_field('telefone','conf-rodape'); ?></a></p>
				<?php if(get_field('email','conf-rodape')) :?>
				<p><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:<?php the_field('email','conf-rodape'); ?>"><?php the_field('email','conf-rodape'); ?></a></p>
				<?php endif; ?>
				<?php if(get_field('texto_link','conf-rodape') && get_field('link_adicional','conf-rodape')) :?>
				<p><i class="fa fa-comment" aria-hidden="true"></i> <a href="<?php the_field('link_adicional','conf-rodape'); ?>"><?php the_field('texto_link','conf-rodape'); ?></a></p>
				<?php endif; ?>
				<p class='footer-title'>Redes sociais</p>				
				<?php 
					// Verifica se existe Redes Sociais
					if( have_rows('redes_sociais', 'conf-rodape') ):
						
						echo '<div class="row redes-footer">';						
						
							while( have_rows('redes_sociais', 'conf-rodape') ) : the_row();
								
								$rede_url = get_sub_field('url_rede'); 
								$rede_texto = get_sub_field('texto_alternativo');								
								$rede_rodape = get_sub_field('tipo_de_icone_rodape');
								$rede_r_imagem = get_sub_field('imagem_rodape');
								$rede_r_icone = get_sub_field('icone_rodape');								
								
							?>
								<div class="col rede-rodape">
									<a href="<?php echo $rede_url; ?>">
										<?php if($rede_rodape == 'imagem' && $rede_r_imagem != '') : ?>
											<img src="<?php echo $rede_r_imagem; ?>" alt="<?php echo $rede_texto; ?>"  width="24" height="24">
										<?php elseif($rede_rodape == 'icone' && $rede_r_icone != ''): ?>
											<i class="fa <?php echo $rede_r_icone; ?>" aria-hidden="true" title="<?php echo $rede_texto; ?>"></i>
										<?php endif; ?>
									</a>
								</div>
							<?php
								

							// End loop.
							endwhile;

						echo '</div>';
					
					endif;
				?>
			</div>
			<div class="col-sm-3 align-middle text-center">				
				
			</div>
		</div>
	</div>
</footer>
<div class="subfooter rodape-api-col">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<p>Prefeitura Municipal de São Paulo - Viaduto do Chá, 15 - Centro - CEP: 01002-020</p>
			</div>
		</div>
	</div>
</div>

<div class="voltar-topo d-block d-sm-block d-md-none">
	<a href="#" id="toTop" style="display: none;">
		<i class="fa fa-arrow-up" aria-hidden="true"></i>
		<p>Voltar ao topo</p>
		<img src="https://via.placeholder.com/40x80" alt="" srcset="">
	</a>
</div>

<?php wp_footer() ?>
<script src="//api.handtalk.me/plugin/latest/handtalk.min.js"></script>
<script>
    var ht = new HT({
        token: "aa1f4871439ba18dabef482aae5fd934"
    });

	document.onkeyup = PresTab;
 
	function PresTab(e)	{
		var keycode = (window.event) ? event.keyCode : e.keyCode;
		

		if (keycode == 9){
			jQuery('.cabecalho-acessibilidade').show();	
			jQuery(" a[accesskey='1']").focus();
			document.onkeyup = null;
		}
	}

	jQuery('.container-a-icones-home').click(function(){
		jQuery('.container-a-icones-home').removeClass('active');
		jQuery(this).addClass('active');
	});

	jQuery( function ( $ ) {
		// Focus styles for menus when using keyboard navigation


		// Properly update the ARIA states on focus (keyboard) and mouse over events
		$( '[role="menubar"]' ).on( 'focus.aria', '[aria-haspopup="true"]', function ( ev ) {
			$( ev.currentTarget ).attr( 'aria-expanded', true );
			$(this).parent().attr( 'aria-expanded', true );
			$(this).parent().attr( 'aria-haspopup', true );
		} );

		// Properly update the ARIA states on blur (keyboard) and mouse out events
		$( '[role="menubar"]' ).on( 'blur.aria', '[aria-haspopup="true"]', function ( ev ) {
			$( ev.currentTarget ).attr( 'aria-expanded', false );
			$(this).parent().attr( 'aria-expanded', false );
			$(this).parent().attr( 'aria-haspopup', false );

			//$(this).click();
		} );

		$("#conteudo a").each(function(){
			var href = $(this).attr('href');
			var valor = $(this).html();
			
							
				if( href && !href.startsWith('#') && !valor.includes('<button') && !valor.includes('<img') && !href.includes('tel:') && !href.includes('mailto:') && !$(this).hasClass( "scroll" ) && href != ''){
					if(!href.includes("https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br") && !href.includes("http://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br")){
						$(this).html(valor + ' <span class="screen-reader-text">(Link para um novo sítio)</span><span aria-hidden="true" class="dashicons dashicons-external"></span>');
					}
				}

				if(valor.includes('<img')){
					if(!href.includes("https://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br") && !href.includes("http://hom-visitasmonitoradas.sme.prefeitura.sp.gov.br")){
						$(this).html(valor + ' <span class="screen-reader-text">(Link para um novo sítio)</span>');
					}
				}
						
			
		});

		//console.log('To aqui');
		<?php
			$parceiros = '';
			$the_query = new WP_Query( 
				array( 
				  'posts_per_page' => -1,
				  'post_type' => 'parceiros' 
				) 
			  );
			
			  if( $the_query->have_posts() ) :
				$i = 0;
				  while( $the_query->have_posts() ): $the_query->the_post();
				  	if($i == 0){
						$parceiros .= '"' . get_the_title() . '"';
					} else {
						$parceiros .= ',"' . get_the_title() . '"';
					}
				  	$i++;
				  endwhile;
				  wp_reset_postdata();  
			  endif;
		?>
		//valores para o campo de parceiros
		//var TipoParceiros = [<?=$parceiros; ?>];
		//autocomplete(document.getElementById("TipoParceiros"), TipoParceiros);
	} );
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	jQuery.extend(jQuery.validator.messages, {
		required: "Campo Obrigatório.",		
	});
	//console.log('oi1');
	//jQuery('#transporte').on('change', function(){
		//alert(this.value); //or alert($(this).val());
	//});
	//console.log('oi2');

	

	var form = jQuery("#example-form");
	/*form.validate({
		errorPlacement: function errorPlacement(error, element) { element.before(error); },
		rules: {
			confirm: {
				equalTo: "#password"
			}
		}
	});*/
	form.children("div").steps({
		headerTag: "h3",
		bodyTag: "section",
		transitionEffect: "slideLeft",
		titleTemplate: '<span class="number">#index#</span><img src="<?= get_template_directory_uri(); ?>/img/check-inscri.png"> #title#',
		onStepChanging: function (event, currentIndex, newIndex)
		{
			form.validate({
				rules: {
					estudantes: {
						required: true,
						max: function() {
							var selectValue = jQuery('#data_hora').val();
							var maxValue = selectValue.match(/\((.*)\)/).pop();
							var secondEdu = jQuery('#nome_edu_2').val();
							
							if(secondEdu){
								return parseInt(maxValue - 3);
							} else {
								return parseInt(maxValue - 2);
							}						

						}
					}
				},
				messages: {
					estudantes: {
						required: "Campo Obrigatório.",
						max: "Número de estudantes excede a quantidade de vagas disponíveis. O número de educadores e de estudantes deve ser limitado a {0} vagas."
					}
				}
			}).settings.ignore = ":disabled,:hidden";

			if(form.valid() == false){
				Swal.fire(
				'Faltam informações para finalizar sua inscrição.',
				'Por favor, preencha os campos em destaque',
				'error'
				)
			}
			
			return form.valid();		
		},
		onFinishing: function (event, currentIndex) { 
			//alert('Inscrição feita com sucesso!');
			form.validate().settings.ignore = ":disabled";
			console.log(form.valid());
			/*
			var horario = jQuery( "#data_hora" ).val();
			jQuery.ajax({				
				url: "/wp-admin/admin-ajax.php", //this is wordpress ajax file which is already avaiable in wordpress
				data: {
					'action':'val_event', //this value is first parameter of add_action,					
					'horario' : horario,
				},
				success:function(data) {
            		// This outputs the result of the ajax request
					console.log(data);
				},
				error: function(errorThrown){
					console.log(errorThrown);
				}
			});*/
			return form.valid();
			
			
		}, 		
		onFinished: function (event, currentIndex)
		{
			jQuery("#sucesso").val('1');
			form.submit();
			return true; 
		},
		labels: {			
			finish: "Solicitar inscrição",
			next: "Continuar",
			previous: "< Voltar",
		}
	});

	jQuery('#transporte').on('change', function() {
		var value = jQuery(this).val();
		if(value == 0){
			jQuery('#info-transporte').hide();
			jQuery('#saida_oni').removeClass('required');
			jQuery('#retorno_oni').removeClass('required');
			jQuery('#end_ue').removeClass('required');
			jQuery('#ponto_ue').removeClass('required');
		} else {
			jQuery('#info-transporte').show();
			jQuery('#saida_oni').addClass('required');
			jQuery('#retorno_oni').addClass('required');
			jQuery('#end_ue').addClass('required');
			jQuery('#ponto_ue').addClass('required');
		}
	});

	jQuery('#pcd').on('change', function() {
		var value = jQuery(this).val();
		if(value == 0){
			jQuery('#info-pcd').hide();
			jQuery('#tipo_pcd').removeClass('required');
		} else {
			jQuery('#info-pcd').show();
			jQuery('#tipo_pcd').addClass('required');
		}
	});
</script>

<?php if($_GET['cadastro'] == '1'): ?>

	<script>
		Swal.fire(
			'Inscrição solicitada!',
			'Aguarde confirmação da sua DRE',
			'success'
		);
	</script>

<?php endif; ?>

<?php if($_GET['permissao'] == '0'): ?>

<script>
	Swal.fire(
		'Não permitido!',
		'Desculpe, seu usuário não tem permissão para fazer inscrições nos eventos. Os usuários permitidos são Direção, Assistente de Direção e Coordenação',
		'error'
	);
</script>

<?php endif; ?>
</body>
</html>