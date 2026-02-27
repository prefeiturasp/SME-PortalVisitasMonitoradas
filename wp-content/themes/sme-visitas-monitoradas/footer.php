</section>
<!--main-->
<?php
	$data_hora = "22/02/2023 18:00 [0] (20)";
	$data = substr($data_hora, 0, 10);
	$date = DateTime::createFromFormat('d/m/Y', $data);
	$date = $date->format('Ymd');

	//print_r($data);
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
				
			</div>
			<div class="col-sm-3 align-middle text-center">				
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
<script src="<?= get_template_directory_uri(); ?>/js/slick/slick.js?v2022" type="text/javascript" charset="utf-8"></script>
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

		var SPMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
		},
		spOptions = {
			onKeyPress: function(val, e, field, options) {
				field.mask(SPMaskBehavior.apply({}, arguments), options);
			}
		};

		$('.tel-mask').mask(SPMaskBehavior, spOptions);

		

		/*
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
		*/

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
					},
					logo_parceiro: {
						required: true,
					},
					aceite_compa: {
						required: true,
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

	jQuery('#select_transporte').on('change', function() {
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

<script type="text/javascript">
    jQuery(function () {

		jQuery('#form-feedback').submit(function(e){
			e.preventDefault();

			var valid = true;

			var demandas = jQuery("input[name=demandas]").is(":checked");
            var transporte = jQuery("input[name=transporte_uti]").is(":checked");
			var relacao = jQuery("input[name=relacao]").is(":checked");
            var repetir = jQuery("input[name=repetir]").is(":checked");

			
			if(!demandas || !transporte || !relacao || !repetir){
				Swal.fire(
					'Campo Obrigatório!',
					'Um ou mais campos possuem erros. Por favor verifique os campos e tente novamente.',
					'error'
				);				
				valid = false;
			}

			//Display error message if no RadioButton is checked.
            jQuery("#demandasError")[0].style.display = demandas ? "none" : "block";
			jQuery("#transporteError")[0].style.display = transporte ? "none" : "block";
            jQuery("#relacaoError")[0].style.display = relacao ? "none" : "block";
			jQuery("#repetirError")[0].style.display = repetir ? "none" : "block";

			if (valid) this.submit();

		});
        
    });

	function verifyCancel(){
		
		Swal.fire({
			title: 'Deseja cancelar a avaliação?',
			text: "Você perderá os dados cadastrados, mas pode fazer a avaliação posteriormente.",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sim',
			cancelButtonText: 'Não',
		}).then((result) => {
		if (result.isConfirmed) {
			Swal.fire({
				icon: 'success',
				title: 'Cancelamento realizado',
				timer: 3000,
  				timerProgressBar: true,
			})
			setTimeout(function() {	
				window.location = "/minhas-incricoes/";
			}, 3000);
			
		}
		})
	}
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

<?php if($_SESSION['success']): ?>
	<script>
		Swal.fire(
		'Inscrição enviada para análise!',
		'Após a aprovação da equipe do Visitas Monitoradas seu conteúdo estará disponível.',
		'success'
		)
	</script>
<?php endif; ?>

<?php if($_SESSION['feedback']): ?>
	<script>
		Swal.fire(
		'Avaliação eviada com sucesso!',
		'Sua avaliação foi enviada com sucesso e foi recebido por nossa equipe, obrigado.',
		'success'
		)
	</script>
<?php endif; ?>

<?php if($_GET['update'] == '1'): ?>

<script>
	Swal.fire(
		'Inscrição cancelada com sucesso!',
		'Em breve você receberá um email confirmando seu cancelamento.',
		'success'
	);
</script>

<?php endif; ?>

<script>

	function updateSubs(id){
		var ajaxurl = 'https://'+window.location.host+'/wp-admin/admin-ajax.php';
			
		jQuery.ajax({
			url: ajaxurl + "?action=updateSubs",
			type: 'POST',
			data: {'id_update' : id},
				success: function(data) {
				if(data == 'true'){
					window.location.href = window.location.href + '?update=1';
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: 'Não foi possível cancelar sua inscrição!<br>Tente novamente ou fale com sua DRE',
					})
				}
			},
				error: function(data) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: 'Não foi possível cancelar sua inscrição!<br>Tente novamente ou fale com sua DRE',
					})
				//console.log("FAILURE");
			}
		});
	}

	function confirmUpdate(id){

		var titulo = jQuery("#title_" + id).text();
		
		Swal.fire({
			title: '<strong>Cancelamento de inscrição</strong>',
			icon: 'warning',
			html: 'Você confirma o <strong>cancelamento</strong> da inscrição para o evento:<br> <strong>' + titulo + '</strong>',
			showCloseButton: true,
			showCancelButton: true,
			focusConfirm: false,
			confirmButtonText:
				'<i class="fa fa-thumbs-up"></i> Confirmar!',
			confirmButtonAriaLabel: 'Thumbs up, great!',
			cancelButtonText:
				'<i class="fa fa-thumbs-down"></i> Cancelar',
			cancelButtonAriaLabel: 'Thumbs down'
		}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				updateSubs(id)
			} else if (result.isDenied) {
				Swal.fire('Changes are not saved', '', 'info')
			}
		})
	}

	
</script>

</body>
</html>