<?php
    //header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    $id_area = $_GET["id_area"];

    if($id_area == 1)
    {
        // Prepara la consulta.
        $query = "SELECT razon_social,
                         importe_total,
                         DATE_FORMAT(fecha_venta, '%d/%m/%Y') as 'fecha_venta'
                
                  FROM playa_ventas
                
                  WHERE YEAR(fecha_venta) = 2019 AND MONTH(fecha_venta) = 12";
    }
    else
    {
        // Prepara la consulta.
        $query = "SELECT razon_social,
                         importe_total,
                         DATE_FORMAT(fecha_venta, '%d/%m/%Y') as 'fecha_venta'
                
                  FROM ventas
                
                  WHERE YEAR(fecha_venta) = 2019 AND MONTH(fecha_venta) = 12";
    }
    

    // Consulta el listado de ventas.
    $ventas = consultar_listado($conexion, $query);

    // Si hubo error ejecutando la consulta.
    if($ventas === false)
    {
        die("Ocurrió un error al buscar el listado de ventas");
    }    

    // Instancia del PDF.
    $mpdf = new \Mpdf\Mpdf();

    // Contenido.
    $contenido = '
    
    <h1 style="text-align:center;font-size:100%">
        Reporte de Ventas en ' . ($id_area == 1 ? 'Playa' : 'Mercado') . ' Diciembre 2019
    </h1>
    
    <div class="row">

        <div class="col-md-6">
            Fecha de visualización: <b>' . date("d/m/y") . '</b>
        </div>

    </div>
    
    <hr>
    
    <table style="width: 100%">
        <thead>
            <tr>
                <th align="left">Razón Social</th>
                <th align="right">Importe</th>
                <th align="center">Fecha</th>
            </tr>
        </thead>
        <tbody>';
        
        $total = 0;
        
        foreach ($ventas as $venta)
        {
            $contenido .='
            <tr>
                <td align="left">' . ($venta['razon_social'] != '' ? $venta['razon_social'] : 'Mostrador') . '</td>
                <td align="right"> $ ' . $venta['importe_total'] . '</td>
                <td align="center">' . $venta['fecha_venta'] . '</td>
            </tr>';
            
            $total += $venta['importe_total'];
        }

    $contenido .= '
        </tbody>
    </table>
    <h3 style="text-align:right;">Total: $ ' . $total . '</h3>
    ';

    // Escribir PDF.
    $mpdf->WriteHTML($contenido);

    // Salida al navegador.
    $mpdf->Output('reporte_ventas.pdf', 'D');
    //$mpdf->Output();
?>