
<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/_class/Meta.class.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/organizacion/autoedicion/database.php');

class clasFunciones extends Meta{

	static $datoDB;

	public function  __construct() {
		parent::__construct();
		self::$datoDB = new todoDB();
	}

	public function usuarioView($id_usuario){
		//../../mtoledo/organizacion/controller.php?mod=78
		$data  = self::$datoDB->selectDatosUsuario($id_usuario);
		$direc = self::$datoDB->direccionUsuario($id_usuario);
		$fono  = self::$datoDB->selectFono($id_usuario);
		$email = self::$datoDB->selectEmail($id_usuario);

		if($data[0][0] == ""){
			$imagenPerfil = "$home/organizacion/Fotos/sin-imagen.jpg";
			$link = "<input type='file' name='foto_usuario_ed' id='foto_usuario_ed'>";
			  echo "  <script type=\"text/javascript\">\n"; 
              echo "    // <![CDATA[\n"; 
              echo "    $(document).ready(function() {\n"; 
              echo "      $('#foto_usuario_ed').uploadify({\n"; 
              echo "        'uploader'  : '$home/_javascript/uploadify/uploadify.swf',\n"; 
              echo "        'script'    : '$home/_javascript/uploadify/uploadify.php',\n"; 
              echo "        'cancelImg' : '$home/_javascript/uploadify/cancel.png',\n"; 
              echo "        'folder'    : '$home/organizacion/Fotos',\n"; 
              echo "        'auto'      : true,\n";
              echo "        'buttonText' :'Subir Archivo',\n"; 
              //echo "      'scriptData'  : {'fuente':'Status','id_informe':12067},\n";  
              echo "      'method'      : 'post',\n"; 
              echo "       'onComplete' : function(event, ID, fileObj, response, data) {\n"; 
              echo "      alert('Archivo Subido Correctamente!');\n"; 
              echo "      insertarUploadify('$id_usuario',response);\n";
              echo "    }\n"; 
              echo "      });\n"; 
              echo "    });\n"; 
              echo "    // ]]>\n"; 
              echo "    </script>\n";
		}else{
			$imagenPerfil = "$home/organizacion/".$data[0][0];
			$link = "<a href='#' onClick='eliminaFotoUsuario(\"$imagenPerfil\",$id_usuario);'>Eliminar foto</a>";
		}
?>
<div align="center" id="detalle_usuario">
<table align="center" width="90%">
	<tr><td>
	<table align="center" width="100%"> 
		<tr>
			<td align="center" colspan="4"><img src='<?=$imagenPerfil?>' width='130px' height='150px'></div></td>
		</tr>
		<tr>
			<td align="center" colspan="4"><?=$link?></td>
		</tr>
		<tr>
			<td colspan="4" class="ui-corner-all ui-widget-header" align="center">INFORMACION DEL USUARIO</td>
		</tr>
		<tr>
			<td class="texto3" width="55px">Nombre</td>
			<td class="cuadrotexto"><?=$data[0][1]?></td>
			<td class="texto3" width="55px">Area</td>
			<td class="cuadrotexto"><?=$data[0][2]?></td>
		</tr>
		<tr>
			<td class="texto3">Perfil</td>
			<td class="cuadrotexto"><?=$data[0][3]?></td>
			<td class="texto3">Cargo</td>
			<td class="cuadrotexto"><?=$data[0][4]?></td>
		</tr>
	</table>
	<table align="center" width="100%">
		<tr>
			<td class="texto3" align="center">Email</td>
			<td class="texto3" align="center">Tipo</td>
		</tr>
		<?php for($i=0;$i<count($email);$i++){?>
		<tr>
			<td style="text-align:center" class="cuadrotexto" width="80%" ><?=$email[$i][1]?></td>
			<td style="text-align:center" class="cuadrotexto" ><?=$email[$i][3]?></td>
		</tr>
		<?php }?>
	</table>
	<table align="center" width="100%">
		<tr>
			<td class="texto3" align="center" width="80%">Fono</td>
			<td class="texto3" align="center">Tipo</td>
		</tr>
		<?php for($k=0;$k<count($fono);$k++){?>
		<tr>
			<td style="text-align:center" class="cuadrotexto"><?=$fono[$k][1]?></td>
			<td style="text-align:center" class="cuadrotexto"><?=$fono[$k][2]?></td>
		</tr>
		<?php }?>
	</table>
	<table align="center" width="100%">
		<tr>
			<td class="texto3" align="center">Direccion</td>
			<td class="texto3" align="center">Numero</td>
			<td class="texto3" align="center">Dpto</td>
			<td class="texto3" align="center">Tipo</td>
		</tr>
		<?php for($k=0;$k<count($direc);$k++){?>
		<tr>
			<td style="text-align:center" class="cuadrotexto"><?=$direc[$k][1]?></td>
			<td style="text-align:center" class="cuadrotexto"><?=$direc[$k][2]?></td>
			<td style="text-align:center" class="cuadrotexto"><?=$direc[$k][3]?></td>
			<td style="text-align:center" class="cuadrotexto"><?=$direc[$k][6]?></td>
		</tr>
		<?php }?>
	</table>
	<table align="center" width="100%">
		<tr>
			<td class="texto3" width="55px">Empresa</td>
			<td class="cuadrotexto"><?=$data[0][5]?></td>
			<td class="texto3" width="55px">Zona</td>
			<td class="cuadrotexto"><?=$data[0][6]?></td>
		</tr>
		<tr>
			<td class="texto3" width="55px">Direcci&oacute;n laboral</td>
			<td class="cuadrotexto"><?=$data[0][7]?></td>
			<td class="texto3" width="55px">Ciudad</td>
			<td class="cuadrotexto"><?=$data[0][8]?></td>
		</tr>
		<tr>
			<td class="texto3" width="55px">Jefatura</td>
			<td class="cuadrotexto"><?=$data[0][9]?></td>
			<td class="texto3" width="55px">Comuna</td>
			<td class="cuadrotexto"><?=$data[0][10]?></td>
		</tr>
		<tr>
			<td colspan="4" class="ui-corner-all ui-widget-header" align="center">ACTUALIZAR DATOS</td>
		</tr>
		<tr>
			<td class="texto3" width="100px">Nueva password</td>
			<td><?=self::inputText(array("id"=>"nueva_pass_us","style"=>"width: 150px","maxlength"=>100,"type"=>"password","maxlength"=>8));?></td>
			<td class="texto3" width="100px">Repita password</td>
			<td><?=self::inputText(array("id"=>"rep_pass_us","style"=>"width: 150px","maxlength"=>100,"type"=>"password","maxlength"=>8));?></td>
		</tr>
		<tr>
			<td align="center" colspan="4"><?=self::inputButton(array("value"=>"Actualizar","style"=>"width: 100px","onclick"=>"cambiaPassword(document.getElementById('nueva_pass_us').value,document.getElementById('rep_pass_us').value);"));?></td>
		</tr>
	</table>
	</td></tr>
</table>
</div>
<?php
	}

	public function actualizaPassword($pass,$id_usuario){
		$passMD5 = md5($pass);
		self::$datoDB->updatePassword($passMD5,$id_usuario);
		echo "<script>alert('Password cambiado con exito');</script>";
		echo self::usuarioView($id_usuario);
	}
	public function checkLogin($pass,$id_usuario){
		$passMD5 = md5($pass);
		$mensaje="";
		if (!$aux=self::$datoDB->checkPassAntigua($passMD5,$id_usuario))		
			$mensaje.="La password no puede ser igual a la anterior\n";

		if(!self::$datoDB->checkPassLogin($passMD5,$id_usuario))
			$mensaje.="La password no puede ser igual al nombre de usuario\n";
		
		return $mensaje;	

	
	}

	public function actualizaFotoUsuario($id_usuario,$nombre){
		
		$nombreEx = explode("|",$nombre);
		$pathFoto = "Fotos/".$nombreEx[0];
		self::$datoDB->updateFoto($id_usuario,$pathFoto);
		self::usuarioView($id_usuario);
	}
	
	public function eliminaFotoUsuario($pathfoto,$id_usuario){
		self::$datoDB->eliminaFoto($id_usuario);
		$pathfoto = "../../mtoledo/organizacion/".$pathfoto;
		unlink($pathfoto);
		self::usuarioView($id_usuario);
	}
	
}
?>