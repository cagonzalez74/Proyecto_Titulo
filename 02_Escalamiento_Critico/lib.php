<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/_class/Meta.class.php');
include_once('database.php');

class clasFunciones extends Meta{

	static $db;

	public function  __construct(){
		parent::__construct();
		self::$db = new todoDB();
	}
	
	public function tabs(){
		$permiso = self::$db->permisoUsuarioReporte($_SESSION[user][id]);
	?>
		<div id='maintab'>
			<ul>
				<li><a href='controller.php?mod=pest_ingreso'>Ingreso Escalamiento Orden</a></li>
				<li><a href='controller.php?mod=pest_ver'>Ver Ordenes</a></li>
				<li><a href='controller.php?mod=pest_fin'>Ver Ordenes Pre-cerradas y Finalizadas</a></li>
				<? if ($permiso['TOTAL'][0] == 1){ ?>
				<li><a href='controller.php?mod=pest_list_ordenes'>Listado Ordenes</a></li>	
				<li><a href='controller.php?mod=pest_asig_ordenes'>Asignar Ordenes</a></li>
				<!-- <li><a href='controller.php?mod=pest_report'>Ver Reportes</a></li> -->
				<!-- <li><a href='controller.php?mod=mant_cav'>Mantenedor CAV</a></li>
				<li><a href='controller.php?mod=mant_sla'>Mantenedor SLA</a></li> -->
				<? } ?>
				
			</ul>
		</div>
		<script type='text/javascript'>;
			//var IntervalosOrd;
			//var IntervalosOrdR;
			tabs_jqAAA('maintab');
		</script>
	<?
	}

	public function adjuntarArchivoDocTipo(){
		?>
		<form name="formulario_archivo" method="post" target="_blank" enctype="multipart/form-data">
			<input type="file" id="file" name="file"></input>
			<input type="button" name="upload" value="Adjuntar" onclick="nuevafunc();"></input>
		</form>
		<div id="probando"></div>
		<?
	}

	public function adjuntarArchivoPDF(){
		?><form name="formulario_archivo" method="post" target="_blank" enctype="multipart/form-data">
			<input type="file" id="file" name="file"></input>
			<input type="button" name="upload" value="Adjuntar" onclick="uploadPDF();"></input>
		</form><?
	}

	public function adjuntarArchivoPDF_CAV(){
		?><form name="formulario_archivo" method="post" target="_blank" enctype="multipart/form-data">
			<input type="file" id="file" name="file"></input>
			<input type="button" name="upload" value="Adjuntar" onclick="uploadPDF_CAV();"></input>
		</form><?
	}

	public function guardaArchivoDoc($conn,$id_inf, $adjunto_doc, $usuario,$doc){

	}

	public function guardaArchivoDocTipo($conn,$nom_arch, $usuario, $id_inf, $link,$doc){

	}

	public function form_ingreso(){
	?>
		<form name="formulario1" id="formulario1">
				<div id="inicioPeticion">
					<h3><a href="#"><div align="left"><b>Ingrese Datos de Orden</b></div></a></h3>
					<div id="tabinicio">
					<table width="100%" >
	                	<tr>
	                        <td width='10%'><div class="titulo">Ingrese RUT de Cliente o Numero de escalamiento</div></td>
	                        <td width='20%'><?=self::inputText(array("name"=>"valor_orden","class"=>"ui-state-default"))?></td>
	                    </tr>
	                    <tr>
	                    	<td></td>
	                        <td><input type="button" name="buscar" value="Buscar" onclick="buscarOrden();" /></td>
	                    </tr>
                    </table>
					</div>
				</div>
				<div id="respuestaPeticion">
					<h3><a href="#"><div align="left"><b>Datos de Orden</b></div></a></h3>
					<div id="resp_orden"></div>
				</div>

				<div id="creaEscalamiento">
				<table width="100%" >
						<div align="left" id="resp_esc"></div>
						<div align="left" id="resp_esc2"></div>
				</table>	
				</div>
			
		</form>
		<div id="divEnviaMail"></div>
		<script type="text/javascript">
        $("#inicioPeticion").accordion({ collapsible: true,autoHeight: false   });
        $("#respuestaPeticion").accordion({ collapsible: true,autoHeight: false  });
	</script>		
	<?	
	}

	public function BuscarOrden($valor){
		$resp = self::$db->BuscarOrdenTango($valor);

		$pos = strpos($valor, "-");
		if ($pos === false) {
			if (count($resp)>1){
				self::MostrarOrdenesEsca($resp['ID_ESCALAMIENTO'][0]);
			} else {
				$fs = new HtmlFieldset();
				$lg = new HtmlLegend("Sin Informacion");
				$fs->add($lg);
				$p = new HtmlP("No Existen registros en la Base de Datos");
				$fs->add($p);
				echo $fs;
			}
		}else{
			$resp1 = self::$db->BuscarOrdenEscalada($valor);
			$resp2 = self::$db->BuscarClienteTango($valor);
			$resp4 = self::$db->DatosViviendaTango($valor);
			echo "<pre>";
			echo "</pre>";

			if( count($resp['ID_ESCALAMIENTO']) == 1 ){
				self::MostrarClienteTango($resp2,$resp4);
			}else{
				if ((count($resp['ID_ESCALAMIENTO']) == 0) && (count($resp2['RUT_PERSONA']) > 0)){
					self::MostrarClienteTango($resp2,$resp4);
				}else{	
					if( count($resp['ID_ESCALAMIENTO']) > 1 ){
						self::MostrarClienteTango($resp2,$resp4);
					}else{
						if( count($resp['ID_ESCALAMIENTO']) == 0 ){
							$fs = new HtmlFieldset();
							$lg = new HtmlLegend("Sin Informacion");
							$fs->add($lg);
							$p = new HtmlP("No Existen registros en la Base de Datos");
							$fs->add($p);
							echo $fs;
						}	
					}
				}	
			}
		}
}

	public function DetallarOrden($valor){
	$resp = self::$db->DetallarOrden($valor);
	?>
	
		<table width="100%" >
	    	<tr>
	    		<td width='20%'><div class="titulo">Numero Orden</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"norden", "value"=>$resp['NMRO_ORDEN'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Rut Cliente</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"rut", "value"=>$resp['RUT_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
		   	<tr>
	    		<td width='20%'><div class="titulo">Nombre Cliente</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"nombre", "value"=>$resp['NOMBRE_CLIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Direccion</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"direccion", "value"=>$resp['DIRECCION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
	    	<tr>
	    		<td width='20%'><div class="titulo">Localidad</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"localidad", "value"=>$resp['LOCALIDAD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Nodo</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"nodo", "value"=>$resp['NODO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
			<tr>
	    		<td width='20%'><div class="titulo">Fecha Ingreso</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"fingreso", "value"=>$resp['FECHA_INGRESO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Fecha Creacion</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"fcrea", "value"=>$resp['FECHA_CREACION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
			<tr>
	    		<td width='20%'><div class="titulo">Fecha Compromiso</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"fcompro", "value"=>$resp['FECHA_COMPROMISO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Area Funcional</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"area", "value"=>$resp['DESC_AREAFUN'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
			<tr>
	    		<td width='20%'><div class="titulo">Fecha Compromiso Orden</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"fech_comp_ord", "value"=>$resp['FECH_COMP_ORD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Numero Orden Tango</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"numero_orden_tango", "value"=>$resp['NUMERO_ORDEN_TANGO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>
			<tr>
				<td width='20%' valign='top'><div class="titulo">Tipo de Escalamiento</div></td>
	            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['TIPO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	    		<td width='20%'><div class="titulo">Motivo Escalamiento</div></td>
	            <td width='20%'><?=self::inputText(array("value"=>$resp['MOTIVO'][0], "readonly"=>"true"))?></td>
				<td></td>
				<td></td>		          
			</tr>
			<tr>
	    		<td width='20%' valign='top'><div class="titulo">Oservaciones Ingreso</div></td>
	            <td width='20%'><?=self::inputTextArea(array("name"=>"obserori", "value"=>$resp['OBSERVACION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Observacion</div></td>
	            <td width='20%'><?=self::inputTextArea(array("name"=>"observaciones","value"=>$resp['NUEVAOBSERVA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
			<tr>
	    		<td width='20%'></td>
	            <td width='20%' colspan="3"><div id="div_recuerda"></div></td>
			</tr>
			<tr>
	    		<td width='20%'><?=self::inputHidden(array("name"=>"codarea", "value"=>$resp['CODI_AREAFUN'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
	            <td width='20%'><?=self::inputHidden(array("name"=>"codhorario", "value"=>$resp['COD_HORARIO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
	            <td width='20%'></td>
			</tr>
		<script type="text/javascript">
		</script>	
		</table>	


    <?
	}
	
	public function MostrarOrdenes($valor){
		$resp = self::$db->BuscarOrdenTangoEstado($valor);		

		$resp5 = self::$db->qry_combomotivo();
		$resp6 = self::$db->qry_combotipo();	?>
		<div id="formMostrar">
		<h3><a href="#"><div align="left" style='color:red;font-size:11px;font-weight: bold'><b>Existe un escalamiento que se encuentra en estado <? echo $resp['ESTADO'][0] ?></b></div></a></h3>
		
		<table>
			<tr>
	    		<td width='20%'><div class="titulo">Numero Escalamiento</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"id_esca", "value"=>$resp['ID_ESCALAMIENTO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>
	    	<tr>
	    		<td width='20%'><div class="titulo">Numero Orden</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"norden_o", "value"=>$resp['NMRO_ORDEN'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Rut Cliente</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"rut_o", "value"=>$resp['RUT_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
		   	<tr>
	    		<td width='20%'><div class="titulo">Nombre Cliente</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"nombre_o", "value"=>$resp['NOMBRE_CLIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Direccion</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"direccion_o", "value"=>$resp['DIRECCION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
	    	<tr>
	    		<td width='20%'><div class="titulo">Localidad</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"localidad_o", "value"=>$resp['LOCALIDAD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Nodo</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"nodo_o", "value"=>$resp['NODO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
			<tr>
	    		<td width='20%'><div class="titulo">Fecha Ingreso</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"fingreso_o", "value"=>$resp['FECHA_INGRESO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	    		<td width='20%' ><div class="titulo">Observaciones Ingreso</div></td>
	            <td width='20%'><?=self::inputTextArea(array("name"=>"obserori_o", "value"=>$resp['OBSERVACION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>
			<tr>
	    		<td width='20%'><div class="titulo">Tipo Escalamiento</div></td>
	            <td width='20%'><?=self::combobox("combo_tipo_o",$resp6,array("onchange"=>""))?></td>
				<td width='20%'><div class="titulo">Ingrese Comentario</div></td>
	                    <td width='20%'><?=self::inputTextArea(array("name"=>"textComentario_o", "value"=>$resp['NUEVAOBSERVA'][0], "class"=>"ui-state-default"))?></td>
			</tr>

	        <tr><td width='20%'><div class="titulo">Servicios</div></td></tr>


			<tr></tr>
	        <td width='20%' margin= "10px"><input type="checkbox" id="check1o" name="check1o" value="1">TV
	        <td width='20%'><input type="checkbox" id="check2o" name="check2o" value="1">Premium
	        <td width='20%'><input type="checkbox" id="check3o" name="check3o" value="1">Telefono
	        <td width='20%'><input type="checkbox" id="check4o" name="check4o" value="1">Internet
	        <tr></tr>

			<tr>
			    <td width='20%'><div class="titulo">Motivo Escalamiento</div></td>
			            <td width='20%'><?=self::combobox("combo_motivoc_o",$resp5,array("onchange"=>""))?></td>
		<script type="text/javascript">
		if (<? echo $resp['SERVICIO_TV'][0] ?>==1) {
			document.getElementById("check1o").checked  = true;
		}		
		if (<? echo $resp['SERVICIO_PREMIUM'][0] ?>==1) {
			document.getElementById("check2o").checked  = true;
		}		
		if (<? echo $resp['SERVICIO_TELEFONO'][0] ?>==1) {
			document.getElementById("check3o").checked  = true;
		}		
		if (<? echo $resp['SERVICIO_INTERNET'][0] ?>==1) {
			document.getElementById("check4o").checked  = true;
		}
		if (<? echo $resp['MOTIVO_ESCALAMIENTO'][0] ?>!=null) {
	        document.getElementById("combo_motivoc_o").value  = <? echo $resp['MOTIVO_ESCALAMIENTO'][0] ?>;
		}
		if (<? echo $resp['TIPO_ESCALAMIENTO'][0] ?>!=null) {
			 document.getElementById("combo_tipo_o").value  = <? echo $resp['TIPO_ESCALAMIENTO'][0] ?>;
		}	       	        
		</script>	

			</tr>
				<tr><td width='20%'><div class="titulo">Correo electronico</div></td>
			    <td width='20%'><?=self::inputText(array("name"=>"correo_o", "value"=>$resp['CORREO_ELECTRONICO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>
			<tr>
	    		<td width='20%'></td>
	            <td width='20%' colspan="3"><div id="div_recuerda"></div></td>
			</tr>
			<tr>
	    		<td width='20%'><?=self::inputHidden(array("name"=>"codarea", "value"=>$resp['CODI_AREAFUN'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
	   
	   		 <tr>
	   		 <td width='20%'><input type="button" name="volver_pest" value="Volver" onclick="volver_pesta();" /></td>
	   		 </tr>
	            <td width='20%'><?=self::inputHidden(array("name"=>"codhorario", "value"=>$resp['CODI_HORARIO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
	            <td width='20%'></td>
			</tr>
		</table>	
			
</div>
<div id="divEnviaMail"></div>	
<div id="ventanita"></div>	
		<script type="text/javascript">
			$("#formMostrar").accordion({ collapsible: true,autoHeight: false   });
		</script>
    <?
	}

	public function MostrarOrdenesEsca($valor){
		$resp = self::$db->BuscarOrdenTangoEstadoEsca($valor);

		$resp5 = self::$db->qry_combomotivo();
		$resp6 = self::$db->qry_combotipo();	?>
		<div id="formMostrar">
		<h3><a href="#"><div align="left" style='color:red;font-size:11px;font-weight: bold'><b>Existe un escalamiento que se encuentra en estado <? echo $resp['ESTADO'][0] ?></b></div></a></h3>

		<table>
			<tr>
	    		<td width='20%'><div class="titulo">Numero Escalamiento</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"id_esca", "value"=>$resp['ID_ESCALAMIENTO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>
	    	<tr>
	    		<td width='20%'><div class="titulo">Numero Orden</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"norden_o", "value"=>$resp['NMRO_ORDEN'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Rut Cliente</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"rut_o", "value"=>$resp['RUT_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
		   	<tr>
	    		<td width='20%'><div class="titulo">Nombre Cliente</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"nombre_o", "value"=>$resp['NOMBRE_CLIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Direccion</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"direccion_o", "value"=>$resp['DIRECCION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
	    	<tr>
	    		<td width='20%'><div class="titulo">Localidad</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"localidad_o", "value"=>$resp['LOCALIDAD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	            <td width='20%'><div class="titulo">Nodo</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"nodo_o", "value"=>$resp['NODO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
			</tr>
			<tr>
	    		<td width='20%'><div class="titulo">Fecha Ingreso</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"fingreso_o", "value"=>$resp['FECHA_INGRESO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
	    		<td width='20%' ><div class="titulo">Observaciones Ingreso</div></td>
	            <td width='20%'><?=self::inputTextArea(array("name"=>"obserori_o", "value"=>$resp['OBSERVACION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>

			<tr>
	    		<td width='20%'><div class="titulo">Tipo Escalamiento</div></td>
	            <td width='20%'><?=self::combobox("combo_tipo_o",$resp6,array("onchange"=>""))?></td>
				<td width='20%'><div class="titulo">Ingrese Comentario</div></td>
	                    <td width='20%'><?=self::inputTextArea(array("name"=>"textComentario_o", "value"=>$resp['NUEVAOBSERVA'][0], "class"=>"ui-state-default"))?></td>
			</tr>

	        <tr><td width='20%'><div class="titulo">Servicios</div></td></tr>

			<tr></tr>
	        <td width='20%' margin= "10px"><input type="checkbox" id="check1o" name="check1o" value="1">TV
	        <td width='20%'><input type="checkbox" id="check2o" name="check2o" value="1">Premium
	        <td width='20%'><input type="checkbox" id="check3o" name="check3o" value="1">Telefono
	        <td width='20%'><input type="checkbox" id="check4o" name="check4o" value="1">Internet
	        <tr></tr>

			<tr>
			    <td width='20%'><div class="titulo">Motivo Escalamiento</div></td>
			            <td width='20%'><?=self::combobox("combo_motivoc_o",$resp5,array("onchange"=>""))?></td>

		<script type="text/javascript">
		if (<? echo $resp['SERVICIO_TV'][0] ?>==1) {
			document.getElementById("check1o").checked  = true;
		}		
		if (<? echo $resp['SERVICIO_PREMIUM'][0] ?>==1) {
			document.getElementById("check2o").checked  = true;
		}		
		if (<? echo $resp['SERVICIO_TELEFONO'][0] ?>==1) {
			document.getElementById("check3o").checked  = true;
		}		
		if (<? echo $resp['SERVICIO_INTERNET'][0] ?>==1) {
			document.getElementById("check4o").checked  = true;
		}
		if (<? echo $resp['MOTIVO_ESCALAMIENTO'][0] ?>!=null) {
	        document.getElementById("combo_motivoc_o").value  = <? echo $resp['MOTIVO_ESCALAMIENTO'][0] ?>;
		}
		if (<? echo $resp['TIPO_ESCALAMIENTO'][0] ?>!=null) {
			 document.getElementById("combo_tipo_o").value  = <? echo $resp['TIPO_ESCALAMIENTO'][0] ?>;
		}      
	        
		</script>	

			</tr>
				<tr><td width='20%'><div class="titulo">Correo electronico</div></td>
			    <td width='20%'><?=self::inputText(array("name"=>"correo_o", "value"=>$resp['CORREO_ELECTRONICO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>
			<tr>
	    		<td width='20%'></td>
	            <td width='20%' colspan="3"><div id="div_recuerda"></div></td>
			</tr>
			<tr>
	    		<td width='20%'><?=self::inputHidden(array("name"=>"codarea", "value"=>$resp['CODI_AREAFUN'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
	   
	   		 <tr><td width='20%'><input type="button" name="volver_pest" value="Volver" onclick="volver_pesta();" /></td>
	   		 </tr>
	            <td width='20%'><?=self::inputHidden(array("name"=>"codhorario", "value"=>$resp['CODI_HORARIO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
	            <td width='20%'></td>
			</tr>
		</table>	
			
</div>
<div id="divEnviaMail"></div>	
		<script type="text/javascript">
			$("#formMostrar").accordion({ collapsible: true,autoHeight: false   });
		</script>
    <?
	}


	public function MostrarClienteTango($resp2,$resp4){
	?>
		<table  >
	    	<tr>
	            <td width='20%'><div class="titulo">Rut Cliente</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"rut_per", "value"=>$resp2['RUT_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
	    		<td width='20%'><div class="titulo">Nombre Cliente</div></td>
	            <td width='20%'><?=self::inputText(array("name"=>"nombre", "value"=>$resp2['NOMBRE_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>

			<tr>
	    		<td width='20%'><div class="titulo">Domicilio</div></td>
	            <td width='20%'><?=self::combobox("combo_iden",$resp4,array("onchange"=>"buscarDatosCliente(this.value, rut_per.value)"))?></td>
	            <td width='20%'><div class="titulo"></div></td>
	            <td width='20%'><div class="titulo"></div></td>

			</tr>
		</table>			
    <?
	}


	public function buscarDatosCliente($iden, $rut){
		$respIden = self::$db->getDatosIdenTango($iden, $rut);
		
		if ((count($respIden['ID_ESCALAMIENTO'][0]) == 0) &&  ($iden!= NULL)){
			$resp3 = self::$db->ViviendaClienteTango($iden);
			$resp5 = self::$db->qry_combomotivo();
			$resp6 = self::$db->qry_combotipo();

		?>
		<div id="IngresarComentario_c">
						<h3><a href="#"><div align="left"><b>Datos adicionales</b></div></a></h3>
		<table >
			<tr>
		        <td width='20'><div class="titulo">Localidad</div></td>
		        <td width='20%'><?=self::inputText(array("name"=>"localidadc", "value"=>$resp3['LOCALIDAD'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>

		    	<td width='20%'><div class="titulo">Nodo</div></td>
		        <td width='20%'><?=self::inputText(array("name"=>"nodoc", "value"=>$resp3['NODO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
			</tr>
		           	           
			<tr>
		        <td width='20%'><div class="titulo">SubNodo</div></td>
		        <td width='20%'><?=self::inputText(array("name"=>"subnodoc", "value"=>$resp3['SUBNODO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>

		    	<td width='20%'><div class="titulo">Tipo</div></td>
		        <td width='20%'><?=self::combobox("combo_tipo",$resp6,array("onchange"=>""))?></td>
			</tr>
			
		        <tr><td width='20%'><div class="titulo">Servicios</div></td></tr>

				<tr></tr>

		        <td width='20%' margin= "10px"><input type="checkbox" id="check1" name="check1" value="1">TV
		        <td width='20%'><input type="checkbox" id="check2" name="check2" value="1">Premium
		        <td width='20%'><input type="checkbox" id="check3" name="check3" value="1">Telefono
		        <td width='20%'><input type="checkbox" id="check4" name="check4" value="1">Internet
		        <tr></tr>		    			    

		    <tr>
			    <td width='20%'><div class="titulo">Motivo Escalamiento</div></td>
			    <td width='20%'><?=self::combobox("combo_motivoc",$resp5,array("onchange"=>""))?></td>
			    <td width='20%'><div class="titulo">Fecha Compromiso Orden</div></td>
			    <td width='20%'>
			    	<?= $this->inputFecha('fech_comp_ord',array("value"=>date('d/m/Y'))) ?><?= self::comboHora(array("name"=>"horas_comp_ord","default"=>$hora_ini[0],"style"=>"width:40px","first_option"=>false))?><?= self::comboMinuto(array("name"=>"minutos_comp_ord","default"=>$hora_ini[1],"style"=>"width:40px","first_option"=>false))?>
			    </td>
			</tr>
			<tr>
			    <td width='20%'><div class="titulo">N° Orden Tango</div></td>
			    <td width='20%'><?=self::inputText(array("name"=>"numero_orden_tango", "style"=>"width:80px", "value"=>"","class"=>"ui-state-default"))?></td>
			    <td width='20%'><div class="titulo">&nbsp;</div></td>
			    <td width='20%'>&nbsp;</td>
			</tr>
			<tr><td width='20%'><div class="titulo">Correo electronico</div></td>
		    <td width='20%'><?=self::inputText(array("name"=>"correoc", "value"=>"","class"=>"ui-state-default", "readonly"=>"true"))?></td>	

		    <td><input type="button" name="adjuntarc" value="Adjuntar" onclick="ventanita2();" /></td>
			</tr>
				<td width='20%'><div class="titulo">Ingrese Comentario</div></td>
                <td width='20%'><?=self::inputTextArea(array("name"=>"textComentario_c","class"=>"ui-state-default"))?></td>
                <tr><td width='20%'><input type="button" name="IngresaEscalamiento_c" value="Ingresar" onclick="IngresaEscalamiento();" /></td></tr>
			</div>
			</form>
			<script type="text/javascript">
		        $("#IngresarComentario_c").accordion({ collapsible: true,autoHeight: false   });
			</script>

		</table>	
	    <?
		}else{ 
			if ($iden!= NULL) {
				self::MostrarOrdenes($respIden['ID_ESCALAMIENTO'][0]);
			}
		}
	}

	public function guardar_escalamiento() {
			$resp = self::$db->GuardarEscalamiento($_GET['RUTP'], $_GET['NOMB'], $_GET['DIRE'], $_GET['LOCA'], $_GET['NODO'], $_GET['TI_ESC'], $_GET['OBSN'], $_GET['SER_TV'], $_GET['SER_PRE'], $_GET['SER_FONO'], $_GET['SER_INET'], $_GET['MOTI_ESC'], $_GET['MOTIVO_DESC'], $_GET['FECH_COMP_ORD']);	
			echo $resp['codigo'];
	}	

	public function guardar_escalamientoNuevo() {
			$resp = self::$db->GuardarEscalamientoNuevo($_GET['RUTP'], $_GET['NOMB'], $_GET['DIRE'], $_GET['LOCA'], $_GET['NODO'], $_GET['TI_ESC'], $_GET['OBSN'], $_GET['SER_TV'], $_GET['SER_PRE'], $_GET['SER_FONO'], $_GET['SER_INET'], $_GET['MOTI_ESC'], $_GET['MOTIVO_DESC'], $_GET['CORREO'], $_GET['FECH_COMP_ORD'], $_GET['HORAS_COMP_ORD'], $_GET['MINUTOS_COMP_ORD'], $_GET['NUMERO_ORDEN_TANGO']);		
			$id_escalamiento = self::$db->getMaxIdEscalamiento();
			self::$db->addBitacoraFechCompOrd($id_escalamiento['ID_ESCALAMIENTO'][0], $_GET['FECH_COMP_ORD'], $_GET['HORAS_COMP_ORD'], $_GET['MINUTOS_COMP_ORD']);
			self::$db->guarda_correo($_GET['CORREO']);
			echo $resp['codigo'];
	}

	public function guardar_escalamientoOrden() {
			$params = self::$db->ParamsGuardarEscalamientoOrden($_GET['NORDEN']);
			$resp = self::$db->GuardarEscalamientoOrden($_GET['RUTP'], $_GET['NOMB'], $_GET['DIRE'], $_GET['LOCA'], $_GET['NODO'], $_GET['TI_ESC'], $_GET['OBSN'], $_GET['SER_TV'], $_GET['SER_PRE'], $_GET['SER_FONO'], $_GET['SER_INET'], $_GET['MOTI_ESC'], $_GET['NORDEN'], $_GET['FINGRESO'], $_GET['OBSERORI'], $_GET['MOTIVO_DESC'], $params['FECHA_COMPROMISO'][0], $params['COD_HORARIO'][0]);	
			echo $resp['codigo'];
	}
	
	public function AsignaEscalamiento($valor) {
			$resp = self::$db->AsignaEscalamiento($_GET['valor']);	
			echo $resp['codigo'];
	}



	public function GuardarOrden($norden, $rut, $nombre, $direccion, $localidad, $nodo, $fingreso, $fcrea, $fcompro, $area, $obserori, $codarea,$motivo, $obs, $activ, $codhorario){
		$resp = self::$db->GuardarOrden($norden, $rut, $nombre, $direccion, $localidad, $nodo, $fingreso, $fcrea, $fcompro, $area, $obserori, $codarea,$motivo, $obs, $activ, $codhorario);
		echo $resp['codigo'];
	}
	
	public function VerOrdenes($escala, $terr, $reg, $localidad, $fechaDesde, $fechaHasta){
		$desde = ( $fechaDesde != '' ) ? $fechaDesde : date('d/m/Y', strtotime("-365 day"));
		$hasta = ( $fechaHasta != '' ) ? $fechaHasta : date('d/m/Y');
		
		if( $escala == 'undefined' ) $escala = '';
		$permiso = self::$db->permisoUsuario($_SESSION[user][id]);
		$asig = self::$db->BuscarOrdenAsig($escala, $terr, $reg, $localidad, $fechaDesde, $fechaHasta);	
		$pend = self::$db->BuscarOrdenPend($escala, $terr, $reg, $localidad, $fechaDesde, $fechaHasta);	
		$ejec = self::$db->BuscarOrdenEjec($escala, $terr, $reg, $localidad, $fechaDesde, $fechaHasta);
		$precer = self::$db->BuscarOrdenPrecer($escala, $terr, $reg, $localidad, $fechaDesde, $fechaHasta);
		$fina = self::$db->BuscarOrdenFina($escala, $terr, $reg, $localidad, $fechaDesde, $fechaHasta);

		for ($i=0; $i < count($asig['ID_ESCALAMIENTO']); $i++) { 
			$temp = $asig['ID_ESCALAMIENTO'][$i];
				
			$conta = self::$db->buscarReescalados($temp);

			$minutos = $asig['SEMAFORO'][$i] % 60;
			$horas =   round(($asig['SEMAFORO'][$i]-$minutos) / 60);

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}

				if ($conta[0][0] >= 2)  {
					$asig['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' style='background-color:red' onClick='comentaOrden(".$asig['ID_ESCALAMIENTO'][$i].")'>".$asig['ID_ESCALAMIENTO'][$i]."</a>";
				} else {
					$asig['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' onClick='comentaOrden(".$asig['ID_ESCALAMIENTO'][$i].")'>".$asig['ID_ESCALAMIENTO'][$i]."</a>";
				}
			
				if ($tempHoras <= 48 ) {
					$asig['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {
					if (($tempHoras >= 49 ) && ($tempHoras <= 71 )) {
					$asig['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					} else {	
						if ($tempHoras >= 72 ) {
							$asig['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
						}	
					} 
				}
			}


		for ($i=0; $i < count($pend['ID_ESCALAMIENTO']); $i++) { 
			$minutos = $pend['SEMAFORO'][$i] % 60;
			$horas =   round(($pend['SEMAFORO'][$i]-$minutos) / 60);

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}


			$pend['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' onClick='DetalleOrden(".$pend['ID_ESCALAMIENTO'][$i].")'>".$pend['ID_ESCALAMIENTO'][$i]."</a>";
			if ($pend['SEMAFORO'][$i] <= 30 ) {
				$pend['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
			} else {
				if (($pend['SEMAFORO'][$i] >= 31 ) && ($pend['SEMAFORO'][$i] <= 60 )) {
				$pend['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {	
					if ($pend['SEMAFORO'][$i] >= 61 ) {
						$pend['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					}	
				} 
			}
		}

		
		for ($i=0; $i < count($ejec['ID_ESCALAMIENTO']); $i++) { 
			
			$minutos = $ejec['SEMAFORO'][$i] % 60;
			$horas =   round(($ejec['SEMAFORO'][$i]-$minutos) / 60);

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}

			$ejec['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' onClick='comentaOrden(".$ejec['ID_ESCALAMIENTO'][$i].")'>".$ejec['ID_ESCALAMIENTO'][$i]."</a>";		

			if ($tempHoras <= 48 ) {
				$ejec['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
			} else {
				if (($tempHoras >= 49 ) && ($tempHoras <= 71 )) {
				$ejec['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {	
					if ($tempHoras >= 72 ) {
						$ejec['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					}	
				} 
			}
		}


		for ($i=0; $i < count($precer['ID_ESCALAMIENTO']); $i++) { 

			$minutos = $precer['SEMAFORO'][$i] % 60;
			$horas =   round(($precer['SEMAFORO'][$i]-$minutos) / 60);

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}

			$precer['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' onClick='verOrdenMortem(".$precer['ID_ESCALAMIENTO'][$i].")'>".$precer['ID_ESCALAMIENTO'][$i]."</a>";
			$precer['Semaforo'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$precer['Semaforo'][$i].'</label>';	

			if ($tempHoras <= 48 ) {
				$precer['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
			} else {
				if (($tempHoras >= 49 ) && ($tempHoras <= 71 )) {
				$precer['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {	
					if ($tempHoras >= 72 ) {
						$precer['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					}	
				} 
			}
		}


		for ($i=0; $i < count($fina['ID_ESCALAMIENTO']); $i++) { 

			$minutos = $fina['SEMAFORO'][$i] % 60;
			$horas =   round(($fina['SEMAFORO'][$i]-$minutos) / 60);

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}

			$fina['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' onClick='verOrden(".$fina['ID_ESCALAMIENTO'][$i].")'>".$fina['ID_ESCALAMIENTO'][$i]."</a>";	

			if ($tempHoras <= 48 ) {
				$fina['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
			} else {
				if (($tempHoras >= 49 ) && ($tempHoras <= 71 )) {
				$fina['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {	
					if ($tempHoras >= 72 ) {
						$fina['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					}	
				} 
			}
		}


		$tabla = array( "firstColumnId"=>true, "showFirstColumn"=>true, "style"=>"width:100%" );
		$params["tr"] = array("onMouseOver"=>"$(this).addClass('ui-state-active')", "onMouseOut"=>"$(this).removeClass('ui-state-active')","onClick"=>"");
		$params['td'] = $td; 
		$params['tabla'] = $tabla;

		
		$tabla1 = array( "firstColumnId"=>true, "showFirstColumn"=>true, "style"=>"width:100%", "tipoOrden"=>"desc" );
		$params1["tr"] = array("onMouseOver"=>"$(this).addClass('ui-state-active')", "onMouseOut"=>"$(this).removeClass('ui-state-active')","onClick"=>"");
		$params1['td'] = $td; 
		$params1['tabla'] = $tabla1;
		
		$tabla2 = array( "firstColumnId"=>true, "showFirstColumn"=>true, "style"=>"width:100%" );

		$params2["tr"] = array("onMouseOver"=>"$(this).addClass('ui-state-active')", "onMouseOut"=>"$(this).removeClass('ui-state-active')","onClick"=>"");

		$params2["tr"] = array("onMouseOver"=>"$(this).addClass('ui-state-active')", "onMouseOut"=>"$(this).removeClass('ui-state-active')","onClick"=>"");
		$params2['td'] = $td; 
		$params2['tabla'] = $tabla2;
		$rand = rand();
	?>
	<div id="modal_servicio"></div>
	<div id="div_enviaMail"></div>
		<form name="formulario4" id="formulario4">
				<div id="Filtros">
					<h3><a href="#"><div align="left"><b>Filtros</b></div></a></h3>
					<div>
						<table>
							<tr>
								<td width='30%'>Ingrese Territorio:</td>
								<td width='20%'>Ingrese Comuna:</td>
							<? if ($permiso['TOTAL'][0] != 1){ ?>
								<!-- <td width='20%'>Ingrese Area:</td> -->
							<? } ?>		
							</tr>
							<tr>
								<td><div id="div_territorio"><?=self::multiple2(self::$db->getTerritorio(),array( "name"=>"territorio", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selTerritorio();", "default"=>$terr ))?></div></td>
								<td><div id="div_comuna"><?=self::multiple2(self::$db->getComuna($terr, $reg),array( "name"=>"comuna", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selLocalidad();", "default"=>$localidad ))?></div></td>
							<? if ($permiso['TOTAL'][0] != 1){ ?>
								<!-- <td><div id="div_area"><?=self::multiple2(self::$db->getEscalamientos(),array( "name"=>"escalamientos", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selEscala();", "default"=>$escala ))?></div></td> -->
							<? } ?>	
							</tr>
							<tr><td><br /></td></tr>
							<? if ($permiso['TOTAL'][0] != 1){ ?>
							<tr>
								<td width='30%'>Seleccione Rango de Fecha:</td>	
								<td>
									<?php echo parent::inputFecha("fechaDesde", array("onChange"=>"javascript:selFecha();", "value"=>$desde ))?>
									<?php echo parent::inputFecha("fechaHasta", array("onChange"=>"javascript:selFecha();", "value"=>$hasta ))?>
								</td>
							</tr>
							<? } ?>
						</table>
					</div>		
				</div>
				<div id="OrdenesAsignadas">
					<h3><a href="#"><div align="left"><b>Ver Ordenes Asignadas al Usuario</b></div></a></h3>
					<div id="asig_orden"><?=parent::listaHtml($asig, $params)?></div>
				</div>
				<div id="OrdenesPendientes">
					<h3><a href="#"><div align="left"><b>Ordenes Pendientes</b></div></a></h3>
					<div id="pend_orden"><?=parent::listaHtml($pend, $params2)?></div>
				</div>
				<div id="OrdenesEjecucion">
					<h3><a href="#"><div align="left"><b>Ordenes en Ejecucion</b></div></a></h3>
					<div id="ejec_orden"><?=parent::listaHtml($ejec, $params)?></div>
				</div>
				<div id="OrdenesPrecerradas">
					<h3><a href="#"><div align="left"><b>Ordenes Pre-cerradas</b></div></a></h3>
					<div id="precer_orden"><?=parent::listaHtml($precer, $params2)?></div>
				</div>
				<div id="OrdenesFinalizadas">
					<h3><a href="#"><div align="left"><b>Ordenes Finalizadas</b></div></a></h3>
					<div id="fina_orden"><?=parent::listaHtml($fina, $params1)?></div>
				</div>
		</form>		
		
		<script type="text/javascript">
			$("#Filtros").accordion({ collapsible: true,autoHeight: false   });
	        $("#OrdenesAsignadas").accordion({ collapsible: true,autoHeight: false   });
	        $("#OrdenesPendientes").accordion({ collapsible: true,autoHeight: false   });
	        $("#OrdenesEjecucion").accordion({ collapsible: true,autoHeight: false   });
	        $("#OrdenesPrecerradas").accordion({ collapsible: true,autoHeight: false   });
	        $("#OrdenesFinalizadas").accordion({ collapsible: true,autoHeight: false   });
		</script>		
	<?	
	}	

	public function AsignarOrden($valor){
		$resp = self::$db->AsignarOrden($valor);
		echo $resp['codigo'];
	}
	
	public function form_ComentaOrden($valor){
		$permiso = self::$db->PermisoOrden($valor);
		$permisoNombre = self::$db->getDatosMail($valor);
		$coment = self::$db->getComentarios($valor);
		$bitacora = self::$db->getBitacoraFechCompOrd( $valor );

		$resp = self::$db->getOrdenEjecPrecer($valor);
		list( $fech_comp_ord, $hora_com_comp_ord ) = explode( ' ', $resp['FECH_COMP_ORD'][0] );
		list( $hora_comp_ord, $minutos_comp_ord, $segundo_comp_ord ) = explode( ':', $hora_com_comp_ord ); 

	?>
		<form name="formulario3" id="formulario3">

				<div id="div_VerOrden">
					<h3><a href="#"><div align="left"><b>Datos de la Orden</b></div></a></h3>
					<div id="com_orden">
						<table width="100%" >
					    	<tr>
					    		<td width='20%'><div class="titulo">Numero Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"norden", "value"=>$resp['ID_ESCALAMIENTO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Rut Cliente</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"rut", "value"=>$resp['RUT_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
						   	<tr>
					    		<td width='20%'><div class="titulo">Nombre Cliente</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"nombre", "value"=>$resp['NOMBRE_CLIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Direccion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"direccion", "value"=>$resp['DIRECCION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
					    	<tr>
					    		<td width='20%'><div class="titulo">Localidad</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"localidad", "value"=>$resp['LOCALIDAD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Nodo</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"nodo", "value"=>$resp['NODO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
					    		<td width='20%'><div class="titulo">Fecha Ingreso</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fingreso", "value"=>$resp['FECHA_INGRESO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Fecha Creacion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fcrea", "value"=>$resp['FECHA_CREACION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
					    		<td width='20%'><div class="titulo">Fecha Compromiso</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fcompro", "value"=>$resp['FECHA_COMPROMISO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Tipo de Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"area", "value"=>$resp['TIPO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Motivo de Escalamiento</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['MOTIVO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Creador Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['CREADOR'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Asignado A</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['ASIGNADO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fecha Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['FECHA_PENDIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fecha Ejecucion</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['FECHA_EJECUCION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fecha Finalizacion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['FECHA_FINALIZADA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fecha Compromiso Orden</div></td>
					            <td width='20%' valign='top'>
					            	<?= $this->inputFecha('fech_comp_ord',array("value"=>$fech_comp_ord)) ?><?= self::comboHora(array("name"=>"horas_comp_ord","default"=>$hora_comp_ord,"style"=>"width:40px","first_option"=>false))?><?= self::comboMinuto(array("name"=>"minutos_comp_ord","default"=>$minutos_comp_ord,"style"=>"width:40px","first_option"=>false))?>
					            </td>
					    		<td width='20%' valign='top'><div class="titulo">Numero Orden Tango</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"numero_orden_tango", "value"=>$resp['NUMERO_ORDEN_TANGO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Observacion</div></td>
					            <td width='20%' valign='top'><?=self::inputTextArea(array("name"=>"activ", "value"=>$resp['OBSERVACION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Observacion Escalamiento</div></td>
					            <td width='20%'><?=self::inputTextArea(array("name"=>"obserori", "value"=>$resp['NUEVAOBSERVA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
						</table>
	                </div>
				</div>		
				<? if (($resp['POST_MORTEM'][0] <> '') && ($resp['NUEVAOBSERVA'][0] <> '')) {?>
				<div id="PostMortem">
					<h3><a href="#"><div align="left"><b>Datos de finalizacion</b></div></a></h3>
					<div id="post_orden">
						<tr>
							<td width='10%'><div class="titulo">Post Mortem</div></td>
		                    <td width='20%'><?=self::inputTextArea(array("rows"=>10,"style"=>"width:700px;align:left;","value"=>$resp['POST_MORTEM'][0],"name"=>"postMortem","class"=>"ui-state-default","readonly"=>"true"))?></td>
						</tr>
						<tr>
							<td width='10%'><div class="titulo">Acciones preventivas</div></td>
		                    <td width='20%'><?=self::inputTextArea(array("rows"=>10,"style"=>"width:700px;align:left;","name"=>"finalizaComentario","value"=>$resp['NUEVAOBSERVA'][0],"class"=>"ui-state-default","readonly"=>"true"))?></td>
		                </tr>
	                </div>
				</div>
				<script type="text/javascript">
		 			$("#PostMortem").accordion({ collapsible: true,autoHeight: false   });
				</script>
				<? } ?>

				<div id="IngresarComentario">
					<h3><a href="#"><div align="left"><b>Comentario en Ejecucion</b></div></a></h3>
					<div id="com_orden">
						<td width='10%'><div class="titulo">Ingrese Comentario</div></td>
	                    <td width='20%'><?=self::inputTextArea(array("name"=>"ingresaComentario","class"=>"ui-state-default"))?></td>
	                    <tr><td width='20%'><input type="button" name="comentaOrden" value="Ingresar" onclick="comentarioOrden(<?=$valor?>);" /></td></tr>
	                </div>
				</div>

				<div id="VerComentarios">
					<h3><a href="#"><div align="left"><b>Ver Comentarios Anteriores</b></div></a></h3>
					<div id="ver_orden"><?=parent::listaHtml($coment, $params)?></div>
				</div>
				
				<div id="VerBitacora">
					<h3><a href="#"><div align="left"><b>Ver Bitacora</b></div></a></h3>
					<div id="ver_orden"><?=parent::listaHtml($bitacora, $params)?></div>
				</div>
				<? 
				if($permiso['ID_ASIGNADO'][0]=='15454'){ $permiso['ID_ASIGNADO'][0]='13201';} // '41852';
				if ($permiso['ID_ASIGNADO'][0] == $_SESSION[user][id]){ ?>
				<div id="FinalizarOrden">
					<h3><a href="#"><div align="left"><b>Finalizar Orden</b></div></a></h3>
					<div id="fin_orden">
						<tr>
							<td width='20%'><div class="titulo">Adjuntar PDF</div></td>
						    <td width='20%'><?=self::inputText(array("name"=>"archivoPDFtext", "value"=>"","class"=>"ui-state-default", "readonly"=>"true"))?></td>	
						    <td><input type="button" name="adjuntarpdf" value="Adjuntar" onclick="ventanita1();" /></td>
						</tr>
						<tr>
							<td width='10%'><div class="titulo">Ingrese Post Mortem</div></td>
		                    <td width='20%'><?=self::inputTextArea(array("rows"=>10,"style"=>"width:700px;align:left;","name"=>"postMortem","class"=>"ui-state-default"))?></td>
						</tr>
						<tr>
							<td width='10%'><div class="titulo">Ingrese acciones preventivas</div></td>
		                    <td width='20%'><?=self::inputTextArea(array("rows"=>10,"style"=>"width:700px;align:left;","name"=>"finalizaComentario","class"=>"ui-state-default"))?></td>
		                </tr>
		                <tr>
		                <br>
		                    <td width='20%'><input type="button" name="finalizaOrden" value="Finalizar" onclick="finalOrden(<?=$valor?>);" /></td>
		                </tr>
	                </div>
				</div>
				<?}else{?>
					<div id="FinalizarOrden">
					<h3><a href="#"><div align="left"><b>No tiene Autorizacion para cerrar la Orden. Solo el Usuario <?=$permisoNombre['ASIGNADO'][0]?> puede cerrarla.</b></div></a></h3>
				</div>	
				<? } ?>
			<div id="modal_servicio"></div>
		</form>
		<script type="text/javascript">
		 	$("#div_VerOrden").accordion({ collapsible: true,autoHeight: false   });
	        $("#FinalizarOrden").accordion({ collapsible: true,autoHeight: false   });
	        $("#IngresarComentario").accordion({ collapsible: true,autoHeight: false   });
	        $("#VerComentarios").accordion({ collapsible: true,autoHeight: false   });
	        $("#VerBitacora").accordion({ collapsible: true,autoHeight: false   });
		</script>
	<? 
	}

	public function form_ComentaOrdenPrecer($valor){
		$permiso = self::$db->PermisoOrden($valor);
		$permisoNombre = self::$db->getDatosMail($valor);
		$coment = self::$db->getComentarios($valor);
		$bitacora = self::$db->getBitacoraFechCompOrd( $valor );

		$post_acciones = self::$db->getPostAcciones($valor);
		$resp = self::$db->getOrdenEjecPrecer($valor);
		$telefonos = self::$db->getFonoContacto($resp['RUT_PERSONA'][0]);
		list( $fech_comp_ord, $hora_completa_comp_ord ) = explode( ' ', $resp['FECH_COMP_ORD'][0] );
		list( $horas_comp_ord, $minutos_comp_ord, $segundos_comp_ord ) = explode( ':', $hora_completa_comp_ord );

		$tabla = array( "paginacion"=>"10", "fecha_ejecucion"=>"desc");
		$params2['tabla'] = $tabla;

	?>
<div id="modal_servicio">
		<form name="formulario3" id="formulario3">

				<div id="div_VerOrden">
					<h3><a href="#"><div align="left"><b>Datos de la Orden</b></div></a></h3>
					<div id="com_orden">
						<table width="100%" >
					    	<tr>
					    		<td width='20%'><div class="titulo">Numero Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"norden", "value"=>$resp['ID_ESCALAMIENTO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Rut Cliente</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"rut", "value"=>$resp['RUT_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
						   	<tr>
					    		<td width='20%'><div class="titulo">Nombre Cliente</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"nombre", "value"=>$resp['NOMBRE_CLIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Direccion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"direccion", "value"=>$resp['DIRECCION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
					    	<tr>
					    		<td width='20%'><div class="titulo">Localidad</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"localidad", "value"=>$resp['LOCALIDAD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Nodo</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"nodo", "value"=>$resp['NODO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
					    		<td width='20%'><div class="titulo">Fecha Ingreso</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fingreso", "value"=>$resp['FECHA_INGRESO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Fecha Creacion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fcrea", "value"=>$resp['FECHA_CREACION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
					    		<td width='20%'><div class="titulo">Fecha Compromiso</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fcompro", "value"=>$resp['FECHA_COMPROMISO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Tipo de Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"area", "value"=>$resp['TIPO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Motivo de Escalamiento</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['MOTIVO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Creador Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"creador_escalamiento", "value"=>$resp['CREADOR'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Asignado A</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"asignado", "value"=>$resp['ASIGNADO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fecha Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fecha_escalamiento", "value"=>$resp['FECHA_PENDIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fecha Ejecucion</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"fecha_ejec", "value"=>$resp['FECHA_EJECUCION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fecha Finalizacion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fecha_finalizacion", "value"=>$resp['FECHA_FINALIZADA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fecha Compromiso Orden</div></td>
								<td width='20%' valign='top'>
									<?= $this->inputFecha('fech_comp_ord_1',array("value"=>$fech_comp_ord)) ?><?= self::comboHora(array("name"=>"horas_comp_ord","default"=>$horas_comp_ord,"style"=>"width:40px","first_option"=>false))?><?= self::comboMinuto(array("name"=>"minutos_comp_ord","default"=>$minutos_comp_ord,"style"=>"width:40px","first_option"=>false))?>
								</td>
								<td width='20%' valign='top'><div class="titulo">Numero Orden Tango</div></td>
								<td width='20%' valign='top'>
									<?=self::inputText(array("name"=>"numero_orden_tango", "value"=>$resp['NUMERO_ORDEN_TANGO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?>
								</td>	
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Observacion</div></td>
					            <td width='20%' valign='top'><?=self::inputTextArea(array("name"=>"observacion", "value"=>$resp['OBSERVACION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Observacion Escalamiento</div></td>
					            <td width='20%'><?=self::inputTextArea(array("name"=>"observacion_escalamiento", "value"=>$resp['NUEVAOBSERVA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fono Contacto 1</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"fono_contacto_1", "value"=>$telefonos['FONO_CONTACTO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fono Contacto 2</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fono_contacto_2", "value"=>$telefonos['FONO_CONTACTO2'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>	       
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fono Contacto 3</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"fotno_contacto_3", "value"=>$telefonos['FONO_CONTACTO3'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>       
							</tr>
						</table>
	                </div>
				</div>		

				<div id="VerComentarios">
					<h3><a href="#"><div align="left"><b>Ver Comentarios Anteriores</b></div></a></h3>
					<div id="ver_orden"><?=parent::listaHtml($coment, $params)?></div>
				</div>
				
				<div id="VerBitacora">
					<h3><a href="#"><div align="left"><b>Ver Bitacora</b></div></a></h3>
					<div id="ver_orden"><?=parent::listaHtml($bitacora, $params)?></div>
				</div>

				<div id="VerPostAcciones">
					<h3><a href="#"><div align="left"><b>Ver Datos Anteriores</b></div></a></h3>
					<div id="ver_post_acciones"><?=parent::listaHtml($post_acciones, $params)?></div>
				</div>

				<div id="FinalizarOrden">
					<h3><a href="#"><div align="left"><b>Finalizar Orden</b></div></a></h3>
					<div id="fin_orden">

						<tr>
							<td width='10%'><div class="titulo">Comentario</div></td>
		                    <td width='20%'><?=self::inputTextArea(array("rows"=>10,"style"=>"width:700px;align:left;","name"=>"comentarioCAV","class"=>"ui-state-default"))?></td>
		                </tr>	
						<tr>
							<td width='20%'><div class="titulo">Correo Electronico</div></td>
						    <td width='20%'><?=self::inputText(array("name"=>"correo_ejec", "value"=>$resp['CORREO_ELECTRONICO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>	
						  <? echo "<td><a href='http://desannoc.vtr.cl/cencina/escalamiento/escalamiento_critico/documentos/".$resp['CORREO_ELECTRONICO'][0]."'>Descargar</a></td>";?>
						</tr>	

						<tr>
							<td width='20%'><div class="titulo">Archivo Ejecucion</div></td>
						    <td width='20%'><?=self::inputText(array("name"=>"archivoejecucion", "value"=>$resp['PDF_SUPERVISOR'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>	
						  <? echo "<td><a href='http://desannoc.vtr.cl/cencina/escalamiento/escalamiento_critico/documentos/".$resp['PDF_SUPERVISOR'][0]."' target='pdf-frame'>Descargar</a></td>";?>
						</tr>	
				
						<tr>
							<td width='20%'><div class="titulo">Adjuntar PDF</div></td>
							<td width='20%'><?=self::inputText(array("name"=>"archivoPDFtext_cav", "value"=>"","class"=>"ui-state-default", "readonly"=>"true"))?></td>	
						    <td><input type="button" name="adjuntarpdf" value="Adjuntar" onclick="ventanita3();" /></td>
						</tr>
		                <tr>
		                <br>
		                <br>
		                    <td width='20%'><input type="button" name="finalizaOrdenConforme" value="Cliente Conforme" onclick="cerrarEscalamiento(<?=$valor?>);" /></td>
		                    <td width='20%'><input type="button" name="reescalamiento" value="Cliente Inconforme" onclick="reescalamientos(<?=$valor?>);" /></td>
		                    <td width='20%'><input type="button" name="finalizaSinContacto" value="Sin Contacto" onclick="finalizarSinContacto(<?=$valor?>);" /></td>
		                </tr>
	                </div>
				</div>	
		</form>
	</div>
		<script type="text/javascript">
		 	$("#div_VerOrden").accordion({ collapsible: true,autoHeight: false   });
	        $("#FinalizarOrden").accordion({ collapsible: true,autoHeight: false   });
	        $("#VerPostAcciones").accordion({ collapsible: true,autoHeight: false   });
	        $("#VerComentarios").accordion({ collapsible: true,autoHeight: false   });
	        $("#VerBitacora").accordion({ collapsible: true,autoHeight: false   });
	        
		</script>
	<? 
	}

	public function FinalizarOrden($valor, $comen, $postMortem, $pdf_ejec, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord){
		$resp = self::$db->FinalizarOrden($valor, $comen, $postMortem, $pdf_ejec, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord);
		if( ! empty( $fech_comp_ord ) ){
			self::$db->addBitacoraFechCompOrd($valor, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord);
		}	
		self::$db->guarda_pdf($valor, $pdf_ejec);
		echo $resp['codigo'];
	}

	public function cerrarEscalamiento($valor, $comen, $pdf_cav, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord){
		$resp = self::$db->cerrarEscalamiento($valor, $comen, $pdf_cav, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord);
		if( ! empty( $fech_comp_ord ) ){
			self::$db->addBitacoraFechCompOrd($valor, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord);
		}	
		self::$db->guarda_pdf($valor, $pdf_cav);
		echo $resp['codigo'];
	}	

	public function finalizarSinContacto($valor, $comen, $pdf_cav, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord){
		$resp = self::$db->finalizarSinContacto($valor, $comen, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord);
		if( ! empty( $fech_comp_ord ) ){
			self::$db->addBitacoraFechCompOrd($valor, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord);
		}	
		self::$db->guarda_pdf($valor, $pdf_cav);
		echo $resp['codigo'];
	}

	public function reescalamiento($valor, $comen, $pdf_cav, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord){
		$resp = self::$db->GuardarEscalamiento($valor);
		$resp2 = self::$db->reescalamientoEdita($valor, $comen, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord);
		if( ! empty( $fech_comp_ord ) ){
			self::$db->addBitacoraFechCompOrd($valor, $fech_comp_ord, $horas_comp_ord, $minutos_comp_ord);
		}	
		self::$db->guarda_pdf($valor, $pdf_cav);
		echo $resp['codigo'];
	}

	public function reescalamientoEdita($valor, $comen, $postMortem){
		$resp2 = self::$db->reescalamientoEdita($valor, $comen, $postMortem);
		echo $resp['codigo'];
	}

	public function AnularOrden($valor){
		//OBTENER PREMISO
		$permiso = self::$db->permiso_anula($valor);
		//var_dump(count($permiso));die;
		if (count($permiso)>1){
			$resp = self::$db->AnularOrden($valor);
			echo $resp['codigo'];
		} else {
			$resp = 2;
			echo $resp;
		}
	}

	public function AnularOrdenEsca($valor){
		$resp = self::$db->AnularOrdenEsca($valor);
		echo $resp['codigo'];
	}

	public function ComentarOrden($valor, $comen){
		$resp = self::$db->ComentarOrden($valor, $comen);
		echo $resp['codigo'];
	}

	public function divComentarios($valor){
		$coment = self::$db->getComentarios($valor);
		return parent::listaHtml($coment, $params);
	}	
	
	public function getCbxRegion($terr){
		echo self::combobox("region",self::$db->getRegion($terr),array("onChange"=>"javascript:selRegion();", "default"=>$reg));
	}
	
	public function getCbxComuna($terr, $reg){
		echo self::combobox("comuna",self::$db->getComuna($terr, $reg),array("onChange"=>"javascript:selLocalidad();", "default"=>$localidad));
	}
	
	public function vbOrden($valor){
		$resp = self::$db->vbOrden($valor);
		echo $resp['TOTAL'][0];
	}		
	
	public function mant_base($mod){
		if ($mod =='mant_cav'){
			$titulo = 'CAV';
			$serv = self::$db->selectUsusariosCav();
			$listServ = self::$db->selectUsusarioCav('');
			$boton = "<input type='button' value='GUARDAR' onclick='guardarNombre()'>";
			$boton2 = "<input type='button' value='BUSCAR' onclick='buscarNombre()'>";
		}else if ($mod =='mant_sla'){
			$titulo = 'Tiempo ';
			$serv = self::$db->getAreas();
			$listServ = self::$db->selectListTiempos('');
			$boton = "<input type='button' value='GUARDAR' onclick='guardarTiempo()'>";
		}
		?>
			<table width="100%">
				<tr>
					<td colspan="4"><font size="2"><b>Mantenedor <?php echo $titulo;?></b></font></td>
				</tr>
			</table>
			<table class="cuadrotexto" width="100%">
				<tr>
					<td><font size="2"><img src="/_includes/icons/add.png" height="16" width="16">Ingresar Nuevo <?php echo $titulo;?></font>
					<input type="hidden" id="txtMod" value="<?php echo $mod;?>" />	
					</td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
					<td width="250">Ingrese <?php echo $titulo;?>:</td>
					<? if ($mod =='mant_cav'){ ?>
						<td width="150"><input type="text" id="txtDesr" size="40"><input type="hidden" id="txtDesr1"></td>
					<script type="text/javascript">
							 			$(document).ready(function() {
							            $('#txtDesr').autocomplete('autocompletar.php', {
							             width: 400,
							             minChars: 3,
							             selectFirst: false,
							             highlightItem: false
							            });
							            $('#txtDesr').result(function(event, data, formatted) {
							             if (data) {
							             $('#txtDesr1').val(data[1]);
							             $('#txtDesr').val(data[2]);
							             }
							            });
							            $('#txtDesr').focus().select();
							            });
						            </script>
					<? }else if ($mod =='mant_sla'){ ?>
						<td colspan="4" width="310"><?=self::combobox('cbxTiempoArea',$serv,array("class"=>"combobox ui-widget-content", "onchange"=>"TraeformTiempo();"));?></td>
					</tr><tr><td colspan="2">
						<div id="div_tiempo"></div>
					</td></tr><tr>
				 	<? } ?>           
					<td width="150" align="center"><?=$boton?></td>
					<td></td>
				</tr>
			</table>
			<br><? if ($mod =='mant_cav'){ ?>
			<table class="cuadrotexto" width="100%">
				<tr>
					<td colspan="4"><font size="2"><img src="/_includes/icons/magnifier.png" height="16" width="16"> Buscar <?php echo $titulo;?></font></td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
					<td width="250">Seleccione <?php echo $titulo;?>:</td>
					<td width="310"><?=self::combobox('cbxBusq',$serv,array("class"=>"combobox ui-widget-content"));?></td>
					<td width="200"><?=$boton2?></td>
					<td></td>
				</tr>
			</table><? } ?>
			<br>
			<table class="cuadrotexto" width="100%">
				<tr>
					<td><font size="2"><img src="/_includes/icons/table.png" height="16" width="16"> Listado <?php echo $titulo;?></font></td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
					<td>
						<div id="listado_servicio">
						<?
						$tabla=array(
								"head"=>true,
								"firstColumnId"=>true,
								"showFirstColumn"=>false,
								"style"=>"width:100%;height%;text-align:left; text-color:blue",
								"columnaOrden"=>10,
								"tipoOrden"=>"asc",
								"paginacion"=>15
						);
						$params['acciones']=$acciones;
						$params['tabla']=$tabla;
						echo parent::listaHtml($listServ,$params);
						?>
						</div>
					</td>
				</tr>
			</table>
		
		<div id="modal_servicio"></div>
		
		<?		
	}	

	public function get_listaRegistros($datos){
		$listServ = self::$db->selectUsusarioCav($datos); 	
		
		$tabla=array(
						"head"=>true,
						"firstColumnId"=>true,
						"showFirstColumn"=>false,
						"style"=>"width:100%;height%;text-align:left; text-color:blue",
						"columnaOrden"=>10,
						"tipoOrden"=>"asc",
						"paginacion"=>15
				);
				$acciones[0]= array("label"=>"Modificar","href"=>"#","img"=>"/_includes/icons/application_edit.png","onClick"=>"modConcepto");
				$params['acciones']=$acciones;
				$params['tabla']=$tabla;
		echo parent::listaHtml($listServ,$params);
	}

	public function guardaUsuarioCAV($idu, $nombre){
		$resp = self::$db->insertUsusarioCav($idu, $nombre);
		return $resp['codigo'];
	}

	public function form_tiempo($id){
		$resp = self::$db->selectListTiempos($id);
		$pend = explode("-", $resp['Tiempo Pendiente (minutos)'][0]);
		$ejec = explode("-", $resp['Tiempo Ejecucion (minutos)'][0]);
		?>
		<table><br>
			<tr>
				<td width="300" class="titulo">Ingrese Tiempo en Estado Pendiente</td>
			</tr><tr style="color: green; font-weight: bold">
				<td>Normal</td><td width="15"><label style="width: 15px">0</label></td><td><label>a</label></td><td><label id="lbl_menor_p"></label></td>
			</tr><tr style="color: orange; font-weight: bold">
				<td>Medio</td><td width="15"><label><?=self::inputText(array("name"=>"txt_menor_p", "onkeyup"=>"return isNumberKeyMnp(event)", "style"=>'width:25px', "value"=>$pend[0])) ?></label></td>
				<td><label>a</label></td><td><label><?=self::inputText(array("name"=>"txt_mayor_p", "onkeyup"=>"return isNumberKeyMyp(event)", "style"=>'width:25px', "value"=>$pend[1])) ?></label></td>
			</tr><tr style="color: red; font-weight: bold">
				<td>Alerta</td><td><label id="lbl_mayor_p">1</label></td><td><label>o Mas</label></td>
			</tr>
			<tr>
				<td class="titulo">Ingrese Tiempo en Estado En Ejecucion</td>
			</tr><tr style="color: green; font-weight: bold">
				<td>Normal</td><td><label>0</label></td><td><label>a</label></td><td><label id="lbl_menor_e"></label></td>
			</tr><tr style="color: orange; font-weight: bold">
				<td>Medio</td><td width="15"><label><?=self::inputText(array("name"=>"txt_menor_e", "onkeyup"=>"return isNumberKeyMne(event)", "style"=>'width:25px', "value"=>$ejec[0])) ?></label></td>
				<td><label>a</label></td><td><label><?=self::inputText(array("name"=>"txt_mayor_e", "onkeyup"=>"return isNumberKeyMye(event)", "style"=>'width:25px', "value"=>$ejec[1])) ?></label></td>
			</tr><tr style="color: red; font-weight: bold">
				<td>Alerta</td><td><label id="lbl_mayor_e"></label></td><td><label>o Mas</label></td>
			</tr>
		</table>
		<?
	}

	public function GuardaTiempo($pend, $ejec, $area){
		$resp = self::$db->GuardaTiempo($pend, $ejec, $area);
		echo $resp['codigo'];
	}	
	
	public function enviaCorreo($norden){
		$mailCreador = self::$db->getMailCreador($norden);
		
		/*$mailCreador[0][0] = "cencina@sys.cl";
		$mailAsignado[0][0] = "cencina@sys.cl";
		$mailJefe[0][0] = "cencina@sys.cl";
		$mailEps[0][0] = "cencina@sys.cl";*/
		$datos = self::$db->getDatosMail($norden);
		$mailCreador = self::$db->getMailCreador($norden);
		$mailAsignado = self::$db->getMailAsignado($norden);
		$mailJefe = self::$db->getMailJefe($norden);
		$mailEps = self::$db->getMailEps($norden);

		//var_dump($datos);die;
		$array = array($mailCreador[0][0], $mailAsignado[0][0], '', '');
		$mailSeparado = implode(",", $array);
        $explode_mail_destino=explode(',',$mailSeparado);
      
        $i=0;
        $sw=0;
        $k=0;
        while ($i<count($explode_mail_destino)){
               $j=$i+1;
               while (($j)<count($explode_mail_destino)){
                      if ($explode_mail_destino[$i]==$explode_mail_destino[$j]){
                            $sw=1;
                      }
                      $j++;
               }
               if ($sw==0){
                      $temp_mail.=$explode_mail_destino[$i].',';
                      $direcciones[$k]=$explode_mail_destino[$i];
                      $k++;
               }
               $i++;
               $sw=0;
        }
        $temp_mail=substr($temp_mail,0,strlen($temp_mail)-1);
        

        $mail_destino=$temp_mail;
		//$mail_destino='cencina@sys.cl';
		
		$cuerpo = "El escalamiento N. ".$datos['ID_ESCALAMIENTO'][0]." fue escalado correctamente y se encuentra en estado ".$datos['DESCRIPCION'][0]."<br>Los datos de la Orden son: <br><br>Nombre Cliente: ".$datos['NOMBRE_CLIENTE'][0]."<br>Rut Cliente: ".$datos['RUT_PERSONA'][0]."<br>Direccion: ".$datos['DIRECCION'][0]."<br>Localidad: ".$datos['LOCALIDAD'][0]."<br>Actividad: ".$datos['ACTIVIDAD'][0]."<br>Motivo Escalamiento: ".$datos['MOTIVO'][0]."<br>Tipo de Escalamiento: ".$datos['TIPO'][0]."<br>Creador Escalamiento: ".$datos['CREADOR'][0]."<br>Fecha Creacion Escalamiento: ".$datos['FECHA_PENDIENTE'][0]."<br>Escalamiento Anulado por: ".$datos['USUARIO_ANULA'][0]."<br>Fecha Anulacion: ".$datos['FECHA_ANULA'][0]./*"<br>Fecha Finalizacion: ".$datos['FECHA_FINALIZADA'][0].*/"<br><br><br><br><b>Nota: Este e-mail es generado de manera automatica, por favor no responda a este mensaje. Asimismo, se han omitido acentos para evitar problemas de compatibilidad.</b>";	
	//var_dump($cuerpo);die;	
		$remitente='nnoc.gestionescalamientos999@vtr.cl';
		$asunto = "Gestion Escalamiento orden N. ".$datos['NMRO_ORDEN'][0];
		

		echo "<script Language='Javascript' type='text/javascript'>
			enviaMail2('$remitente','$mail_destino', '$asunto', '$cuerpo');
		</script>";
	}

	public function enviaCorreoNuevo($id_esca){

		//ESC_CRIT
		$esc = self::$db->getEscalaOrden($id_esca);
		$mailCreador = self::$db->getMailCreador($esc[0][0]);
		$mailAsignado = self::$db->getMailAsignado($esc[0][0]);
		$mailJefe = self::$db->getMailJefe($esc[0][0]);
		$mailEps = self::$db->getMailEps($esc[0][0]);
		//var_dump($esc);die;
		
		$datos = self::$db->getDatosMailNuevo($id_esca);
		//var_dump($datos);//die;
		//ESC_CRIT
		$array = array($mailCreador[0][0], $mailAsignado[0][0], '', '', '');	
		//$array = array($mailCreador, $mailAsignado, $mailJefe, $mailEps, "cencina@sys.cl");
		$mailSeparado = implode(",", $array);
        $explode_mail_destino=explode(',',$mailSeparado);
        
        $i=0;
        $sw=0;
        $k=0;
        while ($i<count($explode_mail_destino)){
               $j=$i+1;
               while (($j)<count($explode_mail_destino)){
                      if ($explode_mail_destino[$i]==$explode_mail_destino[$j]){
                            $sw=1;
                      }
                      $j++;
               }
               if ($sw==0){
                      $temp_mail.=$explode_mail_destino[$i].',';
                      $direcciones[$k]=$explode_mail_destino[$i];
                      $k++;
               }
               $i++;
               $sw=0;
        }
        $temp_mail=substr($temp_mail,0,strlen($temp_mail)-1);

        $mail_destino=$temp_mail;
        //$mail_destino="cencina@sys.cl";
        //$mail_destino="elias.gonzalez@vtr.cl";
        //$mail_destino="rodrigo.mendoza@vtr.cl";
		

		$cuerpo = "El Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0]." fue escalado correctamente y se encuentra en estado ".$datos['DESCRIPCION'][0]."<br>Los datos de la Orden son: <br><br>Nombre Cliente: ".$datos['NOMBRE_CLIENTE'][0]."<br>Rut Cliente: ".$datos['RUT_PERSONA'][0]."<br>Direccion: ".$datos['DIRECCION'][0]."<br>Localidad: ".$datos['LOCALIDAD'][0]."<br>Actividad: ".$datos['ACTIVIDAD'][0]."<br>Motivo Escalamiento: ".$datos['MOTIVO'][0]."<br>Tipo de Escalamiento: ".$datos['TIPO'][0]."<br>Creador Escalamiento: ".$datos['CREADOR'][0]."<br>Fecha Creacion Escalamiento: ".$datos['FECHA_PENDIENTE'][0]."<br><br><br><br><b>Nota: Este e-mail es generado de manera automatica, por favor no responda a este mensaje. Asimismo, se han omitido acentos para evitar problemas de compatibilidad.</b>";	
		
		$remitente='nnoc.gestionescalamientos@vtr.cl';
		//$remitente="cencina@sys.cl";
		$asunto = "ESCALAMIENTO CRITICO PENDIENTE - Gestion Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0];
		
		echo "<script Language='Javascript' type='text/javascript'>enviaMail('$remitente','$mail_destino', '$asunto', '$cuerpo');</script>";
	}

	public function enviaCorreoPend($RUTP, $DIRE, $TI_ESC, $MOTI_ESC){

		//ESC_CRIT
		$id_escal = self::$db->getDatosIdEscal($RUTP, $DIRE, $TI_ESC, $MOTI_ESC);
		$mailCreador = self::$db->getMailCreador($id_escal['ID_ESCALAMIENTO'][0]);
		$mailAsignado = self::$db->getMailAsignado($id_escal['ID_ESCALAMIENTO'][0]);
		$mailJefe = self::$db->getMailJefe($id_escal['ID_ESCALAMIENTO'][0]);
		$mailEps = self::$db->getMailEps($id_escal['ID_ESCALAMIENTO'][0]);
		//var_dump($esc);die;
		/*$mailCreador = "cencina@sys.cl";
		$mailAsignado = "cencina@sys.cl";
		$mailJefe = "cencina@sys.cl";
		$mailEps = "cencina@sys.cl";*/
		$id_escal = self::$db->getDatosIdEscal($RUTP, $DIRE, $TI_ESC, $MOTI_ESC);
		//var_dump($id_escal['ID_ESCALAMIENTO'][0]);
		$datos = self::$db->getDatosMailNuevo($id_escal['ID_ESCALAMIENTO'][0]);
	
		//var_dump($datos);//die;
		//ESC_CRIT
		$array = array($mailCreador[0][0], $mailAsignado[0][0], '', '', '');	
		//$array = array($mailCreador, $mailAsignado, $mailJefe, $mailEps, "cencina@sys.cl");
		$mailSeparado = implode(",", $array);
		
		
        $explode_mail_destino=explode(',',$mailSeparado);
        
        $i=0;
        $sw=0;
        $k=0;
        while ($i<count($explode_mail_destino)){
               $j=$i+1;
               while (($j)<count($explode_mail_destino)){
                      if ($explode_mail_destino[$i]==$explode_mail_destino[$j]){
                            $sw=1;
                      }
                      $j++;
               }
               if ($sw==0){
                      $temp_mail.=$explode_mail_destino[$i].',';
                      $direcciones[$k]=$explode_mail_destino[$i];
                      $k++;
               }
               $i++;
               $sw=0;
        }
        $temp_mail=substr($temp_mail,0,strlen($temp_mail)-1);

        $mail_destino=$temp_mail;
        //$mail_destino="cencina@sys.cl";
        //$mail_destino="elias.gonzalez@vtr.cl";
        //$mail_destino="rodrigo.mendoza@vtr.cl";
		echo $mail_destino;

		$cuerpo = "El Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0]." fue escalado correctamente y se encuentra en estado ".$datos['DESCRIPCION'][0]."<br>Los datos de la Orden son: <br><br>Nombre Cliente: ".$datos['NOMBRE_CLIENTE'][0]."<br>Rut Cliente: ".$datos['RUT_PERSONA'][0]."<br>Direccion: ".$datos['DIRECCION'][0]."<br>Localidad: ".$datos['LOCALIDAD'][0]."<br>Actividad: ".$datos['ACTIVIDAD'][0]."<br>Motivo Escalamiento: ".$datos['MOTIVO'][0]."<br>Tipo de Escalamiento: ".$datos['TIPO'][0]."<br>Creador Escalamiento: ".$datos['CREADOR'][0]."<br>Fecha Creacion Escalamiento: ".$datos['FECHA_PENDIENTE'][0]."<br><br><br><br><b>Nota: Este e-mail es generado de manera automatica, por favor no responda a este mensaje. Asimismo, se han omitido acentos para evitar problemas de compatibilidad.</b>";	
		
		$remitente='nnoc.gestionescalamientos@vtr.cl';
		//$remitente="cencina@sys.cl";
		$asunto = "ESCALAMIENTO CRITICO PENDIENTE NUEVO - Gestion Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0];
		
		echo "<script Language='Javascript' type='text/javascript'>enviaMail('$remitente','$mail_destino', '$asunto', '$cuerpo');</script>";
	}

	public function enviaCorreoAsig($id_esca){

		//ESC_CRIT
		$esc = self::$db->getEscalaOrden($id_esca);
		$mailCreador = self::$db->getMailCreador($esc[0][0]);
		$mailAsignado = self::$db->getMailAsignado($esc[0][0]);
		$mailJefe = self::$db->getMailJefe($esc[0][0]);
		$mailEps = self::$db->getMailEps($esc[0][0]);
		//var_dump($esc);die;
		/*$mailCreador = "cencina@sys.cl";
		$mailAsignado = "cencina@sys.cl";
		$mailJefe = "cencina@sys.cl";
		$mailEps = "cencina@sys.cl";*/
		$datos = self::$db->getDatosMailAsig($id_esca);
		//var_dump($datos);//die;
		//ESC_CRIT
		$array = array($mailCreador[0][0], $mailAsignado[0][0], '', '', '');	
		//$array = array($mailCreador, $mailAsignado, $mailJefe, $mailEps, "cencina@sys.cl");
		$mailSeparado = implode(",", $array);
        $explode_mail_destino=explode(',',$mailSeparado);
        
        $i=0;
        $sw=0;
        $k=0;
        while ($i<count($explode_mail_destino)){
               $j=$i+1;
               while (($j)<count($explode_mail_destino)){
                      if ($explode_mail_destino[$i]==$explode_mail_destino[$j]){
                            $sw=1;
                      }
                      $j++;
               }
               if ($sw==0){
                      $temp_mail.=$explode_mail_destino[$i].',';
                      $direcciones[$k]=$explode_mail_destino[$i];
                      $k++;
               }
               $i++;
               $sw=0;
        }
        $temp_mail=substr($temp_mail,0,strlen($temp_mail)-1);

        $mail_destino=$temp_mail;
        //$mail_destino="cencina@sys.cl";
        //$mail_destino="elias.gonzalez@vtr.cl";
        //$mail_destino="rodrigo.mendoza@vtr.cl";
		
		$cuerpo = "El Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0]." fue escalado correctamente y se encuentra en estado ".$datos['DESCRIPCION'][0]."<br>Los datos de la Orden son: <br><br>Nombre Cliente: ".$datos['NOMBRE_CLIENTE'][0]."<br>Rut Cliente: ".$datos['RUT_PERSONA'][0]."<br>Direccion: ".$datos['DIRECCION'][0]."<br>Localidad: ".$datos['LOCALIDAD'][0]."<br>Actividad: ".$datos['ACTIVIDAD'][0]."<br>Motivo Escalamiento: ".$datos['MOTIVO'][0]."<br>Tipo de Escalamiento: ".$datos['TIPO'][0]."<br>Creador Escalamiento: ".$datos['CREADOR'][0]."<br>Fecha Creacion Escalamiento: ".$datos['FECHA_PENDIENTE'][0]."<br>Escalamiento Asignado a: ".$datos['ASIGNADO'][0]."<br>Fecha Asignacion: ".$datos['FECHA_EJECUCION'][0]."<br><br><br><br><b>Nota: Este e-mail es generado de manera automatica, por favor no responda a este mensaje. Asimismo, se han omitido acentos para evitar problemas de compatibilidad.</b>";	
		
		$remitente='nnoc.gestionescalamientos@vtr.cl';
		//$remitente="cencina@sys.cl";
		$asunto = "ESCALAMIENTO CRITICO ASIGNACION - Gestion Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0];
		
		echo "<script Language='Javascript' type='text/javascript'>enviaMail('$remitente','$mail_destino', '$asunto', '$cuerpo');</script>";
	}	

	public function enviaCorreoEjec($id_esca){

		//ESC_CRIT
		$esc = self::$db->getEscalaOrden($id_esca);
		$mailCreador = self::$db->getMailCreador($esc[0][0]);
		$mailAsignado = self::$db->getMailAsignado($esc[0][0]);
		$mailJefe = self::$db->getMailJefe($esc[0][0]);
		$mailEps = self::$db->getMailEps($esc[0][0]);
		//var_dump($esc);die;
		/*$mailCreador = "cencina@sys.cl";
		$mailAsignado = "cencina@sys.cl";
		$mailJefe = "cencina@sys.cl";
		$mailEps = "cencina@sys.cl";*/
		$datos = self::$db->getDatosMailAsig($id_esca);
		//var_dump($datos);//die;
		//ESC_CRIT
		$array = array($mailCreador[0][0], $mailAsignado[0][0], '', '', '');	
		//$array = array($mailCreador, $mailAsignado, $mailJefe, $mailEps, "cencina@sys.cl");
		$mailSeparado = implode(",", $array);
        $explode_mail_destino=explode(',',$mailSeparado);
        
        $i=0;
        $sw=0;
        $k=0;
        while ($i<count($explode_mail_destino)){
               $j=$i+1;
               while (($j)<count($explode_mail_destino)){
                      if ($explode_mail_destino[$i]==$explode_mail_destino[$j]){
                            $sw=1;
                      }
                      $j++;
               }
               if ($sw==0){
                      $temp_mail.=$explode_mail_destino[$i].',';
                      $direcciones[$k]=$explode_mail_destino[$i];
                      $k++;
               }
               $i++;
               $sw=0;
        }
        $temp_mail=substr($temp_mail,0,strlen($temp_mail)-1);

        $mail_destino=$temp_mail;
        //$mail_destino="cencina@sys.cl";
        //$mail_destino="elias.gonzalez@vtr.cl";
        //$mail_destino="rodrigo.mendoza@vtr.cl";
		

		$cuerpo = "El Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0]." fue escalado correctamente y se encuentra en estado ".$datos['DESCRIPCION'][0]."<br>Los datos de la Orden son: <br><br>Nombre Cliente: ".$datos['NOMBRE_CLIENTE'][0]."<br>Rut Cliente: ".$datos['RUT_PERSONA'][0]."<br>Direccion: ".$datos['DIRECCION'][0]."<br>Localidad: ".$datos['LOCALIDAD'][0]."<br>Actividad: ".$datos['ACTIVIDAD'][0]."<br>Motivo Escalamiento: ".$datos['MOTIVO'][0]."<br>Tipo de Escalamiento: ".$datos['TIPO'][0]."<br>Creador Escalamiento: ".$datos['CREADOR'][0]."<br>Fecha Creacion Escalamiento: ".$datos['FECHA_PENDIENTE'][0]."<br>Escalamiento Asignado a: ".$datos['ASIGNADO'][0]."<br>Fecha Asignacion: ".$datos['FECHA_EJECUCION'][0]./*"<br>Fecha Finalizacion: ".$datos['FECHA_FINALIZADA'][0].*/"<br><br><br><br><b>Nota: Este e-mail es generado de manera automatica, por favor no responda a este mensaje. Asimismo, se han omitido acentos para evitar problemas de compatibilidad.</b>";	
		
		$remitente='nnoc.gestionescalamientos@vtr.cl';
		//$remitente="cencina@sys.cl";
		$asunto = "ESCALAMIENTO CRITICO EJECUCION - Gestion Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0];
		
		echo "<script Language='Javascript' type='text/javascript'>enviaMail('$remitente','$mail_destino', '$asunto', '$cuerpo');</script>";
	}	

	public function enviaCorreoFinal($id_esca){

		//ESC_CRIT
		$esc = self::$db->getEscalaOrden($id_esca);
		$mailCreador = self::$db->getMailCreador($esc[0][0]);
		$mailAsignado = self::$db->getMailAsignado($esc[0][0]);
		$mailJefe = self::$db->getMailJefe($esc[0][0]);
		$mailEps = self::$db->getMailEps($esc[0][0]);
		//var_dump($esc);die;
		/*$mailCreador = "cencina@sys.cl";
		$mailAsignado = "cencina@sys.cl";
		$mailJefe = "cencina@sys.cl";
		$mailEps = "cencina@sys.cl";*/
		$datos = self::$db->getDatosMailAsig($id_esca);
		//var_dump($datos);//die;
		//ESC_CRIT
		$array = array($mailCreador[0][0], $mailAsignado[0][0], '', '', '');	
		//$array = array($mailCreador, $mailAsignado, $mailJefe, $mailEps, "cencina@sys.cl");
		$mailSeparado = implode(",", $array);
        $explode_mail_destino=explode(',',$mailSeparado);
        
        $i=0;
        $sw=0;
        $k=0;
        while ($i<count($explode_mail_destino)){
               $j=$i+1;
               while (($j)<count($explode_mail_destino)){
                      if ($explode_mail_destino[$i]==$explode_mail_destino[$j]){
                            $sw=1;
                      }
                      $j++;
               }
               if ($sw==0){
                      $temp_mail.=$explode_mail_destino[$i].',';
                      $direcciones[$k]=$explode_mail_destino[$i];
                      $k++;
               }
               $i++;
               $sw=0;
        }
        $temp_mail=substr($temp_mail,0,strlen($temp_mail)-1);

        $mail_destino=$temp_mail;
        //$mail_destino="cencina@sys.cl";
        //$mail_destino="elias.gonzalez@vtr.cl";
        //$mail_destino="rodrigo.mendoza@vtr.cl";
		

		$cuerpo = "El Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0]." fue escalado correctamente y se encuentra en estado ".$datos['DESCRIPCION'][0]."<br>Los datos de la Orden son: <br><br>Nombre Cliente: ".$datos['NOMBRE_CLIENTE'][0]."<br>Rut Cliente: ".$datos['RUT_PERSONA'][0]."<br>Direccion: ".$datos['DIRECCION'][0]."<br>Localidad: ".$datos['LOCALIDAD'][0]."<br>Actividad: ".$datos['ACTIVIDAD'][0]."<br>Motivo Escalamiento: ".$datos['MOTIVO'][0]."<br>Tipo de Escalamiento: ".$datos['TIPO'][0]."<br>Creador Escalamiento: ".$datos['CREADOR'][0]."<br>Fecha Creacion Escalamiento: ".$datos['FECHA_PENDIENTE'][0]."<br>Escalamiento Asignado a: ".$datos['ASIGNADO'][0]."<br>Fecha Asignacion: ".$datos['FECHA_EJECUCION'][0]."<br>Fecha Finalizacion: ".$datos['FECHA_FINALIZADA'][0]."<br><br><br><br><b>Nota: Este e-mail es generado de manera automatica, por favor no responda a este mensaje. Asimismo, se han omitido acentos para evitar problemas de compatibilidad.</b>";	
		
		$remitente='nnoc.gestionescalamientos@vtr.cl';
		//$remitente="cencina@sys.cl";
		$asunto = "ESCALAMIENTO CRITICO FINALIZACION - Gestion Escalamiento N. ".$datos['ID_ESCALAMIENTO'][0];
		
		echo "<script Language='Javascript' type='text/javascript'>enviaMail('$remitente','$mail_destino', '$asunto', '$cuerpo');</script>";
	}

	public function form_OrdenFinalizada($valor){
		$resp = self::$db->getOrdenFinalizada($valor);
		$coment = self::$db->getComentarios($valor);
		$bitacora = self::$db->getBitacoraFechCompOrd( $valor );
	?>
		<form name="formulario6" id="formulario6">
				<div id="div_VerOrden">
					<h3><a href="#"><div align="left"><b>Datos de la Orden</b></div></a></h3>
					<div id="com_orden">
						<table width="100%" >
					    	<tr>
					    		<td width='20%'><div class="titulo">Numero Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"norden", "value"=>$resp['ID_ESCALAMIENTO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Rut Cliente</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"rut", "value"=>$resp['RUT_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
						   	<tr>
					    		<td width='20%'><div class="titulo">Nombre Cliente</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"nombre", "value"=>$resp['NOMBRE_CLIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Direccion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"direccion", "value"=>$resp['DIRECCION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
					    	<tr>
					    		<td width='20%'><div class="titulo">Localidad</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"localidad", "value"=>$resp['LOCALIDAD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Nodo</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"nodo", "value"=>$resp['NODO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
					    		<td width='20%'><div class="titulo">Fecha Ingreso</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fingreso", "value"=>$resp['FECHA_INGRESO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Fecha Creacion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fcrea", "value"=>$resp['FECHA_CREACION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
					    		<td width='20%'><div class="titulo">Fecha Compromiso</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fcompro", "value"=>$resp['FECHA_COMPROMISO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Tipo de Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"area", "value"=>$resp['TIPO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Motivo de Escalamiento</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['MOTIVO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Creador Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['CREADOR'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Asignado A</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['ASIGNADO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fecha Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['FECHA_PENDIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fecha Ejecucion</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['FECHA_EJECUCION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fecha Finalizacion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['FECHA_FINALIZADA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fecha Compromiso Orden</div></td>
								<td width='20%' valign='top'>
									<?=self::inputText(array("name"=>"fech_comp_ord", "value"=>$resp['FECH_COMP_ORD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?>
								</td>
								<td width='20%' valign='top'><div class="titulo">Numero Orden Tango</div></td>
								<td width='20%' valign='top'>
									<?=self::inputText(array("name"=>"numero_orden_tango", "value"=>$resp['NUMERO_ORDEN_TANGO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?>
								</td>
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Observacion</div></td>
					            <td width='20%' valign='top'><?=self::inputTextArea(array("name"=>"activ", "value"=>$resp['OBSERVACION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Observacion Escalamiento</div></td>
					            <td width='20%'><?=self::inputTextArea(array("name"=>"obserori", "value"=>$resp['NUEVAOBSERVA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Post Mortem</div></td>
					            <td width='20%' valign='top'><?=self::inputTextArea(array("name"=>"activ", "value"=>$resp['POST_MORTEM'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>  								<td width='20%' valign='top'><div class="titulo">Comentario CAV</div></td>
					            <td width='20%' valign='top'><?=self::inputTextArea(array("name"=>"activ", "value"=>$resp['COMENTARIO_CAV'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>          
							</tr>
						</table>
	                </div>
				</div>
				<div id="div_VerComentario">
					<h3><a href="#"><div align="left"><b>Ver Comentarios Anteriores</b></div></a></h3>
					<div id="ver_orden"><?=parent::listaHtml($coment, $params)?></div>
				</div>
				<div id="div_VerBitacora">
					<h3><a href="#"><div align="left"><b>Ver Bitacora</b></div></a></h3>
					<div id="ver_orden"><?=parent::listaHtml($bitacora, $params)?></div>
				</div>
		</form>
		<script type="text/javascript">
	        $("#div_VerOrden").accordion({ collapsible: true,autoHeight: false   });
	        $("#div_VerComentario").accordion({ collapsible: true,autoHeight: false   });
	        $("#div_VerBitacora").accordion({ collapsible: true,autoHeight: false   });
		</script>
	<? 
	}

	public function form_OrdenFinalizadaMortem($valor){
		$resp = self::$db->getOrdenFinalizada($valor);
		$coment = self::$db->getComentarios($valor);
		$bitacora = self::$db->getBitacoraFechCompOrd( $valor );
	?>
		<form name="formulario6" id="formulario6">
				<div id="div_VerOrden">
					<h3><a href="#"><div align="left"><b>Datos de la Orden</b></div></a></h3>
					<div id="com_orden">
						<table width="100%" >
					    	<tr>
					    		<td width='20%'><div class="titulo">Numero Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"norden", "value"=>$resp['ID_ESCALAMIENTO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Rut Cliente</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"rut", "value"=>$resp['RUT_PERSONA'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
						   	<tr>
					    		<td width='20%'><div class="titulo">Nombre Cliente</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"nombre", "value"=>$resp['NOMBRE_CLIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Direccion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"direccion", "value"=>$resp['DIRECCION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
					    	<tr>
					    		<td width='20%'><div class="titulo">Localidad</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"localidad", "value"=>$resp['LOCALIDAD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Nodo</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"nodo", "value"=>$resp['NODO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
					    		<td width='20%'><div class="titulo">Fecha Ingreso</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fingreso", "value"=>$resp['FECHA_INGRESO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Fecha Creacion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fcrea", "value"=>$resp['FECHA_CREACION'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
					    		<td width='20%'><div class="titulo">Fecha Compromiso</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"fcompro", "value"=>$resp['FECHA_COMPROMISO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					            <td width='20%'><div class="titulo">Tipo de Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"area", "value"=>$resp['TIPO'][0],"class"=>"ui-state-default", "readonly"=>"true")) ?></td>
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Motivo de Escalamiento</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['MOTIVO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Creador Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['CREADOR'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Asignado A</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['ASIGNADO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fecha Escalamiento</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['FECHA_PENDIENTE'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fecha Ejecucion</div></td>
					            <td width='20%' valign='top'><?=self::inputText(array("name"=>"activ", "value"=>$resp['FECHA_EJECUCION'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Fecha Finalizacion</div></td>
					            <td width='20%'><?=self::inputText(array("name"=>"obserori", "value"=>$resp['FECHA_FINALIZADA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Fecha Compromiso Orden</div></td>
								<td width='20%' valign='top'>
									<?=self::inputText(array("name"=>"fech_comp_ord", "value"=>$resp['FECH_COMP_ORD'][0],"class"=>"ui-state-default", "readonly"=>"true"))?>
								</td>
								<td width='20%' valign='top'><div class="titulo">Numero Orden Tango</div></td>
								<td width='20%' valign='top'>
									<?=self::inputText(array("name"=>"numero_orden_tango", "value"=>$resp['NUMERO_ORDEN_TANGO'][0],"class"=>"ui-state-default", "readonly"=>"true"))?>
								</td>
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Post Mortem</div></td>
					            <td width='20%' valign='top'><?=self::inputTextArea(array("name"=>"activ", "value"=>$resp['POST_MORTEM'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>
					    		<td width='20%' valign='top'><div class="titulo">Acciones Preventivas</div></td>
					            <td width='20%'><?=self::inputTextArea(array("name"=>"obserori", "value"=>$resp['NUEVAOBSERVA'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>		          
							</tr>
							<tr>
								<td width='20%' valign='top'><div class="titulo">Comentario CAV</div></td>
					            <td width='20%' valign='top'><?=self::inputTextArea(array("name"=>"activ", "value"=>$resp['COMENTARIO_CAV'][0],"class"=>"ui-state-default", "readonly"=>"true"))?></td>          
							</tr>
						</table>
	                </div>
				</div>
				<div id="div_VerComentario">
					<h3><a href="#"><div align="left"><b>Ver Comentarios Anteriores</b></div></a></h3>
					<div id="ver_orden"><?=parent::listaHtml($coment, $params)?></div>
				</div>
				<div id="div_VerBitacora">
					<h3><a href="#"><div align="left"><b>Ver Bitacora</b></div></a></h3>
					<div id="ver_orden"><?=parent::listaHtml($bitacora, $params)?></div>
				</div>

		</form>
		<script type="text/javascript">
	        $("#div_VerOrden").accordion({ collapsible: true,autoHeight: false   });
	        $("#PostMortem").accordion({ collapsible: true,autoHeight: false   });
	        $("#div_VerComentario").accordion({ collapsible: true,autoHeight: false   });
	        $("#div_VerBitacora").accordion({ collapsible: true,autoHeight: false   });
		</script>
	<? 
	}

	public function getRecuerda($id){
		$consejo = self::$db->getRecuerda($id);
		echo "<label style='color: blue;font-size:11px;font-weight: bold'>Recuerda que: ".$consejo[COMENTARIO][0]."</label>";
		 
	}
	
	public function form_reporte($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		$fpenDesde = ($fpenDesde == '') ? date('d/m/Y', strtotime( "- 365 days" )) : $fpenDesde ;
		$fpenHasta = ($fpenHasta == '') ? date('d/m/Y') : $fpenHasta ;
		//$todosEstado = self::$db->cuentaEstados($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta);
		$todosEstado = self::$db->cuentaEstados1($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		$todosAreas = self::$db->cuentaAreas($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		$todosEmpresa = self::$db->cuentaEmpresa($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		$tiempoPendEjec = self::$db->cuentaTiempoPendEjec($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		$tiempoEjecFina = self::$db->cuentaTiempoEjecFina($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		$tiempoPendTreal = self::$db->cuentaTiempoPendTreal($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		$tiempoEjecTreal = self::$db->cuentaTiempoEjecTreal($terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		?>
			<div id="Filtros">
				<h3><a href="#"><div align="left"><b>Filtros</b></div></a></h3>
				<div>					
					<table>
						<tr>
							<td width='40%'>Ingrese Territorio:</td>
							<td width='40%'>Ingrese Region:</td>
							<td width='40%'>Ingrese Comuna:</td>
						</tr>
						<tr>
							<td><div id="div_territorio"><?=self::multiple2(self::$db->getTerritorio(),array( "name"=>"Rterritorio", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selTerritorioR();", "default"=>$terr ))?></div></td>
							<td><div id="div_region"><?=self::multiple2(self::$db->getRegion($terr),array( "name"=>"Rregion", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selRegionR();", "default"=>$reg ))?></div></td>
							<td><div id="div_comuna"><?=self::multiple2(self::$db->getComuna($terr, $reg),array( "name"=>"Rcomuna", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selLocalidadR();", "default"=>$loc ))?></div></td>
						</tr>
						<tr><td><br /></td></tr>
						<tr>	
							<td width='40%'>Ingrese Area:</td>
							<td width='40%'>Ingrese Actividad:</td>
							<td width='40%'>Ingrese Empresa:</td>
							
						</tr>
						<tr>	
							<td><?=self::multiple2(self::$db->getEscalamientos(),array( "name"=>"Rescalamientos", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selEscalaR();", "default"=>$escala ))?></td>
							<td><?=self::multiple2(self::$db->getActividad(),array( "name"=>"Ractividad", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selEscalaR();", "default"=>$actividad ))?></td>
							<td><?=self::multiple2(self::$db->getEmpresa(),array( "name"=>"Rempresa", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selEmpresaR();", "default"=>$eps ))?></td>
						</tr>
						<tr><td><br /></td></tr>
						<tr>
							<td width='40%'>Ingrese Fecha Escalamiento:</td>	
							<td><?php echo parent::inputFecha("RfechaDesde", array("onChange"=>"javascript:selTerritorioR();", "value"=>$fpenDesde ))?><?php echo parent::inputFecha("RfechaHasta", array("onChange"=>"javascript:selTerritorioR();", "value"=>$fpenHasta))?></td>
						</tr>
					</table>
				</div>					
			</div>
			<div id="Graficos1">
				<h3><a href="#"><div align="left"><b>Graficos</b></div></a></h3>
				<div align="center">
					<table border="1">
						<tr>
							<td width='500px'><div id="div_estados"><?=self::getGraficoTiempos2($todosEstado, 'Cantidad de Ordenes Escaladas', 'Numero de Escalamientos', 'div_estados')?></div></td>
							<td width='700px'><div id="div_areas"><?=self::getGraficoBarras($todosAreas, 'Cantidad de Ordenes Escaladas por Actividad', 'Numero de Escalamientos', 'div_areas')?></div></td>
							<td width='600px'><div id="div_empresas"><?=self::getGraficoBarras($todosEmpresa, 'Cantidad de Ordenes Escaladas por Empresa', 'Numero de Escalamientos', 'div_empresas')?></div></td>
						</tr></table>
					<table border="1">	
						<tr>
							<td width='700px'><div id="div_pendientes_treal"><?=self::getGraficoTiempos($tiempoPendTreal, 'Cantidad Escalamientos por Estado - Tiempo en Pendiente TiempoReal', 'Numero de Escalamientos', 'div_pendientes_treal')?></div></td>
							<td width='700px'><div id="div_ejecucion_treal"><?=self::getGraficoTiempos($tiempoEjecTreal, 'Cantidad Escalamientos por Estado - Tiempo en Ejecucion TiempoReal', 'Numero de Escalamientos', 'div_ejecucion_treal')?></div></td>
						</tr>
						<tr>
							<td width='700px'><div id="div_pendientes"><?=self::getGraficoTiempos($tiempoPendEjec, 'Cantidad Escalamientos por Estado - Tiempo en Pendiente', 'Numero de Escalamientos', 'div_pendientes')?></div></td>
							<td width='700px'><div id="div_ejecucion"><?=self::getGraficoTiempos($tiempoEjecFina, 'Cantidad Escalamientos por Estado - Tiempo en Ejecucion', 'Numero de Escalamientos', 'div_ejecucion')?></div></td>
						</tr>
					</table>
				</div>					
			</div>
			<div id="VentanaDetalle"></div>
			<script type="text/javascript">
				$("#Filtros").accordion({ collapsible: true,autoHeight: false   });
				$("#Graficos1").accordion({ collapsible: true,autoHeight: false   });
			</script>		
		<?
	}
	
	public function getGraficoBarras($datos, $titulo, $descrip, $div){
		$strXML ="<chart plotGradientColor=' ' caption='$titulo' labelDisplay='Rotate' yAxisName='$descrip'  showPercentageValues='0' baseFontSize='9'  showLabels='1'  showBorder='0' showLegend='1' bgColor='FFFFFF' clickURL='' >";

		for ($i=0;$i<count($datos);$i++){
				$texto =  $datos[$i][1];
				$valor =  $datos[$i][0];
				$estado = $datos[$i][2];
				$strXML .="<set label='$texto' value='$valor'  color='00FF00' link='javascript:getVentana($estado, %22$div%22)'/>";
		}
		$strXML .="</chart> ";  
		?>
			
			<script type="text/javascript">
				var myChart = new FusionCharts("<?=$home?>/graficos/Charts/Bar2D.swf", "myChartId", "100%", "280", "FFFFFF", "exactFit");
	    		myChart.setDataXML("<?=$strXML?>");
	    		myChart.render("<?=$div?>");
			</script>
		
		<?	
	}
	
	public function getGraficoTiempos($datos, $titulo, $descrip, $div){
		$empresas = array();
		foreach( $datos['EMPRESA'] as $indice => $empresa ){
			$empresas[$empresa] = $empresa;
			$alertas[$datos['TIPO'][$indice]] = $datos['TIPO'][$indice];
			$valores[$datos['TIPO'][$indice]][$empresa] = $datos['TOTAL'][$indice];
		}
		foreach( $valores as $valor => $empresas1 ){
			foreach( $empresas1 as $empresa => $val ){
				foreach ($alertas as $alerta ) {
					if( !is_null( $valores[$alerta][$empresa] ) ){
						$valores_1[$alerta][$empresa] = $valores[$alerta][$empresa];
					}else{
						$valores_1[$alerta][$empresa] = 0;
					}
				}
			}
		}
		
		$xml  = "<chart plotGradientColor=' ' caption='$titulo' yAxisName='$descrip' formatNumber='0' formatNumberScale='0' showValues='1' rotatelabels='1' slantlabels='1' bgColor='FFFFFF'>";
		
		$xml .= "<categories>";
		foreach($empresas as $empresa ){
			$xml .= "<category label='$empresa'/>";
		}
		$xml .= "</categories>";
		foreach($valores_1 as $alerta => $alertas ){
			if ($alerta == 'Normal'){
				$color = '00FF00';
			}else if ($alerta == 'Medio'){
				$color = 'FF8C00';
			}else if ($alerta == 'Alerta'){
				$color = 'FF0000';
			}
			$xml .= "<dataset seriesname='$alerta' color='$color'>";
			foreach( $alertas as $empresa => $total ){
				$xml .= "<set value='$total' link='javascript:getVentana2(%22$alerta%22, %22$empresa%22, %22$div%22)' />";
			}
			$xml .= "</dataset>";		
		}
		$xml .= "</chart>";	
		$rand = rand();
		?>
			<script type="text/javascript">
				var myChart = new FusionCharts("<?=$home?>/graficos/Charts/StackedBar2D.swf", "myChartId_<?=$rand?>", "100%", "400", "FFFFFF", "exactFit");
	    		myChart.setDataXML("<?=$xml?>");
	    		myChart.render("<?=$div?>");
			</script>
		<?	
	}

	public function getGraficoTiempos2($datos, $titulo, $descrip, $div){
		$empresas = array();
		foreach( $datos['EMPRESA'] as $indice => $empresa ){
			$empresas[$empresa] = $empresa;
			$alertas[$datos['TIPO'][$indice]] = $datos['TIPO'][$indice];
			$valores[$datos['TIPO'][$indice]][$empresa] = $datos['TOTAL'][$indice];
		}
		foreach( $valores as $valor => $empresas1 ){
			foreach( $empresas1 as $empresa => $val ){
				foreach ($alertas as $alerta ) {
					if( !is_null( $valores[$alerta][$empresa] ) ){
						$valores_1[$alerta][$empresa] = $valores[$alerta][$empresa];
					}else{
						$valores_1[$alerta][$empresa] = 0;
					}
				}
			}
		}
		
		$xml  = "<chart plotGradientColor=' ' caption='$titulo' yAxisName='$descrip' formatNumber='0' formatNumberScale='0' showValues='1' rotatelabels='1' slantlabels='1' bgColor='FFFFFF'>";
		
		$xml .= "<categories>";
		foreach($empresas as $empresa ){
			$xml .= "<category label='$empresa'/>";
		}
		$xml .= "</categories>";
		foreach($valores_1 as $alerta => $alertas ){
			if ($alerta == 'Pendiente'){
				$color = '00DD00';
			}else if ($alerta == 'En Ejecucion'){
				$color = 'FF8C00';
			}else if ($alerta == 'Finalizada'){
				$color = 'FF0077';
			}else if ($alerta == 'Anulada'){
				$color = 'FF0000';
			}
			$xml .= "<dataset seriesname='$alerta' color='$color'>";
			foreach( $alertas as $empresa => $total ){
				$xml .= "<set value='$total' link='javascript:getVentana3(%22$alerta%22, %22$empresa%22, %22$div%22)' />";
			}
			$xml .= "</dataset>";		
		}
		$xml .= "</chart>";	
		$rand = rand();
		?>
			<script type="text/javascript">
				var myChart = new FusionCharts("<?=$home?>/graficos/Charts/StackedBar2D.swf", "myChartId_<?=$rand?>", "100%", "400", "FFFFFF", "exactFit");
	    		myChart.setDataXML("<?=$xml?>");
	    		myChart.render("<?=$div?>");
			</script>
		<?	
	}


	public function getGraficoTiemposDetalle($datos, $titulo, $descrip, $div, $empr, $div_anterior, $div_alma){
		$empresas = array();
		foreach( $datos['EMPRESA'] as $indice => $empresa ){
			$empresas[$empresa] = $empresa;
			$alertas[$datos['TIPO'][$indice]] = $datos['TIPO'][$indice];
			$valores[$datos['TIPO'][$indice]][$empresa] = $datos['TOTAL'][$indice];
		}
		foreach( $valores as $valor => $empresas1 ){
			foreach( $empresas1 as $empresa => $val ){
				foreach ($alertas as $alerta ) {
					if( !is_null( $valores[$alerta][$empresa] ) ){
						$valores_1[$alerta][$empresa] = $valores[$alerta][$empresa];
					}else{
						$valores_1[$alerta][$empresa] = 0;
					}
				}
			}
		}
		
		$xml  = "<chart caption='$titulo' yAxisName='$descrip' formatNumber='0' formatNumberScale='0' showValues='1' showLegend='0' rotatelabels='1' slantlabels='1' bgColor='FFFFFF'>";
		
		$xml .= "<categories>";
		foreach($empresas as $empresa ){
			$xml .= "<category label='$empresa'/>";
		}
		$xml .= "</categories>";
		foreach($valores_1 as $alerta => $alertas ){
			$xml .= "<dataset seriesname='$alerta'>";
			foreach( $alertas as $empresa => $total ){
				$xml .= "<set value='$total' link='javascript:getDetalleDiv(%22$alerta%22, %22$empresa%22, %22$div_alma%22, %22$empr%22, %22$div_anterior%22)' />";
			}
			$xml .= "</dataset>";		
		}
		$xml .= "</chart>";	
		$rand = rand();
		?>
			<script type="text/javascript">
				var myChart = new FusionCharts("<?=$home?>/graficos/Charts/StackedBar2D.swf", "myChartId_<?=$rand?>", "100%", "400", "FFFFFF", "exactFit");
	    		myChart.setDataXML("<?=$xml?>");
	    		myChart.render("<?=$div?>");
			</script>
		<?	
	}
	
	public function formDetalleReporteBasic($estado, $div, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if($div == 'div_estados'){
			$datos = self::$db->getDetalleOrdenEstado($estado, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		}elseif($div == 'div_areas'){
			$datos = self::$db->getDetalleOrdenArea($estado, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		}elseif($div == 'div_empresas'){
			$datos = self::$db->getDetalleOrdenEmpresa($estado, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		}
		echo parent::listaHtml($datos, $params);
	}	
	
	public function formDetalleReporteAvanz($alerta, $empresa, $div, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if($div == 'div_pendientes'){
			$datos = self::$db->getEscalamientosPendientes($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$datosDetalle = self::$db->getEscalamientosPendientesDetalle($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$titulo = 'Cantidad Escalamientos por Estado - Tiempo en Pendiente';
		}elseif($div == 'div_ejecucion'){
			$datos = self::$db->getEscalamientosEjecucion($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$datosDetalle = self::$db->getEscalamientosEjecucionDetalle($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$titulo = 'Cantidad Escalamientos por Estado - Tiempo en Ejecucion';
		}else if($div == 'div_pendientes_treal'){
			$datos = self::$db->getEscalamientosPendientesTreal($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$datosDetalle = self::$db->getEscalamientosPendientesDetalleTreal($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$titulo = 'Cantidad Escalamientos por Estado - Tiempo en Pendiente TiempoReal';
		}else if($div == 'div_ejecucion_treal'){
			$datos = self::$db->getEscalamientosEjecucionTreal($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$datosDetalle = self::$db->getEscalamientosEjecucionDetalleTreal($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$titulo = 'Cantidad Escalamientos por Estado - Tiempo en Ejecucion TiempoReal';
		}else if($div == 'div_estados'){
			$datosDetalle = self::$db->getDetalleOrdenEstado($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
			$titulo = 'Cantidad Escalamientos por Estado - Tiempo en Ejecucion TiempoReal';
		}
		$ran = rand();
		$div_alma = "DetalleAvanz_".$ran;
		
			if ($div != 'div_estados'){?>	
			<div id="GraficoAvanz"><?=self::getGraficoTiemposDetalle($datos, $titulo, 'Numero de Escalamientos', 'GraficoAvanz', $empresa, $div, $div_alma)?></div>
			<? } ?>
			<div id="DetalleAvanz_<?=$ran?>"><?=parent::listaHtml($datosDetalle, $params)?></div>		
		<?
	}	
	
	public function getDetalleAvanzDiv($alerta, $usuario, $empresa, $div, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if($div == 'div_pendientes'){
			$datos = self::$db->getEscalamientosPendientesDetalleUsuario($alerta, $usuario, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		}elseif($div == 'div_ejecucion'){
			$datos = self::$db->getEscalamientosEjecucionDetalleUsuario($alerta, $usuario, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		}elseif($div == 'div_pendientes_treal'){
			$datos = self::$db->getEscalamientosPendientesDetalleUsuarioTreal($alerta, $usuario, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		}elseif($div == 'div_ejecucion_treal'){
			$datos = self::$db->getEscalamientosEjecucionDetalleUsuarioTreal($alerta, $usuario, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad);
		}
		echo parent::listaHtml($datos, $params);
	}		
	
	function multiple2($data=array(),$params=array()){
		$name = (isset($params['name']))?$params['name']:'check';
		$action = (isset($params['onChange']))?$params['onChange']:'';
		$size = (isset($params['size']))?$params['size']:'20';
		$width = (isset($params['width']))?$params['width']:'200px';
		$def = (isset($params['default']))?$params['default']:'';
		$defa = explode(",", $def);
		$hmtl="";
		$n = count($data[ID]);
		$html.="<select multiple id=\"$name\" onchange=\"$action\" size=\"$size\" name=\"$name\" style=\"width:".$width." \" >";

		for ($i = 0; $i < $n ; $i++){
			for ($j=0; $j < count($defa) ; $j++) {
				if ($defa[$j] != 'null'){	 
					if ($data[ID][$i] == $defa[$j]){
						$sel[$i] = "selected";
					}
				}
			}
			$html.="<option value='".$data[ID][$i]."' $sel[$i] >".$data[NAME][$i]."</option>";
		}

		$html.="</select>";
		return $html;
	}
	
	public function VerOrdenesFinaliza($escala, $terr, $reg, $localidad, $empresa, $fdesde, $fhasta){
		$fpenDesde = ($fdesde == '') ? date('d/m/Y', strtotime( "- 365 days" )) : $fdesde ;
		$fpenHasta = ($fhasta == '') ? date('d/m/Y') : $fhasta ;
		$permiso = self::$db->permisoUsuario($_SESSION[user][id]);
		$fina = self::$db->BuscarOrdenFinaF($escala, $terr, $reg, $localidad, $empresa, $fpenDesde, $fpenHasta);

		$precer = self::$db->BuscarOrdenPrecer($escala, $terr, $reg, $localidad, $fpenDesde, $fpenHasta);

		for ($i=0; $i < count($fina['ID_ESCALAMIENTO']); $i++) { 

			//$horas = round($fina['SEMAFORO'][$i] / 60);
			//$minutos = round($fina['SEMAFORO'][$i] % 60);
			$minutos = $fina['SEMAFORO'][$i] % 60;
			$horas =   round(($fina['SEMAFORO'][$i]-$minutos) / 60);	

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}
			
			$fina['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' onClick='verOrdenMortem(".$fina['ID_ESCALAMIENTO'][$i].")'>".$fina['ID_ESCALAMIENTO'][$i]."</a>";

			if ($tempHoras <= 48 ) {
				$fina['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
			} else {
				if (($tempHoras >= 49 ) && ($tempHoras <= 71 )) {
					$fina['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {	
					if ($tempHoras >= 72 ) {
						$fina['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					}	
				} 
			}
		}

		for ($i=0; $i < count($precer['ID_ESCALAMIENTO']); $i++) { 

			$minutos = $precer['SEMAFORO'][$i] % 60;
			$horas =   round(($precer['SEMAFORO'][$i]-$minutos) / 60);	

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}


			$temp = $precer['ID_ESCALAMIENTO'][$i];			
			$conta = self::$db->buscarReescalados($temp);

			if ($conta[0][0] >= 2)  {
				$precer['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' style='background-color:red' onClick='comentaOrdenPrecer(".$precer['ID_ESCALAMIENTO'][$i].")'>".$precer['ID_ESCALAMIENTO'][$i]."</a>";
			} else {
				$precer['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' onClick='comentaOrdenPrecer(".$precer['ID_ESCALAMIENTO'][$i].")'>".$precer['ID_ESCALAMIENTO'][$i]."</a>";
			}

			$precer['Semaforo'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$precer['Semaforo'][$i].'</label>';
			
			if ($tempHoras <= 48 ) {
				$precer['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
			} else {
				if (($tempHoras >= 49 ) && ($tempHoras <= 71 )) {
					$precer['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {	
					if ($tempHoras >= 72 ) {
						$precer['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					}	
				} 
			}			
		}


		$tabla1 = array( "firstColumnId"=>true, "showFirstColumn"=>true, "style"=>"width:100%", "tipoOrden"=>"desc" );
		$params1["tr"] = array("onMouseOver"=>"$(this).addClass('ui-state-active')", "onMouseOut"=>"$(this).removeClass('ui-state-active')","onClick"=>"");
		$params1['td'] = $td; 
		$params1['tabla'] = $tabla1;
		

		$tabla2 = array( "firstColumnId"=>true, "showFirstColumn"=>true, "style"=>"width:100%" );
		$params2["tr"] = array("onMouseOver"=>"$(this).addClass('ui-state-active')", "onMouseOut"=>"$(this).removeClass('ui-state-active')","onClick"=>"");
		$params2["tr"] = array("onMouseOver"=>"$(this).addClass('ui-state-active')", "onMouseOut"=>"$(this).removeClass('ui-state-active')","onClick"=>"");
		$params2['td'] = $td; 
		$params2['tabla'] = $tabla2;

		$rand = rand();
	?>
	<div id="modal_servicio_fina"></div>
		<form name="formulario4" id="formulario4">
				<div id="Filtros">
					<h3><a href="#"><div align="left"><b>Filtros</b></div></a></h3>
					<div>
						<table width="100%">
						<tr>
							<td width='40%'>Ingrese Territorio:</td>
							<td width='40%'>Ingrese Comuna:</td>
							<!-- <td width='40%'>Ingrese Area:</td> -->
						</tr>
						<tr>
							<td><div id="div_territorio"><?=self::multiple2(self::$db->getTerritorio(),array( "name"=>"Fterritorio", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selTerritorioF();", "default"=>$terr ))?></div></td>
							<td><div id="div_comuna"><?=self::multiple2(self::$db->getComuna($terr, $reg),array( "name"=>"Fcomuna", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selLocalidadF();", "default"=>$loc ))?></div></td>
							<!-- <td><?=self::multiple2(self::$db->getEscalamientos(),array( "name"=>"Fescalamientos", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selEscalaF();", "default"=>$escala ))?></td> -->
						</tr>
						<tr><td><br /></td></tr>
						<!--<tr>	
							<td width='40%'>Ingrese Empresa:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>	
							<td><?=self::multiple2(self::$db->getEmpresa(),array( "name"=>"Fempresa", "size"=>"5", "width"=>"300px","onChange"=>"javascript:selEmpresaF();", "default"=>$empresa ))?></td>
							<td></td>
							
						</tr> -->
						<tr><td><br /></td></tr>
						<tr>
							<td width='40%'>Ingrese Fecha Escalamiento:</td>	
							<td><?php echo parent::inputFecha("FfechaDesde", array("onChange"=>"javascript:selTerritorioF();", "value"=>$fpenDesde ))?><?php echo parent::inputFecha("FfechaHasta", array("onChange"=>"javascript:selTerritorioF();", "value"=>$fpenHasta))?></td>
							<td>&nbsp;</td>
						</tr>
					</table>
					</div>		
				</div>

				<div id="OrdenesPrecerradas">
					<h3><a href="#"><div align="left"><b>Ordenes Pre-cerradas</b></div></a></h3>
					<div id="precer_orden"><?=parent::listaHtml($precer, $params2)?></div>
				</div>

				<div id="OrdenesFinalizadas">
					<h3><a href="#"><div align="left"><b>Ordenes Finalizadas</b></div></a></h3>
					<div id="fina_orden"><?=parent::listaHtml($fina, $params1)?></div>
				</div>
		<div id="modal_servicio"></div>	
		<div id="modal_servicio_nuevo"></div>		
		</form>
		
		<script type="text/javascript">
			$("#Filtros").accordion({ collapsible: true,autoHeight: false   });
			$("#OrdenesPrecerradas").accordion({ collapsible: true,autoHeight: false   });
	        $("#OrdenesFinalizadas").accordion({ collapsible: true,autoHeight: false   });
		</script>		

		
		<div id="div_enviaMail"></div>
	<?	
	}	
	
	public function estadoCerrarEscalamiento($valor, $id){
		$resp = self::$db->estadoCerrarEscalamiento($valor, $id);
		echo $resp['codigo'];
	}	
	
	public function getFiltroListaOrden(){
?>
		<table align="center">
			<tr>
				<td width='20%' class="cuadrotexto"><b>Desde</b></td>	
				<td width='20%' class="cuadrotexto">
					<?php echo parent::inputFecha("LfechaDesde", array( "value"=>date( 'd/m/Y', strtotime( "-7 day" ) ) ))?>
				</td>
				<td width='20%' class="cuadrotexto"><b>Hasta</b></td>	
				<td width='20%' class="cuadrotexto">
					<?php echo parent::inputFecha("LfechaHasta", array( "value"=>date( 'd/m/Y' ) ))?>
				</td>
				<td width='20%' class="cuadrotexto">
					<input type="button" id="id_lista_orden" name="buscar" value="Generar Listado" onclick="buscarEscalamiento();" />
				</td>			
			</tr>
		</table>
		<div id="listado_ordenes"></div>
		<script language="javascript">
			$('#id_lista_orden').click();
		</script>
<?
	}

	public function getListaOrden( $fecha_desde, $fecha_hasta){
		$resp = self::$db->getListadoOrdenes( $fecha_desde, $fecha_hasta );
		for ($i=0; $i < count($resp['ID_ESCALAMIENTO']); $i++) { 
			$minutos = $resp['SEMAFORO'][$i] % 60;
			$horas =   round(($resp['SEMAFORO'][$i]-$minutos) / 60);

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}
			
			if ($resp['SEMAFORO'][$i] <= 30 ) {
				$resp['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
			} else {
				if (($resp['SEMAFORO'][$i] >= 31 ) && ($pend['SEMAFORO'][$i] <= 60 )) {
				$resp['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {	
					if ($resp['SEMAFORO'][$i] >= 61 ) {
						$resp['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					}	
				} 
			}
			
		}
		echo "<br><p style='text-align:center;font-size:15px'><b>Listado de Ordenes desde ".$fecha_desde." hasta ".$fecha_desde."</b></p>";
		echo parent::listaHTML( $resp );
	}
	
	public function getAsignarOrden(){
		$pend = self::$db->getListadoOrdenesPendientes();
		for ($i=0; $i < count($pend['ID_ESCALAMIENTO']); $i++) { 
			$minutos = $pend['SEMAFORO'][$i] % 60;
			$horas =   round(($pend['SEMAFORO'][$i]-$minutos) / 60);

			$tempHoras=$horas;

			if ($horas >= 24) {	
				$horas = $horas % 24;
				$dias = ($tempHoras-$horas) / 24;
				$newsemaforo[$i] = $dias.'d,'.$horas.'h:' .$minutos.'m';
			} else {
				$newsemaforo[$i] = $horas.'h:' .$minutos.'m';
			}


			$pend['ID_ESCALAMIENTO'][$i] = "<a class='tc' href='#' onClick='reAsignarOrden(".$pend['ID_ESCALAMIENTO'][$i].")'>".$pend['ID_ESCALAMIENTO'][$i]."</a>";
			if ($pend['SEMAFORO'][$i] <= 30 ) {
				$pend['SEMAFORO'][$i] = '<label style="background-color:green;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
			} else {
				if (($pend['SEMAFORO'][$i] >= 31 ) && ($pend['SEMAFORO'][$i] <= 60 )) {
				$pend['SEMAFORO'][$i] = '<label style="background-color:orange;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
				} else {	
					if ($pend['SEMAFORO'][$i] >= 61 ) {
						$pend['SEMAFORO'][$i] = '<label style="background-color:red;color:white; font-size:13px">'.$newsemaforo[$i].'</label>';
					}	
				} 
			}
		}
		echo "<br><p style='text-align:center;font-size:15px'><b>Listado de Ordenes Pendientes</b></p>";
		echo parent::listaHTML( $pend );
		echo "<div id='reasignar_ordenes'></div>";
	}
	
	public function getReasigarOrdenes( $id_escalamiento ){
?>
		<table width="100%">
			<tr>
				<td class="cuadrotexto" colspan="2" style="text-align:center"><b>Asignar Ordenes Pendientes</b></td>
			</tr>
			<tr>
				<td class="cuadrotexto"><b>Id Escalamiento</b></td>
				<td class="cuadrotexto"><?=$id_escalamiento?></td>
			</tr>
			<tr>
				<td class="cuadrotexto"><b>Usuario a Asignar</b></td>
				<td class="cuadrotexto">
					<input type="text" name="nombre_usuario" id="nombre_usuario" size="30" value="" />
					<input type="hidden" name="id_usuario" id="id_usuario" size="30" value="<?=$id_sol?>" maxlength="30" />
				</td>
			</tr>
			<tr>
				<td class="cuadrotexto">&nbsp;</td>
				<td class="cuadrotexto">
					<input type="button" name="boton" id="boton" onclick="javascript:guardarAsignado( '<?=$id_escalamiento?>' )" value="Grabar Usuario Asignado" />
				</td>
			</tr>
		</table>
		<div id="guarda_asigna_orden"></div>
		<script type="text/javascript">
	 			$(document).ready(function() {
		             $('#nombre_usuario').autocomplete('autocompletar_usuarios.php', {
		             width: 400,
		             minChars: 3,
		             selectFirst: false,
		             highlightItem: false
		            });
		             $('#nombre_usuario').result(function(event, data, formatted) { //nombre_usuario
		             if (data) {
		             $('#id_usuario').val(data[1]); //id_usuario
		             $('#nombre_usuario').val(data[2]); //nombre_usuario
		             }
		            });
		            $('#nombre_usuario').focus().select(); //nombre_usuario
		             });
	 </script>
<?		
	}

	public function guardarAsignarOrden( $id_escalamiento, $id_usuario ){
		$result = self::$db->updAsignarOrden( $id_escalamiento, $id_usuario );
		if( $result['codigo'] == 1 ){
			self::$db->LogupdAsignarOrden( $id_escalamiento, $id_usuario );
?>
			<script language="javascript">
				alert( 'Asignacion de Orden realizada exitosamente');
				$('#reasignar_ordenes').dialog("close");
				var pesta = $("#maintab").tabs();  
	    		pesta.tabs("enable", 4); 
	    		pesta.tabs("load", 4);
			</script>
<?			
		}else{
?>
			<script language="javascript">
				alert( 'Error en la asignacion de Orden...');
			</script>
<?			
		}
	}
}