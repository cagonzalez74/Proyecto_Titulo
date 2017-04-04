<script language="Javascript" SRC="./lib.js"></script>
<script type='text/javascript' src='./uploadify/swfobject.js'></script>
<script type='text/javascript' src='./uploadify/jquery.uploadify.v2.1.4.min.js'></script>
<script type='text/javascript' src='<?=$home?>/_javascript/jquery.Rut.js'></script>
<script language="Javascript" SRC="<?=$home?>/_includes/FusionCharts/Charts/FusionCharts.js"></script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/_class/Meta.class.php');
include_once('database.php');
include_once('resize.php');

class clasFunciones extends Meta{

	static $datoDB;

	public function  __construct() {
		parent::__construct();
		self::$datoDB = new todoDB();
	}

	public function redirecciona(){
		echo "<script>location.href='$home'</script>";
	}

	public function resumenOrganizacion(){
?>
	<table align="center">
		<tr>
			<td><?=self::graficoUsuario()?></td>
			<td><?=self::graficoEmpresa()?></td>
		</tr>
		<tr>
			<td colspan="2"><?=self::graficoArea()?></td>
		</tr>
	</table>
<?php
	}

	public function graficoEmpresa(){

		$data = self::$datoDB->selectGraficoEstado();
		//var_dump($data);
		
		$strXml  = "<chart caption='ESTADO DE USUARIO NNOC' formatNumberScale='0' showPercentageInLabel='0' showValues='1' showLabels='1' showLegend='1'>";
		for($i=0;$i<=count($data);$i++){
			$strXml .= "<set value='".$data[$i][1]."' label='".$data[$i][0]."'/> ";
		}
		$strXml .= "</chart>";	
?>
		<div id='grafico2' align="center">
				<script type="text/javascript">
				var myChart = new FusionCharts("/graficos/Charts/Pie2D.swf", "myChartId", "500", "400", "FFFFFF", "exactFit");
				myChart.setDataXML("<?=$strXml?>");
				myChart.render("grafico2");
				</script>
		 </div>
<?php
	}

	public function graficoArea(){
		$data = self::$datoDB->selectGraficoArea();
		//VAR_DUMP($data);
		$strXml  = "<chart caption='USUARIOS POR AREA' formatNumberScale='0' showPercentageInLabel='0' showValues='1' showLabels='1' showLegend='1'>";
		for($i=0;$i<=count($data);$i++){
			$strXml .= "<set value='".$data[$i][2]."' label='".$data[$i][1]."'/> ";
		}
		$strXml .= "</chart>";	
?>
		<div id='grafico1' align="center">
				<script type="text/javascript">
				var myChart = new FusionCharts("/graficos/Charts/Pie2D.swf", "myChartId", "1000", "700", "FFFFFF", "exactFit");
				myChart.setDataXML("<?=$strXml?>");
				myChart.render("grafico1");
				</script>
		 </div>
<?php	
	}

	public function graficoUsuario(){

		$data = self::$datoDB->selectGraficoEstado();
		//var_dump($data);
		
		$strXml  = "<chart caption='ESTADO DE USUARIO NNOC' formatNumberScale='0' showPercentageInLabel='0' showValues='1' showLabels='1' showLegend='1'>";
		for($i=0;$i<=count($data);$i++){
			$strXml .= "<set value='".$data[$i][1]."' label='".$data[$i][0]."'/> ";
		}
		$strXml .= "</chart>";	
?>
		<div id='grafico' align="center">
				<script type="text/javascript">
				var myChart = new FusionCharts("/graficos/Charts/Pie2D.swf", "myChartId", "500", "400", "FFFFFF", "exactFit");
				myChart.setDataXML("<?=$strXml?>");
				myChart.render("grafico");
				</script>
		 </div>
<?php
	}

	public function usuarioView($id_usuario){
		//../../mtoledo/organizacion/controller.php?mod=78
		$data  = self::$datoDB->selectDatosUsuario($id_usuario);
		$direc = self::$datoDB->direccionUsuario($id_usuario);
		$fono  = self::$datoDB->selectFono($id_usuario);
		$email = self::$datoDB->selectEmail($id_usuario);

		if($data[0][0] == ""){
			$imagenPerfil = "../../mtoledo/organizacion/Fotos/sin-imagen.jpg";
			$link = "<input type='file' name='foto_usuario_ed' id='foto_usuario_ed'>";
			  echo "  <script type=\"text/javascript\">\n"; 
              echo "    // <![CDATA[\n"; 
              echo "    $(document).ready(function() {\n"; 
              echo "      $('#foto_usuario_ed').uploadify({\n"; 
              echo "        'uploader'  : './uploadify/uploadify.swf',\n"; 
              echo "        'script'    : './uploadify/uploadify.php',\n"; 
              echo "        'cancelImg' : './uploadify/cancel.png',\n"; 
              echo "        'folder'    : 'Fotos',\n"; 
              echo "        'auto'      : true,\n";
              echo "        'buttonText' :'Subir Archivo',\n"; 
              //echo "      'scriptData'  : {'fuente':'Status','id_informe':12067},\n";  
              echo "      'method'      : 'post',\n"; 
              echo "       'onComplete' : function(event, ID, fileObj, response, data) {\n"; 
              echo "      alert('Archivo Subido Correctamente!');\n"; 
              echo "      insertarUploadify2('$id_usuario',response);\n";
              echo "    }\n"; 
              echo "      });\n"; 
              echo "    });\n"; 
              echo "    // ]]>\n"; 
              echo "    </script>\n";
		}else{
			$imagenPerfil = $data[0][0];
			$link = "<a href='#' onClick='eliminaFotoUsuario(\"$imagenPerfil\",$id_usuario);'>Elimiar foto</a>";
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
			<td align="center" width="80%"><?=$email[$i][1]?></td>
			<td align="center"><?=$email[$i][3]?></td>
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
			<td align="center"><?=$fono[$k][1]?></td>
			<td align="center"><?=$fono[$k][2]?></td>
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
			<td align="center"><?=$direc[$k][1]?></td>
			<td align="center"><?=$direc[$k][2]?></td>
			<td align="center"><?=$direc[$k][3]?></td>
			<td align="center"><?=$direc[$k][6]?></td>
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
			<td><?=self::inputText(array("id"=>"nueva_pass_us","style"=>"width: 150px","maxlength"=>100,"type"=>"password"));?></td>
			<td class="texto3" width="100px">Repita password</td>
			<td><?=self::inputText(array("id"=>"rep_pass_us","style"=>"width: 150px","maxlength"=>100,"type"=>"password"));?></td>
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

	public function tipoPerfil($id_perfil = ""){

		if($id_perfil == ""){
			$edit 	 = "";
			$boton 	 = "Crear";
			$titulo  = "NUEVO";
		}else{
			$edit 	 = "_edit";
			$boton 	 = "Actualiza";
			$titulo  = "ACTUALIZA";
			$data 	 = self::$datoDB->selectPerfilGrilla($id_perfil);
			$nombre	 = $data[0][1];
			$desc	 = $data[0][2];
			$web	 = $data[0][3];
			$conex	 = $data[0][4];
		}
?>
<div align="center">
	<table>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td colspan="2" class="texto3" align="center"><b><?=$titulo?> TIPO DE PERFIL</b></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Nombre</td>
			<td><?=self::inputText(array("id"=>"nom_perfil$edit","style"=>"width: 200px","value"=>$nombre,"maxlength"=>100))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Descripci&oacute;n</td>
			<td><?=self::inputTextArea(array("id"=>"desc_perfil$edit","style"=>"width: 200px","value"=>$desc,"maxlength"=>200))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">P&aacute;gina de inicio</td>
			<td><?=self::inputText(array("id"=>"web_inicio$edit","style"=>"width: 200px","value"=>$web,"maxlength"=>100))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Duraci&oacute;n conexion</td>
			<td><?=self::inputText(array("id"=>"dur_con$edit","style"=>"width: 200px","value"=>$conex,"maxlength"=>100))?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=self::inputbutton(array("value"=>$boton,"style"=>"width: 100px","onclick"=>"guardaUpdateTipoPerfil(document.getElementById('nom_perfil$edit').value,
																																				 document.getElementById('desc_perfil$edit').value,
																																				 document.getElementById('web_inicio$edit').value,
																																				 document.getElementById('dur_con$edit').value,'$id_perfil');"))?></td>
		</tr>
	</table>
</div>
<?php if($id_perfil == ""){?>
<div id="grillaPerfil"><?=self::grillaPerfil();?></div>
<?php
	 }
}
	
	public function grillaPerfil(){
		$data = self::$datoDB->selectPerfilGrilla();
		//var_dump($data);
?>
<div align="center">
		<div style='width:70%;padding:10px;'>
						<table id='tabla_sol_13' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Descripci&oacute;n</th>
									<th class='cabecera'>P&aacute;gina de inicio</th>
									<th class='cabecera'>Duraci&oacute;n conexion</th>
									<th class='cabecera'>Elimina</th>
									<th class='cabecera'>Edita</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data[$i][1]?></td>
									<td align="center"><?=$data[$i][2]?></td>
									<td align="center"><?=$data[$i][3]?></td>
									<td align="center"><?=$data[$i][4]?></td>
									<td align="center"><a href="#" onClick="eliminaTipoPerfil(<?=$data[$i][0]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaTipoPerfil(<?=$data[$i][0]?>);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_13",100);</script>
</div>
<?php
	}
	
	public function tipoCargo($id_cargo = ""){
		if($id_cargo != ""){
			$titulo = "EDITAR";
			$edit	= "_edit";
			$boton	= "Actualizar";
			$data 	= self::$datoDB->selectTipoCargoGrilla($id_cargo);
			$nombre = $data['NOMBRE'][0];
			$desc   = $data['DESCRIPCION'][0];
		}else{
			$titulo = "CREAR";
			$edit	= "";
			$valor	= "";
			$boton	= "Crear";
			$nombre = "";
			$desc	= ""; 
		}
?>
<div align="center">
	<table>
		<tr>
			<td colspan="2" class="ui-corner-all ui-widget-header" align="center"><?=$titulo?> TIPO CARGO</td>
		</tr>
		<tr>
			<td class="cuadrotexto">Nombre</td>
			<td><?=self::inputText(array("id"=>"tipo_cargo$edit","style"=>"width: 200px","value"=>$nombre,"maxlength"=>100))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Descripci&oacute;n</td>
			<td><?=self::inputTextArea(array("id"=>"desc_cargo$edit","style"=>"width: 200px","value"=>$desc,"maxlength"=>200))?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=self::inputbutton(array("value"=>$boton,"style"=>"width: 100px","onclick"=>"guardaUpdateTipoCargo(document.getElementById('tipo_cargo$edit').value,document.getElementById('desc_cargo$edit').value,'$id_cargo');"))?></td>
		</tr>
	</table>
</div>
<?php if($id_cargo == ""){?>
<div id="div_man_tipo_cargo"><?=self::grillaTipoCargo();?></div>
<?php
		}
	}

	private function grillaTipoCargo(){
		$data = self::$datoDB->selectTipoCargoGrilla();
?>
<div align="center">
		<div style='width:40%;padding:10px;'>
						<table id='tabla_sol_13' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Descripci&oacute;n</th>
									<th class='cabecera'>Elimina</th>
									<th class='cabecera'>Edita</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data['ID_CARGO']);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data['NOMBRE'][$i]?></td>
									<td align="center"><?=$data['DESCRIPCION'][$i]?></td>
									<td align="center"><a href="#" onClick="eliminaTipoCargo(<?=$data['ID_CARGO'][$i]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaTipoCargo(<?=$data['ID_CARGO'][$i]?>);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_13",100);</script>
</div>
<?php	
	}	
	
	public function tipoAreaFun($id_tipo_areafun = ""){
		if($id_tipo_areafun != ""){
			$titulo = "EDITA";
			$edit   = "_edit";
			$var    = 1;
			$boton	= "Actualizar";
			$data	= self::$datoDB->selectTipoAreaFun($id_tipo_areafun);
			$valor	= $data['NOMBRE'][0];
		}else{
			$titulo = "CREA";
			$edit	= "";
			$var	= 0;
			$boton	= "Guardar";
			$valor	= "";
		}
?>
<div align="center">
	<table>
		<tr>
			<td colspan="2" class="ui-corner-all ui-widget-header" align="center"><?=$titulo?> TIPO DE AREA FUNCIONAL</td>
		</tr>
		<tr> 
			<td class="cuadrotexto">Nombre</td>
			<td><?=self::inputText(array("id"=>"tipo_areafun$edit","style"=>"width: 200px","value"=>$valor,"maxlength"=>100))?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=self::inputbutton(array("value"=>$boton,"style"=>"width: 100px","onclick"=>"guardaUpdateTipoAreaFun(document.getElementById('tipo_areafun$edit').value,$var,'$id_tipo_areafun');"))?></td>
		</tr>
	</table>
</div>
<?php if($id_tipo_areafun == ""){?>
	<div id="div_man_tipo_areafun"><?=self::grillaTipoAreaFun();?></div>
<?php	
		}
	}

	private function grillaTipoAreaFun(){
		$data = self::$datoDB->selectTipoAreaFun();
?>
<div align="center">
		<div style='width:40%;padding:10px;'>
						<table id='tabla_sol_13' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Elimina</th>
									<th class='cabecera'>Edita</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data['ID_TIPO_AREAFUN']);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data['NOMBRE'][$i]?></td>
									<td align="center"><a href="#" onClick="eliminaTipoAreaFun(<?=$data['ID_TIPO_AREAFUN'][$i]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaTipoAreaFun(<?=$data['ID_TIPO_AREAFUN'][$i]?>);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_13",100);</script>
</div>
<?php	
	}
	
	public function tipoDireccLaboral($id_direcc_lab = ""){
		if($id_direcc_lab != ""){ //Edito
			$data   = self::$datoDB->selectTipoDireccionLabGrilla($id_direcc_lab);
			$nombre = $data['NOMBRE'][0];
			$desc   = $data['DESCRIPCION'][0];
			$titulo = "EDITAR";
			$botton = "Actualziar";
			$edit	= "_edit";
		}else{//Creo
			$nombre	= "";
			$desc	= "";
			$titulo = "NUEVO";
			$botton = "Crear";
			$edit	= "";
		} 
?>
<div align="center">
	<table>
		<tr>
			<td colspan="2" class="ui-corner-all ui-widget-header" align="center"><?=$titulo?> TIPO DE DIRECCION LABORAL</td>
		</tr>
		<tr>
			<td class="cuadrotexto">Nombre</td>
			<td><?=self::inputText(array("id"=>"direc_us_lab$edit","style"=>"width: 200px","value"=>$nombre,"maxlength"=>100))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Descripci&oacute;n</td>
			<td><?=self::inputTextArea(array("id"=>"desc_direc_us_lab$edit","style"=>"width: 200px","value"=>$desc,"maxlength"=>200))?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=self::inputButton(array("value"=>$botton,"style"=>"width: 100px","onclick"=>"creaUpdateTipoDirecLab(document.getElementById('direc_us_lab$edit').value,document.getElementById('desc_direc_us_lab$edit').value,'$id_direcc_lab');"))?></td>
		</tr>
	</table>
</div>
<?php if($id_direcc_lab == ""){?>
<div id="div_grillaDirecLabUs"><?=self::grillaTipoDirecLab();?></div>
<?php }?>
<?php	
	}
	
	private function grillaTipoDirecLab(){
		$data = self::$datoDB->selectTipoDireccionLabGrilla();
		//var_dump($data);
?>
<div align="center">
		<div style='width:40%;padding:10px;'>
						<table id='tabla_sol_9' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Descripci&oacute;n</th>
									<th class='cabecera'>Elimina</th>
									<th class='cabecera'>Edita</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data['ID_TIPO']);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data['NOMBRE'][$i]?></td>
									<td align="center"><?=$data['DESCRIPCION'][$i]?></td>
									<td align="center"><a href="#" onClick="eliminaTipoDireccLab(<?=$data['ID_TIPO'][$i]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaTipoDireccLab(<?=$data['ID_TIPO'][$i]?>);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_9",100);</script>
</div>
<?php		
	}
	
	/* Estas funciones son para actualizar los tipo, se podria re-utilizar las mismas funciones
	 * pero como solo es un campo se creara una nueva function que genere el update*/
	
	public function actualizaTipoUsTelCorr($id,$tipo,$div){
		
		if($tipo == "usuario"){ //Edito el tipo de usuario
			$data   = self::$datoDB->selectInternoNoi($id);
			$valor  = $data['NOMBRE'][0];
		}elseif($tipo == "telefono"){
			$data   = self::$datoDB->selectTipoTelefono($id);
			$valor  = $data['DESCRIPCION_TELEFONO'][0];
		}elseif($tipo == "correo"){
			$data   = self::$datoDB->selectTipoCorreo($id);
			$valor  = $data['DESCRIPCION'][0];
		}elseif($tipo == "rol"){
			$data   = self::$datoDB->selectTipoRol($id);
			$valor  = $data['ROL'][0];
		}elseif($tipo == "direccion_usuario"){
			$data   = self::$datoDB->selectTipoDireccion($id);
			$valor  = $data['NOMBRE'][0];
		}
?>
<div align="left">
	<table>
			<tr>
				<td class="cuadrotexto">Nombre</td>
				<td><?=self::inputText(array("id"=>"edito_campos_tipe","value"=>$valor,"style"=>"width: 100px","name"=>"edito_campos_tipe"))?></td>
				<td><?=self::inputButton(array("value"=>"Actualiza","style"=>"width: 100px","onclick"=>"actualizaTipos(document.getElementById('edito_campos_tipe').value,$id,'$tipo','$div');"))?></td>
			</tr>
	</table>
</div>
<?php
	}
	
	/* fin actulizaciones campos tipo*/
	
	public function selctTiposUs(){
?>
<div align="center">
	<table>
			<tr>
				<td class="ui-corner-all ui-widget-header" align="center">SELECCIONE EL TIPO</td>
			</tr>
			<tr>
				<td><select id="tipo_correspon_usuario" onchange="selecccionaTipoUs(this.value);" style="width: 200px">
						<option value="">- Tipo -</option>
						<option value="1">Tipo Usuario</option>
						<option value="2">Tipo Telefono</option>
						<option value="3">Tipo Correo</option>
						<option value="4">Tipo Rol</option>
						<option value="5">Tipo Direcci&oacute;n</option>
						<option value="6">Tipo Perfil</option>
					</select>
				</td>
			</tr>
	</table>
</div>
<div id="div_selcc_tipo_us"></div>
<?php
	}

	public function tipoDireUsuario(){
?>
	<div align="center">
	<table>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2" class="texto3" align="center"><b>NUEVO TIPO DE DIRECCION</b></td>
			</tr>
			<tr>
				<td class="cuadrotexto" width="80px">Tipo</td>
				<td><?=self::inputText(array("id"=>"tipo_rol_usuario","style"=>"width: 150px","maxlength"=>50));?></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Guardar","onclick"=>"guardaNuevoTipoDireccUs(document.getElementById('tipo_rol_usuario').value);","style"=>"width: 100px"))?></td>
			</tr>
	</table>
	</div>
	<div id="div_grillaTipoDireccionUs"><?=self::grillaUsuarioDirec();?></div>
<?php		
	}
	
private function grillaUsuarioDirec(){
		$data = self::$datoDB->selectTipoDireccion();
?>
<div align="center">
		<div style='width:40%;padding:10px;'>
						<table id='tabla_sol_10' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Elimina</th>
									<th class='cabecera'>Edita</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data['ID_TIPO_DIRECCION_USUARIO']);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data['NOMBRE'][$i]?></td>
									<td align="center"><a href="#" onClick="eliminaDireccUs(<?=$data['ID_TIPO_DIRECCION_USUARIO'][$i]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaTipo(<?=$data['ID_TIPO_DIRECCION_USUARIO'][$i]?>,'direccion_usuario','div_grillaTipoDireccionUs');"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_10",100);</script>
</div>
<?php
	}
	
	public function tipoRol(){
?>
	<div align="center">
	<table>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2" class="texto3" align="center"><b>NUEVO TIPO DE ROL</b></td>
			</tr>
			<tr>
				<td class="cuadrotexto" width="80px">Tipo</td>
				<td><?=self::inputText(array("id"=>"tipo_rol_usuario","style"=>"width: 150px","maxlength"=>50));?></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Guardar","onclick"=>"guardaNuevoTipoRol(document.getElementById('tipo_rol_usuario').value);","style"=>"width: 100px"))?></td>
			</tr>
	</table>
	</div>
	<div id="div_grillaTipoUsuarioRol"><?=self::grillaUsuarioRol();?></div>
<?php		
	}
	
private function grillaUsuarioRol(){
		$data = self::$datoDB->selectTipoRol();
?>
<div align="center" id="a">
		<div style='width:40%;padding:10px;'>
						<table id='tabla_sol_11' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Elimina</th>
									<th class='cabecera'>Edita</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data['ID_TIPO_ROL']);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data['ROL'][$i]?></td>
									<td align="center"><a href="#" onClick="eliminaUsuarioRol(<?=$data['ID_TIPO_ROL'][$i]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaTipo(<?=$data['ID_TIPO_ROL'][$i]?>,'rol','div_grillaTipoUsuarioRol');"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_11",100);</script>
</div>
<?php
	}
	
	public function tipoCorreo(){
?>
	<div align="center">
	<table>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2" class="texto3" align="center"><b>NUEVO TIPO DE CORREO</b></td>
			</tr>
			<tr>
				<td class="cuadrotexto" width="80px">Tipo</td>
				<td><?=self::inputText(array("id"=>"tipo_correo_tel","style"=>"width: 150px","maxlength"=>50));?></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Guardar","onclick"=>"guardaNuevoTipoCorreo(document.getElementById('tipo_correo_tel').value);","style"=>"width: 100px"))?></td>
			</tr>
	</table>
	</div>
	<div id="div_grillaTipoUsuarioCorreo"><?=self::grillaUsuarioCorreo();?></div>
<?php		
	}

	private function grillaUsuarioCorreo(){
			$data = self::$datoDB->selectTipoCorreo();
			//var_dump($data);
	?>
	<div align="center">
			<div style='width:40%;padding:10px;'>
							<table id='tabla_sol_12' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
								<thead>
									<tr>
										<th class='cabecera'>Row</th>
										<th class='cabecera'>Nombre</th>
										<th class='cabecera'>Elimina</th>
										<th class='cabecera'>Edita</th>
									</tr>
								</thead>
								<tbody>
								<?php for($i=0;$i<count($data['ID_TIPO_CORREO_USUARIO']);$i++){
										$row = $i+1;?>
									<tr>
										<td align="center"><?=$row?></td>
										<td align="center"><?=$data['DESCRIPCION'][$i]?></td>
										<td align="center"><a href="#" onClick="eliminaUsuarioCorreo(<?=$data['ID_TIPO_CORREO_USUARIO'][$i]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
										<td align="center"><a href="#" onClick="editaTipo(<?=$data['ID_TIPO_CORREO_USUARIO'][$i]?>,'correo','div_grillaTipoUsuarioCorreo');"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
									</tr>
								<?php }?>
								</tbody>
							</table>
						</div>
					<script type="text/javascript">tabla("tabla_sol_12",100);</script>
	</div>
	<?php
		}

	
	public function tipoTelefonoUsuario(){
?>
	<div align="center">
	<table>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2" class="texto3" align="center"><b>NUEVO TIPO DE TELEFONO</b></td>
			</tr>
			<tr>
				<td class="cuadrotexto" width="80px">Tipo</td>
				<td><?=self::inputText(array("id"=>"tipo_usuario_tel","style"=>"width: 150px","maxlength"=>50));?></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Guardar","onclick"=>"guardaNuevoTipoTel(document.getElementById('tipo_usuario_tel').value);","style"=>"width: 100px"))?></td>
			</tr>
	</table>
	</div>
	<div id="div_grillaTipoUsuarioTel"><?=self::grillaUsuarioTel();?></div>
<?php
		}

	private function grillaUsuarioTel(){
			$data = self::$datoDB->selectTipoTelefono();
	?>
	<div align="center">
			<div style='width:40%;padding:10px;'>
							<table id='tabla_sol_8' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
								<thead>
									<tr>
										<th class='cabecera'>Row</th>
										<th class='cabecera'>Nombre</th>
										<th class='cabecera'>Elimina</th>
										<th class='cabecera'>Edita</th>
									</tr>
								</thead>
								<tbody>
								<?php for($i=0;$i<count($data['ID_TIPO_TELEFONO']);$i++){
										$row = $i+1;?>
									<tr>
										<td align="center"><?=$row?></td>
										<td align="center"><?=$data['DESCRIPCION_TELEFONO'][$i]?></td>
										<td align="center"><a href="#" onClick="eliminaUsuarioTel(<?=$data['ID_TIPO_TELEFONO'][$i]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
										<td align="center"><a href="#" onClick="editaTipo(<?=$data['ID_TIPO_TELEFONO'][$i]?>,'telefono','div_grillaTipoUsuarioTel');"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
									</tr>
								<?php }?>
								</tbody>
							</table>
						</div>
					<script type="text/javascript">tabla("tabla_sol_8",100);</script>
	</div>
	<?php
		}
		
	
	public function tipoUsuario(){
?>
<div align="center">
<table>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td colspan="2" class="texto3" align="center"><b>NUEVO TIPO DE USUARIO</b></td>
		</tr>
		<tr>
			<td class="cuadrotexto" width="80px">Tipo</td>
			<td><?=self::inputText(array("id"=>"tipo_usuario","style"=>"width: 150px","maxlength"=>50));?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Guardar","onclick"=>"guardaNuevoTipoUsuario(document.getElementById('tipo_usuario').value);","style"=>"width: 100px"))?></td>
		</tr>
</table>
</div>
<div id="div_grillaTipoUsuario"><?=self::grillaTipoUsuario();?></div>
<?php
	}
	
	private function grillaTipoUsuario(){
		$data = self::$datoDB->selectInternoNoi();
?>
<div align="center">
		<div id='grillaTipoUsuario' style='width:40%;padding:10px;'>
						<table id='tabla_sol_7' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Elimina</th>
									<th class='cabecera'>Edita</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data['ID_TIPO_USUARIO']);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data['NOMBRE'][$i]?></td>
									<td align="center"><a href="#" onClick="eliminaTipoUsuario(<?=$data['ID_TIPO_USUARIO'][$i]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaTipo(<?=$data['ID_TIPO_USUARIO'][$i]?>,'usuario','div_grillaTipoUsuario');"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_7",100);</script>
</div>
<?php
	}
	
	public function formDireccion($edita = 0,$id_direc = ""){

		$jefes  = self::$datoDB->selectJefes();
		
		if($edita == 1){
			$titulo = "EDITAR";
			$ids = "_edit";
			$data   = self::$datoDB->selectGrillaDireccLaboral($id_direc);
		}else{
			$titulo = "CREAR";
			$ids	= "";
		}

?>
<div align="center">
<form id="principal" name="direc_laboral" method="POST" enctype="multipart/form-data">
	<table width="41%">
		<tr>
			<td colspan="4" class="ui-corner-all ui-widget-header" align="center"><?=$titulo?> DIRECCION</td>
		</tr>
		<tr>
			<td class="cuadrotexto" width="80px">Nombre</td>
			<td><?=self::inputText(array("id"=>"nombre_direccion$ids","name"=>"nombre_direccion","style"=>"width: 150px","value"=>$data[0][1],"maxlength"=>100));?></td>
			<td class="cuadrotexto" width="100px">Tipo Direcci&oacute;n</td>
			<td><?=self::combobox("tipo_direccion",self::$datoDB->selectTipoDireccionLab(),array("id"=>"tipo_direccion$ids","style"=>"width: 150px","default"=>$data[0][2]));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Zona</td>
			<td><?=self::combobox("zona_direccion",self::$datoDB->selectZona(),array("id"=>"zona_direccion$ids","style"=>"width: 150px","onchange"=>"comboboxComuna(this.value,'$ids');","default"=>$data[0][9]));?></td>
			<td class="cuadrotexto">Comuna</td>
			<td><div id="div_comuna_zona"><?=self::combobox("comuna_direccion",self::$datoDB->selectLocalidad(),array("id"=>"comuna_direccion$ids","style"=>"width: 150px","default"=>$data[0][10]));?></div></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Telefono</td>
			<td><?=self::inputText(array("id"=>"telefono_direccion$ids","name"=>"telefono_direccion","style"=>"width: 150px","value"=>$data[0][7],"maxlength"=>10));?></td>
			<td class="cuadrotexto">Emergencia</td>
			<td><?=self::inputText(array("id"=>"emergencia_direccion$ids","name"=>"emergencia_direccion","style"=>"width: 150px","value"=>$data[0][8],"maxlength"=>10));?></td>
		</tr>
		<?php if($edita == 0){?>
		<tr>
			<td class="cuadrotexto">Responsable</td>
			<td><?=self::combobox("responsable_direccion0",$jefes,array("id"=>"responsable_direccion0","style"=>"width: 150px"));?></td>
			<td><a href='#' onClick='AgregarCamposDireccionLaboral();'><img src='../../img/mas.jpg'></a></td>
		</tr>
		<?php }?>
	</table>
	<?php  if($edita == 1){?>
				<div id='div_resp_edit'><?=self::direccionLaboral($id_direc)?></div>	
	<?php }?>
<!-- -------------------------------------------------------------------------------------------------------------- -->

<div id="dinamico_direcc_laboral"></div>
<input type="hidden" value="0" id="mod_direcc_lab" name="mod_direcc_lab"></input>

	<table width="41%" align="center">
		<tr>
			<?php if($edita == 0){?>
			<td align="center"><?=self::inputButton(array("value"=>"Crear","style"=>"width: 100px","onClick"=>"agregaDireccionLaboral(this.form);"))?></td>
			<?php }else{?>
			<td align="center"><?=self::inputButton(array("value"=>"Editar","style"=>"width: 100px","onClick"=>"editaDireccionLaboral($id_direc);"))?></td>
			<?php }?>
		</tr>		
	</table>
</form>
</div>
<?php if($edita == 0){?>
<div id="grilla_direccion_lab"><?=self::grillaDireccionLab()?></div>
<?php }?>
<script type="text/javascript">
var nextinput4 = 0;
			function AgregarCamposDireccionLaboral(){
				respDirecc = $("#responsable_direccion"+nextinput4).val();

				error = ""
				cabecera = "Debe ingresar los siguientes datos \n";

				if(respDirecc == ""){
					error += "- Ingrese responsable \n";
				}				

				if(error != ""){
					alert(cabecera+error);
				}else{
				
					nextinput4++;

					campo  = "<div align='center'>";
					campo  = "<table align='center' width='41%'>";
					campo += "<tr>";
					campo += "<td width='88px'>";
					campo += "</td>";
					campo += "<td align='left'>";
					campo += "<select style='width: 150px' id='responsable_direccion"+nextinput4+"' name='responsable_direccion"+nextinput4+"'>";
					campo += "<option value=''>Seleccione...</option>";
					<?php  for($i=0;$i<count($jefes['ID_USUARIO']);$i++){?>
					campo += "<option value='<?=$jefes['ID_USUARIO'][$i]?>'><?=$jefes['NOMBRES'][$i]?></option>";
					<?php }?>
					campo += "</select>";
					campo += "&nbsp;<a href='#' onClick='eliminaTr(this);'><img src='../../img/menos.jpg'> Eliminar</a>";
					campo += "</td>";
					campo += "</tr>";
					campo += "</table>";
					campo += "</div>";
					
					$("#dinamico_direcc_laboral").append(campo);
	
					document.getElementById("mod_direcc_lab").value = nextinput4;
				}
			}
</script>

<?php		
	}  

	public function direccionLaboral($id_direc){
		$dataUs = self::$datoDB->selectRespDirec($id_direc);
		$maxUs	= self::$datoDB->selectMaxRespDirec($id_direc);
		$max = $maxUs[0][0]+1; 
?>
	<table width="80%">
			<tr>
				<th class="texto3" colspan="3" align="center">RESPONSABLES</th>
			</tr>
			<tr>
				<td class="tc2">Nombre</td>
				<td class="tc2">Eliminar</td>
			</tr>
		<?php for ($i=0;$i<count($dataUs);$i++){?>
			<tr>
				<td class="tc1"><?=$dataUs[$i][2]?></td>
				<td align="center"><a href="#" onClick="eliminaRespDirecc(<?=$dataUs[$i][0]?>,<?=$dataUs[$i][1]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
			</tr>
		<?php }?>
		</table>
		<div id="div_agregaRespDirecc"></div>
		<table width="80%">
		<tr>
			<td align="right"><a href='#' onClick='agregaRespDirec(<?=$id_direc?>,<?=$max?>);'><img src='../../img/mas.jpg'></a></td>
		</tr>
		</table>
<?php
	}
	
	public function agrgaRespDireccion($id_direccion,$max){
?>
<table width="80%" align="center">
	<tr>
		<td><?=self::combobox("nuevoRespDirec",self::$datoDB->selectJefes(),array("id"=>"nuevoRespDirec"))?></td>
		<td><?=self::inputButton(array("value"=>"Guardar","onclick"=>"guardaNuevoRespDirec(document.getElementById('nuevoRespDirec').value,$id_direccion,$max);"))?></td>
	</tr>
</table>
<?php
	}
	
	private function grillaDireccionLab(){
		$data = self::$datoDB->selectGrillaDireccLaboral();
?>
<div align="center">
		<div id='grillaDireccLab' style='width:70%;padding:10px;'>
						<table id='tabla_sol_6' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Zona</th>
									<th class='cabecera'>Localidad</th>
									<th class='cabecera'>Tipo Direcci&oacute;n</th>
									<th class='cabecera'>Responsables</th>
									<th class='cabecera'>Telefono</th>
									<th class='cabecera'>Emergencia</th>
									<th class='cabecera'>Elimina</th>
									<th class='cabecera'>Edita</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data[$i][1]?></td>
									<td align="center"><?=$data[$i][5]?></td>
									<td align="center"><?=$data[$i][6]?></td>
									<td align="center"><?=$data[$i][3]?></td>
									<td align="center"><?=$data[$i][4]?></td>
									<td align="center"><?=$data[$i][7]?></td>
									<td align="center"><?=$data[$i][8]?></td>
									<td align="center"><a href="#" onClick="eliminaDirecc(<?=$data[$i][0]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaDirecc(<?=$data[$i][0]?>,1);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_6",100);</script>
</div>
<?php
	}

	public function comboboxComuna($id_zona,$ids){
		echo self::combobox("comuna_direccion",self::$datoDB->selectLocalidad($id_zona),array("id"=>"comuna_direccion$ids","style"=>"width: 150px"));
	}
	
	public function formEmpresa($edit = 0,$rut_empresa = ""){
		
		if($edit == 1){
			$data = self::$datoDB->selectEmpresaGrilla($rut_empresa);
			//var_dump($data);
		}

		($edit == 0)?$titulo ="AGREGAR":$titulo ="ACTUALIZA"; 
		($edit == 0)?$bot ="Guardar":$bot ="Acutalizar";
		($edit == 0)?$ids ="":$ids ="_edit";	
?>
<script language="javascript" type="text/javascript">
	$('#rut_empresa').Rut({
		  on_error: function(){ alert('Rut incorrecto');
		  		$("#rut_empresa").each(function(){	
				$($(this)).val('')
			});},
		  format_on: 'keyup'
	});
</script>

<div align="center">
	<table>
		<tr>
			<td colspan="2" class="ui-corner-all ui-widget-header" align="center"><?=$titulo?> EMPRESA</td>
		</tr>
		<tr>
			<td class="cuadrotexto">Rut</td>
			<td><?=self::inputText(array("id"=>"rut_empresa$ids","value"=>$data[0][0],"maxlength"=>12));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Razon Social</td>
			<td><?=self::inputText(array("id"=>"razon_social$ids","value"=>$data[0][1],"maxlength"=>100));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Fono</td>
			<td><?=self::inputText(array("id"=>"fono_empresa$ids","value"=>$data[0][5],"maxlength"=>12));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Direcci&oacute;n</td>
			<td><?=self::combobox("dire_empresa$ids",self::$datoDB->selectDireccionLaboral(),array("id"=>"dire_empresa$ids","default"=>$data[0][6]));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Correo</td>
			<td><?=self::inputText(array("id"=>"correo$ids","value"=>$data[0][9],"maxlength"=>100));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">URL</td>
			<td><?=self::inputText(array("id"=>"url$ids","value"=>$data[0][10],"maxlength"=>100));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Responsable</td>
			<td><?=self::combobox("resp_empresa$ids",self::$datoDB->selectJefes(),array("id"=>"resp_empresa$ids","default"=>$data[0][7]));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Tipo empresa</td>
			<td><?=self::combobox("tipo_empresa$ids",self::$datoDB->selectTipoEmpresa(),array("id"=>"tipo_empresa$ids","default"=>$data[0][8]));?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=self::inputButton(array("value"=>$bot,"onclick"=>"agregaActualizaEmpresa(document.getElementById('rut_empresa$ids').value,
																												   	   document.getElementById('razon_social$ids').value,
																												   	   document.getElementById('fono_empresa$ids').value,
																												       document.getElementById('dire_empresa$ids').value,
																												       document.getElementById('resp_empresa$ids').value,
																												       document.getElementById('tipo_empresa$ids').value,'$edit','$rut_empresa',
																												       document.getElementById('correo$ids').value,
																												       document.getElementById('url$ids').value);"));?></td>
		</tr>
	</table>
</div>
<?php if($edit == 0){?>
<div id="grilla_empresa"><?=self::grillaEmpresa();?></div>
<?php }?>
<?php
	}

	private function grillaEmpresa(){
		$data = self::$datoDB->selectEmpresaGrilla();
?>
<div align="center">
		<div id='grillaEmpresa' style='width:90%;padding:10px;'>
						<table id='tabla_sol_5' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Rut</th>
									<th class='cabecera'>Razon Social</th>
									<th class='cabecera'>Fono</th>
									<th class='cabecera'>Responsable</th>
									<th class='cabecera'>Direcci&oacute;n</th>
									<th class='cabecera'>Correo</th>
									<th class='cabecera'>Web</th>
									<th class='cabecera'>Estado</th>
									<th class='cabecera'>Eliminar</th>
									<th class='cabecera'>Editar</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data[$i][0]?></td>
									<td align="center"><?=$data[$i][1]?></td>
									<td align="center"><?=$data[$i][5]?></td>
									<td align="center"><?=$data[$i][3]?></td>
									<td align="center"><?=$data[$i][2]?></td>
									<td align="center"><?=$data[$i][9]?></td>
									<td align="center"><?=$data[$i][10]?></td>
									<td align="center"><?=$data[$i][11]?></td>
									<td align="center"><a href="#" onClick="eliminaEmpresa('<?=$data[$i][0]?>');"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaEmpresa('<?=$data[$i][0]?>',1);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_5",100);</script>
</div>				
<?php
	}
	
	public function agregaCargo(){
?>
<div align="center">
	<table align="center">
		<tr>
			<td colspan="2" class="ui-corner-all ui-widget-header" align="center">AGREGAR CARGO</td>
		</tr>
		<tr>
			<td class="cuadrotexto">Nombre cargo</td>
			<td><?=self::inputText(array("id"=>"nombre_cargo","maxlength"=>100));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Descripci&oacute;n</td>
			<td><?=self::inputTextArea(array("id"=>"desc_cargo","maxlength"=>200));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Tipo cargo</td> 
			<td><?=self::combobox("tipo_cargo",self::$datoDB->selectTipoCargo(),array("id"=>"tipo_cargo"));?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Crear","onclick"=>"agregaCargo(document.getElementById('nombre_cargo').value,document.getElementById('desc_cargo').value,document.getElementById('tipo_cargo').value);"));?></td>
		</tr>
	</table>
</div>
<div id="grilla_cargo"><?=self::grillaCargo();?></div>
<?php		
	}

	private function grillaCargo(){
		$data = self::$datoDB->selectCargoGrilla();
?>
<div id="grillaCargo" align="center">
		<div id='mnt_sol' style='width:70%;padding:10px;'>
						<table id='tabla_sol_4' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Row</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Tipo cargo</th>
									<th class='cabecera'>Creador</th>
									<th class='cabecera'>Eliminar</th>
									<th class='cabecera'>Editar</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$row?></td>
									<td align="center"><?=$data[$i][1]?></td>
									<td align="center"><?=$data[$i][3]?></td>
									<td align="center"><?=$data[$i][2]?></td>
									<td align="center"><a href="#" onClick="eliminaCargo(<?=$data[$i][0]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaCargo(<?=$data[$i][0]?>);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_4",100);</script>
</div>
<?php
	}
	
	public function editaCargo($id_cargo){
		$data = self::$datoDB->selectCargoGrilla($id_cargo);
?>
<div align="center">
	<table align="center">
		<tr>
			<td class="cuadrotexto">Nombre cargo</td>
			<td><?=self::inputText(array("id"=>"nombre_cargo_edit","value"=>$data[0][1]));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Descripci&oacute;n</td>
			<td><?=self::inputTextArea(array("id"=>"desc_cargo_edit","value"=>$data[0][5]));?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Tipo cargo</td>
			<td><?=self::combobox("tipo_cargo_edit",self::$datoDB->selectTipoCargo(),array("id"=>"tipo_cargo_edit","default"=>$data[0][4]));?></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Actualizar","onclick"=>"updateCargo(document.getElementById('nombre_cargo_edit').value,document.getElementById('desc_cargo_edit').value,document.getElementById('tipo_cargo_edit').value,$id_cargo);"));?></td>
		</tr>
	</table>
</div>
<?php
	}
	
	private function generatePassword ($length = 8){

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
        
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }
    // done!
    return $password;
  }	
	
 	public function editaUsuario($id_usuario){

?>
<div align="center">
<table align="center">
	<tr>
		<td colspan="2" align="center"><img src="<?=$dataUsuario[0][11]?>" width="100px" height="100px"></img></td>
	</tr>
	<tr>
		<td class="cuadrotexto">Rut</td>
		<td><?=self::inputText()?></td>
	</tr>
</table>
</div>
<?php 		
 	}

 	public function filtroGrillaVerUsuario(){

?>
<script language="javascript" type="text/javascript">
	$('#rut_fil').Rut({
		  on_error: function(){ alert('Rut incorrecto');
		  		$("#rut_fil").each(function(){	
				$($(this)).val('')
			});},
		  format_on: 'keyup'
	});
</script>
<div align="center">
	<table>
		<tr>
			<td colspan="4" class="ui-corner-all ui-widget-header" align="center">FILTROS</td>
		</tr>
		<tr>
			<td  class="cuadrotexto" width="90px">Nombre</td>
			<td><?=self::inputText(array("id"=>"nom_fil","style"=>"width: 180px"))?></td>
			<td  class="cuadrotexto" width="90px">Apellido</td>
			<td><?=self::inputText(array("id"=>"ape_fil","style"=>"width: 180px"))?></td>
		</tr>
		<tr>
			<td  class="cuadrotexto" width="90px">Area</td>
			<td><?=self::combobox("area_fil",self::$datoDB->selectAreaFun(),array("id"=>"area_fil","style"=>"width: 180px"))?></td>
			<td  class="cuadrotexto" width="90px">Zona</td>
			<td><?=self::combobox("zona_fil",self::$datoDB->selectZona(),array("id"=>"zona_fil","style"=>"width: 180px"))?></td>
		</tr>
		<tr>
			<td  class="cuadrotexto">Empresa</td>
			<td><?=self::combobox("empresa_fil",self::$datoDB->selectEmpresa(),array("id"=>"empresa_fil","style"=>"width: 180px"))?></td>
			<td  class="cuadrotexto">Perfil</td>
			<td><?=self::combobox("perfil_fil",self::$datoDB->selectPerfil(),array("id"=>"perfil_fil","style"=>"width: 180px"))?></td>
		</tr>
		<tr>
			<td  class="cuadrotexto">Rut</td>
			<td><?=self::inputText(array("id"=>"rut_fil","style"=>"width: 180px"))?></td>
		</tr>
		<tr>
			<td colspan="4" align="center"><?=self::inputButton(array("value"=>"Filtrar","style"=>"width: 100px","onclick"=>"filtraVerUsuario(document.getElementById('area_fil').value,
																																			  document.getElementById('zona_fil').value,
																																			  document.getElementById('empresa_fil').value,
																																			  document.getElementById('perfil_fil').value,
																																			  document.getElementById('rut_fil').value,
																																			  document.getElementById('nom_fil').value,
																																			  document.getElementById('ape_fil').value);"))?></td>
		</tr>
	</table>
</div>
 	<div id="div_grillaVerUser"></div> 	
<?php 
 	}

	public function verUsuario($area,$zona,$empresa,$perfil,$rut,$nombre,$apellido){
		$dataUsuario = self::$datoDB->selectuDataUsuario("",$area,$zona,$empresa,$perfil,$rut,$nombre,$apellido);
		//var_dump($dataUsuario);
?>
<div id="grillaUsuario" align="center"><!--  -->
		<div id='mnt_sol_222' style='width:98%;padding:10px;'>
						<table id='tabla_sol_2' cellpadding='0' cellspacing='0' border='0' align='center' class='display' style='width:100%'>
							<thead>
								<tr>
									<th class='cabecera'>Id</th>
									<th class='cabecera'>Rut</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>Id Area</th>
									<th class='cabecera'>Area Funcional</th>
									<!--<th class='cabecera'>Sexo</th>-->
									<th class='cabecera'>Id Jefe</th>
									<th class='cabecera'>Jefe</th>
									<th class='cabecera'>cargo</th>
									<th class='cabecera'>Estado</th>
									<th class='cabecera'>Tipo usuario</th>
									<th class='cabecera'>Empresa</th>
									<th class='cabecera'>Fecha ingreso</th>
									<th align="center">Editar</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($dataUsuario);$i++){
									$row = $i+1;?>
								<tr>
									<td align="center"><?=$dataUsuario[$i][0]?></td> 		<!--ID -->
									<td align="center"><?=$dataUsuario[$i][1]?></td> 		<!--RUT -->
									<td align="center"><?=$dataUsuario[$i][2]?></td>	 	<!--NOMBRES -->
									<td align="center"><?=$dataUsuario[$i][17]?></td>		 <!--ID AREA-->
									<td align="center"><?=$dataUsuario[$i][7]?></td>		 <!--AREA -->
									
									<!-- <td align="center">< ?=$dataUsuario[$i][4]?></td>		 <!--SEXO -->
									<td align="center"><?=$dataUsuario[$i][24]?></td>		 <!--ID JEFE-->
									<td align="center"><?=$dataUsuario[$i][6]?></td>		 <!--JEFE-->
											
									<td align="center"><?=$dataUsuario[$i][8]?></td>		 <!--CARGO -->
									<td align="center"><?=$dataUsuario[$i][9]?></td>		 <!--ESTADO -->
									<td align="center"><?=$dataUsuario[$i][10]?></td>		 <!--TIPO USUARIO-->
									<td align="center"><?=$dataUsuario[$i][5]?></td>		 <!--EMPRESA-->
									<td align="center"><?=$dataUsuario[$i][3]?></td>		 <!--FECHA INGRESO -->
									<td align="center"><a href="#" onClick="editaUsuario(<?=$dataUsuario[$i][0]?>);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_2",100);</script>
</div>
<?php	
	}

	public function verificaLogin($login){

	if($login == ""){
		$foto = "<img src='../../_img/png/24x24/No.png' width='20px'></img>";
	}else{
		$valida = self::$datoDB->validaLogin($login);
		if($valida[0][0]==0){
			$foto = "<img src='../../_img/png/24x24/Accept.png' width='18px'></img>";
		}else{
			$foto = "<img src='../../_img/png/24x24/No.png' width='20px'></img>";
			echo "<script>document.getElementById('login_us').value='';</script>";
			echo "<script>alert('El login ingresado esta asignado a otro usuario intente con otro login');</script>";
		}
	}
	echo $foto;
	}

	public function validaRut($rut){
		
		$data = self::$datoDB->validarRut($rut);
		
		if($rut == ""){
			$foto_rut = "";
		}else{
			if($data[0][0] > 0){ //Existe
				$foto_rut = "<img src='../../_img/png/24x24/No.png' width='20px'></img>";
				echo "<script>document.getElementById('rut_us').value='';</script>";
				echo "<script>alert('El rut ya pertenece a un usuario');</script>"; 
			}else{
				$foto_rut = "<img src='../../_img/png/24x24/Accept.png' width='18px'></img>";
			}
		}
		
	echo $foto_rut;
	}
	
	public function inicio($edicion = 0,$id_usuario = ""){

		/* Querys para llenar Direccion*/
		$tipoDirec = self::$datoDB->selectTipoDireccion();
		//$ciudad	   = self::$datoDB->selectCiudad();
		$localidad = self::$datoDB->selectLocalidad();
		/* Query para llenar Email*/
		$tipoEmail = self::$datoDB->selectTipoCorreo();
		/* Query para llenar Fono*/
		$tipoFono  = self::$datoDB->selectTipoTelefono();
		

		/* Querys si el administrador edita al usuario */	
		if($edicion == 1){
			/* Datos tabla org_usuario */
			$dataUsuario = self::$datoDB->selectuDataUsuario($id_usuario);					
		}
?>
	<script language="javascript" type="text/javascript">
		$('#rut_us').Rut({
			  on_error: function(){ alert('Rut incorrecto');
			  		$("#rut_us").each(function(){	
					$($(this)).val('')
				});},
			  format_on: 'keyup'
		});
	</script>

<div id="form_inicio" align="center">
<form id="principal" name="principal" method="POST" enctype="multipart/form-data"><!-- action="controller.php?mod=4" -->

<table class="cuadrotexto" align="center" width="70%">
	<div id='uso_default'></div>
	<?php 
		if($edicion == 1){
			if($dataUsuario[0][11] == ""){
				$dataUsuario[0][11] = "./Fotos/sin-imagen.jpg";
				$liminaF = ""; 	   //Si el usuario no tiene foto oculto el boton eliminar foto
				$fileLocked = ""; //si el usuario no tiene foto activo el cargar foto
			}else{
				$liminaF =  "<tr><td align='center'><a href='#' onClick='eliminaFoto(\"".$dataUsuario[0][11]."\",$id_usuario);'>Eliminar foto</a></td></tr>";
				$fileLocked = "disabled = true";
			}
			
			echo "<tr><td colspan='4' align='center' class='person'><div class='person'><img src='".$dataUsuario[0][11]."' width='130px' height='150px'></div></td></tr>";
			echo $liminaF;
			$colsan = "colspan='7'";
		}else{
			$colsan = "colspan='5'";
		}
?>
	<tr>
		<td>
			<table align="center" width="100%">
				<tr>
					<td <?=$colsan?> class="ui-corner-all ui-widget-header" align="center">DATOS USUARIO</td>
				</tr>
				<tr>
					<td class="cuadrotexto" width="60px">Rut</td>
					<td width="290px"><?=self::inputText(array("name"=>"rut_us","id"=>"rut_us","onBlur"=>"validaRut(this.value,$edicion);","value"=>$dataUsuario[0][1]))?></td> <!-- ,"onBlur"=>"validaRut()" -->
					<td width="80px"><div id="rut_val"></div></td>
					<td class="cuadrotexto">Foto</td>
					<td><input type="file" id="foto_us" name="foto_us" <?=$fileLocked?>></input></td><!-- class="upload" -->	
				<?php 
			if($edicion == 1){
              echo "  <script type=\"text/javascript\">\n"; 
              echo "    // <![CDATA[\n"; 
              echo "    $(document).ready(function() {\n"; 
              echo "      $('#foto_us').uploadify({\n"; 
              echo "        'uploader'  : 'uploadify/uploadify.swf',\n"; 
              echo "        'script'    : 'uploadify/uploadify.php',\n"; 
              echo "        'cancelImg' : 'uploadify/cancel.png',\n"; 
              echo "        'folder'    : 'Fotos',\n"; 
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
			}
				?>
				</tr>
				<tr>
					<td class="cuadrotexto">Nombres</td>
					<td><?=self::inputText(array("id"=>"nombre_us","name"=>"nombre_us","value"=>$dataUsuario[0][12],"maxlength"=>100))?></td>
					<td>&nbsp;</td>
					<td class="cuadrotexto">Apellidos</td>
					<td><?=self::inputText(array("id"=>"apellido_us","name"=>"apellido_us","value"=>$dataUsuario[0][13],"maxlength"=>100))?></td>
				</tr>
				<tr>
					<td class="cuadrotexto">Login</td>
					<td><?=self::inputText(array("id"=>"login_us","name"=>"login_us","onblur"=>"validaLogin(this.value,$edicion);","value"=>$dataUsuario[0][14],"maxlength"=>30))?></td>
					<td width="80px"><div id="acep_no"></div></td>
					<td class="cuadrotexto">Fecha Nac.</td>
					<td><?=self::inputFecha("fecha_nac",array("id"=>"fecha_nac","value"=>$dataUsuario[0][15],"yearRange"=>"c-90:c+0"))?></td>
				</tr>
				
				<tr>
				<?php  if($edicion == 1){
							if($dataUsuario[0][4] == "M"){
								$selectedM = "selected";
								$selectedF = "";
							}else{
								$selectedM = "";
								$selectedF = "selected";
							}
						}
				?>
					<td class="cuadrotexto">Sexo</td>
					<td>
						<select id="sexo_us" name="sexo_us">
							<option value="">-Seleccione-</option>
							<option value="M" <?=$selectedM?>>Masculino</option>
							<option value="F" <?=$selectedF?>>Femenino</option>
						</select>
					</td>
					<td>&nbsp;</td>
				</tr>
				</table>
				
			<?php if($edicion != 1){?>
			<table>
				<tr>
					<td class="cuadrotexto" width="60px">Direccion</td>
					<td colspan="4"><?=self::inputText(array("name"=>"direccion_pers0","id"=>"direccion_pers0","style"=>"width: 100px","maxlength"=>50))?> <!-- ,"style"=>"50px" -->
					Nro <?=self::inputText(array("id"=>"nmro0","name"=>"nmro0","style"=>"width: 50px"))?>
					Dpto <?=self::inputText(array("id"=>"dpto0","name"=>"dpto0","style"=>"width: 50px","maxlength"=>5))?>
					<?=self::combobox("tipo_direc0",$tipoDirec,array("id"=>"tipo_direc0","style"=>"width: 70px","first_option"=>"-Tipo-"))?>
					<?=self::combobox("local_pers0",$localidad,array("id"=>"local_pers0","style"=>"width: 100px","first_option"=>"-Localidad-"))?>
					<a href='#' onClick='AgregarCamposDireccion();'><img src='../../img/mas.jpg'></a></td>
				</tr>
			</table>
				<?php }else{?>
					<div id='muestraDirec'><?=self::muestraDireccion($id_usuario)?></div>
				<?php }?>	
<!-- Dinamico Direc --> <div id="campos_direccion" align="center"></div>	
<input type="hidden" id="mod_direc" name="mod_direc" value="0">	
			<?php if($edicion != 1){?>	
			<table>
				<tr>
					<td class="cuadrotexto" width="60px">Email</td>
					<td colspan="2"><?=self::inputText(array("id"=>"email0","name"=>"email0","maxlength"=>100))?>&nbsp;
					<?=self::combobox("tipo_correo0",$tipoEmail,array("id"=>"tipo_correo0","style"=>"width:70px","first_option"=>"-Tipo-"))?> <a href='#' onClick='AgregarCamposEmail();'><img src='../../img/mas.jpg'></a></td>
				</tr>
			</table>
			<?php }else{?>
					<div id='div_muestra_email'><?=self::muestraEmail($id_usuario)?></div>
			<?php }?>
			
<!-- Dinamico email --> <div id="campos_email" align="center"></div>
<input type="hidden" id="mod_email" name="mod_email" value="0">
			<?php if($edicion != 1){?>	
			<table>
				<tr>
					<td class="cuadrotexto" width="60px">Fono</td>
					<td colspan="2"><?=self::inputText(array("id"=>"fono0","name"=>"fono0","maxlength"=>30))?>&nbsp;
					<?=self::combobox("tipo_fono0",$tipoFono,array("id"=>"tipo_fono0","style"=>"width: 70px","first_option"=>"-Tipo-"))?> <a href='#' onClick='AgregarCamposFono();'><img src='../../img/mas.jpg'></a></td>
				</tr>
			</table>
			<?php }else{?>
					<div id='div_muestra_fono'><?=self::muestraFono($id_usuario)?></div>
			<?php }?>
<!-- Dinamico Fono --> <div id="campos_fono" align="center"></div>
<input type="hidden" id="mod_fono" name="mod_fono" value="0">
			<table width="100%">
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td colspan="4" class="ui-corner-all ui-widget-header" align="center">DATOS LABORALES</td>
					</tr>
					<tr>
						<td class="cuadrotexto">C&oacute;digo T&eacute;cnico</td>
						<td><?=self::inputText(array("id"=>"codigo_tecnico_us","name"=>"codigo_tecnico_us","value"=>$dataUsuario[0][16],"maxlength"=>30))?></td>
						<td class="cuadrotexto">Area Funcional</td>
						<td><?=self::combobox("area_fun_us",self::$datoDB->selectAreaFun(),array("id"=>"area_fun_us","default"=>$dataUsuario[0][17]))?></td>
					</tr>
					<tr>
						<td class="cuadrotexto">Cargo</td>
						<td><?=self::combobox("cargo_us",self::$datoDB->selectCargo(),array("id"=>"cargo_us","default"=>$dataUsuario[0][18]))?></td>
						<td class="cuadrotexto">Direcci&oacute;n</td> 
						<td><?=self::combobox("dire_lab_us",self::$datoDB->selectDireccionLaboral(),array("id"=>"dire_lab_us","default"=>$dataUsuario[0][19]))?></td>
					</tr>
					<tr>
						<td class="cuadrotexto">Tipo usuario</td>
						<td><?=self::combobox("interno_no_us",self::$datoDB->selectInternoNoi(),array("id"=>"interno_no_us","onchange"=>"verificaInterino(this.value);","default"=>$dataUsuario[0][20]))?></td>
						<td class="cuadrotexto">Empresa</td>
						<td><div id="empresa"><?=self::combobox("empresa_us",self::$datoDB->selectEmpresa(),array("id"=>"empresa_us","default"=>$dataUsuario[0][21]))?></div></td>
					</tr>
					<tr>
						<td class="cuadrotexto">Fecha ing. VTR</td>
						<td><?=self::inputFecha("fecha_ingreso_vtr",array("id"=>"fecha_ingreso_vtr","value"=>$dataUsuario[0][3],"yearRange"=>"-20:+0"))?></td>
						<td class="cuadrotexto">Nivel de aprobaci&oacute;n</td><!-- Es el nivel Ap. Si. -->
						<td><?=self::combobox("nivel_apro_us",self::$datoDB->selectNivelApSi(),array("id"=>"nivel_apro_us","default"=>$dataUsuario[0][22],"selected"=>"selected"))?></td>
					</tr>
					<tr>
						<td class="cuadrotexto">Perfil</td>
						<td><?=self::combobox("perfil_us",self::$datoDB->selectPerfil(),array("id"=>"perfil_us","default"=>$dataUsuario[0][23]))?></td>
						<td class="cuadrotexto">Jefe</td>
						<td><?=self::combobox("jefe_us",self::$datoDB->selectJefes(),array("id"=>"jefe_us","default"=>$dataUsuario[0][24]))?></td>
					</tr>
					<?php if($edicion == 1){
						  	$valor = $dataUsuario[0][25];
						  }else{
							$valor = 1;
						  }?>
					<tr>
						<td class="cuadrotexto">Estado</td>
						<td><?=self::combobox("estado_us",self::$datoDB->selectEstado(),array("id"=>"estado_us","default"=>$valor))?></td>
					</tr>
			</table>	
	<!-- ----------------- Campos dinamicos -->
	<script type="text/javascript">

// ********************************* DINAMICOS DIRECCION *************************		
			var nextinput2 = 0;
			function AgregarCamposDireccion(){
				direccion	= $("#direccion_pers"+nextinput2).val();
				tipo_direc	= $("#tipo_direc"+nextinput2).val();
				localidad	= $("#local_pers"+nextinput2).val();
				nmro		= $("#nmro"+nextinput2).val();
				dpto		= $("#dpto"+nextinput2).val();

				error = ""
				cabecera = "Debe ingresar los siguientes datos \n";

				if(direccion == ""){
					error += "- Ingrese Direccion \n";
				}
				if(nmro == ""){
					error += "- Ingrese el numero de la direccion \n";
				}
				if(tipo_direc == ""){
					error += "- Seleccione Tipo de direccion \n";
				}
				if(localidad == ""){
					error += "- Seleccione Localidad \n";
				}

				if(error != ""){
					alert(cabecera+error);
				}else{
				
					nextinput2++;
	
					campo  = "<table align='left' width='100%'>";

					campo += "<tr>";

					campo += "<td width='65px'>&nbsp;</td>";

					campo += "<td>";

					campo += "&nbsp;<input type='text' id='direccion_pers"+nextinput2+"' name='direccion_pers"+nextinput2+"' style='width:100px' maxlength='50'>&nbsp;";
					campo += "&nbsp;Nro <input type='text' id='nmro"+nextinput2+"' name='nmro"+nextinput2+"' style='width:50px'>&nbsp;";
					campo += "&nbsp;Dpto <input type='text' id='dpto"+nextinput2+"' name='dpto"+nextinput2+"' style='width:50px' maxlength='5'>&nbsp;";

					campo += "<select style='width: 70px' id='tipo_direc"+nextinput2+"' name='tipo_direc"+nextinput2+"'>";
					campo += "<option value=''>-Tipo-</option>";
					<?php for($i=0;$i<count($tipoDirec['ID_TIPO_DIRECCION_USUARIO']);$i++){?>
					campo += "<option value='<?=$tipoDirec['ID_TIPO_DIRECCION_USUARIO'][$i]?>'><?=$tipoDirec['NOMBRE'][$i]?></option>";
					<?php }?>
					campo += "</select>&nbsp;";

					campo += "<select style='width: 100px' id='local_pers"+nextinput2+"' name='local_pers"+nextinput2+"'>";
					campo += "<option value=''>-Localidad-</option>";

					<?php for($i=0;$i<count($localidad['CODI_LOCALIDAD']);$i++){?>
					campo += "<option value='<?=$localidad['CODI_LOCALIDAD'][$i]?>'><?=$localidad['DESC_LOCALIDAD'][$i]?></option>";
					<?php }?>
					campo += "</select>&nbsp;";

					campo += "<a href='#' onClick='eliminaTr(this);'><img src='../../img/menos.jpg'> Eliminar</a>";
					
					campo += "</td>";

					campo += "<td>&nbsp;</td>";
					campo += "</tr>";
					campo += "</table>";

					$("#campos_direccion").append(campo);
	
					document.getElementById("mod_direc").value = nextinput2;
				}
			}

// ********************************* DINAMICOS EMAIL *************************		
	var nextinput = 0;

		function AgregarCamposEmail(){
			correo	= $("#email"+nextinput).val();
			tipo	= $("#tipo_correo"+nextinput).val();

			error = ""
			cabecera = "Debe ingresar los siguientes datos \n";
			
			if(correo == ""){
				error += " - Correo \n";
			}
			if(tipo == ""){
				error += " - Tipo de correo \n";
			}

			if(error != ""){
				alert(cabecera+error);
			}else{

				nextinput++;
	
				campo  = "<table align='left' width='100%'>";
				campo += "<tr>";
	
				campo += "<td width='65px'>&nbsp;</td>";
				
				campo += "<td>";
	
				campo += "<input type='text' id='email"+nextinput+"' name='email"+nextinput+"' style='width: 290px' maxlength=100>&nbsp;";
				campo += "<select style='width:70px' id='tipo_correo"+nextinput+"' name='tipo_correo"+nextinput+"'>";
				campo += "<option value=''>-Tipo-</option>";
				<?php for($i=0;$i<count($tipoEmail['ID_TIPO_CORREO_USUARIO']);$i++){?>
				campo += "<option value='<?=$tipoEmail['ID_TIPO_CORREO_USUARIO'][$i]?>'><?=$tipoEmail['DESCRIPCION'][$i]?></option>";
				<?php }?>
				campo += "</select>";
	
				campo += "&nbsp;<a href='#' onClick='eliminaTr(this);'><img src='../../img/menos.jpg'> Eliminar</a>";	
	
				campo += "</td>";
				
				campo += "<td>&nbsp;</td>";
	
				campo += "</tr>";
				campo += "</table>";
	
				$("#campos_email").append(campo);
	
				document.getElementById("mod_email").value = nextinput;
			}
		}


// ********************************* DINAMICOS FONO *************************		
		var nextinput3 = 0;
		function AgregarCamposFono(){

			fono		= $("#fono"+nextinput3).val();
			tipo_fono	= $("#tipo_fono"+nextinput3).val();

			error = ""
			cabecera = "Debe ingresar los siguientes datos \n";
			
			if(fono == ""){
				error += " - Fono \n";
			}
			if(tipo_fono == ""){
				error += " - Tipo de Fono \n";
			}

			if(error != ""){
				alert(cabecera+error);
			}else{
			
				nextinput3++;
	
				campo  = "<table align='left' width='100%'>";
				
				campo += "<tr>";
	
				campo += "<td width='65px'>&nbsp;</td>";
				
				campo += "<td>";
	
				campo += "<input type='text' id='fono"+nextinput3+"' name='fono"+nextinput3+"' style='width:290px' maxlength=30>&nbsp;";
				
				campo += "<select style='width:70px' id='tipo_fono"+nextinput3+"' name='tipo_fono"+nextinput3+"'>";
				campo += "<option value=''>-Tipo-</option>";
				<?php for($i=0;$i<count($tipoFono['ID_TIPO_TELEFONO']);$i++){?>
				campo += "<option value='<?=$tipoFono['ID_TIPO_TELEFONO'][$i]?>'><?=$tipoFono['DESCRIPCION_TELEFONO'][$i]?></option>";
				<?php }?>
				campo += "</select>&nbsp;";
	
				campo += "<a href='#' onClick='eliminaTr(this);'><img src='../../img/menos.jpg'> Eliminar</a>";	
				
				campo += "</td>";
				
				campo += "<td>&nbsp;</td>";
				
				campo += "</tr>";
				campo += "</table>";
	
				$("#campos_fono").append(campo);
	
				document.getElementById("mod_fono").value = nextinput3;
			}
		}
	</script>
	<!-- ----------------- Fin campos dinamicos ----------- -->
		</td>
	</tr>
	<?php if($edicion == 1){?>
		<tr>
			<td colspan="4" align="center"><?=self::inputButton(array("value"=>"Actualizar","onclick"=>"actualizaUsuario($id_usuario);","style"=>"width :100px"));?></td>
		</tr>
	<?php }else{?>
	<tr>
		<td colspan="4" align="center"><?=self::inputButton(array("value"=>"Guardar","onclick"=>"insertaUsuario(this.form);","style"=>"width :100px"));?></td>
	</tr>
	<?php }?>
</table>

</form>
</div>
<?php
	}

	public function muestraDireccion($id_usuario,$id_direccion = 0,$editar_direccion = 0){ 

		/* Datos tabla org_direccion_usuario */
		$dataDirecc	 = self::$datoDB->direccionUsuario($id_usuario);
		$colspan = 7;
		
		if ($editar_direccion == 1){
			$tit = "<td class='tc2'>Grabar</td>";
			$colspan= 8;
		}
?>
		<table width="100%">
		<tr>
			<th class="ui-corner-all ui-widget-header" colspan="<?=$colspan?>" align="center">DIRECCIONES</th>
		</tr>
		<tr>
			<td class="tc2">Direcci&oacute;n</td>
			<td class="tc2">Nmro</td>
			<td class="tc2">Dpto</td>
			<td class="tc2">Tipo</td>
			<td class="tc2">Localidad</td>
			<?=$tit?>
			<td class="tc2">Eliminar</td>
			<td class="tc2">Editar</td>
		</tr>
		<?php 
			 $disabled = "disabled";
			 
			  for($i=0;$i<count($dataDirecc);$i++){

			  	if($editar_direccion == 1){
					if($id_direccion == $dataDirecc[$i][0]){
							$editar 	= false;
							$disabled	= '';
							$button		= "<td class='tc1' align='center'>".self::inputButton(array('value'=>'Grabar','style'=>'width: 50px',"onclick"=>"grabarDireccion($id_direccion,document.getElementById('edit_direc$i').value,document.getElementById('edit_nmro$i').value,document.getElementById('edit_dpto$i').value,document.getElementById('edit_tipo$i').value,document.getElementById('edit_local$i').value,$id_usuario);"))."</td>";
					}else{
							$editar 	= true;
							$disabled	= "disabled";
							$button		= "<td class='tc1' align='center'></td>";
					}
			     }
		?>
				<tr>
					<td class="tc1"><?=self::inputText(array("id"=>"edit_direc$i","value"=>$dataDirecc[$i][1],"style"=>"width: 100%","readonly"=>$editar))?></td>
					<td class="tc1"><?=self::inputText(array("id"=>"edit_nmro$i","value"=>$dataDirecc[$i][2],"style"=>"width: 100%","readonly"=>$editar))?></td>
					<td class="tc1"><?=self::inputText(array("id"=>"edit_dpto$i","value"=>$dataDirecc[$i][3],"style"=>"width: 100%","readonly"=>$editar))?></td>
					<td class="tc1"><?=self::combobox("edit_tipo$i",self::$datoDB->selectTipoDireccion(),array("id"=>"edit_tipo$i","default"=>$dataDirecc[$i][7],"style"=>"width: 100%",$disabled=>$disabled))?></td>
					<td class="tc1"><?=self::combobox("edit_local$i",self::$datoDB->selectLocalidad(),array("id"=>"edit_local$i","default"=>$dataDirecc[$i][4],"style"=>"width: 100%",$disabled=>$disabled))?></td>
					<?=$button?>
					<td class="tc1" align="center"><a href="#" onClick="eliminaDireccion(<?=$dataDirecc[$i][0]?>,<?=$id_usuario?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
					<td class="tc1" align="center"><a href="#" onClick="editaDireccion(<?=$id_usuario?>,<?=$dataDirecc[$i][0]?>,1);"><img src="../../_img/editar.gif"></img></a></td>
				</tr>
		<?php }?>		
		</table>
		<div id="div_agrega_direccion"></div>
		<table width="100%">
			<tr>
				<td colspan="<?=$colspan?>"><div align='right'><a href='#' onClick='agregaDireccion(<?=$id_usuario?>);'><img src='../../img/mas.jpg'></a></div></td>
			</tr>
		</table>
	<?php }
	
	public function agregaDireccion($id_usuario){
?>
	<table>
		<tr>
			<td><?=self::inputText(array("id"=>"add_direc","style"=>"width: 135px"))?></td>
			<td><?=self::inputText(array("id"=>"add_num","style"=>"width: 130px"))?></td>
			<td><?=self::inputText(array("id"=>"add_depto","style"=>"width: 130px"))?></td>
			<td><?=self::combobox("add_tipo",self::$datoDB->selectTipoDireccion(),array("id"=>"add_tipo","style"=>"width: 80px"))?></td>
			<td><?=self::combobox("add_local",self::$datoDB->selectLocalidad(),array("id"=>"add_local","style"=>"width: 135px"))?></td>
			<td><?=self::inputButton(array("value"=>"Add","onclick"=>"addNuevaDireccion($id_usuario,document.getElementById('add_direc').value,document.getElementById('add_num').value,document.getElementById('add_depto').value,document.getElementById('add_tipo').value,document.getElementById('add_local').value);"))?></td>
			
		</tr>
	</table>
<?php
	}
	
	public function muestraEmail($id_usuario,$id_email = 0,$editar_email = 0){
		$dataEmail = self::$datoDB->selectEmail($id_usuario);
		
		$colspan = 4;
		if ($editar_email == 1){
			$tit = "<td class='tc2'>Grabar</td>";
			$colspan= 5;
		}
?>
<table width='100%'>
		<tr>
			<th class="ui-corner-all ui-widget-header" colspan="<?=$colspan?>" align="center">EMAILS</th>
		</tr>
		<tr>
			<td class="tc2">Correo</td>
			<td class="tc2">Tipo correo</td>
			<?=$tit?>
			<td class="tc2">Eliminar</td>
			<td class="tc2">Editar</td>
		</tr>
		<?php 
			$disabled = "disabled";
		for($i=0;$i<count($dataEmail);$i++){
			if($editar_email == 1){
					if($id_email == $dataEmail[$i][0]){
							$editar 	= false;
							$disabled	= '';
							$button		= "<td class='tc1' align='center'>".self::inputButton(array('value'=>'Grabar','style'=>'width: 50px',"onclick"=>"grabarEmail($id_email,document.getElementById('edit_email$i').value,document.getElementById('edit_tipo_email$i').value,$id_usuario);"))."</td>";
					}else{
							$editar 	= true;
							$disabled	= "disabled";
							$button		= "<td class='tc1' align='center'></td>";
					}
			}
		?>		
		<tr>
			<td class="tc1"><?=self::inputText(array("id"=>"edit_email$i","value"=>$dataEmail[$i][1],"style"=>"width: 100%","readonly"=>$editar))?></td>
			<td class="tc1"><?=self::combobox("edit_tipo_email$i",self::$datoDB->selectTipoCorreo(),array("id"=>"edit_tipo_email$i","default"=>$dataEmail[$i][2],"style"=>"width: 100%",$disabled=>$disabled))?></td>
			<?=$button?>
			<td class="tc1" align="center"><a href="#" onClick="eliminaEmail(<?=$dataEmail[$i][0]?>,<?=$id_usuario?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
			<td class="tc1" align="center"><a href="#" onClick="editaEmail(<?=$id_usuario?>,<?=$dataEmail[$i][0]?>,1);"><img src="../../_img/editar.gif"></img></a></td>
		</tr>
		<?php } ?>
	</table>
	<div id="div_agrega_email"></div>
	<table width="100%">
		<tr>
			<td colspan="<?=$colspan?>"><div align='right'><a href='#' onClick='agregaEmail(<?=$id_usuario?>);'><img src='../../img/mas.jpg'></a></div></td>
		</tr>
	</table>
<?php
	}

	public function agregaEmail($id_usuario){
		$maxCorreo   = self::$datoDB->selectMaxCorreoUs($id_usuario);
		$id_creacion = $maxCorreo[0][0] + 1;
?>
	<table width="100%">
		<tr>
			<td><?=self::inputText(array("id"=>"add_email","style"=>"width: 325px"))?>
			<?=self::combobox("add_tipo_email",self::$datoDB->selectTipoCorreo(),array("id"=>"add_tipo_email","style"=>"width: 200px"))?>
			<?=self::inputButton(array("value"=>"Add","onclick"=>"addNuevoEmail($id_usuario,document.getElementById('add_email').value,document.getElementById('add_tipo_email').value,$id_creacion);"))?></td>
		</tr>
	</table>
	
<?php
	}
	
	public function muestraFono($id_usuario,$id_fono = 0,$editar_fono = 0){
		$dataFono = self::$datoDB->selectFono($id_usuario);
	
		$colspan = 4;
		if ($editar_fono == 1){
			$tit = "<td class='tc2'>Grabar</td>";
			$colspan= 5;
		}
?>
	<table width='100%'>
		<tr>
			<th class="ui-corner-all ui-widget-header" colspan="<?=$colspan?>" align="center">TELEFONOS</th>
		</tr>
		<tr>
			<td class="tc2">Telefono</td>
			<td class="tc2">Tipo telefono</td>
			<?=$tit?>
			<td class="tc2">Eliminar</td>
			<td class="tc2">Editar</td>
		</tr>
		<?php 
			$disabled = "disabled";
		for($i=0;$i<count($dataFono);$i++){
			if($editar_fono == 1){
					if($id_fono == $dataFono[$i][0]){
							$editar 	= false;
							$disabled	= '';
							$button		= "<td class='tc1' align='center'>".self::inputButton(array('value'=>'Grabar','style'=>'width: 50px',"onclick"=>"grabarFono($id_fono,document.getElementById('edit_fono$i').value,document.getElementById('edit_tipo_fono$i').value,$id_usuario);"))."</td>";
					}else{
							$editar 	= true;
							$disabled	= "disabled";
							$button		= "<td class='tc1' align='center'></td>";
					}
			}
		?>
		<tr>
			<td class="tc1"><?=self::inputText(array("id"=>"edit_fono$i","value"=>$dataFono[$i][1],"style"=>"width: 100%","readonly"=>$editar))?></td>
			<td class="tc1"><?=self::combobox("edit_tipo_fono$i",self::$datoDB->selectTipoTelefono(),array("id"=>"edit_tipo_fono$i","default"=>$dataFono[$i][3],"style"=>"width: 100%",$disabled=>$disabled))?></td>
			<?=$button?>
			<td class="tc1" align="center"><a href="#" onClick="eliminaFono(<?=$dataFono[$i][0]?>,<?=$id_usuario?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
			<td class="tc1" align="center"><a href="#" onClick="editaFono(<?=$dataFono[$i][0]?>,<?=$id_usuario?>,1);"><img src="../../_img/editar.gif" ></img></a></td>
		</tr>
		<?php } ?>
	</table>
	<div id="div_agrega_Fono"></div>
	<table width="100%">
		<tr>
			<td colspan="<?=$colspan?>"><div align='right'><a href='#' onClick='agregaFono(<?=$id_usuario?>);'><img src='../../img/mas.jpg'></a></div></td>
		</tr>
	</table>
<?php	
	}

	public function agregaFono($id_usuario){
	$maxIdCreacion  = self::$datoDB->selectMaxIdCreFono($id_usuario);
	$id_creacion	= $maxIdCreacion[0][0]+1;
?>
	<table width="100%">
		<tr>
			<td><?=self::inputText(array("id"=>"add_fono","style"=>"width: 325px"))?>
			<?=self::combobox("add_tipo_fono",self::$datoDB->selectTipoTelefono(),array("id"=>"add_tipo_fono","style"=>"width: 200px"))?>
			<?=self::inputButton(array("value"=>"Add","onclick"=>"addNuevoFono($id_usuario,document.getElementById('add_fono').value,document.getElementById('add_tipo_fono').value,$id_creacion);"))?></td>
		</tr>
	</table>
	
<?php
	}

	public function AgregaComboboxExterno($tipo_usuario){
			return self::combobox("empresa_us",self::$datoDB->selectEmpresa($tipo_usuario),array("id"=>"empresa_us"));
	}

	public function areaFuncional(){
?>
<div align="center">
	<table align="center">
		<tr>
			<td colspan="2" class="ui-corner-all ui-widget-header" align="center">CREAR AREA</td>
			</tr>
		<tr>
			<td class="cuadrotexto">Nombre area</td>
			<td><?=self::inputText(array("id"=>"nom_area","maxlength"=>100))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Descripci&oacute;n</td>
			<td><?=self::inputTextArea(array("id"=>"desc_area","maxlength"=>200))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Responsable</td>
			<td><?=self::combobox("resp_area",self::$datoDB->selecResponsableArea(),array("id"=>"resp_area"))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Area padre</td>
			<td><?=self::combobox("area_padre",self::$datoDB->selectAreaFun(),array("id"=>"area_padre"))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Direcci&oacute;n</td>
			<td><?=self::combobox("dire_area",self::$datoDB->selectDireccionLaboral(),array("id"=>"dire_area"))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Tipo Area</td>
			<td><?=self::combobox("tipo_area",self::$datoDB->selectTipoAreaFun(),array("id"=>"tipo_area"))?></td>
		</tr>
			<tr>
				<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Crear","onclick"=>"agregaArea(document.getElementById('nom_area').value,
																												  document.getElementById('desc_area').value,
																												  document.getElementById('resp_area').value,
																												  document.getElementById('area_padre').value,
																												  document.getElementById('dire_area').value,
																												  document.getElementById('tipo_area').value);","style"=>"width: 100px"))?></td>
			</tr>
	</table>
</div>
<div id="grilla_areafun"><?=self::grillaAreaFun();?></div>
<?php
	}

/* Se cre� dos veces el mismo formulario ya que es un formulario chico, era
 * mas complejor editarlo sobre el mismo a crearlo denuevo */

public function editaAreaFuncional($id_area){
		$data = self::$datoDB->selectAreaFunGrilla($id_area);
?>
<div align="center">
	<table align="center">
		<tr>
			<td class="cuadrotexto">Nombre area</td>
			<td><?=self::inputText(array("id"=>"nom_area_edit","value"=>$data[0][1]))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Descripci&oacute;n</td>
			<td><?=self::inputTextArea(array("id"=>"desc_area_edit","value"=>$data[0][8]))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Responsable</td>
			<td><?=self::combobox("resp_area_edit",self::$datoDB->selecResponsableArea(),array("id"=>"resp_area_edit","default"=>$data[0][2]))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Area padre</td>
			<td><?=self::combobox("area_padre_edit",self::$datoDB->selectAreaFun(),array("id"=>"area_padre_edit","default"=>$data[0][5]))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Direcci&oacute;n</td>
			<td><?=self::combobox("dire_area_edit",self::$datoDB->selectDireccionLaboral(),array("id"=>"dire_area_edit","default"=>$data[0][6]))?></td>
		</tr>
		<tr>
			<td class="cuadrotexto">Tipo Area</td>
			<td><?=self::combobox("tipo_area_edit",self::$datoDB->selectTipoAreaFun(),array("id"=>"tipo_area_edit","default"=>$data[0][10]))?></td>
		</tr>
			<tr>
				<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Actualizar","onclick"=>"editaAreaFuncional(document.getElementById('nom_area_edit').value,
																												  	  		   document.getElementById('desc_area_edit').value,
																												  	  		   document.getElementById('resp_area_edit').value,
																												  	  		   document.getElementById('area_padre_edit').value,
																												  	  		   document.getElementById('dire_area_edit').value,$id_area,
																												  	  		   document.getElementById('tipo_area_edit').value);","style"=>"width: 100px"))?></td>
			</tr>
	</table>
</div>
<?php
	}

	public function grillaAreaFun(){
		$data = self::$datoDB->selectAreaFunGrilla();
?>
<div align="center" id="div_grilla_area_fun">
		<div style='width:90%;padding:10px;'>
						<table id='tabla_sol_3' cellpadding='0' cellspacing='0' border='0' align='center' class='display'  style='width: *%'>
							<thead>
								<tr>
									
									<th class='cabecera'>Id</th>
									<th class='cabecera'>Nombre</th>
									<th class='cabecera'>ID Responsable</th>
									<th class='cabecera'>Responsable</th>
									<th class='cabecera'>Id Area Padre</th>
									<th class='cabecera'>Area padre</th>
									<th class='cabecera'>Direcci&oacute;n</th>
									<th class='cabecera'>Tipo Area</th>
									<th class='cabecera' align="center">Elimina</th>
									<th  class='cabecera' align="center">Editar</th>
								</tr>
							</thead>
							<tbody>
							<?php for($i=0;$i<count($data);$i++){
									$row = $i+1;?>
								<tr>
									
									<td align="center"><?=$data[$i][0]?></td>
									<td align="center"><?=$data[$i][1]?></td>
									<td align="center"><?=$data[$i][2]?></td>
									<td align="center"><?=$data[$i][3]?></td>
									<td align="center"><?=$data[$i][5]?></td>
									<td align="center"><?=$data[$i][4]?></td>
									<td align="center"><?=$data[$i][7]?></td>
									<td align="center"><?=$data[$i][9]?></td>
									<td align="center"><a href="#" onClick="eliminaAreaFun(<?=$data[$i][0]?>);"><img src="../../_img/borrar_x.gif"></img></a></td>
									<td align="center"><a href="#" onClick="editaArea(<?=$data[$i][0]?>);"><img src="../../_img/editar.gif" alt="Edita usuario"></img></a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				<script type="text/javascript">tabla("tabla_sol_3",100);</script>
</div>
<?php
	}

	public function areaOrganizacional(){
?>
<div align="center">
	<table>
			<tr>
				<td colspan="2" class="ui-corner-all ui-widget-header" align="center">AGREGAR NUEVA AREA</td>
			</tr>
			<tr>
				<td class="cuadrotexto">Nombre Area</td>
				<td><?=self::inputText()?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Descripci&oacute;n</td>
				<td><?=self::inputTextArea()?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Ubicaci&oacute;n</td>
				<td><?=self::inputText()?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Direcci&oacute;n</td>
				<td><?=self::combobox("id_direc",self::$datoDB->selectDireccionLaboral(),array("id"=>"id_direc"))?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Area Superior</td>
				<td><?=self::inputText()?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Responsable</td>
				<td><?=self::combobox("")?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Empresa Vtr</td>
				<td><?=self::combobox("",self::$datoDB->selectEmpresa(1))?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Tipo Area</td>
				<td><?=self::combobox("")?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Zona contable</td>
				<td><?=self::combobox("")?></td>
			</tr>
			<tr>
				<td class="cuadrotexto">Centro Responsable</td>
				<td><?=self::combobox("")?></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><?=self::inputButton(array("value"=>"Crear","style"=>"width: 100px"))?></td>
			</tr>
	</table>
</div>
<?php
	}
	
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	/* ++++++++++++++++++++++++++++++++++++ BASE DE DATOS ++++++++++++++++++++++++++++++++++++*/
	/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

	public function eliminaAreaFun($id_areafun){
		self::$datoDB->deleteAreaFun($id_areafun);
		self::grillaAreaFun();
	}

	public function eliminaPerfil($id_perfil){
		self::$datoDB->deletePerfil($id_perfil);
		self::grillaPerfil();
	}

	public function actualizaPerfil($nombre,$desc,$web_ini,$dura_con,$id_perfil){
		self::$datoDB->updatePerfil($nombre,$desc,$web_ini,$dura_con,$id_perfil);
		self::grillaPerfil();
	}

	public function insertaPerfil($nombre,$desc,$web_ini,$dura_con){
		self::$datoDB->insertPerfil($nombre,$desc,$web_ini,$dura_con);
		
		self::grillaPerfil();
	}

	public function actualizaPassword($pass,$id_usuario){
		$passMD5 = md5($pass);
		self::$datoDB->updatePassword($passMD5,$id_usuario);
		self::usuarioView($id_usuario);
	}

	public function actualizaFoto($id_usuario,$nombre){
		
		$nombreEx = explode("|",$nombre);
		$pathFoto = "Fotos/".$nombreEx[0];
		self::$datoDB->updateFoto($id_usuario,$pathFoto);
		self::inicio(1,$id_usuario);
	}

	public function actualizaFotoUsuario($id_usuario,$nombre){
		
		$nombreEx = explode("|",$nombre);
		$pathFoto = "Fotos/".$nombreEx[0];
		self::$datoDB->updateFoto($id_usuario,$pathFoto);
		self::usuarioView($id_usuario);
	}

	public function actualizaTipoCargo($nombre,$desc,$id_cargo){
		self::$datoDB->updateTipoCargo($nombre,$desc,$id_cargo);
		self::grillaTipoCargo();
	}

	public function eliminaTipoCargo($id_cargo){
		self::$datoDB->deleteTipoCargo($id_cargo);
		self::grillaTipoCargo();
	}

	public function insertaTipoCargo($nombre,$desc){
		self::$datoDB->insertTipoCargo($nombre,$desc);
		echo "<script>alert('Tipo de Cargo creado con exito');</script>";
		self::grillaTipoCargo();
	}

	public function actualizaTipoAreaFun($nombre,$id_areafun){
		self::$datoDB->updateTipoAreaFun($nombre,$id_areafun);
		self::grillaTipoAreaFun();
	}

	public function eliminaTipoAreaFun($id_tipo_areafun){
		self::$datoDB->deleteTipoAreaFun($id_tipo_areafun);
		self::grillaTipoAreaFun();
	}

	public function insertaTipoAreaFun($nombre){
		self::$datoDB->insertTipoAreaFun($nombre);
		self::grillaTipoAreaFun();
	}

	public function actualizaTipoDireccLab($nombre,$desc,$id_direccion){
		self::$datoDB->updateTipoDireccLab($nombre,$desc,$id_direccion);
		self::grillaTipoDirecLab();
	}

	public function eliminaTipoDireccLab($id_direcc_lab){
		self::$datoDB->deleteTipoDireccLab($id_direcc_lab);
		self::grillaTipoDirecLab();
	}

	public function insertaTipoDireccLab($nombre,$desc){
		self::$datoDB->insertTipoDireccLab($nombre,$desc);
		self::grillaTipoDirecLab();
	}

	public function eliminaTipoDireccUs($id_direcc_us){
		self::$datoDB->deleteTipoDireccUs($id_direcc_us);
		self::grillaUsuarioDirec();
	}

	public function insertaTipoDireccUs($nombre){
		self::$datoDB->insertTipoDireccUs($nombre);
		self::grillaUsuarioDirec();
	}

	public function eliminaTipoRol($id_rol){
		self::$datoDB->deleteTipoRol($id_rol);
		self::grillaUsuarioRol();
	}

	public function insertaTipoRol($rol){
		self::$datoDB->insertTipoRol($rol);
		self::grillaUsuarioRol(); 
	}

	public function actualizoTipos($nombre,$id,$tipo){
		
		if($tipo == "usuario"){
			self::$datoDB->updateTipoUsuario($nombre,$id);
			self::grillaTipoUsuario();
		}
		if($tipo == "telefono"){
			self::$datoDB->updateTipoTel($nombre,$id);
			self::grillaUsuarioTel();
		}
		if($tipo == "correo"){
			self::$datoDB->updateTipoCorreo($nombre,$id);
			self::grillaUsuarioCorreo();
		}
		if($tipo == "rol"){
			self::$datoDB->updateTipoRol($nombre,$id);
			self::grillaUsuarioRol();
		}
		if($tipo == "direccion_usuario"){
			self::$datoDB->updateDireccUs($nombre,$id);
			self::grillaUsuarioDirec();
		}
	}
	
	public function eliminaTipoCorreo($id_correo){
		self::$datoDB->deleteTipoCorreo($id_correo);
		self::grillaUsuarioCorreo();
	}
	
	public function insertaTipoCorreo($nombre){
		self::$datoDB->insertTipoCorreo($nombre);
		self::grillaUsuarioCorreo();
	}
	
	public function eliminaTipoTel($id_tel){
		self::$datoDB->deleteTipoTel($id_tel);
		self::grillaUsuarioTel();
	} 
	
	public function insertaTipoTel($tipo_tel){
		self::$datoDB->insertTipoTel($tipo_tel);
		self::grillaUsuarioTel();
	}
	
	public function eliminaTipoUsuario($id_tipo){
		self::$datoDB->deleteTipoUsuario($id_tipo);
		self::grillaTipoUsuario();
	}
	
	public function insertaTipoUsuario($nuevoTipo){
		self::$datoDB->insertTipoUsuario($nuevoTipo);
		self::grillaTipoUsuario();
	}
	
	public function actualizaRespDireccion($nombre,$tipo,$zona,$comuna,$telefono,$emergen,$id_direc){
		self::$datoDB->updateRespDireccion($nombre,$tipo,$zona,$comuna,$telefono,$emergen,$id_direc);
		self::grillaDireccionLab();
	}

	public function insertaNuevoRespDirec($id_usuario,$id_direccion,$id_creacion){
		self::$datoDB->insertResponDirecc($id_direccion,$id_usuario,$id_creacion);
		self::direccionLaboral($id_direccion);
	}

	public function eliminaRespDireccion($id_usuario,$id_direccion){
		self::$datoDB->deleteRespDireccion($id_usuario,$id_direccion);
		self::direccionLaboral($id_direccion);
	}

	public function eliminaDireccionLaboral($id_direccion){
		self::$datoDB->deleteDireccionLaboral($id_direccion); //Solo desactiva la direccion no la elimina
		self::grillaDireccionLab();
	}

	public function insertaDireccionLaboral($nombre,$tipo,$zona,$localidad,$telefono,$emergencia,$arrRespon){

		/* Inserto la direccion*/
		self::$datoDB->insertDireccionLaboral($nombre,$tipo,$zona,$localidad,$telefono,$emergencia);
		/* Rescato la ultima direccion ingresada*/
		$maxDirec    = self::$datoDB->selectMaxDireccion();
		$ultimaDirec = $maxDirec[0][0];
		
		/* Inserto responsable de direcciones*/
		for($i=0;$i<count($arrRespon);$i++){
			self::$datoDB->insertResponDirecc($ultimaDirec,$arrRespon[$i],$i);
		}
		echo "<script>location.href='index.php';</script>";
	}
	
	public function actualizaEmpresa($rut_empresa,$razon_social,$fono,$direccion,$responsable,$tipo_empresa,$rut_empresa_where,$correo,$url){
		self::$datoDB->updateEmpresa($rut_empresa,$razon_social,$fono,$direccion,$responsable,$tipo_empresa,$rut_empresa_where,$correo,$url);
		self::grillaEmpresa();
	}

	public function eliminaEmpresa($rut_empresa){
		self::$datoDB->deleteEmpresa($rut_empresa);
		self::grillaEmpresa();
	}
	
	public function insertaEmpresa($rut_empresa,$razon_social,$fono,$direccion,$responsable,$tipo_empresa,$correo,$url){
		$data = self::$datoDB->selectEmpresaExiste($rut_empresa);
		
		if($data[0][0] == 0){
			self::$datoDB->insertEmpresa($rut_empresa,$razon_social,$fono,$direccion,$responsable,$tipo_empresa,$correo,$url);
		}else{
			echo "<script>alert('El rut ya es utilizado por otra empresa, verifique el rut ingresado');</script>";
			echo "<script>document.getElementById('rut_empresa').value = '';</script>";
		}
		self::grillaEmpresa();
	}
	
	public function actualizaCargo($nombre,$desc,$tipo,$id_cargo){
		self::$datoDB->updateCargo($nombre,$desc,$tipo,$id_cargo);
		self::grillaCargo();
	}

	public function eliminaCargo($id_cargo){
		self::$datoDB->deleteCargo($id_cargo);
		self::grillaCargo();
	}

	public function insertaCargo($nombre,$desc,$tipo){
		$id_creador = $_SESSION['user']['id'];
		self::$datoDB->insertCargo($nombre,$desc,$tipo,$id_creador);
		echo "<script>alert('Cargo creado con exito');</script>";
		self::grillaCargo();
	}

	public function actualizaAreaFun($nom_area,$desc_area,$resp_area,$area_padre,$dire_area,$id_area,$tipo_area){
		self::$datoDB->updateAreaFun($nom_area,$desc_area,$resp_area,$area_padre,$dire_area,$id_area,$tipo_area);
		self::grillaAreaFun();
	}

	public function insertaArea($nom_area,$desc_area,$resp_area,$area_padre,$dire_area,$tipo_area){
		$id_creador = $_SESSION['user']['id'];
		self::$datoDB->insertArea($nom_area,$desc_area,$resp_area,$area_padre,$dire_area,$id_creador,$tipo_area);
		self::grillaAreaFun();
	}

	public function actualizaUsuario($rut_us,$nombre_us,$apellido_us,$login_us,$fecha_nac,$sexo_us,$codigo_tecnico_us,$area_fun_us,$cargo_us,$dire_lab_us,$interno_no_us,$empresa_us,$fecha_ingreso_vtr,$nivel_apro_us,$perfil_us,$jefe_us,$estado_us,$id_usuario){
		$id_creador = $_SESSION['user']['id'];
		self::$datoDB->actualizaModificacion($id_usuario,$codigo_tecnico_us,$area_fun_us,$cargo_us,$dire_lab_us,$interno_no_us,$empresa_us,$fecha_ingreso_vtr,$nivel_apro_us,$perfil_us,$jefe_us,$estado_us,$id_creador); //ORG_USUARIO_EVENTO
		self::$datoDB->updateUsuario($rut_us,$nombre_us,$apellido_us,$fecha_nac,$sexo_us,$codigo_tecnico_us,$area_fun_us,$cargo_us,$dire_lab_us,$interno_no_us,$empresa_us,$fecha_ingreso_vtr,$nivel_apro_us,$perfil_us,$jefe_us,$estado_us,$id_usuario,$id_creador);
		self::$datoDB->updateLogin($login_us,$id_usuario);
		self::inicio(1,$id_usuario);
	}

	public function eliminaFoto($pathfoto,$id_usuario){
		self::$datoDB->eliminaFoto($id_usuario);
		unlink($pathfoto);
		self::inicio(1,$id_usuario);
	}

	public function eliminaFotoUsuario($pathfoto,$id_usuario){
		self::$datoDB->eliminaFoto($id_usuario);
		unlink($pathfoto);
		self::usuarioView($id_usuario);
	}

	public function insertaFonoUnico($id_usuario,$fono,$tipo,$id_creacion){
		self::$datoDB->insertFono($fono,$tipo,$id_usuario,$id_creacion);
		self::muestraFono($id_usuario);
	}

	public function insertaEmailUnico($id_usuario,$correo,$tipo_correo,$id_creacion){
		self::$datoDB->insertEmail($correo,$tipo_correo,$id_usuario,$id_creacion);
		self::muestraEmail($id_usuario);
	}

	public function insertaDirecionUnica($id_usuario,$direccion,$numero,$dpto,$tipo,$localidad){
		//marco
		$dato = self::$datoDB->selectMaxDireccionUsuario($id_usuario);
		if($dato[0][0] == ""){
			$max = 0;
		}else{
			$max = $dato[0][0] + 1;
		}
		self::$datoDB->insertDireccion($direccion,$numero,$dpto,$tipo,$localidad,$id_usuario,$max);
		self::muestraDireccion($id_usuario);
	}

	public function actualizaFono($id_fono,$fono,$tipo_fono,$id_usuario){
		self::$datoDB->updateFono($id_fono,$fono,$tipo_fono);
		self::muestraFono($id_usuario);
	}
	
	public function actualizaEmail($id_email,$email,$tipo_email,$id_usuario){
		self::$datoDB->updateEmail($id_email,$email,$tipo_email);
		self::muestraEmail($id_usuario);
	}
	
	public function actualizarDireccion($id_direccion,$direccion,$numero,$dpto,$tipo,$local,$id_usuario){
		self::$datoDB->UpdateDireccion($id_direccion,$direccion,$numero,$dpto,$tipo,$local);
		self::muestraDireccion($id_usuario);
	}
	
	public function eliminaFono($id_fono,$id_usuario){
		self::$datoDB->deleteFono($id_fono);
		self::muestraFono($id_usuario);
	}
	
	public function eliminaEmail($id_email,$id_usuario){
		self::$datoDB->deleteEmail($id_email);
		self::muestraEmail($id_usuario);
	}
	
	public function eliminaDireccion($id_direccion,$id_usuario){
		self::$datoDB->deleteDireccion($id_direccion);
		self::muestraDireccion($id_usuario);
	}
	
	public function insertaUsuario($rut,$nombre,$apellido,$fe_in_vtr,$pass_us,$sexo,$empresa,$cod_tec,$nivl_apr,$perfil,$jefe_us,$cargo,$area_fun,$fecha_n,$path_f,$id_crea,$estado_us,$tipo_us,$fileTmp,$direccion){
		
		if($path_f != ""){
			$path_foto = "Fotos/".date('d-m-Y his')."-".$path_f;
		}else{
			$path_foto = "Fotos/sin-imagen.jpg";
		}
		/* Iserto usuario */
		self::$datoDB->insertUsuario($rut,$nombre,$apellido,$fe_in_vtr,$pass_us,$sexo,$empresa,$cod_tec,$nivl_apr,$perfil,$jefe_us,$cargo,$area_fun,$fecha_n,$path_foto,$id_crea,$estado_us,$tipo_us,$direccion);
		/* Copio archivo al servidor*/
		move_uploaded_file($fileTmp,"./".$path_foto);		
	}
	
	/* Se puede hacer todas las funciones del igreso de usuario dentro de una misma funcion pero tendria que enviar
	* los arreglos uno por uno y asi no hago la llamada a selectIdUsuario tantas veces,
	* pero quedaria una funcion mas enrededada, con muchos for, como la query es peque�a
	* se prefirio llamar varias veces :D */

	public function insertaDireccion($direccion,$num_direc,$num_dpto,$tipo_direc,$local_direc,$i){
		
		/* Rescato el �ltimo usuario creado para rescatar ID*/
		$data 		= self::$datoDB->selectIdusuario();
		$id_usuario = $data[0][0];
		/* Inserto direcciones asociadas al ID del usuario*/
		self::$datoDB->insertDireccion($direccion,$num_direc,$num_dpto,$tipo_direc,$local_direc,$id_usuario,$i);
	}

	public function insertaEmail($email,$tipo_correo,$k){
		$data 		= self::$datoDB->selectIdusuario();
		$id_usuario = $data[0][0];
		self::$datoDB->insertEmail($email,$tipo_correo,$id_usuario,$k);
	}

	public function insertaFono($fono,$tipo_fono,$m){
		$data 		= self::$datoDB->selectIdusuario();
		$id_usuario = $data[0][0];
		
		self::$datoDB->insertFono($fono,$tipo_fono,$id_usuario,$m);
	}

	public function insertaLogin($login){
		
		/* Rescato el �ltimo usuario creado para rescatar ID */
		$data 		= self::$datoDB->selectIdusuario();
		$id_usuario = $data[0][0];
		$pass 		=  self::generatePassword();
		$pass_md5	= md5($pass);

		self::$datoDB->insertLogin($id_usuario,$login,$pass_md5);
		
		/* Luego de crear todos los campos e insertado el login rescato sus correos y le envio la pass*/
		$dataCorreo = self::$datoDB->selectCorreo($id_usuario);
		$dataLogin	= self::$datoDB->selectLogin($id_usuario);

		for($i=0;$i<count($dataCorreo);$i++){
			$remitente 		= "registro.nnoc@vtr.cl";
			$destinatario 	= $dataCorreo[$i][1];
			$asunto			= "Datos nnoc";
 			$mensaje		= "Estimados Se�or(a): ".$dataLogin[0][0]."<br><br>";
 			$mensaje 	   .= "- Se ha completado el registro exitosamente, los datos para el acceso a <a href='http://webnnoc.vtr.cl'>NNOC</a> son:<br><br>";
 			$mensaje 	   .= "<table>";
 			$mensaje 	   .= "<tr><td><b>Usuario:</b></td><td>".$dataLogin[0][1]."</td></tr>"; 
 			$mensaje 	   .= "<tr><td><b>contrase�a:</b></td><td>$pass</td></tr>";
 			$mensaje	   .= "</table>";
 			$mensaje	   .= "<br><br><br><br><br><br><br><br>";
 			$mensaje	   .= "<i>Este correo ha sido generado de manera automatica, no debe ser respondido</i>";
 			
			self::$datoDB->enviaCorreo($remitente,$destinatario,$asunto,$mensaje);
		}
	}

	public function tabsCargo(){
	?>		
		<div id='maintab_areaFun'>
				<ul>
					<li><a href='controller.php?mod=72'>Crear Cargo</a></li>
					<li><a href='controller.php?mod=73'>Tipo de Cargo</a></li>
				</ul>
			</div>
			<script type='text/javascript'>;
				tabs_jq('maintab_areaFun');
			</script>
	<?php		
		}
	
	public function tabsAreaFun(){
?>		
	<div id='maintab_areaFun'>
			<ul>
				<li><a href='controller.php?mod=67'>Crea Area</a></li>
				<li><a href='controller.php?mod=68'>Tipo de Area</a></li>
			</ul>
		</div>
		<script type='text/javascript'>;
			tabs_jq('maintab_areaFun');
		</script>
<?php		
	}
	
	public function tabsDireccLab(){
?>		
	<div id='maintab_direcLab'>
			<ul>
				<li><a href='controller.php?mod=63'>Crear Direcci&oacute;n</a></li>
				<li><a href='controller.php?mod=64'>Tipo de direcci&oacute;n</a></li>
			</ul>
		</div>
		<script type='text/javascript'>;
			tabs_jq('maintab_direcLab');
		</script>
<?php		
	}

	public function tabsUsuario(){
?>		
	<div id='maintab_usuario'>
			<ul>
				<li><a href='controller.php?mod=7'>Crear Usuario</a></li>
				<li><a href='controller.php?mod=8'>Ver usuarios</a></li>
				<li><a href='controller.php?mod=49'>Tipo de usuario</a></li>
			</ul>
		</div>
		<script type='text/javascript'>;
			tabs_jq('maintab_usuario');
		</script>
<?php		
	}

	public function tabs(){
?>
		<div id='maintab'>
			<ul>
				<li><a href='controller.php?mod=1'>Usuario</a></li>
				<li><a href='controller.php?mod=27'>Area Funcional</a></li>
				<li><a href='controller.php?mod=31'>Cargo</a></li>
				<li><a href='controller.php?mod=39'>Direccion</a></li>
				<li><a href='controller.php?mod=36'>Empresa</a></li>
				<!-- <li><a href='controller.php?mod=86'>Resumen</a></li>-->
			</ul>
		</div>
		<script type='text/javascript'>;
			tabs_jq('maintab');
		</script>
<?php						
	}
}
?>