<?php

session_start();

require("../conexion.php");

if(isset($_POST['updatedata'])) {


  $id = $_POST['update_id'];
  $Detalle = $_POST['detalle'];
  $Precio = $_POST['precio'];

  $Costo = $_POST['costo'];
  $fecha = $_POST['fecha'];

$sql="UPDATE costo SET Detalle='$Detalle', Precio='$Precio', fecha='$fecha' where idCosto = '$id' ";
$query_run = mysqli_query($conexion, $sql);


  if($query_run)
   {
     $to = "Actualizado";
  echo '<script type="text/javascript">alert("Data has been submitted to ' . $to . '");</script>';
    header("location: informatica.php");
  }
else
{
  echo '<script> alert("Data Not Updated"); </script>';
}


}



 ?>
