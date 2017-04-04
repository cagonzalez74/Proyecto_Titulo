<?php
$aplicacion='GCSADMIN';
include_once($_SERVER['DOCUMENT_ROOT'].'/_database/cabecera_jq.php');
include_once('lib.php');

?>
<style type="text/css">
    #ui-datepicker-div
    {
        z-index: 99999999;
    }
	#ui-state-default .input{
		cursor: hand;
	}
</style>
<?php
$traeTag = new clasFunciones();
echo $traeTag->tabs();
?> 
