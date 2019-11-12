<?php
    header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    try {

        $id_venta = $_GET['id'];

        $tabla= "ventas";

        $id_area = $_GET["id_area"];

        if ($id_area == 1){
            $tabla="playa_".$tabla;
        }
        // Prepara la consulta.
        $query = "SELECT $tabla.numero_factura, 
                         $tabla.fecha_venta,
                         tipos_pagos.descripcion as 'tipo_pago',
                         CONCAT(usuarios.nombres, ' ', usuarios.apellidos) as 'vendedor'
                  FROM $tabla
                  INNER JOIN tipos_pagos
                    ON tipos_pagos.id = $tabla.id_tipo_pago
                  INNER JOIN usuarios
                    ON $tabla.id_usuario_vendedor = usuarios.id
                  WHERE $tabla.id = $id_venta";

        // Consulta una venta.
        $tabla = consultar_registro($conexion, $query);
            
        // Si hubo error ejecutando la consulta.
        if($tabla === false)
        {
            $respuesta['descripcion'] = "Ocurrió un error al buscar la venta (L 38).";
        }
        // Si la consulta fue exitosa y la venta se encuentra.
        else 
        {
            $ventas_detalles= "ventas_detalle";
            $id_area= $_GET["id_area"];

            if ($id_area== 1){
                $tabla="playa_".$tabla;
            }
            // Prepara la consulta.
            $query = "SELECT productos.descripcion as 'producto', 
                        $ventas_detalles.cantidad,
                        $ventas_detalles.precio_unitario,
                        $ventas_detalles.precio_total 
                FROM $ventas_detalles
                INNER JOIN productos
                    ON $ventas_detalles.id_producto = productos.id
                WHERE $ventas_detalles.id_venta = $id_venta";

            // Consulta el listado de ventas_detalle.
            $ventas_detalles = consultar_listado($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($ventas_detalles === false)
            {
                die("Ocurrió un error al buscar el listado de ventas_detalles");
            }
            $id_cliente = $_GET['id'];

            $tabla_clientes="cliente";

            $id_area = $_GET["id_area"];

            if ($id_area== 1){
                $tabla="playa_".$tabla;
            }

            // Prepara la consulta.
            $query = "SELECT $tabla_clientes.razon_social, 
                         $tabla_clientes.cuit,
                         $tabla_clientes.domiclio,
                         $tabla_clientes.telefono
                  FROM $tabla_clientes
                  WHERE $tabla_clientes.id = $id_cliente";

            // Consulta al cliente.
            $tabla_clientes = consultar_registro($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($tabla_clientes === false)
            {
            $respuesta['descripcion'] = "Ocurrió un error al buscar la venta (L 91).";
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
            
            <hr>
            
            <h6 style="text-align: left;"><strong>Razon social: <b>' . $tabla_clientes->razon_social . '</b></strong></h6>
            
            <h6 style="text-align: left;"><strong>C.U.I.T: <b>' . $tabla_clientes->cuit . '</b></strong></h6>
            
            <h6 style="text-align: left;"><strong>Domicilio: <b>' . $tabla_clientes->domicilio . '</b></strong></h6>
            
            <h6 style="text-align: left;"><strong>Telefono: <b>' . $tabla_clientes->telefono . '</b></strong></h6>
            
            <hr>

            <div class="row">
                <div class="col-md-6">
                    Fecha: <b>' . date("d/m/y") . '</b>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    Medio de pago: <b>' . $tabla->tipo_pago . '</b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    Vendedor: <b>' . $tabla->vendedor . '</b>
                </div>
            </div>

            <br>
            <br>
            <hr>
            <h3>Numero de Factura: ' . $tabla->numero_factura . '</h3>
            
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