<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    	<!-- Título -->
        <title> Estación de Servicio - Productos </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/productos.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<div class="container">

			<!-- Listado de productos-->
			<div id="listado" style="display:none">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
	                        Listado de Productos
	                    </h1>
                    </div>
                    
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-primary mt-2" name="nuevo" data-toggle="tooltip" data-placement="left" title="Nuevo Producto">
                            <span class="fa fa-plus"></span>
                            <span class="fa fa-box fa-lg"></span>
                        </button>
                    </div>

	            </div>

	            <hr>

	            <div class="mt-4">

	            	<!-- Barra cargando -->
                    <?php include('secciones/barraCargando.php'); ?>

	                <!-- Tabla Productos -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark" style="width: 100%">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col">
	                                    Código
	                                </th>
									<th scope="col">
	                                    Descripción
	                                </th>
									<th scope="col">
	                                    Tipo Producto
	                                </th>
	                                <th class="text-center" scope="col" colspan="4" style="width: 20%">
	                                    Acciones
	                                </th>
	                            </tr>
	                        </thead>

	                        <tbody></tbody>
	                    
	                    </table>

	                </div>

	            </div>

	        </div>

			<!-- Detalles -->
            <div id="detalles" style="display:none">
                
				<div class="row mt-5">
                    
					<div class="col-sm-6">
                        <h1 class="font-weight-normal">
                            Detalles
                        </h1>
                    </div>
                    
					<!-- Volver al listado -->
	                <div class="col-md-6 text-right">
                        <button class="btn btn-secondary mt-2" name="volver">
                            <span class="fa fa-chevron-left"></span> 
                            Volver
                        </button>
                    </div>

                </div>

                <!-- Información -->
                <div class="row mt-2">
                    <div class="col-sm-6">
                        <h3 class="font-weight-normal">
                            Información de la producto
                        </h3>
                    </div>
                </div>
                
                <form>

                    <div class="row">

                        <label class="col-sm-4 col-form-label" data-label="detalle">
                            Detalle: <b></b>
                        </label>

						<label class="col-sm-4 col-form-label" data-label="importe_total">
                            Importe total: $ <b></b>
                        </label>

						<label class="col-sm-4 col-form-label" data-label="fecha_producto">
                            Fecha producto: <b></b>
                        </label>

                    </div>

                    <div class="row">
                        
						<label class="col-sm-4 col-form-label" data-label="proveedor">
                            Proveedor: <b></b>
                        </label>
                        
						<label class="col-sm-4 col-form-label" data-label="tipo_comprobante">
                            Tipo Comprobante: <b></b>
                        </label>
						
						<label class="col-sm-4 col-form-label" data-label="numero_factura">
                            N° Factura: <b></b>
                        </label>

                    </div>

                    <div class="row">
                        
						<label class="col-sm-4 col-form-label" data-label="orden_producto_numero">
                            N° Orden de producto: <b></b>
                        </label>
                        
						<label class="col-sm-4 col-form-label" data-label="orden_producto_fecha">
                            Fecha Orden de producto: <b></b>
                        </label>
                    
					</div>

                    <div class="row">
                        
						<label class="col-sm-4 col-form-label" data-label="gastos_envio">
                            Gastos envío: $ <b></b>
                        </label>
                        
						<label class="col-sm-4 col-form-label" data-label="gastos_envio_iva">
							Gastos envío IVA: $ <b></b>
                        </label>

						<label class="col-sm-4 col-form-label" data-label="gastos_envio_impuestos">
							Gastos envío impuestos: $ <b></b>
                        </label>

                    </div>
					
                </form>

                <hr>

                <!-- Cursos inscriptos -->
                <div id="divCursosInscriptos">

                    <div class="row">
                        
                        <!-- Título -->
                        <div class="col-sm-6">
                            <h3 class="font-weight-normal">
                                Detalles de producto
                            </h3>
                        </div>
                    </div>

                    <!-- Tabla cursos inscriptos -->
                    <div class="table-responsive-xl mt-2">
                        
                        <table class="table table-striped table-dark" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        Descripción
                                    </th>
                                    <th scope="col">
                                        Cantidad
                                    </th>
									<th scope="col">
                                        Precio unitario
                                    </th>
                                    <th scope="col">
                                        Precio total
                                    </th>
                                </tr>
                            </thead>

                            <tbody></tbody>

                        </table>

                    </div>

                </div>

            </div>

	        <!-- Nuevo producto -->
	        <div id="nuevo" style="display:none">
	            
				<!-- Encabezado -->
	            <div class="row mt-5">

	            	<!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Nuevo producto
	                    </h1>
	                </div>
	                
	                <!-- Botón volver -->
	                <div class="col-md-6 text-right">
                        <button class="btn btn-secondary mt-2" name="volver">
                            <span class="fa fa-chevron-left"></span> 
                            Volver
                        </button>
                    </div>

	            </div>

	            <hr>

	            <!-- Formulario -->
	            <form class="mt-4">
	                
	                <!-- Primera fila -->
	                <div class="form-row">

	                	<!-- Proveedor -->
	                	<div class="form-group col-md-3">
	                        <label>
	                            Tipo Producto
	                        </label>
	                        <select class="form-control" name="id_tipo_producto" data-requerido></select> 
	                    </div>

	                    <!-- Tipo Comprobante -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Descripción
	                        </label>
	                        <input type="text" class="form-control" name="descripcion" data-requerido></select> 
	                    </div>

                    </div>
                    
					<!-- Botón confirmar -->
					<button type="button" class="btn btn-primary mt-3" name="confirmar">
						<span class="fa fa-check"></span> 
						Confirmar
					</button>
					
				</form>

	        </div>

			<!-- Editar producto -->
	        <div id="editar" style="display:none">
	            
				<!-- Encabezado -->
	            <div class="row mt-5">

	            	<!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Editar producto
	                    </h1>
	                </div>
	                
	                <!-- Botón volver -->
	                <div class="col-md-6 text-right">
                        <button class="btn btn-secondary mt-2" name="volver" data-pantalla="inicio">
                            <span class="fa fa-chevron-left"></span> 
                            Volver
                        </button>
                    </div>

	            </div>

	            <hr>

	            <!-- Formulario -->
	            <form class="mt-4">
	                
	                <!-- Primera fila -->
	                <div class="form-row">

	                	<!-- Proveedor -->
	                	<div class="form-group col-md-3">
	                        <label>
	                            Tipo Producto
	                        </label>
	                        <select class="form-control" name="id_tipo_producto" data-requerido></select> 
	                    </div>

	                    <!-- Tipo Comprobante -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Descripción
	                        </label>
	                        <select class="form-control" name="descripcion" data-requerido></select> 
	                    </div>

                    </div>
                    
					<input type="hidden" name="id" data-requerido>

					<!-- Botón confirmar -->
					<button type="button" class="btn btn-primary mt-3" name="confirmar">
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