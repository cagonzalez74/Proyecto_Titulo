<?php
include_once($_SERVER['DOCUMENT_ROOT']."/_class/DBConneccion.class.php");

class todoDB extends DBConneccion {

	public function selectGraficoArea(){
		$sql = "select b.id_areafun,nvl(b.nombre,'Sin area'),count(a.id_usuario) from organizacion.org_usuario a
				left join organizacion.new_org_areafun b on (a.id_areafun = b.id_areafun)
				group by b.id_areafun,b.nombre
				order by b.nombre asc";
	return self::consultaNum($sql);
	}

	public function selectGraficoEstado(){
		$sql = "select nvl(b.estado,'Sin estado'),count(a.id_usuario) from organizacion.org_usuario a
				left join organizacion.org_estado_usuario b on (a.id_estado = b.id_estado)
				group by b.estado";
	return self::consultaNum($sql);
	}

	public function deleteAreaFun($id_areafun){
		$par = array();
		$sql = "UPDATE organizacion.NEW_ORG_AREAFUN
				SET ID_ESTADO = 0
				WHERE ID_AREAFUN = :ID_AREAFUN";
		
		$par[":ID_AREAFUN"]  = array($id_areafun,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function deletePerfil($id_perfil){
		$par = array();
		
		$sql = "delete from organizacion.ORG_PERFIL
				where ID_PERFIL = :ID_PERFIL";
		
		$par[":ID_PERFIL"]  = array($id_perfil,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function updatePerfil($nombre,$desc,$web_ini,$dura_con,$id_perfil){
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_PERFIL
				SET    NOMBRE            = :NOMBRE,
				       PAGINA_INICIO     = :PAGINA_INICIO,
				       DESC_PERFIL       = :DESC_PERFIL,
				       DURACION_CONEXION = :DURACION_CONEXION
				WHERE  ID_PERFIL         = :ID_PERFIL";
		
		$par[":NOMBRE"] 			= array($nombre,-1,SQLT_CHR);
		$par[":DESC_PERFIL"] 		= array($desc,-1,SQLT_CHR);
		$par[":PAGINA_INICIO"] 		= array($web_ini,-1,SQLT_CHR);
		$par[":DURACION_CONEXION"] 	= array($dura_con,-1,SQLT_INT);
		$par[":ID_PERFIL"] 			= array($id_perfil,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertPerfil($nombre,$desc,$web_ini,$dura_con){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_PERFIL (
			   NOMBRE, PAGINA_INICIO, DESC_PERFIL,   DURACION_CONEXION) 
			VALUES (:NOMBRE, :PAGINA_INICIO, :DESC_PERFIL, :DURACION_CONEXION)";
		
		$par[":NOMBRE"] 			= array($nombre,-1,SQLT_CHR);
		$par[":DESC_PERFIL"] 		= array($desc,-1,SQLT_CHR);
		$par[":PAGINA_INICIO"] 		= array($web_ini,-1,SQLT_CHR);
		$par[":DURACION_CONEXION"] 	= array($dura_con,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function actualizaModificacion($id_usuario,$codigo_tecnico_us,$area_fun_us,$cargo_us,$dire_lab_us,$interno_no_us,$empresa_us,$fecha_ingreso_vtr,$nivel_apro_us,$perfil_us,$jefe_us,$estado_us,$id_creador){
		$par = array();

		$sql = "begin organizacion.actualiza_eventos_org_usuario(:id_usuario,:codigo_tecnico_us,:area_fun_us,:cargo_us,:dire_lab_us,:interno_no_us,:empresa_us,to_date(:fecha_ingreso_vtr,'dd/mm/yy'),:nivel_apro_us,:perfil_us,:jefe_us,:estado_us,:id_creador); end;";

		$par[":id_usuario"] 		= array($id_usuario,-1,SQLT_INT);
		$par[":codigo_tecnico_us"] 	= array($codigo_tecnico_us,-1,SQLT_CHR);
		$par[":area_fun_us"] 		= array($area_fun_us,-1,SQLT_INT);
		$par[":cargo_us"] 			= array($cargo_us,-1,SQLT_INT);
		$par[":dire_lab_us"] 		= array($dire_lab_us,-1,SQLT_INT);
		$par[":interno_no_us"] 		= array($interno_no_us,-1,SQLT_INT);
		$par[":empresa_us"] 		= array($empresa_us,-1,SQLT_CHR);
		$par[":fecha_ingreso_vtr"] 	= array($fecha_ingreso_vtr,-1,SQLT_CHR);
		$par[":nivel_apro_us"] 		= array($nivel_apro_us,-1,SQLT_INT);
		$par[":perfil_us"] 			= array($perfil_us,-1,SQLT_INT);
		$par[":jefe_us"] 			= array($jefe_us,-1,SQLT_INT);
		$par[":estado_us"] 			= array($estado_us,-1,SQLT_INT);
		$par[":id_creador"] 		= array($id_creador,-1,SQLT_INT);
	return self::consulta($sql,$par);
	}

	public function updatePassword($pass,$id_usuario){
		$par = array();

		$sql = "update organizacion.org_registro
				set PASSWD 			= trim(:PASSWD),
					fecha_caducidad = to_date(to_char(add_months(SYSDATE,3),'DD/MM/YYYY hh24:mi'),'dd/mm/yy hh24:mi')
				where id_usuario = :id_usuario";
		
		$par[":PASSWD"] = array($pass,-1,SQLT_CHR);
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function selectDatosUsuario($id_usuario){
		$par = array();

		$sql = "SELECT a.pathfoto,initcap(a.nombres||' '||a.apellidos) nombre,d.NOMBRE,e.nombre as perfil,
				       c.nombre cargo,b.razon_social,f.DESC_ZONA zona,
				       g.DESCRIPCION,H.DESC_LOCALIDAD ciudad,initcap(i.nombres||' '||i.apellidos) as jefe,
				       h.desc_localidad comuna
				FROM organizacion.ORG_USUARIO a
				left join organizacion.NEW_ORG_EMPRESA b on (lower(replace(replace(a.empresa,'.',''),'-','')) = lower(replace(replace(b.RUT_EMPRESA,'.',''),'-','')))
				left join organizacion.new_org_cargo c on (a.ID_CARGO = c.id_cargo)
				left join organizacion.new_org_areafun d on(a.id_areafun = d.id_areafun)
				left join organizacion.org_perfil e on (a.id_perfil = e.id_perfil)
				left join organizacion.org_zona f on (a.cod_zona = f.codi_zona)
				left join organizacion.new_org_direccion g on (a.ID_DIRECCION = g.ID_DIRECCION)
				left join organizacion.org_localidad h on (a.CODIGO_LOCALIDAD = h.CODI_LOCALIDAD)
				left join organizacion.new_org_usuario i on(a.id_jefe = i.id_usuario)
				left join organizacion.org_localidad j on (a.CODIGO_LOCALIDAD = j.CODI_localidad)
				where a.id_usuario = :id_usuario";

		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}

	public function selectMaxIdCreFono($id_usuario){
		$par = array();
		
		$sql = "select max(id_creacion) from organizacion.ORG_TELEFONO_USUARIO
				where id_usuario = :id_usuario";

		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}

	public function selectMaxCorreoUs($id_usuario){
		$par = array();
		
		$sql = "select max(id_creacion) from organizacion.org_correo_usuario
				where id_usuario = :id_usuario";

		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}

	public function selectMaxRespDirec($id_direc){
		$par = array();
		
		$sql = "select max(id_creacion) from organizacion.ORG_RESPONSABLE_DIRECCION
				where id_direccion = :id_direccion";
		
		$par[":id_direccion"] = array($id_direc,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}

	public function updateFoto($id_usuario,$pathFoto){
		$par = array();

		$sql = "update organizacion.new_org_usuario	
				set PATHFOTO = :PATHFOTO
				where ID_USUARIO = :ID_USUARIO";
		
		$par[":PATHFOTO"] 	= array($pathFoto,-1,SQLT_CHR);
		$par[":ID_USUARIO"] = array($id_usuario,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function updateTipoCargo($nombre,$desc,$id_cargo){
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_TIPO_CARGO
				SET    NOMBRE 	    = trim(:NOMBRE),
					   DESCRIPCION  = :DESCRIPCION
				WHERE  ID_CARGO = :ID_CARGO";

		$par[":NOMBRE"] 		= array($nombre,-1,SQLT_CHR);
		$par[":DESCRIPCION"] 	= array($desc,-1,SQLT_CHR);
		$par[":ID_CARGO"] 	= array($id_cargo,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function deleteTipoCargo($id_cargo){
		$par = array();

		$sql = "delete from organizacion.ORG_TIPO_CARGO
				where ID_CARGO = :ID_CARGO";

		$par[":ID_CARGO"] = array($id_cargo,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertTipoCargo($nombre,$desc){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TIPO_CARGO (NOMBRE, DESCRIPCION) 
												      VALUES (trim(:NOMBRE), :DESCRIPCION)";
		
		$par[":NOMBRE"] 	 = array($nombre,-1,SQLT_CHR);
		$par[":DESCRIPCION"] = array($desc,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function updateTipoAreaFun($nombre,$id_areafun){
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_TIPO_AREAFUN
				SET    NOMBRE          = INITCAP(trim(:NOMBRE))
				WHERE  ID_TIPO_AREAFUN = :ID_TIPO_AREAFUN";
		
		$par[":NOMBRE"] 		 = array($nombre,-1,SQLT_CHR);
		$par[":ID_TIPO_AREAFUN"] = array($id_areafun,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function deleteTipoAreaFun($id_tipo_areafun){
		$par = array();

		$sql = "delete from organizacion.ORG_TIPO_AREAFUN
				where ID_TIPO_AREAFUN = :ID_TIPO_AREAFUN";
		
		$par[":ID_TIPO_AREAFUN"] = array($id_tipo_areafun,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertTipoAreaFun($nombre){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TIPO_AREAFUN (NOMBRE) 
													    VALUES (INITCAP(trim(:NOMBRE)))";
		
		$par[":NOMBRE"] = array($nombre,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function updateTipoDireccLab($nombre,$desc,$id_direccion){
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_TIPO_DIRECCION_LABORAL
				SET    NOMBRE      = trim(INITCAP(:NOMBRE)),
					   DESCRIPCION = trim(:DESCRIPCION)
				WHERE  ID_TIPO     = :ID_TIPO";
		
		$par[":NOMBRE"] 	 = array($nombre,-1,SQLT_CHR);
		$par[":DESCRIPCION"] = array($desc,-1,SQLT_CHR);
		$par[":ID_TIPO"] 	 = array($id_direccion,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function deleteTipoDireccLab($id_direcc_lab){
		$par = array();
		
		$sql = "delete from organizacion.ORG_TIPO_DIRECCION_LABORAL
				where ID_TIPO = :ID_TIPO";
		
		$par[":ID_TIPO"] = array($id_direcc_lab,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertTipoDireccLab($nombre,$desc){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TIPO_DIRECCION_LABORAL (NOMBRE, DESCRIPCION) 
																  VALUES (INITCAP(trim(:NOMBRE)),:DESCRIPCION)";
		
		$par[":NOMBRE"] 	 = array($nombre,-1,SQLT_CHR);
		$par[":DESCRIPCION"] = array($desc,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function updateDireccUs($nombre,$id){
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_TIPO_DIRECCION_USUARIO
				SET    NOMBRE = INITCAP(trim(:NOMBRE))
				WHERE  ID_TIPO_DIRECCION_USUARIO = :ID_TIPO_DIRECCION_USUARIO";
		
		$par[":NOMBRE"] = array($nombre,-1,SQLT_CHR);
		$par[":ID_TIPO_DIRECCION_USUARIO"] = array($id,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function deleteTipoDireccUs($id_direcc_us){
		$par = array();
		
		$sql = "delete from organizacion.ORG_TIPO_DIRECCION_USUARIO
				where ID_TIPO_DIRECCION_USUARIO = :ID_TIPO_DIRECCION_USUARIO";
		
		$par[":ID_TIPO_DIRECCION_USUARIO"] = array($id_direcc_us,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertTipoDireccUs($nombre){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TIPO_DIRECCION_USUARIO (NOMBRE) 
																  VALUES (INITCAP(trim(:NOMBRE)))";
		
		$par[":NOMBRE"] = array($nombre,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function updateTipoRol($nombre,$id){ 
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_TIPO_ROL
				SET    ROL         = INITCAP(trim(:ROL))
				WHERE  ID_TIPO_ROL = :ID_TIPO_ROL";
		
		$par[":ROL"] 		 = array($nombre,-1,SQLT_CHR);
		$par[":ID_TIPO_ROL"] = array($id,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function deleteTipoRol($id_rol){
		$par = array();
		
		$sql = "delete from organizacion.ORG_TIPO_ROL
				where id_tipo_rol = :id_tipo_rol";
		
		$par[":id_tipo_rol"] = array($id_rol,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertTipoRol($rol){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TIPO_ROL (ROL) 
													VALUES (INITCAP(trim(:ROL)))";
		
		$par[":ROL"] = array($rol,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function selectTipoRol($id_rol = ""){
		$par = array();
		
		if($id_rol != ""){
			$where = "where id_tipo_rol = :id_tipo_rol";
		$par[":id_tipo_rol"] = array($id_rol,-1,SQLT_INT);
		}
		
		$sql = "select id_tipo_rol, rol from organizacion.ORG_TIPO_ROL
				$where
				order by rol asc";
	return self::consulta($sql,$par);
	}

	public function updateTipoCorreo($nombre,$id){
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_TIPO_CORREO_USUARIO
				SET    DESCRIPCION            = INITCAP(trim(:DESCRIPCION))
				WHERE  ID_TIPO_CORREO_USUARIO = :ID_TIPO_CORREO_USUARIO";
		
		$par[":DESCRIPCION"] 			= array($nombre,-1,SQLT_CHR);
		$par[":ID_TIPO_CORREO_USUARIO"] = array($id,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function updateTipoTel($nombre,$id){
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_TIPO_TELEFONO
				SET    DESCRIPCION_TELEFONO = INITCAP(trim(:DESCRIPCION_TELEFONO))
				WHERE  ID_TIPO_TELEFONO     = :ID_TIPO_TELEFONO";
		
		$par[":DESCRIPCION_TELEFONO"] 	= array($nombre,-1,SQLT_CHR);
		$par[":ID_TIPO_TELEFONO"] 		= array($id,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function updateTipoUsuario($nombre,$id){
		$par = array();
		
		$sql = "UPDATE organizacion.ORG_TIPO_USUARIO
				SET    NOMBRE          = INITCAP(trim(:NOMBRE))
				WHERE  ID_TIPO_USUARIO = :ID_TIPO_USUARIO";
		
		$par[":NOMBRE"] 		 = array($nombre,-1,SQLT_CHR);
		$par[":ID_TIPO_USUARIO"] = array($id,-1,SQLT_INT);
		
	return self::upsert($sql,$par);
	}
	
	public function deleteTipoCorreo($id_correo){
		$par = array();
			
		$sql = "delete from organizacion.ORG_TIPO_CORREO_USUARIO
			where ID_TIPO_CORREO_USUARIO = :ID_TIPO_CORREO_USUARIO";
		
		$par[":ID_TIPO_CORREO_USUARIO"] = array($id_correo,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function insertTipoCorreo($nombre){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TIPO_CORREO_USUARIO (DESCRIPCION) 
															   VALUES (lower(trim(:DESCRIPCION)))";
		
		$par[":DESCRIPCION"] = array($nombre,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}
	
	public function deleteTipoTel($id_tel){
		$par = array();
		
		$sql = "delete from organizacion.ORG_TIPO_TELEFONO
				where ID_TIPO_TELEFONO = :ID_TIPO_TELEFONO";
		
		$par[":ID_TIPO_TELEFONO"] = array($id_tel,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}
	
	public function insertTipoTel($tipo_tel){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TIPO_TELEFONO(DESCRIPCION_TELEFONO) 
														VALUES (INITCAP(trim(:nombre)))";
		
		$par[":nombre"] = array($tipo_tel,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}
	
	public function deleteTipoUsuario($id_tipo){
		$par = array();
		
		$sql = "delete from organizacion.ORG_TIPO_USUARIO
				where id_tipo_usuario = :tipo_usuario";
		
		$par[":tipo_usuario"] = array($id_tipo,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function insertTipoUsuario($nuevoTipo){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TIPO_USUARIO (NOMBRE)
														VALUES (INITCAP(trim(:nombre)))";
		
		$par[":nombre"] = array($nuevoTipo,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}
	
	public function updateRespDireccion($nombre,$tipo,$zona,$comuna,$telefono,$emergen,$id_direc){
		$par = array();
		
		$sql = "UPDATE organizacion.new_ORG_DIRECCION
				SET    DESCRIPCION       = :DESCRIPCION,
				       CODIGO_COMUNA     = :CODIGO_COMUNA,
				       ID_TIPO_DIRECCION = :ID_TIPO_DIRECCION,
				       CODI_ZONA         = :CODI_ZONA,
				       TELEFONO          = :TELEFONO,
				       TEL_EMERGENCIA    = :TEL_EMERGENCIA
				WHERE  ID_DIRECCION      = :ID_DIRECCION";
		
		$par[":DESCRIPCION"]   		= array($nombre,-1,SQLT_CHR);
		$par[":CODIGO_COMUNA"]   	= array($comuna,-1,SQLT_CHR);
		$par[":ID_TIPO_DIRECCION"]  = array($tipo,-1,SQLT_INT);
		$par[":CODI_ZONA"]   		= array($zona,-1,SQLT_CHR);
		$par[":TELEFONO"]   		= array($telefono,-1,SQLT_CHR);
		$par[":TEL_EMERGENCIA"]   	= array($emergen,-1,SQLT_CHR);
		$par[":ID_DIRECCION"]   	= array($id_direc,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function deleteRespDireccion($id_usuario,$id_direccion){
		$par = array();
		
		$sql = "delete from organizacion.ORG_RESPONSABLE_DIRECCION
				where id_usuario   = :id_usuario
				  and id_direccion = :id_direccion";
		
		$par[":id_usuario"]   = array($id_usuario,-1,SQLT_INT);
		$par[":id_direccion"] = array($id_direccion,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function selectRespDirec($id_direc){
		$par = array();
		
		$sql = "select a.id_direccion,a.id_usuario,initcap(b.nombres||' '||b.apellidos) nombres
					from organizacion.ORG_RESPONSABLE_DIRECCION a
				left join organizacion.new_org_usuario b on (a.id_usuario = b.id_usuario)
				where a.id_direccion = :id_direccion
				order by nombres asc";
		
		$par[":id_direccion"]   = array($id_direc,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}

	public function deleteResponsableDirecc($id_direccion){
		$par = array();

		$sql = "delete from organizacion.ORG_RESPONSABLE_DIRECCION
				where id_direccion = :id_direccion";
		
		$par[":id_direccion"]   = array($id_direccion,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function deleteDireccionLaboral($id_direccion){
		$par = array();
		
		$sql = "update organizacion.new_ORG_DIRECCION
				set id_estado = 2
				where id_direccion = :id_direccion";
		
		$par[":id_direccion"]   = array($id_direccion,-1,SQLT_INT);
	return self::upsert($sql,$par);	
	}

	public function selectGrillaDireccLaboral($id_direc = ""){
		$par = array();
		
		if($id_direc != ""){
			$and = "and a.id_direccion = :id_direccion";
		$par[":id_direccion"]   = array($id_direc,-1,SQLT_INT);
		}
		
		$sql = "select a.id_direccion,a.descripcion,b.id_tipo,
				       b.nombre,count(c.id_usuario) responsables,d.desc_zona,e.desc_localidad,
				       a.telefono,a.TEL_EMERGENCIA, a.codi_zona,
				       a.codigo_comuna
				   from organizacion.new_ORG_DIRECCION a
				left join organizacion.ORG_TIPO_DIRECCION_LABORAL b on (a.ID_TIPO_DIRECCION = b.ID_TIPO)
				left join organizacion.ORG_RESPONSABLE_DIRECCION c on (a.id_direccion = c.id_direccion)
				left join organizacion.ORG_ZONA d on(a.codi_zona = d.codi_zona)
				left join organizacion.ORG_LOCALIDAD e on(a.codigo_comuna = e.codi_localidad)
				where id_estado = 1
				$and
				group by a.id_direccion,a.descripcion,b.id_tipo,
				         b.nombre,d.desc_zona,e.desc_localidad,
				         a.telefono,a.TEL_EMERGENCIA, a.codi_zona,
				         a.codigo_comuna
				order by a.descripcion asc";
	return self::consultaNum($sql,$par);
	}

	public function insertResponDirecc($ultimaDirec,$responsable,$id_creacion){
		$par = array();
				
		$sql = "INSERT INTO organizacion.ORG_RESPONSABLE_DIRECCION (
			   ID_DIRECCION, ID_USUARIO,ID_CREACION) 
			VALUES (:ID_DIRECCION ,:ID_USUARIO,:ID_CREACION)";

		$par[":ID_DIRECCION"] = array($ultimaDirec,-1,SQLT_CHR);
		$par[":ID_USUARIO"]   = array($responsable,-1,SQLT_INT);
		$par[":ID_CREACION"]   = array($id_creacion,-1,SQLT_INT);
	return self::upsert($sql,$par);	
	}

	public function selectMaxDireccion(){
		$sql = "select max(id_direccion) from organizacion.new_ORG_DIRECCION";
	return self::consultaNum($sql);
	}

	public function selectMaxDireccionUsuario($id_usuario){
		$par = array();
		
		$sql = "select max(ID_CREACION) from organizacion.ORG_DIRECCION_USUARIO
				where id_usuario = :id_usuario";
		
		$par[":id_usuario"] 	= array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}

	public function insertDireccionLaboral($nombre,$tipo,$zona,$localidad,$telefono,$emergencia){
		$par = array();
		
		$sql = "INSERT INTO organizacion.new_ORG_DIRECCION (
				   DESCRIPCION, CODIGO_COMUNA, ID_TIPO_DIRECCION, 
				   CODI_ZONA, TELEFONO, TEL_EMERGENCIA,ID_ESTADO) 
				VALUES (:DESCRIPCION, :CODIGO_COMUNA, :ID_TIPO_DIRECCION,
				   		:CODI_ZONA, :TELEFONO, :TEL_EMERGENCIA,1)";
		
		$par[":DESCRIPCION"] 		= array($nombre,-1,SQLT_CHR);
		$par[":CODIGO_COMUNA"] 		= array($localidad,-1,SQLT_CHR);
		$par[":ID_TIPO_DIRECCION"] 	= array($tipo,-1,SQLT_INT);
		$par[":CODI_ZONA"] 			= array($zona,-1,SQLT_CHR);
		$par[":TELEFONO"] 			= array($telefono,-1,SQLT_CHR);
		$par[":TEL_EMERGENCIA"] 	= array($emergencia,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function selectTipoDireccionLabGrilla($id_direccion = ""){
		$par = array();
		
		if($id_direccion != ""){
			$where = "where id_tipo = :id_tipo";
		$par[":id_tipo"] 	   = array($id_direccion,-1,SQLT_INT);
		}
		$sql = "select id_tipo,nombre,descripcion from organizacion.ORG_TIPO_DIRECCION_LABORAL
				$where
				order by nombre asc";
				
	return self::consulta($sql,$par);
	}

	public function selectTipoDireccionLab(){

		$sql = "select id_tipo,nombre from organizacion.ORG_TIPO_DIRECCION_LABORAL
				order by nombre asc";

	return self::consulta($sql,$par);
	}

	public function selectZona(){
		$sql = "select codi_zona, desc_zona from organizacion.ORG_ZONA
				order by desc_zona asc";
	return self::consulta($sql);
	}

	public function updateEmpresa($rut_empresa,$razon_social,$fono,$direccion,$responsable,$tipo_empresa,$rut_empresa_where,$correo,$url){
		$par = array();

		$sql = "UPDATE organizacion.new_ORG_EMPRESA
				SET    RUT_EMPRESA        = :RUT_EMPRESA,
				       RAZON_SOCIAL       = :RAZON_SOCIAL,
				       ID_DIRECCION       = :ID_DIRECCION,
				       TELEFONO           = :TELEFONO,
				       ID_RESPONSABLE     = :ID_RESPONSABLE,
				       ID_TIPO_USUARIO    = :ID_TIPO_USUARIO,
				       CORREO_RESPONSABLE = :CORREO_RESPONSABLE,
				       WEB				  = :WEB
				WHERE lower(replace(replace(rut_empresa,'-',''),'.','')) = lower(replace(replace(:rut_empresa_where,'-',''),'.',''))";

		$par[":rut_empresa_where"] 	= array($rut_empresa_where,-1,SQLT_CHR);
		$par[":RUT_EMPRESA"] 	   	= array($rut_empresa,-1,SQLT_CHR);
		$par[":RAZON_SOCIAL"] 	   	= array($razon_social,-1,SQLT_CHR);
		$par[":ID_DIRECCION"] 	   	= array($direccion,-1,SQLT_INT);
		$par[":TELEFONO"] 		   	= array($fono,-1,SQLT_CHR);
		$par[":ID_RESPONSABLE"]    	= array($responsable,-1,SQLT_INT);
		$par[":ID_TIPO_USUARIO"]   	= array($tipo_empresa,-1,SQLT_INT);
		$par[":CORREO_RESPONSABLE"]	= array($correo,-1,SQLT_CHR);
		$par[":WEB"]   				= array($url,-1,SQLT_CHR);
			
	return self::upsert($sql,$par);
	}

	public function deleteEmpresa($rut_empresa){
		$par = array();
		
		$sql = "update organizacion.new_ORG_EMPRESA
				set id_estado = 2
				where lower(replace(replace(rut_empresa,'-',''),'.','')) = lower(replace(replace(:rut_empresa,'-',''),'.',''))" ;
	
		$par[":rut_empresa"] = array($rut_empresa,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function insertEmpresa($rut_empresa,$razon_social,$fono,$direccion,$responsable,$tipo_empresa,$correo,$url){
		$par = array();

		$sql = "INSERT INTO organizacion.new_ORG_EMPRESA (
				   RUT_EMPRESA, RAZON_SOCIAL, ID_DIRECCION, 
				   TELEFONO, ID_RESPONSABLE, ID_TIPO_USUARIO,ID_ESTADO,CORREO_RESPONSABLE,WEB) 
				VALUES (:RUT_EMPRESA , :RAZON_SOCIAL, :ID_DIRECCION,
				    	:TELEFONO, :ID_RESPONSABLE, :ID_TIPO_USUARIO,1,:CORREO_RESPONSABLE,:WEB)";

		$par[":RUT_EMPRESA"] 		= array($rut_empresa,-1,SQLT_CHR);
		$par[":RAZON_SOCIAL"] 		= array($razon_social,-1,SQLT_CHR);
		$par[":ID_DIRECCION"] 		= array($direccion,-1,SQLT_INT);
		$par[":TELEFONO"] 			= array($fono,-1,SQLT_CHR);
		$par[":ID_RESPONSABLE"] 	= array($responsable,-1,SQLT_INT);
		$par[":ID_TIPO_USUARIO"]	= array($tipo_empresa,-1,SQLT_INT);
		$par[":CORREO_RESPONSABLE"]	= array($correo,-1,SQLT_CHR);
		$par[":WEB"]				= array($url,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function selectEmpresaExiste($rut_empresa){
		$par = array();
		
		$sql = "select count(1) from organizacion.new_ORG_EMPRESA
				where lower(replace(replace(rut_empresa,'-',''),'.','')) = lower(replace(replace(:rut_empresa,'-',''),'.',''))";
	
		$par[":rut_empresa"] = array($rut_empresa,-1,SQLT_CHR);
	return self::consultaNum($sql,$par);
	}

	public function selectTipoEmpresa(){ //Para esto selecciono la tabla tipo de usuario Externo o interno
		$sql = "select id_tipo_usuario,nombre from organizacion.ORG_TIPO_USUARIO
				where id_tipo_usuario in (1,2)
				order by nombre asc";
	return self::consulta($sql);
	}

	public function selectEmpresaGrilla($rut_empresa = ""){
		$par = array();
		
		if($rut_empresa != ""){
			$and_rut = "where lower(replace(replace(rut_empresa,'-',''),'.','')) = lower(replace(replace(:rut_empresa,'-',''),'.',''))";
		$par[":rut_empresa"] = array($rut_empresa,-1,SQLT_CHR);
		}
		
		$sql = "select lower(a.rut_empresa),a.razon_social,b.descripcion,
				       c.nombres||' '||c.apellidos encargado, d.nombre,a.telefono,
				       b.id_direccion,c.id_usuario,d.id_tipo_usuario,
				       a.correo_responsable,a.web,EST.ESTADO
				    from organizacion.new_ORG_EMPRESA a
				left join organizacion.new_ORG_DIRECCION b on (a.id_direccion = b.id_direccion)
				left join organizacion.new_org_usuario c on (a.id_responsable = c.id_usuario)
				left join organizacion.ORG_TIPO_USUARIO d on (a.id_tipo_usuario = d.id_tipo_usuario)
				left join organizacion.org_estado_usuario est on est.id_estado = nvl(a.id_estado,1)
				$and_rut order by a.razon_social asc";
	return self::consultaNum($sql,$par);
	}

	public function selectTipoCargoGrilla($id_cargo = ""){
		$par = array();
		
		if($id_cargo != ""){
			$where = "where ID_CARGO = :ID_CARGO";
		$par[":ID_CARGO"] 	= array($id_cargo,-1,SQLT_INT);
		}
		 $sql = "select ID_CARGO,nombre,descripcion from organizacion.ORG_TIPO_CARGO
		 		$where
		 		order by nombre asc";
	return self::consulta($sql,$par);
	}

	public function selectTipoCargo(){
		 $sql = "select ID_CARGO,nombre from organizacion.ORG_TIPO_CARGO
		 		order by nombre asc";
	return self::consulta($sql);
	}

	public function updateCargo($nombre,$desc,$tipo,$id_cargo){
		$par = array();
				
		$sql = "UPDATE organizacion.new_ORG_CARGO
				SET    NOMBRE        = :NOMBRE,
				       DESCRIPCION   = :DESCRIPCION,
				       ID_TIPO_CARGO = :ID_TIPO_CARGO
				WHERE  ID_CARGO      = :ID_CARGO";
		
		$par[":NOMBRE"] 	    = array($nombre,-1,SQLT_CHR);
		$par[":DESCRIPCION"] 	= array($desc,-1,SQLT_CHR);
		$par[":ID_TIPO_CARGO"] 	= array($tipo,-1,SQLT_INT);
		$par[":ID_CARGO"] 		= array($id_cargo,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function deleteCargo($id_cargo){
		$par = array();

		/*$sql = "delete from organizacion.ORG_CARGO
				where id_cargo = :id_cargo";*/
		$sql = "UPDATE organizacion.new_ORG_CARGO
				SET ID_ESTADO = 0
				where id_cargo = :id_cargo";
		
		$par[":id_cargo"] 	= array($id_cargo,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertCargo($nombre,$desc,$tipo,$id_creador){
		$par = array();
		
		$sql = "INSERT INTO organizacion.new_ORG_CARGO (NOMBRE, DESCRIPCION, ID_TIPO_CARGO, ID_CREADOR,ID_ESTADO) 
												 VALUES (:NOMBRE, :DESCRIPCION, :ID_TIPO_CARGO, :ID_CREADOR,1)";
		
		$par[":NOMBRE"] 		= array($nombre,-1,SQLT_CHR);
		$par[":DESCRIPCION"] 	= array($desc,-1,SQLT_CHR);
		$par[":ID_TIPO_CARGO"] 		= array($tipo,-1,SQLT_INT);
		$par[":ID_CREADOR"] 	= array($id_creador,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function selectCargoGrilla($id_cargo = ""){
		$par = array();
		
		if($id_cargo != ""){
			$and_id_c = "and a.id_cargo = :id_cargo";
		$par[":id_cargo"] 	= array($id_cargo,-1,SQLT_INT);
		}
		
		$sql = "select a.id_cargo,a.nombre,b.nombres||' '||b.apellidos creador,c.nombre tipo_cargo,
					   c.id_cargo,a.descripcion
					from organizacion.new_org_cargo a
				left join organizacion.new_org_usuario b on(a.id_creador = b.id_usuario)
				left join organizacion.org_tipo_cargo c on(a.id_tipo_cargo = c.id_cargo)
				where a.id_estado = 1
				$and_id_c
				order by a.nombre asc";
	return self::consultaNum($sql,$par);
	}
		
	public function selectTipoAreaFun($id_areafun = ""){
		$par = array();
		
		if($id_areafun != ""){
			$where = "where id_tipo_areafun = :id_tipo_areafun";
		$par[":id_tipo_areafun"] 		  = array($id_areafun,-1,SQLT_INT);
		}
		
		$sql = "select id_tipo_areafun,nombre from organizacion.ORG_TIPO_AREAFUN
				$where
				order by nombre asc";
	return self::consulta($sql,$par);
	}

	public function updateAreaFun($nom_area,$desc_area,$resp_area,$area_padre,$dire_area,$id_area,$tipo_area){
		$par = array();
		
		$sql = "UPDATE organizacion.new_ORG_AREAFUN
				SET    NOMBRE               = :NOMBRE,
				       DESCRIPCION          = :DESCRIPCION,
				       RESPONSABLE          = :RESPONSABLE,
				       ID_AREA_PADRE        = :ID_AREA_PADRE,
				       ID_DIRECCION 		= :ID_DIRECCION,
				       ID_TIPO_AREAFUN		= :ID_TIPO_AREAFUN
				WHERE  ID_AREAFUN           = :ID_AREAFUN";
		
		$par[":NOMBRE"] 			  = array($nom_area,-1,SQLT_CHR);
		$par[":DESCRIPCION"] 		  = array($desc_area,-1,SQLT_CHR);
		$par[":RESPONSABLE"] 		  = array($resp_area,-1,SQLT_INT);
		$par[":ID_AREA_PADRE"] 		  = array($area_padre,-1,SQLT_INT);
		$par[":ID_DIRECCION"] 		  = array($dire_area,-1,SQLT_INT);
		$par[":ID_AREAFUN"] 		  = array($id_area,-1,SQLT_INT);
		$par[":ID_TIPO_AREAFUN"] 	  = array($tipo_area,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function insertArea($nom_area,$desc_area,$resp_area,$area_padre,$dire_area,$id_creador,$tipo_area){
		$par = array();
		
		$sql = "insert into organizacion.new_org_areafun(nombre,descripcion,responsable,creador,id_area_padre,id_direccion,id_tipo_areafun,id_estado)
												  values(:nombre,:descripcion,:responsable,:creador,:id_area_padre,:id_direccion,:tipo_area,1)";
		
		$par[":nombre"] 			  = array($nom_area,-1,SQLT_CHR);
		$par[":descripcion"] 		  = array($desc_area,-1,SQLT_CHR);
		$par[":responsable"] 		  = array($resp_area,-1,SQLT_INT);
		$par[":creador"] 			  = array($id_creador,-1,SQLT_INT);
		$par[":id_area_padre"] 		  = array($area_padre,-1,SQLT_INT);
		$par[":id_direccion"] 		  = array($dire_area,-1,SQLT_INT);
		$par[":tipo_area"] 			  = array($tipo_area,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function selectAreaFunGrilla($id_areafun = ""){
		$par = array();
		
		if($id_areafun != ""){
			$and_area = "where a.id_areafun = :id_area_fun";
		$par[":id_area_fun"] = array($id_areafun,-1,SQLT_INT);
		}
		
		$sql = "select a.id_areafun, a.nombre, a.responsable,
					   b.nombres||' '||b.apellidos nombre_usuario, c.nombre nombre_area_padres, c.id_areafun,
					   d.ID_DIRECCION, d.DESCRIPCION,a.descripcion descripcion_area,
					   e.nombre,e.id_tipo_areafun
				    from  organizacion.new_org_areafun a
				left join organizacion.new_ORG_USUARIO b on (a.responsable = b.id_usuario)
				left join organizacion.new_org_areafun c on(a.id_area_padre = c.id_areafun)
				left join organizacion.new_ORG_DIRECCION d on(a.id_direccion = d.ID_DIRECCION)
				left join organizacion.ORG_TIPO_AREAFUN e on(a.id_tipo_areafun = e.id_tipo_areafun)
				$and_area
				order by a.nombre asc";

	return self::consultaNum($sql,$par);
	}

	public function updateUsuario($rut_us,$nombre_us,$apellido_us,$fecha_nac,$sexo_us,$codigo_tecnico_us,$area_fun_us,$cargo_us,$dire_lab_us,$interno_no_us,$empresa_us,$fecha_ingreso_vtr,$nivel_apro_us,$perfil_us,$jefe_us,$estado_us,$id_usuario,$id_creador){

		$sql = "UPDATE organizacion.new_ORG_USUARIO
					SET    RUT                  = lower(:RUT),
					       NOMBRES              = :NOMBRES,
					       APELLIDOS            = :APELLIDOS,
					       FECHA_INGRESO        = to_date(:FECHA_INGRESO,'dd/mm/yyyy'),
					       SEXO                 = :SEXO,
					       EMPRESA              = :EMPRESA,
					       CODIGO_TECNICO       = :CODIGO_TECNICO,
					       ID_NIVEL_APSI        = :ID_NIVEL_APSI,
					       ID_PERFIL            = :ID_PERFIL,
					       ID_JEFE              = :ID_JEFE,
					       ID_CARGO             = :ID_CARGO,
					       ID_AREAFUN           = :ID_AREAFUN,
					       FECHA_NACIMIENTO     = to_date(:FECHA_NACIMIENTO,'dd/mm/yyyy'),
					       ID_CREADOR           = :ID_CREADOR,
					       ID_ESTADO            = :ID_ESTADO,
					       ID_TIPO_USUARIO      = :ID_TIPO_USUARIO,
					       ID_DIRECCION    		= :ID_DIRECCION
				 WHERE  ID_USUARIO           = :ID_USUARIO";

		$par[":RUT"] 				= array($rut_us,-1,SQLT_CHR);
		$par[":NOMBRES"] 			= array($nombre_us,-1,SQLT_CHR);
		$par[":APELLIDOS"] 			= array($apellido_us,-1,SQLT_CHR);
		$par[":FECHA_NACIMIENTO"]	= array($fecha_nac,-1,SQLT_CHR);
		$par[":SEXO"] 				= array($sexo_us,-1,SQLT_CHR);
		$par[":CODIGO_TECNICO"] 	= array($codigo_tecnico_us,-1,SQLT_CHR);
		$par[":ID_AREAFUN"] 		= array($area_fun_us,-1,SQLT_INT);
		$par[":ID_CARGO"] 			= array($cargo_us,-1,SQLT_INT);
		$par[":ID_DIRECCION"] 		= array($dire_lab_us,-1,SQLT_INT);
		$par[":ID_TIPO_USUARIO"] 	= array($interno_no_us,-1,SQLT_INT);
		$par[":EMPRESA"] 			= array($empresa_us,-1,SQLT_CHR);
		$par[":FECHA_INGRESO"] 		= array($fecha_ingreso_vtr,-1,SQLT_CHR);
		$par[":ID_NIVEL_APSI"] 		= array($nivel_apro_us,-1,SQLT_INT);
		$par[":ID_PERFIL"] 			= array($perfil_us,-1,SQLT_INT);
		$par[":ID_JEFE"] 			= array($jefe_us,-1,SQLT_INT);
		$par[":ID_ESTADO"] 			= array($estado_us,-1,SQLT_INT);
		$par[":ID_CREADOR"] 		= array($id_creador,-1,SQLT_INT);
		$par[":ID_USUARIO"] 		= array($id_usuario,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function updateLogin($login,$id_usuario){
		$par = array();

		$sql = "update organizacion.ORG_REGISTRO
				set login = :login
				where id_usuario = :id_usuario";

		$par[":login"]		= array($login,-1,SQLT_CHR);
		$par[":id_usuario"]	= array($id_usuario,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function eliminaFoto($id_usuario){
		$par = array();

		$sql = "update organizacion.new_ORG_USUARIO
				set pathfoto = ''
				where id_usuario = :id_usuario";
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function updateFono($id_fono,$fono,$tipo_fono){
		$par = array();

		$sql = "update organizacion.ORG_TELEFONO_USUARIO
				set telefono = :telefono,
					id_tipo_telefono = :tipo
				where id_telefono_usuario = :id_fono";
		
		$par[":telefono"] = array($fono,-1,SQLT_CHR);
		$par[":tipo"] 	  = array($tipo_fono,-1,SQLT_INT);
		$par[":id_fono"]  = array($id_fono,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function updateEmail($id_email,$email,$tipo_email){
		$par = array();
		
		$sql = "update organizacion.ORG_CORREO_USUARIO
				set correo 					= :correo,
					id_tipo_correo_usuario	= :id_tipo_correo
				where id_correo_usuario = :id_mail";
		
		$par[":id_mail"] 		= array($id_email,-1,SQLT_INT);
		$par[":correo"] 		= array($email,-1,SQLT_CHR);
		$par[":id_tipo_correo"] = array($tipo_email,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function UpdateDireccion($id_direccion,$direccion,$numero,$dpto,$tipo,$local){
		$par = array();
		
		$sql = "update organizacion.ORG_DIRECCION_USUARIO
				set direccion 		  = :direccion,
					numero	  		  = :numero,
					depto			  = :dpto,
					id_tipo_direccion = :tipo,
					codi_localidad	  = :local
				where id_direccion_usuario = :id_direccion";	

		$par[":id_direccion"] 	= array($id_direccion,-1,SQLT_INT);
		$par[":direccion"] 		= array($direccion,-1,SQLT_CHR);
		$par[":numero"] 		= array($numero,-1,SQLT_INT);
		$par[":dpto"] 			= array($dpto,-1,SQLT_CHR);
		$par[":tipo"] 			= array($tipo,-1,SQLT_INT);
		$par[":local"] 			= array($local,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function deleteFono($id_fono){
		$par = array();
		
		$sql = "delete from organizacion.ORG_TELEFONO_USUARIO
				where id_telefono_usuario = :id_fono";
		
		$par[":id_fono"] = array($id_fono,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function deleteEmail($id_email){
		$par = array();
		
		$sql = "delete from organizacion.ORG_CORREO_USUARIO
				where id_correo_usuario = :id_email";
		
		$par[":id_email"] = array($id_email,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function deleteDireccion($id_direccion){
		$par = array();
		
		$sql = "delete from organizacion.ORG_DIRECCION_USUARIO
				where id_direccion_usuario = :id_direccion";
		
		$par[":id_direccion"] = array($id_direccion,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}
	
	public function selectFono($id_usuario){
		$par = array();
		
		$sql = "select a.id_telefono_usuario,a.telefono,b.descripcion_telefono,a.id_tipo_telefono 
					from organizacion.ORG_TELEFONO_USUARIO a
				left join organizacion.ORG_TIPO_TELEFONO b on (a.id_tipo_telefono = b.id_tipo_telefono)
				where a.id_usuario = :id_usuario";
		
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}
	
	public function selectEmail($id_usuario){
		$par = array();
		
		$sql = "select a.id_correo_usuario,a.correo,b.id_tipo_correo_usuario,b.descripcion,a.id_usuario
						from organizacion.org_correo_usuario a
				left join organizacion.ORG_TIPO_CORREO_USUARIO b on (a.ID_TIPO_CORREO_USUARIO = b.ID_TIPO_CORREO_USUARIO)
				where a.id_usuario = :id_usuario
				order by a.id_correo_usuario asc";
		
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}

	public function direccionUsuario($id_usuario){
		$par = array();
		
		$sql = "select a.id_direccion_usuario, a.direccion, a.numero,
				       a.depto,a.codi_localidad,a.id_usuario,
				       b.nombre, a.id_tipo_direccion
				     from organizacion.org_direccion_usuario a
				left join organizacion.ORG_TIPO_DIRECCION_USUARIO b on(a.id_tipo_direccion = b.id_tipo_direccion_usuario)
				where id_usuario = :id_usuario
				order by a.id_direccion_usuario asc";

		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}

	public function selectuDataUsuario($id_usuario = "",$area = "",$zona = "",$empresa = "",$perfil = "",$rut = "",$nombre = "",$apellido = ""){
		$par = array();

		if($id_usuario != ""){
			$and_us = "and a.id_usuario = :id_usuario";
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
		}
		if($area != ""){
			$and_a = "and a.id_areafun = :area";
		$par[":area"] = array($area,-1,SQLT_INT);
		}
		if($zona != ""){
			$and_z = "and i.codi_zona = :zona";
		$par[":zona"] = array($zona,-1,SQLT_CHR);
		}
		if($empresa != ""){
			$and_e = "and lower(replace(replace(a.empresa,'.',''),'-','')) = lower(replace(replace(:rut_empresa,'.',''),'-',''))";
		$par[":rut_empresa"] = array($empresa,-1,SQLT_CHR);
		}
		if($perfil != ""){
			$and_p = "and a.id_perfil = :perfil";
		$par[":perfil"] = array($perfil,-1,SQLT_INT);
		}
		if($rut != ""){
			$and_rut = "and lower(a.rut) = lower(:rut)";
		$par[":rut"] = array($rut,-1,SQLT_CHR);
		}
		if($nombre != ""){
			$and_nom = "and lower(a.nombres) like '%'||lower(:nombre)||'%'";
		$par[":nombre"] = array($nombre,-1,SQLT_CHR);
		}
		if($apellido != ""){
			$and_ape = "and lower(a.apellidos) like '%'||lower(:apellido)||'%'";
		$par[":apellido"] = array($apellido,-1,SQLT_CHR);
		}

		$sql = "select a.id_usuario, a.rut, initcap(a.nombres||' '||a.apellidos) nombre,
				       to_char(a.fecha_ingreso,'dd/mm/yyyy'), a.sexo, b.razon_social,
				       c.nombres||' '||c.apellidos jefe, d.nombre area, e.nombre cargo,
				       f.estado, g.nombre interno, a.pathfoto,
				       a.nombres, a.apellidos, h.login,
				       to_char(a.fecha_nacimiento,'dd/mm/yyyy'), a.codigo_tecnico, a.id_areafun,
				       a.id_cargo, a.id_direccion, a.id_tipo_usuario,
				       a.empresa, a.id_nivel_apsi, a.id_perfil,
				       a.id_jefe, a.id_estado
				     from organizacion.new_org_usuario a
				left join organizacion.new_org_empresa b on (lower(replace(replace(a.empresa,'.',''),'-','')) = lower(replace(replace(b.rut_empresa,'.',''),'-','')))
				left join organizacion.new_org_usuario c on (a.id_jefe = c.id_usuario)
				left join organizacion.new_org_areafun d on (a.id_areafun = d.id_areafun)
				left join organizacion.new_org_cargo e on (a.id_cargo = e.id_cargo)
				left join organizacion.org_estado_usuario f on (a.id_estado = f.id_estado)
				left join organizacion.org_tipo_usuario g on (a.id_tipo_usuario = g.id_tipo_usuario)
				left join organizacion.org_registro h on (a.id_usuario = h.id_usuario)
				left join organizacion.new_org_direccion i on (a.id_direccion = i.id_direccion)
				where 1=1		
				$and_us
				$and_a
				$and_z
				$and_e
				$and_p
				$and_rut
				$and_nom
				$and_ape
				order by a.nombres||' '||a.apellidos asc";
	
		return self::consultaNum($sql,$par);		
	}

	public function selectLogin($id_usuario){
		$par = array();

		$sql = "select initcap(a.nombres||' '||a.apellidos),b.login from organizacion.new_org_usuario a
				left join organizacion.org_registro b on (a.id_usuario = b.id_usuario)
				where a.id_usuario = :id_usuario";
		
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}
	
	public function enviaCorreo($remitente,$destinatario,$asunto,$mensaje){
			$par = array();
		
			$sql="begin NNOC.EnviarCorreo_beta_ccambio(:remitente,:Destinatarios,:asunto,:mensaje); end;";
			
			$par[":remitente"] 		= array($remitente,-1,SQLT_CHR);
			$par[":Destinatarios"]  = array($destinatario,-1,SQLT_CHR);
			$par[":asunto"] 		= array($asunto,-1,SQLT_CHR);
			$par[":mensaje"] 		= array($mensaje,-1,SQLT_CHR);
	return self::consulta($sql,$par);
	} 

	public function selectCorreo($id_usuario){
		$par = array();

		$sql = "select id_tipo_correo_usuario,correo from organizacion.ORG_CORREO_USUARIO
				where id_usuario = :id_usuario";
		
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
	}
	
	public function insertFono($fono,$tipo_fono,$id_usuario,$id_creacion){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_TELEFONO_USUARIO (
				   TELEFONO, ID_TIPO_TELEFONO, ID_USUARIO,ID_CREACION) 
				VALUES (:fono,:tipo_fono,:id_usuario,:id_creacion)";
		
		$par[":fono"] 		= array($fono,-1,SQLT_CHR);
		$par[":tipo_fono"] 	= array($tipo_fono,-1,SQLT_INT);
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
		$par[":id_creacion"] = array($id_creacion,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertEmail($email,$tipo_correo,$id_usuario,$id_creacion){
		$par = array();
		
		$sql = "INSERT INTO organizacion.ORG_CORREO_USUARIO (
			   		CORREO,ID_TIPO_CORREO_USUARIO,ID_USUARIO,ID_CREACION) 
				VALUES (lower(:email),:tipo_correo,:id_usuario,:id_creacion)";
		
		$par[":email"] 		 = array($email,-1,SQLT_CHR);
		$par[":tipo_correo"] = array($tipo_correo,-1,SQLT_INT);
		$par[":id_usuario"]  = array($id_usuario,-1,SQLT_INT);
		$par[":id_creacion"] = array($id_creacion,-1,SQLT_INT);
	return self::upsert($sql,$par);
	}

	public function insertLogin($id_usuario,$login,$pass){
		$par = array();

		$sql = "INSERT INTO organizacion.ORG_REGISTRO(ID_USUARIO,LOGIN,PASSWD,FECHA_CREACION) 
												   VALUES (:id_usuario,lower(:login),:pass,sysdate)";

		/* no inserto el campo FECHA_CADUCIDAD porque al momento de crear el usuario
		 * se obliga a cambiar la contrase�a la primer vez, la logica seria asi: si la contrase�a
		 * de caducidad viene vacia el usuario deber� cambiarla cuando ingrese a la web con la contrase�a
		 * que se genero automaticamentte*/
		
		$par[":id_usuario"] = array($id_usuario,-1,SQLT_CHR);
		$par[":login"]   	= array($login,-1,SQLT_CHR);
		$par[":pass"]		= array($pass,-1,SQLT_CHR);
	return self::upsert($sql,$par);
	}

	public function insertDireccion($direccion,$num_direc,$num_dpto,$tipo_direc,$local_direc,$id_usuario,$id_creacion){
		$par  = array();
		
		$sql = "INSERT INTO organizacion.ORG_DIRECCION_USUARIO (
				   DIRECCION,NUMERO,ID_TIPO_DIRECCION,
				   CODI_LOCALIDAD,ID_USUARIO,DEPTO,ID_CREACION) 
				VALUES (:direccion,:num_direc,:tipo_direc,
				    	:local_direc,:id_usuario,:num_dpto,:id_creacion)";

		$par[":direccion"]   = array($direccion,-1,SQLT_CHR);
		$par[":num_direc"]   = array($num_direc,-1,SQLT_INT);
		$par[":tipo_direc"]  = array($tipo_direc,-1,SQLT_INT);
		$par[":local_direc"] = array($local_direc,-1,SQLT_CHR);
		$par[":id_usuario"]  = array($id_usuario,-1,SQLT_INT);
		$par[":num_dpto"]  	 = array($num_dpto,-1,SQLT_CHR);
		$par[":id_creacion"] = array($id_creacion,-1,SQLT_INT);

	return self::upsert($sql,$par);
	}
	
	public function selectIdusuario(){
		$sql = "select max(id_usuario) from organizacion.new_org_usuario";
	return self::consultaNum($sql);
	}
	
	public function validarRut($rut){
		$par = array();
		
		$sql = "select count(rut) 
					from organizacion.new_org_usuario usr
					where 
					lpad(REPLACE(REPLACE (UPPER (usr.rut), '.', ''),'-',''),12,'0') = lpad(REPLACE (REPLACE (UPPER (:RUT), '.', ''),'-',''),12,'0')
					and USR.ID_ESTADO = 1";
		
		$par[":rut"]  = array($rut,-1,SQLT_CHR);
	return self::consultaNum($sql,$par);	
	}
	
	public function insertUsuario($rut,$nombre,$apellido,$fe_in_vtr,$pass_us,$sexo,$empresa,$cod_tec,$nivl_apr,$perfil,$jefe_us,$cargo,$area_fun,$fecha_n,$path_f,$id_crea,$estado_us,$tipo_us,$direccion){
		
		$par = array();
		
		$sql = "INSERT INTO organizacion.new_ORG_USUARIO (
				   RUT, NOMBRES, APELLIDOS, 
				   FECHA_INGRESO, SEXO, EMPRESA, 
				   CODIGO_TECNICO, ID_NIVEL_APSI,ID_PERFIL, 
				   ID_JEFE, ID_CARGO, ID_AREAFUN, 
				   FECHA_NACIMIENTO,PATHFOTO,ID_CREADOR, 
				   ID_ESTADO, ID_TIPO_USUARIO,ID_DIRECCION) 
				VALUES (lower(:rut),INITCAP(:nombre),INITCAP(:apellido),
				    	to_date(:fe_in_vtr,'dd/mm/yyyy'), :sexo, :empresa,
				   		:cod_tec,:nivl_apr,:perfil,
				    	:jefe_us, :cargo, :area_fun,
				    	to_date(:fecha_n,'dd/mm/yyyy'),:path_f,:id_crea,
				    	:estado_us , :tipo_us,:direccion)";

		 $par[":rut"] 		 = array($rut,-1,SQLT_CHR);
		 $par[":nombre"] 	 = array($nombre,-1,SQLT_CHR);
		 $par[":apellido"] 	 = array($apellido,-1,SQLT_CHR);
		 $par[":fe_in_vtr"]  = array($fe_in_vtr,-1,SQLT_CHR);
		 $par[":sexo"] 	 	 = array($sexo,-1,SQLT_CHR);
		 $par[":empresa"] 	 = array($empresa,-1,SQLT_CHR);
		 $par[":cod_tec"] 	 = array($cod_tec,-1,SQLT_CHR);
		 $par[":nivl_apr"] 	 = array($nivl_apr,-1,SQLT_INT);
		 $par[":perfil"] 	 = array($perfil,-1,SQLT_INT);
		 $par[":jefe_us"] 	 = array($jefe_us,-1,SQLT_INT);
		 $par[":cargo"] 	 = array($cargo,-1,SQLT_INT);
		 $par[":area_fun"] 	 = array($area_fun,-1,SQLT_INT);
		 $par[":fecha_n"] 	 = array($fecha_n,-1,SQLT_CHR);
		 $par[":path_f"] 	 = array($path_f,-1,SQLT_CHR);
		 $par[":id_crea"] 	 = array($id_crea,-1,SQLT_INT);
		 $par[":estado_us"]  = array($estado_us,-1,SQLT_INT);
		 $par[":tipo_us"] 	 = array($tipo_us,-1,SQLT_INT);
		 $par[":direccion"]  = array($direccion,-1,SQLT_INT);  
	
	return self::upsert($sql,$par);
	}
	
	public function selectEstado(){
		$sql = "select id_estado, estado from organizacion.org_estado_usuario
				order by estado asc";
	return self::consulta($sql);
	}
	
	public function selecResponsableArea(){
		$sql = "select id_usuario,nombres||' '||apellidos nombres from organizacion.new_org_usuario
				where id_tipo_usuario = 1 and id_estado = 1
				order by nombres asc";
	return self::consulta($sql);	
	}
	
	public function selectJefes(){
//		$sql = "select id_usuario,initcap(nombres||' '||apellidos) nombres from organizacion.new_org_usuario
//                where id_cargo in(8792,8793,8794,8797,8795,9) or 
//                id_cargo in (select cr2.id_cargo from ORGANIZACION.NEW_ORG_CARGO  cr2 where cr2.id_tipo_cargo = 16527)
//                order by nombres asc";
		
		$sql="select id_usuario,initcap(nombres||' '||apellidos) nombres, CA.NOMBRE 
                from organizacion.new_org_usuario usr
                join organizacion.new_org_cargo ca on CA.ID_CARGO=USR.ID_CARGO
                where 
                usr.id_usuario = 1 and
                ca.id_cargo in(8792,8793,8794,8797,8795,9,21760) or 
                ca.id_cargo in 
                    (select cr2.id_cargo 
                    from ORGANIZACION.NEW_ORG_CARGO  cr2 
                    where cr2.id_tipo_cargo in (152, 153,130,2,3,4) )
                 and usr.id_estado = 1
                order by nombres asc";
	return self::consulta($sql);	 
	}
	
	public function selectLocalidad($cod_zona = ""){
		$par = array();
		
		if($cod_zona != ""){
			$where = "where codi_zona = :codi_zona";	
		$par[":codi_zona"] 	= array($cod_zona,-1,SQLT_CHR);
		}

		$sql = "select codi_localidad,desc_localidad from organizacion.ORG_LOCALIDAD
				$where
				order by desc_localidad asc";
	return self::consulta($sql,$par);
	}

	public function selectNivelApSi(){
		$sql = "select id_nivel_apsi,desc_nivel_apsi from organizacion.ORG_NIVEL_APSI";
	return self::consulta($sql);
	}

	public function selectDireccionLaboral(){
		$sql = "select id_direccion, descripcion from organizacion.new_org_direccion
				order by descripcion asc";
	return self::consulta($sql);
	}

	public function selectPerfilGrilla($id_perfil = ""){
		$par = array();
		
		if($id_perfil != ""){
			$where = "where id_perfil = :id_perfil";
		$par[":id_perfil"] 	= array($id_perfil,-1,SQLT_INT);
		}else{
			$where = "";
		}
		
		$sql = "select id_perfil,nombre,DESC_PERFIL,PAGINA_INICIO,DURACION_CONEXION 
				from organizacion.ORG_PERFIL
				$where	
				order by nombre asc";
	return self::consultaNum($sql,$par);
	}
	
	public function selectPerfil(){
		$sql = "select id_perfil,nombre from organizacion.ORG_PERFIL
				order by nombre asc";
	return self::consulta($sql);
	}

	public function selectEmpresa($id_tipo_usuario = ""){
		$par = array();
	
		if($id_tipo_usuario != ""){
			$where = " and id_tipo_usuario = :id_tipo_usuario ";
		$par[":id_tipo_usuario"] 	= array($id_tipo_usuario,-1,SQLT_INT);
		}else{
			$where = "";
		}
		
		$sql = "select rut_empresa,initcap(razon_social) razon_social from organizacion.new_org_empresa
				where nvl(id_estado,1) = 1
				$where
				order by razon_social";

	return self::consulta($sql,$par);
	}

	public function selectInternoNoi($id_tipo_usuario = ""){
		$par = array();
		
		if($id_tipo_usuario != ""){
			$where = "where id_tipo_usuario = :id_tipo_usuario";
		$par[":id_tipo_usuario"] 	= array($id_tipo_usuario,-1,SQLT_INT);
		}
		
		 $sql = "select id_tipo_usuario,nombre from organizacion.ORG_TIPO_USUARIO
		 		 $where
		 		 order by nombre asc";
		 
	return self::consulta($sql,$par);
	}

	public function selectAreaFun(){
		 $sql = "select id_areafun,nombre from organizacion.new_ORG_AREAFUN
		 		 order by nombre asc";
	return self::consulta($sql);
	}

	public function selectCargo(){
		 $sql = "select id_cargo,nombre from organizacion.new_ORG_CARGO
		 		where id_estado = 1
		 		order by nombre asc";
	return self::consulta($sql);
	}

	public function selectTipoCorreo($id_tipo = ""){
		$par = array();
		
		if($id_tipo != ""){
			$where  = "where id_tipo_correo_usuario = :id_tipo_correo_usuario";
		$par[":id_tipo_correo_usuario"] = array($id_tipo,-1,SQLT_INT);
		}
		
		$sql = "select id_tipo_correo_usuario,descripcion from organizacion.ORG_TIPO_CORREO_USUARIO
				$where
				order by descripcion asc";
	return self::consulta($sql,$par);
	}

	public function selectCiudad(){
		$sql = "select codi_ciudad,desc_localidad from organizacion.ORG_LOCALIDAD
				where codi_localidad = codi_ciudad
				order by desc_localidad asc";
	return self::consulta($sql);
	}

	public function selectTipoTelefono($id_tipo = ""){
		$par = array();
		
		if($id_tipo != ""){
			$where  = "where id_tipo_telefono = :id_tipo_telefono";
		$par[":id_tipo_telefono"] = array($id_tipo,-1,SQLT_INT);
		}
		
		$sql = "select id_tipo_telefono,descripcion_telefono from organizacion.ORG_TIPO_TELEFONO
				$where
				order by descripcion_telefono asc";
	return self::consulta($sql,$par);
	}

	public function selectTipoDireccion($id_direccion = ""){
		$par = array();

		if($id_direccion != ""){
			$where = "where ID_TIPO_DIRECCION_USUARIO = :ID_TIPO_DIRECCION_USUARIO";
		$par[":ID_TIPO_DIRECCION_USUARIO"] = array($id_direccion,-1,SQLT_INT);	
		}
		
		$sql = "select ID_TIPO_DIRECCION_USUARIO, NOMBRE from organizacion.ORG_TIPO_DIRECCION_USUARIO
				$where
				order by nombre asc";
	return self::consulta($sql,$par);
	}

	public function validaLogin($login){
		$par = array();
		
		 $sql = "select count(login) from organizacion.ORG_REGISTRO
				 where login = :login";
		 
		 $par[":login"] 	 = array($login,-1,SQLT_CHR);
	return self::consultaNum($sql,$par);
	}
}