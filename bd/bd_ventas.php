<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'ventas';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // BUSCAR: Listado de ventas.
        if($accion == "buscar_listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT ventas.id, proveedores.razon_social as 'proveedor', ventas.importe_total, ventas.detalle, DATE_FORMAT(ventas.fecha_venta, '%d/%m/%Y') as 'fecha_venta' 
                      FROM ventas
                      INNER JOIN proveedores
                        ON ventas.id_proveedor = proveedores.id
                      WHERE ventas.eliminado = 0";

            // Consulta el listado de ventas.
            $ventas = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($ventas === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de ventas (L 37).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['ventas'] = $ventas;
            }
        }

        // BUSCAR: Detalles de venta por id.
        else if($accion == "buscar_detalles")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];
            
            // Prepara la consulta.
            $query = "SELECT ventas.detalle, proveedores.razon_social as 'proveedor', tipos_comprobantes.descripcion as 'tipo_comprobante', ventas.numero_factura, ventas.orden_venta_numero, DATE_FORMAT(ventas.orden_venta_fecha, '%d/%m/%Y') as 'orden_venta_fecha', ventas.gastos_envio, ventas.gastos_envio_iva, ventas.gastos_envio_impuestos, ventas.importe_total, DATE_FORMAT(ventas.fecha_venta, '%d/%m/%Y') as 'fecha_venta' 
                      FROM ventas 
                      INNER JOIN proveedores 
                        ON ventas.id_proveedor = proveedores.id 
                      INNER JOIN tipos_comprobantes 
                        ON ventas.id_tipo_comprobante = tipos_comprobantes.id
                      WHERE ventas.id = $id AND ventas.eliminado = 0 LIMIT 1";
            
            // Consulta los detalles de venta.
            $venta = consultar_registro($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($venta === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del venta (L 72).";
            }
            // Si la consulta fue exitosa y no se encuentra el venta.
            else if(empty($venta))
            {
                $respuesta['descripcion'] = "El venta no se encuentra.";
            }
            // Si la consulta fue exitosa y el venta se encuentra.
            else 
            {
                // Prepara la consulta.
                $query = "SELECT productos.descripcion, ventas_detalles.cantidad, ventas_detalles.precio_unitario, ventas_detalles.precio_total 
                        FROM ventas_detalles
                        INNER JOIN productos
                        ON ventas_detalles.id_producto = productos.id
                        WHERE ventas_detalles.id_venta = $id ";
                
                // Consulta los detalles de venta.
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
                    $respuesta['venta'] = $venta;
                    $respuesta['detalles'] = $detalles;
                }
            }
        }

        // NUEVO: Buscar información para crear venta.
        else if($accion == "nueva_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            
            // Prepara la consulta.
            $query = "SELECT id, descripcion, precio_unitario 
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
                $respuesta['productos'] = $productos;
            }
        }

        // NUEVO: Confirmar nueva venta.
        else if($accion == "nueva_confirmar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nueva_buscar", $respuesta, false);
            
            $venta = $_POST["venta"];
            $productos = $venta["productos"];

            // Prepara la consulta.
            /*$query = "SELECT precio_unitario 
                      FROM stock 
                      WHERE ";
            
            for ($i = 0; $i < count($productos); $i++)
            {
                $query .= $productos[$i]['id_producto'];

                if($i < count($productos) - 1)
                {
                    $query .= ' AND ';
                }
            }
            
            // Inserta un nueva venta.
            $productos_unidades = consultar_registros($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($productos_unidades === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al guardar nueva venta (L 165).";
            }
            // Si la consulta fue exitosa.
            else
            {
                /* VALIDAR QUE HAYA STOCK.
                for($i = 0; $i < count($productos_unidades); $i++)
                {
                    if($productos_)
                    {

                    }
                }*/

                // Prepara la consulta.
                $query = "INSERT INTO ventas (importe_total) "
                . "VALUES"
                . "("
                    . $venta['importe_total']
                . ")";
                
                // Inserta un nueva venta.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al guardar nueva venta (L 184).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $id_venta = mysqli_insert_id($conexion);

                    $productos_stock = array();

                    // Prepara la consulta.
                    $query = "INSERT INTO ventas_detalles (id_venta, id_producto, cantidad, precio_unitario, precio_total) "
                    . "VALUES";
                    
                    for ($i = 0; $i < count($productos); $i++)
                    {
                        $query .= "("
                            . $id_venta . ", "
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
                    
                    // Inserta un nueva venta de venta.
                    $resultado = ejecutar($conexion, $query);
                    
                    // Si hubo error ejecutando la consulta.
                    if($resultado === false)
                    {
                        $respuesta['descripcion'] = "Ocurrió un error al guardar nueva venta (L 217).";
                    }
                    // Si la consulta fue exitosa.
                    else
                    {
                        for ($i = 0; $i < count($productos_stock); $i++) { 
                            // Prepara la consulta.
                            $query = "UPDATE stock 
                                    SET unidades = unidades - " . $productos_stock[$i]['cantidad'] . "
                                    WHERE id_producto = " . $productos_stock[$i]['id_producto'];
                            
                            // Edita stock.
                            $resultado = ejecutar($conexion, $query);
                        }
                        
                        // Si hubo error ejecutando la consulta.
                        if($resultado === false)
                        {
                            $respuesta['descripcion'] = "Ocurrió un error al editar la venta (L 214).";
                        }
                        // Si la consulta fue exitosa.
                        else
                        {
                            $respuesta['exito'] = true;
                            $respuesta['descripcion'] = "Se registró correctamente la venta!";
                        }
                    }
                }
            //}
        }
        
        // EDITAR: Buscar información para editar venta.
        else if($accion == "editar_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id_venta = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT id, id_proveedor, id_tipo_comprobante, numero_factura, orden_venta_numero, DATE_FORMAT(orden_venta_fecha, '%d/%m/%Y') as 'orden_venta_fecha', gastos_envio, gastos_envio_iva, gastos_envio_impuestos, detalle
            FROM ventas
            WHERE id = $id_venta AND eliminado = 0";

            // Consulta la venta a editar.
            $venta = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($venta === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar la venta (L 136).";
            }
            // Si la consulta fue exitosa y no existe la venta.
            else if(empty($venta))
            {
                $respuesta['descripcion'] = "La venta que se intenta editar no existe.";
            }
            // Si la consulta fue exitosa.
            else
            {
                // Prepara la consulta.
                $query = "SELECT ventas_detalles.id, ventas_detalles.id_producto, productos.descripcion, ventas_detalles.cantidad, ventas_detalles.precio_unitario, ventas_detalles.precio_total
                          FROM ventas_detalles
                          INNER JOIN productos
                            ON ventas_detalles.id_producto = productos.id
                          WHERE ventas_detalles.id_venta = $id_venta";

                // Consulta detalles de la venta.
                $detalles = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($detalles === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles de la venta (L 136).";
                }
                // Si la consulta fue exitosa.
                else
                {
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
                                $respuesta['venta'] = $venta;
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

        // EDITAR: Confirmar edición de venta.
        else if($accion == "editar_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nueva_buscar", $respuesta, false);
            
            $venta = $_POST["venta"];
            $productos = $venta["productos"];
            
            // Prepara la consulta.
            $query = "UPDATE ventas 
                      SET id_proveedor = " . $venta['id_proveedor'] . ",
                      id_tipo_comprobante = " . $venta['id_tipo_comprobante'] . ",
                      numero_factura = " . $venta["numero_factura"] . ",
                      orden_venta_numero = " . $venta['orden_venta_numero'] . ",
                      orden_venta_fecha = STR_TO_DATE('" . $venta['orden_venta_fecha'] . "', '%d/%m/%Y'),
                      gastos_envio = " . $venta['gastos_envio'] . ",
                      gastos_envio_iva = " . $venta['gastos_envio_iva'] . ",
                      gastos_envio_impuestos = " . $venta['gastos_envio_impuestos'] . ",  
                      importe_total = " . $venta['importe_total'] . ",  
                      detalle = '" . $venta['detalle'] . "'
                      WHERE id = " . $venta['id'];
            
            // Edita una venta.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al editar la venta (L 383).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['descripcion'] = "<b>" . $venta["detalle"] . "</b> se editó correctamente.";
            }
        }

        // ELIMINAR: Confirmar eliminación de venta.
        else if($accion == "eliminar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM ventas 
                      WHERE id = $id LIMIT 1";

            // Consulta información del venta a eliminar.
            $ventaDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($ventaDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de venta (L 427).";
            }
            // Si la consulta fue exitosa y no existe el venta.
            else if(empty($ventaDB))
            {
                $respuesta['descripcion'] = "El venta que se intenta eliminar no existe.";
            }
            // Si la consulta fue exitosa y existe el venta.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE ventas 
                          SET eliminado = 1 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del venta.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al eliminar venta (L 448).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Venta eliminada correctamente.";
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