<?php
	function abrirConexion()
	{
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "";
		$db = "estacion_servicio";
		$conexion = new mysqli($dbhost, $dbuser, $dbpass, $db);

		if(!$conexion)
		{
			die("ERROR de conexión: No se pudo conectar. " . $conexion->connect_error);
		}

		mysqli_set_charset($conexion, "utf8");

		return $conexion;
	}

	function cerrarConexion($conexion)
	{
		$conexion->close();
	}

	function consultar_listado($conexion, $query)
	{
		if ($resultados = $conexion->query($query))
        {
            $listado = array();
            while($fila = $resultados->fetch_assoc()) 
            {
                $listado[] = $fila;
            }
            
            $resultados->free();

            return $listado;
        }

        return false;
	}

	function consultar_registro($conexion, $query)
	{
		if ($resultado = $conexion->query($query))
        {
            $registro = $resultado->fetch_object();
            
            $resultado->free();

            return $registro;
        }

        return false;
	}

	function ejecutar($conexion, $query)
	{
		if ($conexion->query($query) === true)
        {
            return true;
        }
        return false;
	}

	function validarPermiso($conexion, $area, $modulo, $accion, $respuesta, $redireccionar)
	{
		if(!tienePermiso($conexion, $area, $modulo, $accion, $respuesta))
        {
            $respuesta['descripcion'] = "No tiene permiso para realizar esa acción.";
        	$respuesta['redireccionar'] = $redireccionar;
            
            // Devuelve la respuesta.
            echo json_encode($respuesta);
            exit;
        }
	}

	function tienePermiso($conexion, $area, $modulo, $accion, $respuesta)
	{
		// Prepara la consulta.
        $query = "SELECT * 
                  
                  FROM perfiles_permisos 
                  
                  INNER JOIN permisos
                    ON perfiles_permisos.id_permiso = permisos.id
                  INNER JOIN modulos
                    ON permisos.id_modulo = modulos.id
                  INNER JOIN areas
                    ON permisos.id_area = areas.id
                  
                  WHERE perfiles_permisos.habilitado = 1 
                    AND permisos.accion = '$accion'
                    AND perfiles_permisos.id_perfil = " . $_SESSION['usuario']->id_perfil . " 
                    LIMIT 1";
        
        // Consulta el permiso.
        $permiso = consultar_registro($conexion, $query);

        // Si hubo error ejecutando la consulta.
        if($permiso === false)
        {
            $respuesta['descripcion'] = 'Ocurrió un error al buscar el permiso (L 98). ' . $query;
            // Devuelve la respuesta.
            echo json_encode($respuesta);
            exit;
        }
        // Si la consulta fue exitosa y el permiso no se encuentra.
        else if(empty($permiso))
        {
            return false;
        }
        // Si la consulta fue exitosa y el permiso se encuentra.
        else 
        {
            return true;
        }
	}
?>