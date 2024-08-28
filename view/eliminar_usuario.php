<?php
session_start();

require("../conexion.php");

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query_delete = mysqli_query($conexion, "DELETE FROM cliente WHERE idCliente = $id");
    mysqli_close($conexion);
    header("Location: clientes.php");
}
