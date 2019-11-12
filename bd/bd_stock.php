<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'stock';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // BUSCAR: Listado de stock.
        if($accion == "listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT stock.id, stock.id_producto, productos.descripcion as 'producto', stock.unidades 
                      FROM stock
                      INNER JOIN productos
                        ON stock.id_producto = productos.id";
            
            // Consulta el listado de stock.
            $stock = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($stock === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de stock (L 37).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['stock'] = $stock;
            }
        }
        
        else
        {
            $respuesta['descripcion'] = "Accion no especificada.";
        }

        // Cierra la conexión a la base de datos.
        cerrarConexion($conexion);
    }
    else
    {
        $respuesta['descripcion'] = "No se enviaron datos.";
    }

    // Devuelve la respuesta.
    echo json_encode($respuesta);
?>