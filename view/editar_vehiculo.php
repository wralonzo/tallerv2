<?php

session_start();

require("../config/Conexion.php");

if(isset($_POST['updatedata'])) {


  $id = $_POST['update_id'];
  $Nombre = $_POST['nombre'];
  $Placa = $_POST['placa'];

  $Marca = $_POST['marca'];
  $Tipo = $_POST['tipo'];
  $Color = $_POST['color'];
    $fecha = $_POST['fecha'];
    $fecha2 = $_POST['fecha2'];


  $sql="UPDATE vehiculo SET Placa='$Placa', Marca='$Marca', tipoVehiculo='$Tipo',
   Color='$Color', fecha = '$fecha', fecha2 = '$fecha2' where idVehiculo = '$id' ";
$query_run = mysqli_query($conexion, $sql);


  if($query_run)
   {
     $to = "Actualizado";
  echo '<script type="text/javascript">alert("Data has been submitted to ' . $to . '");</script>';
    header("location: vehiculos.php");
  }
else
{
  echo '<script> alert("Data Not Updated"); </script>';
}


}



 ?>
