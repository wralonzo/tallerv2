<?php
session_start();

require("../config/Conexion.php");

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM vehiculo WHERE idVehiculo = $id");
    mysqli_close($conexion);
    header("Location: vehiculos.php");
}
