<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();



include "../config/Conexion.php";

if (!empty($_POST)) {

    $id = $_POST['id'];
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Telefono = $_POST['Telefono'];
    $Correo = $_POST['Correo'];
    $Direccion = $_POST['Direccion'];
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
          }else {
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
            }else{
              $query_insert = mysqli_query($conexion, "INSERT INTO cliente(Nombre,Apellido,Telefono,correo,Direccion) values ('$Nombre', '$Apellido', '$Telefono', '$Correo','Direccion')");
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
              }else {
            $sql_update = mysqli_query($conexion, "UPDATE cliente SET Nombre = '$Nombre', Apellido = '$Apellido', Telefono='$Telefono', correo = '$Correo', Direccion = '$Direccion' WHERE idCliente = $id");
            if ($sql_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Usuario Modificado
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error al modificar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
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

if ($_SESSION['clientes']==1)
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" class="form-control" placeholder="Ingrese Nombre" name="Nombre" id="nombre">
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Apellido">Apellido</label>
                                <input type="text" class="form-control" placeholder="Ingrese Apellido" name="Apellido" id="apellido">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Telefono">Telefono</label>
                                <input type="number" class="form-control" placeholder="Ingrese Telefono" name="Telefono" id="Telefono">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Correo">Correo</label>
                                <input type="email" class="form-control" placeholder="Ingrese Correo" name="Correo" id="Correo">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Direccion">Direccion</label>
                                <input type="text" class="form-control" placeholder="Ingrese Direccion" name="Direccion" id="Direccion">
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                    <input type="button" value="Nuevo" class="btn btn-success" id="btnNuevo" onclick="limpiar()">
                </form>
            </div>
        </div>
          <div class="panel-body" style="height: 400px;" id="formularioregistros">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mt-2" id="tbl">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Direccion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php include "../conexion.php";
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
                                <td>
                                  <form action="editar_usuario.php?id=<?php echo $data['idCliente']; ?>" method="post" class="confirmar d-inline">
                                      <button class="btn btn-success" type="submit"><i class='fas fa-edit'></i> </button>
                                  </form>
                                    <a href="#" onclick="editarCliente(<?php echo $data['idCliente']; ?>)" class="btn btn-success"><i class='fas fa-edit'></i></a>
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
<script type="text/javascript" src="scripts/clientes.js"></script>
<?php
}
ob_end_flush();
?>
