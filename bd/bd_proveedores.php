<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'proveedores';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // BUSCAR: Listado de proveedores.
        if($accion == "buscar_listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM proveedores
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
            }
        }

        // BUSCAR: Detalles de proveedor por id.
        else if($accion == "buscar_detalles")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT proveedores.id, proveedores.nombres, proveedores.apellidos, DATE_FORMAT(proveedores.fecha_nacimiento, '%d/%m/%Y') as 'fecha_nacimiento', proveedores.ocupacion, tipo_nacionalidad.descripcion as 'nacionalidad_descripcion', tipo_estado_civil.descripcion as 'estado_civil_descripcion', tipo_documento.descripcion as 'tipo_documento_descripcion', proveedores.documento, proveedores.domicilio, proveedores.id_postal, proveedores.localidad, proveedores.provincia, proveedores.telefono_fijo, proveedores.telefono_celular, proveedores.email, proveedores.facebook, proveedores.instagram, DATE_FORMAT(proveedores.fecha_registro, '%d/%m/%Y') as 'fecha_registro' 
                      FROM proveedores 
                      INNER JOIN tipo_nacionalidad 
                        ON proveedores.id_nacionalidad = tipo_nacionalidad.id 
                      INNER JOIN tipo_estado_civil 
                        ON proveedores.id_estado_civil = tipo_estado_civil.id 
                      INNER JOIN tipo_documento 
                        ON proveedores.id_tipo_documento = tipo_documento.id 
                      WHERE proveedores.id = $id LIMIT 1";
            
            // Consulta los detalles de proveedor.
            $proveedor = consultar_registro($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($proveedor === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del proveedor (L 63).";
            }
            // Si la consulta fue exitosa y no se encuentra el proveedor.
            else if(empty($proveedor))
            {
                $respuesta['descripcion'] = "El proveedor no se encuentra.";
            }
            // Si la consulta fue exitosa y el proveedor se encuentra.
            else 
            {
                $respuesta['exito'] = true;
                $respuesta['proveedor'] = $proveedor;
            }
        }

        // NUEVO: Buscar información para crear proveedor.
        else if($accion == "nuevo_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            // Prepara la consulta.
            $query = "SELECT id, descripcion 
                      FROM tipo_nacionalidad";

            // Consulta los tipos de nacionalidades habilitados.
            $tipos_nacionalidades = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($tipos_nacionalidades === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de nacionalidades (L 151).";
            }
            // Si la consulta fue exitosa.
            else
            {
                // Prepara la consulta.
                $query = "SELECT id, descripcion 
                          FROM tipo_estado_civil";

                // Consulta los tipos de estados civiles habilitados.
                $tipos_estados_civiles = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($tipos_estados_civiles === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de estados civiles (L 166).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    // Prepara la consulta.
                    $query = "SELECT id, descripcion 
                              FROM tipo_documento";

                    // Consulta los tipos de documentos habilitados.
                    $tipos_documentos = consultar_listado($conexion, $query);

                    // Si hubo error ejecutando la consulta.
                    if($tipos_documentos === false)
                    {
                        $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de documentos (L 181).";
                    }
                    // Si la consulta fue exitosa.
                    else
                    {
                        $respuesta['exito'] = true;
                        $respuesta['tipos_nacionalidades'] = $tipos_nacionalidades;
                        $respuesta['tipos_estados_civiles'] = $tipos_estados_civiles;
                        $respuesta['tipos_documentos'] = $tipos_documentos;
                    }
                }
            }
        }

        // NUEVO: Confirmar nuevo proveedor.
        else if($accion == "nuevo_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nuevo_buscar", $respuesta, false);

            $proveedor = $_POST["proveedor"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM proveedores 
                      WHERE cuit = " .$proveedor["cuit"];

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
                $query = "INSERT INTO proveedores (razon_social, domicilio, telefono, email, cuit) "
                       . "VALUES"
                       . "("
                            . "'" . $proveedor['razon_social'] . "', "
                            . "'" . $proveedor["domicilio"] . "', "
                                  . $proveedor["telefono"] . ", "
                            . "'" . $proveedor["email"] . "', "
                                  . $proveedor["cuit"]
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
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM proveedores 
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
                $respuesta['exito'] = true;
                $respuesta['proveedor'] = $proveedor;
            }
        }

        // EDITAR: Confirmar edición de proveedor.
        else if($accion == "editar_confirmar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "editar_buscar", $respuesta, false);

            $proveedor = $_POST["proveedor"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM proveedores
                      WHERE proveedores.id = " . $proveedor['id'] . " LIMIT 1";

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
                $query = "UPDATE proveedores 
                          SET razon_social = '" . $proveedor['razon_social'] . "', 
                          domicilio = '" . $proveedor["domicilio"] . "', 
                          telefono = " . $proveedor['telefono'] . ",  
                          email = '" . $proveedor['email'] . "', 
                          cuit = " . $proveedor['cuit'] . " 
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
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM proveedores 
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
                $query = "UPDATE proveedores 
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
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM proveedores 
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
                $query = "UPDATE proveedores 
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
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM proveedores 
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
                $query = "UPDATE proveedores 
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