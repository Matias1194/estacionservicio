<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'permisos';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // Listado.
        if($accion == "listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $area, $modulo, $accion, $respuesta, true);
            $id_perfil = $_POST['id_perfil'] ? $_POST['id_perfil'] : 1;
            $id_modulo = $_POST['id_modulo'] ? $_POST['id_modulo'] : 1;
            $id_area = $_POST['id_area'] ? $_POST['id_area'] : 1;

            // Prepara la consulta.
            $query = "SELECT permisos.id as 'id_permiso', 
                             perfiles.descripcion as 'perfil',
                             areas.descripcion as 'area',
                             modulos.descripcion as 'modulo',
                             permisos.accion as 'permiso',
                             perfiles_permisos.habilitado

                      FROM perfiles_permisos
                      
                      LEFT OUTER JOIN perfiles
                        ON perfiles_permisos.id_perfil = perfiles.id
                      LEFT OUTER JOIN permisos
                        ON perfiles_permisos.id_permiso = permisos.id
                      LEFT OUTER JOIN modulos
                        ON permisos.id_modulo = modulos.id
                      LEFT OUTER JOIN areas
                        ON permisos.id_area = areas.id
                        
                      WHERE perfiles_permisos.id_perfil = $id_perfil
                        AND permisos.id_modulo = $id_modulo
                        AND permisos.id_area = $id_area";
            
            // Consulta los permisos.
            $permisos = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($permisos === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los permisos (L 44).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['permisos'] = $permisos;
            }
        }

        // Habilitar.
        else if($accion == "habilitar")
        {   
            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "UPDATE perfiles_permisos 
                        SET habilitado = 1 
                        WHERE id = $id LIMIT 1";

            // Actualiza la información del permiso.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al habilitar el permiso (L 139).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['id'] = $id;
            }
        }

        // Deshabilitar.
        else if($accion == "deshabilitar")
        {   
            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "UPDATE perfiles_permisos 
                        SET habilitado = 0 
                        WHERE id = $id LIMIT 1";
            
            // Actualiza la información del permiso.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al deshabilitar el permiso (L 166).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['id'] = $id;
            }
        }
        
        else
        {
            $respuesta['descripcion'] = "Accion no especificada.";
        }

        // Cierra la conexión a la base de datos.
        cerrarConexion($conexion);
    }
    else
    {
        $respuesta['descripcion'] = "No se enviaron datos.";
    }

    // Devuelve la respuesta.
    echo json_encode($respuesta);
?>