<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
require("../config/Conexion.php");
if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
} else {
    require 'template/header.php';

    if ($_SESSION['vehiculos'] == 1) {




?>

        <div class="content-body">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <!-- Bootstrap CSS -->
                        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
                        <!-- CSS personalizado -->
                        <link rel="stylesheet" href="main.css">

                        <!--datables CSS básico-->
                        <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css" />
                        <!--datables estilo bootstrap 4 CSS-->
                        <link rel="stylesheet" type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">

                        <!--font awesome con CDN-->
                        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

                        </head>

                        <BR>
                        <header>
                            <h1>Reporte Servicios</h1>

                        </header>
                        <div style="height:50px"></div>

                        <!--Ejemplo tabla con DataTables-->
                        <div class="container">
                            <form action="printClient.php" method="POST">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Servicios sin facturar por cliente</label>
                                            <select class="form-control" type="text" name="cliente" id="">
                                                <?php
                                                $query = mysqli_query($conexion, "SELECT * from cliente");
                                                $result = mysqli_num_rows($query);
                                                if ($result > 0) {
                                                    while ($data = mysqli_fetch_assoc($query)) {
                                                ?>
                                                        <option value="<?php echo $data['idCliente']; ?>"><?php echo $data['Nombre']; ?> <?php echo $data['Apellido']; ?></option>

                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for=""></label><br>
                                        <input class="btn btn-success" type="submit" value="Facturar">
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive" style="font-size: 10px;">
                                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead style="font-size: 10px;">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>NOMBRE</th>
                                                    <th>DETALLE</th>
                                                    <th>PLACA VEHICULO</th>
                                                    <th>Costo</th>
                                                    <th>ANTICIPO</th>
                                                    <th>DESCUENTO</th>
                                                    <th>TOTAL</th>
                                                    <th>FECHA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query($conexion, "SELECT p.idServicio, p.created_at, pd.Nombre,pd.Apellido, p.descuento, p.facturado, p.image,
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
                                                            <td><?php echo $data['idServicio']; ?></td>
                                                            <td><?php echo $data['Nombre']; ?> <?php echo $data['Apellido']; ?></td>

                                                            <td><?php echo $data['descripcion']; ?></td>
                                                            <td><?php echo $data['tipoVehiculo'];    ?></td>
                                                            <td><?php echo $data['Precio']; ?></td>
                                                            <td><?php echo $data['Anticipo']; ?></td>
                                                            <td><?php echo $data['descuento']; ?></td>
                                                            <td><?php echo $data['Total']; ?></td>
                                                            <td><?php echo $data['created_at']; ?></td>

                                                        </tr>
                                                <?php }
                                                } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- jQuery, Popper.js, Bootstrap JS -->
                        <script src="../jquery/jquery-3.3.1.min.js"></script>
                        <script src="../popper/popper.min.js"></script>
                        <script src="../bootstrap/js/bootstrap.min.js"></script>

                        <!-- datatables JS -->
                        <script type="text/javascript" src="../datatables/datatables.min.js"></script>

                        <!-- para usar botones en datatables JS -->
                        <script src="../datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
                        <script src="../datatables/JSZip-2.5.0/jszip.min.js"></script>
                        <script src="../datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
                        <script src="../datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
                        <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

                        <!-- código JS propìo-->
                        <script type="text/javascript" src="main.js"></script>

                    </div>
                </div>
            </div>

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