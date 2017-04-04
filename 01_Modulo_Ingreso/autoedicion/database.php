	<?php
include_once($_SERVER['DOCUMENT_ROOT']."/_class/DBConneccion.class.php");

class todoDB extends DBConneccion {
	
	public function selectDatosUsuario($id_usuario){
		$par = array();

		$sql = "SELECT a.pathfoto,a.nombres||' '||a.apellidos nombre,d.NOMBRE,e.nombre as perfil,
				       c.nombre cargo,b.razon_social,f.DESC_ZONA zona,
				       g.DESCRIPCION,H.DESC_LOCALIDAD ciudad,i.nombres||' '||i.apellidos as jefe,
				       h.desc_localidad comuna,a.PASSWD
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
	
	public function direccionUsuario($id_usuario){
		$par = array();
		
		$sql = "select a.id_direccion_usuario, a.direccion, a.numero,
				       a.depto,a.codi_localidad,a.id_usuario,
				       b.nombre,
				       a.id_tipo_direccion
				     from organizacion.org_direccion_usuario a
				left join organizacion.ORG_TIPO_DIRECCION_USUARIO b on(a.id_tipo_direccion = b.id_tipo_direccion_usuario)
				where id_usuario = :id_usuario
				order by a.id_direccion_usuario asc";

		$par[":id_usuario"] = array($id_usuario,-1,SQLT_INT);
	return self::consultaNum($sql,$par);
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
	
	public function updateFoto($id_usuario,$pathFoto){
		$par = array();

		$sql = "update organizacion.new_org_usuario	
				set PATHFOTO = :PATHFOTO
				where ID_USUARIO = :ID_USUARIO";
		
		$par[":PATHFOTO"] 	= array($pathFoto,-1,SQLT_CHR);
		$par[":ID_USUARIO"] = array($id_usuario,-1,SQLT_INT);
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
	public function checkPassAntigua($pass,$usrId){
		$par = array();
		
		$sql = "select RG.PASSWD
				from organizacion.new_org_usuario usr
				left join ORGANIZACION.ORG_REGISTRO rg on USR.ID_USUARIO = RG.ID_USUARIO
				where USR.ID_USUARIO = :id_usuario";
		
		$par[":id_usuario"] = array($usrId,-1,SQLT_INT);
		
		$arr = self::consulta($sql,$par);
		if($arr['PASSWD'][0]==$pass)
			return FALSE;
		elseif ($arr['PASSWD'][0]!=$pass)
			return TRUE;
		
	}
	public function checkPassLogin($pass,$usrId){
		$par = array();
		
		$sql = "select RG.LOGIN
				from organizacion.new_org_usuario usr
				left join ORGANIZACION.ORG_REGISTRO rg on USR.ID_USUARIO = RG.ID_USUARIO
				where USR.ID_USUARIO = :id_usuario";
		
		$par[":id_usuario"] = array($usrId,-1,SQLT_INT);
		
		$arr=self::consulta($sql,$par);
		
		if(md5($arr['LOGIN'][0])==$pass)
			return FALSE;
		elseif (md5($arr['LOGIN'][0])!=$pass)
			return TRUE;
	}
	
}
