<?php
session_start();

require("../conexion.php");

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM servicio WHERE idServicio = $id");
    mysqli_close($conexion);
    header("Location: servicios.php");
}
