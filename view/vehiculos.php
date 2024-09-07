<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();



include "../config/Conexion.php";



if (!empty($_POST)) {


  $Nombre = $_POST['Nombre'];
  $Placa = $_POST['Placa'];
  $Vin = $_POST['Vin'];
  $Marca = $_POST['Marca'];
  $tipoVehiculo = $_POST['tipoVehiculo'];
  $Color = $_POST['Color'];
  $fecha = $_POST['Fecha'];
  $fecha2 = $_POST['Fecha2'];
  $alert = "";
  if (empty($Nombre) || empty($Placa) || empty($Vin) || empty($Marca) || empty($tipoVehiculo) || empty($Color)) {
    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todo los campos son obligatorio
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
  } else {
    if (empty($id)) {
      $Placa = $_POST['Placa'];
      if (empty($Placa)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  PLACA es requerido
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
      } else {
        $Placa = $_POST['Placa'];
        $query = mysqli_query($conexion, "SELECT * FROM vehiculo where Placa = '$Placa'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
          $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  PLACA ya existe
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
        } else {
          $query_insert = mysqli_query($conexion, "INSERT INTO vehiculo(idCliente,Placa,Vin,Marca,
              tipoVehiculo,Color,fecha,fecha2) values ('$Nombre',
               '$Placa', '$Vin', '$Marca','$tipoVehiculo','$Color','$fecha','$fecha2')");
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

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'template/header.php';

  if ($_SESSION['vehiculos'] == 1) {

?>

    <br>
    <br>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">
      <div class="container-fluid">
        <div class="card">
          <h2>Vehículos</h2>
          <div class="card-body">
            <form action="" method="post" autocomplete="off" id="formulario">
              <?php echo isset($alert) ? $alert : ''; ?>
              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Nombre">Cliente</label>
                    <select class="form-control" placeholder="Seleccionar" name="Nombre" id="Nombre">
                      <option value="">Seleccione</option>
                      <?php

                      $sql = "SELECT * FROM cliente";
                      $query = mysqli_query($conexion, $sql);
                      while ($data = mysqli_fetch_assoc($query)) {
                        $id = $data['idCliente'];
                        $name = $data['Nombre'];
                        $apell = $data['Apellido'];
                      ?>
                        <option value="<?php echo $id; ?>"><?php echo $apell . ' ' . $name; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="Placa">No. de Placa</label>
                    <input type="text" class="form-control" placeholder="Ingrese placa vehículo" name="Placa" id="Placa">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="Marca">No. de Vin</label>
                    <input type="text" class="form-control" placeholder="Ingrese No. Vin" name="Vin" id="Vin">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="Marca">Marca Vehículo</label>
                    <input type="text" class="form-control" placeholder="Ingrese marca del vehículo" name="Marca" id="Marca">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="Tipo">Tipo Vehículo</label>
                    <input type="text" class="form-control" placeholder="Tipo de vehiculo" name="tipoVehiculo" id="tipoVehiculo">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="Color">Color Vehículo</label>
                    <input type="text" class="form-control" placeholder="Color del vehículo" name="Color" id="Color">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="Fecha">Fecha Ingreso</label>
                    <input type="date" class="form-control" placeholder="Fecha" name="Fecha" id="Fecha">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="Fecha">Fecha Salida</label>
                    <input type="date" class="form-control" placeholder="Fecha2" name="Fecha2" id="Fecha2">
                  </div>
                </div>
              </div>
              <input type="submit" value="Registrar" class="btn btn-success" id="btnAccion">
            </form>
          </div>
        </div>
        <div class="panel-body" style="height: 400px;" id="formularioregistros">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mt-2" id="example">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>CLIENTE</th>
                  <th>PLACA</th>
                  <th>VIN</th>
                  <th>MARCA</th>
                  <th>TIPO</th>
                  <th>COLOR</th>
                  <th>FECHA INGRESO</th>
                  <th>FECHA SALIDA</th>
                  <th>ACCIONES</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($conexion, "SELECT p.idVehiculo, pr.Nombre, pr.Apellido, p.Placa, 
                    p.Vin, p.Marca, p.tipoVehiculo, p.Color,p.fecha ,p.fecha2 FROM
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
                      <td><?php echo $data['idVehiculo']; ?></td>
                      <td><?php echo $data['Nombre']; ?> <?php echo $data['Apellido']; ?></td>
                      <td><?php echo $data['Placa']; ?></td>
                      <td><?php echo $data['Vin']; ?></td>
                      <td><?php echo $data['Marca']; ?></td>
                      <td><?php echo $data['tipoVehiculo']; ?></td>
                      <td><?php echo $data['Color']; ?></td>
                      <td><?php echo $data['fecha']; ?></td>
                      <td><?php echo $data['fecha2']; ?></td>
                      <td>

                        <button type="submit" class="btn btn-warning editbtn" data-bs-toggle="modal" data-bs-target="#editar"><i class='fas fa-redo-alt'></i></button>


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
    </div>



    <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">EDITAR VEHICULO</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="editar_vehiculo.php" method="post">
              <input type="hidden" name="update_id" id="update_id">

              <div class="form-group">
                <label for="">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" disabled>
              </div>


              <div class="form-group">
                <label for="">No de Placa</label>
                <input type="text" name="placa" id="placa" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="">No de VIN</label>
                <input type="text" name="vin" id="vin" class="form-control" required>
              </div>


              <div class="form-group">
                <label for="">Marca vehículo</label>
                <input type="text" name="marca" id="marca" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="">Tipo vehículo</label>
                <input type="text" name="tipo" id="tipo" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="">Color vehículo</label>
                <input type="text" name="color" id="color" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="">Fecha Ingreso</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="">Fecha Salisa</label>
                <input type="date" name="fecha2" id="fecha2" class="form-control" required>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="updatedata" class="btn btn-primary">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

  <?php
  } else {
    require 'noacceso.php';
  }

  require 'template/footer.php';
  ?>
  <script type="text/javascript" src="scripts/vehiculo.js"></script>
<?php
}
ob_end_flush();
?>