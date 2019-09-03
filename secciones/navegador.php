<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="javascript:void(0)" class="navbar-brand" data-url="inicio">
        <img src="img/estacion_servicio_icono.png" class="img-responsive img-rounded" width="80" height="50"></img>
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContenido">
        <?php if (isset($_SESSION['usuario'])) { ?>
        <ul class="navbar-nav mr-auto">
            <!--<?php //if(tienePermiso(18)) { ?>-->
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/proveedores.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="proveedores">
                    Proveedores
                </a>
            </li>
            <!--<?php //} if(tienePermiso(8)) { ?>-->
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/clientes.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="clientes">
                    Clientes
                </a>
            </li>
            <!--<?php //} if(tienePermiso(1)) { ?>-->
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/usuarios.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="usuarios">
                    Usuarios
                </a>
            </li>
            <!--<?php //} if(tienePermiso(1)) { ?>-->
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/compras.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="compras">
                    Compras
                </a>
            </li>
            <!--<?php //} if(tienePermiso(15)) { ?>-->
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/ventas.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="ventas">
                    Ventas
                </a>
            </li>
            <!--<?php //} ?>-->
        </ul>
        <?php } ?>
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['usuario'])) { ?>
                <li class="nav-item dropdown">
                <a href="javascript:void(0)" id="menuUsuario" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="fas fa-star"></span>
                    <?php echo $_SESSION['usuario']->usuario ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menuUsuario">
                    <a href="javascript:void(0)" id="botonCerrarSesion" class="dropdown-item">
                        Cerrar Sesión
                        <span class="fas fa-sign-out-alt"></span>
                    </a>
                </div>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" data-url="ingreso">
                    <span class="fas fa-sign-in-alt"></span>
                    Iniciar Sesión
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>