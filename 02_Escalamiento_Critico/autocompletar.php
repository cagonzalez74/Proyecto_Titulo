<?
error_reporting(0);
$limit=$_REQUEST['limit'];
$term1=$_REQUEST['q'];
$term1=str_ireplace("ñ","�",$term1);
$term = strtolower($term1);
$terms=explode(" ",$term);
$terms1=explode(" ",$term1);
include $_SERVER['DOCUMENT_ROOT']."/_database/conexion.php";
$sql="select id_usuario,nombres||' '||apellidos nombre from organizacion.new_org_usuario_c
where (lower(nombres) like '%".$terms[0]."%' or lower(apellidos) like '%".$terms[0]."%' )";
for ($i=1;$i<count($terms);$i++) {
	$sql.=" and (lower(nombres) like '%".$terms[$i]."%' or lower(apellidos) like '%".$terms[$i]."%' )";
} 
$sql.=" order by nombres ";
$parse=oci_parse($conn, $sql);
$resultado=array();

if (oci_execute($parse, OCI_DEFAULT)) {
	$contador=0;
	while ($row = oci_fetch_array($parse,OCI_ASSOC + OCI_RETURN_NULLS)) {
		$resultado[] = $row;
		$nombre=$row["NOMBRE"];
		$nombre_original=$nombre;
		for ($i=0;$i<count($terms1);$i++) {
			$nombre=str_ireplace($terms1[$i],"<b>".$terms1[$i]."</b>",$nombre);
		}
		echo $nombre."|".$row["ID_USUARIO"]."|".$nombre_original."\n";
		$contador++;
		if ($contador>=$limit) {
			break;
		}
	}
}
?>
