<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'stock';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // BUSCAR: Listado de stock.
        if($accion == "buscar_listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT stock.id, stock.id_producto, productos.descripcion as 'producto', stock.unidades 
                      FROM stock
                      INNER JOIN productos
                        ON stock.id_producto = productos.id";
            
            // Consulta el listado de stock.
            $stock = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($stock === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de stock (L 37).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['stock'] = $stock;
            }
        }

        // BUSCAR: Detalles de stock por id.
        else if($accion == "buscar_detalles")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];
            
            // Prepara la consulta.
            $query = "SELECT stock.detalle, proveedores.razon_social as 'proveedor', tipos_comprobantes.descripcion as 'tipo_comprobante', stock.numero_factura, stock.orden_stock_numero, DATE_FORMAT(stock.orden_stock_fecha, '%d/%m/%Y') as 'orden_stock_fecha', stock.gastos_envio, stock.gastos_envio_iva, stock.gastos_envio_impuestos, stock.importe_total, DATE_FORMAT(stock.fecha_stock, '%d/%m/%Y') as 'fecha_stock' 
                      FROM stock 
                      INNER JOIN proveedores 
                        ON stock.id_proveedor = proveedores.id 
                      INNER JOIN tipos_comprobantes 
                        ON stock.id_tipo_comprobante = tipos_comprobantes.id
                      WHERE stock.id = $id AND stock.eliminado = 0 LIMIT 1";
            
            // Consulta los detalles de stock.
            $stock = consultar_registro($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($stock === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del stock (L 72).";
            }
            // Si la consulta fue exitosa y no se encuentra el stock.
            else if(empty($stock))
            {
                $respuesta['descripcion'] = "El stock no se encuentra.";
            }
            // Si la consulta fue exitosa y el stock se encuentra.
            else 
            {
                // Prepara la consulta.
                $query = "SELECT productos.descripcion, stock_detalles.cantidad, stock_detalles.precio_unitario, stock_detalles.precio_total 
                        FROM stock_detalles
                        INNER JOIN productos
                        ON stock_detalles.id_producto = productos.id
                        WHERE stock_detalles.id_stock = $id ";
                
                // Consulta los detalles de stock.
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
                    $respuesta['stock'] = $stock;
                    $respuesta['detalles'] = $detalles;
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