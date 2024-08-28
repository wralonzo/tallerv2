<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cliente
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($Nombre,$Apellido,$Telefono,$Email,$Direccion)
	{
		$sql="INSERT INTO cliente(Nombre,Apellido,Telefono,correo,Direccion)
		VALUES ('$Nombre','$Apellido','$Telefono','$Correo','$Direccion')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$Nombre,$Apellido,$Telefono,$Email,$Direccion)
	{
		$sql="UPDATE cliente SET Nombre='$Nombre', Apellido='$Apellido', Telefono='$Telefono', correo='$Email', Direccion='$Direccion' WHERE idCliente='$id' ";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT * FROM cliente WHERE idCliente='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM cliente";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM cliente where condicion=1";
		return ejecutarConsulta($sql);
	}
	}
?>
