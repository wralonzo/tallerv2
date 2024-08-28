<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'template/header.php';

if ($_SESSION['escritorio']==1)
{




?>
<br>
<style>
<style>
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body{
font-family: 'Raleway', sans-serif;
}
header{
  width: 100%;
  height: auto;
  position: relative;
}
video{
  width: 100%;
   height: 50%;

}

.absolute{
  width: 100%;
  height: 100%;
  top:0;
  right: 0;
  position: absolute;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
}
h1{
  font-size: 80px;
  font-weight: 900;
  z-index: 100;
  color: #fff;
  margin-bottom: 30px;
}
h1::after{
  display: block;
  width: 30%;
  height: 10px;
  content: "";
  margin: auto;
  background: #fff;
}
.overlay{
  width: 81%;
  height: 100%;
  position: absolute;
  background: rgba(0,0,0,0.575);
}

</style>
<br>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <div class="overlay"></div>
        <div class="absolute">
          <h1>Bienvenido(a)
          <p><?php echo $_SESSION['nombre'];?></p></h1>
        </div>
        <video  onloadedmetadata="this.muted=true" autoplay loop>
          <source src="production.mp4">
        </video>
    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}


require 'template/footer.php';
?>

<?php
}
ob_end_flush();
?>
