<?php

session_start();

require("../config/Conexion.php");

if (isset($_POST['updatedata'])) {
  $id = $_POST['update_id'];
  $Anticipo = $_POST['anticipo'];
  $Total = $_POST['total'];
  $Abonar = $_POST['abonar'];

  $sql = "UPDATE servicio SET Anticipo='$Anticipo', Total='$Total' WHERE idServicio = '$id'";
  $query_run = mysqli_query($conexion, $sql);

  var_dump($sql);

  if ($query_run) {
    echo '<script type="text/javascript">alert("Elemento actualizado");</script>';
    header("location: servicios.php");
  } else {
    echo '<script> alert("Data Not Updated"); </script>';
  }
}
