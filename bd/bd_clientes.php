<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'clientes';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // BUSCAR: Listado de clientes.
        if($accion == "buscar_listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT clientes.id, razon_social, cuit, domicilio, telefono, email, habilitado
                      FROM clientes
                      WHERE clientes.eliminado = 0";

            // Consulta el listado de clientes.
            $clientes = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($clientes === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de clientes (L 31).";
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['clientes'] = $clientes;
            }
        }

        // BUSCAR: Detalles de cliente por id.
        else if($accion == "buscar_detalles")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT clientes.id, clientes.nombres, clientes.apellidos, DATE_FORMAT(clientes.fecha_nacimiento, '%d/%m/%Y') as 'fecha_nacimiento', clientes.ocupacion, tipo_nacionalidad.descripcion as 'nacionalidad_descripcion', tipo_estado_civil.descripcion as 'estado_civil_descripcion', tipo_documento.descripcion as 'tipo_documento_descripcion', clientes.documento, clientes.domicilio, clientes.id_postal, clientes.localidad, clientes.provincia, clientes.telefono_fijo, clientes.telefono_celular, clientes.email, clientes.facebook, clientes.instagram, DATE_FORMAT(clientes.fecha_registro, '%d/%m/%Y') as 'fecha_registro' 
                      FROM clientes 
                      INNER JOIN tipo_nacionalidad 
                        ON clientes.id_nacionalidad = tipo_nacionalidad.id 
                      INNER JOIN tipo_estado_civil 
                        ON clientes.id_estado_civil = tipo_estado_civil.id 
                      INNER JOIN tipo_documento 
                        ON clientes.id_tipo_documento = tipo_documento.id 
                      WHERE clientes.id = $id LIMIT 1";
            
            // Consulta los detalles de cliente.
            $cliente = consultar_registro($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($cliente === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar los detalles del cliente (L 63).";
            }
            // Si la consulta fue exitosa y no se encuentra el cliente.
            else if(empty($cliente))
            {
                $respuesta['descripcion'] = "El cliente no se encuentra.";
            }
            // Si la consulta fue exitosa y el cliente se encuentra.
            else 
            {
                $respuesta['exito'] = true;
                $respuesta['cliente'] = $cliente;
            }
        }

        // NUEVO: Buscar información para crear cliente.
        else if($accion == "nuevo_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $respuesta['exito'] = true;
        }

        // NUEVO: Confirmar nuevo cliente.
        else if($accion == "nuevo_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "nuevo_buscar", $respuesta, false);

            $cliente = $_POST["cliente"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM clientes 
                      WHERE cuit = " .$cliente["cuit"] . " LIMIT 1";

            // Consulta si existe un cliente con mismo número de cuit antes de insertarlo.
            $clienteDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($clienteDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al guardar nuevo cliente (L 211).";
            }
            // Si la consulta fue exitosa y ya existe el cliente.
            else if(!empty($clienteDB))
            {
                $respuesta['descripcion'] = "El cliente ingresado ya se encuentra registrado.";
            }
            // Si la consulta fue exitosa y no existe el nombre de cliente.
            else
            {
                // Prepara la consulta.
                $query = "INSERT INTO clientes (id_tipo_cliente, razon_social, cuit, domicilio, telefono, email) "
                       . "VALUES"
                       . "("
                                  . 1 . ", "
                            . "'" . $cliente['razon_social'] . "', "
                                  . $cliente["cuit"] . ", "
                            . "'" . $cliente["domicilio"] . "', "
                            . "'" . $cliente["telefono"] . "', "
                            . "'" . $cliente["email"] . "'"
                       . ")";

                // Inserta un nuevo cliente.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al guardar nuevo cliente (L 160).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $cliente["razon_social"] . "</b> se agregó correctamente a Clientes.";
                }
            }
        }
        
        // EDITAR: Buscar información para editar cliente.
        else if($accion == "editar_buscar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM clientes 
                      WHERE id = $id LIMIT 1";
            
            // Consulta información del cliente a editar.
            $cliente = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($cliente === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de cliente (L 279).";
            }
            // Si la consulta fue exitosa y no existe el cliente.
            else if(empty($cliente))
            {
                $respuesta['descripcion'] = "El cliente buscado no existe.";
            }
            // Si la consulta fue exitosa y existe el cliente.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['cliente'] = $cliente;
            }
        }

        // EDITAR: Confirmar edición de cliente.
        else if($accion == "editar_confirmar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, "editar_buscar", $respuesta, false);

            $cliente = $_POST["cliente"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM clientes
                      WHERE clientes.id = " . $cliente['id'] . " LIMIT 1";

            // Consulta información del cliente a editar.
            $clienteDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($clienteDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información del cliente (L 361).";
            }
            // Si la consulta fue exitosa y no existe el cliente.
            else if(empty($clienteDB))
            {
                $respuesta['descripcion'] = "El cliente que se intenta editar no existe.";
            }
            // Si la consulta fue exitosa y existe el cliente.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE clientes 
                          SET id_tipo_cliente = " . $cliente['id_tipo_cliente'] . ", 
                          razon_social = '" . $cliente['razon_social'] . "', 
                          domicilio = '" . $cliente["domicilio"] . "', 
                          telefono = " . $cliente['telefono'] . ",  
                          email = '" . $cliente['email'] . "', 
                          cuit = " . $cliente['cuit'] . " 
                          WHERE id = " . $cliente['id'];
                
                // Actualizo la información del cliente.
                $resultado = ejecutar($conexion, $query);
                
                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al editar cliente (L 400).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $cliente['razon_social'] . "</b> se editó correctamente.";
                }
            }
        }

        // ELIMINAR: Confirmar eliminación de cliente.
        else if($accion == "eliminar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM clientes 
                      WHERE id = $id LIMIT 1";

            // Consulta información del cliente a eliminar.
            $clienteDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($clienteDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de cliente (L 427).";
            }
            // Si la consulta fue exitosa y no existe el cliente.
            else if(empty($clienteDB))
            {
                $respuesta['descripcion'] = "El cliente que se intenta eliminar no existe.";
            }
            // Si la consulta fue exitosa y existe el cliente.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE clientes 
                          SET eliminado = 1 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del cliente.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al eliminar cliente (L 448).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Cliente eliminado correctamente.";
                }
            }
        }

        // DESHABILITAR: Confirmar deshabilitación de cliente.
        else if($accion == "deshabilitar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM clientes 
                      WHERE id = $id LIMIT 1";

            // Consulta información del cliente a deshabilitar.
            $clienteDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($clienteDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de cliente (L 476).";
            }
            // Si la consulta fue exitosa y no existe el cliente.
            else if(empty($clienteDB))
            {
                $respuesta['descripcion'] = "El cliente que se intenta deshabilitar no existe.";
            }
            // Si la consulta fue exitosa y existe el cliente.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE clientes 
                          SET habilitado = 0 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del cliente.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al deshabilitar cliente (L 497).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Cliente deshabilitado correctamente.";
                }
            }
        }

        // HABILITAR: Confirmar habilitación de cliente.
        else if($accion == "habilitar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM clientes 
                      WHERE id = $id LIMIT 1";

            // Consulta información del cliente a habilitar.
            $clienteDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($clienteDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de cliente (L 525).";
            }
            // Si la consulta fue exitosa y no existe el cliente.
            else if(empty($clienteDB))
            {
                $respuesta['descripcion'] = "El cliente que se intenta habilitar no existe.";
            }
            // Si la consulta fue exitosa y existe el cliente.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE clientes 
                          SET habilitado = 1 
                          WHERE id = $id";

                // Actualiza la información del cliente.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al habilitar cliente (L 546).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Cliente habilitado correctamente.";
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