<?php
    //header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    try {

        $id =  $_GET['id'];
        $fecha =  $_GET['fecha'];

        // Prepara la consulta.
        $query = "SELECT productos.descripcion as 'producto', 
                     compras_detalles.cantidad,
                     compras_detalles.precio_unitario,
                     compras_detalles.precio_total,
                     compras.fecha_compra 
             FROM compras_detalles
             INNER JOIN productos
                ON compras_detalles.id_producto = productos.id
             INNER JOIN compras
                on compras_detalles.id_compra = compras.id
                WHERE compras_detalles.id = $id and DATE (compras.fecha_compra) = $fecha";
                

        // Consulta el listado de compras_detalle.
        $compras_detalles = consultar_listado($conexion, $query);
        
        // Si hubo error ejecutando la consulta.
        if($compras_detalles === false)
        {
            die("Ocurrió un error al buscar el listado de compras_detalles");
        }
        
        // Instancia del PDF.
        $mpdf = new \Mpdf\Mpdf();
        
        // Contenido.
        $contenido = '
        
        <h1>Compras periodo</h1>
        <h2>Este sería un titulo</h2>
        <h3>Este sería subtitulo</h3>
        
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