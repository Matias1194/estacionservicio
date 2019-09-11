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

        <!-- Alertas -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<main role="main" class="container">
			
			<!-- Inicio -->
			<div id="inicio">
				
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
                        <button class="btn btn-lg btn-primary mt-2" name="consultar">
                            <span class="fa fa-search"></span>
                            Consultar
                        </button>
                    </div>

                    <!-- Botón Nueva Compra -->
                    <div class="col-sm-3 text-center">
                        <button class="btn btn-lg btn-primary mt-2" name="nueva">
                            <span class="fa fa-shopping-cart"></span>
                            Nueva Compra
                        </button>
                    </div>
                
                </div>

			</div>

			<!-- Listado de compras-->
			<div id="listado" style="display:none">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
	                        Listado de Compras
	                    </h1>
	                </div>

	                <!-- Volver al listado -->
	                <div class="col-md-6 text-right">
                        <button class="btn btn-secondary mt-2" name="volver" data-pantalla="inicio">
                            <span class="fa fa-chevron-left"></span> 
                            Volver
                        </button>
                    </div>

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
	                                    Detalle
	                                </th>
									<th scope="col">
	                                    Proveedor
	                                </th>
									<th scope="col">
	                                    Importe
	                                </th>
	                                <th scope="col">
	                                    Fecha
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

	        <!-- Nueva compra -->
	        <div id="nueva" style="display:none">
	            
				<!-- Encabezado -->
	            <div class="row mt-5">

	            	<!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Nueva Compra
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
	                
	            	<!-- Cabecera de la compra -->

					<!-- Primera fila -->
	                <div class="form-row">

	                	<!-- Detalle -->
	                	<div class="form-group col-md-6">
	                        <label>
	                            Detalle
	                        </label>
	                        <input type="text" class="form-control" name="detalle" data-requerido></select> 
	                    </div>

					</div>

	                <!-- Segunda fila -->
	                <div class="form-row">

	                	<!-- Proveedor -->
	                	<div class="form-group col-md-3">
	                        <label>
	                            Proveedor
	                        </label>
	                        <select class="form-control" name="id_proveedor" data-requerido></select> 
	                    </div>

	                    <!-- Tipo Comprobante -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Tipo Comprobante
	                        </label>
	                        <select class="form-control" name="id_tipo_comprobante" data-requerido></select> 
	                    </div>

	                    <!-- N° de Factura -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            N° de Factura
	                        </label>
	                        <input type="number" class="form-control" name="numero_factura" min="0" data-requerido>
	                    </div>

	                </div>

	                <!-- Tercera fila -->
	                <div class="form-row">

	                    <!-- N° Orden de compra -->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	Nº Orden de compra
	                        </label>
	                        <input type="number" class="form-control" name="orden_compra_numero" min="0" data-requerido>
	                    </div>

	                    <!-- Fecha Orden de compra -->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	Fecha Orden de compra
	                        </label>
	                        <input type="text" class="form-control" name="orden_compra_fecha" data-requerido>
	                    </div>
	                    
	                </div>

	                <!-- Cuarta fila -->
	                <div class="form-row">

	                	<!-- Gastos de envío -->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	Gastos de envío
	                        </label>
	                         <input type="number" class="form-control" name="gastos_envio" min="0" step=".01" data-requerido>
	                    </div>

                        <!-- % de IVA en gastos de envío-->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	% IVA Gastos de envío
	                        </label>
	                        <input type="number" class="form-control" name="gastos_envio_iva" min="0" max="100" step=".01" data-requerido>
	                    </div>

	                    <!-- Impuestos en gastos de envío -->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	Impuestos Gastos de envío
	                        </label>
	                        <input type="number" class="form-control" name="gastos_envio_impuestos" min="0" step=".01" data-requerido>
	                    </div>

	                </div>

					<hr>

					<!-- Cuerpo de la compra -->
					<div id="divAgregarProductoNueva" class="form-inline">

						<div class="form-inline">
							
							<!-- Producto -->
							<div class="form-group mb-2">
								<select class="form-control" name="id_producto"></select> 
							</div>
							
							<!-- Cantidad -->
							<div class="form-group mx-sm-3 mb-2">
								<input type="number" class="form-control" name="cantidad" min="0" step=".01" placeholder="Cantidad">
							</div>

							<!-- Precio unitario-->
							<div class="form-group mb-2">
								<input type="number" class="form-control" name="precio_unitario" min="0" step=".01" placeholder="Precio unitario">
							</div>
							
							<!-- Botón agregar producto -->
							<button type="button" class="btn btn-primary mx-sm-3 mb-2" name="agregar-producto" data-toggle="tooltip" data-placement="top" title="Agregar Producto">
								<span class="fas fa-cart-plus"></span>
							</button>

						</div>

					</div>

					<!-- Productos agregados -->
					<div id="divProductosAgregadosNueva" class="mt-4">

						<!-- Tabla Subtotales -->
						<div class="table-responsive-xl">
							
							<table class="table table-striped table-dark">
								
								<thead>
									<tr>
										<th scope="col">
											Codigo
										</th>
										<th scope="col">
											Descripción
										</th>
										<th scope="col">
											Cantidad
										</th>
										<th scope="col">
											Precio Unitario
										</th>
										<th scope="col">
											Precio Total
										</th>
										<th class="text-center" scope="col" colspan="4">
											Acciones
										</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td class="text-center" colspan="6">
											No se ingresaron productos
										</td>
									</tr>
								</tbody>
							
							</table>

						</div>

						<!-- Quinta fila -->
						<div class="form-row">

							<!-- Importe total -->
							<div class="form-group col-md-3">
								<label>
								Importe total
								</label>
								<input type="text" class="form-control" name="importe_total" data-requerido readonly>
							</div>

						</div>

					</div>

					<!-- Botón confirmar -->
					<button type="button" class="btn btn-primary mt-3" name="confirmar">
						<span class="fa fa-check"></span> 
						Confirmar Compra
					</button>
					
				</form>

	        </div>

	        <!-- Editar compra -->
	        <div id="editar" style="display:none">
	        	
	        	<div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Editar Compra
	                    </h1>
	                </div>
	                
	                <!-- Volver al listado -->
	                <div class="col-md-6 text-right">
                        <button class="btn btn-secondary mt-2" name="volver" data-pantalla="listado">
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
	                            Proveedor
	                        </label>
	                        <select id="comboProveedoresEditar" class="form-control" name="id_proveedor"></select> 
	                    </div>

	                    <!-- Tipo Comprobante -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            Tipo Comprobante
	                        </label>
	                        <select id="comboTipoComprobanteEditar" class="form-control" name="id_tipo_comprobante"></select> 
	                    </div>

	                    <!-- N° de Factura -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            N° de Factura
	                        </label>
	                        <input type="text" class="form-control" name="numero_factura">
	                    </div>

	                </div>

	                <!-- Segunda fila -->
	                <div class="form-row">

	                    <!-- N° Orden de compra -->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	Nº Orden de compra
	                        </label>
	                        <input type="text" class="form-control" name="orden_compra_numero">
	                    </div>

	                    <!-- Fecha Orden de compra -->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	Fecha Orden de compra
	                        </label>
	                        <input type="text" class="form-control" name="orden_compra_fecha">
	                    </div>
	                    
	                </div>

	                <!-- Tercera fila -->
	                <div class="form-row">

	                	<!-- Gastos de envío -->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	Gastos de envío
	                        </label>
	                         <input type="text" class="form-control" name="gastos_envio">
	                    </div>

                        <!-- % de IVA en gastos de envío-->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	% IVA Gastos de envio
	                        </label>
	                        <input type="password" class="form-control" name="gastos_envio_iva">
	                    </div>

	                    <!-- Impuestos en gastos de envío -->
	                    <div class="form-group col-md-3">
	                        <label>
	                        	Impuestos Gastos de envio
	                        </label>
	                        <input type="text" class="form-control" name="gastos_envio_impuestos">
	                    </div>

	                </div>

	                <input type="hidden" name="id">

	                <!-- Botón confirmar -->
	                <button id="botonConfirmarEditar" class="btn btn-primary mt-3">
	                    <span class="fa fa-check"></span> 
	                    Confirmar
	                </button>

	            </form>

	        </div>

       	</main>

		<!-- Footer -->
		<?php include('secciones/footer.php'); ?>

	</body>
	
</html>