jQuery(function() {
    jQuery("#inputDate").datepicker({
        dateFormat: 'mm/yy',
        closeText:"Fechar",
        prevText:"&#x3C;Anterior",
        nextText:"Próximo&#x3E;",
        currentText:"Hoje",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onClose: function() {
            var iMonth = jQuery("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var iYear = jQuery("#ui-datepicker-div .ui-datepicker-year :selected").val();
            jQuery(this).datepicker('setDate', new Date(iYear, iMonth, 1));
        },
        monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
        monthNamesShort:["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
        dayNames:["Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sábado"],
        dayNamesShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
        dayNamesMin:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
        weekHeader:"Sm",
        firstDay:1
    });


    /*ativa o pill css*/
    jQuery(".pill-one").click(function(){
        jQuery(".pill-all").removeClass('active-pill');
        jQuery(this).toggleClass('active-pill');
        var local = jQuery(this).data('local');
        if( jQuery('#' + local).val() == '' ){
            jQuery('#' + local).val(local);
        } else {
            jQuery('#' + local).val('');
        }
    });

    var activePill = true;
    jQuery(".pill-all").click(function(){
        if(activePill == true){
            jQuery(".pill-one").addClass('active-pill');
            activePill = false;
        }else{
            jQuery(".pill-one").removeClass('active-pill');
            activePill = true;
        }

        jQuery(this).toggleClass('active-pill');
    });


    
    /*Validação de form*/
    /*
    jQuery("input").blur(function(){
        if(jQuery(this).val() != ""){
            jQuery(this).css({"background" : "#FFF1D5"});
            jQuery(this).css({"border-color" : "#CFD2D5"});
            //jQuery(this).css({"background" : "#FFF1D5", "color" : "#fff"});
        }
        if(jQuery(this).val() == ""){
            jQuery(this).css({"border-color" : "#FFB441"});
        }
    }); */


    /*Abre Filtro*/
    jQuery(".btn-filtros").click(function(){
        jQuery('.filter-sidebar').show('active-pill');
    });
    /*Fecha Filtro*/
    jQuery(".btn-filtros-close").click(function(){
        jQuery('.filter-sidebar').hide('active-pill');
    });

    /*Abre menu*/
    jQuery(".btn-menu").click(function(){
        jQuery('.menu-sidebar').show('active-pill');
    });

    /*Fecha menu*/
    jQuery(".btn-menu-close").click(function(){
        jQuery('.menu-sidebar').hide('active-pill');
    });


    /*coloca pill no form*/
    jQuery("[data-local=cinema]").click(function(){
      jQuery(this).toggleClass('active-pill');
    });


    /*Limpar filtros*/
    jQuery('#tipodetransporte').change(function () {
        let tipodetransporte = jQuery('#tipodetransporte').val();
        if(tipodetransporte != "Selecionado"){
            jQuery('.btn-limpar-filtros').show();
        }
    });
    jQuery('#tipogenero').change(function () {
        let tipogenero = jQuery('#tipogenero').val();
        if(tipogenero != "Selecionado"){
            jQuery('.btn-limpar-filtros').show();
        }
    });
    jQuery('#tipoevento').change(function () {
        let tipoevento = jQuery('#tipoevento').val();
        if(tipoevento != "Selecionado"){
            jQuery('.btn-limpar-filtros').show();
        }
    });
    jQuery("#eventosacessiveis").change(function() {
        if(this.checked) {
            jQuery('.btn-limpar-filtros').show();
        }else{
            //I'm not checked
        }
    });
    jQuery(".btn-limpar-filtros").click(function(){
        //jQuery('#tipodetransporte').val('Selecionado');
        //jQuery('#tipogenero').val('Selecionado');

        jQuery('option', jQuery('#tipodetransporte')).each(function(element) {
            jQuery(this).removeAttr('selected').prop('selected', false);
        });
        jQuery("#tipodetransporte").multiselect('refresh');

        jQuery('option', jQuery('#tipogenero')).each(function(element) {
            jQuery(this).removeAttr('selected').prop('selected', false);
        });
        jQuery("#tipogenero").multiselect('refresh');

        jQuery('option', jQuery('#tipoevento')).each(function(element) {
            jQuery(this).removeAttr('selected').prop('selected', false);
        });
        jQuery("#tipoevento").multiselect('refresh');

        jQuery( "#eventosacessiveis" ).prop( "checked", false );
    });


    /*Aplicar filtros*/
    jQuery(".btn-aplicar-filtros").click(function(){
        jQuery('.filter-sidebar').hide('active-pill');
    });


    /*Multi Select*/
    jQuery('#tipodetransporte').multiselect({
        buttonWidth: '100%',
        nonSelectedText: "Selecione",
        allSelectedText: "Todos selecionados",
        includeSelectAllOption: false,
    });
    jQuery('#tipogenero').multiselect({
        buttonWidth: '100%',
        nonSelectedText: "Selecione",
        allSelectedText: "Todos selecionados",
        includeSelectAllOption: false,
    });
    jQuery('#tipoevento').multiselect({
        buttonWidth: '100%',
        nonSelectedText: "Selecione",
        allSelectedText: "Todos selecionados",
        includeSelectAllOption: false,
    });
    jQuery('#ciclo').multiselect({
        buttonWidth: '100%',
        nonSelectedText: "Selecione",
        allSelectedText: "Todos selecionados",
        includeSelectAllOption: false,
    });
    jQuery('#faixa').multiselect({
        buttonWidth: '100%',
        nonSelectedText: "Selecione",
        allSelectedText: "Todos selecionados",
        includeSelectAllOption: false,
    });
    jQuery('#tipo_pcd').multiselect({
        buttonWidth: '100%',
        nonSelectedText: "Informe",
        allSelectedText: "Todos selecionados",
        includeSelectAllOption: false,
    });

});







/*Parceiros auto complete*/
function autocomplete(inp, arr) {
    var currentFocus;
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for (i = 0; i < arr.length; i++) {
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                b = document.createElement("DIV");
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                b.addEventListener("click", function(e) {
                    inp.value = this.getElementsByTagName("input")[0].value;
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
        } else if (e.keyCode == 38) { //up
            currentFocus--;
            addActive(x);
        } else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
                if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        if (!x) return false;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}