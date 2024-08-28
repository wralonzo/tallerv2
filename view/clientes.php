<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();



include "../config/Conexion.php";

if (!empty($_POST)) {


  $Nombre = $_POST['Nombre'];
  $Apellido = $_POST['Apellido'];
  $Telefono = $_POST['Telefono'];
  $Correo = $_POST['Correo'];
  $Direccion = $_POST['Direccion'];
  $fecha = $_POST['fecha'];

  $alert = "";
  if (empty($Nombre) || empty($Apellido) || empty($Telefono) || empty($Correo) || empty($Direccion)) {
    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todo los campos son obligatorio
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
  } else {
    if (empty($id)) {
      $Correo = $_POST['Correo'];
      if (empty($Correo)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  Correo es requerido
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
      } else {
        $Correo = $_POST['Correo'];
        $query = mysqli_query($conexion, "SELECT * FROM cliente where correo = '$Correo'");
        $result = mysqli_fetch_array($query);
        if ($result > 0) {
          $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  El correo ya existe
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
        } else {
          $query_insert = mysqli_query($conexion, "INSERT INTO cliente(Nombre,Apellido,Telefono,correo,Direccion,fecha) values ('$Nombre', '$Apellido', '$Telefono', '$Correo','$Direccion','$fecha')");
          if ($query_insert) {
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Cliente Registrado
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

  if ($_SESSION['clientes'] == 1) {




?>

    <br>
    <br>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">
      <!-- row -->
      <div class="container-fluid">
        <h2>Clientes</h2>
        <div class="card-body">
          <form action="" method="post" autocomplete="off" id="formulario">
            <?php echo isset($alert) ? $alert : ''; ?>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="Nombre">Nombre</label>
                  <input type="text" class="form-control" placeholder="Ingrese Nombre" name="Nombre" id="Nombre">

                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="Apellido">Apellido</label>
                  <input type="text" class="form-control" placeholder="Ingrese Apellido" name="Apellido" id="Apellido">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="Telefono">Teléfono</label>
                  <input type="number" class="form-control" placeholder="Ingrese # de teléfono" name="Telefono" id="Telefono">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="Correo">E-mail</label>
                  <input type="email" class="form-control" placeholder="Ingrese E-mail" name="Correo" id="Correo">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="Direccion">Dirección</label>
                  <input type="text" class="form-control" placeholder="Ingrese Dirección" name="Direccion" id="Direccion">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha">Fecha registro</label>
                  <input type="date" class="form-control" placeholder="Ingrese fecha" name="fecha" id="fecha">
                </div>
              </div>
            </div>
            <input type="submit" value="Registrar" class="btn btn-success" id="btnAccion">
          </form>
        </div>
      </div>
      <div class="panel-body " style="height: 400px;" id="formularioregistros">
        <div class="table-responsive container-fluid">
          <table class="table table-hover table-striped table-bordered mt-2" id="example">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>TELEFONO</th>
                <th>E-MAIL</th>
                <th>DIRECCION</th>
                <th>FECHA RECEPCION</th>
                <th>ACCIONES</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $query = mysqli_query($conexion, "SELECT * FROM cliente");
              $result = mysqli_num_rows($query);
              if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) { ?>
                  <tr>

                    <td><?php echo $data['idCliente']; ?></td>
                    <td><?php echo $data['Nombre']; ?></td>
                    <td><?php echo $data['Apellido']; ?></td>
                    <td><?php echo $data['Telefono']; ?></td>
                    <td><?php echo $data['correo']; ?></td>
                    <td><?php echo $data['Direccion']; ?></td>
                    <td><?php echo $data['fecha']; ?></td>
                    <td>

                      <button type="submit" class="btn btn-warning editbtn" data-toggle="modal" data-target="#editar"><i class='fas fa-redo-alt'></i></button>


                      <form action="eliminar_usuario.php?id=<?php echo $data['idCliente']; ?>" method="post" class="confirmar d-inline">
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
            <h5 class="modal-title" id="exampleModalLabel">EDITAR CLIENTES</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="editar_usuario.php" method="post">
              <input type="hidden" name="update_id" id="update_id">
              <div class="form-group">
                <label for="">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
              </div>


              <div class="form-group">
                <label for="">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="">Telefono</label>
                <input type="number" name="telefono" id="telefono" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="">Correo</label>
                <input type="email" name="correo" id="correo" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="">Direccion</label>
                <input type="text" name="direccion" id="direccion" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="">fecha</label>
                <input type="text" name="fecha" id="fecha" class="form-control" required>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="updatedata" class="btn btn-primary">Guardar</button>



              </div>
            </form>




          </div>
        </div>
      </div>



    </div>

  <?php
  } else {
    require 'noacceso.php';
  }

  require 'template/footer.php';
  ?>
  <script type="text/javascript" src="scripts/clientes.js"></script>
<?php
}
ob_end_flush();
?>