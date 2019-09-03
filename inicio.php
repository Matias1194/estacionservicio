<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>

    <head>

        <!-- Título -->
        <title> Estación de Servicio - Inicio </title>

        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/inicio.js"></script>
        
    </head>

    <body>

        <!-- Barra de Navegación -->
		<?php include('secciones/navegador.php'); ?>
        
        <!-- Alertas y Notificaciones -->
        <?php include('secciones/alertas.php'); ?>
        
        <!-- Contenido -->
		<div class="container">
			<div class="row mt-5">
                <div class="col-sm-10">
                    <h1 class="font-weight-normal">
						Bienvenido <?php echo $_SESSION["usuario"]->nombres . ' ' . $_SESSION["usuario"]->apellidos ?> !
                    </h1>
                </div>
            </div>
		</div>

        <!-- Footer -->
        <?php include('secciones/footer.php'); ?>

    </body>

</html>