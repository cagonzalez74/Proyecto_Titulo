function insertarUploadify(id_usuario,nombre){
	ajaxgetpage('../../organizacion/autoedicion/controller.php?mod=1&id_usuario='+id_usuario+'&nombre='+nombre,'detalle_usuario');
}

function eliminaFotoUsuario(pathfoto,id_usuario){
	ajaxgetpage("../../organizacion/autoedicion/controller.php?mod=2&pathfoto="+pathfoto+"&id_usuario="+id_usuario,"detalle_usuario");
}

function cambiaPassword(pass,pass2){

	if(pass == "" || pass2 == ""){
		alert('Debe ingresar una nueva contrase\u00f1a para poder efectuar los cambios');
	}else{
		if(pass != pass2){
			alert('Las contrase\u00f1as deben ser iguales');
		}else{
			ajaxgetpage('../../organizacion/autoedicion/controller.php?mod=3&pass='+pass,'detalle_usuario');
		}
	}
}