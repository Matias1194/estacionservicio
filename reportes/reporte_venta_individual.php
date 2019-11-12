<?php
    //header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    try {
        $tabla_productos= "productos";
        
        $tabla_ventas_detalle= "ventas_detalle";

        $id_area = $_GET["id_area"];

        if ($id_area == 1){

            $tabla="playa_".$tabla;
        
        }

        // Prepara la consulta.
        $query = "SELECT $tabla_productos.descripcion as 'producto', 
                     $tabla_ventas_detalle.cantidad,
                     $tabla_ventas_detalle.precio_unitario,
                     $tabla_ventas_detalle.precio_total 
             FROM $tabla_ventas_detalle
             INNER JOIN $tabla_productos
                ON $tabla_ventas_detalle.id_producto = $tabla_productos.id";

        // Consulta el listado de compras_detalle.
        $tabla_ventas_detalle = consultar_listado($conexion, $query);
        
        // Si hubo error ejecutando la consulta.
        if($tabla_ventas_detalle === false)
        {
            die("Ocurrió un error al buscar el listado de ventas_detalles");
        }
        
        // Instancia del PDF.
        $mpdf = new \Mpdf\Mpdf();
        
        // Contenido.
        $contenido = '
        
        <h6 style="text-align: center;font-size:100%"><strong>Ventas individual</strong></h6>
        <div class="row">
            <div class="col-md-6">
                Fecha: <b>' . date("d/m/y") . '</b>
            </div>

        </div>
        
        <hr>
        
        <table border="1">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Precio total</th>
                </tr>
            </thead>
            <tbody>';
            
            foreach ($compras_detalles as $producto)
            {
                $contenido .='
                <tr>
                    <td>' . $producto['producto'] . '</td>
                    <td>' . $producto['cantidad'] . '</td>
                    <td>' . $producto['precio_unitario'] . '</td>
                    <td>' . $producto['precio_total'] . '</td>
                </tr>';
            }
            
        $contenido .= '
            </tbody>
        </table>';
        
        // Escribir PDF.
        $mpdf->WriteHTML($contenido);

        // Salida al navegador.
        $mpdf->Output('reporte_compras_detalle.pdf', 'D');
    }
    catch(Excepcion $e) {
        print('Esto es lo que pasó: ' . $e);
    }
?>