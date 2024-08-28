<?php 
require_once "../model/Costo.php";

$vehiculo=new Vehiculo();

switch ($_GET["op"]){
	
	case 'client':
		$rspta = $vehiculo->listar($_GET['id']);
		$result = array();
		while ($row = $rspta->fetch_object()) {
			$result[] = $row;
		}
		echo json_encode($result);

	break;
}
?>