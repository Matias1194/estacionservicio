<?php
    //header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();

    $id_area = $_GET["id_area"];

    if($id_area == 1)
    {
        // Prepara la consulta.
        $query = "SELECT playa_productos.descripcion,
                         unidades
                
                  FROM playa_stock

                  INNER JOIN playa_productos
                    ON playa_stock.id_producto = playa_productos.id
                
                  WHERE playa_productos.eliminado = 0";
    }
    else
    {
        // Prepara la consulta.
        $query = "SELECT productos.descripcion,
                         unidades
                
                  FROM stock

                  INNER JOIN productos
                    ON stock.id_producto = productos.id
                
                  WHERE productos.eliminado = 0";
    }
    
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
    
    <h6 style="text-align: center;font-size:100%">
        Reporte de Stock en ' . ($id_area == 1 ? 'Playa' : 'Mercado') . '
    </h6>
    
    <div class="row">
        
        <div class="col-md-6">
            Fecha de visualización: <b>' . date("d/m/y") . '</b>
        </div>

    </div>
    
    <hr>
    
    <table style="width: 100%">
        <thead>
            <tr>
                <th align="left">Productos</th>
                <th align="right">Unidades</th>
            </tr>
        </thead>
        <tbody>';
        
        foreach ($stock as $producto)
        {
            $contenido .='
            <tr>
                <td align="left">' . $producto['descripcion'] . '</td>
                <td align="right">' . $producto['unidades'] . '</td>
            </tr>';
        }

    $contenido .= '
        </tbody>
    </table>';

    // Escribir PDF.
    $mpdf->WriteHTML($contenido);

    // Salida al navegador.
    $mpdf->Output('reporte_stock.pdf', 'D');
    //$mpdf->Output();
?>