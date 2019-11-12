<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a href="javascript:void(0)" class="navbar-brand" data-url="inicio">
        <img src="img/estacion_servicio_icono.png" class="img-responsive img-rounded" width="80" height="50"></img>
        <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="./img/favicon.ico" type="image/x-icon">
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContenido">
        <?php if (isset($_SESSION['usuario'])) { ?>
        <ul class="navbar-nav mr-auto">
            
            <!-- Usuarios -->
            <?php if(tienePermiso(1) && tienePermiso(58)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/usuarios.php' ? 'active' : '') ?>" href="javascript:void(0)" id="usuariosDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Usuarios
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="usuariosDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="usuarios" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="usuarios" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(1)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/usuarios.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="usuarios" data-area="1">
                    Usuarios
                </a>
            </li>
            <?php } else if(tienePermiso(58)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/usuarios.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="usuarios" data-area="2">
                    Usuarios
                </a>
            </li>

            <!-- Permisos -->
            <?php } if(tienePermiso(10) && tienePermiso(67)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/permisos.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="permisos">
                    Permisos
                </a>
            </li>

            <!-- Clientes -->
            <?php } if(tienePermiso(12) && tienePermiso(69)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/clientes.php' ? 'active' : '') ?>" href="javascript:void(0)" id="clientesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Clientes
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="clientesDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="clientes" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="clientes" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(12)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/clientes.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="clientes" data-area="1">
                    Clientes
                </a>
            </li>
            <?php } else if(tienePermiso(69)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/clientes.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="clientes" data-area="2">
                    Clientes
                </a>
            </li>

            <!-- Proveedores -->
            <?php } if(tienePermiso(34) && tienePermiso(91)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/proveedores.php' ? 'active' : '') ?>" href="javascript:void(0)" id="proveedoresDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Proveedores
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="proveedoresDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="proveedores" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="proveedores" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(34)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/proveedores.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="proveedores" data-area="1">
                    Proveedores
                </a>
            </li>
            <?php } else if(tienePermiso(91)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/proveedores.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="proveedores" data-area="2">
                    Proveedores
                </a>
            </li>
            
            <!-- Compras -->
            <?php } if(tienePermiso(21) && tienePermiso(78)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/compras.php' ? 'active' : '') ?>" href="javascript:void(0)" id="comprasDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Compras
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="comprasDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="compras" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="compras" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(21)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/compras.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="compras" data-area="1">
                    Compras
                </a>
            </li>
            <?php } else if(tienePermiso(78)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/compras.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="compras" data-area="2">
                    Compras
                </a>
            </li>
            
            <!-- Ventas -->
            <?php } if(tienePermiso(44) && tienePermiso(101)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/ventas.php' ? 'active' : '') ?>" href="javascript:void(0)" id="ventasDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ventas
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ventasDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="ventas" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="ventas" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(44)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/ventas.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="ventas" data-area="1">
                    Ventas
                </a>
            </li>
            <?php } else if(tienePermiso(101)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/ventas.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="ventas" data-area="2">
                    Ventas
                </a>
            </li>
            
            <!-- Productos -->
            <?php } if(tienePermiso(28) && tienePermiso(85)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/productos.php' ? 'active' : '') ?>" href="javascript:void(0)" id="productosDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Productos
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="productosDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="productos" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="productos" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(28)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/productos.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="productos" data-area="1">
                    Productos
                </a>
            </li>
            <?php } else if(tienePermiso(85)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/productos.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="productos" data-area="2">
                    Productos
                </a>
            </li>
            
            <!-- Stock -->
            <?php } if(tienePermiso(43) && tienePermiso(100)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/stock.php' ? 'active' : '') ?>" href="javascript:void(0)" id="stockDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Stock
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="stockDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="stock" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="stock" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(43)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/stock.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="stock" data-area="1">
                    Stock
                </a>
            </li>
            <?php } else if(tienePermiso(100)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/stock.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="stock" data-area="2">
                    Stock
                </a>
            </li>
            
            <!-- Caja -->
            <?php } if(tienePermiso(11) && tienePermiso(68)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/caja.php' ? 'active' : '') ?>" href="javascript:void(0)" id="cajaDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Caja
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cajaDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="caja" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="caja" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(11)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/caja.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="caja" data-area="1">
                    Caja
                </a>
            </li>
            <?php } else if(tienePermiso(68)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/caja.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="caja" data-area="2">
                    Caja
                </a>
            </li>

            <!-- Reportes -->
            <?php } if(tienePermiso(57) && tienePermiso(114)) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/reportes.php' ? 'active' : '') ?>" href="javascript:void(0)" id="reportesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reportes
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="reportesDropdown">
                    <a href="javascript:void(0)" class="dropdown-item" data-url="reportes" data-area="1">
                        Playa
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item" data-url="reportes" data-area="2">
                        Mercado
                    </a>
                </div>
            </li>
            <?php } else if(tienePermiso(57)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/reportes.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="reportes" data-area="1">
                    Reportes
                </a>
            </li>
            <?php } else if(tienePermiso(114)) { ?>
            <li class="nav-item <?php echo ($_SERVER['PHP_SELF'] == '/estacionservicio/reportes.php' ? 'active' : '') ?>">
                <a href="javascript:void(0)" class="nav-link" data-url="reportes" data-area="2">
                    Reportes
                </a>
            </li>
            
            <?php } ?>
        </ul>
        <?php } ?>
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['usuario'])) { ?>
                <li class="nav-item dropdown">
                <a href="javascript:void(0)" id="menuUsuario" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="fas fa-user-circle fa-lg"></span>
                    <?php echo $_SESSION['usuario']->usuario ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menuUsuario">
                    <a href="javascript:void(0)" id="botonCerrarSesion" class="dropdown-item">
                        Salir
                        <span class="fas fa-sign-out-alt"></span>
                    </a>
                </div>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" data-url="ingreso">
                    <span class="fas fa-sign-in-alt"></span>
                    Ingresar
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>