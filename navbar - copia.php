	<?php
  error_reporting(0);
		if (isset($title))
		{
	?>
<nav class="navbar nav container navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">SUMED</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php echo $active_facturas;?>"><a href="facturas.php"><i class='glyphicon glyphicon-list-alt'></i> Remisiones <span class="sr-only">(current)</span></a></li>
        <li class="<?php echo $active_servicios;?>"><a href="servicios_integrales.php"><i class='glyphicon glyphicon-list-alt'></i> Servicios Integrales <span class="sr-only"></span></a></li>
        <li class="<?php echo $active_productos;?>"><a href="productos.php"><i class='glyphicon glyphicon-barcode'></i> Productos</a></li>
		<li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Clientes</a></li>
		<?php  
    $session_id = $_SESSION["user_id"];
          $sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
          $rw_usuario=mysqli_fetch_array($sql_usuario);

    if ($rw_usuario['is_admin']==1){
     echo "
    <li class='".$active_usuarios."'><a href='usuarios.php'><i  class='glyphicon glyphicon-lock'></i> Usuarios</a></li>";}?>
    
  <?php if ($rw_usuario['is_admin'] == 1) {
    echo "
      <li class='".$active_perfil."'><a href='perfil.php'><i  class='glyphicon glyphicon-con'></i> Configuración</a></li>
       </ul>";
      }  ?>

      <ul class='nav navbar-nav navbar-right'>
		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>