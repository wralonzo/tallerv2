<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

require("../config/Conexion.php");
$idCliente = $_POST["cliente"];

?>

<div class="content-wrapper">

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

            </header>
            <div style="height:50px"></div>
            <center>
                <a class="noprint" href="pdfservicio.php">
                    <h1 style="color: white;">Regresar</h1>
                </a>
            </center>
            <!--Ejemplo tabla con DataTables-->
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                    </div>
                </div>
                <html>
                <style>
                    @media print {
                        .noprint {
                            color: white;
                            display: none;
                        }
                    }

                    body {
                        font-family: 'Roboto', sans-serif;
                        font-size: 10px;
                        margin: 0;
                        padding: 0;
                        background-color: #264653;
                        color: black;
                    }

                    .container {
                        max-width: 1200px;
                        margin: 0 auto;
                        padding: 20px;
                    }

                    .header {
                        text-align: center;
                        padding: 20px;
                        background-color: #fff;
                        color: #264653;
                    }

                    .header h1 {
                        font-size: 3em;
                        margin: 0;
                    }

                    .header p {
                        font-size: 1.2em;
                        margin: 0;
                    }

                    .car-info {
                        display: flex;
                        justify-content: space-between;
                        margin-top: 20px;
                    }

                    .car-info div {
                        width: 30%;
                        padding: 20px;
                        background-color: #fff;
                        color: #264653;
                    }

                    .car-info h2 {
                        font-size: 1.5em;
                        margin: 0;
                    }

                    .car-info p {
                        font-size: 1em;
                        margin: 0;
                    }
                </style>
                <?php
                $query = mysqli_query($conexion, "SELECT p.idServicio, pd.Nombre, pd.Apellido, p.Total,
                    pd.Direccion, p.created_at, pd.Telefono, u.nombre as mecanico, p.garantia,
                    p.Detalle, pr.tipoVehiculo, pt.descripcion, pt.nombre, ph.Precio, pr.Placa FROM

                    WHERE pr.idCliente = '$idCliente'; ");
                $data = mysqli_fetch_object($query);
                ?>

                <body>
                    <div class="container">
                        <table width="110%">
                            <tr>
                                <th width="20%">
                                    <img src="../files/system/logo.jpeg" width="80%" alt="">
                                </th>
                                <th width="90%">
                                    <div class="header" style="font-size: 12px;">
                                        <h1>OLAM DAVID'S</h1>
                                        <p>TALLER DE MECANÍCA</p>
                                        <p>SUZUKI • HONDA • TOYOTA • LEXUS • HYUNDAI • MERCEDES-BENZ • BMW • VOLVO</p>
                                        <p>Reparación de todo tipo de vehículos de todos los marcas en general</p>
                                        <p>Sector escuela regional Cuilco, Huehuetenango.</p>
                                        <p>Teléfono: 4017-5966/5991-1694/3000-0511, En Dios confiamos!!!</p>
                                    </div>
                                </th>
                            </tr>
                        </table>
                        <div class="header">
                            <div>
                                <table align="center" cellspacing="10">
                                    <tr>
                                        <th>
                                            <p>Nombre: <?= $data->Nombre ?> <?= $data->Apellido ?></p>
                                            <p>DIRECCIÓN: <?= $data->Direccion ?></p>
                                            <p>PLACA: <?= $data->Placa ?></p>
                                            <p>GARANTÍA: <?= $data->garantia ?> días</p>

                                        </th>
                                        <th>
                                            <p>Fecha: <?= $data->created_at ?> </p>
                                            <p>TEL: <?= $data->Telefono ?></p>
                                            <p>MECANICO:<?= $data->mecanico ?> </p>
                                        </th>

                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="header container" width="120%" border="1">
                            <div>
                                <table align="center" border="1">
                                    <tr align="center">
                                        <th width="20%">
                                            Id
                                        </th>
                                        <th width="20%">
                                            Cantidad
                                        </th>
                                        <th width="40%">
                                            Descripción
                                        </th>
                                        <th width="20%">Costo</th>
                                        <th width="20%">Descuento</th>
                                        <th width="10%">Anticipo</th>
                                        <th width="20%">Valor</th>
                                    </tr>
                                    <tbody>
                                        <?php
                                        $queryReport = mysqli_query($conexion, "SELECT p.idServicio, pd.Nombre, p.Total, p.descuento, p.Anticipo,
                                            pd.Direccion, p.created_at, pd.Telefono, u.nombre as mecanico,
                                            p.Detalle, pr.tipoVehiculo, pt.descripcion, pt.nombre, ph.Precio, pr.Placa FROM
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
                                            on 
                                            u.idusuario = p.mecanico

                                            WHERE pr.idCliente = '$idCliente' and p.facturado = 0; ");
                                        $resultArray = mysqli_num_rows($queryReport);

                                        if ($resultArray > 0) {
                                            $totalFactura = 0;
                                            $totalDecuento = 0;
                                            $totalAnticipo = 0;
                                            $totalCosto = 0;
                                            $contador = 0;
                                            while ($newData = mysqli_fetch_assoc($queryReport)) {
                                                $totalFactura = $totalFactura + $newData['Total'];
                                                $totalCosto = $totalCosto + $newData['Precio'];
                                                $totalDecuento = $totalDecuento + $newData['descuento'];
                                                $totalAnticipo = $totalAnticipo + $newData['Anticipo'];
                                                $contador = $contador + 1;
                                        ?>
                                                <tr>

                                                    <td>
                                                        <?= $newData['idServicio'] ?>
                                                    </td>
                                                    <td>
                                                        <?= '1' ?>
                                                    </td>
                                                    <td>
                                                        <?= $newData['nombre'] ?>: <?= $newData['descripcion'] ?>
                                                    </td>
                                                    <td>
                                                        Q. <?= $newData['Precio'] ?>
                                                    </td>
                                                    <td>
                                                        Q. <?= $newData['descuento'] ?>
                                                    </td>
                                                    <td>
                                                        Q. <?= $newData['Anticipo'] ?>
                                                    </td>
                                                    <td>
                                                        Q. <?= $newData['Total'] ?>
                                                    </td>

                                                </tr>
                                        <?php }
                                        } ?>
                                        <tr>
                                            <td width="20%"><strong>Total</strong></td>
                                            <td width="20%"><strong><?= $contador; ?></strong></td>
                                            <td width="40%"><strong>Total</strong></td>
                                            <td width="20%"><strong>Q.<?= $totalCosto; ?></strong></td>
                                            <td width="20%"><strong>Q.<?= $totalDecuento; ?></strong></td>
                                            <td width="20%"><strong>Q.<?= $totalAnticipo; ?></strong></td>
                                            <td width="20%"><strong>Q.<?= $totalFactura; ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </body>

                </html>
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
        <script>
            window.onload = function() {
                window.print();
            };
        </script>

    </div>
</div>

<?php
?>
<?php

ob_end_flush();
?>