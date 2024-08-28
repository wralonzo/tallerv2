<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Servicio
{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}


	//Implementar un método para listar los registros
	public function update($idServicio)
	{
		$sql = "UPDATE servicio SET  facturado = 1 WHERE idServicio = '$idServicio';";
		return ejecutarConsulta($sql);
	}
}
