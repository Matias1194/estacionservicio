<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'playa_compras';

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
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT playa_compras.id, 
                             playa_proveedores.razon_social as 'proveedor', 
                             playa_compras.importe_total, playa_compras.detalle, 
                             DATE_FORMAT(playa_compras.fecha_compra, '%d/%m/%Y') as 'fecha_compra' 
                      FROM playa_compras
                      INNER JOIN playa_proveedores
                        ON playa_compras.id_proveedor = playa_proveedores.id
                      WHERE playa_compras.eliminado = 0";

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
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];
            
            // Prepara la consulta.
            $query = "SELECT playa_compras.detalle, 
                             playa_proveedores.razon_social as 'proveedor', 
                             tipos_comprobantes.descripcion as 'tipo_comprobante', 
                             playa_compras.numero_factura, 
                             playa_compras.orden_compra_numero, 
                             DATE_FORMAT(playa_compras.orden_compra_fecha, '%d/%m/%Y') as 'orden_compra_fecha', 
                             playa_compras.gastos_envio, 
                             playa_compras.gastos_envio_iva, 
                             playa_compras.gastos_envio_impuestos, 
                             playa_compras.importe_total, 
                             DATE_FORMAT(playa_compras.fecha_compra, '%d/%m/%Y') as 'fecha_compra' 
                      FROM playa_compras 
                      INNER JOIN playa_proveedores 
                        ON playa_compras.id_proveedor = playa_proveedores.id 
                      INNER JOIN tipos_comprobantes 
                        ON playa_compras.id_tipo_comprobante = tipos_comprobantes.id
                      WHERE playa_compras.id = $id AND playa_compras.eliminado = 0 LIMIT 1";
            
            // Consulta los detalles de compra.
            $compra = consultar_registro($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($compra === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del compra (L 72).";
            }
            // Si la consulta fue exitosa y no se encuentra el compra.
            else if(empty($compra))
            {
                $respuesta['descripcion'] = "El compra no se encuentra.";
            }
            // Si la consulta fue exitosa y el compra se encuentra.
            else 
            {
                // Prepara la consulta.
                $query = "SELECT playa_productos.descripcion, 
                                 playa_compras_detalles.cantidad, 
                                 playa_compras_detalles.precio_unitario, 
                                 playa_compras_detalles.precio_total 
                        FROM playa_compras_detalles
                        INNER JOIN playa_productos
                        ON playa_compras_detalles.id_producto = playa_productos.id
                        WHERE playa_compras_detalles.id_compra = $id ";
                
                // Consulta los detalles de compra.
                $detalles = consultar_listado($conexion, $query);
                
                // Si hubo error ejecutando la consulta.
                if($detalles === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del detalles (L 95).";
                }
                // Si la consulta fue exitosa y no se encuentra el detalles.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['compra'] = $compra;
                    $respuesta['detalles'] = $detalles;
                }
            }
        }

        // NUEVO: Buscar información para crear compra.
        else if($accion == "nueva_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            // Prepara la consulta.
            $query = "SELECT id, razon_social 
                      FROM playa_proveedores
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
                              FROM playa_productos
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
            validarPermiso($conexion, $area, $modulo, "nueva_buscar", $respuesta, false);
            
            $compra = $_POST["compra"];
            $productos = $compra["productos"];
            
            // Prepara la consulta.
            $query = "INSERT INTO playa_compras (id_proveedor, id_tipo_comprobante, numero_factura, orden_compra_numero, orden_compra_fecha, gastos_envio, gastos_envio_iva, gastos_envio_impuestos, importe_total, detalle) "
            . "VALUES"
            . "("
                . $compra['id_proveedor'] . ", "
                . $compra['id_tipo_comprobante'] . ", "
                . $compra['numero_factura'] . ", "
                . $compra['orden_compra_numero'] . ", "
                . "STR_TO_DATE('" . $compra['orden_compra_fecha'] . "', '%d/%m/%Y'), "
                . $compra['gastos_envio'] . ", "
                . $compra['gastos_envio_iva'] . ", "
                . $compra['gastos_envio_impuestos'] . ", "
                . $compra['importe_total'] . ", "
                . "'" . $compra['detalle'] . "'"
            . ")";
            
            // Inserta un nueva compra.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al guardar nueva compra (L 184).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $id_compra = mysqli_insert_id($conexion);


                $productos_stock = array();

                // Prepara la consulta.
                $query = "INSERT INTO playa_compras_detalles (id_compra, id_producto, cantidad, precio_unitario, precio_total) "
                . "VALUES";
                
                for ($i = 0; $i < count($productos); $i++)
                {
                    $query .= "("
                        . $id_compra . ", "
                        . $productos[$i]['id_producto'] . ", "
                        . $productos[$i]['cantidad'] . ", "
                        . $productos[$i]['precio_unitario'] . ", "
                        . $productos[$i]['precio_total'] 
                    . ")";

                    if($i < count($productos) - 1)
                    {
                        $query .= ', ';
                    }

                    $productos_stock[$i]['id_producto'] = $productos[$i]['id_producto'];
                    $productos_stock[$i]['cantidad'] = $productos[$i]['cantidad'];
                }
                
                // Inserta un nueva compra de compra.
                $resultado = ejecutar($conexion, $query);
                
                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al guardar nueva compra (L 217).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    for ($i = 0; $i < count($productos_stock); $i++) { 
                        // Prepara la consulta.
                        $query = "UPDATE playa_stock 
                                  SET unidades = unidades + " . $productos_stock[$i]['cantidad'] . "
                                  WHERE id_producto = " . $productos_stock[$i]['id_producto'];
                        
                        // Edita stock.
                        $resultado = ejecutar($conexion, $query);
                    }
                    
                    // Si hubo error ejecutando la consulta.
                    if($resultado === false)
                    {
                        $respuesta['descripcion'] = "Ocurrió un error al editar la compra (L 383).";
                    }
                    // Si la consulta fue exitosa.
                    else
                    {
                        $respuesta['exito'] = true;
                        $respuesta['descripcion'] = "<b>" . $compra["detalle"] . "</b> se agregó correctamente a Compras.";
                    }
                }
            }
        }
        
        // EDITAR: Buscar información para editar compra.
        else if($accion == "editar_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id_compra = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT id, 
                             id_proveedor, 
                             id_tipo_comprobante, 
                             numero_factura, 
                             orden_compra_numero, 
                             DATE_FORMAT(orden_compra_fecha, '%Y-%m-%d') as 'orden_compra_fecha', 
                             gastos_envio, 
                             gastos_envio_iva, 
                             gastos_envio_impuestos, 
                             detalle
                      FROM playa_compras
                      WHERE id = $id_compra AND eliminado = 0";

            // Consulta la compra a editar.
            $compra = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($compra === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar la compra (L 136).";
            }
            // Si la consulta fue exitosa y no existe la compra.
            else if(empty($compra))
            {
                $respuesta['descripcion'] = "La compra que se intenta editar no existe.";
            }
            // Si la consulta fue exitosa.
            else
            {
                // Prepara la consulta.
                $query = "SELECT playa_compras_detalles.id, 
                                 playa_compras_detalles.id_producto, 
                                 playa_productos.descripcion, 
                                 playa_compras_detalles.cantidad, 
                                 playa_compras_detalles.precio_unitario, 
                                 playa_compras_detalles.precio_total
                          FROM playa_compras_detalles
                          INNER JOIN playa_productos
                            ON playa_compras_detalles.id_producto = playa_productos.id
                          WHERE playa_compras_detalles.id_compra = $id_compra";

                // Consulta detalles de la compra.
                $detalles = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($detalles === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles de la compra (L 136).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    // Prepara la consulta.
                    $query = "SELECT id, razon_social 
                            FROM playa_proveedores
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
                                    FROM playa_productos
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
                                $respuesta['compra'] = $compra;
                                $respuesta['detalles'] = $detalles;
                                $respuesta['proveedores'] = $proveedores;
                                $respuesta['tipos_comprobantes'] = $tipos_comprobantes;
                                $respuesta['productos'] = $productos;
                            }
                        }
                    }
                }
            }
        }

        // EDITAR: Confirmar edición de compra.
        else if($accion == "editar_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, "nueva_buscar", $respuesta, false);
            
            $compra = $_POST["compra"];
            $productos = $compra["productos"];
            
            // Prepara la consulta.
            $query = "UPDATE playa_compras 
                      SET id_proveedor = " . $compra['id_proveedor'] . ",
                      id_tipo_comprobante = " . $compra['id_tipo_comprobante'] . ",
                      numero_factura = " . $compra["numero_factura"] . ",
                      orden_compra_numero = " . $compra['orden_compra_numero'] . ",
                      orden_compra_fecha = STR_TO_DATE('" . $compra['orden_compra_fecha'] . "', '%d/%m/%Y'),
                      gastos_envio = " . $compra['gastos_envio'] . ",
                      gastos_envio_iva = " . $compra['gastos_envio_iva'] . ",
                      gastos_envio_impuestos = " . $compra['gastos_envio_impuestos'] . ",  
                      importe_total = " . $compra['importe_total'] . ",  
                      detalle = '" . $compra['detalle'] . "'
                      WHERE id = " . $compra['id'];
            
            // Edita una compra.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al editar la compra (L 383).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['descripcion'] = "<b>" . $compra["detalle"] . "</b> se editó correctamente.";
            }
        }

        // ELIMINAR: Confirmar eliminación de compra.
        else if($accion == "eliminar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_compras 
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
                $query = "UPDATE playa_compras 
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
                    $respuesta['descripcion'] = "Compra eliminada correctamente.";
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