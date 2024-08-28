<?php 
require_once "../model/Vehiculo.php";

$vehiculo=new Vehiculo();

switch ($_GET["op"]){
	case 'client':
		$rspta = $vehiculo->listarPlacas($_GET['id']);
		$result = array();
		while ($row = $rspta->fetch_object()) {
			$result[] = $row;
		}
		echo json_encode($result);

	break;
}
?>