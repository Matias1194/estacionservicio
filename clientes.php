<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
		
    	<!-- Título -->
        <title> Estación de Servicio - Clientes </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/clientes.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas y Notificaciones -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<div class="container">
			
			<!-- Listado de Clientes -->
			<div id="divListadoClientes">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
	                        Listado de Clientes
	                    </h1>
	                </div>

	                <?php //if(tienePermiso(10)) { ?>
	                <!-- Nuevo curso -->
                    <div class="col-sm-6 text-right">
                        <button type="button" id="botonNuevoCliente" class="btn btn-primary mt-2" data-toggle="tooltip" data-placement="left" title="Nuevo Cliente">
                            <span class="fa fa-plus"></span>
                            <span class="fa fa-address-book fa-lg"></span>
                        </button>
                    </div>
	            	<?php //} ?>

	            </div>

	            <hr>

	            <div class="mt-4">

	            	<!-- Barra cargando -->
                    <?php include('secciones/barraCargando.php'); ?>

	                <!-- Tabla Clientes -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark" style="width:100%">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col">
	                                    Razón Social
	                                </th>
	                                <th scope="col">
	                                    CUIT
	                                </th>
	                                <th scope="col">
	                                    Domicilio
	                                </th>
	                                <th scope="col">
	                                    Email
	                                </th>
	                                <th scope="col">
	                                    Teléfono
	                                </th>
	                                <th class="text-center" scope="col" colspan="4">
	                                    Acciones
	                                </th>
	                            </tr>
	                        </thead>

	                        <tbody></tbody>
	                    
	                    </table>

	                </div>

	            </div>

	        </div>

	        <!-- Nuevo Cliente -->
	        <div id="divNuevoCliente" style="display: none;">
	            
	            <div class="row mt-5">

	            	<!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Nuevo Cliente
	                    </h1>
	                </div>
	                
	                <!-- Volver al listado -->
	                <div class="col-md-6 text-right">
                        <button type="button" class="botonVolver btn btn-secondary mt-2" data-pantalla="Listado">
                            <span class="fa fa-chevron-left"></span> 
                            Volver
                        </button>
                    </div>

	            </div>

	            <hr>

	            <form class="mt-4">
	                
	                <!-- Primera fila -->
	                <div class="form-row">
	                    
	                    <!-- Razon Social -->
	                    <div class="form-group col-md-3">
	                        <label>
	                           Razon social
	                        </label>
	                         <input type="text" class="form-control" name="razon_social">
	                    </div>
	                    
	                    <!-- CUIT -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            CUIT
	                        </label>
	                        <input type="number" class="form-control" name="cuit">
	                    </div>

	                </div>

	                <!-- Segunda fila -->
	                <div class="form-row">
	                    
	                    <!-- Domicilio -->
	                    <div class="form-group col-md-5">
	                        <label>
	                            Domicilio
	                        </label>
	                        <input type="text" class="form-control" name="domicilio">
	                    </div>

	                </div>

	                <!-- Tercera fila -->
	                <div class="form-row">
	                    
	                    <!-- E-mail -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            E-mail
	                        </label>
	                        <input type="text" class="form-control" name="email">
	                    </div>
                    	
                    	<!-- Telefono-->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Telefono
	                        </label>
	                        <input type="text" class="form-control" name="telefono">
	                    </div>

	                </div>

	                <!-- Botón confirmar -->
	                <button type="button" id="botonConfirmarNuevo" class="btn btn-primary mt-3">
	                    <span class="fa fa-check"></span> 
	                    Confirmar
	                </button>

	            </form>

	        </div>

	        <!-- Editar Cliente -->
	        <div id="divEditarCliente" style="display: none;">
	        	
	        	<div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Editar Cliente
	                    </h1>
	                </div>
	                
	                <!-- Volver al listado -->
	                <div class="col-md-6 text-right">
                        <button type="button" class="botonVolver btn btn-secondary mt-2" data-pantalla="Listado">
                            <span class="fa fa-chevron-left"></span> 
                            Volver
                        </button>
                    </div>

	            </div>

	            <hr>

	            <form class="mt-4">
	                
	                <!-- Primera fila -->
	                <div class="form-row">
	                    
	                    <!-- Razon Social -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Razon Social
	                        </label>
	                        <input type="text" class="form-control" name="razon_social">
	                    </div>
	                    
	                    <!-- CUIT -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            CUIT
	                        </label>
	                        <input type="number" class="form-control" name="cuit">
	                    </div>

	                </div>
	                
	                <!-- Segunda fila -->
	                <div class="form-row">
	                    
	                    <!-- Domicilio -->
	                    <div class="form-group col-md-5">
	                        <label>
	                            Domicilio
	                        </label>
	                        <input type="text" class="form-control" name="domicilio">
	                    </div>
	                </div>

	                <!-- Segunda fila -->
	                <div class="form-row">
	                    
	                    <!-- E-mail -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            E-mail
	                        </label>
	                        <input type="text" class="form-control" name="email">
	                    </div>

	                    <!-- Telefono-->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Telefono
	                        </label>
	                        <input type="text" class="form-control" name="telefono">
	                    </div>

	                </div>

	                <input type="hidden" name="id">

	                <!-- Botón confirmar -->
	                <button type="button" id="botonConfirmarEditar" class="btn btn-primary mt-3">
	                    <span class="fa fa-check"></span> 
	                    Confirmar
	                </button>

	            </form>

	        </div>

       	</div>

		<!-- Footer -->
		<?php include('secciones/footer.php'); ?>

	</body>
	
</html>