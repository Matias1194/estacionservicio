<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'playa_proveedores';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $area = $_POST['area'];
        $modulo = 7;
        $accion = $_POST['accion'];

        // BUSCAR: Listado de proveedores.
        if($accion == "listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_proveedores
                      WHERE eliminado = 0";

            // Consulta el listado de proveedores.
            $proveedores = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($proveedores === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de proveedores (L 31).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['proveedores'] = $proveedores;
                $respuesta['permisos'] = $_SESSION['usuario']->permisos;
            }
        }
        
        // NUEVO: Buscar información para crear proveedor.
        else if($accion == "nuevo_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            // Prepara la consulta.
            $query = "SELECT id, descripcion 
                      FROM tipos_documentos
                      WHERE habilitado = 1";

            // Consulta los tipos de documentos habilitados.
            $tipos_documentos = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($tipos_documentos === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de documentos (L 104).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['tipos_documentos'] = $tipos_documentos;
            }
        }

        // NUEVO: Confirmar nuevo proveedor.
        else if($accion == "nuevo_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, "nuevo_buscar", $respuesta, false);

            $proveedor = $_POST["proveedor"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_proveedores 
                      WHERE documento = " .$proveedor["documento"];

            // Consulta si existe un proveedor con mismo número de cuit antes de insertarlo.
            $proveedorDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($proveedorDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al guardar nuevo proveedor (L 211).";
            }
            // Si la consulta fue exitosa y ya existe el proveedor.
            else if(!empty($proveedorDB))
            {
                $respuesta['descripcion'] = "El proveedor ingresado ya se encuentra registrado.";
            }
            // Si la consulta fue exitosa y no existe el nombre de proveedor.
            else
            {
                // Prepara la consulta.
                $query = "INSERT INTO playa_proveedores (razon_social, id_tipo_documento, documento, sucursal, pais, provincia, localidad, calle, email, telefono) "
                       . "VALUES"
                       . "("
                            . "'" . $proveedor['razon_social'] . "', "
                                  . $proveedor["id_tipo_documento"] . ", "
                                  . $proveedor["documento"] . ", "
                            . "'" . $proveedor["sucursal"] . "', "
                            . "'" . $proveedor["pais"] . "', "
                            . "'" . $proveedor["provincia"] . "', "
                            . "'" . $proveedor["localidad"] . "', "
                            . "'" . $proveedor["calle"] . "', "
                            . "'" . $proveedor["email"] . "', "
                                  . $proveedor["telefono"]
                       . ")";
                
                // Inserta un nuevo proveedor.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al guardar nuevo proveedor (L 252).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $proveedor["razon_social"] . "</b> se agregó correctamente a Proveedores.";
                }
            }
        }
        
        // EDITAR: Buscar información para editar proveedor.
        else if($accion == "editar_buscar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_proveedores 
                      WHERE id = $id LIMIT 1";
            
            // Consulta información del proveedor a editar.
            $proveedor = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($proveedor === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de proveedor (L 279).";
            }
            // Si la consulta fue exitosa y no existe el proveedor.
            else if(empty($proveedor))
            {
                $respuesta['descripcion'] = "El proveedor buscado no existe.";
            }
            // Si la consulta fue exitosa y existe el proveedor.
            else
            {
                // Prepara la consulta.
                $query = "SELECT id, descripcion 
                          FROM tipos_documentos
                          WHERE habilitado = 1";

                // Consulta los tipos de documentos habilitados.
                $tipos_documentos = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($tipos_documentos === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de documentos (L 104).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['proveedor'] = $proveedor;
                    $respuesta['tipos_documentos'] = $tipos_documentos;
                }
            }
        }

        // EDITAR: Confirmar edición de proveedor.
        else if($accion == "editar_confirmar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, "editar_buscar", $respuesta, false);

            $proveedor = $_POST["proveedor"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_proveedores
                      WHERE id = " . $proveedor['id'] . " LIMIT 1";

            // Consulta información del proveedor a editar.
            $proveedorDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($proveedorDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información del proveedor (L 361).";
            }
            // Si la consulta fue exitosa y no existe el proveedor.
            else if(empty($proveedorDB))
            {
                $respuesta['descripcion'] = "El proveedor que se intenta editar no existe.";
            }
            // Si la consulta fue exitosa y existe el proveedor.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE playa_proveedores 
                          SET razon_social = '" . $proveedor['razon_social'] . "', 
                          id_tipo_documento = " . $proveedor['id_tipo_documento'] . ", 
                          documento = " . $proveedor['documento'] . ", 
                          sucursal = '" . $proveedor["sucursal"] . "', 
                          pais = '" . $proveedor["pais"] . "', 
                          provincia = '" . $proveedor["provincia"] . "', 
                          localidad = '" . $proveedor["localidad"] . "', 
                          calle = '" . $proveedor["calle"] . "', 
                          email = '" . $proveedor['email'] . "', 
                          telefono = " . $proveedor['telefono'] . "  
                          WHERE id = " . $proveedor['id'];
                
                // Actualizo la información del proveedor.
                $resultado = ejecutar($conexion, $query);
                
                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al editar proveedor (L 400).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $proveedor['razon_social'] . "</b> se editó correctamente.";
                }
            }
        }

        // ELIMINAR: Confirmar eliminación de proveedor.
        else if($accion == "eliminar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_proveedores 
                      WHERE id = $id LIMIT 1";

            // Consulta información del proveedor a eliminar.
            $proveedorDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($proveedorDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de proveedor (L 427).";
            }
            // Si la consulta fue exitosa y no existe el proveedor.
            else if(empty($proveedorDB))
            {
                $respuesta['descripcion'] = "El proveedor que se intenta eliminar no existe.";
            }
            // Si la consulta fue exitosa y existe el proveedor.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE playa_proveedores 
                          SET eliminado = 1 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del proveedor.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al eliminar proveedor (L 448).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Proveedor eliminado correctamente.";
                }
            }
        }

        // DESHABILITAR: Confirmar deshabilitación de proveedor.
        else if($accion == "deshabilitar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_proveedores 
                      WHERE id = $id LIMIT 1";

            // Consulta información del proveedor a deshabilitar.
            $proveedorDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($proveedorDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de proveedor (L 476).";
            }
            // Si la consulta fue exitosa y no existe el proveedor.
            else if(empty($proveedorDB))
            {
                $respuesta['descripcion'] = "El proveedor que se intenta deshabilitar no existe.";
            }
            // Si la consulta fue exitosa y existe el proveedor.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE playa_proveedores 
                          SET habilitado = 0 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del proveedor.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al deshabilitar proveedor (L 497).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Proveedor deshabilitado correctamente.";
                }
            }
        }

        // HABILITAR: Confirmar habilitación de proveedor.
        else if($accion == "habilitar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_proveedores 
                      WHERE id = $id LIMIT 1";

            // Consulta información del proveedor a habilitar.
            $proveedorDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($proveedorDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de proveedor (L 525).";
            }
            // Si la consulta fue exitosa y no existe el proveedor.
            else if(empty($proveedorDB))
            {
                $respuesta['descripcion'] = "El proveedor que se intenta habilitar no existe.";
            }
            // Si la consulta fue exitosa y existe el proveedor.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE playa_proveedores 
                          SET habilitado = 1 
                          WHERE id = $id";

                // Actualiza la información del proveedor.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al habilitar proveedor (L 546).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Proveedor habilitado correctamente.";
                }
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