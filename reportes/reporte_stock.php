<?php
    header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    // Prepara la consulta.
    $query = "SELECT productos.descripcion as 'producto', 
                     stock.unidades 
             FROM stock
             INNER JOIN productos
                ON stock.id_producto = productos.id";

    // Consulta el listado de stock.
    $stock = consultar_listado($conexion, $query);

    // Si hubo error ejecutando la consulta.
    if($stock === false)
    {
        die("Ocurrió un error al buscar el listado de stock");
    }    

    // Instancia del PDF.
    $mpdf = new \Mpdf\Mpdf();

    // Contenido.
    $contenido = '
    
    <h1>Stock</h1>
    <h2>Este sería un titulo</h2>
    <h3>Este sería subtitulo</h3>
    
    <hr>
    
    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Unidades</th>
            </tr>
        </thead>
        <tbody>';
        
        foreach ($stock as $producto)
        {
            $contenido .='
            <tr>
                <td>' . $producto['producto'] . '</td>
                <td>' . $producto['unidades'] . '</td>
            </tr>';
        }

    $contenido .= '
        </tbody>
    </table>';

    // Escribir PDF.
    $mpdf->WriteHTML($contenido);

    // Salida al navegador.
    $mpdf->Output('reporte_stock.pdf', 'D');
?>