<?php
require_once "../model/Servicio.php";

$vehiculo = new Servicio();

switch ($_GET["op"]) {

	case 'servicio':
		$rspta = $vehiculo->update($_GET['id']);
		echo json_encode($rspta);

		break;
}
