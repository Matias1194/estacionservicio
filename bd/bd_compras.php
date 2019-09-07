<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'compras';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // BUSCAR: Listado de compras.
        if($accion == "buscar_listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM compras
                      WHERE eliminado = 0";

            // Consulta el listado de compras.
            $compras = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($compras === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de compras (L 37).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['compras'] = $compras;
            }
        }

        // BUSCAR: Detalles de compra por id.
        else if($accion == "buscar_detalles")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT compras.id, compras.nombres, compras.apellidos, DATE_FORMAT(compras.fecha_nacimiento, '%d/%m/%Y') as 'fecha_nacimiento', compras.ocupacion, tipo_nacionalidad.descripcion as 'nacionalidad_descripcion', tipo_estado_civil.descripcion as 'estado_civil_descripcion', tipo_documento.descripcion as 'tipo_documento_descripcion', compras.documento, compras.domicilio, compras.id_postal, compras.localidad, compras.provincia, compras.telefono_fijo, compras.telefono_celular, compras.email, compras.facebook, compras.instagram, DATE_FORMAT(compras.fecha_registro, '%d/%m/%Y') as 'fecha_registro' 
                      FROM compras 
                      INNER JOIN tipo_nacionalidad 
                        ON compras.id_nacionalidad = tipo_nacionalidad.id 
                      INNER JOIN tipo_estado_civil 
                        ON compras.id_estado_civil = tipo_estado_civil.id 
                      INNER JOIN tipo_documento 
                        ON compras.id_tipo_documento = tipo_documento.id 
                      WHERE compras.id = $id LIMIT 1";
            
            // Consulta los detalles de compra.
            $compra = consultar_registro($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($compra === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del compra (L 63).";
            }
            // Si la consulta fue exitosa y no se encuentra el compra.
            else if(empty($compra))
            {
                $respuesta['descripcion'] = "El compra no se encuentra.";
            }
            // Si la consulta fue exitosa y el compra se encuentra.
            else 
            {
                $respuesta['exito'] = true;
                $respuesta['compra'] = $compra;
            }
        }

        // NUEVO: Buscar información para crear compra.
        else if($accion == "nueva_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            // Prepara la consulta.
            $query = "SELECT id, razon_social 
                      FROM proveedores
                      WHERE habilitado = 1";

            // Consulta los tipos de proveedores habilitados.
            $proveedores = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($proveedores === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los proveedores (L 104).";
            }
            // Si la consulta fue exitosa.
            else
            {
                // Prepara la consulta.
                $query = "SELECT id, descripcion 
                          FROM tipos_comprobantes
                          WHERE habilitado = 1";

                // Consulta los tipos de comprobantes habilitados.
                $tipos_comprobantes = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($tipos_comprobantes === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de comprobantes (L 120).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    // Prepara la consulta.
                    $query = "SELECT id, descripcion 
                              FROM productos
                              WHERE habilitado = 1";

                    // Consulta los tipos de productos habilitados.
                    $productos = consultar_listado($conexion, $query);

                    // Si hubo error ejecutando la consulta.
                    if($productos === false)
                    {
                        $respuesta['descripcion'] = "Ocurrió un error al buscar los productos (L 136).";
                    }
                    // Si la consulta fue exitosa.
                    else
                    {
                        $respuesta['exito'] = true;
                        $respuesta['proveedores'] = $proveedores;
                        $respuesta['tipos_comprobantes'] = $tipos_comprobantes;
                        $respuesta['productos'] = $productos;
                    }
                }
            }
        }

        // NUEVO: Confirmar nueva compra.
        else if($accion == "nueva_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nueva_buscar", $respuesta, false);

            $compra = $_POST["compra"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM compras 
                      WHERE documento = " .$compra["documento"];

            // Consulta si existe un compra con mismo número de cuit antes de insertarlo.
            $compraDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($compraDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al guardar nueva compra (L 211).";
            }
            // Si la consulta fue exitosa y ya existe el compra.
            else if(!empty($compraDB))
            {
                $respuesta['descripcion'] = "El compra ingresado ya se encuentra registrado.";
            }
            // Si la consulta fue exitosa y no existe el nombre de compra.
            else
            {
                // Prepara la consulta.
                $query = "INSERT INTO compras (razon_social, id_tipo_documento, documento, sucursal, pais, provincia, localidad, calle, email, telefono) "
                       . "VALUES"
                       . "("
                            . "'" . $compra['razon_social'] . "', "
                                  . $compra["id_tipo_documento"] . ", "
                                  . $compra["documento"] . ", "
                            . "'" . $compra["sucursal"] . "', "
                            . "'" . $compra["pais"] . "', "
                            . "'" . $compra["provincia"] . "', "
                            . "'" . $compra["localidad"] . "', "
                            . "'" . $compra["calle"] . "', "
                            . "'" . $compra["email"] . "', "
                                  . $compra["telefono"]
                       . ")";
                
                // Inserta un nueva compra.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al guardar nueva compra (L 252).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $compra["razon_social"] . "</b> se agregó correctamente a Compras.";
                }
            }
        }
        
        // EDITAR: Buscar información para editar compra.
        else if($accion == "editar_buscar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM compras 
                      WHERE id = $id LIMIT 1";
            
            // Consulta información del compra a editar.
            $compra = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($compra === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de compra (L 279).";
            }
            // Si la consulta fue exitosa y no existe el compra.
            else if(empty($compra))
            {
                $respuesta['descripcion'] = "El compra buscado no existe.";
            }
            // Si la consulta fue exitosa y existe el compra.
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
                    $respuesta['compra'] = $compra;
                    $respuesta['tipos_documentos'] = $tipos_documentos;
                }
            }
        }

        // EDITAR: Confirmar edición de compra.
        else if($accion == "editar_confirmar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "editar_buscar", $respuesta, false);

            $compra = $_POST["compra"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM compras
                      WHERE compras.id = " . $compra['id'] . " LIMIT 1";

            // Consulta información del compra a editar.
            $compraDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($compraDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información del compra (L 361).";
            }
            // Si la consulta fue exitosa y no existe el compra.
            else if(empty($compraDB))
            {
                $respuesta['descripcion'] = "El compra que se intenta editar no existe.";
            }
            // Si la consulta fue exitosa y existe el compra.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE compras 
                          SET razon_social = '" . $compra['razon_social'] . "', 
                          id_tipo_documento = " . $compra['id_tipo_documento'] . ", 
                          documento = " . $compra['documento'] . ", 
                          sucursal = '" . $compra["sucursal"] . "', 
                          pais = '" . $compra["pais"] . "', 
                          provincia = '" . $compra["provincia"] . "', 
                          localidad = '" . $compra["localidad"] . "', 
                          calle = '" . $compra["calle"] . "', 
                          email = '" . $compra['email'] . "', 
                          telefono = " . $compra['telefono'] . "  
                          WHERE id = " . $compra['id'];
                
                // Actualizo la información del compra.
                $resultado = ejecutar($conexion, $query);
                
                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al editar compra (L 400).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $compra['razon_social'] . "</b> se editó correctamente.";
                }
            }
        }

        // ELIMINAR: Confirmar eliminación de compra.
        else if($accion == "eliminar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM compras 
                      WHERE id = $id LIMIT 1";

            // Consulta información del compra a eliminar.
            $compraDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($compraDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de compra (L 427).";
            }
            // Si la consulta fue exitosa y no existe el compra.
            else if(empty($compraDB))
            {
                $respuesta['descripcion'] = "El compra que se intenta eliminar no existe.";
            }
            // Si la consulta fue exitosa y existe el compra.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE compras 
                          SET eliminado = 1 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del compra.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al eliminar compra (L 448).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Compra eliminado correctamente.";
                }
            }
        }

        // DESHABILITAR: Confirmar deshabilitación de compra.
        else if($accion == "deshabilitar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM compras 
                      WHERE id = $id LIMIT 1";

            // Consulta información del compra a deshabilitar.
            $compraDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($compraDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de compra (L 476).";
            }
            // Si la consulta fue exitosa y no existe el compra.
            else if(empty($compraDB))
            {
                $respuesta['descripcion'] = "El compra que se intenta deshabilitar no existe.";
            }
            // Si la consulta fue exitosa y existe el compra.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE compras 
                          SET habilitado = 0 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del compra.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al deshabilitar compra (L 497).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Compra deshabilitado correctamente.";
                }
            }
        }

        // HABILITAR: Confirmar habilitación de compra.
        else if($accion == "habilitar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM compras 
                      WHERE id = $id LIMIT 1";

            // Consulta información del compra a habilitar.
            $compraDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($compraDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de compra (L 525).";
            }
            // Si la consulta fue exitosa y no existe el compra.
            else if(empty($compraDB))
            {
                $respuesta['descripcion'] = "El compra que se intenta habilitar no existe.";
            }
            // Si la consulta fue exitosa y existe el compra.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE compras 
                          SET habilitado = 1 
                          WHERE id = $id";

                // Actualiza la información del compra.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al habilitar compra (L 546).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Compra habilitado correctamente.";
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