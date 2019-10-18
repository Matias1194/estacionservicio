<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    	<!-- Título -->
        <title> Estación de Servicio - Stock </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/stock.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<div class="container">

			<!-- Listado de stock-->
			<div id="listado" style="display:none">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
	                        Listado de Stock
	                    </h1>
                    </div>
                    
                    <!-- Descargar PDF -->
	                <div class="col-md-6 text-right">
                        <button class="btn btn-success mt-2" name="descargar">
                            <span class="fa fa-file-pdf"></span>
                            Descargar
                        </button>
                    </div>

	            </div>

	            <hr>

	            <div class="mt-4">

	            	<!-- Barra cargando -->
                    <?php include('secciones/barraCargando.php'); ?>

	                <!-- Tabla Stock -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col">
	                                    Código
	                                </th>
									<th scope="col">
	                                    Producto
	                                </th>
									<th scope="col">
	                                    Unidades
	                                </th>
	                                <!--<th class="text-center">
	                                    Acciones
	                                </th>-->
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
                            Información de la compra
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

						<label class="col-sm-4 col-form-label" data-label="fecha_compra">
                            Fecha compra: <b></b>
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
                        
						<label class="col-sm-4 col-form-label" data-label="orden_compra_numero">
                            N° Orden de compra: <b></b>
                        </label>
                        
						<label class="col-sm-4 col-form-label" data-label="orden_compra_fecha">
                            Fecha Orden de compra: <b></b>
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

            </div>

       	</div>

		<!-- Footer -->
		<?php include('secciones/footer.php'); ?>

	</body>
	
</html>