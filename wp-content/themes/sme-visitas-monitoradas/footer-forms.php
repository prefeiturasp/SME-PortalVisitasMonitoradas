</section>
<!--main-->
		
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
			
							
				if( href && !href.startsWith('#') && !valor.includes('<button') && !valor.includes('<img') && !href.includes('tel:') && !href.includes('mailto:') && href != ''){
					if(!href.includes("https://educacao.sme.prefeitura.sp.gov.br") && !href.includes("http://educacao.sme.prefeitura.sp.gov.br")){
						$(this).html(valor + ' <span class="screen-reader-text">(Link para um novo sítio)</span><span aria-hidden="true" class="dashicons dashicons-external"></span>');
					}
				}

				if(valor.includes('<img')){
					if(!href.includes("https://educacao.sme.prefeitura.sp.gov.br") && !href.includes("http://educacao.sme.prefeitura.sp.gov.br")){
						$(this).html(valor + ' <span class="screen-reader-text">(Link para um novo sítio)</span>');
					}
				}
						
			
		});

		console.log('To aqui');
	} );
</script>
</body>
</html>