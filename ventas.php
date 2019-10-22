<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    	<!-- Título -->
        <title> Estación de Servicio - Ventas </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/ventas.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<div class="container">
			
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

	            <div class="row mt-5 text-center">

                    <!-- Botón Tickets -->
                    <div class="col-sm-3">
                        <button class="btn btn-lg btn-primary" name="tickets">
                            <span class="fa fa-receipt fa-lg"></span>
                            Tickets
                        </button>
                    </div>
                
                </div>

			</div>

			<!-- Nueva venta con tickets -->
	        <div id="tickets" style="display:none">
	            
				<!-- Encabezado -->
	            <div class="row mt-5">

	            	<!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Nueva Venta
	                    </h1>
	                </div>
					<!-- Descargar PDF -->
	                <div class="col-md-3 text-right">
                        <button class="btn btn-success mt-2" name="descargar">
                            <span class="fa fa-file-pdf"></span>
                            Descargar
                        </button>
                    </div>
	                
	                <!-- Botón volver -->
	                <div class="col-md-3 text-right">
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

						<!-- Tipo pago -->
	                	<div class="form-group col-md-3">
							<label>
								Tipo Pago
							</label>
							<select class="form-control" name="id_tipo_pago" data-requerido></select> 
						</div>
	                	
					</div>

					<!-- Cuerpo de la venta -->
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
							<input type="hidden" class="form-control" name="precio_unitario">
							
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
						Confirmar Venta
					</button>
					
				</form>

	        </div>
            
		</div>

		<!-- Footer -->
		<?php include('secciones/footer.php'); ?>

	</body>
	
</html>