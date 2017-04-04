<?php
session_start();
$id_usuario_temp = $_SESSION[user][id];
include_once('lib.php');
$lib = new clasFunciones();
$mod = (!isset($_GET[mod])) ? "pest_ingreso" : $_GET[mod]; ;
switch ($mod)
{

	case "correo":
		echo $lib->adjuntarArchivoDocTipo();
	break;	

	case "pdf":
		echo $lib->adjuntarArchivoPDF();
	break;		

	case "pdf_cav":
		echo $lib->adjuntarArchivoPDF_CAV();
	break;	

	case "pdf2":
			$id_inf=$_GET[id_inf];
			$usuario=$_GET[usuario];
			$doc=$_GET[doc];
			guardaArchivoDoc($conn,$id_inf, $_FILES[adjunto_doc], $usuario,$doc);
	break;

	case "guarda_escalamiento":
		echo $lib->guardar_escalamiento();
	break;	

	case "guarda_escalamientoNuevo":
		echo $lib->guardar_escalamientoNuevo();
	break;

	case "guarda_escalamientoOrden":
		echo $lib->guardar_escalamientoOrden();
	break;

	case "pest_ingreso":
		echo "<script type='text/javascript'>clearInterval(IntervalosOrd);</script>";
		echo "<script type='text/javascript'>clearInterval(IntervalosOrdR);</script>";
		echo $lib->form_ingreso();
	break;

	case "detallarOrden":
		echo $lib->DetallarOrden($_GET['valor']);
	break;

	case "buscarOrden":
		echo $lib->BuscarOrden($_GET['valor']);
	break;

	case "AsignaEscalamiento":
		echo $lib->AsignaEscalamiento($_GET['valor']);
	break;
	
	case "vbOrden":
		echo $lib->vbOrden($_GET['norden']);
	break;		
	
	case "guardarOrden":
		echo $lib->GuardarOrden($_GET['norden'] , $_GET['rut'], $_GET['nombre'], $_GET['direccion'], $_GET['localidad'], $_GET['nodo'], $_GET['fingreso'], $_GET['fcrea'], $_GET['fcompro'], $_GET['area'], $_GET['obserori'], $_GET['codarea'],$_GET['motivo'], $_GET['obs'], $_GET['activ'], $_GET['codhorario']);
	break;
			
	case "pest_ver":
		echo "<script type='text/javascript'>clearInterval(IntervalosOrd);</script>";
		echo "<script type='text/javascript'>clearInterval(IntervalosOrdR);</script>";
		//echo "<script type='text/javascript'>intervaloTiempo();</script>";
		echo $lib->VerOrdenes($_GET['escala'], $_GET['terr'], $_GET['reg'], $_GET['loc']);
	break;

	case "asignarOrden":
		echo $lib->AsignarOrden($_GET['valor']);
	break;	

	case "cerrarEscalamiento":
		echo $lib->cerrarEscalamiento($_GET['valor'], $_GET['comen'], $_GET['pdf_cav']);
	break;	

	case "finalizarSinContacto":
		echo $lib->finalizarSinContacto($_GET['valor'], $_GET['comen'], $_GET['pdf_cav']);
	break;

	case "comentarOrden":
		echo $lib->form_ComentaOrden($_GET['valor']);
	break;

	case "comentarOrdenPrecer":
		echo $lib->form_ComentaOrdenPrecer($_GET['valor']);
	break;

	case "finalizarOrden":
		echo $lib->FinalizarOrden($_GET['valor'], $_GET['comen'], $_GET['postMortem'], $_GET['pdf_ejec']);
	break;

	case "anularOrden":
		echo $lib->AnularOrden($_GET['valor']);
	break;

	case "anularOrdenEsca":
		echo $lib->anularOrdenEsca($_GET['valor']);
	break;
		
	case "comentaOrden":
		echo $lib->ComentarOrden($_GET['valor'], $_GET['comen']);
	break;

	case "refComentario":
		echo $lib->divComentarios($_GET['norden']);
	break;

	case "traeRegion":
		echo $lib->getCbxRegion($_GET['terr']);
	break;

	case "traeComuna":
		echo $lib->getCbxComuna($_GET['terr'], $_GET['reg']);
	break;

	/*case substr($mod, 0, 4) == 'mant':
		echo "<script type='text/javascript'>clearInterval(IntervalosOrd);</script>";
		echo "<script type='text/javascript'>clearInterval(IntervalosOrdR);</script>";
		echo $lib->mant_base($mod);
	break;*/

	case "guardaUsuarioCAV":
		echo $lib->guardaUsuarioCAV($_GET['idu'], $_GET['nombre']);
	break;

	case "Form_tiempo":
		echo $lib->form_tiempo($_GET['id']);
	break;

	case "guardaTiempo":
		echo $lib->GuardaTiempo($_GET['pend'], $_GET['ejec'], $_GET['area']);
	break;

	case "listaRegistros":
		echo $lib->get_listaRegistros($_GET['serv']);
	break;

	case "getRecuerda":
		echo $lib->getRecuerda($_GET['id']);
	break;

	case "verOrdenF":
		echo $lib->form_OrdenFinalizada($_GET['valor']);
	break;
	
	case "verOrdenMortem":
		echo $lib->form_OrdenFinalizadaMortem($_GET['valor']);
	break;

	case "enviaCorreo":
		$lib->enviaCorreo($_GET['norden']);
	break;

	case "enviaCorreoNuevo":
		$lib->enviaCorreoNuevo($_GET['id_esca']);
	break;

	case "enviaCorreoAsig":
		$lib->enviaCorreoAsig($_GET['id_esca']);
	break;	

	case "enviaCorreoPend":
		$lib->enviaCorreoPend($_GET['RUTP'],$_GET['DIRE'],$_GET['TI_ESC'],$_GET['MOTI_ESC']);	    
	break;

	case "enviaCorreoEjec":
		$lib->enviaCorreoEjec($_GET['id_esca']);	    
	break;	

	case "enviaCorreoFinal":
		$lib->enviaCorreoFinal($_GET['id_esca']);	    
	break;

	case "pest_report":
		echo "<script type='text/javascript'>clearInterval(IntervalosOrd);</script>";
		echo "<script type='text/javascript'>clearInterval(IntervalosOrdR);</script>";
		echo "<script type='text/javascript'>intervaloTiempoR();</script>";
		echo $lib->form_reporte($_GET['terr'], $_GET['reg'], $_GET['loc'], $_GET['escala'], $_GET['empresa'], $_GET['fdesde'], $_GET['fhasta'], $_GET['actividad']);
	break;

	case "detalleReportesBasic":
		echo $lib->formDetalleReporteBasic($_GET['estado'], $_GET['div'], $_GET['terr'], $_GET['reg'], $_GET['loc'], $_GET['escala'], $_GET['empresa'], $_GET['fdesde'], $_GET['fhasta'], $_GET['actividad']);
	break;

	case "detalleReportesAvanz":
		echo $lib->formDetalleReporteAvanz($_GET['alerta'], $_GET['empresa'], $_GET['div'], $_GET['terr'], $_GET['reg'], $_GET['loc'], $_GET['escala'], $_GET['eps'], $_GET['fdesde'], $_GET['fhasta'], $_GET['actividad']);
	break;
						
	case "DetalleAvanzDiv":
		echo $lib->getDetalleAvanzDiv($_GET['alerta'], $_GET['usuario'], $_GET['empresa'], $_GET['divanterior'], $_GET['terr'], $_GET['reg'], $_GET['loc'], $_GET['escala'], $_GET['eps'], $_GET['fdesde'], $_GET['fhasta'], $_GET['actividad']);
	break;
	
	case "pest_fin":
		echo "<script type='text/javascript'>clearInterval(IntervalosOrd);</script>";
		echo "<script type='text/javascript'>clearInterval(IntervalosOrdR);</script>";
		echo $lib->VerOrdenesFinaliza($_GET['escala'], $_GET['terr'], $_GET['reg'], $_GET['loc'], $_GET['empresa'], $_GET['fdesde'], $_GET['fhasta']);
	break;	

	case "pest_gestion":
		echo "<script type='text/javascript'>clearInterval(IntervalosOrd);</script>";
		echo "<script type='text/javascript'>clearInterval(IntervalosOrdR);</script>";
		echo $lib->form_gestion();
	break;	

	case "buscarEscalamiento":
		echo $lib->BuscarEscalamiento($_GET['valor']);
	break;

	case "estadoCerrarEscalamiento":
		echo $lib->estadoCerrarEscalamiento($_GET['valor'], $_GET['id']);
	break;
	
	case "reescalamiento":
		echo $lib->reescalamiento($_GET['valor'], $_GET['comen'], $_GET['pdf_cav']);
	break;
	
	case "reescalamientoEdita":
		echo $lib->reescalamientoEdita($_GET['valor'], $_GET['comen'], $_GET['postMortem']);
	break;
	case "buscarDatosCliente":
		$iden = $_GET['iden'];
		$rut = $_GET['rut'];
		//echo "<div id='cprueba'>";
		echo $lib->buscarDatosCliente($iden, $rut);
		//echo "</div>";	
	break;
						
	//
		case 'mant_cav': 
			//$cav='mant_cav';
			echo $lib->tabla_mant('mant_cav');
		break;
		
		case 'edita_cav': 
			echo $lib->edita_cav($_GET[cav], $_GET[id]);
		break;
		
		case 'actualiza_cav':
			$lib->actualiza_cav($_GET[nombre], $_GET[id], $_GET[estado]);
		break;
		
		case 'refresca_cav':
			echo $lib->tabla_mant($_GET[cav]);
		break;
		
		case 'elimina_cav':
			$lib->elimina_cav($_GET[cav], $_GET[id]);
			echo $lib->lista_cav($_GET[cav]);
		break;
		
		case 'cancela_cav':
			echo '';
		break;
		
		case 'nuevo_cav':
			echo $lib->nuevo_cav($_GET[cav]);
		break;
		
		case 'agrega_cav':
			$lib->agrega_cav($_GET[rut]);
		break;
		

		
		case substr($mod, 0, 4) == 'mant':
			echo $lib->tabla_mant($mod);
		break;

		case 'isset':
			echo 'mod vacio';
		break;
		
		default:
			echo 'default';
	//
	default:
		echo "case no encontrado";
	break;
}