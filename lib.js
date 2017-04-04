function nuevafunc(){
	archivo=document.getElementById("file").value;
	
	if(archivo!=""){
		datFormulario=document.formulario_archivo;
		datFormulario.action="./upload.php?file="+archivo;
		datFormulario.submit();
		//ajaxpost( datFormulario, '_blank', "upload.php?file="+archivo );
		$('#dialog').dialog('destroy');
	}else{
		alert("Debe ingresar un archivo antes de solicitar su subida");
	}
	/*var inputFileImage = document.getElementById("file");
	var archivo=document.getElementById("file").value
	var file = inputFileImage.files[0];
	var data1 = new FormData();
	data1.append('archivo',file);
	var url = "upload.php";
	
	$.ajax({
		url:url,
		type:'POST',
		contentType:false,
		data:data1,
		processData:false,
		cache:false,
		 success: function (data1) {
                var win = window.open();
                win.document.write(data1);
            }
	});*/
}


function uploadPDF(){
	archivo=document.getElementById("file").value;
	
	if(archivo!=""){
		datFormulario=document.formulario_archivo;
		datFormulario.action="./upload_pdf.php?file="+archivo;
		datFormulario.submit();
		//ajaxpost( datFormulario, '_blank', "upload.php?file="+archivo );
		$('#dialog').dialog('destroy');

	}else{
		alert("Debe ingresar un archivo antes de solicitar su subida");
	}
	/*var inputFileImage = document.getElementById("file");
	var file = inputFileImage.files[0];
	var data = new FormData();
	data.append('archivo',file);
	var url = "upload_pdf.php";

			$.ajax({
				url:url,
				type:'POST',
				contentType:false,
				data:data,
				processData:false,
				cache:false,
				success: function (data) {
    			    if(data.status == 'success'){
        				$("#archivoPDFtext").val(data.archivo);
        				$("#mydiv").val('Archivo subido exitosamente! ');
        				$('#dialog').dialog('destroy');
    				}else if(data.status == 'error'){
        				$("#mydiv").val(" Ha ocurrido un error inesperado en la subida del archivo. " + data.msg);
        				$('#dialog').dialog('destroy');
    				}
    			}
			});*/
}

function uploadPDF_CAV(){
	archivo=document.getElementById("file").value;
	
	if(archivo!=""){
		datFormulario=document.formulario_archivo;
		datFormulario.action="./upload_pdf_cav.php?file="+archivo;
		datFormulario.submit();
		//ajaxpost( datFormulario, '_blank', "upload.php?file="+archivo );
		$('#dialog').dialog('destroy');
		
	/*	if ($("#archivoPDFtext").val() == ""){
			alert("Archivo subido exitosamente!");
		}else{
			alert("error al adjuntar el archivo PDF. Intentelo nuevamente por favor.");
		}*/

	}else{
		alert("Debe ingresar un archivo antes de solicitar su subida");
	}
	
	/*var inputFileImage = document.getElementById("file");
	var file = inputFileImage.files[0];
	var data = new FormData();
	data.append('archivo',file);
	var url = "upload_pdf.php";

			$.ajax({
				url:url,
				type:'POST',
				contentType:false,
				data:data,
				processData:false,
				cache:false,
				success: function (data) {
    			    if(data.status == 'success'){
        				$("#archivoPDFtext_cav").val(data.archivo);
        				alert('Archivo subido exitosamente! ');
        				$('#dialog').dialog('destroy');
    				}else if(data.status == 'error'){
        				alert(" Ha ocurrido un error inesperado en la subida del archivo. " + data.msg);
        				$('#dialog').dialog('destroy');
    				}
    			}
			});*/
}

function descargarPDF(archivo){
	var raiz = '/usr/local/apache2/htdocs/web/cencina/escalamiento/escalamiento_critico/documentos/';
	alert(archivo);
}

function ventanita3(){
	var url = "controller.php?mod=pdf_cav";
	var titulo = "Explorador de Archivos";
	ventanita( titulo, url, 150, 400 );
}

function ventanita2(){
	var url = "controller.php?mod=correo";
	var titulo = "Explorador de Archivos";
	ventanita( titulo, url, 150, 400 );
}

function ventanita1(){
	var url = "controller.php?mod=pdf";
	var titulo = "Explorador de Archivos";
	ventanita( titulo, url, 150, 400 );
}

function ventanita2010() {
	alert('entra');
	var pagina = "controller.php?mod=pdf";
	var ancho=500;
	var alto=450;
	var titulo='Adjuntar Documento';

	var especial = "?";
    var direccion="";

    $('#ventanita').addClass('thickbox');
    $('#ventanita').attr('title',titulo);
    $('#ventanita').attr('href',pagina);
    $('#ventanita').click();
}

function adjuntaDoc_tipo(id_inf,usuario,doc){

}

function IngresaEscalamiento(){

var RUTP = $("#rut_per").val();
var NOMB = $("#nombre").val();
var DIRE = $("#combo_iden>option:selected").html();
var LOCA = $("#zonac").val();
var NODO = $("#nodoc").val();
var TI_ESC=$("#combo_tipo").val();
var MOTI_ESC=$("#combo_motivoc").val();
var OBSN = $("#textComentario_c").val();
var CORREO = $("#correoc").val();
var MOTIVO_DESC = $("#combo_motivoc>option:selected").html();

var SER_TV = $("#check1:checked").val();
	if (SER_TV != "1") {
		SER_TV='0';
	}
var SER_PRE = $("#check2:checked").val();
	if (SER_PRE != "1") {
		SER_PRE='0';
	}
var SER_FONO = $("#check3:checked").val();
	if (SER_FONO != "1") {
		SER_FONO='0';
	}
var SER_INET = $("#check4:checked").val();
	if (SER_INET != "1") {
		SER_INET='0';
	}
	
	if (CORREO!="") {
		if (TI_ESC!="") {
			if (MOTI_ESC!="") {
				if (OBSN!="") { 
					if ( (SER_TV!="0")||(SER_PRE!="0")||(SER_FONO!="0")||(SER_INET!="0") ){
						var resp = ajaxgetResponse('controller.php?mod=guarda_escalamientoNuevo&RUTP='+RUTP+'&NOMB='+NOMB+'&DIRE='+DIRE+'&LOCA='+LOCA+'&NODO='+NODO+'&TI_ESC='+TI_ESC+'&OBSN='+OBSN+'&SER_TV='+SER_TV+'&SER_PRE='+SER_PRE+'&SER_FONO='+SER_FONO+'&SER_INET='+SER_INET+'&MOTI_ESC='+MOTI_ESC+'&MOTIVO_DESC='+MOTIVO_DESC+'&CORREO='+CORREO);
						if(resp == 1){
							ajaxgetpage('controller.php?mod=enviaCorreoPend&RUTP='+RUTP+'&DIRE='+DIRE+'&TI_ESC='+TI_ESC+'&MOTI_ESC='+MOTI_ESC);
							alert('Se ha realizado un escalamiento correctamente.');
						}
						ajaxgetpage('controller.php?mod=pest_ingreso');	
					}else{
						alert('Ingrese al menos un servicio.');
						$("#check1").focus();
					}
				} else {
					alert('Ingrese comentario.');
					$("#textComentario_c").focus();
				}
			} else {
			alert('Ingrese Motivo de escalamiento.');
			$("#combo_motivoc").focus();
			}	
		} else {
			alert('Ingrese Tipo de escalamiento.');
			$("#combo_tipo").focus();
		}
	} else {
		alert('Adjunte correo electronico.');
		$("#adjuntarc").focus();
	}
}

function volver_pesta(){
	ajaxgetpage('controller.php?mod=pest_ingreso');	
}	

function CerrarEscalamiento(id){
	var valor = $("#estadoCerrar_"+id+" option:selected").val();
	
	var resp = ajaxgetResponse('controller.php?mod=estadoCerrarEscalamiento&valor='+valor+'&id='+id)
	if(resp == 1){
			
			alert('Se ha el estado correctamente');

			ajaxgetpage('controller.php?mod=pest_ver');	
		}else{
			alert('Ha ocurrido un error inesperado'); 
		}	
}

function cerrarEscalamiento(valor){
	var comen = $("#comentarioCAV").val();
	var pdf_cav = $("#archivoPDFtext_cav").val();
	
	if (comen!="") {
		if (pdf_cav!="") { 
			var r = confirm("Desea finalizar el escalamiento nro. "+valor+" con conformidad del cliente?");
			if ( r == true){
				var resp = ajaxgetResponse('controller.php?mod=cerrarEscalamiento&valor='+valor+'&comen='+comen+'&pdf_cav='+pdf_cav);	
				if(resp == 1){
					ajaxgetpage('controller.php?mod=enviaCorreoFinal&id_esca='+valor);
					$('#modal_servicio').empty();  
					$('#modal_servicio').remove();
					alert('Se ha finalizado el escalamiento correctamente');
					$('#modal_servicio').dialog('destroy');
					ajaxgetpage('controller.php?mod=pest_fin');
				}else{
					alert('Ha ocurrido un error inesperado'); 
				}	
			}
		}else{
			alert('Adjunte archivo PDF.');
		}
	}else{
		alert('Ingrese comentario.');
		$("#comentarioCAV").focus();
	}
}

function finalizarSinContacto(valor){
	var comen = $("#comentarioCAV").val();
	var pdf_cav = $("#archivoPDFtext_cav").val();

	if (comen!="") {
		if (pdf_cav!="") { 
			var r = confirm("Desea finalizar el escalamiento nro. "+valor+" Sin Contacto con el cliente?");
			if ( r == true){
				var resp = ajaxgetResponse('controller.php?mod=finalizarSinContacto&valor='+valor+'&comen='+comen+'&pdf_cav='+pdf_cav);	
				if(resp == 1){
					ajaxgetpage('controller.php?mod=enviaCorreoFinal&id_esca='+valor);
					//$('#modal_servicio').empty();  
					//$('#modal_servicio').remove();
					alert('Se ha finalizado el escalamiento correctamente');
					$('#modal_servicio').dialog('destroy');
					ajaxgetpage('controller.php?mod=pest_fin');
				}else{
					alert('Ha ocurrido un error inesperado'); 
				}	
			}
		}else{
			alert('Adjunte archivo PDF.');
		}
	}else{
		alert('Ingrese comentario.');
		$("#comentarioCAV").focus();
	}
}

function IngresaEscalamientoOrden(){

var ID_ESC = $("#id_esca").val();
var NORDEN = $("#norden_o").val();
var FINGRESO = $("#fingreso_o").val();
var OBSERORI = $("#obserori_o").val();
var RUTP = $("#rut_o").val();
var NOMB = $("#nombre_o").val();
var DIRE = $("#direccion_o").val();
var LOCA = $("#localidad_o").val();
var NODO = $("#nodo_o").val();
var TI_ESC=$("#combo_tipo_o").val();
var MOTI_ESC=$("#combo_motivoc_o").val();
var OBSN = $("#textComentario_o").val();
var MOTIVO_DESC = $("#combo_motivoc_o>option:selected").html();

var SER_TV = $("#check1o:checked").val();
	if (SER_TV != "1") {
		SER_TV='0';
	}
var SER_PRE = $("#check2o:checked").val();
	if (SER_PRE != "1") {
		SER_PRE='0';
	}
var SER_FONO = $("#check3o:checked").val();
	if (SER_FONO != "1") {
		SER_FONO='0';
	}
var SER_INET = $("#check4o:checked").val();
	if (SER_INET != "1") {
		SER_INET='0';
	}

	if (TI_ESC!="") {
		if (MOTI_ESC!="") {
			if (OBSN!="") { 
				if ( (SER_TV!="0")||(SER_PRE!="0")||(SER_FONO!="0")||(SER_INET!="0") ){
					var resp = ajaxgetResponse('controller.php?mod=guarda_escalamientoOrden&RUTP='+RUTP+'&NOMB='+NOMB+'&DIRE='+DIRE+'&LOCA='+LOCA+'&NODO='+NODO+'&TI_ESC='+TI_ESC+'&OBSN='+OBSN+'&SER_TV='+SER_TV+'&SER_PRE='+SER_PRE+'&SER_FONO='+SER_FONO+'&SER_INET='+SER_INET+'&MOTI_ESC='+MOTI_ESC+'&NORDEN='+NORDEN+'&FINGRESO='+FINGRESO+'&OBSERORI='+OBSERORI+'&MOTIVO_DESC='+MOTIVO_DESC+'&ID_ESC='+ID_ESC);
					if (resp == 1) {
						ajaxgetpage('controller.php?mod=enviaCorreoNuevo&id_esca='+ID_ESC);
						alert('Se ha realizado un escalamiento correctamente.');
						ajaxgetpage('controller.php?mod=pest_ingreso');	
					} else {
						alert('Ha ocurrido un error inesperado.');
					}			
				}else{
					alert('Ingrese al menos un servicio.');
					$("#check1o").focus();
				}
			} else {
				alert('Ingrese comentario.');
				$("#textComentario_o").focus();
			}
		} else {
		alert('Ingrese Motivo de escalamiento.');
		$("#combo_motivoc_o").focus();
		}	
	} else {
		alert('Ingrese Tipo de escalamiento.');
		$("#combo_tipo_o").focus();
	}
}

function buscarOrden(){
	var valor = $("#valor_orden").val();
	$("#resp_esc2").html("");
	$("#resp_orden").html(ajaxgetResponse('controller.php?mod=buscarOrden&valor='+valor));	
}

function buscarEscalamiento(){
	var valor = $("#valor_escalamiento").val();
	$("#resp_orden").html(ajaxgetResponse('controller.php?mod=buscarEscalamiento&valor='+valor));	
}

function buscarDatosCliente(){
	var iden = $('#combo_iden').val();
	var rut = $('#rut_per').val();
	var url = "controller.php?mod=buscarDatosCliente&iden="+iden+"&rut="+rut;
	ajaxgetpage(url,'resp_esc2'); 
} 


function seleccionaOrden(valor){
	$("#resp_orden").html(ajaxgetResponse('controller.php?mod=buscarOrden&valor='+valor));
}

function guardaOrden(){
	var err = "";
	var norden = $("#norden").val();
	var rut = $("#rut").val();
	var nombre = $("#nombre").val();
	var direccion = $("#direccion").val();
	var localidad = $("#localidad").val();
	var nodo = $("#nodo").val();
	var fingreso = $("#fingreso").val();
	var fcrea = $("#fcrea").val();
	var fcompro = $("#fcompro").val();
	var area = $("#area").val();
	var obserori = $("#obserori").val();
	var codarea = $("#codarea").val();	
	var motivo = $("#motivos").val();
	var obs = $("#observaciones").val();
	var activ = $("#activ").val();
	var codhorario = $("#codhorario").val();
	var borden = ajaxgetResponse('controller.php?mod=vbOrden&norden='+norden);
	
	if (motivo == ""){
		err += "Debe ingresar un Motivo de Escalamiento\n";
	}
	if (obs == ""){
		err += "Debe ingresar una Observacion";
	}
	
	if (borden == 0){
		if (err == ""){
			var resp = ajaxgetResponse('controller.php?mod=guardarOrden&norden='+norden
			+'&rut='+rut+'&nombre='+nombre+'&direccion='+direccion+'&localidad='+localidad
			+'&nodo='+nodo+'&fingreso='+fingreso+'&fcrea='+fcrea+'&fcompro='+fcompro+'&area='+area
			+'&obserori='+obserori+'&codarea='+codarea
			+'&motivo='+motivo+'&obs='+obs+'&activ='+activ+'&codhorario='+codhorario);

			if(resp == 1){
				var resp2 = ajaxgetResponse('controller.php?mod=enviaCorreoNuevo&norden='+norden, 'divEnviaMail');
				alert('Se ha escalado la Orden correctamente');
			}else if(resp == 2){
				alert('No es posible escalar la orden, por favor intente nuevamente tras ingresar nuevamente');
				window.location.reload(); 
				}else{
					alert('Ha ocurrido un error inesperado'); 
				} 
			}else{
				alert(err);
			}
		}else{
			alert("La orden ya tiene un escalamiento ingresado");
		}
}

function asignaOrden(valor){
	var r = confirm("Desea Asignarse la Orden "+valor+" ?");
	if ( r == true){
		var resp = ajaxgetResponse('controller.php?mod=asignarOrden&valor='+valor);	
		if(resp == 1){
			var resp2 = ajaxgetResponse('controller.php?mod=enviaCorreo&norden='+valor, 'div_enviaMail');
			ajaxgetpage('controller.php?mod=pest_ver');
			alert('Se ha asignado la Orden correctamente');
		}else{
			alert('Ha ocurrido un error inesperado'); 
		}	
	}
}


function reescalamientos(valor){
	var comen = $("#comentarioCAV").val();
	var pdf_cav = $("#archivoPDFtext_cav").val();

	if (comen!="") {
		if (pdf_cav!="") { 
			var r = confirm("Desea realizar un reescalamiento de la Orden nro. "+valor+" ?");
			if ( r == true){
				var resp = ajaxgetResponse('controller.php?mod=reescalamiento&valor='+valor+'&comen='+comen+'&pdf_cav='+pdf_cav);	
				if(resp == 1){
					ajaxgetpage('controller.php?mod=enviaCorreoAsig&id_esca='+valor);
					//$('#modal_servicio_').empty();  
					//$('#modal_servicio').remove();
					alert('Se ha reescalado la Orden correctamente');
					$('#modal_servicio').dialog('destroy');
					ajaxgetpage('controller.php?mod=pest_fin');
				}else{
					alert('Ha ocurrido un error inesperado'); 
				}	
			}
		}else{
			alert('Adjunte archivo PDF.');
		}
	}else{
		alert('Ingrese comentario.');
		$("#comentarioCAV").focus();
	}
}

function finalOrden(valor){
	var postMortem = $("#postMortem").val();
	var comen = $("#finalizaComentario").val();
	var pdf_ejec = $("#archivoPDFtext").val();
	if (pdf_ejec == ""){
		alert("Se debe adjuntar el archivo PDF");
	}else{
		if (comen == ""){
			alert("Se debe ingresar al menos una accion preventiva para cerrar la Orden");
		}else{
			if (postMortem == ""){
				alert("Se debe ingresar el Post Mortem para cerrar la Orden");
			}else{
				var resp = ajaxgetResponse('controller.php?mod=finalizarOrden&valor='+valor+'&comen='+comen+'&postMortem='+postMortem+'&pdf_ejec='+pdf_ejec);
				//alert(resp);
				if(resp == 1){
					ajaxgetpage('controller.php?mod=enviaCorreoEjec&id_esca='+valor);
					alert('Se ha finalizado la Orden correctamente');
					$('#modal_servicio').dialog('destroy');
					ajaxgetpage('controller.php?mod=pest_ver');
				}else{
					alert('Ha ocurrido un error inesperado '); 
				}
			}
		}
	}
}

function comentaOrden(valor){
	var url = "controller.php?mod=comentarOrden&valor="+valor;
	$("#modal_servicio").html(ajaxgetResponse(url));
	$("#modal_servicio").dialog('open');
	$("#modal_servicio").dialog({
		bgiframe: true
        ,resizable: true
        ,width:955
        ,height:600
        ,modal: true
        ,stack: false
        ,title:'<h3><img src="/_includes/icons/delete.png" width="18" height="18">Orden N '+valor+'</h3>'
        ,overlay: {backgroundColor: '#000000', opacity: 1.8 }
     });
}

function comentaOrdenPrecer(valor){
	var url = "controller.php?mod=comentarOrdenPrecer&valor="+valor;
	$("#modal_servicio").html(ajaxgetResponse(url));
	$("#modal_servicio").dialog('open');
	$("#modal_servicio").dialog({
		bgiframe: true
        ,resizable: true
        ,width:955
        ,height:600
        ,modal: true
        ,stack: false
        ,title:'<h3><img src="/_includes/icons/delete.png" width="18" height="18">Orden N '+valor+'</h3>'
        ,overlay: {backgroundColor: '#000000', opacity: 1.8 }
     });
}


function DetalleOrden2(valor){

	var r = confirm("Desea Asignarse el escalamiento "+valor+" ?");
		if ( r == true){
				var resp = ajaxgetResponse('controller.php?mod=AsignaEscalamiento&valor='+valor);
				alert('Se ha asignado la Orden correctamente22');
				if(resp == 1){
					
					alert('Se ha asignado la Orden correctamente22');
				}else {
				alert('NO Se ha asignado la Orden correctamente11');}
		}
			var url = "controller.php?mod=detallarOrden&valor="+valor;
			$("#modal_servicio").html(ajaxgetResponse(url));
			$("#modal_servicio").dialog('open');
			$("#modal_servicio").dialog({
				bgiframe: true
		        ,resizable: true
		        ,width:955
		        ,height:300
		        ,modal: true
		        ,stack: false
		        ,title:'<h3><img src="/_includes/icons/delete.png" width="18" height="18">Escalamiento N '+valor+'</h3>'
		        ,overlay: {backgroundColor: '#000000', opacity: 1.8 } });
		
}

function DetalleOrden(valor){

 	var dialog = $('<p>Desea Asignarse el escalamiento '+valor+' ?</p>').dialog({
 					modal: true,
                    buttons: {
                        "Si": function() {
                        	dialog.dialog('close');
                        	var resp = ajaxgetResponse('controller.php?mod=AsignaEscalamiento&valor='+valor);
								if(resp == 1){ 
									var resp2 = ajaxgetResponse('controller.php?mod=enviaCorreoAsig&id_esca='+valor, 'div_enviaMail');
									alert('Se ha asignado la Orden correctamente');
								} else {
									alert('Ha ocurrido un error inesperado');
								}
								ajaxgetpage('controller.php?mod=pest_ver');
							var url = "controller.php?mod=detallarOrden&valor="+valor;
							$("#modal_servicio").html(ajaxgetResponse(url));
							$("#modal_servicio").dialog('open');
							$("#modal_servicio").dialog({
								bgiframe: true
						        ,resizable: true
						        ,width:955
						        ,height:300
						        ,modal: true
						        ,stack: false
						        ,title:'<h3><img src="/_includes/icons/delete.png" width="18" height="18">Escalamiento N '+valor+'</h3>'
		        ,overlay: {backgroundColor: '#000000', opacity: 1.8 } });
                        },
                        "No":  function() {	
                        	dialog.dialog('close');						
                        	var url = "controller.php?mod=detallarOrden&valor="+valor;
							$("#modal_servicio").html(ajaxgetResponse(url));
							$("#modal_servicio").dialog('open');
							$("#modal_servicio").dialog({
								bgiframe: true
						        ,resizable: true
						        ,width:955
						        ,height:300
						        ,modal: true
						        ,stack: false
						        ,title:'<h3><img src="/_includes/icons/delete.png" width="18" height="18">Escalamiento N '+valor+'</h3>'
		        ,overlay: {backgroundColor: '#000000', opacity: 1.8 } });},
                        "Anular Escalamiento":  function() {
                            	dialog.dialog('close');
									var r = confirm("Esta seguro que desea Anular la orden "+valor+" ?");
									if ( r == true){
										var resp = ajaxgetResponse('controller.php?mod=anularOrden&valor='+valor);
										if(resp == 1){
											var resp2 = ajaxgetResponse('controller.php?mod=enviaCorreo&norden='+valor, 'div_enviaMail');
											ajaxgetResponse('controller.php?mod=refComentario&norden='+valor, 'ver_orden');
											//$('#modal_servicio').dialog('destroy');
											$('#modal_servicio').empty();
											$('#modal_servicio').remove();
											ajaxgetpage('controller.php?mod=pest_ver');
											alert('Se ha Anulado la Orden correctamente');
										}else{
											if (resp == 2){
												alert('No posee los permisos necesarios para anular el escalamiento.'); 
											}else{
												alert('Ha ocurrido un error inesperado'); 
											} 
										}	
								}
                        }
                    }
                });							
}

function anulOrden(valor){
	var comen = $("#cbxAnula option:selected").text();
	alert(comen);
	if (comen != "Seleccione...."){
		//alert(comen);
		var r = confirm("Esta seguro que desea Anular la orden "+valor+" ?");
		if ( r == true){
			var resp = ajaxgetResponse('controller.php?mod=anularOrden&valor='+valor+'&comen='+comen);
			if(resp == 1){
				var resp2 = ajaxgetResponse('controller.php?mod=enviaCorreo&norden='+valor, 'div_enviaMail');
				ajaxgetResponse('controller.php?mod=refComentario&norden='+valor, 'ver_orden');
				$('#modal_servicio').dialog('destroy');
				ajaxgetpage('controller.php?mod=pest_ver');
				alert('Se ha Anulado la Orden correctamente');
			}else{
			alert('Ha ocurrido un error inesperado'); 
			}	
		}
	}else{
		alert('Debe seleccionar un Motivo para Anular la Orden');
	}
}


function anulOrdenEsca(valor){

	var r = confirm("Esta seguro que desea Anular la orden "+valor+" ?");
	if ( r == true){
		var resp = ajaxgetResponse('controller.php?mod=anularOrden&valor='+valor);
		//resp = 1;
		if(resp == 1){
			var resp2 = ajaxgetResponse('controller.php?mod=enviaCorreo&norden='+valor, 'div_enviaMail');
			//ajaxgetResponse('controller.php?mod=refComentario&norden='+valor, 'ver_orden');
			$('#modal_servicio').dialog('destroy');
			ajaxgetpage('controller.php?mod=pest_fin');
			alert('Se ha Anulado la Orden correctamente');
		}else{
			alert('Ha ocurrido un error inesperado'); 
		}	
	}
}

function comentarioOrden(valor){
	var comen = $("#ingresaComentario").val();
	if (comen == ""){
		alert("Debe ingresar un comentario");
	}else{
		var resp = ajaxgetResponse('controller.php?mod=comentaOrden&valor='+valor+'&comen='+comen);
		if(resp == 1){
			ajaxgetResponse('controller.php?mod=refComentario&norden='+valor, 'ver_orden');
			alert('Se ha ingresado un nuevo comentario a la Orden');
			$("#ingresaComentario").val('');
		}else{
			alert('Ha ocurrido un error inesperado'); 
		}
	}
}

function selEscala(){
	var escala = $("#escalamientos").val();
	var terr = $("#territorio").val();
	var reg = $("#region").val();
	var loc = $("#comuna").val();
	
	ajaxgetpage('controller.php?mod=pest_ver&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala);
}

function selTerritorio(){
	var terr = $("#territorio").val();
	var reg = $("#region").val();
	var loc = $("#comuna").val();
	var escala = $("#escalamientos").val();
	
	ajaxgetpage('controller.php?mod=pest_ver&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala);
	
}

function selRegion(){
	var terr = $("#territorio").val();
	var reg = $("#region").val();
	var loc = $("#comuna").val();
	var escala = $("#escalamientos").val();
	
	
	ajaxgetpage('controller.php?mod=pest_ver&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala);
	
}

function selLocalidad(){
	var terr = $("#territorio").val();
	var reg = $("#region").val();
	var loc = $("#comuna").val();
	var escala = $("#escalamientos").val();
	
	
	ajaxgetpage('controller.php?mod=pest_ver&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala);
}

function guardarNombre(opc){
	var msg = '';
	var serv = $('#txtDesr').val();
	var serv1 = $('#txtDesr1').val();
	
		if(serv == ''){
			$('#txtDesr').css('background','#FFCCCC');
			alert('Debe ingresar el nombre del Usuario CAV');
		}else{
			$('#txtDesr').css('background','#FFF');
			var url = "controller.php?mod=guardaUsuarioCAV&nombre="+serv+"&idu="+serv1;
		}	
		
	var resp = ajaxgetResponse(url);
	if(resp == 1){
		alert('Se ha ingresado un nuevo Usuario');
		$('#txtDesr').val('');
		$('#txtDesr1').val('');
		var serv = '';
		var url = "controller.php?mod=listaRegistros&serv="+serv;
		$('#listado_servicio').html(ajaxgetResponse(url));
	}else{
		alert('Ha ocurrido un error inesperado'); 
	}
}
 
function isNumberKeyMnp(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
    	var v = $("#txt_menor_p").val();
    	var s = v - 1;
    	$("#lbl_menor_p").html(s);
        return true;
    }      
}
 
function isNumberKeyMyp(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
    	var b = $("#txt_mayor_p").val();
    	var n = parseInt(b) + parseInt(1);
    	$("#lbl_mayor_p").html(n);
        return true;
    }      
}

 
function isNumberKeyMne(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
    	var v = $("#txt_menor_e").val();
    	var s = v - 1;
    	$("#lbl_menor_e").html(s);
        return true;
    }      
}
 
function isNumberKeyMye(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
    	var b = $("#txt_mayor_e").val();
    	var n = parseInt(b) + parseInt(1);
    	$("#lbl_mayor_e").html(n);
        return true;
    }      
}

function TraeformTiempo(){
	var id = $("#cbxTiempoArea").val();
	$("#div_tiempo").html(ajaxgetResponse('controller.php?mod=Form_tiempo&id='+id));
}

function guardarTiempo(){
	var menorp = $("#txt_menor_p").val();
	var mayorp = $("#txt_mayor_p").val();
	var menore = $("#txt_menor_e").val();
	var mayore = $("#txt_mayor_e").val();
	var area = $("#cbxTiempoArea").val();
	
	var a = "";
	if (menorp == '' || mayorp == '' || menore == '' || mayore == ''){
		alert('Debe ingresar todos los datos');
	}else{
		if (menorp >= mayorp ){
			a = "El segundo valor del Tiempo Pendiente,debe ser mayor al primero\n";
		}
		if (menore >= mayore ){
			a = "El segundo valor del Tiempo En Ejecucion,debe ser mayor al primero";
		}
	}
	if (a == ""){
		var pend = menorp + "-" + mayorp;
		var ejec = menore + "-" + mayore;
		var resp = ajaxgetResponse('controller.php?mod=guardaTiempo&pend='+pend+'&ejec='+ejec+'&area='+area);
		if(resp == 1){
			alert('Se han ingresado los tiempos correctamente');
			ajaxgetpage('controller.php?mod=mant_sla');
		}else{
			alert('Ha ocurrido un error inesperado'); 
		}
	}else{
		alert(a);
	}
}

function intervaloTiempo(){
	var escala = $("#escalamientos").val();
	var terr = $("#territorio").val();
	var reg = $("#region").val();
	var loc = $("#comuna").val();
	
	var url = 'controller.php?mod=pest_ver&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala;
	IntervalosOrd = setTimeout("ajaxgetpage('"+url+"' ,'ui-tabs-maintab-9')",50000);
}

function enviaMail(remitente, destino, asunto, cuerpo ){
	ajaxgetResponse('enviacorreo.php?remitente='+remitente+'&destino='+destino+'&asunto='+asunto+'&cuerpo='+cuerpo);
}

function enviaMail2(remitente, destino, asunto, cuerpo ){
	ajaxgetResponse('enviacorreo.php?remitente='+remitente+'&destino='+destino+'&asunto='+asunto+'&cuerpo='+cuerpo);
}

function getRecuerda(id){
	ajaxgetResponse('controller.php?mod=getRecuerda&id='+id, 'div_recuerda');
}


var ajax_tab_content_id;

function tabs_jqAAA(x) {
	$('#'+x).tabs({
		load: function(event, ui) {
			$('#cargando_ajax').css('display', 'none');
			ajax_tab_content_id = ui.panel.id;
		},
		select: function(event, ui) {
			$('#cargando_ajax').css('display', 'block');
			$.each($('#'+x+' div[id|="'+"ui-tabs-"+x+'"]'), function(i,elem) {
				if(ui.index != i){
					$(elem).html("");
				}
			});
		},
		/* editado el 3-8-2011 por clemente a peticiï¿½n de Raul (para reporte wireless, se supone que no afecta)
		show: function(event,ui) {
			$.each($('#'+x+' div[id|="'+"ui-tabs-"+x+'"]'), function(i,elem) {
				if(ui.index != i){
					$(elem).html("");
				}
			});
		},*/
		idPrefix: "ui-tabs-"+x+"-",
		cookie: { expires: 1 },
		ajaxOptions: { async: false },
		cache: false,
		selected: 0,
		event: 'click'
	});
}


function verOrden(valor){
	ventanita("Orden N "+valor, "controller.php?mod=verOrdenF&valor="+valor, 600, 955);
}

function verOrdenMortem(valor){
	ventanita("Orden N "+valor, "controller.php?mod=verOrdenMortem&valor="+valor, 600, 955);
}

function getVentana(estado, div){
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var escala = $("#Rescalamientos").val();
	var actividad = $("#Ractividad").val();
	var empresa = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();	
		
	var url = "controller.php?mod=detalleReportesBasic&estado="+estado+'&div='+div+'&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad;
	$("#VentanaDetalle").html(ajaxgetResponse(url));
	$("#VentanaDetalle").dialog('open');
	$("#VentanaDetalle").dialog({
		bgiframe: true
        ,resizable: true
        ,width:1150
        ,height:600
        ,modal: true
        ,stack: false
        ,title:'<h3><img src="/_includes/icons/application_form.png" width="18" height="18">Detalle</h3>'
        ,overlay: {backgroundColor: '#000000', opacity: 1.8 }
     });
}

function getVentana2(alerta, empresa, div){
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var escala = $("#Rescalamientos").val();
	var actividad = $("#Ractividad").val();
	var eps = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();

	
	var url = "controller.php?mod=detalleReportesAvanz&alerta="+alerta+'&empresa='+empresa+'&div='+div+'&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&eps='+eps+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad;
	$("#VentanaDetalle").html(ajaxgetResponse(url));
	$("#VentanaDetalle").dialog('open');
	$("#VentanaDetalle").dialog({
		bgiframe: true
        ,resizable: true
        ,width:1150
        ,height:600
        ,modal: true
        ,stack: false
        ,title:'<h3><img src="/_includes/icons/application_form.png" width="18" height="18">Detalle</h3>'
        ,overlay: {backgroundColor: '#000000', opacity: 1.8 }
     });
}

function getVentana3(alerta, empresa, div){
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var escala = $("#Rescalamientos").val();
	var actividad = $("#Ractividad").val();
	var eps = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();

	
	var url = "controller.php?mod=detalleReportesAvanz&alerta="+alerta+'&empresa='+empresa+'&div='+div+'&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&eps='+eps+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad;
	$("#VentanaDetalle").html(ajaxgetResponse(url));
	$("#VentanaDetalle").dialog('open');
	$("#VentanaDetalle").dialog({
		bgiframe: true
        ,resizable: true
        ,width:1150
        ,height:600
        ,modal: true
        ,stack: false
        ,title:'<h3><img src="/_includes/icons/application_form.png" width="18" height="18">Detalle</h3>'
        ,overlay: {backgroundColor: '#000000', opacity: 1.8 }
     });
}

function getDetalleDiv(alerta, usuario, div, empresa, divanterior){
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var escala = $("#Rescalamientos").val();
	var actividad = $("#Ractividad").val();
	var eps = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();

	var url = 'controller.php?mod=DetalleAvanzDiv&alerta='+alerta+'&usuario='+usuario+'&empresa='+empresa+'&divanterior='+divanterior+'&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&eps='+eps+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad;
	ajaxgetResponse(url, div);
}

function selEmpresaR(){
	var escala = $("#Rescalamientos").val();
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var actividad = $("#Ractividad").val();
	var empresa = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();	
	
	ajaxgetpage('controller.php?mod=pest_report&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad);
}

function selEscalaR(){
	var escala = $("#Rescalamientos").val();
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var actividad = $("#Ractividad").val();
	var empresa = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();		

	ajaxgetpage('controller.php?mod=pest_report&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad);
}

function selTerritorioR(){
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var escala = $("#Rescalamientos").val();
	var actividad = $("#Ractividad").val();
	var empresa = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();

	ajaxgetpage('controller.php?mod=pest_report&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad);
	
}

function selRegionR(){
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var actividad = $("#Ractividad").val();
	var escala = $("#Rescalamientos").val();
	var empresa = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();	

	ajaxgetpage('controller.php?mod=pest_report&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad);
	
}

function selLocalidadR(){
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var escala = $("#Rescalamientos").val();
	var actividad = $("#Ractividad").val();
	var empresa = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();
	
	ajaxgetpage('controller.php?mod=pest_report&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad);
}

function intervaloTiempoR(){
	var terr = $("#Rterritorio").val();
	var reg = $("#Rregion").val();
	var loc = $("#Rcomuna").val();
	var escala = $("#Rescalamientos").val();
	var actividad = $("#Ractividad").val();
	var empresa = $("#Rempresa").val();
	var fdesde = $("#RfechaDesde").val();
	var fhasta = $("#RfechaHasta").val();

	var url = 'controller.php?mod=pest_report&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta+'&actividad='+actividad;
	IntervalosOrdR = setTimeout("ajaxgetpage('"+url+"' ,'ui-tabs-maintab-11')",50000);
}


function selEscalaF(){
	var escala = $("#Fescalamientos").val();
	var terr = $("#Fterritorio").val();
	var reg = $("#Fregion").val();
	var loc = $("#Fcomuna").val();
	var empresa = $("#Fempresa").val();
	var fdesde = $("#FfechaDesde").val();
	var fhasta = $("#FfechaHasta").val();		

	ajaxgetpage('controller.php?mod=pest_fin&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta);
}

function selTerritorioF(){
	var escala = $("#Fescalamientos").val();
	var terr = $("#Fterritorio").val();
	var reg = $("#Fregion").val();
	var loc = $("#Fcomuna").val();
	var empresa = $("#Fempresa").val();
	var fdesde = $("#FfechaDesde").val();
	var fhasta = $("#FfechaHasta").val();

	ajaxgetpage('controller.php?mod=pest_fin&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta);
	
}

function selRegionF(){
	var escala = $("#Fescalamientos").val();
	var terr = $("#Fterritorio").val();
	var reg = $("#Fregion").val();
	var loc = $("#Fcomuna").val();
	var empresa = $("#Fempresa").val();
	var fdesde = $("#FfechaDesde").val();
	var fhasta = $("#FfechaHasta").val();	

	ajaxgetpage('controller.php?mod=pest_fin&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta);
	
}

function selLocalidadF(){
	var escala = $("#Fescalamientos").val();
	var terr = $("#Fterritorio").val();
	var reg = $("#Fregion").val();
	var loc = $("#Fcomuna").val();
	var empresa = $("#Fempresa").val();
	var fdesde = $("#FfechaDesde").val();
	var fhasta = $("#FfechaHasta").val();
	
	ajaxgetpage('controller.php?mod=pest_fin&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta);
}

function selEmpresaF(){
	var escala = $("#Fescalamientos").val();
	var terr = $("#Fterritorio").val();
	var reg = $("#Fregion").val();
	var loc = $("#Fcomuna").val();
	var empresa = $("#Fempresa").val();
	var fdesde = $("#FfechaDesde").val();
	var fhasta = $("#FfechaHasta").val();
	
	ajaxgetpage('controller.php?mod=pest_fin&terr='+terr+'&reg='+reg+'&loc='+loc+'&escala='+escala+'&empresa='+empresa+'&fdesde='+fdesde+'&fhasta='+fhasta);
}

//
function quitSer_cav(id){
	var id_cam  = $('#xnombre').val();
	var est = 'ELIMINA';
	if (confirm("¿Esta seguro de eliminar este registro?") == true){
	ajaxgetpage('controller.php?mod=elimina_cav&cav=mant_cav&id='+id, 'lista_mant_cav');
	}
}

function cancela_cav(cav)
{
	ajaxgetpage('controller.php?mod=cancela_cav', 'div_mant_cav');
}

function editSer_cav(id)
{
	ajaxgetpage('controller.php?mod=edita_cav&cav=mant_cav&id='+id, 'div_mant_cav');
}


function actualiza_cav(cav, id)
{
	var nombre = $('#respons').val();
	var estado = $('#c_estado').val();
	var id = $('#c_id').val();
	ajaxgetpage('controller.php?mod=actualiza_cav&nombre='+nombre+'&id='+id+'&estado='+estado);
	ajaxgetpage('controller.php?mod=refresca_cav&cav=mant_cav');
}


function agreReg_cav(cav)
{
	ajaxgetpage('controller.php?mod=nuevo_cav&cav='+cav, 'div_'+cav);
}

function agrega_cav(cav)
{
	var rut = $('#respons').val();
	var resp = ajaxgetResponse('controller.php?mod=agrega_cav&rut='+rut);
	if (resp == 1) {
		alert("Ingreso exitoso");
	}else{
		alert("Rut incorrecto y/o no existe");
	}
		ajaxgetpage('controller.php?mod=refresca_cav&cav=mant_cav');
	
}

function guardaReg_cav(i, cav){
	var id = $('#accion_'+i).val();
	if ($('#accion_'+i).is(':checked')){
		ajaxgetpage('controller.php?mod=cambio_cav&id='+id+'&activo=1');
	}else{
		ajaxgetpage('controller.php?mod=cambio_cav&id='+id+'&activo=0');
	}
	ajaxgetpage('controller.php?mod=refresca_cav&cav='+cav);
}
//

