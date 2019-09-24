<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

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
	                    Página desconocida
                    </h1>
                    
                </div>
                
		    </div>

		</div>

        <!-- Footer -->
        <?php include('secciones/footer.php'); ?>

    </body>

</html>