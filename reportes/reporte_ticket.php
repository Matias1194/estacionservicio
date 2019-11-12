<?php
    header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    try {

        $id_venta = $_GET['id'];
        
        $tabla_ventas= "ventas";

        $id_area = $_GET["id_area"];

        if ($id_area == 1){

            $tabla="playa_".$tabla;
        
        }

        // Prepara la consulta.
        $query = "SELECT $tabla_ventas.numero_factura, 
                         $tabla_ventas.fecha_venta,
                         tipos_pagos.descripcion as 'tipo_pago',
                         CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as 'vendedor'
                  FROM $tabla_ventas
                  INNER JOIN tipos_pagos
                    ON tipos_pagos.id = $tabla_ventas.id_tipo_pago
                  INNER JOIN usuarios
                    ON $tabla_ventas.id_usuario_vendedor = usuarios.id
                  WHERE $tabla_ventas.id = $id_venta";

        // Consulta una venta.
        $tabla_ventas = consultar_registro($conexion, $query);
            
        // Si hubo error ejecutando la consulta.
        if($tabla_ventas === false)
        {
            $respuesta['descripcion'] = "Ocurrió un error al buscar la venta (L 31).";
        }
        // Si la consulta fue exitosa y la venta se encuentra.
        else 
        {
            $tabla_ventas_detalles = "ventas_detalle";

            $tabla_productos = "productos";

            $id_area = $_GET["id_area"];
    
            if ($id_area == 1){
    
                $tabla_ventas_detalles="playa_".$tabla_ventas_detalles;
            
            }
            // Prepara la consulta.
            $query = "SELECT $tabla_productos.descripcion as 'producto', 
                        $tabla_ventas_detalles.cantidad,
                        $tabla_ventas_detalles.precio_unitario,
                        $tabla_ventas_detalles.precio_total 
                FROM $tabla_ventas_detalles
                INNER JOIN $tabla_productos
                    ON $tabla_ventas_detalles.id_producto = $tabla_productos.id
                WHERE $tabla_ventas_detalles.id_venta = $id_venta";

            // Consulta el listado de ventas_detalle.
            $tabla_ventas_detalles = consultar_listado($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($tabla_ventas_detalles === false)
            {
                die("Ocurrió un error al buscar el listado de ventas_detalles");
            }    
        }
        
        // Instancia del PDF.
        $mpdf = new \Mpdf\Mpdf();
        
        // Contenido.
        $contenido = '
            <b style="font-size:100%">DARUMA S.A</b>
            <br>
            <b style="font-size:100%">C.U.I.T.: 30-20203030-3</b>
            <br>
            <b style="font-size:100%">CORONEL CHAMIZO N° 3345</b>
            <br>
            <b style="font-size:100%">GERLI, CP: 3343</b>
            <br>
            <b style="font-size:100%">IVA RESP. INSCRIPTO</b>
            <br>
            <b style="font-size:100%">A CONSUMIDOR FINAL</b>
            <br>
            <b style="font-size:100%">INI ACT: 01/03/2019</b>
            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    Fecha: <b>' . date("d/m/y") . '</b>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    Medio de pago: <b>' . $tabla_ventas->tipo_pago . '</b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    Vendedor: <b>' . $tabla_ventas->vendedor . '</b>
                </div>
            </div>

            <br>
            <br>
            <hr>
            <h3>Numero de Ticket: ' . $tabla_ventas->numero_factura . '</h3>
            
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
                
                foreach ($tabla_ventas_detalles as $tabla_producto)
                {
                    $contenido .='
                    <tr>
                        <td>' . $tabla_producto['producto'] . '</td>
                        <td>' . $tabla_producto['cantidad'] . '</td>
                        <td align="right"> $' . $tabla_producto['precio_unitario'] . '</td>
                        <td align="right"> $' . $tabla_producto['precio_total'] . '</td>
                    </tr>';
                }
                
            $contenido .= '
                </tbody>
            </table>
        </div>';
        
        // Escribir PDF.
        $mpdf->WriteHTML($contenido);

        // Descarga PDF.
        $mpdf->Output('ticket-' . $id_venta . '.pdf', 'D');
        //$mpdf->Output();
    }
    catch(Excepcion $e) {
        print('Esto es lo que pasó: ' . $e);
    }
?>