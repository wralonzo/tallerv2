<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
require("../config/Conexion.php");
$idServicio = $_GET["id"];

?>

<style>
    @media print {
        .noprint {
            color: white;
            display: none;
        }
    }
</style>
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
                <a class="noprint" href="servicios.php">
                    <h1 style="color: white;">Regresar</h1>
                </a>
            </center>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                    </div>
                </div>
                <html>
                <style>
                    body {
                        font-family: 'Roboto', sans-serif;
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
                $query = mysqli_query($conexion, "SELECT p.idServicio, pd.Nombre, pd.Apellido, p.Total, p.descuento, p.Anticipo,
                    pd.Direccion, p.created_at, pd.Telefono, u.nombre as mecanico, p.garantia,
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

                    WHERE idServicio = '$idServicio'; ");
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
                                    <div class="header">
                                        <div class="header" style="font-size: 12px;">
                                            <h1>OLAM DAVID'S</h1>
                                            <p>TALLER DE MECANÍCA</p>
                                            <p>SUZUKI • HONDA • TOYOTA • LEXUS • HYUNDAI • MERCEDES-BENZ • BMW • VOLVO</p>
                                            <p>Reparación de todo tipo de vehículos de todos los marcas en general</p>
                                            <p>Sector escuela regional Cuilco, Huehuetenango.</p>
                                            <p>Teléfono: 4017-5769-5116, En Dios confiamos!!!</p>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </table>
                        <div class="header">
                            <div>
                                <table align="center" cellspacing="10">
                                    <tr>
                                        <th>
                                            <p>Nombre: <?= $data->Nombre ?> <?= $data->Nombre ?></p>
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
                                        <th width="20%">Anticipo</th>
                                        <th width="20%">Valor</th>
                                    </tr>
                                    <tbody>

                                        <tr align="center">
                                            <td>
                                                <?= $data->idServicio ?>
                                            </td>
                                            <td>
                                                <?= '1' ?>
                                            </td>
                                            <td>
                                                <?= $data->nombre ?>: <?= $data->descripcion ?>
                                            </td>
                                            <td>
                                                Q. <?= $data->Precio ?>
                                            </td>
                                            <td>
                                                Q. <?= $data->descuento ?>
                                            </td>
                                            <td>
                                                Q. <?= $data->Anticipo ?>
                                            </td>
                                            <td>
                                                Q. <?= $data->Total ?>
                                            </td>
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