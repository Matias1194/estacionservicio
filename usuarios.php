<?php include('secciones/sesion.php') ?>

<!DOCTYPE html>
<html>
    
    <head>

    	<!-- Título -->
        <title> Estación de Servicio - Usuarios </title>
        
        <!-- Estilos -->
        <?php include('secciones/estilos.php'); ?>

        <!-- Scripts -->
        <?php include('secciones/scripts.php'); ?>
        <script src="js/usuarios.js"></script>
        
    </head>

	<body>

		<!-- Barra de Navegación -->
        <?php include('secciones/navegador.php'); ?>

        <!-- Alertas y Notificaciones -->
        <?php include('secciones/alertas.php'); ?>

		<!-- Contenido -->
		<main role="main" class="container">
			
			<!-- Listado de Usuarios -->
			<div id="divListadoUsuarios">

	            <div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-sm-6">
	                    <h1 class="font-weight-normal">
	                        Listado de Usuarios
	                    </h1>
	                </div>

	                <?php //if(tienePermiso(10)) { ?>
	                <!-- Nuevo curso -->
                    <div class="col-sm-6 text-right">
                        <button type="button" id="botonNuevoUsuario" class="btn btn-primary mt-2" data-toggle="tooltip" data-placement="left" title="Nuevo Usuario">
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

	                <!-- Tabla Usuarios -->
	                <div class="table-responsive-xl">
	                    
	                    <table class="table table-striped table-dark">
	                        
	                        <thead>
	                            <tr>
	                                <th scope="col">
	                                    Usuario
	                                </th>
	                                <th scope="col">
	                                    Perfíl
	                                </th>
	                                <th scope="col">
	                                    Nombres
	                                </th>
	                                <th scope="col">
	                                    Apellidos
	                                </th>
	                                <th scope="col">
	                                    Registro
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

	        <!-- Nuevo Usuario -->
	        <div id="divNuevoUsuario" style="display: none;">
	            
	            <div class="row mt-5">

	            	<!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Nuevo Usuario
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
	                    
	                    <!-- Perfíl -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Perfíl
	                        </label>
	                        <select id="comboTipoPerfilNuevo" class="form-control" name="id_perfil"> </select>
	                    </div>

	                	<!-- Usuario -->
	                    <div class="form-group col-md-2">
	                        <label>
	                           Usuario
	                        </label>
	                         <input type="text" class="form-control" name="usuario">
	                    </div>

                        <!-- Clave -->
	                    <div class="form-group col-md-2">
	                        <label>
	                           Clave
	                        </label>
	                         <input type="password" class="form-control" name="clave">
	                    </div>
	                    
	                </div>

	                <!-- Segunda fila -->
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
	                
	                <!-- Tercera fila -->
	                <div class="form-row">

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

	                <!-- Cuarta fila -->
	                <div class="form-row">

                    	<!-- Teléfono-->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Teléfono
	                        </label>
	                        <input type="text" class="form-control" name="telefono">
	                    </div>
                    	
	                    <!-- E-mail -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            E-mail
	                        </label>
	                        <input type="text" class="form-control" name="email">
	                    </div>

	                </div>

	                <!-- Botón confirmar -->
	                <button type="button" id="botonConfirmarNuevo" class="btn btn-primary mt-3">
	                    <span class="fa fa-check"></span> 
	                    Confirmar
	                </button>

	            </form>

	        </div>

	        <!-- Editar Usuario -->
	        <div id="divEditarUsuario" style="display: none;">
	        	
	        	<div class="row mt-5">
	                
	                <!-- Título -->
	                <div class="col-md-6">
	                    <h1 class="font-weight-normal">
	                        Editar Usuario
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
	                    
	                    <!-- Perfíl -->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Perfíl
	                        </label>
	                        <select id="comboTipoPerfilEditar" class="form-control" name="id_perfil"> </select>
	                    </div>

	                	<!-- Usuario -->
	                    <div class="form-group col-md-2">
	                        <label>
	                           Usuario
	                        </label>
	                         <input type="text" class="form-control" name="usuario">
	                    </div>

                        <!-- Clave -->
	                    <div class="form-group col-md-2">
	                        <label>
	                           Clave
	                        </label>
	                         <input type="password" class="form-control" name="clave">
	                    </div>
	                    
	                </div>

	                <!-- Segunda fila -->
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

                    	<!-- Teléfono-->
	                    <div class="form-group col-md-2">
	                        <label>
	                            Teléfono
	                        </label>
	                        <input type="text" class="form-control" name="telefono">
	                    </div>
                    	
	                    <!-- E-mail -->
	                    <div class="form-group col-md-3">
	                        <label>
	                            E-mail
	                        </label>
	                        <input type="text" class="form-control" name="email">
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