<!DOCTYPE html>
<html>

	<head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

		<!-- Título -->
		<title> Estación de Servicio - Ingreso </title>

		<!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/ingreso.js"></script>
		
	</head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas y Notificaciones -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
        <div class="container">

        	<!-- Ingreso -->
            <div class="row m-5">
                <div class="col-md-4 mx-auto">

                    <!-- Título -->
                    <h2 class="mb-3 font-weight-normal text-center">
                        Ingreso
                    </h2>
					
					<!-- Formulario -->
                    <form class="mt-4">
                        
                        <!-- Usuario -->
                        <div class="form-group">
                            <input type="text" id="campoUsuario" class="form-control" placeholder="Usuario">
                        </div>
                        
                        <!-- Clave -->
                        <div class="form-group">
                            <input type="password" id="campoClave" class="form-control" placeholder="Clave">
                        </div>
                        
                        <!-- Botón Ingresar -->
                        <button type="button" id="botonIngresar" class="btn btn-primary btn-block">
                            <span class="fa fa-sign-in-alt"></span> 
                            Ingresar
                        </button>
                    
                    </form>

                </div>
            </div>

        </div>

		<!-- Footer -->
		<?php include('secciones/footer.php'); ?>

	</body>
    
</html>