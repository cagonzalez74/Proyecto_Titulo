<?php session_start();?>
<script language="Javascript" SRC="<?=$home?>/_javascript/uploadify/swfobject.js"></script>
<script language="Javascript" SRC="<?=$home?>/_javascript/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script language="Javascript" SRC="<?=$home?>/organizacion/autoedicion/lib.js"></script>
<?php
$aplicacion='DSCXN';
//DESA86
//include_once($_SERVER['DOCUMENT_ROOT'].'/_database/cabecera_jq.php');
include_once('./lib.php');

$traeTag = new clasFunciones();
echo $traeTag->usuarioView($_SESSION['user']['id']);

?>