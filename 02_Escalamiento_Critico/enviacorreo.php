<?	
    //$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.17.97.37)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=reponnoc)))";
	//$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = alicanto-scan.vtr.cl)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=orannoc.vtr.cl)))";
    //$conn = oci_pconnect("nnoc","noc.,vtr",$db,"WE8ISO8859P1") or die ('No me pude conectar a la base de datos<br>');

    $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.17.37.9)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=DESANNOC)))";
    $conn = oci_pconnect("nnoc","noc.,vtr",$db,"WE8ISO8859P1") or die ('No me pude conectar a la base de datos<br>');
  
	
 //*****************CORREO*************************************************/
//var_dump('si entra al mail');//die();
$sql_mail="begin NNOC.ENVIARCORREO_LONG1(:Par_Remitente,:Par_Destinatarios,:Par_Asunto,:Par_Mensaje); end;"; 

$parse_mail=ociparse($conn,$sql_mail);
              oci_bind_by_name($parse_mail,":Par_Remitente",$_GET['remitente']);
              oci_bind_by_name($parse_mail,":Par_Destinatarios",$_GET['destino']);
              oci_bind_by_name($parse_mail,":Par_Asunto",$_GET['asunto']);
              oci_bind_by_name($parse_mail,":Par_Mensaje",$_GET['cuerpo']);
              //oci_bind_by_name($parse_mail,":Par_Server",$servidor); 
              $rs_mail=oci_execute($parse_mail, OCI_DEFAULT) or die ('No se pudo ejecutar la sentencia');        
 ?>