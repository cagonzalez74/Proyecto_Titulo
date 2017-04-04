<?php
require_once($_SERVER['DOCUMENT_ROOT']."/_class/DBConneccion.class.php");

class todoDB extends DBConneccion {

	public function  __construct(){
		//parent::__construct("alicanto");
		//parent::__construct("desa");
		parent::__construct();
	}

	//ESC_CRIT
	public function qry_combotipo(){			

		$sql = "SELECT id_tipo, descripcion FROM GOC.ESCALAMIENTO_TIPO_C
				WHERE ESTADO = 1";

		return self::consulta($sql);
	}

	public function qry_combomotivo(){			

		$sql = "SELECT id_motivo, descripcion FROM GOC.ESCALAMIENTO_MOTIVO_C
				WHERE ESTADO  = 1
				ORDER BY ID_MOTIVO DESC";

		return self::consulta($sql);
	}

	public function GuardarEscalamiento($id_esca){
		GLOBAL $id_usuario_temp;


			$sql="INSERT INTO goc.escalamiento_ordenes_c (
                                        NMRO_ORDEN,
                                        FECHA_INGRESO,
                                        FECHA_CREACION,
                                        FECHA_COMPROMISO,
                                        ESTC_ACTIV_TECNICO,
                                        CODI_AREAFUN,
                                        DESC_AREAFUN,
                                        OBSERVACION,
                                        ID_ASIGNADO,
                                        AREA_ESCALA,
                                        COD_HORARIO,
                                        RUT_PERSONA,
                                        NOMBRE_CLIENTE,
                                        DIRECCION,
                                        LOCALIDAD,
                                        NODO,
                                        FECHA_PENDIENTE,
                                        NUEVAOBSERVA,
                                        TIPO_ESCALAMIENTO,
                                        SERVICIO_TV,
                                        SERVICIO_PREMIUM,
                                        SERVICIO_TELEFONO,
                                        SERVICIO_INTERNET,
                                        CORREO_ELECTRONICO,
                                        MOTIVO_ESCALAMIENTO,
                                        ID_CREADOR,
                                        ACTIVIDAD,
                                        ID_ESCALAMIENTO,
                                        NMRO_ORDEN_INT,
                                        FECHA_EJECUCION,
                                        ESTADO
                                        )
SELECT  NMRO_ORDEN,
                                        FECHA_INGRESO,
                                        FECHA_CREACION,
                                        FECHA_COMPROMISO,
                                        ESTC_ACTIV_TECNICO,
                                        CODI_AREAFUN,
                                        DESC_AREAFUN,
                                        OBSERVACION,
                                        ID_ASIGNADO,
                                        AREA_ESCALA,
                                        COD_HORARIO,
                                        RUT_PERSONA,
                       NOMBRE_CLIENTE,
                       DIRECCION,
                       LOCALIDAD,
                       NODO,
                       FECHA_PENDIENTE,
                       NUEVAOBSERVA,
                       TIPO_ESCALAMIENTO,
                       SERVICIO_TV,
                       SERVICIO_PREMIUM,
                       SERVICIO_TELEFONO,
                       SERVICIO_INTERNET,
                       CORREO_ELECTRONICO,
                       MOTIVO_ESCALAMIENTO,
                       ID_CREADOR,
                       ACTIVIDAD, 
                       (GOC.SEC_ESCALAMIENTO_C.nextval) id_escalamiento,
                       NMRO_ORDEN_INT,
                       sysdate,
                       2           
FROM goc.escalamiento_ordenes_c WHERE id_escalamiento = :VAL";

			$par[":VAL"]  = array($id_esca,-1,SQLT_CHR);

			return self::upsert($sql,$par);

	}	


	public function guarda_correo($correo){
		GLOBAL $id_usuario_temp;
		
			$sql="INSERT INTO goc.escalamiento_registropdf_c (id_escalamiento,
                                            usuario,
                                            fecha,
                                            archivo)
     VALUES ( (SELECT MAX (id_escalamiento)
                 FROM goc.escalamiento_ordenes_c
                WHERE id_creador = :IUSER),
             :IUSER,
             SYSDATE,
             :ARCHIVO)";

			$par[":IUSER"]  = array($id_usuario_temp,-1,SQLT_CHR);
			$par[":ARCHIVO"]  = array($correo,-1,SQLT_CHR);

			return self::upsert($sql,$par);
	}

	public function GuardarEscalamientoNuevo($RUTP, $NOMB, $DIRE, $LOCA, $NODO, $TI_ESC, $OBSN, $SER_TV, $SER_PRE, $SER_FONO, $SER_INET, $MOTI_ESC, $MOTIVO_DESC, $CORREO){
		GLOBAL $id_usuario_temp;
	
			$sql="INSERT INTO goc.escalamiento_ordenes_c (RUT_PERSONA, NOMBRE_CLIENTE, DIRECCION, LOCALIDAD, NODO,FECHA_PENDIENTE, TIPO_ESCALAMIENTO, NUEVAOBSERVA, SERVICIO_TV, SERVICIO_PREMIUM, SERVICIO_TELEFONO, SERVICIO_INTERNET, CORREO_ELECTRONICO, MOTIVO_ESCALAMIENTO, ACTIVIDAD, ID_CREADOR, ID_ESCALAMIENTO, NMRO_ORDEN_INT, ESTADO) VALUES ( :RUT_PERSONA, :NOMBRE_CLIENTE, :DIRECCION, :LOCALIDAD, :NODO, SYSDATE, :TIPO_ESCALAMIENTO, :NUEVAOBSERVA, :SERVICIO_TV, :SERVICIO_PREMIUM, :SERVICIO_TELEFONO, :SERVICIO_INTERNET, :CORREO, :MOTIVO_ESCALAMIENTO, :ACTIVIDAD, :USER2, (GOC.SEC_ESCALAMIENTO_C.nextval), (GOC.SEC_NROORDENINT_C.nextval), 1)";

			$par[":RUT_PERSONA"]  = array($RUTP,-1,SQLT_CHR);
			$par[":NOMBRE_CLIENTE"]  = array($NOMB,-1,SQLT_CHR);
			$par[":DIRECCION"]  = array($DIRE,-1,SQLT_CHR);
			$par[":LOCALIDAD"]  = array($LOCA,-1,SQLT_CHR);
			$par[":NODO"]  = array($NODO,-1,SQLT_CHR);
			$par[":CORREO"]  = array($CORREO,-1,SQLT_CHR);

			$par[":TIPO_ESCALAMIENTO"]  = array($TI_ESC,-1,SQLT_CHR);
			$par[":NUEVAOBSERVA"]  = array($OBSN,-1,SQLT_CHR);
			$par[":SERVICIO_TV"]  = array($SER_TV,-1,SQLT_CHR);
			$par[":SERVICIO_PREMIUM"]  = array($SER_PRE,-1,SQLT_CHR);
			$par[":SERVICIO_TELEFONO"]  = array($SER_FONO,-1,SQLT_CHR);
			$par[":SERVICIO_INTERNET"]  = array($SER_INET,-1,SQLT_CHR);
			$par[":MOTIVO_ESCALAMIENTO"]  = array($MOTI_ESC,-1,SQLT_CHR);
			$par[":ACTIVIDAD"]  = array($MOTIVO_DESC,-1,SQLT_CHR);
			$par[":USER2"]  = array($id_usuario_temp,-1,SQLT_CHR);

			return self::upsert($sql,$par);
	}



	public function ParamsGuardarEscalamientoOrden($NORDEN){
		$sql="SELECT to_char(fecha_compromiso,'DD/MM/YYYY hh24:mi:ss') fecha_compromiso,  cod_horario FROM goc.escalamiento_ordenes_c WHERE NMRO_ORDEN = :NORDEN order by id_escalamiento desc";

		$par[":NORDEN"]  = array($NORDEN,-1,SQLT_CHR);

		return self::consulta($sql,$par);
	}	

	public function GuardarEscalamientoOrden($RUT, $NOMBRE, $DIRECCION, $LOCALIDAD, $NODO, $TI_ESC, $OBSN, $SER_TV, $SER_PRE, $SER_FONO, $SER_INET, $MOTI_ESC, $NORDEN, $FINGRESO, $OBSERORI, $MOTIVO_DESC, $FECHA_COMPROMISO, $COD_HORARIO){
		GLOBAL $id_usuario_temp;

		$sql="INSERT INTO goc.escalamiento_ordenes_c (ID_ESCALAMIENTO,RUT_PERSONA,NOMBRE_CLIENTE,DIRECCION,LOCALIDAD,NODO,FECHA_PENDIENTE,NUEVAOBSERVA,TIPO_ESCALAMIENTO,SERVICIO_TV,SERVICIO_PREMIUM,SERVICIO_TELEFONO,SERVICIO_INTERNET,CORREO_ELECTRONICO, ESTADO, MOTIVO_ESCALAMIENTO, ID_CREADOR, NMRO_ORDEN, FECHA_INGRESO, OBSERVACION, ACTIVIDAD, FECHA_COMPROMISO, COD_HORARIO, NMRO_ORDEN_INT)VALUES ((GOC.SEC_ESCALAMIENTO_C.nextval),:RUTP,:NOMB,:DIRE,:LOCA,:NODO,sysdate,:OBSN,:TI_ESC,:SER_TV,:SER_PRE,:SER_FONO,:SER_INET,'correo@vtr.cl',1, :MOTI_ESC, :ID_CREADOR, :NORDEN, to_date(:FINGRESO, 'DD/MM/YYYY HH24:MI:SS'), :OBSERORI, :MOTIVO_DESC, to_date(:FECHA_COMPROMISO,'DD/MM/YYYY hh24:mi:ss'), :COD_HORARIO, (GOC.SEC_NROORDENINT_C.nextval))";

			$par[":RUTP"]  = array($RUT,-1,SQLT_CHR);
			$par[":NOMB"]  = array($NOMBRE,-1,SQLT_CHR);
			$par[":DIRE"]  = array($DIRECCION,-1,SQLT_CHR);
			$par[":LOCA"]  = array($LOCALIDAD,-1,SQLT_CHR);
			$par[":NODO"]  = array($NODO,-1,SQLT_CHR);
			$par[":TI_ESC"]  = array($TI_ESC,-1,SQLT_CHR);
			$par[":OBSN"]  = array($OBSN,-1,SQLT_CHR);
			$par[":SER_TV"]  = array($SER_TV,-1,SQLT_CHR);
			$par[":SER_PRE"]  = array($SER_PRE,-1,SQLT_CHR);
			$par[":SER_FONO"]  = array($SER_FONO,-1,SQLT_CHR);
			$par[":SER_INET"]  = array($SER_INET,-1,SQLT_CHR);
			$par[":MOTI_ESC"]  = array($MOTI_ESC,-1,SQLT_CHR);
			$par[":ID_CREADOR"]  = array($id_usuario_temp,-1,SQLT_CHR);
			$par[":NORDEN"]  = array($NORDEN,-1,SQLT_CHR);
			$par[":FINGRESO"]  = array($FINGRESO,-1,SQLT_CHR);
			$par[":OBSERORI"]  = array($OBSERORI,-1,SQLT_CHR);
			$par[":MOTIVO_DESC"]  = array($MOTIVO_DESC,-1,SQLT_CHR);
			$par[":FECHA_COMPROMISO"]  = array($FECHA_COMPROMISO,-1,SQLT_CHR);
			$par[":COD_HORARIO"]  = array($COD_HORARIO,-1,SQLT_CHR);


			return self::upsert($sql,$par);
	}

	public function BuscarOrdenTango($valor){			
		$pos = strpos($valor, "-");
		if ($pos === false) {
			$where = " where id_escalamiento = :VAL ";
		}else{
			if ( strlen($valor) == 10 ){
				$valor = '00'.$valor;
			}else if ( strlen($valor) == 9 ){
				$valor = '000'.$valor;
			}
			$where = " where rut_persona = :VAL ";	
		}
		$sql = "SELECT id_escalamiento, nmro_orden
				        , to_char(fecha_ingreso, 'DD-MM-YYYY HH24:MI:SS') as fecha_ingreso
				        , to_char(fecha_creacion, 'DD-MM-YYYY HH24:MI:SS') as fecha_creacion
				        , to_char(fecha_compromiso, 'DD-MM-YYYY HH24:MI:SS') as fecha_compromiso
				        , rut_persona
				        , nombre_cliente
				        , direccion
				        , localidad
				        , ACTIVIDAD
				        , nodo
				        , codi_areafun
				        , desc_areafun
				        , observacion
				        , cod_horario
				        , tipo_escalamiento
                        , motivo_escalamiento       
                        , nuevaobserva
                        , servicio_tv
                        , servicio_telefono
                        , servicio_internet
                        , servicio_premium 
				from goc.escalamiento_ordenes_c ".$where;
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}		


	public function BuscarOrdenTangoEstado($valor){			
		$pos = strpos($valor, "-");
		if ($pos === false) {
			$where = " where id_escalamiento = :VAL and estado in (1,2,5) order by fecha_pendiente asc";
		}else{
			if ( strlen($valor) == 10 ){
				$valor = '00'.$valor;
			}else if ( strlen($valor) == 9 ){
				$valor = '000'.$valor;
			}
			$where = " where rut_persona = :VAL and estado in (1,2,5) order by fecha_pendiente asc";	
		}
		$sql = "SELECT id_escalamiento, nmro_orden
				        , to_char(fecha_ingreso, 'DD-MM-YYYY HH24:MI:SS') as fecha_ingreso
				        , to_char(fecha_creacion, 'DD-MM-YYYY HH24:MI:SS') as fecha_creacion
				        , to_char(fecha_compromiso, 'DD-MM-YYYY HH24:MI:SS') as fecha_compromiso
				        , rut_persona
				        , nombre_cliente
				        , direccion
				        , localidad
				        , ACTIVIDAD
				        , nodo
				        , codi_areafun
				        , desc_areafun
				        , observacion
				        , cod_horario
				        , tipo_escalamiento
                        , motivo_escalamiento       
                        , nuevaobserva
                        , servicio_tv
                        , servicio_telefono
                        , servicio_internet
                        , servicio_premium 
                        , descripcion ESTADO
                        , correo_electronico
				from goc.escalamiento_ordenes_c t1 inner join goc.escalamiento_estado_c t2 on t1.estado = t2.id_estado ".$where;
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}		

	public function BuscarOrdenTangoEstadoEsca($valor){			
		$pos = strpos($valor, "-");
		if ($pos === false) {
			$where = " where id_escalamiento = :VAL order by fecha_pendiente asc";
		}else{
			if ( strlen($valor) == 10 ){
				$valor = '00'.$valor;
			}else if ( strlen($valor) == 9 ){
				$valor = '000'.$valor;
			}
			$where = " where rut_persona = :VAL and estado in (1,2,5) order by fecha_pendiente asc";	
			//echo "RUT";
		}
		$sql = "SELECT id_escalamiento, nmro_orden
				        , to_char(fecha_ingreso, 'DD-MM-YYYY HH24:MI:SS') as fecha_ingreso
				        , to_char(fecha_creacion, 'DD-MM-YYYY HH24:MI:SS') as fecha_creacion
				        , to_char(fecha_compromiso, 'DD-MM-YYYY HH24:MI:SS') as fecha_compromiso
				        , rut_persona
				        , nombre_cliente
				        , direccion
				        , localidad
				        , ACTIVIDAD
				        , nodo
				        , codi_areafun
				        , desc_areafun
				        , observacion
				        , cod_horario
				        , tipo_escalamiento
                        , motivo_escalamiento       
                        , nuevaobserva
                        , servicio_tv
                        , servicio_telefono
                        , servicio_internet
                        , servicio_premium 
                        , descripcion ESTADO
                        , correo_electronico
				from goc.escalamiento_ordenes_c t1 inner join goc.escalamiento_estado_c t2 on t1.estado = t2.id_estado ".$where;
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}	

	public function BuscarOrdenTango2($valor){			
		$pos = strpos($valor, "-");
		if ($pos === false) {
			$where = " where id_escalamiento = :VAL ";
		}else{
			if ( strlen($valor) == 10 ){
				$valor = '00'.$valor;
			}else if ( strlen($valor) == 9 ){
				$valor = '000'.$valor;
			}
			$where = " where rut_persona = :VAL ";	
		}
		$sql = "SELECT id_escalamiento, nmro_orden
				        , to_char(fecha_ingreso, 'DD-MM-YYYY HH24:MI:SS') as fecha_ingreso
				        , rut_persona
				        , nombre_cliente
				        , direccion
				        , localidad
				        , ACTIVIDAD
				        , observacion
				        , escalamiento_tipo_c.descripcion tipo
                        , ESCALAMIENTO_MOTIVO_C.descripcion MOTIVO      
                        , nuevaobserva
				from goc.escalamiento_ordenes_c 
				inner join goc.ESCALAMIENTO_MOTIVO_C on ESCALAMIENTO_MOTIVO_C.id_motivo = escalamiento_ordenes_c.motivo_escalamiento
				inner join goc.ESCALAMIENTO_TIPO_C on escalamiento_tipo_c.id_tipo = escalamiento_ordenes_c.tipo_escalamiento ".$where;
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

public function BuscarOrdenEscalada($valor){			
		$pos = strpos($valor, "-");
		if ($pos === false) {
			$where = " where nmro_orden = :VAL ";
		}else{
			if ( strlen($valor) == 10 ){
				$valor = '00'.$valor;
			}else if ( strlen($valor) == 9 ){
				$valor = '000'.$valor;
			}
			$where = " where rut_persona = :VAL ";	
		}
		$sql = "select id_escalamiento
				        , o.nmro_orden \"Numero Orden\"
				        , AR.MOTIVO \"Motivo\"
				        , o.rut_persona \"RUT Cliente\"
				        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
				        , o.actividad \"Actividad\"
				        , to_char(O.FECHA_INGRESO, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Ingreso\"
				        , to_char(O.FECHA_CREACION , 'DD-MM-YYYY HH24:MI:SS') \"Fecha Creacion\"
				        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY HH24:MI:SS') \"Fecha Compromiso\"
				        , es.descripcion \"Estado\"
				from goc.escalamiento_ordenes_c o
				inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
				inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO ".$where;
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}


//ESC_CRIT
public function BuscarClienteTango($valor){			
		$pos = strpos($valor, "-");
		if ($pos === false) {
			$where = " where rut_persona = :VAL ";
		}else{
			if ( strlen($valor) == 10 ){
				$valor = '00'.$valor;
			}else if ( strlen($valor) == 9 ){
				$valor = '000'.$valor;
			}
			$where = " where rut_persona = :VAL ";	
		}
		$sql = "SELECT rut_persona, desc_paterno ||' '|| desc_materno ||' '|| desc_nombres as nombre_persona from sut_persona@REPONNOC_ORAC.WORLD ".$where;
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);

		return self::consulta($sql,$par);
	}

//ESC_CRIT
public function ViviendaClienteTango($valor){			
		$where = " where iden_vivienda = :VAL ";
		$sql = "SELECT * from tango.rev_vivienda@REPONNOC_ORAC.WORLD ".$where;
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);

		return self::consulta($sql,$par);
	}

//ESC_CRIT
public function getDatosIdenTango($iden, $rut){			
        $sql="SELECT * 
from goc.escalamiento_ordenes_c     
where rut_persona = :RUTP and estado in (1,2,5) and direccion =  (select direccion from tango.rev_vivienda@REPONNOC_ORAC.WORLD
where iden_vivienda = :IDENV)
order by fecha_pendiente, id_escalamiento asc";
		
		$par[":RUTP"]  = array($rut,-1,SQLT_CHR);
		$par[":IDENV"]  = array($iden,-1,SQLT_CHR);

		return self::consulta($sql,$par);
	}

//ESC_CRIT
public function DatosViviendaTango($valor){	
		if ( strlen($valor) == 10 ){
			$valor = '00'.$valor;
		}else if ( strlen($valor) == 9 ){
			$valor = '000'.$valor;
		}		

		$sql = "SELECT iden_vivienda, direccion from rev_vivienda@REPONNOC_ORAC.WORLD where iden_vivienda in (SELECT distinct iden_vivienda from sut_servicio@REPONNOC_ORAC.WORLD where rut_persona = :VAL )";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}
	
	public function getAreas(){
		$permiso = self::permisoUsusarioCav($_SESSION[user][id]);
		if ($permiso[0][0] != 1){
			$sql_where = " and id_escala <> 12 ";
		}			
		$sql = "select id_escala, motivo from goc.ESCALAMIENTO_AREA where estado = 1".$sql_where;
		
		return self::consulta($sql);
	}
	
	public function getEscalamientos(){
		$sql = "select id_area id, area name from goc.ESCALAMIENTO_AREA_ESCALA";
		
		return self::consulta($sql);
	}	

	public function getActividad(){
		$sql = "select id_escala id, motivo name from GOC.ESCALAMIENTO_AREA";
		
		return self::consulta($sql);
	}
	
	public function getAnulacion(){
		$sql = "select id_anula, motivo from goc.ESCALAMIENTOS_ANULA_C";
		
		return self::consulta($sql);
	}	
		
	public function GuardarOrden($norden, $rut, $nombre, $direccion, $localidad, $nodo, $fingreso, $fcrea, $fcompro, $area, $obserori, $codarea,$motivo, $obs, $activ, $codhorario){
		GLOBAL $id_usuario_temp;

		if ($id_usuario_temp != ''){	
			
			$par[":NORD"]  = array($norden,-1,SQLT_CHR);
			$par[":RUTP"]  = array($rut,-1,SQLT_CHR);
			$par[":NOMB"]  = array($nombre,-1,SQLT_CHR);
			$par[":DIRE"]  = array($direccion,-1,SQLT_CHR);
			$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			$par[":NODO"]  = array($nodo,-1,SQLT_CHR);
			$par[":FING"]  = array($fingreso,-1,SQLT_CHR);
			$par[":FCRE"]  = array($fcrea,-1,SQLT_CHR);
			$par[":FCOM"]  = array($fcompro,-1,SQLT_CHR);
			$par[":AREA"]  = array($area,-1,SQLT_CHR);
			$par[":OBSO"]  = array($obserori,-1,SQLT_CHR);
			$par[":CODA"]  = array($codarea,-1,SQLT_CHR);
			$par[":MOTI"]  = array($motivo,-1,SQLT_CHR);
			$par[":OBSN"]  = array($obs,-1,SQLT_CHR);
			$par[":ACTV"]  = array($activ,-1,SQLT_CHR);
			$par[":CODH"]  = array($codhorario,-1,SQLT_CHR);
			$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);


			return self::upsert($sql,$par);
		}else{
			$a['codigo'] = 2;
			return $a;
		}
	}
	
	public function BuscarOrdenAsig($escala, $terr, $reg, $localidad){
		GLOBAL $id_usuario_temp;	
		
		$sql="SELECT id_escalamiento ID_Escalamiento
                        , o.nmro_orden Numero_Orden
                        , trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) Semaforo
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') Fecha_Escalamiento
                        , o.actividad Actividad
                        , o.rut_persona RUT_Cliente
                        , trim(O.NOMBRE_CLIENTE) Nombre_Cliente
                        , o.direccion
                        , o.localidad Comuna
                        , o.nodo Nodo
                        , es.descripcion Estado 
                from goc.escalamiento_ordenes_c o
                 inner join goc.escalamiento_estado_c es on estado = id_estado
                 where o.ID_ASIGNADO = :IUSE and o.estado = 2
                 order by id_escalamiento desc";

        $par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	} 
	
	public function buscarReescalados($valor){

		$sql="SELECT COUNT (*) FROM goc.escalamiento_ordenes_c WHERE nmro_orden_int = (SELECT nmro_orden_int FROM goc.escalamiento_ordenes_c WHERE id_escalamiento = :VAL)";

	    $par[":VAL"]  = array($valor,-1,SQLT_CHR);
	    return self::consultaNum($sql,$par);
	}	

	public function getPostAcciones($valor){

		$sql="SELECT to_date(fecha_ejecucion,'dd-mm-yyyy hh24:mi:ss') fecha_ejecucion, post_mortem, nuevaobserva acciones_preventivas FROM goc.escalamiento_ordenes_c WHERE nmro_orden_int = (SELECT nmro_orden_int FROM goc.escalamiento_ordenes_c WHERE id_escalamiento = :VAL)";

	    $par[":VAL"]  = array($valor,-1,SQLT_CHR);
	    return self::consulta($sql,$par);
	}

	public function BuscarOrdenPend($escala, $terr, $reg, $localidad){
		GLOBAL $id_usuario_temp;
		
		$sql="SELECT id_escalamiento ID_Escalamiento
                        , o.nmro_orden Numero_Orden
                        , trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) Semaforo
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') Fecha_Escalamiento
                        , o.actividad Actividad
                        , o.rut_persona RUT_Cliente
                        , trim(O.NOMBRE_CLIENTE) Nombre_Cliente
                        , o.direccion
                        , o.localidad Comuna
                        , o.nodo Nodo
                        , es.descripcion Estado 
                from goc.escalamiento_ordenes_c o
                 inner join goc.escalamiento_estado_c es on estado = id_estado
                 where o.estado = 1
                 order by id_escalamiento desc";

		$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);				
		return self::consulta($sql,$par);
	} 
	
	public function BuscarOrdenEjec($escala, $terr, $reg, $localidad){
		GLOBAL $id_usuario_temp;
		$permiso = self::permisoUsuario($id_usuario_temp);
		$sql_where = "";

		$sql="SELECT id_escalamiento ID_Escalamiento
                        , o.nmro_orden Numero_Orden
                        , trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) Semaforo
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') Fecha_Escalamiento
                        , o.actividad Actividad
                        , o.rut_persona RUT_Cliente
                        , trim(O.NOMBRE_CLIENTE) Nombre_Cliente
                        , o.direccion
                        , o.localidad Comuna
                        , o.nodo Nodo
                        , es.descripcion Estado 
                from goc.escalamiento_ordenes_c o
                inner join goc.escalamiento_estado_c es on estado = id_estado
                 where o.estado = 2
                 order by id_escalamiento desc";

		$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	} 


	public function BuscarOrdenPrecer($escala, $terr, $reg, $localidad){
		GLOBAL $id_usuario_temp;
		$permiso = self::permisoUsuario($id_usuario_temp);
		$sql_where = "";

		$sql="SELECT id_escalamiento ID_Escalamiento
                        , o.nmro_orden Numero_Orden
                        , trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) Semaforo
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') Fecha_Escalamiento
                        , o.actividad Actividad
                        , o.rut_persona RUT_Cliente
                        , trim(O.NOMBRE_CLIENTE) Nombre_Cliente
                        , o.direccion
                        , o.localidad Comuna
                        , o.nodo Nodo
                        , es.descripcion Estado 
                from goc.escalamiento_ordenes_c o
                inner join goc.escalamiento_estado_c es on estado = id_estado
                 where o.estado = 5
                 order by id_escalamiento desc";
		
		$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	
	public function BuscarOrdenFina($escala, $terr, $reg, $localidad){
		GLOBAL $id_usuario_temp;
		$permiso = self::permisoUsuario($id_usuario_temp);
		$sql_where = "";

		$sql="SELECT id_escalamiento ID_Escalamiento
                        , o.nmro_orden Numero_Orden
                        , trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) Semaforo
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') Fecha_Escalamiento
                        , o.actividad Actividad
                        , o.rut_persona RUT_Cliente
                        , trim(O.NOMBRE_CLIENTE) Nombre_Cliente
                        , o.direccion
                        , o.localidad Comuna
                        , o.nodo Nodo
                        , es.descripcion Estado 
                from goc.escalamiento_ordenes_c o
                inner join goc.escalamiento_estado_c es on estado = id_estado
                 where o.estado = 3
                 order by id_escalamiento desc";
		
		$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}
	
	public function AsignarOrden($valor){
		GLOBAL $id_usuario_temp;
		$sql = "update goc.escalamiento_ordenes_c
				set
				id_asignado = :IUSE
				, estado = 2
				, fecha_ejecucion = sysdate
				where ID_ESCALAMIENTO = :VAL";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);
		return self::upsert($sql,$par);
	}	

	public function PermisoOrden($valor){
		$sql = "select id_asignado from goc.escalamiento_ordenes_c where ID_ESCALAMIENTO = :VAL";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function getComentarios($valor){			
		$sql = "SELECT to_char(fecha, 'DD-MM-YYYY HH24:MI:SS') fecha, comentario 
				from goc.ESCALAMIENTO_COMENTARIO_C where nmro_orden = :VAL";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}
	
	public function FinalizarOrden($valor, $comen, $postMortem, $pdf_ejec){
		//POST_MORTEM = :POST,
		$sql = "UPDATE goc.escalamiento_ordenes_c set POST_MORTEM = :POST, NUEVAOBSERVA = :COME, PDF_SUPERVISOR = :PDF, estado = 5 where ID_ESCALAMIENTO = :VAL";
		
		$par[":POST"]  = array($postMortem,-1,SQLT_CHR);
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":COME"]  = array($comen,-1,SQLT_CHR);
		$par[":PDF"]  = array($pdf_ejec,-1,SQLT_CHR);
		

		return self::upsert($sql,$par);
	}

	public function guarda_pdf($valor, $archivo){
		GLOBAL $id_usuario_temp;
		
			$sql="INSERT INTO goc.escalamiento_registropdf_c (id_escalamiento,
			                                            usuario,
			                                            fecha,
			                                            archivo)
			     VALUES (:VAL,
			             :IUSER,
			             SYSDATE,
			             :ARCHIVO)";

			$par[":VAL"]  = array($valor,-1,SQLT_CHR);
			$par[":IUSER"]  = array($id_usuario_temp,-1,SQLT_CHR);
			$par[":ARCHIVO"]  = array($archivo,-1,SQLT_CHR);
		
		return self::upsert($sql,$par);
	}	
	
	public function cerrarEscalamiento($valor, $comen, $pdf_cav){
		//POST_MORTEM = :POST,
		$sql = "UPDATE goc.escalamiento_ordenes_c set COMENTARIO_CAV = :COME, PDF_CAV = :PDF, estado = 3, subestado = 1, fecha_finalizada = sysdate where ID_ESCALAMIENTO = :VAL";

		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":COME"]  = array($comen,-1,SQLT_CHR);
		$par[":PDF"]  = array($pdf_cav,-1,SQLT_CHR);
		

		return self::upsert($sql,$par);
	}	

	public function finalizarSinContacto($valor, $comen){
		//POST_MORTEM = :POST,
		$sql = "UPDATE goc.escalamiento_ordenes_c set COMENTARIO_CAV = :COME, estado = 3, subestado = 2, fecha_finalizada = sysdate where ID_ESCALAMIENTO = :VAL";

		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":COME"]  = array($comen,-1,SQLT_CHR);
		

		return self::upsert($sql,$par);
	}


	public function reescalamiento($ID_ESCALAMIENTO, $NMRO_ORDEN, $FECHA_INGRESO, $FECHA_CREACION, $FECHA_COMPROMISO, $ESTC_ACTIV_TECNICO, $RUT_PERSONA, $NOMBRE_CLIENTE, $DIRECCION, $LOCALIDAD, $NODO, $CODI_AREAFUN, $DESC_AREAFUN, $OBSERVACION, $FECHA_PENDIENTE, $FECHA_FINALIZADA, $ID_CREADOR, $ID_ASIGNADO, $AREA_ESCALA,  $NUEVAOBSERVA, $ACTIVIDAD, $COD_HORARIO, $TIPO_ESCALAMIENTO, $SERVICIO_TV, $SERVICIO_PREMIUM, $SERVICIO_TELEFONO, $SERVICIO_INTERNET, $CORREO_ELECTRONICO, $MOTIVO_ESCALAMIENTO, $POST_MORTEM, $NMRO_ORDEN_INT){

		$sql = "INSERT INTO goc.escalamiento_ordenes_c (ID_ESCALAMIENTO,NMRO_ORDEN,FECHA_INGRESO,FECHA_CREACION,FECHA_COMPROMISO,ESTC_ACTIV_TECNICO,RUT_PERSONA,NOMBRE_CLIENTE,DIRECCION,LOCALIDAD,NODO,CODI_AREAFUN,DESC_AREAFUN,OBSERVACION,FECHA_PENDIENTE,FECHA_FINALIZADA,ID_CREADOR,ID_ASIGNADO,AREA_ESCALA,NUEVAOBSERVA,ACTIVIDAD,COD_HORARIO,TIPO_ESCALAMIENTO,SERVICIO_TV,SERVICIO_PREMIUM,SERVICIO_TELEFONO,SERVICIO_INTERNET,CORREO_ELECTRONICO,MOTIVO_ESCALAMIENTO,POST_MORTEM,NMRO_ORDEN_INT,fecha ejecucion,estado) values ((GOC.SEC_ESCALAMIENTO_C.nextval),:NMRO_ORDEN,:FECHA_INGRESO,:FECHA_CREACION,:FECHA_COMPROMISO,:ESTC_ACTIV_TECNICO,:RUT_PERSONA,:NOMBRE_CLIENTE,:DIRECCION,:LOCALIDAD,:NODO,:CODI_AREAFUN,:DESC_AREAFUN,:OBSERVACION,:FECHA_PENDIENTE,:FECHA_FINALIZADA,:ID_CREADOR,:ID_ASIGNADO,:AREA_ESCALA,:NUEVAOBSERVA,:ACTIVIDAD,:COD_HORARIO,:TIPO_ESCALAMIENTO,:SERVICIO_TV,:SERVICIO_PREMIUM,:SERVICIO_TELEFONO,:SERVICIO_INTERNET,:CORREO_ELECTRONICO,:MOTIVO_ESCALAMIENTO,:POST_MORTEM,:NMRO_ORDEN_INT,sysdate,2)";

        $par[":NMRO_ORDEN"]  = array($NMRO_ORDEN,-1,SQLT_CHR);
        $par[":FECHA_INGRESO"]  = array($FECHA_INGRESO,-1,SQLT_CHR);
        $par[":FECHA_CREACION"]  = array($FECHA_CREACION,-1,SQLT_CHR);
        $par[":FECHA_COMPROMISO"]  = array($FECHA_COMPROMISO,-1,SQLT_CHR);
        $par[":ESTC_ACTIV_TECNICO"]  = array($ESTC_ACTIV_TECNICO,-1,SQLT_CHR);
        $par[":RUT_PERSONA"]  = array($RUT_PERSONA,-1,SQLT_CHR);
        $par[":NOMBRE_CLIENTE"]  = array($NOMBRE_CLIENTE,-1,SQLT_CHR);
        $par[":DIRECCION"]  = array($DIRECCION,-1,SQLT_CHR);
        $par[":LOCALIDAD"]  = array($LOCALIDAD,-1,SQLT_CHR);
        $par[":NODO"]  = array($NODO,-1,SQLT_CHR);
        $par[":CODI_AREAFUN"]  = array($CODI_AREAFUN,-1,SQLT_CHR);
        $par[":DESC_AREAFUN"]  = array($DESC_AREAFUN,-1,SQLT_CHR);
        $par[":OBSERVACION"]  = array($OBSERVACION,-1,SQLT_CHR);
        $par[":FECHA_PENDIENTE"]  = array($FECHA_PENDIENTE,-1,SQLT_CHR);
        $par[":FECHA_FINALIZADA"]  = array($FECHA_FINALIZADA,-1,SQLT_CHR);
        $par[":ID_CREADOR"]  = array($ID_CREADOR,-1,SQLT_CHR);
        $par[":ID_ASIGNADO"]  = array($ID_ASIGNADO,-1,SQLT_CHR);
        $par[":AREA_ESCALA"]  = array($AREA_ESCALA,-1,SQLT_CHR);
        $par[":NUEVAOBSERVA"]  = array($NUEVAOBSERVA,-1,SQLT_CHR);
        $par[":ACTIVIDAD"]  = array($ACTIVIDAD,-1,SQLT_CHR);
        $par[":COD_HORARIO"]  = array($COD_HORARIO,-1,SQLT_CHR);
        $par[":TIPO_ESCALAMIENTO"]  = array($TIPO_ESCALAMIENTO,-1,SQLT_CHR);
        $par[":SERVICIO_TV"]  = array($SERVICIO_TV,-1,SQLT_CHR);
        $par[":SERVICIO_PREMIUM"]  = array($SERVICIO_PREMIUM,-1,SQLT_CHR);
        $par[":SERVICIO_TELEFONO"]  = array($SERVICIO_TELEFONO,-1,SQLT_CHR);
        $par[":SERVICIO_INTERNET"]  = array($SERVICIO_INTERNET,-1,SQLT_CHR);
        $par[":CORREO_ELECTRONICO"]  = array($CORREO_ELECTRONICO,-1,SQLT_CHR);
        $par[":MOTIVO_ESCALAMIENTO"]  = array($MOTIVO_ESCALAMIENTO,-1,SQLT_CHR);
        $par[":POST_MORTEM"]  = array($POST_MORTEM,-1,SQLT_CHR);
        $par[":NMRO_ORDEN_INT"]  = array($NMRO_ORDEN_INT,-1,SQLT_CHR);

		return self::upsert($sql,$par);

	}

	public function getDatosEscalamiento($valor){

		$sql = "SELECT  rut_persona, nombre_cliente, direccion, localidad, nodo, tipo_escalamiento, observacion, servicio_tv, servicio_premium, servicio_telefono, servicio_internet, fecha_pendiente, id_creador, id_asignado, nuevaobserva, actividad, correo_electronico, motivo_escalamiento, post_mortem, nmro_orden_int
			from goc.escalamiento_ordenes_c where id_escalamiento = :VAL";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function reescalamientoEdita($valor, $comen){

		$sql = "UPDATE goc.escalamiento_ordenes_c set COMENTARIO_CAV = :COME, estado = 6 where ID_ESCALAMIENTO = :VAL";
		

		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":COME"]  = array($comen,-1,SQLT_CHR);
		
		return self::upsert($sql,$par);
	}

	public function permiso_anula($valor){
		GLOBAL $id_usuario_temp;

		$sql = "SELECT id_creador
				from goc.escalamiento_ordenes_c
				where id_escalamiento = :VAL
				and id_creador = :IUSER ";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":IUSER"]  = array($id_usuario_temp,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function AnularOrden($valor){
		$sql = "UPDATE goc.escalamiento_ordenes_c
				set
				estado = 4
				, fecha_finalizada = sysdate
				where ID_ESCALAMIENTO = :VAL";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":COME"]  = array($comen,-1,SQLT_CHR);
		return self::upsert($sql,$par);
	}	
	
	public function AnularOrdenEsca($valor){
		$sql = "update goc.escalamiento_ordenes_c
				set
				estado = 4
				, fecha_finalizada = sysdate
				where ID_ESCALAMIENTO = :VAL";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::upsert($sql,$par);
	}	

	public function ComentarOrden($valor, $comen){
		$sql = "INSERT into goc.ESCALAMIENTO_COMENTARIO_C
							(id_comentario
							, nmro_orden
							, fecha
							, comentario)
				values
							(GOC.SEC_ORDENES_COMENTARIO_C.nextval
							, :VAL
							, sysdate
							, :COME)";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":COME"]  = array($comen,-1,SQLT_CHR);
		return self::upsert($sql,$par);
	}	
	
	public function getTerritorio(){
		$sql = "select id_nombre id, descripcion name from nnoc.TERR_NOMBRE order by id_nombre asc";
		
		return self::consulta($sql);	
	}

	public function getRegion($idn){
		if (isset($idn)){
			$sql = "select distinct r.id_region id, r.region name from NNOC.TERR_REGION r
					inner join NNOC.TERR_TERRITORIO t
					on R.ID_REGION = T.ID_REGION
					inner join NNOC.TERR_NOMBRE n
					on N.ID_NOMBRE = T.ID_NOMBRE
					where N.ID_NOMBRE in ( $idn )
					order by r.id_region asc";
		}
		
		$par[":IDN"]  = array($idn,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}
	
	public function getComuna($idn, $idr){
		if (isset($idn) and isset($idr)){
			$sql = "select distinct c.localidad id, c.comuna name from NNOC.TERR_COMUNA c
					inner join NNOC.TERR_TERRITORIO t
					on C.ID_COMUNA = T.ID_COMUNA
					where t.ID_NOMBRE in ( $idn ) 
					and T.ID_REGION in ( $idr ) 
					order by c.localidad asc";
		}
		
		$par[":IDN"]  = array($idn,-1,SQLT_CHR);
		$par[":IDR"]  = array($idr,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function vbOrden($valor){
		$sql = "select count(nmro_orden) total from goc.escalamiento_ordenes_c where nmro_orden = :VAL and estado <> 3";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function permisoUsuarioReporte($valor){
		$sql = "select count(*) total
					from (select * from organizacion.org_usuario
					where id_usuario in (11765,127,2330,12687,14558,778,23675,9,2236,14308,13540,1797,1301,23315,11192,1072,1086,14047,11367,17155,14415,12331))
				where id_usuario = :IDU";
		
		$par[":IDU"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}	
	
	public function permisoUsuario($valor){
		$sql = "select count(*) total from ORGANIZACION.NEW_ORG_USUARIO u
				inner join ORGANIZACION.NEW_ORG_EMPRESA o on o.rut_empresa = u.empresa
				inner join nnoc.TERR_EMPRESA t on o.rut_empresa = T.RUT
				where U.ID_USUARIO = :IDU";
		
		$par[":IDU"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}
	
	public function insertUsusarioCav($id, $nombre){
		$sql = "insert into goc.escalamiento_usuarios_cav_c (id_usuario, nombre)
				values
				(:IDU, :NOM)";
		
		$par[":IDU"]  = array($id,-1,SQLT_CHR);
		$par[":NOM"]  = array($nombre,-1,SQLT_CHR);
		return self::upsert($sql,$par);
	} 
	
	public function selectUsusariosCav(){
		$sql = "select * from goc.escalamiento_usuarios_cav_c";
		
		$par[":IDU"]  = array($id,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function selectUsusarioCav($id){
		if ($id != ''){
			$sql_where = " where id_usuario = :IDU";
			$par[":IDU"]  = array($id,-1,SQLT_CHR);
		}
		$sql = "select * from goc.escalamiento_usuarios_cav_c ".$sql_where;
		
		return self::consulta($sql,$par);
	}	

	public function permisoUsusarioCav($id){
		if ($id != ''){
			$sql_where = " where id_usuario = :IDU";
			$par[":IDU"]  = array($id,-1,SQLT_CHR);
		}
		$sql = "select count(*) from goc.escalamiento_usuarios_cav_c ".$sql_where;
		
		return self::consultaNum($sql,$par);
	}

	public function selectListTiempos($id){
		if ($id != ''){
			$sql_where = " where id_area = :IDU";
			$par[":IDU"]  = array($id,-1,SQLT_CHR);
		}
		$sql = "select id_tiempo, motivo \"Motivo Escalamiento\", tiempo_pend \"Tiempo Pendiente (minutos)\", tiempo_ejec \"Tiempo Ejecucion (minutos)\", comentario \"Comentario\" from GOC.ESCALAMIENTO_TIEMPO_C t
				inner join GOC.ESCALAMIENTO_AREA a on T.ID_AREA = A.ID_ESCALA  ".$sql_where;
		
		return self::consulta($sql,$par);
	}	

	public function GuardaTiempo($pend, $ejec, $area){
		$sql = "insert into goc.escalamiento_tiempo_C (id_area, tiempo_pend, tiempo_ejec)
				values
				(:IDA, :PEN, :EJE)";
		
		$par[":IDA"]  = array($area,-1,SQLT_CHR);
		$par[":PEN"]  = array($pend,-1,SQLT_CHR);
		$par[":EJE"]  = array($ejec,-1,SQLT_CHR);
		return self::upsert($sql,$par);
	} 

	public function selectTiempoOrdenPend($id){
		
		$sql = "select id_tiempo, motivo, tiempo_pend from GOC.ESCALAMIENTO_TIEMPO_C t
				inner join GOC.ESCALAMIENTO_AREA a on T.ID_AREA = A.ID_ESCALA 
				where motivo = :MOT";
		$par[":MOT"]  = array($id,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}	

	public function selectTiempoOrdenEjec($id){
		$sql = "select id_tiempo, motivo, tiempo_ejec from GOC.ESCALAMIENTO_TIEMPO_C t
				inner join GOC.ESCALAMIENTO_AREA a on T.ID_AREA = A.ID_ESCALA
				 where motivo like :MOT ";
		$par[":MOT"]  = array($id,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function BuscaRecuerda($id){
		if ($id != ''){
			$sql_where = " where nmro_orden = :MNO";
			$par[":MNO"]  = array($id,-1,SQLT_CHR);
		}  
		$sql = "select comentario from GOC.ESCALAMIENTO_ORDENES_c o
                inner join GOC.ESCALAMIENTO_AREA a on o.area_escala = A.ID_ESCALA
                inner join GOC.ESCALAMIENTO_TIEMPO_C t on T.ID_AREA = A.ID_ESCALA ".$sql_where;
		
		return self::consulta($sql,$par);
	}	
	
	public function getMailCreador($id){
		/*$sql = "select id_creador from goc.escalamiento_ordenes_c where id_escalamiento = :NORD";
		
		$par[":NORD"]  = array($id,-1,SQLT_INT);
		$crea = self::consultaNum($sql,$par);
		
		$sql1 = "select email from ORGANIZACION.ORG_USUARIO where id_usuario = :IDU";
		$par[":IDU"]  = array($crea[0][0],-1,SQLT_INT);*/
		$sql="SELECT email FROM ORGANIZACION.ORG_USUARIO
 				WHERE id_usuario = (SELECT id_creador
                       FROM goc.escalamiento_ordenes_c
                      WHERE id_escalamiento = :ESCA)";
		
		$par[":ESCA"]  = array($id,-1,SQLT_INT);
		
		return self::consulta($sql,$par);
	}	

	public function getMailCreador1($id){
		$sql = "select id_creador from goc.escalamiento_ordenes_c where nmro_orden = :NORD";
		
		$par[":NORD"]  = array($id,-1,SQLT_INT);
		$crea = self::consultaNum($sql,$par);
		
		$sql1 = "select email from ORGANIZACION.ORG_USUARIO where id_usuario = :IDU";
		$par[":IDU"]  = array($crea[0][0],-1,SQLT_INT);
		return self::consultaNum($sql1,$par);
	}		
	
	public function getMailAsignado($id){
		$sql = "SELECT email FROM ORGANIZACION.ORG_USUARIO
 				WHERE id_usuario = (SELECT id_asignado
                       FROM goc.escalamiento_ordenes_c
                      WHERE id_escalamiento = :ESCA)";
		
		$par[":ESCA"]  = array($id,-1,SQLT_INT);
		
		return self::consulta($sql,$par);
	}		

	public function getMailAsignado1($id){
		$sql = "select id_asignado from goc.escalamiento_ordenes_c where nmro_orden = :NORD";
		
		$par[":NORD"]  = array($id,-1,SQLT_INT);
		$crea = self::consultaNum($sql,$par);
		
		$sql1 = "select email from ORGANIZACION.ORG_USUARIO where id_usuario = :IDU";
		$par[":IDU"]  = array($crea[0][0],-1,SQLT_INT);
		return self::consultaNum($sql1,$par);
	}		
	
	public function getMailJefe($id){
		$sql = "select id_asignado from goc.escalamiento_ordenes_c where id_escalamiento = :NORD";
		
		$par[":NORD"]  = array($id,-1,SQLT_INT);
		$crea = self::consultaNum($sql,$par);
		
		$sql1 = "select email from ORGANIZACION.ORG_USUARIO 
				where id_usuario = (select id_jefe from ORGANIZACION.ORG_USUARIO where id_usuario = :IDU)
				and id_usuario not in (774,2236,131,127,213)";
		$par[":IDU"]  = array($crea[0][0],-1,SQLT_INT);
		return self::consultaNum($sql1,$par);
	}

	public function getMailJefe1($id){
		$sql = "select id_asignado from goc.escalamiento_ordenes_c where nmro_orden = :NORD";
		
		$par[":NORD"]  = array($id,-1,SQLT_INT);
		$crea = self::consultaNum($sql,$par);
		
		$sql1 = "select email from ORGANIZACION.ORG_USUARIO 
				where id_usuario = (select id_jefe from ORGANIZACION.ORG_USUARIO where id_usuario = :IDU)
				and id_usuario not in (774,2236,131,127,213)";
		$par[":IDU"]  = array($crea[0][0],-1,SQLT_INT);
		return self::consultaNum($sql1,$par);
	}

	
	public function getNombreUsuario($id){
		$sql = "select nombres || ' ' || apellidos as nom from organizacion.org_usuario where id_usuario = :IDU";
		
		$par[":IDU"]  = array($id,-1,SQLT_INT);
		return self::consultaNum($sql1,$par);
	} 
	
	public function getMailEps($id){		
		$sql = "select e.correo_responsable from ORGANIZACION.NEW_ORG_EMPRESA e
				inner join NNOC.TERR_EMPRESA te on E.RUT_EMPRESA = TE.RUT
				inner join NNOC.TERR_TERRITORIO tt on TE.ID_EMPRESA = TT.ID_EMPRESA
				inner join NNOC.TERR_COMUNA tc on TC.ID_COMUNA = TT.ID_COMUNA
				inner join GOC.ESCALAMIENTO_ORDENES_c eo on EO.LOCALIDAD = TC.LOCALIDAD
				where eo.id_escalamiento = :IDO";
				 
		$par[":IDO"]  = array($id,-1,SQLT_CHR);
		return self::consultaNum($sql,$par);
	}	

	public function getMailEps1($id){		
		$sql = "select e.correo_responsable from ORGANIZACION.NEW_ORG_EMPRESA e
				inner join NNOC.TERR_EMPRESA te on E.RUT_EMPRESA = TE.RUT
				inner join NNOC.TERR_TERRITORIO tt on TE.ID_EMPRESA = TT.ID_EMPRESA
				inner join NNOC.TERR_COMUNA tc on TC.ID_COMUNA = TT.ID_COMUNA
				inner join GOC.ESCALAMIENTO_ORDENES_c eo on EO.LOCALIDAD = TC.LOCALIDAD
				where eo.nmro_orden = :IDO";
				 
		$par[":IDO"]  = array($id,-1,SQLT_CHR);
		return self::consultaNum($sql,$par);
	}	

	public function getEscalaOrden($id){		
		$sql = "select max(id_escalamiento) from GOC.ESCALAMIENTO_ORDENES_c
				where id_escalamiento = :IDO";
				 
		$par[":IDO"]  = array($id,-1,SQLT_CHR);
		return self::consultaNum($sql,$par);
	}

	
	public function getDatosMail($id){
		GLOBAL $id_usuario_temp;

		$sql = "SELECT o.id_escalamiento
                        , o.nombre_cliente
                        , o.rut_persona
                        , o.direccion
                        , o.localidad
                        , o.actividad
                        , usu.nombres || ' ' || usu.apellidos creador
                        , to_char(O.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') fecha_pendiente
                        , to_char(O.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') fecha_ejecucion
                        , to_char(O.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') fecha_finalizada
                        , e.descripcion
                        , m.descripcion motivo
                        , t.descripcion tipo
                        , to_char(sysdate, 'DD-MM-YYYY HH24:MI:SS') fecha_anula
                        , (select nombres || ' ' || apellidos from ORGANIZACION.NEW_ORG_USUARIO WHERe ID_USUARIO = :IUSER) USUARIO_ANULA
                from goc.escalamiento_ordenes_c o 
                Inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO  
                inner join goc.escalamiento_estado_c e on e.id_estado = o.estado 
                inner join goc.escalamiento_motivo_c m on o.motivo_escalamiento = m.id_motivo 
                inner join goc.escalamiento_tipo_c t on o.tipo_escalamiento = t.id_tipo
                where ID_ESCALAMIENTO = :MNO";

			$par[":MNO"]  = array($id,-1,SQLT_CHR);
			$par[":IUSER"]  = array($id_usuario_temp,-1,SQLT_CHR);

		return self::consulta($sql,$par);
	}

	public function getDatosMailNuevo($id){

		$sql = "SELECT o.id_escalamiento
                        , o.nombre_cliente
                        , o.rut_persona
                        , o.direccion
                        , o.localidad
                        , o.actividad
                        , usu.nombres || ' ' || usu.apellidos creador
                        , to_char(O.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') fecha_pendiente
                        , to_char(O.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') fecha_ejecucion
                        , to_char(O.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') fecha_finalizada
                        , e.descripcion
                        , m.descripcion motivo
                        , t.descripcion tipo
                from goc.escalamiento_ordenes_c o 
                Inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO  
                inner join goc.escalamiento_estado_c e on e.id_estado = o.estado 
                inner join goc.escalamiento_motivo_c m on o.motivo_escalamiento = m.id_motivo 
                inner join goc.escalamiento_tipo_c t on o.tipo_escalamiento = t.id_tipo
                where ID_ESCALAMIENTO = :MNO";

                $par[":MNO"]  = array($id,-1,SQLT_CHR);
		
		return self::consulta($sql,$par);
	}

	public function getDatosIdEscal($RUTP, $DIRE, $TI_ESC, $MOTI_ESC){

		$sql = "SELECT id_escalamiento
				from goc.escalamiento_ordenes_c
				where rut_persona=:RUTPp
				and direccion = :DIREp
				and tipo_escalamiento = :TI_ESCp
				and motivo_escalamiento= :MOTI_ESCp
				order by id_escalamiento desc";

                $par[":RUTPp"]  = array($RUTP,-1,SQLT_CHR);
                $par[":DIREp"]  = array($DIRE,-1,SQLT_CHR);
                $par[":TI_ESCp"]  = array($TI_ESC,-1,SQLT_CHR);
                $par[":MOTI_ESCp"]  = array($MOTI_ESC,-1,SQLT_CHR);
		
		return self::consulta($sql,$par);
	}

	public function getDatosMailAsig($id){

		$sql = "SELECT o.id_escalamiento
                        , o.nombre_cliente
                        , o.rut_persona
                        , o.direccion
                        , o.localidad
                        , o.actividad
                        , usu.nombres || ' ' || usu.apellidos creador
                        , usa.nombres || ' ' || usa.apellidos Asignado
                        , to_char(O.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') fecha_pendiente
                        , to_char(O.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') fecha_ejecucion
                        , to_char(O.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') fecha_finalizada
                        , e.descripcion
                        , m.descripcion motivo
                        , t.descripcion tipo
                from goc.escalamiento_ordenes_c o 
                Inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO  
                Inner join ORGANIZACION.NEW_ORG_USUARIO usa on o.id_asignado = USA.ID_USUARIO
                inner join goc.escalamiento_estado_c e on e.id_estado = o.estado 
                inner join goc.escalamiento_motivo_c m on o.motivo_escalamiento = m.id_motivo 
                inner join goc.escalamiento_tipo_c t on o.tipo_escalamiento = t.id_tipo
                where ID_ESCALAMIENTO = :MNO";

                $par[":MNO"]  = array($id,-1,SQLT_CHR);
		
		return self::consulta($sql,$par);
	}

	public function getRecuerda($id){
		$sql = "select comentario from GOC.ESCALAMIENTO_TIEMPO_C where id_area = :IDA";
		
		$par[":IDA"]  = array($id,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}
	
	public function getOrdenFinalizada($id){
		$sql = "SELECT o.id_escalamiento
				        , o.nombre_cliente
				        , o.rut_persona
				        , o.direccion
				        , o.localidad
				        , o.actividad actividad
				        , usu.nombres || ' ' || usu.apellidos creador
				        , usa.nombres || ' ' || usa.apellidos Asignado
				        , to_char(O.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') fecha_pendiente
				        , to_char(O.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') fecha_ejecucion
				        , to_char(O.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') fecha_finalizada
				        , to_char(O.FECHA_INGRESO, 'DD-MM-YYYY HH24:MI:SS') FECHA_INGRESO
				        , to_char(O.FECHA_CREACION , 'DD-MM-YYYY HH24:MI:SS') FECHA_CREACION
				        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY HH24:MI:SS') FECHA_COMPROMISO
				        , e.descripcion
				        , o.observacion
				        , o.nuevaobserva
				        , post_mortem
				        , m.descripcion motivo
                        , t.descripcion tipo   
                        , COMENTARIO_CAV
				from goc.escalamiento_ordenes_c o 
				left join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO  
				left join ORGANIZACION.NEW_ORG_USUARIO usa on o.id_asignado = USA.ID_USUARIO
				inner join goc.escalamiento_estado_c e on e.id_estado = o.estado
				inner join goc.escalamiento_motivo_c m on o.motivo_escalamiento = m.id_motivo 
                inner join goc.escalamiento_tipo_c t on o.tipo_escalamiento = t.id_tipo
				where o.id_escalamiento = :IDO";
		
		$par[":IDO"]  = array($id,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}

	public function getOrdenEjecPrecer($id){
		$sql = "SELECT o.id_escalamiento
				        , o.nombre_cliente
				        , o.rut_persona
				        , o.direccion
				        , o.localidad
				        , o.actividad actividad
				        , usu.nombres || ' ' || usu.apellidos creador
				        , usa.nombres || ' ' || usa.apellidos Asignado
				        , to_char(O.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') fecha_pendiente
				        , to_char(O.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') fecha_ejecucion
				        , to_char(O.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') fecha_finalizada
				        , to_char(O.FECHA_INGRESO, 'DD-MM-YYYY HH24:MI:SS') FECHA_INGRESO
				        , to_char(O.FECHA_CREACION , 'DD-MM-YYYY HH24:MI:SS') FECHA_CREACION
				        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY HH24:MI:SS') FECHA_COMPROMISO
				        , e.descripcion
				        , o.observacion
				        , o.nuevaobserva
				        , o.post_mortem
				        , m.descripcion motivo
                        , t.descripcion tipo
                        , o.correo_electronico
                        , o.pdf_supervisor
				from goc.escalamiento_ordenes_c o 
				left join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO  
				left join ORGANIZACION.NEW_ORG_USUARIO usa on o.id_asignado = USA.ID_USUARIO
				inner join goc.escalamiento_estado_c e on e.id_estado = o.estado
				inner join goc.escalamiento_motivo_c m on o.motivo_escalamiento = m.id_motivo 
                inner join goc.escalamiento_tipo_c t on o.tipo_escalamiento = t.id_tipo
				where o.id_escalamiento = :IDO
				and e.id_estado in (2,5)";
		
		$par[":IDO"]  = array($id,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}
	
	public function getFonoContacto($rut){
		$sql = "SELECT fono_contacto, fono_contacto2, fono_contacto3 from tango.sut_persona@REPONNOC_ORAC.WORLD where rut_persona=:RUT";
		
		$par[":RUT"]  = array($rut,-1,SQLT_CHR);

		return self::consulta($sql,$par); 
	}

	public function getEmpresa(){
		$sql = "select rut id, empresa name from NNOC.TERR_EMPRESA where rut is not null";
		
		return self::consulta($sql); 
	}
	
	public function cuentaEstados($terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){						
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if ($eps != ''){
			$sql_where .= " and TE.RUT = :EMPR ";
			$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
		}		
		if ($escala != ''){
			$sql_where .= " and ar.area = :ESCA ";
			$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
		}	
		if ($terr != ''){
			$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
		                    inner join NNOC.TERR_TERRITORIO t
		                    on C.ID_COMUNA = T.ID_COMUNA
		                    inner join NNOC.TERR_NOMBRE N
		                    on N.ID_NOMBRE = T.ID_NOMBRE
		                    WHERE N.ID_NOMBRE = :TERR ) ";
			$par[":TERR"]  = array($terr,-1,SQLT_CHR);
		}		
		if ($reg != ''){
			$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
							inner join NNOC.TERR_TERRITORIO t
							on C.ID_COMUNA = T.ID_COMUNA
							inner join NNOC.TERR_REGION r
							on R.ID_REGION = T.ID_REGION
							WHERE R.ID_REGION = :REGI )  ";
			$par[":REGI"]  = array($reg,-1,SQLT_CHR);
		}
		if ($localidad != ''){
			$sql_where .= " and o.localidad = :LOCA ";
			$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
		}
		if ($actividad != ''){
			$sql_where .= " and o.area_escala = :ARES ";
			$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
		}
		
		$sql = "select count(*) total, E.DESCRIPCION empresa, O.ESTADO tipo 
				from GOC.ESCALAMIENTO_ORDENES_c o
				inner join GOC.ESCALAMIENTO_ESTADO_c e on E.ID_ESTADO = O.ESTADO 
				inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
				inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
				where 1=1 ".$sql_where."
				group by E.DESCRIPCION, O.ESTADO
				order by o.estado asc";
		
		return self::consultaNum($sql,$par); 
	}

	public function cuentaEstados1($terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){						
		if ($fpenDesde == date('d/m/Y', strtotime( "- 1 days" )) && $fpenHasta == date('d/m/Y')){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) > trunc(sysdate-5)";
		}else{
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}			
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala )";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}		
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr ) ) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}
		if (isset($reg)){		
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}
		if (isset($localidad)){	
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		$sql = "select count(distinct(id_escalamiento)) total, to_char(O.FECHA_PENDIENTE, 'dd-mm-yyyy') empresa, E.DESCRIPCION tipo
				from GOC.ESCALAMIENTO_ORDENES_c o
				inner join GOC.ESCALAMIENTO_ESTADO_c e on E.ID_ESTADO = O.ESTADO 
				inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
				inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
				where 1=1 ".$sql_where."
				group by E.DESCRIPCION, to_char(O.FECHA_PENDIENTE, 'dd-mm-yyyy'), O.ESTADO
				order by o.estado asc";
		return self::consulta($sql,$par); 
	}	
		
	public function cuentaAreas($terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){				
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}	
		if (isset($escala)){	
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr ) ) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}			
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		$sql = "select count(*) total, ar.motivo empresa, AR.ID_ESCALA tipo
				from GOC.ESCALAMIENTO_ORDENES_c o
				inner join GOC.ESCALAMIENTO_AREA ar on AR.ID_ESCALA = O.AREA_ESCALA
				inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
				where 1=1 ".$sql_where."
				group by AR.MOTIVO, AR.ID_ESCALA
				order by AR.ID_ESCALA";
		
		return self::consultaNum($sql,$par); 
	}
	
	public function cuentaEmpresa($terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}
		if (isset($escala)){		
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){	
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr ) ) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}		
		if (isset($reg)){	
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}	
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		$sql = "select count(*) total , TE.EMPRESA empresa, TE.ID_EMPRESA tipo from GOC.ESCALAMIENTO_ORDENES_c o
				inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
				inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
				inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
				inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
				where 1=1 ".$sql_where."
				group by TE.EMPRESA, TE.ID_EMPRESA
				order by TE.ID_EMPRESA asc";
		
		return self::consultaNum($sql,$par); 
	}
	
	public function cuentaTiempoPendEjec($terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}
		if (isset($escala)){		
			if ($escala != 'null'){
				$sql_area = " where ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}		
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		$sql = "select sum(total) total , a.EMPRESA, a.tipo from (
                    select sum(total) total, TE.EMPRESA, o.tipo , O.AREA_ESCALA from (
                    select count(*) total, 'Normal' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) > trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440)
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    union all
                    select count(*) total, 'Medio' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) between SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) and SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1)
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    union all
                    select count(*) total, 'Alerta' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1) < trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440)
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE) o
                inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                where 1=1  ".$sql_where."
                group by TE.EMPRESA, o.tipo, O.AREA_ESCALA
                order by TE.EMPRESA asc) a
                inner join GOC.ESCALAMIENTO_AREA ar on a.AREA_ESCALA = AR.ID_ESCALA
                ".$sql_area."
                group by a.EMPRESA, a.tipo";
		
		return self::consulta($sql,$par); 
	}

	public function cuentaTiempoPendTreal($terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_area = " where ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr ) ) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}			
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}	
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		$sql = "select sum(total) total , to_char(a.FECHA_PENDIENTE, 'dd-mm-yyyy') empresa, a.tipo from (
                    select sum(total) total, o.FECHA_PENDIENTE, o.tipo , O.AREA_ESCALA from (
                    select count(*) total, 'Normal' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) > trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440)
                    and o.fecha_ejecucion is null
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    union all
                    select count(*) total, 'Medio' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) between SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) and SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1)
					and o.fecha_ejecucion is null
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    union all
                    select count(*) total, 'Alerta' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1) < trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440)
					and o.fecha_ejecucion is null
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE) o
                inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                where 1=1  ".$sql_where."
                group by o.FECHA_PENDIENTE, o.tipo, O.AREA_ESCALA
                order by o.FECHA_PENDIENTE asc) a
                inner join GOC.ESCALAMIENTO_AREA ar on a.AREA_ESCALA = AR.ID_ESCALA
                ".$sql_area."
                group by to_char(a.FECHA_PENDIENTE, 'dd-mm-yyyy'), a.tipo
                order by to_char(a.FECHA_PENDIENTE, 'dd-mm-yyyy') desc";
		
		return self::consulta($sql,$par); 
	}	
		
	public function cuentaTiempoEjecFina($terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_area = " where ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){	
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr ) ) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}			
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}	
		}		
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		$sql = "select sum(total) total, a.EMPRESA, a.tipo from (
                    select sum(total) total, TE.EMPRESA, o.tipo, O.AREA_ESCALA from (
                    select count(*) total, 'Normal' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where SUBSTR(ET.TIEMPO_EJEC , 1, INSTR(ET.TIEMPO_EJEC, '-')-1) > trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440)
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    union all
                    select count(*) total, 'Medio' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) between SUBSTR(ET.TIEMPO_EJEC, 1, INSTR(ET.TIEMPO_EJEC, '-')-1) and SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1)
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    union all
                    select count(*) total, 'Alerta' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1) < trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440)
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE) o
                inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                where 1=1  ".$sql_where."
                group by TE.EMPRESA, o.tipo, O.AREA_ESCALA
                order by TE.EMPRESA asc) a
                inner join GOC.ESCALAMIENTO_AREA ar on a.AREA_ESCALA = AR.ID_ESCALA
                ".$sql_area."
                group by a.EMPRESA, a.tipo";
		
		return self::consulta($sql,$par); 
	}

	public function cuentaTiempoEjecTreal($terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_area = " where ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr ) ) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){		
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ))  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}	
		}		
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		$sql = "select sum(total) total, to_char(a.FECHA_PENDIENTE, 'dd-mm-yyyy') empresa, a.tipo from (
                    select sum(total) total, O.FECHA_PENDIENTE, o.tipo, O.AREA_ESCALA from (
                    select count(*) total, 'Normal' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where SUBSTR(ET.TIEMPO_EJEC , 1, INSTR(ET.TIEMPO_EJEC, '-')-1) > trunc((nvl(sysdate,sysdate)-O.FECHA_EJECUCION)*1440)
                    and O.FECHA_FINALIZADA is null
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    union all
                    select count(*) total, 'Medio' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where trunc((nvl(sysdate,sysdate)-O.FECHA_EJECUCION)*1440) between SUBSTR(ET.TIEMPO_EJEC, 1, INSTR(ET.TIEMPO_EJEC, '-')-1) and SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1)
                    and O.FECHA_FINALIZADA is null
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    union all
                    select count(*) total, 'Alerta' tipo, o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    where SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1) < trunc((nvl(sysdate,sysdate)-O.FECHA_EJECUCION)*1440)
                    and O.FECHA_FINALIZADA is null
                    group by o.localidad, O.AREA_ESCALA, O.FECHA_PENDIENTE) o
                inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                where 1=1  ".$sql_where."
                group by O.FECHA_PENDIENTE, o.tipo, O.AREA_ESCALA
                order by O.FECHA_PENDIENTE asc) a
                inner join GOC.ESCALAMIENTO_AREA ar on a.AREA_ESCALA = AR.ID_ESCALA
                ".$sql_area."
                group by to_char(a.FECHA_PENDIENTE, 'dd-mm-yyyy'), a.tipo
                order by to_char(a.FECHA_PENDIENTE, 'dd-mm-yyyy') desc";
		
		return self::consulta($sql,$par); 
	}	
		
	public function getDetalleOrdenEstado($alerta, $empresa, $terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
	
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}		
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr ) ) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}			
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in (  $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}	
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		$sql = "select O.ID_ESCALAMIENTO \"ID Escalamiento\"
				        , O.NMRO_ORDEN \"Numero Orden\"
				        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
				        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end \"Fecha Ejecucion\"
				        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end \"Fecha Finalizacion\"
				        , usu.nombres || ' ' || usu.apellidos  \"Usuario Ingresa Escalamiento\"
				        , AR.MOTIVO \"Motivo Escalamiento\"
				        , o.actividad  \"Actividad\"
				        , o.rut_persona \"RUT Cliente\"
				        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
				        , o.localidad \"Comuna\"
				        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
				        , o.cod_horario \"Bloque Horario\"
				        , es.descripcion \"Estado\"
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA  \"Empresa\"
                from GOC.ESCALAMIENTO_ORDENES_c o
                inner join GOC.ESCALAMIENTO_ESTADO_c e on E.ID_ESTADO = O.ESTADO
                inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO 
                inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
				inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                where E.DESCRIPCION = :IDE
                and to_char(o.FECHA_PENDIENTE, 'dd-mm-yyyy') = :FEC ".$sql_where."
                order by o.estado asc";
		
		$par[":IDE"]  = array($alerta,-1,SQLT_CHR);
		$par[":FEC"]  = array($empresa,-1,SQLT_CHR);	
		return self::consulta($sql,$par);
	}
	
	public function getDetalleOrdenArea($estado, $terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}	
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		$sql = "select O.ID_ESCALAMIENTO \"ID Escalamiento\"
				        , O.NMRO_ORDEN \"Numero Orden\"
				        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
				        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end \"Fecha Ejecucion\"
				        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end \"Fecha Finalizacion\"
				        , usu.nombres || ' ' || usu.apellidos  \"Usuario Ingresa Escalamiento\"
				        , AR.MOTIVO \"Motivo Escalamiento\"
				        , o.actividad  \"Actividad\"
				        , o.rut_persona \"RUT Cliente\"
				        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
				        , o.localidad \"Comuna\"
				        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
				        , o.cod_horario \"Bloque Horario\"
				        , es.descripcion \"Estado\" 
				        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA  \"Empresa\"
                from GOC.ESCALAMIENTO_ORDENES_c o
                inner join GOC.ESCALAMIENTO_ESTADO_c e on E.ID_ESTADO = O.ESTADO
                inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO 
                inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO 
                inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                where AR.ID_ESCALA = :IDE ".$sql_where."
                order by o.estado asc";
		
		$par[":IDE"]  = array($estado,-1,SQLT_CHR);		
		return self::consulta($sql,$par);
	}	
	
	public function getDetalleOrdenEmpresa($estado, $terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}	
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		$sql = "select O.ID_ESCALAMIENTO \"ID Escalamiento\"
				        , O.NMRO_ORDEN \"Numero Orden\"
				        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
				        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end \"Fecha Ejecucion\"
				        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end \"Fecha Finalizacion\"
				        , usu.nombres || ' ' || usu.apellidos  \"Usuario Ingresa Escalamiento\"
				        , AR.MOTIVO \"Motivo Escalamiento\"
				        , o.actividad  \"Actividad\"
				        , o.rut_persona \"RUT Cliente\"
				        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
				        , o.localidad \"Comuna\"
				        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
				        , o.cod_horario \"Bloque Horario\"
				        , es.descripcion \"Estado\" 
				        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA  \"Empresa\"
                from GOC.ESCALAMIENTO_ORDENES_c o
                inner join GOC.ESCALAMIENTO_ESTADO_c e on E.ID_ESTADO = O.ESTADO
                inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO 
                inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                where TE.ID_EMPRESA = :IDE ".$sql_where."
                order by TE.ID_EMPRESA asc";
		
		$par[":IDE"]  = array($estado,-1,SQLT_CHR);		
		return self::consulta($sql,$par);
	}

	public function getDetalleOrdenPendiente($estado){	
		$sql = "select O.ID_ESCALAMIENTO \"ID Escalamiento\"
				        , O.NMRO_ORDEN \"Numero Orden\"
				        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
				        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end \"Fecha Ejecucion\"
				        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end \"Fecha Finalizacion\"
				        , usu.nombres || ' ' || usu.apellidos  \"Usuario Ingresa Escalamiento\"
				        , AR.MOTIVO \"Motivo Escalamiento\"
				        , o.actividad  \"Actividad\"
				        , o.rut_persona \"RUT Cliente\"
				        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
				        , o.localidad \"Comuna\"
				        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
				        , o.cod_horario \"Bloque Horario\"
				        , es.descripcion \"Estado\" 
                from GOC.ESCALAMIENTO_ORDENES_c o
                inner join GOC.ESCALAMIENTO_ESTADO_c e on E.ID_ESTADO = O.ESTADO
                inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO 
                inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                where TE.ID_EMPRESA = :IDE
                order by TE.ID_EMPRESA asc";
		
		$par[":IDE"]  = array($estado,-1,SQLT_CHR);		
		return self::consulta($sql,$par);
	}

	public function getEscalamientosPendientes($alerta, $empresa, $terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}	
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		if ($alerta == 'Normal'){
			$sql = " select count(*) total, 'Normal' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA 
                    where SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) > trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}elseif ($alerta == 'Medio'){
			$sql = " select count(*) total, 'Medio' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    where trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) between SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) and SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}elseif ($alerta == 'Alerta'){
			$sql = " select count(*) total, 'Alerta' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    where SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1) < trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}
	
	public function getEscalamientosPendientesDetalle($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		if ($alerta == 'Normal'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) > trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where." ";
		}elseif ($alerta == 'Medio'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                    where trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) between SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) and SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1)
                    and TE.EMPRESA = :IDE  ".$sql_where." ";
		}elseif ($alerta == 'Alerta'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1) < trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where." ";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}	

	public function getEscalamientosPendientesDetalleUsuario($alerta, $usuario, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		if ($alerta == 'Normal'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                    where SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) > trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}elseif ($alerta == 'Medio'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE  
                    where trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) between SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) and SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}elseif ($alerta == 'Alerta'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE  
                    where SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1) < trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		$par[":USUA"]  = array($usuario,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}

	public function getEscalamientosPendientesTreal($alerta, $empresa, $terr, $reg, $localidad, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}	
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($localidad)){
			if ($localidad != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		if ($alerta == 'Normal'){
			$sql = " select count(*) total, 'Normal' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA 
                    where SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) > trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}elseif ($alerta == 'Medio'){
			$sql = " select count(*) total, 'Medio' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    where trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) between SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) and SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}elseif ($alerta == 'Alerta'){
			$sql = " select count(*) total, 'Alerta' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    where SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1) < trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null  ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}	
	
	public function getEscalamientosPendientesDetalleTreal($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		if ($alerta == 'Normal'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) > trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null ".$sql_where." ";
		}elseif ($alerta == 'Medio'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\"
                        , TN.DESCRIPCION  \"Territorio\" 
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                    where trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) between SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) and SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null  ".$sql_where." ";
		}elseif ($alerta == 'Alerta'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\"
                        , TN.DESCRIPCION  \"Territorio\" 
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1) < trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null ".$sql_where." ";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}	

	public function getEscalamientosPendientesDetalleUsuarioTreal($alerta, $usuario, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
			
		if ($alerta == 'Normal'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE  
                    where SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) > trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}elseif ($alerta == 'Medio'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) between SUBSTR(et.tiempo_pend, 1, INSTR(et.tiempo_pend, '-')-1) and SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}elseif ($alerta == 'Alerta'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(et.tiempo_pend, INSTR(et.tiempo_pend, '-')+1) < trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_EJECUCION is null ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		$par[":USUA"]  = array($usuario,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}	
		
	public function getEscalamientosEjecucion($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		if ($alerta == 'Normal'){
			$sql = " select count(*) total, 'Normal' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    where SUBSTR(ET.TIEMPO_EJEC , 1, INSTR(ET.TIEMPO_EJEC, '-')-1) > trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}elseif ($alerta == 'Medio'){
			$sql = " select count(*) total, 'Medio' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    where trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) between SUBSTR(ET.TIEMPO_EJEC, 1, INSTR(ET.TIEMPO_EJEC, '-')-1) and SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}elseif ($alerta == 'Alerta'){
			$sql = " select count(*) total, 'Alerta' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    where SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1) < trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}

	public function getEscalamientosEjecucionDetalle($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		if ($alerta == 'Normal'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(ET.TIEMPO_EJEC , 1, INSTR(ET.TIEMPO_EJEC, '-')-1) > trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where." ";
		}elseif ($alerta == 'Medio'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) between SUBSTR(ET.TIEMPO_EJEC, 1, INSTR(ET.TIEMPO_EJEC, '-')-1) and SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1)
                    and TE.EMPRESA = :IDE ".$sql_where." ";
		}elseif ($alerta == 'Alerta'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\"
                        , TN.DESCRIPCION  \"Territorio\" 
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1) < trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where." ";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}

	public function getEscalamientosEjecucionDetalleUsuario($alerta, $usuario, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		if ($alerta == 'Normal'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE  
                    where SUBSTR(ET.TIEMPO_EJEC , 1, INSTR(ET.TIEMPO_EJEC, '-')-1) > trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}elseif ($alerta == 'Medio'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE  
                    where trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) between SUBSTR(ET.TIEMPO_EJEC, 1, INSTR(ET.TIEMPO_EJEC, '-')-1) and SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}elseif ($alerta == 'Alerta'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE  
                    where SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1) < trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440)
                    and TE.EMPRESA = :IDE ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		$par[":USUA"]  = array($usuario,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}

	public function getEscalamientosEjecucionTreal($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		if ($alerta == 'Normal'){
			$sql = " select count(*) total, 'Normal' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    where SUBSTR(ET.TIEMPO_EJEC , 1, INSTR(ET.TIEMPO_EJEC, '-')-1) > trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}elseif ($alerta == 'Medio'){
			$sql = " select count(*) total, 'Medio' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    where trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440) between SUBSTR(ET.TIEMPO_EJEC, 1, INSTR(ET.TIEMPO_EJEC, '-')-1) and SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}elseif ($alerta == 'Alerta'){
			$sql = " select count(*) total, 'Alerta' tipo, usu.nombres || ' ' || usu.apellidos empresa
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    where SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1) < trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where."
                    group by usu.nombres || ' ' || usu.apellidos";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}

	public function getEscalamientosEjecucionDetalleTreal($alerta, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		if ($alerta == 'Normal'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(ET.TIEMPO_EJEC , 1, INSTR(ET.TIEMPO_EJEC, '-')-1) > trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where." ";
		}elseif ($alerta == 'Medio'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440) between SUBSTR(ET.TIEMPO_EJEC, 1, INSTR(ET.TIEMPO_EJEC, '-')-1) and SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where." ";
		}elseif ($alerta == 'Alerta'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1) < trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where." ";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}

	public function getEscalamientosEjecucionDetalleUsuarioTreal($alerta, $usuario, $empresa, $terr, $reg, $loc, $escala, $eps, $fpenDesde, $fpenHasta, $actividad){
		if ($fpenDesde != '' && $fpenHasta != ''){
			$sql_where .= "and trunc(O.FECHA_PENDIENTE) >= to_date(:FDESDE , 'dd-mm-yyyy')
                		   and trunc(O.FECHA_PENDIENTE) <= to_date(:FHASTA , 'dd-mm-yyyy')";
            $par[":FDESDE"]  = array($fpenDesde,-1,SQLT_CHR);
            $par[":FHASTA"]  = array($fpenHasta,-1,SQLT_CHR);
		}
		if (isset($eps)){
			if ($eps != 'null'){
				$eps = explode(",", $eps);
				$eps = "'".implode("','", $eps)."'";
				$sql_where .= " and TE.RUT in ( $eps ) ";
				$par[":EMPR"]  = array($eps,-1,SQLT_CHR);
			}
		}		
		if (isset($escala)){
			if ($escala != 'null'){
				$sql_where .= " and ar.area in ( $escala ) ";
				$par[":ESCA"]  = array($escala,-1,SQLT_CHR);
			}
		}	
		if (isset($terr)){
			if ($terr != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
			                    inner join NNOC.TERR_TERRITORIO t
			                    on C.ID_COMUNA = T.ID_COMUNA
			                    inner join NNOC.TERR_NOMBRE N
			                    on N.ID_NOMBRE = T.ID_NOMBRE
			                    WHERE N.ID_NOMBRE in ( $terr )) ";
				$par[":TERR"]  = array($terr,-1,SQLT_CHR);
			}
		}	
		if (isset($reg)){
			if ($reg != 'null'){
				$sql_where .= " and o.localidad in (select distinct localidad from NNOC.TERR_COMUNA c
								inner join NNOC.TERR_TERRITORIO t
								on C.ID_COMUNA = T.ID_COMUNA
								inner join NNOC.TERR_REGION r
								on R.ID_REGION = T.ID_REGION
								WHERE R.ID_REGION in ( $reg ) )  ";
				$par[":REGI"]  = array($reg,-1,SQLT_CHR);
			}
		}	
		if (isset($loc)){
			if ($loc != 'null'){
				$localidad = explode(",", $localidad);
				$localidad = "'".implode("','", $localidad)."'";
				$sql_where .= " and o.localidad in ( $localidad ) ";
				$par[":LOCA"]  = array($localidad,-1,SQLT_CHR);
			}
		}
		if (isset($actividad)){
			if ($actividad != 'null'){
				$sql_where .= " and o.area_escala in ( $actividad ) ";
				$par[":ARES"]  = array($actividad,-1,SQLT_CHR);
			}
		}
		
		if ($alerta == 'Normal'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA 
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE 
                    where SUBSTR(ET.TIEMPO_EJEC , 1, INSTR(ET.TIEMPO_EJEC, '-')-1) > trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}elseif ($alerta == 'Medio'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                    where trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440) between SUBSTR(ET.TIEMPO_EJEC, 1, INSTR(ET.TIEMPO_EJEC, '-')-1) and SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}elseif ($alerta == 'Alerta'){
			$sql = " select O.ID_ESCALAMIENTO \"ID Escalamiento\"
                        , O.NMRO_ORDEN \"Numero Orden\"
                        , trunc((o.fecha_ejecucion-nvl(o.fecha_pendiente,sysdate))*1440) \"Semaforo Pendiente\"
                        , trunc((o.fecha_finalizada-nvl(o.fecha_ejecucion,sysdate))*1440) \"Semaforo Ejecucion\"
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Escalamiento\"
                        , case es.descripcion when 'Pendiente' then 'No Ejecutada' else to_char(o.fecha_ejecucion, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Ejecucion\"
                        , case es.descripcion when 'Pendiente' then 'No Finalizada' when 'En Ejecucion' then 'No Finalizada'  else to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') end  \"Fecha Finalizacion\"
                        , usu.nombres || ' ' || usu.apellidos   \"Usuario Ingresa Escalamiento\"
                        , AR.MOTIVO \"Motivo Escalamiento\"
                        , o.actividad  \"Actividad\"
                        , o.rut_persona \"RUT Cliente\"
                        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
                        , o.localidad \"Comuna\"
                        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
                        , o.cod_horario \"Bloque Horario\"
                        , es.descripcion  \"Estado\" 
                        , TN.DESCRIPCION  \"Territorio\"
                        , TE.EMPRESA \"Empresa\"
                    from GOC.ESCALAMIENTO_ORDENES_c o
                    inner join GOC.ESCALAMIENTO_TIEMPO_C et on ET.ID_AREA = O.AREA_ESCALA
                    inner join ORGANIZACION.NEW_ORG_USUARIO usu on o.id_creador = USU.ID_USUARIO
                    inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
                    inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
                    inner join NNOC.TERR_COMUNA tc on TC.LOCALIDAD = O.LOCALIDAD
                    inner join NNOC.TERR_TERRITORIO tt on TC.ID_COMUNA = TT.ID_COMUNA
                    inner join NNOC.TERR_EMPRESA te on TE.ID_EMPRESA = TT.ID_EMPRESA  
                    inner join NNOC.TERR_NOMBRE tn on TN.ID_NOMBRE = TT.ID_NOMBRE
                    where SUBSTR(ET.TIEMPO_EJEC, INSTR(ET.TIEMPO_EJEC, '-')+1) < trunc((nvl(sysdate,sysdate)-o.fecha_ejecucion)*1440)
                    and trunc(O.FECHA_PENDIENTE) = to_date(:IDE, 'dd-mm-yyyy') 
                    and O.FECHA_FINALIZADA is null ".$sql_where."
                    and usu.nombres || ' ' || usu.apellidos like :USUA";
		}			
			
		$par[":IDE"]  = array($empresa,-1,SQLT_CHR);
		$par[":USUA"]  = array($usuario,-1,SQLT_CHR);
		return self::consulta($sql,$par); 
	}

	public function DetallarOrden($valor){			
		$sql = "SELECT nmro_orden
                        , to_char(fecha_ingreso, 'DD-MM-YYYY HH24:MI:SS') as fecha_ingreso
                        , to_char(fecha_creacion, 'DD-MM-YYYY HH24:MI:SS') as fecha_creacion
                        , to_char(fecha_compromiso, 'DD-MM-YYYY HH24:MI:SS') as fecha_compromiso
                        , rut_persona
                        , nombre_cliente
                        , direccion
                        , localidad
                        , actividad
                        , nodo
                        , codi_areafun
                        , desc_areafun
                        , observacion
                        , cod_horario
                        , nuevaobserva
                 		, tipo_escalamiento
                        , motivo_escalamiento       
                        , nuevaobserva
                        , servicio_tv
                        , servicio_telefono
                        , servicio_internet
                        , servicio_premium 
                        , m.descripcion motivo
                        , t.descripcion tipo  
                from goc.ESCALAMIENTO_ORDENES_c o
                inner join goc.escalamiento_motivo_c m on o.motivo_escalamiento = m.id_motivo 
                inner join goc.escalamiento_tipo_c t on o.tipo_escalamiento = t.id_tipo
                where id_escalamiento = :VAL ";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function AsignaEscalamiento($valor){		
	GLOBAL $id_usuario_temp;	
		$sql = "UPDATE goc.escalamiento_ordenes_c
				set estado = 2,
				id_asignado = :IUSE,
				fecha_ejecucion = sysdate
				where id_escalamiento = :VAL ";

		$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::upsert($sql, $par);
	}

	public function ConfirmaAsignacion($valor){		
	GLOBAL $id_usuario_temp;	
		$sql = "select * from goc.escalamiento_ordenes_c
				where estado= 2
				and id_escalamiento = :VAL 
				and id_asignado = :IUSE";

		$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		return self::upsert($sql, $par);
	}



	public function BuscarOrdenFinaF($escala, $terr, $reg, $localidad, $eps, $fdesde, $fhasta){
		GLOBAL $id_usuario_temp;
		$permiso = self::permisoUsuario($id_usuario_temp);
		$sql_where = "";
		
		$sql="SELECT id_escalamiento ID_Escalamiento
                        , o.nmro_orden Numero_Orden
                        , trunc((nvl(sysdate,sysdate)-o.fecha_pendiente)*1440) Semaforo
                        , to_char(o.fecha_pendiente, 'DD-MM-YYYY HH24:MI:SS') Fecha_Escalamiento
                        , o.actividad Actividad
                        , o.rut_persona RUT_Cliente
                        , trim(O.NOMBRE_CLIENTE) Nombre_Cliente
                        ,o.direccion
                        , o.localidad Comuna
                        , o.nodo Nodo
                        , es.descripcion Estado 
                from goc.escalamiento_ordenes_c o
                inner join goc.escalamiento_estado_c es on estado = id_estado
                 where o.estado in (3,7)
                 order by id_escalamiento desc";
		
		$par[":IUSE"]  = array($id_usuario_temp,-1,SQLT_CHR);
		return self::consulta($sql,$par);
	}

	public function BuscarOrdenEscalamiento($valor){			
		$sql = "select id_escalamiento \"ID Escalamiento\"
				        , o.nmro_orden \"Numero Orden\"
				        , to_char(o.fecha_finalizada, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Finalizacion\"
				        , AR.MOTIVO \"Motivo Escalamiento\"
				        , o.actividad \"Actividad\"
				        , o.rut_persona \"RUT Cliente\"
				        , trim(O.NOMBRE_CLIENTE) \"Nombre Cliente\"
				        , o.localidad \"Comuna\"
				        , o.nodo \"Nodo\"
				        , to_char(O.FECHA_INGRESO, 'DD-MM-YYYY HH24:MI:SS') \"Fecha Ingreso\"
				        , to_char(O.FECHA_CREACION , 'DD-MM-YYYY HH24:MI:SS') \"Fecha Creacion\"
				        , to_char(O.FECHA_COMPROMISO , 'DD-MM-YYYY') \"Fecha Compromiso\"
				        , es.descripcion \"Estado\"
				        , es.descripcion \"Estado1\" 
				from goc.escalamiento_ordenes_c o
				inner join GOC.ESCALAMIENTO_AREA ar on O.AREA_ESCALA = AR.ID_ESCALA
				inner join goc.escalamiento_estado_c es on es.id_estado = O.ESTADO
				where O.ID_ESCALAMIENTO in ( $valor )";
		
		return self::consulta($sql,$par);
	}

	public function estadoCerrarEscalamiento($valor, $id){			
		$sql = "update goc.escalamiento_ordenes_c  
				set
					estado = :VAL,
					NUEVAOBSERVA = NUEVAOBSERVA || '  //Finalizacion Administrativa',
					fecha_finalizada = trunc(sysdate)
				where ID_ESCALAMIENTO = :IDE";
		
		$par[":VAL"]  = array($valor,-1,SQLT_CHR);
		$par[":IDE"]  = array($id,-1,SQLT_CHR);
		return self::upsert($sql,$par);
	}

//MANT
	public function get_UsuariosCAV()
	{	
		$sql = "SELECT id_usuario id, nombre,rut, decode(estado, '1', 'Activo', 'Inactivo') estado from goc.ESCALAMIENTO_USUARIOS_CAV_C";
				
		return self::consulta($sql);
	}

	public function get_ID_Insert($prut){
		$sql="SELECT id_usuario, NEW_ORG_USUARIO.rut,  nombres ||' '||apellidos as nombre_persona from organizacion.NEW_ORG_USUARIO where id_estado=1 and replace(NEW_ORG_USUARIO.rut, '.','') like replace( :RUTP, '.','') and replace(:RUTP, '.','') not in (select escalamiento_usuarios_cav_c.rut from goc.escalamiento_usuarios_cav_c)";

		$par[":RUTP"] = array($prut,-1,SQLT_CHR);
		return self::consulta($sql, $par);	
	}
	
	public function getUsuario($id)
	{	
		$sql = "SELECT id_tipo id, descripcion, estado, to_char(fecha_modificacion, 'DD/MM/YYYY HH24:MI:SS') Modificado, usuario from goc.escalamiento_tipo_c where id_tipo = :ID";

		$par[":ID"] = array($id,-1,SQLT_INT);
		return self::consulta($sql, $par);
	}
	
	public function get_CAV($id)
	{	
		$sql = "SELECT id_usuario, nombre, estado from goc.escalamiento_usuarios_cav_c where id_usuario = :ID";

		$par[":ID"] = array($id,-1,SQLT_INT);
		return self::consulta($sql, $par);
	}

	public function getServicioUsuario($id){	
		$sql = "select b.id, A.ID_SERVICIO, a.descripcion as servicio, c.descripcion as tipo, C.ID_TIPO from nnoc.RENI_SERVICIO a, nnoc.RENI_SERVICIO_TIPO b, RENI_TIPO_CPE c 
                where a.id_servicio = b.id_servicio
                and b.id_tipo = c.id_tipo
                and b.id = :ID";

		$par[":ID"] = array($id,-1,SQLT_INT);
		return self::consulta($sql, $par);
	}
	
	public function actualiza_cav($nombre, $id, $estado){
		$user = $_SESSION[user][id];
		$sql = "UPDATE goc.escalamiento_usuarios_cav_c
                set nombre = :nombre,
                	estado = :ESTADO
                where id_usuario = :ID";
		
        $par[":ID"] = array($id,-1,SQLT_INT);
		$par[":nombre"] = array($nombre,-1,SQLT_CHR);
		$par[":ESTADO"] = array($estado,-1,SQLT_CHR);
		return self::upsert($sql, $par);
	}
	
	public function agrega_cav($id, $rut, $nombre)
	{
		$sql = "INSERT INTO goc.ESCALAMIENTO_usuarios_cav_C (id_usuario,
                                     nombre,
                                     rut,
                                     estado,
                                     estado_admin)
     VALUES (:ID,
             :NOMBRE,
             :RUT,
             1,0)";
		
		$par[":ID"] = array($id,-1,SQLT_CHR);
		$par[":RUT"] = array($rut,-1,SQLT_CHR);
		$par[":NOMBRE"] = array($nombre,-1,SQLT_CHR);
		return self::upsert($sql, $par);
	}

	
	public function elimina_cav($id)
	{
		$sql = "delete from goc.escalamiento_usuarios_cav_c where id_usuario = :ID";
		
		$par[":ID"] = array($id,-1,SQLT_INT);
		self::upsert($sql, $par);
	}
//MANT

	public function permiso_admin($id){
		$sql="select * from goc.escalamiento_usuarios_cav_c
				where id_usuario = :IDU
				and estado = 1
				and estado_admin = 1";
				
		$par[":IDU"] = array($id,-1,SQLT_INT);
		return self::consulta($sql, $par);
	}
	
	public function permiso_usuario_cav($id){
		$sql="select * from goc.escalamiento_usuarios_cav_c
				where id_usuario = :IDU
				and estado = 1";
				
		$par[":IDU"] = array($id,-1,SQLT_INT);
		return self::consulta($sql, $par);
	}
}
