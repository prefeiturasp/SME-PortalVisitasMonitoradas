jQuery( document ).ready(function() {

    if(jQuery('#parent_id').length){
        jQuery("#parent_id").chosen({
            search_contains: true,
            no_results_text: "Nenhum resultado encontrado para "
        });
    }    
});

jQuery(document).ready(function(){
    var valorLoad = jQuery('#acf-field_628fca507d189').val();
    //jQuery('#acf-field_628e4080d3c88').get(0).type = 'hidden';
    jQuery('#acf-field_628e4080d3c88').val(valorLoad);
    jQuery('#acf-field_628d3c7dbd459').attr('disabled', 'disabled');
});

// Incluir mensagem no Upload de Arquivos
jQuery("#plupload-upload-ui").prepend( '<div class="alert-info media-new"><strong>Atenção:</strong> "Caso a mídia seja uma publicação institucional da Secretaria, enviar o arquivo do documento para o e-mail <a href="mailto:smecopedbibliotecadigital@sme.prefeitura.sp.gov.br">smecopedbibliotecadigital@sme.prefeitura.sp.gov.br</a> para que seja feito o upload no Acervo Digital, a fim de mantermos a padronização na catalogação, e evitar que versões desatualizadas fiquem disponíveis".</div>' );
jQuery(".wp-header-end").after( '<div class="alert-info media-new d-none"><strong>Atenção:</strong> "Caso a mídia seja uma publicação institucional da Secretaria, enviar o arquivo do documento para o e-mail <a href="mailto:smecopedbibliotecadigital@sme.prefeitura.sp.gov.br">smecopedbibliotecadigital@sme.prefeitura.sp.gov.br</a> para que seja feito o upload no Acervo Digital, a fim de mantermos a padronização na catalogação, e evitar que versões desatualizadas fiquem disponíveis".</div>' );


var $s = jQuery.noConflict();

$s('#attachment_alt').each(function() {
    var textbox = $s(document.createElement('textarea')).val(this.value);
    console.log(this.attributes);
    $s.each(this.attributes, function() {
        if (this.specified) {
            textbox.prop(this.name, this.value)
        }
    });
    $s(this).replaceWith(textbox);
});

$s('#attachment-details-two-column-alt-text').each(function() {
    var textbox = $s(document.createElement('textarea')).val(this.value);
    console.log(this.attributes);
    $s.each(this.attributes, function() {
        if (this.specified) {
            textbox.prop(this.name, this.value)
        }
    });
    $s(this).replaceWith(textbox);
});

$s("#acf-field_636be867c3e08").prop('disabled', true);
$s("#acf-field_63876e7de650f").prop('disabled', true);

window.onload = function() {
    var $div = $s("#__wp-uploader-id-0");
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === "class") {

                //var attributeValue = $s(mutation.target).prop(mutation.attributeName);
                //console.log("Class attribute changed to:", attributeValue);

                $s("[aria-describedby='alt-text-description']").each(function() {
                    var textbox = $s(document.createElement('textarea')).val(this.value);
                    //console.log(this.attributes);
                    $s.each(this.attributes, function() {
                        if (this.specified) {
                            textbox.prop(this.name, this.value)
                        }
                    });
                    $s(this).replaceWith(textbox);
                });
            }
        });
    });
    observer.observe($div[0], {
        attributes: true
    });
}