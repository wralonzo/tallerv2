<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
require "../config/Conexion.php";
if (!empty($_POST)) {
  $Nombre = $_POST['Nombre'];
  $Detalle = $_POST['Detalle'];
  $Vehiculot = $_POST['Vehiculot'];
  $Categoriat = $_POST['Categoriat'];
  $Costo = $_POST['Costo'];
  $Anticipo = $_POST['Anticipo'];
  $Total = $_POST['Total'];
  $mecanico = $_POST['mecanico'];
  $descuento = $_POST['descuento'];
  $garantia = $_POST['garantia'];
  $alert = "";
  if (empty($Nombre) || empty($Detalle) || empty($Vehiculot) || empty($Categoriat) || empty($Costo) || empty($Total)) {
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
      } else {
        $nombre_archivo = '';
        if (isset($_FILES['fileService'])) {
          $nombre_archivo = $_SESSION["idusuario"] . $_FILES['fileService']['name'];
          $tipo_archivo = $_FILES['fileService']['type'];
          $tamano_archivo = $_FILES['fileService']['size'];

          // Validación del archivo (opcional)
          // if (move_uploaded_file($_FILES['fileService']['tmp_name'], './uploads/' . $nombre_archivo)) {
          //   echo "El archivo ha sido subido correctamente.";
          // } else {
          //   echo "Ha ocurrido un error al subir el archivo.";
          // }
        }

        $usuario = $_SESSION["idusuario"];
        $query = "INSERT INTO servicio(Nombre,Detalle,Anticipo,Total,idVehiculo,idCategoria,idCosto,idUser,mecanico,descuento,garantia, image) values ('$Nombre', '$Detalle', '$Anticipo', '$Total', '$Vehiculot', '$Categoriat', '$Costo', '$usuario', '$mecanico', '$descuento', '$garantia','$nombre_archivo'); ";
        $query_insert = mysqli_query($conexion, $query);
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


if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'template/header.php';

  if ($_SESSION['servicios'] == 1) {


?>

    <br>
    <br>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">
      <div class="container-fluid">
        <div class="card">
          <h1> Servicios</h1>
          <div class="card-body">
            <form action="" method="post" autocomplete="off" id="formulario" enctype="multipart/form-data">
              <?php echo isset($alert) ? $alert : ''; ?>
              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Nombre">Nombre Cliente</label>
                    <select class="form-control" placeholder="Seleccionar" name="Nombre" id="Nombre" required>
                      <?php
                      $sql = "SELECT * FROM cliente";
                      $query = mysqli_query($conexion, $sql);
                      while ($data = mysqli_fetch_assoc($query)) {
                        $id = $data['idCliente'];
                        $nombre = $data['Nombre'];
                        $apellido = $data['Apellido'];
                      ?>
                        <option value="<?php echo $id; ?>"><?php echo $nombre . ' ' . $apellido; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Detalle">Detalle Servicio</label>
                    <select class="form-control" placeholder="Seleccionar" name="Detalle" id="Detalle" required>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Vehiculot">Placa Vehículo</label>
                    <select class="form-control" placeholder="Seleccionar" name="Vehiculot" id="Vehiculot" required>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Categoriat">Categoría Servicio</label>
                    <select class="form-control" placeholder="Seleccionar" name="Categoriat" id="Categoriat" required>
                      <?php
                      $sql = "SELECT * FROM categoria";
                      $query = mysqli_query($conexion, $sql);
                      $idCostoQ = 0;
                      while ($data = mysqli_fetch_assoc($query)) {

                        $idCostoQ = $data['idcategoria'];
                        $descripcion = $data['nombre'];
                      ?>
                        <option value="<?php echo $idCostoQ;  ?>"><?php echo $descripcion; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="Costo">Costo en (Q)</label>
                    <select class="form-control" placeholder="Seleccionar" name="Costo" id="costoprecio" required>
                    </select>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="Anticipo">Anticipo en (Q)</label>
                    <input type="number" class="form-control" name="Anticipo" id="Anticipo" min="0" onchange="calculateTotal()" required>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="Total">Total en (Q)</label>
                    <input type="number" class="form-control" name="Total" id="Total" readonly>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Nombre">Nombre del mecanico</label>
                    <select class="form-control" placeholder="Seleccionar" name="mecanico" id="mecanico" required>
                      <?php
                      $sql = "SELECT DISTINCT( u.idUsuario), u.nombre FROM usuario u INNER JOIN usuario_permiso s on s.idusuario = u.idusuario INNER JOIN permiso p on p.idpermiso = s.idpermiso WHERE p.nombre = 'Mecanico';";
                      $query = mysqli_query($conexion, $sql);
                      $idusuario = 0;
                      while ($data = mysqli_fetch_assoc($query)) {
                        $idusuario = $data['idUsuario'];
                        $nombre = $data['nombre'];
                      ?>
                        <option value="<?php echo $idusuario; ?>"> <?php echo $nombre ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Total">Descuento (Q)</label>
                    <input type="number" class="form-control" name="descuento" id="descuento" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Total">Garantía (Días)</label>
                    <input type="number" class="form-control" name="garantia" id="garantia" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Ajuntar un archivo</label>
                  <input type="file" name="fileService" id="abono" class="form-control" onchange="calculateSum()">
                </div>


              </div>
              <input type="submit" value="Registrar" class="btn btn-success" id="btnAccion">
            </form>
          </div>
        </div>

        <div class="panel-body" style="height: 400px;" id="formularioregistros">
          <div class="table-responsive">
            <table style="font-size: 10px;" class="table table-hover table-striped table-bordered mt-2" id="example">
              <thead class="thead-dark">
                <tr style="font-size: 10px !important;">
                  <th style="font-size: 10px !important;">ID</th>
                  <th style="font-size: 10px !important;">NOMBRE</th>
                  <th style="font-size: 10px !important;">DETALLE</th>
                  <th style="font-size: 10px !important;">TIPO VEHICULO</th>
                  <th style="font-size: 10px !important;">COSTO</th>
                  <th style="font-size: 10px !important;">NO.PLACA</th>
                  <th style="font-size: 10px !important;">ANTICIPO</th>
                  <th style="font-size: 10px !important;">TOTAL</th>
                  <th style="font-size: 10px !important;">DESCUENTO</th>
                  <th style="font-size: 10px !important;">MECANICO</th>
                  <th style="font-size: 10px !important;">ACCIONES</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($conexion, "SELECT p.idServicio, pd.Nombre,pd.Apellido, p.descuento, p.facturado, p.image,
                     p.Detalle, p.Anticipo, p.Total, pr.tipoVehiculo, pt.descripcion, ph.Precio, pr.Placa, u.nombre as mecanico FROM
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

                      INNER JOIN 
                      usuario u
                      on u.idusuario = p.mecanico

                      WHERE idServicio = p.idServicio ");

                $result = mysqli_num_rows($query);
                if ($result > 0) {
                  while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                      <td style="font-size: 10px !important;"><?php echo $data['idServicio']; ?></td>
                      <td style="font-size: 10px !important;"><?php echo $data['Nombre']; ?></td>
                      <td style="font-size: 10px !important;"><?php echo $data['descripcion']; ?>
                        <?php
                        $filename = $data['image'];
                        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                        $array = array("png", "jpg", "jpeg", "gif");
                        $valueToSearch = $extension;
                        if (in_array(strtolower($valueToSearch), array_map('strtolower', $array), true)):

                        ?>
                          <img width="10%" src="./uploads/<?php echo $data['image']; ?>" alt="servicio" srcset="">
                        <?php else: ?>
                          <a href="./uploads/<?php echo $data['image']; ?>" target="_blank" class="text-primary"><?php echo $extension ?></a>
                        <?php endif; ?>
                      </td>
                      <td style="font-size: 10px !important;"><?php echo $data['tipoVehiculo'];    ?></td>
                      <td style="font-size: 10px !important;"><?php echo $data['Precio']; ?></td>
                      <td style="font-size: 10px !important;"><?php echo $data['Placa']; ?></td>
                      <td style="font-size: 10px !important;"><?php echo $data['Anticipo']; ?></td>
                      <td style="font-size: 10px !important;"><?php echo $data['Total']; ?></td>
                      <td style="font-size: 10px !important;"><?php echo $data['descuento']; ?></td>
                      <td style="font-size: 10px !important;"><?php echo $data['mecanico']; ?></td>
                      <td style="font-size: 10px !important;">
                        <?php if ($data['facturado'] == 0) { ?>
                          <a title="Facturado" href="#"><i class='fas fa-dollar-sign text-primary facturarS'></i></a>
                        <?php } ?>
                        <a title="Editar" href="#" class="editbtn" data-bs-toggle="modal" data-bs-target="#editar"><i class='fas fa-redo-alt text-warning'></i></a>
                        <a title="Imprimir" href="pdfService.php?id=<?= $data['idServicio'] ?>">
                          <i class='fas fa-print text-success'></i>
                        </a>
                        <form action="eliminar_servicio.php?id=<?php echo $data['idServicio']; ?>" method="post" class="confirmar d-inline">
                          <button style="border:none;" type="submit"><i class='fas fa-trash-alt text-danger'></i> </button>
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
              <h5 class="modal-title" id="exampleModalLabel">EDITAR SERVICIO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="editar_servicio.php" method="post">
                <input type="hidden" name="update_id" id="update_id">

                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" required disabled>
                </div>

                <div class="form-group">
                  <label for="">Detalle Servicio</label>
                  <input type="text" name="detalle" id="detalle" class="form-control" required disabled>
                </div>

                <div class="form-group">
                  <label for="">Vehiculo</label>
                  <input type="text" name="vehiculo" id="vehiculo" class="form-control" disabled>
                </div>

                <!-- <div class="form-group">
                <label for="">Categoria Servicio</label>
                <input type="text" name="categoria" id="categoria" class="form-control" disabled>
              </div> -->

                <div class="form-group">
                  <label for="">Costo en (Q)</label>
                  <input type="text" name="costo" id="costo" class="form-control" disabled>
                </div>

                <div class="form-group">
                  <label for="">Mecanico</label>
                  <input type="text" name="mecanicoT" id="mecanicoT" class="form-control" readonly>
                </div>

                <div class="form-group">
                  <label for="">Anticipo (Q)</label>
                  <input type="text" name="anticipo" id="anticipo" class="form-control" readonly>
                </div>

                <div class="form-group">
                  <label for="">Total (Q)</label>
                  <input type="text" name="total" id="total" class="form-control" readonly>
                </div>

                <div class="form-group">
                  <label for="">Descuento</label>
                  <input type="text" name="descuentoT" id="descuentoT" class="form-control" readonly>
                </div>

                <div class="form-group">
                  <label for="">Abonar</label>
                  <input type="text" name="abono" id="abono" class="form-control" onchange="calculateSum()">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="updatedata" class="btn btn-primary">Guardar</button>
                </div>
              </form>
            </div>
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
  <script>
    function calculateAbono() {
      var total = document.getElementById('total').value;
      var abono = document.getElementById('abono').value;
      var newTotal = total - abono;

      if (newTotal < 0) {
        alert('El total no puede ser un número negativo.');
        document.getElementById('abono').value = '';
      } else {
        document.getElementById('total').value = newTotal;
      }
    }

    // Call calculateAbono when the Abono input changes
    document.getElementById('abono').addEventListener('blur', calculateAbono);

    function calculateSum() {
      var anticipo = parseFloat(document.getElementById('anticipo').value) || 0;
      var abono = parseFloat(document.getElementById('abono').value) || 0;
      document.getElementById('anticipo').value = anticipo + abono;
    }
  </script>

  <script>
    $(document).ready(function() {
      $('.facturarS').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Esta seguro que ya facturó el servicio?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'SI, Facturado!'
        }).then((result) => {
          if (result.isConfirmed) {
            $tr = $(this).closest('tr');
            var datos = $tr.children('td').map(function() {
              return $(this).text();
            });
            var idServicio = datos[0];
            $.get("../controller/servicio.php?op=servicio&id=" + idServicio, function(data) {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Servicio facturado correctamente',
                showConfirmButton: false,
                timer: 2000
              })
            });
          }
        });
      });

      $('.editbtn').on('click', function() {
        $tr = $(this).closest('tr');
        var datos = $tr.children('td').map(function() {
          return $(this).text();
        });
        $('#update_id').val(datos[0]);
        $('#nombre').val(datos[1]);
        $('#detalle').val(datos[2]);
        $('#vehiculo').val(datos[3]);
        $('#categoria').val(datos[4]);
        $('#costoprecio').val(datos[4]);
        $('#anticipo').val(datos[6]);
        $('#total').val(datos[7]);
        $('#descuentoT').val(datos[8]);
        $('#mecanicoT').val(datos[9]);
      });

      var optionSelectedV = $('#Nombre').find('option:selected');
      var valueSelectedV = optionSelectedV.val();

      $.get("../controller/vehiculo.php?op=client&id=" + valueSelectedV, function(data) {
        data = JSON.parse(data);
        for (let i = 0; i < data.length; i++) {
          $('#Vehiculot').append(new Option(data[i].Marca + ' - ' + data[i].Placa, data[i].idVehiculo));
        }
      });

      var optionSelected = $('#Categoriat').find('option:selected');
      var valueSelected = optionSelected.val();

      $.get("../controller/costo.php?op=client&id=" + valueSelected, function(data) {
        data = JSON.parse(data);
        for (let i = 0; i < data.length; i++) {
          $('#Detalle').append(new Option(data[i].Detalle, data[i].idCosto));
          $('#costoprecio').append(
            data.map(function(item) {
              var option = $('<option>', {
                value: item.idCosto,
                text: item.Precio,
                'data-precio': item.Precio
              });
              return option;
            })
          );
        }
        calculateTotal();
      });

      function calculateTotal() {

        var costo = document.querySelector('#costoprecio option:checked').dataset.precio;
        var anticipo = document.getElementById('Anticipo').value;
        var descuento = document.getElementById('descuento').value;

        var total = costo - anticipo;
        total = total - descuento;

        if (total < 0) {
          alert('El total no puede ser un número negativo.');
          document.getElementById('Total').value = '';
        } else {
          document.getElementById('Total').value = total;
        }
      }

      // Call calculateTotal when the Costo selection changes
      document.getElementById('costoprecio').addEventListener('change', calculateTotal);

      // Call calculateTotal when the Anticipo input changes
      document.getElementById('Anticipo').addEventListener('input', calculateTotal);
      document.getElementById('descuento').addEventListener('input', calculateTotal);

    });

    $('#Nombre').on('change', function() {
      // Get the selected option
      var optionSelected = $(this).find('option:selected');
      var valueSelected = optionSelected.val();
      var textSelected = optionSelected.text();
      $.get("../controller/vehiculo.php?op=client&id=" + valueSelected, function(data) {
        $('#Vehiculot').empty();
        data = JSON.parse(data);
        for (let i = 0; i < data.length; i++) {
          $('#Vehiculot').append(new Option(data[i].Marca + ' - ' + data[i].Placa, data[i].idVehiculo));
        }
      });
    });

    $('#Categoriat').on('change', function() {
      // Get the selected option
      var optionSelected = $(this).find('option:selected');
      var valueSelected = optionSelected.val();
      var textSelected = optionSelected.text();
      $.get("../controller/costo.php?op=client&id=" + valueSelected, function(data) {
        $('#Detalle').empty();
        $('#costoprecio').empty();
        data = JSON.parse(data);
        for (let i = 0; i < data.length; i++) {
          $('#Detalle').append(new Option(data[i].Detalle, data[i].idCosto));
          // <option value="<?php echo $idCosto; ?>" data-precio="<?php echo $precio; ?>"><?php echo $precio; ?></option>
          $('#costoprecio').append(
            data.map(function(item) {
              var option = $('<option>', {
                value: item.idCosto,
                text: item.Precio,
                'data-precio': item.Precio
              });
              return option;
            })
          );

          // $('#costoprecio').append(new Option(data[i].idCosto, data[i].Precio));
        }

      });
    });
  </script>
<?php
}
ob_end_flush();
?>