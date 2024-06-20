	<?php
  error_reporting(0);
		if (isset($title))
		{
	?>
            <nav class="nav container">
                <a href="#" class="nav__logo"></a>
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="facturas.php" class="nav__link <?php echo $active_facturas;?>">
                                <i class='bx bx-home-alt nav__icon'></i>
                                <span class="nav__name">REMISIONES</span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="servicios_integrales.php" class="nav__link <?php echo $active_servicios;?>">
                                <i class='bx bx-home-alt nav__icon'></i>
                                <span class="nav__name">SERVICIOS</span>
                            </a>
                        </li>
                       
                        
                        <li class="nav__item ">
                            <a href="productos.php" class="nav__link <?php echo $active_productos;?>">
                                <i class='bx bx-briefcase-alt nav__icon'></i>
                                <span class="nav__name">PRODUCTOS</span>
                            </a>
                        </li>
                        <!--<li class="nav__item ">
                            <a href="almacenes.php" class="nav__link <?php echo $active_almacenes;?>">
                                <i class='bx bx-briefcase-alt nav__icon'></i>
                                <span class="nav__name">ALMACENES</span>
                            </a>
                        </li>-->

                        <?php
                            $session_id = $_SESSION["user_id"];
                            $sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
                            $rw_usuario=mysqli_fetch_array($sql_usuario);
                        if ($rw_usuario['is_admin']==1 || $rw_usuario['is_admin']==2 || $rw_usuario['is_admin']==5){
                            echo
                                "
                            <li class='nav__item'>
                                <a href='gastos.php' class='nav__link ".$active_finanzas."'>
                                    <i class='bx bx-credit-card-alt nav__icon'></i>
                                    <span class='nav__name'>GASTOS Prueba</span>
                                </a>
                            </li>";
                        }
                        ?>

                        <?php
                        $session_id = $_SESSION["user_id"];
          $sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
          $rw_usuario=mysqli_fetch_array($sql_usuario);
                        if ($rw_usuario['is_admin']==4 || $rw_usuario['is_admin']==3){
                        }else{
                            echo 
                            "      

                        <li class='nav__item'>
                            <a href='clientes.php' class='nav__link ".$active_clientes."'>
                                <i class='bx bx-book-alt nav__icon'></i>
                                <span class='nav__name'>CLIENTES</span>
                            </a>
                        </li>";
                    }?> 
                        <?php
         $session_id = $_SESSION["user_id"];
          $sql_usuario=mysqli_query($con,"select * from users where user_id ='$session_id'");
          $rw_usuario=mysqli_fetch_array($sql_usuario);
                        if ($rw_usuario['is_admin']==1){
                            echo 
                            "
                            <li class='nav__item'>
                            <a href='reporte_concentrado.php' class='nav__link <?php echo $active_concentrado;?>'>
                                <i class='bx bx-bar-chart nav__icon'></i>
                                <span class='nav__name'>REPORTE</span>
                            </a>
                        </li>

                        <li class='nav__item '>
                            <a href='almacenes.php' class='nav__link ".$active_almacen."'>
                                <i class='bx bx-briefcase-alt nav__icon'></i>
                                <span class='nav__name'>ALMACEN</span>
                            </a>
                        </li>
                        
                        <li class='nav__item'>
                            <a href='usuarios.php' class='nav__link ".$active_usuarios."'>
                                <i class='bx bx-user nav__icon'></i>
                                <span class='nav__name'>USUARIOS</span>
                            </a>
                        </li>

                        <li class='nav__item'>
                            <a href='perfil.php' class='nav__link ".$active_perfil."'>
                                <i class='bx bx-message-square-detail nav__icon'></i>
                                <span class='nav__name'>PERFIL</span>
                            </a>
                        </li>";
                        }?> 
                        <li class="nav__item ">
                            <a href="login.php?logout" class="nav__link ">
                                <i class='bx bx-power-off nav__icon'></i>
                                <span class="nav__name">SALIR</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
	<?php
		}
	?>