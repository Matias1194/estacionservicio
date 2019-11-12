<?php
    header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();

    $tabla_productos = "productos";

    $tabla_stock = "stock";

    $id_area = $_GET["id_area"];

    if ($id_area == 1){

        $tabla_productos="playa_".$tabla_productos;
    
    }
    
    // Prepara la consulta.
    $query = "SELECT $tabla_productos.descripcion as 'producto', 
                     $tabla_stock.unidades 
             FROM $tabla_stock
             INNER JOIN $tabla_productos
                ON $tabla_stock.id_producto = productos.id";

    // Consulta el listado de stock.
    $tabla_stock = consultar_listado($conexion, $query);

    // Si hubo error ejecutando la consulta.
    if($tabla_stock === false)
    {
        die("Ocurrió un error al buscar el listado de stock");
    }    

    // Instancia del PDF.
    $mpdf = new \Mpdf\Mpdf();

    // Contenido.
    $contenido = '
    
    <h6 style="text-align: center;font-size:100%"><strong>Stock</strong></h6>
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
                <th>Unidades</th>
            </tr>
        </thead>
        <tbody>';
        
        foreach ($tabla_stock as $tabla_productos)
        {
            $contenido .='
            <tr>
                <td>' . $tabla_productos['producto'] . '</td>
                <td>' . $tabla_productos['unidades'] . '</td>
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