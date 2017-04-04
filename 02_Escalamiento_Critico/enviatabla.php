<?	
    //$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.17.97.37)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=reponnoc)))";
	$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = alicanto-scan.vtr.cl)(PORT = 1521)))(CONNECT_DATA=(SERVICE_NAME=orannoc.vtr.cl)))";
    $conn = oci_pconnect("nnoc","noc.,vtr",$db,"WE8ISO8859P1") or die ('No me pude conectar a la base de datos<br>');

	$sql="select * from (
			select count(distinct id_escalamiento) total, TN.DESCRIPCION, 'Ingresadas' estado, '1' orden
			                from goc.escalamiento_ordenes_c o
			                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
			                inner join NNOC.TERR_COMUNA_c tc on TC.LOCALIDAD = O.LOCALIDAD
			                inner join NNOC.TERR_TERRITORIO_c tt on TC.ID_COMUNA = TT.ID_COMUNA
			                inner join NNOC.TERR_EMPRESA_c te on TE.ID_EMPRESA = TT.ID_EMPRESA
			                inner join NNOC.TERR_NOMBRE_C tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
			                group by TN.DESCRIPCION
			union all
			select count(distinct id_escalamiento) total, TN.DESCRIPCION, ES.DESCRIPCION estado, '4' orden
			                from goc.escalamiento_ordenes_c o
			                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
			                inner join NNOC.TERR_COMUNA_c tc on TC.LOCALIDAD = O.LOCALIDAD
			                inner join NNOC.TERR_TERRITORIO_c tt on TC.ID_COMUNA = TT.ID_COMUNA
			                inner join NNOC.TERR_EMPRESA_c te on TE.ID_EMPRESA = TT.ID_EMPRESA
			                inner join NNOC.TERR_NOMBRE_C tn on TN.ID_NOMBRE = TT.ID_NOMBRE
			                where O.ESTADO = 1 and trunc(O.FECHA_PENDIENTE) = trunc(sysdate) 
			                group by TN.DESCRIPCION, ES.DESCRIPCION
			union all
			select count(distinct id_escalamiento) total, TN.DESCRIPCION, ES.DESCRIPCION estado, '3' orden
			                from goc.escalamiento_ordenes_c o
			                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
			                inner join NNOC.TERR_COMUNA_c tc on TC.LOCALIDAD = O.LOCALIDAD
			                inner join NNOC.TERR_TERRITORIO_c tt on TC.ID_COMUNA = TT.ID_COMUNA
			                inner join NNOC.TERR_EMPRESA_c te on TE.ID_EMPRESA = TT.ID_EMPRESA
			                inner join NNOC.TERR_NOMBRE_C tn on TN.ID_NOMBRE = TT.ID_NOMBRE
			                where O.ESTADO = 2  
			                group by TN.DESCRIPCION, ES.DESCRIPCION
			union all                
			select count(distinct id_escalamiento) total, TN.DESCRIPCION, ES.DESCRIPCION estado, '2' orden
			                from goc.escalamiento_ordenes_c o
			                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
			                inner join NNOC.TERR_COMUNA_c tc on TC.LOCALIDAD = O.LOCALIDAD
			                inner join NNOC.TERR_TERRITORIO_c tt on TC.ID_COMUNA = TT.ID_COMUNA
			                inner join NNOC.TERR_EMPRESA_c te on TE.ID_EMPRESA = TT.ID_EMPRESA
			                inner join NNOC.TERR_NOMBRE_C tn on TN.ID_NOMBRE = TT.ID_NOMBRE
			                where O.ESTADO = 3 
			                group by TN.DESCRIPCION, ES.DESCRIPCION
			union all
			select count(distinct id_escalamiento) total, TN.DESCRIPCION, 'Pendientes Vencidos' estado, '6' orden
			                from goc.escalamiento_ordenes_c o
			                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
			                inner join NNOC.TERR_COMUNA_c tc on TC.LOCALIDAD = O.LOCALIDAD
			                inner join NNOC.TERR_TERRITORIO_c tt on TC.ID_COMUNA = TT.ID_COMUNA
			                inner join NNOC.TERR_EMPRESA_c te on TE.ID_EMPRESA = TT.ID_EMPRESA
			                inner join NNOC.TERR_NOMBRE_C tn on TN.ID_NOMBRE = TT.ID_NOMBRE
			                where O.ESTADO = 1 and trunc(O.FECHA_PENDIENTE) < trunc(sysdate) 
			                group by TN.DESCRIPCION
			union all
			select count(distinct id_escalamiento) total, TN.DESCRIPCION, ES.DESCRIPCION estado, '5' orden
                            from goc.escalamiento_ordenes_c o
                            inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                            inner join NNOC.TERR_COMUNA_c tc on TC.LOCALIDAD = O.LOCALIDAD
                            inner join NNOC.TERR_TERRITORIO_c tt on TC.ID_COMUNA = TT.ID_COMUNA
                            inner join NNOC.TERR_EMPRESA_c te on TE.ID_EMPRESA = TT.ID_EMPRESA
                            inner join NNOC.TERR_NOMBRE_C tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                            where O.ESTADO = 4 
                            group by TN.DESCRIPCION, ES.DESCRIPCION			                
			) h
			order by h.orden, h.descripcion";
	$parse=oci_parse($conn, $sql);
	$resp=oci_execute($parse, OCI_DEFAULT);		
	 
		while($arr_data=oci_fetch_array($parse, OCI_NUM)){
			$arr_todo[$arr_data[2]][$arr_data[1]]=$arr_data[0];
			$arr_area[$arr_data[1]]=$arr_data[1];
		}
		
		foreach ($arr_area as $area =>$res1){
			foreach ($arr_todo as $estado =>$res2){
				if( !is_null( $arr_todo[$estado][$area] ) ){
					$arr_todo[$estado][$area] = $arr_todo[$estado][$area];
				}else{
					$arr_todo[$estado][$area] = 0;
				}
			}
		}

		$strHtml.="<label style='color: #999999;font-size: 11px;font-family:verdana;font-weight:bold;'>Estimados:<br>
					A continuacion les indicamos el estatus de los escalamientos, la informacion está actualizada a las 17:30.<br>
					Para revisar el detalle de ellos, debes ingresar al siguiente link:<br>
					<a href='http://nnoc.vtr.cl/escalamientos/?app=APP1716'>http://nnoc.vtr.cl/escalamientos/?app=APP1716</a><br><br></label>";
		$strHtml.="<table border='0' style='background-color: #dddddd;border: #aaaaaa;border-style: solid;border-top-width: 1px;border-right-width: 1px;border-bottom-width: 1px;border-left-width: 1px;text-align: center;color: #000088;font-family: Tahoma, Arial, Helvetica, sans-serif;font-size: 14px;' width='80%'>
		<tr style='background-color: #dddddd;border: #dddddd;padding-top: 3px;padding-right: 3px;padding-bottom: 3px;padding-left: 3px;text-align: center;color: #000088;font-weight: bold;font-family: Arial, Helvetica, sans-serif;font-size: 11px;border-style: solid;border-top-width: 1px;border-right-width: 1px;border-bottom-width: 1px;border-left-width: 1px;'>
		<td>Territorio</td><td>Ingresadas</td>
		<td>Finalizados</td><td>En Ejecucion</td>
		<td>Pendientes</td><td>Anuladas</td>
		<td>Pendientes Vencidos</td><td>Total</tr>";
		$a=0;
		foreach ($arr_area as $area =>$res1){
			$totArea=0;
			if($a%2==0){
				$color="bgcolor='#eeeeee'";
			}else{
				$color="bgcolor='#ffffff'";
			}
			$strHtml.="<tr ".$color." ><td style='color: #666666;font-size: 11px;font-family:verdana;font-weight:bold;'>".$area."</td>";
			foreach ($arr_todo as $estado =>$res2){
					$enla=$arr_todo[$estado][$area];  
					if ( $estado != 'Ingresadas'){ $totArea+=$arr_todo[$estado][$area]; } 
					$strHtml.="<td style='font-family:Verdana;color:#000088;font-size:10px;text-align:center;padding-left:5px;'>".$enla."</td>";
					if ( $estado != 'Ingresadas'){ $totales[$i]+=$arr_todo[$estado][$area]; }
			}
			$enlaTot=$totArea;
			$strHtml.="<td style='font-family:Verdana;color:#000088;font-size:10px;text-align:center;padding-left:5px;'>".$enlaTot."</td>";
			$totales[6]+=$totArea;
			$strHtml.="</tr>";
			$a++;
		}
		$enlaTotal0=$totales[0];
		$enlaTotal1=$totales[1];
		$enlaTotal2=$totales[2];
		$enlaTotal3=$totales[3];
		$enlaTotal4=$totales[4];
		$enlaTotal5=$totales[5];
		$enlaTotal6=$totales[6];
		
		$strHtml.="<tr><td>Totales</td><td>".$enlaTotal0."</td><td>".$enlaTotal1."</td><td>".$enlaTotal2."</td>
		<td>".$enlaTotal3."</td><td>".$enlaTotal4."</td><td>".$enlaTotal5."</td><td>".$enlaTotal6."</td></tr>";
		$strHtml.="</table><br><br>";
		 
       $cuerpo_correo=$strHtml;
		echo $cuerpo_correo;
		

       //////////Saca los repetidos del mail destino y deja solo uno
       $explode_mail_destino=explode(',',$mail_destino);
      
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
       $mail_destino=$temp_mail;  ////Final y asignacion
      
 
       //////////Fin de rutina sacar repetidos	
 //*****************CORREO*************************************************/
//$sql_mail="begin NNOC.ENVIARCORREO_LONG1(:Par_Remitente,:Par_Destinatarios,:Par_Asunto,:Par_Mensaje); end;"; 
 
//$parse_mail=ociparse($conn,$sql_mail);
//              oci_bind_by_name($parse_mail,":Par_Remitente",$_GET['remitente']);
//              oci_bind_by_name($parse_mail,":Par_Destinatarios",$_GET['destino']);
//              oci_bind_by_name($parse_mail,":Par_Asunto",$_GET['asunto']);
//              oci_bind_by_name($parse_mail,":Par_Mensaje",$_GET['cuerpo']);
              //oci_bind_by_name($parse_mail,":Par_Server",$servidor); 
//              $rs_mail=oci_execute($parse_mail, OCI_DEFAULT) or die ('No se pudo ejecutar la sentencia');        
 ?>