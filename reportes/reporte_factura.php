<?php
    header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    try {

        $id_venta = $_GET['id'];

        // Prepara la consulta.
        $query = "SELECT ventas.numero_factura, 
                         ventas.fecha_venta,
                         tipos_pagos.descripcion as 'tipo_pago',
                         CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as 'vendedor'
                  FROM ventas
                  INNER JOIN tipos_pagos
                    ON tipos_pagos.id = ventas.id_tipo_pago
                  INNER JOIN usuarios
                    ON ventas.id_usuario_vendedor = usuarios.id
                  WHERE ventas.id = $id_venta";

        // Consulta una venta.
        $venta = consultar_registro($conexion, $query);
            
        // Si hubo error ejecutando la consulta.
        if($venta === false)
        {
            $respuesta['descripcion'] = "Ocurrió un error al buscar la venta (L 31).";
        }
        // Si la consulta fue exitosa y la venta se encuentra.
        else 
        {
            // Prepara la consulta.
            $query = "SELECT productos.descripcion as 'producto', 
                        ventas_detalles.cantidad,
                        ventas_detalles.precio_unitario,
                        ventas_detalles.precio_total 
                FROM ventas_detalles
                INNER JOIN productos
                    ON ventas_detalles.id_producto = productos.id
                WHERE ventas_detalles.id_venta = $id_venta";

            // Consulta el listado de ventas_detalle.
            $ventas_detalles = consultar_listado($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($ventas_detalles === false)
            {
                die("Ocurrió un error al buscar el listado de ventas_detalles");
            }    
        }
        
        // Instancia del PDF.
        $mpdf = new \Mpdf\Mpdf();
        
        // Contenido.
        $contenido = '
            <h6 style="text-align: center;font-size:100%"><strong>Factura A</strong></h6>            
            
            <h6 style="text-align: left;"><strong>DARUMA S.At</strong></h6>
            
            <h6 style="text-align: left;"><strong>C.U.I.T.: 30-20203030-3</strong></h6>
            
            <h6 style="text-align: left;"><strong>CORONEL CHAMIZO N° 3345</strong></h6>
            
            <h6 style="text-align: left;"><strong>GERLI, CP: 3343</strong></h6>
            
            <h6 style="text-align: left;"><strong>IVA RESP. INSCRIPTO</strong></h6>
            
            <h6 style="text-align: left;"><strong>CONSUMIDOR FINAL</strong></h6>
            
            <h6 style="text-align: left;"><strong>INI ACT: 01/03/2019</strong></h6>
            
            <b style="font-size:100%">Razon social:</b>
            
            <b style="font-size:100%">CUIT:</b>
            
            <b style="font-size:100%"><Domicilio:</b>
            
            <b style="font-size:100%">Telefono:</b>
            
            
            <div class="row">
                <div class="col-md-6">
                    Fecha: <b>' . date("d/m/y") . '</b>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    Medio de pago: <b>' . $venta->tipo_pago . '</b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    Vendedor: <b>' . $venta->vendedor . '</b>
                </div>
            </div>

            <br>
            <br>
            <hr>
            <h3>Numero de Ticket: ' . $venta->numero_factura . '</h3>
            
            <hr>

            <br>
            <br>
            <br>
            
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th align="left">Producto</th>
                        <th align="left">Cantidad</th>
                        <th align="right">Precio unitario</th>
                        <th align="right">Precio total</th>
                    </tr>
                </thead>

                <tbody>';
                
                foreach ($ventas_detalles as $producto)
                {
                    $contenido .='
                    <tr>
                    <td>' . $producto['producto'] . '</td>
                        <td>' . $producto['cantidad'] . '</td>
                        <td align="right"> $' . $producto['precio_unitario'] . '</td>
                        <td align="right"> $' . $producto['precio_total'] . '</td>
                    </tr>';
                }
                
            $contenido .= '
                </tbody>
            </table>
        </div>';
        
        // Escribir PDF.
        $mpdf->WriteHTML($contenido);

        // Descarga PDF.
        //$mpdf->Output('ticket-' . $id_venta . '.pdf', 'D');
        $mpdf->Output();
    }
    catch(Excepcion $e) {
        print('Esto es lo que pasó: ' . $e);
    }
?>