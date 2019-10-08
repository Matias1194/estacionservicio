<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'movimientos_caja';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();
        
        $accion = $_POST['accion'];

        // BUSCAR: Listado de caja.
        if($accion == "listado") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            //validarPermiso($conexion, $tabla, $accion, $respuesta, true);

            // Prepara la consulta.
            $query = "SELECT movimientos_caja.id, 
                             tipos_registros_caja.descripcion as 'registro', 
                             movimientos_caja.entrada, 
                             movimientos_caja.salida, 
                             movimientos_caja.saldo, 
                             tipos_pagos.descripcion as 'tipo_pago', 
                             movimientos_caja.fecha, 
                             usuarios.usuario

                      FROM movimientos_caja
                      
                      LEFT OUTER JOIN tipos_registros_caja
                        ON movimientos_caja.id_tipo_registro_caja = tipos_registros_caja.id
                      LEFT OUTER JOIN tipos_pagos
                        ON movimientos_caja.id_pago = tipos_pagos.id
                      LEFT OUTER JOIN usuarios
                        ON movimientos_caja.id_usuario = usuarios.id";
            
            // Consulta el listado de caja.
            $movimientos_caja = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($movimientos_caja === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de caja (L 51).";
            }
            // Si la consulta fue exitosa.
            else
            {
                // Prepara la consulta.
                $query = "SELECT *
                          FROM tipos_registros_caja";

                // Consulta el listado de caja.
                $tipos_registros_caja = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($tipos_registros_caja === false)
                {
                $respuesta['descripcion'] = "Ocurrió un error al buscar el listado de caja (L 51).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['movimientos_caja'] = $movimientos_caja;
                    $respuesta['tipos_registros_caja'] = $tipos_registros_caja;
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