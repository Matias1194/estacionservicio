<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    	<!-- Título -->
        <title> Estación de Servicio - Permisos </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/permisos.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<div class="container">

			<!-- Listado de permisos-->
			<div id="listado" style="display:block">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
                            <span class="fa fa-key"></span>
                            Permisos
	                    </h1>
                    </div>

	            </div>

	            <hr>

	            <div class="mt-4">

	            	<!-- Barra cargando -->
                    <?php include('secciones/barraCargando.php'); ?>

                    <div class="row">
                    
                        <!-- Perfil -->
                        <div class="form-group col-md-3">
                            <label>
                                Perfil
                            </label>
                            <select class="form-control" name="id_perfil">
                                <option value="1" selected>Administrador</option>
                                <option value="2">Coordinador Playa</option>
                                <option value="3">Coordinador Mercado</option>
                                <option value="4">Playero</option>
                                <option value="5">Vendedor</option>
                            </select> 
                        </div>

                        <!-- Área -->
                        <div class="form-group col-md-3">
                            <label>
                                Área
                            </label>
                            <select class="form-control" name="id_area">
                                <option value="1" selected>Playa</option>
                                <option value="2">Mercado</option>
                            </select> 
                        </div>

                        <!-- Módulo -->
                        <div class="form-group col-md-3">
                            <label>
                                Módulo
                            </label>
                            <select class="form-control" name="id_modulo">
                                <option value="1" selected>Usuarios</option>
                                <option value="2">Permisos</option>
                                <option value="3">Caja</option>
                                <option value="4">Clientes</option>
                                <option value="5">Compras</option>
                                <option value="6">Productos</option>
                                <option value="7">Proveedores</option>
                                <option value="8">Stock</option>
                                <option value="9">Ventas</option>
                                <option value="10">Reportes</option>
                            </select> 
                        </div>
                    
                    </div>

	                <!-- Tabla Permisos -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark" style="width:100%">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col" class="ocultable">
	                                    id
	                                </th>
									<th scope="col" class="ocultable">
	                                    Perfil
	                                </th>
                                    <th scope="col" class="ocultable">
	                                    Área
	                                </th>
                                    <th scope="col" class="ocultable">
	                                    Módulo
	                                </th>
									<th scope="col">
	                                    Permisos
	                                </th>
	                                <th class="text-center">
	                                    Estado
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