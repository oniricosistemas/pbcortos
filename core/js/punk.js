/* 
 * Archivo javascript con funciones generales y basicas usadas en el framework
 */

$(document).ready(
    function() {
        $('.ajax').live("click", function(){
            //console.log($(this).attr("href"));
            var pagina = $(this).attr("href");
            envioAjax(pagina);
            /*var x = $('#main');
            x.ajaxStart(inicioEnvio);
            x.load(pagina);
            x.ajaxStop(paroEnvio);*/
            return false;
        })

        function inicioEnvio()
        {
            var x = $("#preloader");
            var y = $("#wrapper");
            y.css({
                'opacity' : 0.3
            });
            x.css("display","block");

        }

        function paroEnvio(){
            var x = $("#preloader");
            var y = $("#wrapper");
            x.hide();
            y.css({
                'opacity' : 1
            });

        }
        function envioAjax(url){
            $.ajax({
                url: url,
                beforeSend: inicioEnvio,
                complete: paroEnvio,
                success: function(data) {                    
                    $.getScript(baseJs+'punk.js');
                    $.getScript(baseJs+'effects.js');
                    $.getScript('template/js/jNice.js');
                    $.getScript('template/js/funciones.js');
                    $('#main').empty();
                    $('#main').html(data);
                }
            });
        }
        $('.delete').click(function(){
            var link = '';
            link = $(this).attr('href');
            $( "#dialog-confirm" ).dialog( "destroy" );
            //llamo al cuadro de dialogo para borrar un item
            $( "#dialog-confirm" ).dialog({
                autoOpen: true,
                resizable: false,
                height:140,
                width: 400,
                modal: true,
                buttons: {
                    "Si": function() {
                        window.location = link;
                        $( this ).dialog( "close" );
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
            return false;
        })
        // funcion ajax para cargar contenido en un contenido especifico
        function requestAjax(link,param,valor,contenedor,visible){
            var url ;
            url = link;
            if(contenedor==''){
                alert(no);
            }
            else{
                alert(contenedor);
            }
            if(param!=''){
                url = url+"&"+param;
            }
            if(valor!=''){
                url = url+'='+valor;
            }
            $.ajax({
                url: url,
                cache: false,
                success: function(html){
                    //alert(url);
                    $("#"+contenedor).empty();
                    $("#"+contenedor).append(html);
                    if(visible==1){
                        $("#"+contenedor).css('display','block');
                    }
                }
            });

        }

        function submitAjax(idForm,link,contenedor,visible){
            $.ajax({
                async:true,
                type: "POST",
                dataType: "html",
                contentType: "application/x-www-form-urlencoded",
                url: link,
                data: $("#"+idForm).serialize(),
                beforeSend:function(){
                    $("#cargando" ).dialog({
                        modal: true,
                        position: 'center'
                    });
                },
                success:function(html){
                    if(contenedor!=''){
                        $("#"+contenedor).empty();
                        $("#"+contenedor).append(html);
                        if(visible==1){
                            $("#"+contenedor).css('display','block');
                        }
                    }
                },
                timeout:114000
            });
            return false;
        }
    }
    );
