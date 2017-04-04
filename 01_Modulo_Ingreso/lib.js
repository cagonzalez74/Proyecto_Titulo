function eliminaAreaFun(id_areafun){
	ajaxgetpage("controller.php?mod=85&id_areafun="+id_areafun,"div_grilla_area_fun");
}

function eliminaFotoUsuario(pathfoto,id_usuario){
	ajaxgetpage("controller.php?mod=83&pathfoto="+pathfoto+"&id_usuario="+id_usuario,"detalle_usuario");
}

function insertarUploadify2(id_usuario,nombre){
	 ajaxgetpage('controller.php?mod=84&id_usuario='+id_usuario+'&nombre='+nombre,'detalle_usuario');
}

function eliminaTipoPerfil(id_perfil){
	var r = confirm("Esta seguro de borrar esta seleccion");
	if(r == true){
		ajaxgetpage('controller.php?mod=82&id_perfil='+id_perfil,'grillaPerfil');
	}
}

function editaTipoPerfil(id_perfil){
	ventanita("Edita Tipo de Perfil","controller.php?mod=81&id_perfil="+id_perfil,300,500);
}

function guardaUpdateTipoPerfil(nombre,desc,web_ini,dura_con,id_perfil){
	
	cabecera = "De completar los siguientes campos:\n";
	error 	 = "";
	var url;
	if(nombre == ""){
		error += " - Nombre\n"
	}
	if(desc == ""){
		error += " - Descripcion\n"
	}
	if(error == ""){
		url='controller.php?mod=80&nombre='+nombre+'&desc='+desc+'&web_ini='+web_ini+'&dura_con='+dura_con+'&id_perfil='+id_perfil;
		//alert(url);
		resp=ajaxgetResponse(url);
		//alert(resp);
		$("#grillaPerfil").html(resp);
		
	}else{
		alert(cabecera+error);
	}
}

function cambiaPassword(pass,pass2){

	if(pass != pass2){
		alert('Las contrase�as deben ser iguales');
	}else{
		ajaxgetpage('controller.php?mod=79&pass='+pass,'detalle_usuario');
	}
}

function insertarUploadify(id_usuario,nombre){
	 ajaxgetpage('controller.php?mod=77&id_usuario='+id_usuario+'&nombre='+nombre,'form_inicio');
}
 
function editaTipoCargo(id_tipo_cargo){
	ventanita("Edita Tipo de Cargo","controller.php?mod=76&id_tipo_cargo="+id_tipo_cargo,200,400);
}

function eliminaTipoCargo(id_cargo){
	var r = confirm("Esta seguro de borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=75&id_cargo="+id_cargo,"div_man_tipo_cargo");
	}
}

function guardaUpdateTipoCargo(nombre,desc,id_cargo){
	if(nombre == ""){
		alert('Debe ingresar el nombre del nuevo tipo');
	}else{
		ajaxgetpage("controller.php?mod=74&nombre="+nombre+"&desc="+desc+"&id_cargo="+id_cargo,"div_man_tipo_cargo");
	}
}

function editaTipoAreaFun(id_tipo_areafun){
	ventanita("Edita Tipo area funcional","controller.php?mod=71&id_tipo_areafun="+id_tipo_areafun,200,400);
}

function eliminaTipoAreaFun(id_tipo_areafun){
	var r = confirm("Esta seguro de borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=70&id_tipo_areafun="+id_tipo_areafun,"div_man_tipo_areafun");
	}
}

function guardaUpdateTipoAreaFun(nombre,edit,id_areafun){
	if(nombre == ""){
		alert('Debe ingresar el nombre de la nueva area');
	}else{
		ajaxgetpage("controller.php?mod=69&nombre="+nombre+"&edit="+edit+"&id_areafun="+id_areafun,"div_man_tipo_areafun");
	}
}

function editaTipoDireccLab(id_direcc_lab){
	ventanita("Edita direcci�n laboral","controller.php?mod=64&id_direcc_lab="+id_direcc_lab,400,400);
}

function eliminaTipoDireccLab(id_direcc_lab){
	var r = confirm("Esta seguro de borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=66&id_direcc_lab="+id_direcc_lab,"div_grillaDirecLabUs");
	}
}
 
function creaUpdateTipoDirecLab(nombre,desc,id_direccion){

	if(nombre == ""){
		alert("Debe ingresar el nombre de la nueva direccion");
	}else{
		ajaxgetpage("controller.php?mod=65&nombre="+nombre+"&desc="+desc+"&id_direccion="+id_direccion,"div_grillaDirecLabUs");
	}
}

function eliminaDireccUs(id_direcc_us){
	var r = confirm("Esta seguro de borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=62&id_direcc_us="+id_direcc_us,"div_grillaTipoDireccionUs");
	}
}

function guardaNuevoTipoDireccUs(nombre){
	if(nombre == ""){
		alert("Debe ingresar el nombre del nuevo tipo");
	}else{
		ajaxgetpage("controller.php?mod=61&nombre="+nombre,"div_grillaTipoDireccionUs");
	}
}

function eliminaUsuarioRol(id_rol){
	var r = confirm("Esta seguro de borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=60&id_rol="+id_rol,"div_grillaTipoUsuarioRol");
	}
}

function guardaNuevoTipoRol(rol){
	if(rol == ""){
		alert("Debe ingresar el nombre del nuevo tipo");
	}else{
		ajaxgetpage("controller.php?mod=59&rol="+rol,"div_grillaTipoUsuarioRol");
	}
}

function actualizaTipos(nombre,id,tipo,div){
	if(nombre == ""){
		alert("Debe ingresar el nombre del nuevo tipo");
	}else{
		ajaxgetpage("controller.php?mod=58&nombre="+nombre+"&id="+id+"&tipo="+tipo,div);
	}
}

function editaTipo(id,tipo,div){
	ventanita("Edita tipo telefono","controller.php?mod=57&id="+id+"&tipo="+tipo+"&div="+div,100,400);
}

function eliminaUsuarioCorreo(id_correo){
	ajaxgetpage("controller.php?mod=56&id_correo="+id_correo,"div_grillaTipoUsuarioCorreo");
}

function guardaNuevoTipoCorreo(nombre){
	if(nombre == ""){
		alert("Debe ingresar el nombre del nuevo tipo");
	}else{
		ajaxgetpage("controller.php?mod=55&nombre="+nombre,"div_grillaTipoUsuarioCorreo");
	}
}

function eliminaUsuarioTel(id_tel){
	var r = confirm("Esta seguro de borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=54&id_tel="+id_tel,"div_grillaTipoUsuarioTel");
	}
}

function guardaNuevoTipoTel(nombre_tel){
	if(nombre_tel == ""){
		alert("Debe ingresar el nombre del nuevo tipo");
	}else{
		ajaxgetpage("controller.php?mod=53&nombre_tel="+nombre_tel,"div_grillaTipoUsuarioTel");
	}
}

function eliminaTipoUsuario(id_tipo){
	var r = confirm("Esta seguro de borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=52&id_tipo="+id_tipo,"div_grillaTipoUsuario");
	}
}

function guardaNuevoTipoUsuario(nuevoTipo){
	if(nuevoTipo == ""){
		alert("Debe ingresar el nombre del nuevo tipo");
	}else{
		ajaxgetpage("controller.php?mod=51&nuevoTipo="+nuevoTipo,"div_grillaTipoUsuario");
	}
}

function selecccionaTipoUs(tipo){
	ajaxgetpage("controller.php?mod=50&tipo="+tipo,"div_selcc_tipo_us");
}

function filtraVerUsuario(area,zona,empresa,perfil,rut,nombre,apellido){
	ajaxgetpage("controller.php?mod=48&area="+area+"&zona="+zona+"&empresa="+empresa+"&perfil="+perfil+"&rut="+rut+"&nombre="+nombre+"&apellido="+apellido,"div_grillaVerUser");
}

function guardaNuevoRespDirec(id_usuario,id_direccion,max){
	ajaxgetpage("controller.php?mod=46&id_usuario="+id_usuario+"&id_direccion="+id_direccion+"&max="+max,"div_resp_edit");
}

function agregaRespDirec(id_direccion,max){
	ajaxgetpage("controller.php?mod=45&id_direccion="+id_direccion+"&max="+max,"div_agregaRespDirecc");
}

function eliminaRespDirecc(id_direccion,id_usuario){
	ajaxgetpage("controller.php?mod=44&id_usuario="+id_usuario+"&id_direccion="+id_direccion,"div_resp_edit");
}

function editaDireccionLaboral(id_direc){
	  nombre 	= document.getElementById('nombre_direccion_edit').value;
	  tipo		= document.getElementById('tipo_direccion_edit').value;
	  zona		= document.getElementById('zona_direccion_edit').value;
	  comuna	= document.getElementById('comuna_direccion_edit').value;
	  telefono	= document.getElementById('telefono_direccion_edit').value;
	  emergen	= document.getElementById('emergencia_direccion_edit').value;
	  
	  ajaxgetpage("controller.php?mod=47&nombre="+nombre+"&tipo="+tipo+"&zona="+zona+"&comuna="+comuna+"&telefono="+telefono+"&emergen="+emergen+"&id_direc="+id_direc,"grilla_direccion_lab");
}

function editaDirecc(id_direccion,edita){
	ventanita("Edita Direccion","controller.php?mod=43&id_direccion="+id_direccion+"&edita="+edita,400,600);
}

function eliminaDirecc(id_direccion){	
	var r = confirm("Esta seguro de borrar esta direccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=42&id_direccion="+id_direccion,"grilla_direccion_lab");
	}
}

function agregaDireccionLaboral(form){
	formulario = form;
	cabecera = "De completar los siguientes campos:\n";
	error 	 = "";
	
	if(formulario.nombre_direccion.value == ""){
		error += "- Nombre\n";
	}
	if(formulario.tipo_direccion.value == ""){
		error += "- Tipo de direccion\n";
	}
	if(formulario.zona_direccion.value == ""){
		error += "- Zona\n";
	}
	if(formulario.comuna_direccion.value == ""){
		error += "- Comuna\n";
	}
	if(formulario.telefono_direccion.value == ""){
		error += "- Telefono\n";
	}
	if(formulario.emergencia_direccion.value == ""){
		error += "- Telefono de emergencia\n";
	}
	if(formulario.responsable_direccion0.value == ""){
		error += "- Responsable\n";
	}
	if(error == ""){
		formulario.action = 'controller.php?mod=41';
		formulario.submit();
	}else{
		alert(cabecera+error);
	}
}

function comboboxComuna(id_zona,ids){
	ajaxgetpage("controller.php?mod=40&id_zona="+id_zona+"&ids="+ids,"div_comuna_zona");
}

function editaEmpresa(rut_empresa,edita){
	ventanita("Edita cargo","controller.php?mod=36&rut_empresa="+rut_empresa+"&edita="+edita,300,500);
}

function eliminaEmpresa(rut_empresa){
	var r = confirm("Eas seguro que deseas borrar esta seleccion");
	
	if(r == true){
		ajaxgetpage("controller.php?mod=38&rut_empresa="+rut_empresa,"grilla_empresa");
	}
}

function agregaActualizaEmpresa(rut_empresa,razon_social,fono,direccion,responsable,tipo_empresa,edit,rut_empresa_where,correo,url){

	cabecera = "Debe ingresar los siguientes datos:\n"
	error 	 = "";
	
	if(rut_empresa == ""){
		error += "- Rut empresa\n"
	}
	if(razon_social == ""){
		error += "- Razon social\n"
	}
	if(direccion == ""){
		error += "- Direccion\n"
	}
	if(responsable == ""){
		error += "- Responsable\n"
	}
	if(tipo_empresa == ""){
		error += "- Tipo empresa\n"
	}
	if(error == ""){
		ajaxgetpage("controller.php?mod=37&rut_empresa="+rut_empresa+"&razon_social="+razon_social+"&fono="+fono+"&direccion="+direccion+"&responsable="+responsable+"&tipo_empresa="+tipo_empresa+"&edit="+edit+"&rut_empresa_where="+rut_empresa_where+"&correo="+correo+"&url="+url,"grilla_empresa");
	}else{
		alert(cabecera+error);
	}
}

function updateCargo(nombre,desc,tipo,id_cargo){
	ajaxgetpage("controller.php?mod=35&nombre="+nombre+"&desc="+desc+"&tipo="+tipo+"&id_cargo="+id_cargo,"grilla_cargo");
}

function editaCargo(id_cargo){
	ventanita("Edita cargo","controller.php?mod=34&id_cargo="+id_cargo,300,500);
}

function eliminaCargo(id_cargo){ 
	var r = confirm("Eas seguro que deseas borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=33&id_cargo="+id_cargo,"grilla_cargo");
	}
}

function agregaCargo(nombre,desc,tipo){
	cabecera = "Debe ingresar los siguientes datos:\n"
	error = "";

	if(nombre == ""){
		error += "- Nombre del nuevo cargo\n"
	}
	if(desc == ""){
		error += "- Descripcion del nuevo cargo\n"
	}
	if(tipo == ""){
		error += "- Tipo de cargo\n"
	}
	if(error == ""){
		ajaxgetpage("controller.php?mod=32&nombre="+nombre+"&desc="+desc+"&tipo="+tipo,"grilla_cargo");
	}else{
		alert(cabecera+error);
	}
	
}

function editaAreaFuncional(nom_area,desc_area,resp_area,area_padre,dire_area,id_area,tipo_area){ //Misma funcion..!! 
	ajaxgetpage("controller.php?mod=30&nom_area="+nom_area+"&desc_area="+desc_area+"&resp_area="+resp_area+"&area_padre="+area_padre+"&dire_area="+dire_area+"&id_area="+id_area+"&tipo_area="+tipo_area,"grilla_areafun");
}

function editaArea(id_area){
	ventanita("Edita Area","controller.php?mod=28&id_area="+id_area,400,400);
}

function agregaArea(nom_area,desc_area,resp_area,area_padre,dire_area,tipo_area){
	
	cabecera = "Debe ingresar los siguientes datos:\n"
	error = "";

		if(nom_area == ""){
			error += "- Nombre area\n";
		}
		if(area_padre == ""){
			error += "- Area padre\n";
		}
		if(dire_area == ""){
			error += "- Direccion\n";
		}
		if(tipo_area == ""){
			error += "- Tipo area\n";
		}
		
		if(error == ""){
				ajaxgetpage("controller.php?mod=29&nom_area="+nom_area+"&desc_area="+desc_area+"&resp_area="+resp_area+"&area_padre="+area_padre+"&dire_area="+dire_area+"&tipo_area="+tipo_area,"grilla_areafun");
		}else{
			alert(cabecera+error);
		}
}

function actualizaUsuario(id_usuario){
	
	rut_us 				= document.getElementById('rut_us').value;
	nombre_us 			= document.getElementById('nombre_us').value;
	apellido_us 		= document.getElementById('apellido_us').value;
	login_us 			= document.getElementById('login_us').value;
	fecha_nac 			= document.getElementById('fecha_nac').value;
	sexo_us 			= document.getElementById('sexo_us').value;
	codigo_tecnico_us 	= document.getElementById('codigo_tecnico_us').value;
	area_fun_us 		= document.getElementById('area_fun_us').value;
	cargo_us 			= document.getElementById('cargo_us').value;
	dire_lab_us 		= document.getElementById('dire_lab_us').value;
	interno_no_us 	  	= document.getElementById('interno_no_us').value;
	empresa_us 		  	= document.getElementById('empresa_us').value;
	fecha_ingreso_vtr 	= document.getElementById('fecha_ingreso_vtr').value;
	nivel_apro_us 	  	= document.getElementById('nivel_apro_us').value;
	perfil_us 			= document.getElementById('perfil_us').value;
	jefe_us 			= document.getElementById('jefe_us').value;
	estado_us 			= document.getElementById('estado_us').value;

	ajaxgetpage("controller.php?mod=26&rut_us="+rut_us+"&nombre_us="+nombre_us+"&apellido_us="+apellido_us+"&login_us="+login_us+"&fecha_nac="+fecha_nac+"&sexo_us="+sexo_us+"&codigo_tecnico_us="+codigo_tecnico_us+"&area_fun_us="+area_fun_us+"&cargo_us="+cargo_us+"&dire_lab_us="+dire_lab_us+"&interno_no_us="+interno_no_us+"&empresa_us="+empresa_us+"&fecha_ingreso_vtr="+fecha_ingreso_vtr+"&nivel_apro_us="+nivel_apro_us+"&perfil_us="+perfil_us+"&jefe_us="+jefe_us+"&estado_us="+estado_us+"&id_usuario="+id_usuario,"form_inicio")
}

function eliminaFoto(pathfoto,id_usuario){
	ajaxgetpage("controller.php?mod=25&pathfoto="+pathfoto+"&id_usuario="+id_usuario,"form_inicio");
}

function addNuevoFono(id_usuario,fono,tipo,id_creacion){
	ajaxgetpage("controller.php?mod=24&id_usuario="+id_usuario+"&fono="+fono+"&tipo="+tipo+"&id_creacion="+id_creacion,"div_muestra_fono");
}

function agregaFono(id_usuario){
	ajaxgetpage("controller.php?mod=23&id_usuario="+id_usuario,"div_agrega_Fono");
}

function addNuevoEmail(id_usuario,correo,tipo_correo,id_creacion){
	ajaxgetpage("controller.php?mod=22&id_usuario="+id_usuario+"&correo="+correo+"&tipo_correo="+tipo_correo+"&id_creacion="+id_creacion,"div_muestra_email");
}

function agregaEmail(id_usuario){
	ajaxgetpage("controller.php?mod=21&id_usuario="+id_usuario,"div_agrega_email");
}

function addNuevaDireccion(id_usuario,direccion,numero,dpto,tipo,localidad){
	ajaxgetpage("controller.php?mod=20&id_usuario="+id_usuario+"&direccion="+direccion+"&numero="+numero+"&dpto="+dpto+"&tipo="+tipo+"&localidad="+localidad,"muestraDirec");
}

function agregaDireccion(id_usuario){
	ajaxgetpage("controller.php?mod=19&id_usuario="+id_usuario,"div_agrega_direccion");
}

function grabarFono(id_fono,fono,tipo_fono,id_usuario){
	ajaxgetpage("controller.php?mod=18&id_fono="+id_fono+"&fono="+fono+"&tipo_fono="+tipo_fono+"&id_usuario="+id_usuario,"div_muestra_fono");
}

function editaFono(id_fono,id_usuario,editar_fono){
	ajaxgetpage("controller.php?mod=17&id_fono="+id_fono+"&id_usuario="+id_usuario+"&editar_fono="+editar_fono,"div_muestra_fono");
}

function grabarEmail(id_email,email,tipo_email,id_usuario){
	ajaxgetpage("controller.php?mod=16&id_email="+id_email+"&email="+email+"&tipo_email="+tipo_email+"&id_usuario="+id_usuario,"div_muestra_email");
}

function editaEmail(id_usuario,id_email,editar_email){
	ajaxgetpage("controller.php?mod=15&id_usuario="+id_usuario+"&id_email="+id_email+"&editar_email="+editar_email,"div_muestra_email");
}

function editaDireccion(id_usuario,id_direccion,editar_direccion){
	ajaxgetpage("controller.php?mod=13&id_direccion="+id_direccion+"&id_usuario="+id_usuario+"&editar_direccion="+editar_direccion,"muestraDirec");
}

function grabarDireccion(id_direccion,direccion,numero,dpto,tipo,local,id_usuario){
	ajaxgetpage("controller.php?mod=14&id_direccion="+id_direccion+"&direccion="+direccion+"&numero="+numero+"&dpto="+dpto+"&tipo="+tipo+"&local="+local+"&id_usuario="+id_usuario,"muestraDirec");
}

function eliminaEmail(id_email,id_usuario){
	var r = confirm("Eas seguro que deseas borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=11&id_email="+id_email+"&id_usuario="+id_usuario,"div_muestra_email");
	}
}

function eliminaFono(id_fono,id_usuario){
	var r = confirm("Eas seguro que deseas borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=12&id_fono="+id_fono+"&id_usuario="+id_usuario,"div_muestra_fono");
	}
}

function eliminaDireccion(id_direccion,id_usuario){
	var r = confirm("Eas seguro que deseas borrar esta seleccion");
	if(r == true){
		ajaxgetpage("controller.php?mod=10&id_direccion="+id_direccion+"&id_usuario="+id_usuario,"muestraDirec");
	}
}

function editaUsuario(id_usuario){
	ventanita("Edicion de usuario","controller.php?mod=9&id_usuario="+id_usuario,800,900);
}

function soloNum(evt){
	var key = nav4 ? evt.which : evt.keyCode;	
	return (key <= 13 || (key >= 48 && key <= 57));
}

function validaRut(rut,edicion){
	if(edicion != 1){
		ajaxgetpage("controller.php?mod=6&rut="+rut,"rut_val");
	}
}

function eliminaTr(obj){
	var oTr = obj;

	while(oTr.nodeName.toLowerCase()!='tr'){

		oTr=oTr.parentNode;

	}

	var root = oTr.parentNode;

	root.removeChild(oTr);
}

function insertaUsuario(form){
	formulario = form;
	
	rut		= $("#rut_us").val();
	nombre	= $("#nombre_us").val();
	apelli	= $("#apellido_us").val();
	login	= $("#login_us").val();
	sexo	= $("#sexo_us").val();
	direcc	= $("#direccion_pers0").val();
	nmro	= $("#nmro0").val();
	tipo_di	= $("#tipo_direc0").val();
	locali	= $("#local_pers0").val();
	email	= $("#email0").val();
	tipo_e	= $("#tipo_correo0").val();
	fono	= $("#fono0").val();
	tipo_f	= $("#tipo_fono0").val();
	//cod_tec	= $("#codigo_tecnico_us").val();
	area_fu	= $("#area_fun_us").val();
	area_or	= $("#area_org_us").val();
	perfil	= $("#perfil_us").val();
	cargo_u	= $("#cargo_us").val();
	direc_l	= $("#dire_lab_us").val();
	tip_us	= $("#interno_no_us").val();
	empresa	= $("#empresa_us").val();

	cabecera = "Debe ingresar los siguientes datos\n";
	error	 = "";

	if(rut == ""){error += "- Rut\n";}
	if(nombre == ""){error += "- Nombre\n";}
	if(apelli == ""){error += "- Apellido\n";}
	if(login == ""){error += "- Login\n";}
	if(sexo == ""){error += "- Sexo\n";}
	if(direcc == ""){error += "- Direccion\n";}
	if(nmro == ""){error += "- Numero de direccion\n";}
	if(tipo_di == ""){error += "- Tipo de direccion\n";}
	if(locali == ""){error += "- Localidad\n";}
	if(email == ""){error += "- Email\n";}
	if(tipo_e == ""){error += "- Tipo de email\n";}
	if(fono == ""){error += "- Fono\n";}
	if(tipo_f == ""){error += "- Tipo Fono\n";}
	//if(cod_tec == ""){error += "- Codigo tecnico\n";}
	if(area_fu == ""){error += "- Area funcional\n";}
	if(area_or == ""){error += "- Area organizacional\n";}
	if(perfil == ""){error += "- Peril\n";}
	if(cargo_u == ""){error += "- Cargo\n";}
	if(direc_l == ""){error += "- Direccion laboral\n";}
	if(tip_us == ""){error += "- Tipo usuario\n";}
	if(empresa == ""){error += "- Empresa\n";}

	if(error == ""){
	//ajaxpost(formulario,'form_inicio');
	formulario.action = 'controller.php?mod=4';
	formulario.submit();
	}else{
		alert(cabecera+error);
	}
}

function alerta(mensaje){
	$("#dialog").html(mensaje);
	$("#dialog").dialog('open');
	$("#dialog").dialog({bgiframe: true
                            ,resizable: true
                            ,width:250
                            ,height:100
                            ,modal: true,
                            overlay: {backgroundColor: '#000000',
                                        opacity: 1.8
                            }
                            ,buttons: {'Cerrar': function(){
                                                $(this).dialog('close');}
                            }
                           }
	);
} 

function validaLogin(login,edicion){
	if(edicion != 1){
		ajaxgetpage("controller.php?mod=3&login="+login,"acep_no");
	}
}

function verificaInterino(tipo_usuario){
	ajaxgetpage("controller.php?mod=5&tipo_usuario="+tipo_usuario,"empresa");
}

$(function() {
	$( "#tabinicio" ).accordion({ collapsible: true,autoHeight: false   });
	$( "#tabinicio_2" ).accordion({ collapsible: true,autoHeight: false   });
});