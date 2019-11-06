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

        if($accion == "caja_estado")
        {
            $query = "SELECT COUNT(*) as 'estado' 
                      FROM movimientos_caja 
                      WHERE (id_tipo_registro_caja = 1 OR id_tipo_registro_caja = 3) AND DATE(fecha) = CURDATE()";

            // Consulta el estado de la caja (0 = CERRADO, 1 = ABIERTO).
            $caja = consultar_registro($conexion, $query);

            // Caja cerrada.
            if($caja->estado % 2 == 0) 
            {
                $respuesta['exito'] = true;
                $respuesta['caja_estado'] = false;
            }
            // Caja abierta.
            else 
            {
                $query = "SELECT COUNT(*) as 'estado' 
                      FROM movimientos_caja 
                      WHERE (id_tipo_registro_caja = 8 OR id_tipo_registro_caja = 9) AND id_usuario = " . $_SESSION['usuario']->id . " AND DATE(fecha) = CURDATE()";

                // Consulta el estado del turno (0 = CERRADO, 1 = ABIERTO).
                $turno = consultar_registro($conexion, $query);

                // Turno cerrado.
                if($turno->estado % 2 == 0)
                {
                    $respuesta['exito'] = true;
                    $respuesta['caja_estado'] = true;
                    $respuesta['turno_estado'] = false;
                }
                // Turno abierto.
                else {
                    $respuesta['exito'] = true;
                    $respuesta['caja_estado'] = true;
                    $respuesta['turno_estado'] = true;
                }
            }
        }

        // Abrir Caja.
        else if($accion == "abrir_caja")
        {
            $saldo = $_POST['saldo'];

            $query = "INSERT INTO movimientos_caja (id_tipo_registro_caja, saldo, id_pago, id_usuario) 
                      VALUES (
                          1,
                          $saldo,
                          0, "
                        . $_SESSION['usuario']->id . "
                      )";
            
            // Abre la caja.
            $apertura = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($apertura === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al abrir la caja (L 81).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
            }
        }

        // Cerrar Caja.
        else if($accion == "cerrar_caja")
        {
            $saldo = $_POST['saldo'];

            $query = "INSERT INTO movimientos_caja (id_tipo_registro_caja, saldo, id_pago, id_usuario) 
                      VALUES (
                          3,
                          $saldo,
                          0, "
                        . $_SESSION['usuario']->id . "
                      )";
            
            // Cierra la caja.
            $cierre = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($cierre === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al cerrar la caja (L 108).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
            }
        }

        // Abrir Turno.
        else if($accion == "comenzar_turno")
        {
            $query = "INSERT INTO movimientos_caja (id_tipo_registro_caja, id_usuario) 
                      VALUES (
                          8, "
                        . $_SESSION['usuario']->id . "
                      )";
            
            // Comienza el turno.
            $apertura = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($apertura === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al abrir el turno (L 136).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
            }
        }

        // Cerrar Turno.
        else if($accion == "finalizar_turno")
        {
            $query = "INSERT INTO movimientos_caja (id_tipo_registro_caja, id_usuario) 
                      VALUES (
                          9, "
                        . $_SESSION['usuario']->id . "
                      )";
            
            // Finaliza el turno.
            $cierre = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($cierre === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al cerrar el turno (L 160).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
            }
        }

        // Otros > Buscar.
        else if($accion == "otros_buscar")
        {
            $query = "SELECT id, descripcion
                      FROM tipos_registros_caja
                      WHERE id = 5 OR id = 6";
            
            // Consulta los conceptos.
            $conceptos = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($conceptos === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error buscando los conceptos (L 178).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['conceptos'] = $conceptos;
            }
        }

        // Otros > Confirmar.
        else if($accion == "otros_confirmar")
        {
            $id_concepto = $_POST['id_concepto'];
            $importe = $_POST['importe'];

            // Prepara la consulta.
            $query = "SELECT *
                      FROM movimientos_caja
                      WHERE saldo IS NOT NULL
                      ORDER BY id DESC LIMIT 1";

            // Consulta ultimo movimiento de caja.
            $ultimo_movimiento_caja = consultar_registro($conexion, $query);

            $saldo = $ultimo_movimiento_caja->saldo + ($id_concepto == 6 ? -$importe : $importe);
            
            $query = "INSERT INTO movimientos_caja (id_tipo_registro_caja, " . ($id_concepto == 5 ? "entrada" : ($id_concepto == 6 ? "salida" : "")) . ", saldo, id_usuario) 
                      VALUES (
                          $id_concepto, 
                          $importe, 
                          $saldo, "
                        . $_SESSION['usuario']->id . "
                      )";
            
            // Registra el movimiento.
            $movimiento = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($movimiento === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al guardar el movimiento (L 208).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['descripcion'] = "El movimiento se registró exitosamente!";
            }
        }

        // BUSCAR: Listado de ventas.
        else if($accion == "buscar_listado") 
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

        // Ticket > Nueva > Buscar.
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
                // Prepara la consulta.
                $query = "SELECT id, descripcion 
                        FROM tipos_pagos
                        WHERE habilitado = 1";

                // Consulta los tipos de pagos habilitados.
                $tipos_pagos = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($tipos_pagos === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de pago(L 140).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['productos'] = $productos;
                    $respuesta['tipos_pagos'] = $tipos_pagos;
                }
            }
        }

        // Ticket > Nueva > Confirmar.
        else if($accion == "nueva_confirmar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nueva_buscar", $respuesta, false);
            
            $venta = $_POST["venta"];
            $productos = $venta["productos"];
            
            // Prepara la consulta.
            $query = "INSERT INTO ventas (id_tipo_pago, importe_total, id_usuario_vendedor) "
            . "VALUES"
            . "("
                . $venta['id_tipo_pago'] . ", "
                . $venta['importe_total'] . ", "
                . $_SESSION['usuario']->id
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
                        // Prepara la consulta.
                        $query = "SELECT *
                                    FROM movimientos_caja
                                    WHERE saldo IS NOT NULL
                                    ORDER BY id DESC LIMIT 1";
                        
                        // Consulta ultimo movimiento de caja.
                        $ultimo_movimiento_caja = consultar_registro($conexion, $query);
                        
                        // Prepara la consulta.
                        $query = "INSERT INTO movimientos_caja (id_tipo_registro_caja, entrada, saldo, id_pago, id_usuario)
                                    VALUES ("
                                    . 7 . ", "
                                    . $venta['importe_total'] . ", "
                                    . (floatval($ultimo_movimiento_caja->saldo) + floatval($venta['importe_total'])) . ", "
                                    . $venta['id_tipo_pago'] . ", "
                                    . $_SESSION['usuario']->id
                                . ')';
                        
                        // Guarda un nuevo movimiento de caja.
                        $resultado = ejecutar($conexion, $query);
                        
                        // Si hubo error ejecutando la consulta.
                        if($resultado === false)
                        {
                            $respuesta['descripcion'] = "Ocurrió un error al regitrar el movimiento de caja (L 295).";
                        }
                        // Si la consulta fue exitosa.
                        else
                        {
                            $respuesta['exito'] = true;
                            $respuesta['descripcion'] = "Se registró correctamente la venta!";
                            $respuesta['id_venta'] = $id_venta;
                        }
                    }
                }
            }
        }
        
        // Factura > Nueva > Buscar.
        else if($accion == "factura_nueva_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            // Prepara la consulta.
            $query = "SELECT id, descripcion 
                        FROM tipos_clientes";

            // Consulta los clientes habilitados.
            $tipos_clientes = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($tipos_clientes === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de cliente (L 502).";
            }
            // Si la consulta fue exitosa.
            else
            {
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
                    // Prepara la consulta.
                    $query = "SELECT id, descripcion 
                            FROM tipos_pagos
                            WHERE habilitado = 1";

                    // Consulta los tipos de pagos habilitados.
                    $tipos_pagos = consultar_listado($conexion, $query);

                    // Si hubo error ejecutando la consulta.
                    if($tipos_pagos === false)
                    {
                        $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de pago(L 140).";
                    }
                    // Si la consulta fue exitosa.
                    else
                    {
                        $respuesta['exito'] = true;
                        $respuesta['tipos_clientes'] = $tipos_clientes;
                        $respuesta['tipos_pagos'] = $tipos_pagos;
                        $respuesta['productos'] = $productos;
                    }
                }
            }
        }

        // Factura > Nueva > Buscar.
        else if($accion == "factura_nueva_clientes_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            // Prepara la consulta.
            $query = "SELECT id, razon_social 
                        FROM clientes
                        WHERE habilitado = 1 AND eliminado = 0";

            // Consulta los clientes habilitados.
            $clientes = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($clientes === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los clientes (L 563).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['clientes'] = $clientes;
            }
        }
        
        // Factura > Nueva > Confirmar.
        else if($accion == "factura_nueva_confirmar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nueva_buscar", $respuesta, false);
            
            $venta = $_POST["venta"];
            $productos = $venta["productos"];

            $razon_social = "";
            $cuit = "";
            $domicilio = "";
            $telefono = "";
            $email = "";
            
            if($venta['id_tipo_cliente'] == 1) 
            {
                $query = "SELECT *
                          FROM clientes
                          WHERE id = " . $venta['id_cliente'];
                
                // Inserta un nueva venta.
                $cliente = consultar_registro($conexion, $query);
                
                // Si hubo error ejecutando la consulta.
                if($cliente === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al guardar nueva venta (L 184).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $razon_social = $cliente->razon_social;
                    $cuit = $cliente->cuit;
                    $domicilio = $cliente->domicilio;
                    $telefono = $cliente->telefono;
                    $email = $cliente->email;
                }
            } 
            else if($venta['id_tipo_cliente'] == 2) 
            {
                $razon_social = $venta['razon_social'];
                    $cuit = $venta['cuit'];
                    $domicilio = $venta['domicilio'];
                    $telefono = $venta['telefono'];
                    $email = $venta['email'];
            }


            // Prepara la consulta.
            $query = "INSERT INTO ventas (razon_social, cuit, domicilio, telefono, email, id_tipo_pago, importe_total, id_usuario_vendedor) "
            . "VALUES"
            . "(
                  '$razon_social', "
                . $cuit . ", 
                  '$domicilio',
                  '$telefono',
                  '$email', "
                . $venta['id_tipo_pago'] . ", "
                . $venta['importe_total'] . ", "
                . $_SESSION['usuario']->id
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
                        // Prepara la consulta.
                        $query = "SELECT *
                                    FROM movimientos_caja
                                    WHERE saldo IS NOT NULL
                                    ORDER BY id DESC LIMIT 1";
                        
                        // Consulta ultimo movimiento de caja.
                        $ultimo_movimiento_caja = consultar_registro($conexion, $query);
                        
                        // Prepara la consulta.
                        $query = "INSERT INTO movimientos_caja (id_tipo_registro_caja, entrada, saldo, id_pago, id_usuario)
                                    VALUES ("
                                    . 7 . ", "
                                    . $venta['importe_total'] . ", "
                                    . (floatval($ultimo_movimiento_caja->saldo) + floatval($venta['importe_total'])) . ", "
                                    . $venta['id_tipo_pago'] . ", "
                                    . $_SESSION['usuario']->id
                                . ')';
                        
                        // Guarda un nuevo movimiento de caja.
                        $resultado = ejecutar($conexion, $query);
                        
                        // Si hubo error ejecutando la consulta.
                        if($resultado === false)
                        {
                            $respuesta['descripcion'] = "Ocurrió un error al regitrar el movimiento de caja (L 295).";
                        }
                        // Si la consulta fue exitosa.
                        else
                        {
                            $respuesta['exito'] = true;
                            $respuesta['descripcion'] = "Se registró correctamente la venta!";
                            $respuesta['id_venta'] = $id_venta;
                        }
                    }
                }
            }
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