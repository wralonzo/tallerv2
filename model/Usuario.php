<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}

	private function ejecutarConsulta($sql, $params)
	{
		global $conexion;
		$stmt = $conexion->prepare($sql);
		$stmt->bind_param(...$params);
		$stmt->execute();
		return array('stmt' => $stmt, 'last_id' => $conexion->insert_id);
	}

	//Implementamos un método para insertar registros
	public function insertar($nombre, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
	{
		$sql = "INSERT INTO usuario (nombre,telefono,email,cargo,login,clave,imagen,condicion)
    VALUES (?, ?, ?, ?, ?, ?, ?, '1')";
		$params = array('sssssss', $nombre, $telefono, $email, $cargo, $login, $clave, $imagen);
		$result = $this->ejecutarConsulta($sql, $params);
		$idusuarionew = $result['last_id'];

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($permisos)) {
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES(?, ?)";
			$params = array('ii', $idusuarionew, $permisos[$num_elementos]);
			$result = $this->ejecutarConsulta($sql_detalle, $params);
			if ($result['stmt']->affected_rows == 0) {
				$sw = false;
				break;
			}
			$num_elementos = $num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario, $nombre, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
	{
		$sql = "UPDATE usuario SET nombre='$nombre',telefono='$telefono',email='$email',cargo='$cargo',login='$login',clave='$clave',imagen='$imagen' WHERE idusuario='$idusuario'";
		ejecutarConsulta($sql);

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel = "DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($permisos)) {
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuario', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos = $num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql = "UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql = "UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql = "SELECT * FROM usuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql = "SELECT * FROM usuario";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql = "SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Función para verificar el acceso al sistema
	public function verificar($login, $clave)
	{
		$sql = "SELECT u.idusuario,u.nombre,u.telefono,u.email,u.cargo,u.imagen,u.login, u.clave FROM usuario u
		WHERE u.login='$login' AND u.clave='$clave' AND u.condicion='1'";
		return ejecutarConsulta($sql);
	}

	public function select()
	{
		$sql = "SELECT idusuario, concat(nombre,' ',cargo) as nombres  FROM usuario where condicion=1;";
		return ejecutarConsulta($sql);
	}
}
