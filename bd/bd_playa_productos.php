<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'playa_productos';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nuevo conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $area = $_POST['area'];
        $modulo = 6;
        $accion = $_POST['accion'];

        // BUSCAR: Listado de productos.
        if($accion == "listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT playa_productos.id, 
                             playa_productos.descripcion, 
                             playa_tipos_productos.descripcion as 'tipo_producto'
                      FROM playa_productos
                      INNER JOIN playa_tipos_productos
                        ON playa_productos.id_tipo_producto = playa_tipos_productos.id
                      WHERE playa_productos.habilitado = 1 AND playa_productos.eliminado = 0";

            // Consulta el listado de productos.
            $productos = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($productos === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de productos (L 37).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['productos'] = $productos;
            }
        }

        // NUEVO: Buscar información para crear producto.
        else if($accion == "nuevo_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);
            
            // Prepara la consulta.
            $query = "SELECT id, descripcion 
                        FROM playa_tipos_productos";

            // Consulta los tipos de comprobantes habilitados.
            $tipos_productos = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($tipos_productos === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los tipos de comprobantes (L 120).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['tipos_productos'] = $tipos_productos;
            }
        }

        // NUEVO: Confirmar nuevo producto.
        else if($accion == "nuevo_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, "nuevo_buscar", $respuesta, false);
            
            $producto = $_POST["producto"];
            
            // Prepara la consulta.
            $query = "INSERT INTO playa_productos (id_tipo_producto, descripcion, precio_unitario) "
            . "VALUES"
            . "("
                . $producto['id_tipo_producto'] . ", "
                . "'" . $producto['descripcion'] . "', "
                . $producto['precio_unitario']
            . ")";
            
            // Inserta un nuevo producto.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al guardar nuevo producto (L 184).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $id_producto = mysqli_insert_id($conexion);

                // Prepara la consulta.
                $query = "INSERT INTO playa_stock (id_producto) "
                . "VALUES (" . $id_producto . ")";
                
                // Inserta un nuevo producto en stock.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al guardar nuevo producto (L 114).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $producto["descripcion"] . "</b> se agregó correctamente a Productos.";
                }
            }
        }
        
        // EDITAR: Buscar información para editar producto.
        else if($accion == "editar_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id_producto = $_POST['id'];
            
            // Prepara la consulta.
            $query = "SELECT id, 
                             descripcion,
                             precio_unitario,
                             id_tipo_producto
                             
                      FROM playa_productos
                        
                      WHERE id = $id_producto";

            // Consulta detalles de el producto.
            $producto = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($producto === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del producto (L 172).";
            }
            // Si la consulta fue exitosa y no existe el producto.
            else if(empty($producto))
            {
                $respuesta['descripcion'] = "La producto que se intenta editar no existe.";
            }
            // Si la consulta fue exitosa.
            else
            {
                // Prepara la consulta.
                $query = "SELECT id, 
                                 descripcion
                            
                    FROM playa_tipos_productos";

                // Consulta tipos de productos.
                $tipos_productos = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($tipos_productos === false)
                {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del producto (L 172).";
                }
                // Si la consulta fue exitosa y no existe el producto.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['producto'] = $producto;
                    $respuesta['tipos_productos'] = $tipos_productos;
                }
            }
        }

        // EDITAR: Confirmar edición de producto.
        else if($accion == "editar_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, "nuevo_buscar", $respuesta, false);
            
            $producto = $_POST["producto"];
            
            // Prepara la consulta.
            $query = "UPDATE playa_productos 
                      SET id_tipo_producto = " . $producto['id_tipo_producto'] . ", 
                          descripcion = '" . $producto['descripcion'] . "',
                          precio_unitario = " . $producto['precio_unitario'] . "
                      
                      WHERE id = " . $producto['id'];
            
            // Edita una producto.
            $resultado = ejecutar($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($resultado === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al editar la producto (L 210).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['descripcion'] = "<b>" . $producto["descripcion"] . "</b> se editó correctamente.";
            }
        }

        // ELIMINAR: Confirmar eliminación de producto.
        else if($accion == "eliminar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM playa_productos 
                      WHERE id = $id LIMIT 1";

            // Consulta información del producto a eliminar.
            $productoDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($productoDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de producto (L 427).";
            }
            // Si la consulta fue exitosa y no existe el producto.
            else if(empty($productoDB))
            {
                $respuesta['descripcion'] = "El producto que se intenta eliminar no existe.";
            }
            // Si la consulta fue exitosa y existe el producto.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE playa_productos 
                          SET eliminado = 1 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del producto.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al eliminar producto (L 448).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Producto eliminada correctamente.";
                }
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