<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

    	<!-- Título -->
        <title> Estación de Servicio - Compras </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/compras.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas y Notificaciones -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<main role="main" class="container">
			
			<!-- Inicio -->
			<div id="divInicioCompras" style="display: block;">
				
				<div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6 text-center">
	                    <h1 class="font-weight-normal">
	                        Seleccione la opción
	                    </h1>
	                </div>

	            </div>

	            <div class="row mt-5">
	            
	                <!-- Botón Consultar Compras -->
                    <div class="col-sm-3 text-center">
                        <button type="button" id="botonConsultarCompras" class="btn btn-lg btn-primary mt-2" data-toggle="tooltip" data-placement="left" title="Consultar Compras">
                            <span class="fa fa-search"></span>
                            Consultar
                        </button>
                    </div>

                    <!-- Botón Nueva Compra -->
                    <div class="col-sm-3 text-center">
                        <button type="button" id="botonNuevaCompra" class="btn btn-lg btn-primary mt-2" data-toggle="tooltip" data-placement="left" title="Nueva Compra">
                            <span class="fa fa-plus"></span>
                            Nueva
                        </button>
                    </div>
                
                </div>

	            <hr>

	            <div class="mt-4">

	            </div>

			</div>

			<!-- Listado de Compras -->
			<div id="divListadoCompras" style="display: block;">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
	                        Listado de Compras
	                    </h1>
	                </div>

	                <?php //if(tienePermiso(10)) { ?>
	                <!-- Nuevo curso -->
                    <div class="col-sm-6 text-right">
                        <button type="button" id="botonNuevoCompra" class="btn btn-primary mt-2" data-toggle="tooltip" data-placement="left" title="Nuevo Compra">
                            <span class="fa fa-plus"></span>
                            <span class="fa fa-user"></span>
                        </button>
                    </div>
	            	<?php //} ?>

	            </div>

	            <hr>

	            <div class="mt-4">

	            	<!-- Barra cargando -->
                    <?php include('secciones/barraCargando.php'); ?>

	                <!-- Tabla Compras -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col">
	                                    Codigo
	                                </th>
	                                <th scope="col">
	                                    Descripcion
	                                </th>
	                                <th scope="col">
	                                    Fecha de Registro
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

	        <!-- Nueva Compra -->
	        <div id="divNuevaCompra" style="display: block;">
	            
	            <div class="row mt-5">

	            	<!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Nueva Compra
	                    </h1>
	                </div>
	                
	                <!-- Volver al listado -->
	                <div class="col-md-6 text-right">
                        <button type="button" class="botonVolver btn btn-secondary mt-2">
                            <span class="fa fa-chevron-left"></span> 
                            Volver
                        </button>
                    </div>

	            </div>

	            <hr>

	            <form class="mt-4">
	                
	                <!-- Primera fila -->
	                <div class="form-row">
	                	<div class="form-group col-md-3">
	                        <label>
	                            Proveedor
	                        </label>
	                        
	                        <select class="form-control" name="nombres"></select> 
	                    </div>

	                    <div class="form-group col-md-3">
	                        <label>
	                            Tipo Comprobante
	                        </label>

	                        <select class="form-control" name="nombres"></select> 
	                    </div>
	                    <!-- Nombres -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Numero de Factura
	                        </label>
	                        <input type="text" class="form-control" name="nombres">
	                    </div>

	                </div>

	                <div class="form-row">    

	                    <!-- Apellidos -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Nº Orden de compra 
	                        </label>
	                        <input type="text" class="form-control" name="apellidos">
	                    </div>
	                    <div class="form-group col-md-3">
	                        <label>
	                            Fecha Orden de compra 
	                        </label>
	                        <input type="text" class="form-control" name="apellidos">
	                    </div>
	                    
	                </div>

	                <!-- Segunda fila -->
	                <div class="form-row">

	                	<!-- Compra -->
	                    <div class="form-group col-md-3">
	                        <label>
	                           Gatos de envio
	                        </label>
	                         <input type="text" class="form-control" name="compra">
	                    </div>

                        <!-- Clave -->
	                    <div class="form-group col-md-3">
	                        <label>
	                           IVA Gastos de envio
	                        </label>
	                         <input type="password" class="form-control" name="clave">
	                    </div>
	                    <div class="form-group col-md-3">
	                        <label>
	                           Impuestos Gatos de envio
	                        </label>
	                         <input type="text" class="form-control" name="compra">
	                    </div>


	                </div>

	                <!-- Botón confirmar -->
	                <button type="button" id="botonConfirmarNuevo" class="btn btn-primary mt-3">
	                    <span class="fa fa-check"></span> 
	                    Confirmar
	                </button>

	            </form>

	        </div>

	        <!-- Editar Compra -->
	        <div id="divEditarCompra" style="display: none;">
	        	
	        	<div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Editar Compra
	                    </h1>
	                </div>
	                
	                <!-- Volver al listado -->
	                <div class="col-md-6 text-right">
                        <button type="button" class="botonVolver btn btn-secondary mt-2">
                            <span class="fa fa-chevron-left"></span> 
                            Volver
                        </button>
                    </div>

	            </div>

	            <hr>

	            <form class="mt-4">
	                
	                <!-- Primera fila -->
	                <div class="form-row">
	                    
	                    <!-- Nombres -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Nombres
	                        </label>
	                        <input type="text" class="form-control" name="nombres">
	                    </div>

	                    <!-- Apellidos -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Apellidos
	                        </label>
	                        <input type="text" class="form-control" name="apellidos">
	                    </div>
	                    
	                </div>

	                <!-- Segunda fila -->
	                <div class="form-row">

	                	<!-- Compra -->
	                    <div class="form-group col-md-3">
	                        <label>
	                           Compra
	                        </label>
	                         <input type="text" class="form-control" name="compra">
	                    </div>

                        <!-- Clave -->
	                    <div class="form-group col-md-3">
	                        <label>
	                           Clave
	                        </label>
	                         <input type="password" class="form-control" name="clave">
	                    </div>

	                </div>
	                
	                <!-- Tercera fila -->
	                <div class="form-row">

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

	                <!-- Cuarta fila -->
	                <div class="form-row">

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