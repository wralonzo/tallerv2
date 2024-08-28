<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="css/fonts.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plantilla/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plantilla/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../plantilla/dist/css/adminlte.min.css">
  <link rel="stylesheet" type="text/css" href="css/cssAdicionales/jquery.dataTables.min.css">
  <link rel="stylesheet" href="css/cssAdicionales/responsive.dataTables.min.css">
  <link rel="stylesheet" href="css/cssAdicionales/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../plantilla/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../plantilla/dist/css/datatable.css">
  <link rel="stylesheet" href="css/cssAdicionales/select2-bootstrap.min.css" />
  <link href="css/cssAdicionales/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/cssAdicionales/mdb.lite.min.css" />
  <link rel="stylesheet" href="css/cssAdicionales/mdb.min.css" />
  <link rel="stylesheet" href="css/cssAdicionales/choices.min.css">
  <link rel="stylesheet" href="css/cssAdicionales/bootstrap-select.css" />

  <style>
    div.container {
      max-width: 1200px
    }
  </style>
  <style>
    .swal2-popup {
      font-size: 1.6rem !important;
    }

    .select2-container .select2-choice,
    .select2-result-label {
      font-size: 1.5em;
      height: 41px;
      overflow: auto;
    }

    .select2-selection {
      min-height: 10px !important;
    }
    .select2-container .select2-selection--single {
      height: 35px !important;
    }

    .select2-selection__arrow {
      height: 34px !important;
    }
  </style>
</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="../plantilla/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="80" width="80">
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
      <div class="dropdown">
        <button class="btn btn-white dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img id="img_nav" style="width: 28px;" class="img-circle elevation-2" src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>">
          <strong><span class="hidden-xs text-primary"><?php echo $_SESSION['nombre']; ?></span></strong>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li class="user-header">
            <div class="image">
              <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle elevation-2" alt="User Image" style="height:200px; width:200px;">
            </div>
            <div class="text-center">
              <strong><a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a></strong>
            </div>
          </li>
          <li class="user-footer">
            <a href="../controller/usuario.php?op=salir" class="dropdown-item">
              <i class="fas fa-arrow-left mr-2"></i> Salir
              <span class="float-right text-muted text-sm">ahora</span>
            </a>
          </li>
        </div>
      </div>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="../plantilla/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">JONASA,S.A</span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php
            if ($_SESSION['escritorio'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/escritorio.php" class="nav-link active">
                    <i class="fas fa-globe"></i>
                      <p>
                        Inicio
                      </p>
                    </a>
                    </li>';
            }
            ?>

<?php
            if ($_SESSION['clientes'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/clientes.php" class="nav-link active">
                    <i class="fas fa-user"></i>
                      <p>
                      Clientes
                      </p>
                    </a>
                    </li>';
            }
            ?>

            <?php
                        if ($_SESSION['vehiculos'] == 1) {
                          echo '<li class="nav-item">
                                <a href="../view/vehiculos.php" class="nav-link active">
                                <i class="fas fa-car"></i>
                                  <p>
                                    Vehículos
                                  </p>
                                </a>
                                </li>';
                        }
                        ?>

                        <?php
                                    if ($_SESSION['servicios'] == 1) {
                                      echo '<li class="nav-item">
                                            <a href="../view/servicios.php" class="nav-link active">
                                            <i class="fas fa-cog"></i>
                                              <p>
                                              Servicios
                                              </p>
                                            </a>
                                            </li>';
                                    }
                                    ?>
<?php
            if ($_SESSION['informatica'] == 1) {
              echo '<li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="fas fa-cogs">
                </i>
                <p>
                  Taller
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                  <a href="categoria.php" class="nav-link">
                    <i class="fas fa-list-ol"></i>
                    <p>Categorías</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="informatica.php" class="nav-link">
                  <i class="fas fa-money-bill"></i>
                    <p>Costos</p>
                  </a>
                </li>
              </ul>
            </li>';
            }
            ?>
<?php
            if ($_SESSION['acceso'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="fas fa-key">
              </i>
              <p>
                Acceso
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="usuarios.php" class="nav-link">
                  <i class="fas fa-users"></i>
                  <p>Usuarios</p>
                </a>
              </li>
            </ul>
          </li>';
            }
            ?>

<?php
            if ($_SESSION['ayuda'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/rrhh.php" class="nav-link active">
                    <i class="fas fa-question"></i>
                      <p>
                        Ayuda
                      </p>
                    </a>
                    </li>';
            }
            ?>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
