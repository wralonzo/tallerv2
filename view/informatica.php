<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();



include "../conexion.php";

if (!empty($_POST)) {

    $Nombre = $_POST['Nombre'];
    $Detalle = $_POST['Detalle'];
    $Precio = $_POST['Precio'];
    $fecha = $_POST['fecha'];


    $alert = "";
    if (empty($Detalle) || empty($Precio) ) {
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
                  Detalle es requerido
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
                   Detalle ya existe
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
            }else{
              $query_insert = mysqli_query($conexion, "INSERT INTO costo(idNombre,Detalle,Precio,fecha) values ('$Nombre','$Detalle', '$Precio','$fecha')");
                    if ($query_insert) {
                        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Datos Registrados
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

if ($_SESSION['informatica']==1)
{




?>

<br>
<br>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <div class="card">
            <h2>Costos</h2>
            <div class="card-body">
                <form action="" method="post" autocomplete="off" id="formulario">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="row">

                      <div class="col-md-3">
                      <div class="form-group">
                      <label for="Nombre">Categoría</label>
                          <select class="form-control" placeholder="Seleccionar" name="Nombre" id="Nombre" required>
                            <option value="">Seleccione</option>
                          <?php

                          $sql = "SELECT * FROM categoria";
                          $query = mysqli_query($conexion,$sql);
                          while ($data = mysqli_fetch_assoc($query))
                          {
                            $id = $data['idcategoria'];
                            $nombre = $data['nombre'];

                          ?>
                      <option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
                          <?php
                           }
                          ?>
                          </select>
                          </div>
                    </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Detalle">Detalle</label>
                                <input type="text" class="form-control" placeholder="Ingrese Detalle" name="Detalle" id="Detalle">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Precio">Precio (Q.)</label>
                                <input type="text" class="form-control" placeholder="Ingrese Precio" name="Precio" id="Precio">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Precio">Fecha Ingreso</label>
                                <input type="text" value="<?php echo Date('m/d/Y') ?>" class="form-control" placeholder="Ingrese fecha" name="fecha" id="fecha">
                            </div>
                        </div>

                    </div>
                    <input type="submit" value="Registrar" class="btn btn-success" id="btnAccion">
                </form>
            </div>
        </div>
          <div class="panel-body" style="height: 400px;" id="formularioregistros">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mt-2" id="tbl">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>DETALLE</th>
                        <th>PRECIO</th>
                        <th>FECHA INGRESO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conexion, "SELECT p.idCosto,u.Nombre,p.Detalle,p.Precio,p.fecha FROM costo p INNER JOIN categoria u
                            ON
                            p.idNombre = u.idcategoria");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td ><?php echo $data['idCosto']; ?></td>
                                <td ><?php echo $data['Nombre']; ?></td>
                                <td ><?php echo $data['Detalle']; ?></td>
                                <td ><?php echo $data['Precio']; ?></td>
                                <td ><?php echo $data['fecha']; ?></td>

                                <td>

                                      <button type="submit" class="btn btn-warning editbtn" data-toggle="modal" data-target="#editar"><i class='fas fa-redo-alt'></i></button>


                                    <form action="eliminar_costo.php?id=<?php echo $data['idCosto']; ?>" method="post" class="confirmar d-inline">
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
              <h5 class="modal-title" id="exampleModalLabel">EDITAR COSTO</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="editar_costo.php" method="post">
                <input type="hidden" name="update_id" id="update_id" >
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="">Detalle</label>
                  <input type="text" name="detalle" id="detalle" class="form-control" required>
                </div>


                <div class="form-group">
                  <label for="">Precio</label>
                  <input type="text" name="precio" id="precio" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="">fecha</label>
                  <input type="text" name="fecha" id="fecha" class="form-control" required>
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
