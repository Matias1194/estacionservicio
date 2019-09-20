<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'productos';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nuevo conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // BUSCAR: Listado de productos.
        if($accion == "buscar_listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT productos.id, productos.descripcion, tipos_productos.descripcion as 'tipo_producto'
                      FROM productos
                      INNER JOIN tipos_productos
                        ON productos.id_tipo_producto = tipos_productos.id
                      WHERE productos.habilitado = 1 AND productos.eliminado = 0";

            // Consulta el listado de productos.
            $productos = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($productos === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de productos (L 37).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['productos'] = $productos;
            }
        }

        // NUEVO: Buscar información para crear producto.
        else if($accion == "nuevo_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);
            
            // Prepara la consulta.
            $query = "SELECT id, descripcion 
                        FROM tipos_productos";

            // Consulta los tipos de comprobantes habilitados.
            $tipos_productos = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($tipos_productos === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de comprobantes (L 120).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['tipos_productos'] = $tipos_productos;
            }
        }

        // NUEVO: Confirmar nuevo producto.
        else if($accion == "nuevo_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nuevo_buscar", $respuesta, false);
            
            $producto = $_POST["producto"];
            
            // Prepara la consulta.
            $query = "INSERT INTO productos (id_tipo_producto, descripcion) "
            . "VALUES"
            . "("
                . $producto['id_tipo_producto'] . ", "
                . "'" . $producto['descripcion'] . "'"
            . ")";
            
            // Inserta un nuevo producto.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al guardar nuevo producto (L 184).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $id_producto = mysqli_insert_id($conexion);

                // Prepara la consulta.
                $query = "INSERT INTO stock (id_producto) "
                . "VALUES (" . $id_producto . ")";
                
                // Inserta un nuevo producto en stock.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al guardar nuevo producto (L 114).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $producto["descripcion"] . "</b> se agregó correctamente a Productos.";
                }
            }
        }
        
        // EDITAR: Buscar información para editar producto.
        else if($accion == "editar_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id_producto = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT id, id_proveedor, id_tipo_comprobante, numero_factura, orden_producto_numero, DATE_FORMAT(orden_producto_fecha, '%d/%m/%Y') as 'orden_producto_fecha', gastos_envio, gastos_envio_iva, gastos_envio_impuestos, detalle
            FROM productos
            WHERE id = $id_producto AND eliminado = 0";

            // Consulta la producto a editar.
            $producto = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($producto === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar la producto (L 136).";
            }
            // Si la consulta fue exitosa y no existe la producto.
            else if(empty($producto))
            {
                $respuesta['descripcion'] = "La producto que se intenta editar no existe.";
            }
            // Si la consulta fue exitosa.
            else
            {
                // Prepara la consulta.
                $query = "SELECT productos_detalles.id, productos_detalles.id_producto, productos.descripcion, productos_detalles.cantidad, productos_detalles.precio_unitario, productos_detalles.precio_total
                          FROM productos_detalles
                          INNER JOIN productos
                            ON productos_detalles.id_producto = productos.id
                          WHERE productos_detalles.id_producto = $id_producto";

                // Consulta detalles de la producto.
                $detalles = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($detalles === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles de la producto (L 136).";
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
                                $respuesta['producto'] = $producto;
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

        // EDITAR: Confirmar edición de producto.
        else if($accion == "editar_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nuevo_buscar", $respuesta, false);
            
            $producto = $_POST["producto"];
            $productos = $producto["productos"];
            
            // Prepara la consulta.
            $query = "UPDATE productos 
                      SET id_proveedor = " . $producto['id_proveedor'] . ",
                      id_tipo_comprobante = " . $producto['id_tipo_comprobante'] . ",
                      numero_factura = " . $producto["numero_factura"] . ",
                      orden_producto_numero = " . $producto['orden_producto_numero'] . ",
                      orden_producto_fecha = STR_TO_DATE('" . $producto['orden_producto_fecha'] . "', '%d/%m/%Y'),
                      gastos_envio = " . $producto['gastos_envio'] . ",
                      gastos_envio_iva = " . $producto['gastos_envio_iva'] . ",
                      gastos_envio_impuestos = " . $producto['gastos_envio_impuestos'] . ",  
                      importe_total = " . $producto['importe_total'] . ",  
                      detalle = '" . $producto['detalle'] . "'
                      WHERE id = " . $producto['id'];
            
            // Edita una producto.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al editar la producto (L 383).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['descripcion'] = "<b>" . $producto["detalle"] . "</b> se editó correctamente.";
            }
        }

        // ELIMINAR: Confirmar eliminación de producto.
        else if($accion == "eliminar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM productos 
                      WHERE id = $id LIMIT 1";

            // Consulta información del producto a eliminar.
            $productoDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($productoDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de producto (L 427).";
            }
            // Si la consulta fue exitosa y no existe el producto.
            else if(empty($productoDB))
            {
                $respuesta['descripcion'] = "El producto que se intenta eliminar no existe.";
            }
            // Si la consulta fue exitosa y existe el producto.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE productos 
                          SET eliminado = 1 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del producto.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al eliminar producto (L 448).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Producto eliminada correctamente.";
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