<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    	<!-- Título -->
        <title> Estación de Servicio - Caja </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/caja.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<div class="container">

			<!-- Listado de caja-->
			<div id="listado" style="display:none">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
	                        Movimientos de Caja
	                    </h1>
	                </div>

	            </div>

	            <hr>

	            <div class="mt-4">

	            	<!-- Barra cargando -->
                    <?php include('secciones/barraCargando.php'); ?>
                    
	                <!-- Tabla Caja -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark" style="width:100%">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col">
	                                    Fecha
	                                </th>
									<th scope="col">
	                                    Registro
	                                </th>
									<th scope="col">
	                                    Entrada
	                                </th>
                                    <th scope="col">
	                                    Salida
	                                </th>
                                    <th scope="col">
	                                    Saldo
	                                </th>
                                    <th scope="col">
	                                    Medio de pago
	                                </th>
                                    <th scope="col">
	                                    Usuario
	                                </th>
	                                <!--<th class="text-center" scope="col" colspan="4">
	                                    Acciones
	                                </th>-->
	                            </tr>
	                        </thead>

	                        <tbody></tbody>
	                    
	                    </table>

	                </div>

	            </div>

	        </div>
            
       	</div>

		<!-- Footer -->
		<?php include('secciones/footer.php'); ?>

	</body>
	
</html>