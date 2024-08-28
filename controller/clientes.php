<?php
session_start();
require_once "../model/clientes.php";

$cliente=new Cliente();

$idCliente=isset($_POST["idCliente"])? limpiarCadena($_POST["idCliente"]):"";
$Nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$Apellido=isset($_POST["Apellido"])? limpiarCadena($_POST["Apellido"]):"";
$Telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$Email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$Direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idCliente)){
			$rspta=$cliente->insertar($Nombre,$Apellido,$Telefono,$Email,$Direccion);
			echo $rspta ? 1 : 2 ;
		}
		else {
			$rspta=$cliente->editar($idCliente,$Nombre,$Apellido,$Telefono,$Email,$Direccion);
			echo $rspta ? 3 : 4;
		}
	break;


	case 'mostrar':
		$rspta=$cliente->mostrar($idCliente);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cliente->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idCliente.')"><i class="fas fa-edit"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->idCliente.')"><i class="far fa-times-circle"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->idCliente.')"><i class="fas fa-edit"></i></button>'.
                ' <button class="btn btn-primary" onclick="activar('.$reg->idCliente.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->Nombre,
 				"2"=>$reg->Apellido,
				"3"=>$reg->Telefono,
 				"4"=>$reg->Correo,
				"5"=>$reg->Direccion,
 				"6"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>
