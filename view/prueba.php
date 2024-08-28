<?php

//Activamos el almacenamiento en el buffer
ob_start();
session_start();



include "../conexion.php";



if (!empty($_POST)) {


    $Nombre = $_POST['Nombre'];

    $categoria = $_POST['Categoria'];

    $fecha = $_POST['fecha'];

    $alert = "";
    if (empty($Nombre) || empty($categoria)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todo los campos son obligatorio
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    } else {
      if (empty($id)) {
          $Nombre = $_POST['Nombre'];
          if (empty($Nombre)) {
              $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  Nombre es requerido
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
          }else {
              $Nombre = $_POST['Nombre'];
              $query = mysqli_query($conexion, "SELECT * FROM servicio where Nombre = '$Nombre'");
              $result = mysqli_fetch_array($query);
              if ($result > 0) {
                  $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  Nombre ya existe
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
          }else{
              $query_insert = mysqli_query($conexion, "INSERT INTO servicio(Nombre,idVehiculo,idCategoria,idCosto,fecha) values ('$Nombre', Vehiculo, '$categoria', Precio, '$fecha')");
                    if ($query_insert) {
                        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Servicio Registrado
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

          if ($_SESSION['servicios']==1)
          {


?>

<div class="content-wrapper">
  <div class="card">
      <div class="card-body">
        <div class="card">
            <div class="card-body">
              <form action="" method="post" autocomplete="off" id="formulario">
  <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <input type="hidden" id="idcliente" value="1" name="idcliente" required>
                              <label>Nombre</label>
                              <input type="text" name="Nombre" id="Nombre" class="form-control" placeholder="Ingrese nombre del cliente" required>
                          </div>
                      </div>

                      <div class="col-md-5">
                          <div class="form-group">
                              <label>Vehiculo</label>
                              <input type="text" name="Vehiculo" id="Vehiculo" class="form-control" >
                          </div>
                      </div>

                        <div class="col-md-5">
                            <div class="form-group">
  <input type="hidden" id="idcliente" value="1" name="idcliente" required>
                                <label>Categoria</label>
                                <input type="text" name="Categoria" id="Categoria" class="form-control" placeholder="Ingrese Nombre Categoria" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="decimal" name="Precio" id="Precio" class="form-control" disabled >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
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
                      <th>Nombre</th>
                      <th>Vehiculo</th>
                      <th>Categoria</th>
                      <th>Costo</th>
                      <th>Fecha</th>
                      <th>Herramienta</th>

                  </tr>
              </thead>
              <tbody>
                  <?php
                  $query= mysqli_query($conexion,"SELECT p.idServicio, pd.Nombre, pr.tipoVehiculo, pt.descripcion, ph.Precio,p.fecha FROM
                    servicio p
                    INNER JOIN
                    vehiculo pr
                    ON
                    p.idVehiculo = pr.idVehiculo
                    INNER JOIN
                    categoria pt
                    ON
                    p.idCategoria = pt.idcategoria
                    INNER JOIN
                    costo ph
                    ON
                    p.idCosto= ph.idCosto
                    INNER JOIN
                    cliente pd
                    ON
                    p.Nombre = pd.idCliente

                    WHERE idServicio = p.idServicio ");

                  $result = mysqli_num_rows($query);
                  if ($result > 0) {
                      while ($data = mysqli_fetch_assoc($query)) { ?>
                          <tr>
                              <td ><?php echo $data['idServicio']; ?></td>
                              <td ><?php echo $data['Nombre']; ?></td>
                              <td ><?php echo $data['tipoVehiculo']; ?></td>
                              <td ><?php echo $data['descripcion']; ?></td>
                              <td ><?php echo $data['Precio']; ?></td>
                                <td ><?php echo $data['fecha'];    ?></td>

                              <td>

                                    <button type="submit" class="btn btn-success editbtn" data-toggle="modal" data-target="#editar"><i class='fas fa-redo-alt'></i></button>


                                  <form action="eliminar_servicio.php?id=<?php echo $data['idServicio']; ?>" method="post" class="confirmar d-inline">
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
            <form action="editar_servicio.php" method="post">
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
                <label for="">Tipo Vehiculo</label>
                <input type="text" name="vehiculo" id="vehiculo" class="form-control" disabled>
              </div>

              <div class="form-group">
                <label for="">Tipo Categoria</label>
                <input type="text" name="categoria" id="categoria" class="form-control" disabled>
              </div>

              <div class="form-group">
                <label for="">Costo</label>
                <input type="text" name="costo" id="costo" class="form-control" disabled>
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
<script type="text/javascript" src="scripts/servicio.js"></script>
<?php
}
ob_end_flush();
?>
