<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    	<!-- Título -->
        <title> Estación de Servicio - Reportes </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
		<script src="js/reportes.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<div class="container">

            <input type="hidden" id="area" value="<?php echo $_GET['area']; ?>">
            
            <!-- Inicio-->
			<div id="inicio" style="display:none">
				
	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
							<span class="fa fa-file-download"></span>
							Reportes
	                    </h1>
	                </div>

	            </div>

	            <hr>

	            <div class="mt-4">
                    
	                <!-- Tabla -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark" style="width:100%">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col">
	                                    Módulo
	                                </th>
									<th scope="col">
                                        Período
	                                </th>
	                                <th class="text-center" scope="col">
	                                    Acciones
	                                </th>
	                            </tr>
	                        </thead>

	                        <tbody>
                                <tr>
                                    <td>Ventas</td>
                                    <td>Último Mes</td>
                                    <td class="text-center">
                                        <button class="btn btn-success mt-2" name="descargar_ventas">
                                            <span class="fa fa-file-pdf fa-lg"></span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Compras</td>
                                    <td>Último Mes</td>
                                    <td class="text-center">
                                        <button class="btn btn-success mt-2" name="descargar_compras">
                                            <span class="fa fa-file-pdf fa-lg"></span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stock</td>
                                    <td>Actual</td>
                                    <td class="text-center">
                                        <button class="btn btn-success mt-2" name="descargar_stock">
                                            <span class="fa fa-file-pdf fa-lg"></span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
	                    
	                    </table>

	                </div>

	            </div>

	        </div>
            
       	</div>

		<!-- Footer -->
		<?php include('secciones/footer.php'); ?>

	</body>
	
</html>