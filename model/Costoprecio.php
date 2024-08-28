<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Vehiculo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function listar($idCliente)
	{
		$sql="SELECT * FROM costo WHERE idNombre = '$idCliente';";
		return ejecutarConsulta($sql);		
	}

}

?>