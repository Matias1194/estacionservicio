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

					<!-- Botón Abrir Caja -->
					<div class="col-sm-2 pull-left">
						<button class="btn btn-lg btn-success" name="abrir_caja" style="display:none; width:100%; line-height: 5.0">
							<span class="fa fa-cash-register fa-5x mt-4"></span>
							ABRIR CAJA
						</button>
					</div>

					<!-- Botón Comenzar Turno -->
					<div class="col-sm-2 pull-left">
						<button class="btn btn-lg btn-success" name="comenzar_turno" style="display:none; width:100%; line-height: 5.0">
							<span class="fa fa-user fa-5x mt-4"></span>
							COM.&nbsp;TURNO
						</button>
					</div>

					<!-- Botón Ticket -->
					<div class="col-sm-2">
						<button class="btn btn-lg btn-primary" name="tickets" style="display:none; width:100%; line-height: 5.0">
							<span class="fa fa-receipt fa-5x mt-4"></span>
							TICKETS
						</button>
					</div>
	
					<!-- Botón Factura -->
					<div class="col-sm-2">
						<button class="btn btn-lg btn-info" name="factura" style="display:none; width:100%; line-height: 5.0">
							<span class="fa fa-file-invoice-dollar fa-5x mt-4"></span>
							FACTURA
						</button>
					</div>

					<!-- Botón Otros -->
					<div class="col-sm-2">
						<button class="btn btn-lg btn-secondary" name="otros" style="display:none; width:100%; line-height: 5.0">
							<span class="fa fa-exchange-alt fa-5x mt-4"></span>
							OTROS
						</button>
					</div>
					
					<!-- Botón Finalizar Turno -->
					<div class="col-sm-2">
						<button class="btn btn-lg btn-danger" name="finalizar_turno" style="display:none; width:100%; line-height: 5.0">
							<span class="fa fa-user fa-5x mt-4"></span>
							FIN.&nbsp;TURNO
						</button>
					</div>

					<!-- Botón Cerrar Caja -->
					<div class="col-sm-2">
						<button class="btn btn-lg btn-danger" name="cerrar_caja" style="display:none; width:100%; line-height: 5.0">
							<span class="fa fa-cash-register fa-5x mt-4"></span>
							CERRAR CAJA
						</button>
					</div>
				
				</div>

				<!-- Formulario -->
	            <form name="abrir_caja" class="mt-4" style="display:none">
						
					<!-- Primera fila -->
					<div class="form-row">

						<!-- Saldo -->
	                	<div class="form-group col-md-2">
	                        <label>
	                            Saldo
	                        </label>
	                        <input type="text" class="form-control" name="saldo" data-requerido></select> 
						</div>
					
					</div>

					<!-- Primera fila -->
					<div class="form-row">
					
						<!-- Botón confirmar -->
						<div class="form-group col-md-2">

							<button type="button" class="btn btn-success btn-block" name="confirmar">
								<span class="fa fa-check"></span> 
								Confirmar
							</button>
						</div>
					
					</div>

				</form>
					
				<!-- Formulario -->
				<form name="cerrar_caja" class="mt-4" style="display:none">
						
					<!-- Primera fila -->
					<div class="form-row">
	
						<!-- Saldo -->
						<div class="form-group col-md-2 offset-10">
							<label>
								Saldo
							</label>
							<input type="text" class="form-control" name="saldo" data-requerido></select> 
						</div>
					
					</div>
	
					<!-- Primera fila -->
					<div class="form-row">
					
						<!-- Botón confirmar -->
						<div class="form-group col-md-2 offset-10">
	
							<button type="button" class="btn btn-success btn-block" name="confirmar">
								<span class="fa fa-check"></span> 
								Confirmar
							</button>
						</div>
					
					</div>
				
				</form>

				<!-- Formulario -->
				<form name="otros" class="mt-4" style="display:none">
						
					<!-- Primera fila -->
					<div class="form-row">
	
						<!-- Concepto -->
						<div class="form-group col-md-2 offset-8">
							<label>
								Concepto
							</label>
							<select class="form-control" name="id_concepto" data-requerido></select> 
						</div>

					</div>

					<!-- Segunda fila -->
					<div class="form-row">

						<!-- Importe -->
						<div class="form-group col-md-2 offset-8">
							<label>
								Importe
							</label>
							<input type="text" class="form-control" name="importe" data-requerido></select> 
						</div>
					
					</div>
	
					<!-- Tercera fila -->
					<div class="form-row">
					
						<!-- Botón confirmar -->
						<div class="form-group col-md-2 offset-8">
	
							<button type="button" class="btn btn-success btn-block" name="confirmar">
								<span class="fa fa-check"></span> 
								Confirmar
							</button>
						</div>
					
					</div>
				
				</form>

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
								<input type="number" class="form-control" name="cantidad" min="0" step="1" placeholder="Cantidad">
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
							
							<table class="table table-striped table-dark" style="width:100%">
								
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
										<th class="text-center" scope="col">
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
			
			<!-- Nueva venta con Factura -->
	        <div id="factura" style="display:none">
	            
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

						<!-- Tipo Cliente -->
	                	<div class="form-group col-md-3">
							<label>
								Tipo Cliente
							</label>
							<select class="form-control" name="id_tipo_cliente" data-requerido></select> 
						</div>

						<!-- Clientes -->
	                	<div class="form-group col-md-3" style="display:none">
							<label>
								Clientes
							</label>
							<select class="form-control" name="id_cliente"></select> 
						</div>
	                	
					</div>

					<!-- Segunda fila -->
	                <div name="cliente_demostrador" class="form-row" style="display:none">

						<!-- Razón Social -->
	                	<div class="form-group col-md-2">
							<label>
								Razón Social
							</label>
							<input class="form-control" name="razon_social"></select> 
						</div>

						<!-- CUIT -->
	                	<div class="form-group col-md-2">
							<label>
								CUIT
							</label>
							<input class="form-control" name="cuit"></select> 
						</div>

						<!-- Domicilio -->
	                	<div class="form-group col-md-2">
							<label>
								Domicilio
							</label>
							<input class="form-control" name="domicilio"></select> 
						</div>

						<!-- Email -->
	                	<div class="form-group col-md-2">
							<label>
								Email
							</label>
							<input class="form-control" name="email"></select> 
						</div>

						<!-- Telefono -->
	                	<div class="form-group col-md-2">
							<label>
								Telefono
							</label>
							<input class="form-control" name="telefono"></select> 
						</div>
	                	
					</div>

					<hr>
				
					<!-- Tercera fila -->
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
					<div id="factura_divAgregarProductoNueva" class="form-inline">

						<div class="form-inline">
							
							<!-- Producto -->
							<div class="form-group mb-2">
								<select class="form-control" name="id_producto"></select> 
							</div>
							
							<!-- Cantidad -->
							<div class="form-group mx-sm-3 mb-2">
								<input type="number" class="form-control" name="cantidad" min="0" step="1" placeholder="Cantidad">
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
					<div id="factura_divProductosAgregadosNueva" class="mt-4">

						<!-- Tabla Subtotales -->
						<div class="table-responsive-xl">
							
							<table class="table table-striped table-dark" style="width:100%">
								
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
										<th class="text-center" scope="col">
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