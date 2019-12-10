<?php
    //header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    $id_area = $_GET["id_area"];

    if($id_area == 1)
    {
        // Prepara la consulta.
        $query = "SELECT playa_proveedores.razon_social,
                         importe_total,
                         DATE_FORMAT(fecha_compra, '%d/%m/%Y') as 'fecha_compra'
                
                  FROM playa_compras

                  INNER JOIN playa_proveedores
                    ON playa_compras.id_proveedor = playa_proveedores.id
                
                  WHERE YEAR(fecha_compra) = 2019 AND MONTH(fecha_compra) = 12";
    }
    else
    {
        // Prepara la consulta.
        $query = "SELECT proveedores.razon_social,
                         importe_total,
                         DATE_FORMAT(fecha_compra, '%d/%m/%Y') as 'fecha_compra'
                
                  FROM compras

                  INNER JOIN proveedores
                    ON compras.id_proveedor = proveedores.id
                
                  WHERE YEAR(fecha_compra) = 2019 AND MONTH(fecha_compra) = 12";
    }
    

    // Consulta el listado de compras.
    $compras = consultar_listado($conexion, $query);

    // Si hubo error ejecutando la consulta.
    if($compras === false)
    {
        die("Ocurrió un error al buscar el listado de compras");
    }    

    // Instancia del PDF.
    $mpdf = new \Mpdf\Mpdf();

    // Contenido.
    $contenido = '
    
    <h1 style="text-align:center;font-size:100%">
        Reporte de Compras en ' . ($id_area == 1 ? 'Playa' : 'Mercado') . ' Diciembre 2019
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
        
        foreach ($compras as $compra)
        {
            $contenido .='
            <tr>
                <td align="left">' . ($compra['razon_social'] != '' ? $compra['razon_social'] : 'Mostrador') . '</td>
                <td align="right"> $ ' . $compra['importe_total'] . '</td>
                <td align="center">' . $compra['fecha_compra'] . '</td>
            </tr>';
            
            $total += $compra['importe_total'];
        }

    $contenido .= '
        </tbody>
    </table>
    <h3 style="text-align:right;">Total: $ ' . $total . '</h3>
    ';

    // Escribir PDF.
    $mpdf->WriteHTML($contenido);

    // Salida al navegador.
    $mpdf->Output('reporte_compras.pdf', 'D');
    //$mpdf->Output();
?>