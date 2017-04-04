<?php
session_start();
include_once('lib.php');

if(!isset($_GET['mod'])){$mod=1;}else{$mod=$_GET['mod'];}

$cFun = new clasFunciones();

switch ($mod){
	case 1:
		echo $cFun->tabsUsuario();
		break;
	case 2:
		echo $cFun->areaOrganizacional();
		break;
	case 3:
		$login = $_GET['login'];
		echo $cFun->verificaLogin($login); 
		break;
	case 4:
		/* +++++++++ DATOS PERSONALES USUARIO +++++++++ */
		$rut 		= $_POST['rut_us'];
		$nombre 	= $_POST['nombre_us'];
		$apellido 	= $_POST['apellido_us'];
 		$fe_in_vtr  = $_POST['fecha_ingreso_vtr']; //Fecha de ingreso a VTR
		$sexo 		= $_POST['sexo_us'];
		$empresa	= $_POST['empresa_us'];
		$cod_tec 	= $_POST['codigo_tecnico_us'];
		$nivl_apr	= $_POST['nivel_apro_us'];
		$perfil 	= $_POST['perfil_us']; 
		$jefe_us 	= $_POST['jefe_us'];
		$cargo 		= $_POST['cargo_us'];
		$area_fun 	= $_POST['area_fun_us'];
		$fecha_n	= $_POST['fecha_nac'];
		$path_f		= $_FILES['foto_us']['name'];
		$id_crea	= $_SESSION['user']['id'];
		$estado_us	= $_POST['estado_us'];
		$tipo_us	= $_POST['interno_no_us'];
		$fileTmp	= $_FILES['foto_us']['tmp_name'];
		$direccion	= $_POST['dire_lab_us'];
		//Inserto usuario
		echo $cFun->insertaUsuario($rut,$nombre,$apellido,$fe_in_vtr,$pass_us,$sexo,$empresa,$cod_tec,$nivl_apr,$perfil,$jefe_us,$cargo,$area_fun,$fecha_n,$path_f,$id_crea,$estado_us,$tipo_us,$fileTmp,$direccion);
		
		/* +++++++++ CAMPOS DINAMICOS +++++++++ */
		$mod_direc = $_POST['mod_direc'];
		$mod_email = $_POST['mod_email'];
		$mod_fono  = $_POST['mod_fono'];

		for($i=0;$i<=$mod_direc;$i++){ //For para direcci�n
			$direc 		= "direccion_pers".$i;
			$num_direc	= "nmro".$i;
			$depto		= "dpto".$i;
			$tipo_direc	= "tipo_direc".$i;
			$local_di	= "local_pers".$i;

			$cFun->insertaDireccion($_POST[$direc],$_POST[$num_direc],$_POST[$depto],$_POST[$tipo_direc],$_POST[$local_di],$i);
		}
		/* ++++++++++++++++++++++++++++++++++++ */ 
		
		for($k=0;$k<=$mod_email;$k++){ //For para email
			$email  = "email".$k;
			$tipo_c = "tipo_correo".$k;

			$cFun->insertaEmail($_POST[$email],$_POST[$tipo_c],$k);
		}
		
		for($m=0;$m<=$mod_fono;$m++){ //For para fono
			$fono  = "fono".$m;
			$tipo_f = "tipo_fono".$m;

			$cFun->insertaFono($_POST[$fono],$_POST[$tipo_f],$m);
		}
		
		/* +++++++++ INSERTO LOGIN +++++++++ */
		$login 	= $_POST['login_us'];
		$cFun->insertaLogin($login);
		
		echo "<script>location.href='index.php'</script>";
		break;
	case 5:
		$tipo_usuario = $_GET['tipo_usuario'];
		echo $cFun->AgregaComboboxExterno($tipo_usuario);
		break;
	case 6:
		 $rut = $_GET['rut'];
		 echo $cFun->validaRut($rut);
		break;
	case 7:
		echo $cFun->inicio();
		break;
	case 8:
		echo $cFun->filtroGrillaVerUsuario(); 
		break;
	case 9:
		$id_usuario = $_GET['id_usuario'];
		echo $cFun->inicio(1,$id_usuario);
		break;
	case 10:
		$id_direccion = $_GET['id_direccion'];
		$id_usuario	  = $_GET['id_usuario'];
		$cFun->eliminaDireccion($id_direccion,$id_usuario);
		break;
	case 11:
		$id_email	= $_GET['id_email'];
		$id_usuario	= $_GET['id_usuario'];
		$cFun->eliminaEmail($id_email,$id_usuario);
		break;
	case 12:
		$id_fono	= $_GET['id_fono'];
		$id_usuario	= $_GET['id_usuario'];
		$cFun->eliminaFono($id_fono,$id_usuario);
		break;
	case 13:
		$id_direccion		= $_GET['id_direccion'];
		$id_usuario			= $_GET['id_usuario'];
		$editar_direccion	= $_GET['editar_direccion'];
		
		$cFun->muestraDireccion($id_usuario,$id_direccion,$editar_direccion);
		break;
	case 14:
		$id_direccion	= $_GET['id_direccion'];
		$direccion		= $_GET['direccion'];
		$numero			= $_GET['numero'];
		$dpto			= $_GET['dpto'];
		$tipo			= $_GET['tipo'];
		$local			= $_GET['local'];
		$id_usuario		= $_GET['id_usuario'];
		
		$cFun->actualizarDireccion($id_direccion,$direccion,$numero,$dpto,$tipo,$local,$id_usuario);
		break;
	case 15:
		$id_usuario	  = $_GET['id_usuario'];
		$id_email	  = $_GET['id_email'];
		$editar_email = $_GET['editar_email'];
		
		$cFun->muestraEmail($id_usuario,$id_email,$editar_email);
		break;
	case 16:
		$id_email	= $_GET['id_email'];
		$email		= $_GET['email'];
		$tipo_email	= $_GET['tipo_email'];
		$id_usuario	= $_GET['id_usuario'];
		
		$cFun->actualizaEmail($id_email,$email,$tipo_email,$id_usuario);
		break;
	case 17:
		$id_fono	 = $_GET['id_fono'];
		$id_usuario	 = $_GET['id_usuario'];
		$editar_fono = $_GET['editar_fono'];
		$cFun->muestraFono($id_usuario,$id_fono,$editar_fono);
		break;
	case 18:
		$id_fono	= $_GET['id_fono'];
		$fono		= $_GET['fono'];
		$tipo_fono	= $_GET['tipo_fono'];
		$id_usuario = $_GET['id_usuario'];
		$cFun->actualizaFono($id_fono,$fono,$tipo_fono,$id_usuario);
		break;
	case 19:
		$id_usuario = $_GET['id_usuario'];
		$cFun->agregaDireccion($id_usuario);
		break;
	case 20:
		$id_usuario	= $_GET['id_usuario'];
		$direccion	= $_GET['direccion'];
		$numero		= $_GET['numero'];
		$dpto		= $_GET['dpto'];
		$tipo		= $_GET['tipo'];
		$localidad	= $_GET['localidad'];
		$cFun->insertaDirecionUnica($id_usuario,$direccion,$numero,$dpto,$tipo,$localidad);
		break;
	case 21:
		$id_usuario 	= $_GET['id_usuario'];
		$cFun->agregaEmail($id_usuario,$id_creacion);
		break;
	case 22:
		$id_usuario	 = $_GET['id_usuario'];
		$correo		 = $_GET['correo'];
		$tipo_correo = $_GET['tipo_correo'];
		$id_creacion = $_GET['id_creacion'];
		$cFun->insertaEmailUnico($id_usuario,$correo,$tipo_correo,$id_creacion);
		break;
	case 23:
		$id_usuario = $_GET['id_usuario'];
		$cFun->agregaFono($id_usuario);
		break;
	case 24:
		$id_usuario	 = $_GET['id_usuario'];
		$fono		 = $_GET['fono'];
		$tipo		 = $_GET['tipo'];
		$id_creacion = $_GET['id_creacion'];
		$cFun->insertaFonoUnico($id_usuario,$fono,$tipo,$id_creacion);
		break;
	case 25:
		$pathfoto	= $_GET['pathfoto'];
		$id_usuario	= $_GET['id_usuario'];
		$cFun->eliminaFoto($pathfoto,$id_usuario);
		break;
	case 26:
		$rut_us 			= $_GET['rut_us'];
		$nombre_us 			= $_GET['nombre_us'];
		$apellido_us 		= $_GET['apellido_us'];
		$login_us 			= $_GET['login_us'];
		$fecha_nac 			= $_GET['fecha_nac'];
		$sexo_us 			= $_GET['sexo_us'];
		$codigo_tecnico_us 	= $_GET['codigo_tecnico_us'];
		$area_fun_us 		= $_GET['area_fun_us'];
		$cargo_us 			= $_GET['cargo_us'];
		$dire_lab_us 		= $_GET['dire_lab_us'];
		$interno_no_us 	  	= $_GET['interno_no_us'];
		$empresa_us 		= $_GET['empresa_us'];
		$fecha_ingreso_vtr 	= $_GET['fecha_ingreso_vtr'];
		$nivel_apro_us 	= $_GET['nivel_apro_us'];
		$perfil_us 			= $_GET['perfil_us'];
		$jefe_us 			= $_GET['jefe_us'];
		$estado_us 			= $_GET['estado_us'];
		$id_usuario			= $_GET['id_usuario'];
		$cFun->actualizaUsuario($rut_us,$nombre_us,$apellido_us,$login_us,$fecha_nac,$sexo_us,$codigo_tecnico_us,$area_fun_us,$cargo_us,$dire_lab_us,$interno_no_us,$empresa_us,$fecha_ingreso_vtr,$nivel_apro_us,$perfil_us,$jefe_us,$estado_us,$id_usuario);
		break;
	case 27:
		$cFun->tabsAreaFun();
		break;
	case 28:
		$id_area = $_GET['id_area'];
		$cFun->editaAreaFuncional($id_area);
		break;
	case 29:
		$nom_area	  = $_GET['nom_area'];
		$desc_area	  = $_GET['desc_area'];
		$resp_area	  = $_GET['resp_area'];
		$area_padre	  = $_GET['area_padre'];
		$dire_area	  = $_GET['dire_area'];
		$tipo_area	  = $_GET['tipo_area'];
		
		$cFun->insertaArea($nom_area,$desc_area,$resp_area,$area_padre,$dire_area,$tipo_area);
		break;
	case 30:
		$nom_area	  = $_GET['nom_area'];
		$desc_area	  = $_GET['desc_area'];
		$resp_area	  = $_GET['resp_area'];
		$area_padre	  = $_GET['area_padre'];
		$dire_area	  = $_GET['dire_area'];
		$id_area	  = $_GET['id_area'];
		$tipo_area	  = $_GET['tipo_area'];
		$cFun->actualizaAreaFun($nom_area,$desc_area,$resp_area,$area_padre,$dire_area,$id_area,$tipo_area);
		break;
	case 31:
		$cFun->tabsCargo();
		break;
	case 32:
		$nombre	= $_GET['nombre'];
		$desc	= $_GET['desc'];	
		$tipo	= $_GET['tipo'];
		$cFun->insertaCargo($nombre,$desc,$tipo);
		break;
	case 33:
		$id_cargo	= $_GET['id_cargo'];
		$cFun->eliminaCargo($id_cargo);
		break;
	case 34:
		$id_cargo = $_GET['id_cargo'];
		$cFun->editaCargo($id_cargo);
		break;
	case 35:
		$nombre	  = $_GET['nombre'];
		$desc	  = $_GET['desc'];	
		$tipo	  = $_GET['tipo'];
		$id_cargo = $_GET['id_cargo'];
		$cFun->actualizaCargo($nombre,$desc,$tipo,$id_cargo);
		break;
	case 36:
		$rut_empresa = $_GET['rut_empresa'];
		$edita		= $_GET['edita'];
		
		$cFun->formEmpresa($edita,$rut_empresa);
		break;
	case 37:
		$rut_empresa	   = $_GET['rut_empresa'];
		$razon_social	   = $_GET['razon_social'];
		$fono			   = $_GET['fono'];
		$direccion		   = $_GET['direccion'];
		$responsable	   = $_GET['responsable'];
		$tipo_empresa	   = $_GET['tipo_empresa'];
		$edit			   = $_GET['edit'];
		$rut_empresa_where = $_GET['rut_empresa_where'];
		$correo			   = $_GET['correo'];
		$url			   = $_GET['url'];
		
		if($edit == 1){
			$cFun->actualizaEmpresa($rut_empresa,$razon_social,$fono,$direccion,$responsable,$tipo_empresa,$rut_empresa_where,$correo,$url);
		}else{
			$cFun->insertaEmpresa($rut_empresa,$razon_social,$fono,$direccion,$responsable,$tipo_empresa,$correo,$url);
		}
		break;
	case 38:
		$rut_empresa = $_GET['rut_empresa'];
		$cFun->eliminaEmpresa($rut_empresa);
		break;
	case 39:
		$cFun->tabsDireccLab();
		break;
	case 40:
		$id_zona = $_GET['id_zona'];
		$ids	 = $_GET['ids'];
		$cFun->comboboxComuna($id_zona,$ids); 
		break;
	case 41:
		$nombre		 = $_POST['nombre_direccion'];	
		$tipo		 = $_POST['tipo_direccion'];
		$zona		 = $_POST['zona_direccion'];
		$localidad	 = $_POST['comuna_direccion'];
		$telefono	 = $_POST['telefono_direccion'];
		$emergencia	 = $_POST['emergencia_direccion'];
		$mod_res	 = $_POST['mod_direcc_lab'];
		
		for($i=0;$i<=$mod_res;$i++){
			$respon = "responsable_direccion".$i;
			$arrRespon[] = $_POST[$respon];
		}
		$cFun->insertaDireccionLaboral($nombre,$tipo,$zona,$localidad,$telefono,$emergencia,$arrRespon);
		break;
	case 42:
		$id_direccion = $_GET['id_direccion'];
		$cFun->eliminaDireccionLaboral($id_direccion);
		break;
	case 43:
		$id_direccion = $_GET['id_direccion'];
		$edita		  = $_GET['edita'];
		$cFun->formDireccion($edita,$id_direccion);
		break;
	case 44:
		$id_usuario	  = $_GET['id_usuario'];
		$id_direccion = $_GET['id_direccion'];
		$cFun->eliminaRespDireccion($id_usuario,$id_direccion);
		break;
	case 45:
		$id_direccion = $_GET['id_direccion'];
		$max		  = $_GET['max'];
		$cFun->agrgaRespDireccion($id_direccion,$max);
		break;
	case 46:
		$id_usuario		= $_GET['id_usuario'];
		$id_direccion	= $_GET['id_direccion'];
		$id_creacion	= $_GET['max'];
		$cFun->insertaNuevoRespDirec($id_usuario,$id_direccion,$id_creacion);
		break;
	case 47:
		$nombre	  = $_GET['nombre'];
		$tipo	  = $_GET['tipo'];
	  	$zona	  = $_GET['zona'];
	  	$comuna	  = $_GET['comuna'];
	  	$telefono = $_GET['telefono'];	
	  	$emergen  = $_GET['emergen'];
	  	$id_direc = $_GET['id_direc'];
	  	$cFun->actualizaRespDireccion($nombre,$tipo,$zona,$comuna,$telefono,$emergen,$id_direc);
		break;
	case 48:
		$area	  = $_GET['area'];
		$zona	  = $_GET['zona'];
		$empresa  = $_GET['empresa'];
		$perfil	  = $_GET['perfil'];
		$rut	  = $_GET['rut'];
		$nombre	  = $_GET['nombre'];
		$apellido = $_GET['apellido'];
		$cFun->verUsuario($area,$zona,$empresa,$perfil,$rut,$nombre,$apellido);
		break;
	case 49:
		$cFun->selctTiposUs();
		break;
	case 50:
		$tipo = $_GET['tipo'];
		if($tipo == 1){$cFun->tipoUsuario($tipo);}		//Mantenedor Tipo usuario
		if($tipo == 2){$cFun->tipoTelefonoUsuario();}	//Mantenedor Tipo Telefono
		if($tipo == 3){	$cFun->tipoCorreo();}			//Mantenedor Tipo Correo
		if($tipo == 4){$cFun->tipoRol();}				//Mantenedor Tipo Rol
		if($tipo == 5){$cFun->tipoDireUsuario();}		//Mantenedor Tipo Direccion usuario
		if($tipo == 6){$cFun->tipoPerfil();}			//Mantenedor Tipo Perfil
		break;
	case 51:
		$nuevoTipo = $_GET['nuevoTipo'];
		$cFun->insertaTipoUsuario($nuevoTipo);
		break;
	case 52:
		$id_tipo = $_GET['id_tipo'];
		$cFun->eliminaTipoUsuario($id_tipo);
		break;
	case 53:
		$tipo_tel = $_GET['nombre_tel'];
		$cFun->insertaTipoTel($tipo_tel);
		break;
	case 54:
		$id_tel = $_GET['id_tel'];
		$cFun->eliminaTipoTel($id_tel);
		break;
	case 55:
		$nombre = $_GET['nombre'];
		$cFun->insertaTipoCorreo($nombre);
		break;
	case 56:
		$id_correo = $_GET['id_correo'];
		$cFun->eliminaTipoCorreo($id_correo);
		break;
	case 57:
		$id   = $_GET['id'];
		$tipo = $_GET['tipo'];
		$div  = $_GET['div'];
		$cFun->actualizaTipoUsTelCorr($id,$tipo,$div);
		break;
	case 58:
		$nombre = $_GET['nombre'];
		$id		= $_GET['id'];
		$tipo	= $_GET['tipo'];
		$cFun->actualizoTipos($nombre,$id,$tipo);
		break;
	case 59:
		$rol = $_GET['rol'];
		$cFun->insertaTipoRol($rol);
		break;
	case 60:
		$id_rol = $_GET['id_rol'];
		$cFun->eliminaTipoRol($id_rol);
		break;
	case 61:
		$nombre = $_GET['nombre'];
		$cFun->insertaTipoDireccUs($nombre);
		break;
	case 62:
		$id_direcc_us = $_GET['id_direcc_us'];
		$cFun->eliminaTipoDireccUs($id_direcc_us);
		break;
	case 63:
		$cFun->formDireccion();
		break;
	case 64:
		$id_direcc_lab = $_GET['id_direcc_lab'];
		$cFun->tipoDireccLaboral($id_direcc_lab);
		break;
	case 65:
		$nombre 	  = $_GET['nombre'];
		$desc		  = $_GET['desc'];
		$id_direccion = $_GET['id_direccion'];

		if($id_direccion == ""){
			$cFun->insertaTipoDireccLab($nombre,$desc);
		}else{
			$cFun->actualizaTipoDireccLab($nombre,$desc,$id_direccion);
		}
		break;
	case 66:
		$id_direcc_lab = $_GET['id_direcc_lab'];
		$cFun->eliminaTipoDireccLab($id_direcc_lab);
		break;
	case 67:
		$cFun->areaFuncional();
		break;
	case 68:
		$cFun->tipoAreaFun();
		break;
	case 69:
		$nombre 	= $_GET['nombre'];
		$edita  	= $_GET['edit'];
		$id_areafun	= $_GET['id_areafun'];

		if($edita == 0){
			$cFun->insertaTipoAreaFun($nombre);
		}else{
			$cFun->actualizaTipoAreaFun($nombre,$id_areafun);
		}
		break;
	case 70:
		$id_tipo_areafun = $_GET['id_tipo_areafun'];
		$cFun->eliminaTipoAreaFun($id_tipo_areafun);
		break;
	case 71:
		$id_tipo_areafun = $_GET['id_tipo_areafun'];
		$cFun->tipoAreaFun($id_tipo_areafun);
		break;
	case 72:
		$cFun->agregaCargo();
		break;
	case 73:
		$cFun->tipoCargo();
		break;
	case 74:
		$nombre 	= $_GET['nombre'];
		$desc		= $_GET['desc'];
		$id_cargo 	= $_GET['id_cargo'];
		
		if($id_cargo == ""){
			$cFun->insertaTipoCargo($nombre,$desc);
		}else{
			$cFun->actualizaTipoCargo($nombre,$desc,$id_cargo);
		}
		break;
	case 75:
		$id_cargo = $_GET['id_cargo'];
		$cFun->eliminaTipoCargo($id_cargo);
		break;
	case 76:
		$id_tipo_cargo = $_GET['id_tipo_cargo'];
		$cFun->tipoCargo($id_tipo_cargo);
		break;
	case 77:
		$id_usuario	= $_GET['id_usuario'];
		$nombre		= $_GET['nombre'];
		$cFun->actualizaFoto($id_usuario,$nombre);
		break;
	case 78:
		$id_usuario = $_SESSION['user']['id'];
		if(isset($_SESSION['user']['id'])){
			$cFun->usuarioView($id_usuario);
		}else{
			echo "<script>location.href='http://nnoc.vtr.cl'</script>";
		}
		break;
	case 79:
		$pass		= $_GET['pass'];
		$id_usuario	= $_SESSION['user']['id'];
		$cFun->actualizaPassword($pass,$id_usuario);
		break;
	case 80:
		$nombre		= $_GET['nombre'];
		$desc		= $_GET['desc'];
		$web_ini	= $_GET['web_ini'];
		$dura_con	= $_GET['dura_con'];
		$id_perfil	= $_GET['id_perfil'];
		//print_($_GET);
		if($id_perfil == ""){
			$cFun->insertaPerfil($nombre,$desc,$web_ini,$dura_con);
		}else{
			$cFun->actualizaPerfil($nombre,$desc,$web_ini,$dura_con,$id_perfil);
		}
		
		break;
	case 81:
		$id_perfil = $_GET['id_perfil'];
		$cFun->tipoPerfil($id_perfil);
		break;
	case 82:
		$id_perfil = $_GET['id_perfil'];
		$cFun->eliminaPerfil($id_perfil);
		break;
	case 83:
		$pathfoto	= $_GET['pathfoto'];
		$id_usuario	= $_GET['id_usuario'];
		$cFun->eliminaFotoUsuario($pathfoto,$id_usuario);
		break;
	case 84:
		$id_usuario	= $_GET['id_usuario'];
		$nombre		= $_GET['nombre'];
		$cFun->actualizaFotoUsuario($id_usuario,$nombre);
		break;
	case 85:
		$id_areafun = $_GET['id_areafun'];
		$cFun->eliminaAreaFun($id_areafun);
		break;
	case 86:
		$cFun->resumenOrganizacion();
		break;
	default:
		echo "<h3><b>SIN REFERENCIA</b></h3>";
		break;
}