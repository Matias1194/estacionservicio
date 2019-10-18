<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    	<!-- Título -->
        <title> Estación de Servicio - Proveedores </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/proveedores.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas y Notificaciones -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<div class="container">
			
			<!-- Listado de Proveedores -->
			<div id="divListadoProveedores">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
	                        Listado de Proveedores
	                    </h1>
	                </div>

	                <?php //if(tienePermiso(10)) { ?>
	                <!-- Nuevo curso -->
                    <div class="col-sm-6 text-right">
                        <button type="button" id="botonNuevoProveedor" class="btn btn-primary mt-2" data-toggle="tooltip" data-placement="left" title="Nuevo Proveedor">
                            <span class="fa fa-plus"></span>
                            <span class="fa fa-parachute-box fa-lg"></span>
                        </button>
                    </div>
	            	<?php //} ?>

	            </div>

	            <hr>

	            <div class="mt-4">

	            	<!-- Barra cargando -->
                    <?php include('secciones/barraCargando.php'); ?>

	                <!-- Tabla Proveedores -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark" style="width: 100%">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col">
	                                    Razón Social
	                                </th>
	                                <th scope="col">
	                                    CUIT
	                                </th>
	                                <th scope="col">
	                                    Calle
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

	        <!-- Nuevo Proveedor -->
	        <div id="divNuevoProveedor" style="display: none;">
	            
	            <div class="row mt-5">

	            	<!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Nuevo Proveedor
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
	                    <div class="form-group col-md-4">
	                        <label>
	                           Razon social
	                        </label>
	                         <input type="text" class="form-control" name="razon_social">
	                    </div>

	                    <!-- Tipo Documento -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Tipo Documento
	                        </label>
	                        <select id="comboTipoDocumentoNuevo" class="form-control" name="id_tipo_documento"> </select>
	                    </div>
	                    
	                    <!-- Documento -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Documento
	                        </label>
	                        <input type="number" class="form-control" name="documento">
	                    </div>

	                </div>

	                <!-- Segunda fila -->
	                <div class="form-row">

	                	<!-- País -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            País
	                        </label>
	                        <input type="text" class="form-control" name="pais">
	                    </div>

	                	<!-- Provincia -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Provincia
	                        </label>
	                        <input type="text" class="form-control" name="provincia">
	                    </div>

	                    <!-- Localicad -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Localidad
	                        </label>
	                        <input type="text" class="form-control" name="localidad">
	                    </div>
	                    
	                    <!-- Calle -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Calle
	                        </label>
	                        <input type="text" class="form-control" name="calle">
	                    </div>

	                </div>

	                <!-- Tercera fila -->
	                <div class="form-row">
	                    
						<!-- Sucursal -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Sucursal
	                        </label>
	                        <input type="text" class="form-control" name="sucursal">
	                    </div>

	                    <!-- E-mail -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            E-mail
	                        </label>
	                        <input type="text" class="form-control" name="email">
	                    </div>
                    	
                    	<!-- Teléfono-->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Teléfono
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

	        <!-- Editar Proveedor -->
	        <div id="divEditarProveedor" style="display: none;">
	        	
	        	<div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Editar Proveedor
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
	                    <div class="form-group col-md-4">
	                        <label>
	                           Razon social
	                        </label>
	                         <input type="text" class="form-control" name="razon_social">
	                    </div>

	                    <!-- Tipo Documento -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Tipo Documento
	                        </label>
	                        <select id="comboTipoDocumentoEditar" class="form-control" name="id_tipo_documento"> </select>
	                    </div>
	                    
	                    <!-- Documento -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Documento
	                        </label>
	                        <input type="number" class="form-control" name="documento">
	                    </div>

	                </div>

	                <!-- Segunda fila -->
	                <div class="form-row">

	                	<!-- País -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            País
	                        </label>
	                        <input type="text" class="form-control" name="pais">
	                    </div>

	                	<!-- Provincia -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Provincia
	                        </label>
	                        <input type="text" class="form-control" name="provincia">
	                    </div>

	                    <!-- Localicad -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Localidad
	                        </label>
	                        <input type="text" class="form-control" name="localidad">
	                    </div>
	                    
	                    <!-- Calle -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Calle
	                        </label>
	                        <input type="text" class="form-control" name="calle">
	                    </div>

	                </div>

	                <!-- Tercera fila -->
	                <div class="form-row">
	                    
						<!-- Sucursal -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Sucursal
	                        </label>
	                        <input type="text" class="form-control" name="sucursal">
	                    </div>

	                    <!-- E-mail -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            E-mail
	                        </label>
	                        <input type="text" class="form-control" name="email">
	                    </div>
                    	
                    	<!-- Teléfono-->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Teléfono
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