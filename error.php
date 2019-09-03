<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    <head>

        <!-- Título -->
        <title> Estación de Servicio - Error </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        
    </head>

    <body>

        <!-- Barra de Navegación -->
		<?php include('secciones/navegador.php'); ?>
        
        <!-- Alertas y Notificaciones -->
        <?php include('secciones/alertas.php'); ?>
        
		<!-- Contenido -->
        <div class="container">

            <!-- Mensaje de error -->
		    <div class="row p-5">
		        <div class="col-md-12 mx-auto text-center">
	                <h1 class="mb-3 font-weight-normal">
                        <span class="fa fa-exclamation-triangle"></span>
	                    La página solicitada no se encuentra
	                </h1>
		        </div>
		    </div>

		</div>

        <!-- Footer -->
        <?php include('secciones/footer.php'); ?>

    </body>

</html>