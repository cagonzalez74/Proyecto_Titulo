<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_class/Meta.class.php');
session_start();
$id_usuario_temp = $_SESSION[user][id];
//header('Content-type: application/json');
//CAMBIAR    
//$upload_folder =$_SERVER['DOCUMENT_ROOT'].'/cencina/escalamiento/escalamiento_critico/documentos/';
$upload_folder =$_SERVER['DOCUMENT_ROOT'].'/gvaldivia/escalamiento_critico/documentos/';
//print_r( $_FILES );
$nombre_archivo = $_FILES['file']['name'];
$tipo_archivo = $_FILES['file']['type'];
$file_ext = explode('.', $nombre_archivo);
$file_ext = strtolower(end($file_ext));
$allowed = array('pdf');

//GLOBAL $id_usuario_temp;
$nombre_archivo = 'PDF_'.date('Ymd_His').'_'.$id_usuario_temp;
$tamano_archivo = $_FILES['file']['size'];
$tmp_archivo = $_FILES['file']['tmp_name'];
$file_error	= $_FILES['file']['error'];
$archivador = $upload_folder . '/' . $nombre_archivo;

		if(in_array($file_ext, $allowed)){
			if($file_error === 0){
				if($tamano_archivo <= 20971520){
					$file_name_new = $nombre_archivo. '.' . $file_ext;
					//echo $file_name_new;
					//CAMBIAR
					//$file_destination = $_SERVER['DOCUMENT_ROOT'].'/cencina/escalamiento/escalamiento_critico/documentos/' . $file_name_new;
					$file_destination = $upload_folder. $file_name_new;
					//var_dump($file_ext);
					//die();
					if (!move_uploaded_file($tmp_archivo, $file_destination)) {
						$response_array['status'] = 'error';
						$response_array['msg'] = 'Intentelo nuevamente por favor.';
					}else {
						$response_array['status'] = 'success'; 
						$response_array['archivo'] = $file_name_new; 
					}
				}else {
					$response_array['status'] = 'size';
					$response_array['msg'] = 'Archivo demasiado pesado';
				}
			}else{
				$response_array['status'] = 'error2';
				$response_array['msg'] = 'Intentelo nuevamente.';
			}
		}else{
			$response_array['status'] = 'tipo';
			$response_array['msg'] = 'Tipo de archivo no valido.';
		}
	//echo $response_array;

?>
<body onLoad="JavaScript:Cerraraliniciar()">
<script language="JavaScript">
function Cerraraliniciar(){
var id;
id = setTimeout("cerrar()", 3);
}
function cerrar() {
<? if ($response_array['status'] == 'success') { ?>
	window.opener.document.getElementById("archivoPDFtext").value = "<?echo $file_name_new?>";
	window.opener.document.getElementById("descarga_pdf").innerHTML = "<a href='http://nnoc.vtr.cl/gvaldivia/escalamiento_critico/documentos/<?echo $file_name_new?>' target='_blank'>Descargar</a>";
	var ventana = window.self;
	ventana.opener = window.self;
	alert("Archivo subido exitosamente");
	ventana.close();
<?}else{?>
	var ventana = window.self;
	ventana.opener = window.self;
	alert("Error al adjuntar el archivo PDF. Intentelo nuevamente por favor.");
	ventana.close();
<?} ?>
	

}
</script>




<?php


/*session_start();
$id_usuario_temp = $_SESSION[user][id];

header('Content-type: application/json');


//CAMBIAR    
//$upload_folder =$_SERVER['DOCUMENT_ROOT'].'/cencina/escalamiento/escalamiento_critico/documentos/';
$upload_folder ='./documentos/';
$nombre_archivo = $_FILES['archivo']['name'];
$tipo_archivo = $_FILES['archivo']['type'];
$file_ext = explode('.', $nombre_archivo);
$file_ext = strtolower(end($file_ext));

GLOBAL $id_usuario_temp;
$nombre_archivo = 'PDF_'.date('Ymd_His').'_'.$id_usuario_temp;
$tamano_archivo = $_FILES['archivo']['size'];
$tmp_archivo = $_FILES['archivo']['tmp_name'];
$file_error	= $_FILES['archivo']['error'];
$allowed = array('pdf');
$archivador = $upload_folder . '/' . $nombre_archivo;

	if(in_array($file_ext, $allowed)){
			if($file_error === 0){
				if($tamano_archivo <= 20971520){
					$file_name_new = $nombre_archivo. '.' . $file_ext;
					//CAMBIAR
					//$file_destination = $_SERVER['DOCUMENT_ROOT'].'/cencina/escalamiento/escalamiento_critico/documentos/' . $file_name_new;
					$file_destination = $upload_folder. $file_name_new;
					if (!move_uploaded_file($tmp_archivo, $file_destination)) {
						$response_array['status'] = 'error';
						$response_array['msg'] = 'Intentelo nuevamente por favor.';
					}else {
						$response_array['status'] = 'success'; 
						$response_array['archivo'] = $file_name_new;  
					}
				}else {
					$response_array['status'] = 'error';
					$response_array['msg'] = 'Archivo demasiado pesado';
				}
			}else{
				$response_array['status'] = 'error';
				$response_array['msg'] = 'Intentelo nuevamente.';
			}
		}else{
			$response_array['status'] = 'error';
			$response_array['msg'] = 'Tipo de archivo no valido.';
		}
	echo json_encode($response_array);*/
?>