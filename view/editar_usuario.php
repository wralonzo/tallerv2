<?php

session_start();

require("../conexion.php");

if(isset($_POST['updatedata'])) {


  $id = $_POST['update_id'];
  $Nombre = $_POST['nombre'];
  $Apellido = $_POST['apellido'];
  $Telefono = $_POST['telefono'];
  $Correo = $_POST['correo'];
  $Direccion = $_POST['direccion'];

  $sql="UPDATE cliente SET Nombre='$Nombre', Apellido='$Apellido', Telefono='$Telefono', correo='$Correo', Direccion='$Direccion' where idCliente = '$id' ";
$query_run = mysqli_query($conexion, $sql);


  if($query_run)
   {
     $to = "Actualizado";
  echo '<script type="text/javascript">alert("Data has been submitted to ' . $to . '");</script>';
    header("location: clientes.php");
  }
else
{
  echo '<script> alert("Data Not Updated"); </script>';
}


}



 ?>
