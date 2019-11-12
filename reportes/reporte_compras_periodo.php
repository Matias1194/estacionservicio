<?php
    //header('Content-Type: application/pdf');

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bd/bd_conexion.php';
    
    $conexion = AbrirConexion();
    
    try {

        $id =  $_GET['id'];
        $fecha =  $_GET['fecha'];
        $tabla_productos = "productos";
        $tabla_compras = "compras";
        $tabla_compras_detalles = "compras_detalles";
    
        $id_area = $_GET["id_area"];
    
        if ($id_area == 1){
    
            $tabla_productos="playa_".$tabla_productos;
        
        }

        // Prepara la consulta.
        $query = "SELECT $tabla_productos.descripcion as 'producto', 
                     $tabla_compras_detalles.cantidad,
                     $tabla_compras_detalles.precio_unitario,
                     $tabla_compras_detalles.precio_total,
                     $tabla_compras.fecha_compra 
             FROM $tabla_compras_detalles
             INNER JOIN $tabla_productos
                ON $tabla_compras_detalles.id_producto = $tabla_productos.id
             INNER JOIN $tabla_compras
                on $tabla_compras_detalles.id_compra = $tabla_compras.id
                WHERE $tabla_compras_detalles.id = $id and DATE ($tabla_compras.fecha_compra) = $fecha";
                

        // Consulta el listado de compras_detalle.
        $tabla_compras_detalles = consultar_listado($conexion, $query);
        
        // Si hubo error ejecutando la consulta.
        if($tabla_compras_detalles === false)
        {
            die("Ocurrió un error al buscar el listado de compras_detalles");
        }
        
        // Instancia del PDF.
        $mpdf = new \Mpdf\Mpdf();
        
        // Contenido.
        $contenido = '
        
        <h6 style="text-align: center;font-size:100%"><strong>Compras periodo</strong></h6>
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
            
            foreach ($tabla_compras_detalles as $tabla_producto)
            {
                $contenido .='
                <tr>
                    <td>' . $tabla_producto['producto'] . '</td>
                    <td>' . $tabla_producto['cantidad'] . '</td>
                    <td>' . $tabla_producto['precio_unitario'] . '</td>
                    <td>' . $tabla_producto['precio_total'] . '</td>
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