<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();



include "../conexion.php";



if (!empty($_POST)) {


    $Nombre = $_POST['Nombre'];
    $Detalle = $_POST['Detalle'];
    $Precio =$_POST['Precio'];
    $alert = "";
    if (empty($Nombre) || empty($Detalle)  || empty($Precio)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todo los campos son obligatorio
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    } else {
      if (empty($id)) {
          $Detalle = $_POST['Detalle'];
          if (empty($Detalle)) {
              $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  PLACA es requerido
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
          }else {
              $Detalle = $_POST['Detalle'];
              $query = mysqli_query($conexion, "SELECT * FROM costo where Detalle = '$Detalle'");
              $result = mysqli_fetch_array($query);
              if ($result > 0) {
                  $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  PLACA ya existe
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
            }else{
              $query_insert = mysqli_query($conexion, "INSERT INTO costo(idcategoria,Detalle,Precio) values ('$Nombre','$Detalle','$Precio')");
                    if ($query_insert) {
                        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Vehiculo Registrado
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
                    }
                  }
                }
              }
            }
          }







if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'template/header.php';

if ($_SESSION['vehiculos']==1)
{




?>

<br>
<br>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <div class="card">
            <div class="card-body">
                <form action="" method="post" autocomplete="off" id="formulario">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="row">

                      <div class="col-md-4">
                        <div class="form-group">
                        <label for="Nombre">Categoria</label>
                            <select class="form-control" placeholder="Seleccionar" name="Nombre" id="Nombre">
                            <?php

                            $sql = "SELECT * FROM costo";
                            $query = mysqli_query($conexion,$sql);
                            while ($data = mysqli_fetch_assoc($query))
                            {
                              $id = $data['idcategoria'];
                              $name = $data['Detalle'];
                              $apell = $data['Precio'];
                            ?>
                        <option value="<?php echo $id; ?>"><?php echo $apell.' '.$name; ?></option>
                            <?php
                             }
                            ?>
                            </select>
                            </div>
                      </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Placa">N.PLACA</label>
                                <input type="text" class="form-control" placeholder="Ingrese PLACA" name="Placa" id="Placa">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Marca">Vin</label>
                                <input type="text" class="form-control" placeholder="Ingrese Vin" name="Vin" id="Vin">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Marca">MARCA</label>
                                <input type="text" class="form-control" placeholder="Ingrese Correo" name="Marca" id="Marca">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Tipo">Tipo Vehiculo</label>
                                <input type="text" class="form-control" placeholder="Vehiculo" name="tipoVehiculo" id="tipoVehiculo">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Color">Color</label>
                                <input type="text" class="form-control" placeholder="Color" name="Color" id="Color">
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                </form>
            </div>
        </div>
          <div class="panel-body" style="height: 400px;" id="formularioregistros">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mt-2" id="tbl">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>PLACA</th>
                        <th>VIN</th>
                        <th>MARCA</th>
                        <th>TIPO</th>
                        <th>COLOR</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query= mysqli_query($conexion,"SELECT p.idVehiculo, pr.Nombre, p.Placa, p.Vin, p.Marca, p.tipoVehiculo, p.Color FROM
                      vehiculo p
                      INNER JOIN
                      cliente pr
                      ON
                      p.idCliente = pr.idCliente

                       ");


                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) { ?>
                            <tr>
                                <td ><?php echo $data['idVehiculo']; ?></td>
                                <td ><?php echo $data['Nombre']?></td>
                                <td ><?php echo $data['Placa']; ?></td>
                                <td ><?php echo $data['Vin']; ?></td>
                                <td ><?php echo $data['Marca']; ?></td>
                                <td ><?php echo $data['tipoVehiculo']; ?></td>
                                <td ><?php echo $data['Color']; ?></td>
                                <td>

                                      <button type="submit" class="btn btn-success editbtn" data-toggle="modal" data-target="#editar"><i class='fas fa-redo-alt'></i></button>


                                    <form action="eliminar_vehiculo.php?id=<?php echo $data['idVehiculo']; ?>" method="post" class="confirmar d-inline">
                                        <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                    </form>
                                </td>
                            </tr>
                    <?php }

                    } ?>

                </tbody>
            </table>
        </div>
</div>

      </div>
      <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">EDITAR VEHICULO</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="editar_vehiculo.php" method="post">
                <input type="hidden" name="update_id" id="update_id" >

                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" disabled>
                </div>


                <div class="form-group">
                  <label for="">Tipo</label>
                  <input type="text" name="tipo" id="tipo" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="">Precio</label>
                  <input type="text" name="Precio" id="Precio" class="form-control" required>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" name="updatedata"    class="btn btn-primary">Guardar</button>



                </div>
              </form>




</div>
</div>
</div>



    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
}
else
{
  require 'noacceso.php';
}

require 'template/footer.php';
?>
<script type="text/javascript" src="scripts/costo.js"></script>
<?php
}
ob_end_flush();
?>
