<?php
    session_start();
    
    include 'bd_conexion.php';

    $tabla = 'usuarios';

    // Prepara la respuesta.
    $respuesta = array(
        'exito' => false
    );

    if ($_POST)
    {
        // Abre una nueva conexión con la base de datos.
        $conexion = AbrirConexion();

        $accion = $_POST['accion'];

        // BUSCAR: Listado de usuarios.
        if($accion == "buscar_listado")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, true);
            
            // Prepara la consulta.
            $query = "SELECT usuarios.id, usuarios.usuario, perfiles.descripcion as 'perfil', usuarios.nombres, usuarios.apellidos, DATE_FORMAT(usuarios.fecha_registro, '%d/%m/%Y') as 'fecha_registro', usuarios.habilitado 
                      FROM usuarios 
                      INNER JOIN perfiles
                        ON usuarios.id_perfil = perfiles.id
                      WHERE usuarios.eliminado = 0";

            // Consulta el listado de usuarios.
            $usuarios = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($usuarios === false)
            {
                $respuesta['descripcion'] = 'Ocurrió un error al buscar el listado de usuarios (L 39).';
            }
            // Si la consulta fue exitosa.
            else
            {
                $respuesta['exito'] = true;
                $respuesta['usuarios'] = $usuarios;
            }
        }

        // BUSCAR: Detalles de usuario por id.
        else if($accion == "buscar_detalles")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT perfiles.descripcion as 'perfil_descripcion', usuarios.usuario, usuarios.nombres, usuarios.apellidos, DATE_FORMAT(usuarios.fecha_registro, '%d/%m/%Y') as 'fecha_registro', usuarios.habilitado 
                      FROM usuarios 
                      INNER JOIN perfiles 
                        ON usuarios.id_perfil = perfiles.id 
                      WHERE usuarios.id = $id LIMIT 1";

            // Consulta los detalles de usuario.
            $usuario = consultar_registro($conexion, $query);
            
            // Si hubo error ejecutando la consulta.
            if($usuario === false)
            {
                $respuesta['descripcion'] = 'Ocurrió un error al buscar los detalles del usuario (L 70).';
            }
            // Si la consulta fue exitosa y no se encuentra el usuario.
            else if(empty($usuario))
            {
                $respuesta['descripcion'] = 'El usuario no se encuentra.';
            }
            // Si la consulta fue exitosa y el usuario se encuentra.
            else 
            {
                $respuesta['exito'] = true;
                $respuesta['usuario'] = $usuario;
            }
        }

        // NUEVO: Buscar información para crear usuario.
        else if($accion == "nuevo_buscar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            // Prepara la consulta.
            $query = "SELECT id, descripcion 
                      FROM perfiles
                      WHERE habilitado = 1";

            // Consulta los perfiles habilitados.
            $tipos_perfiles = consultar_listado($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($tipos_perfiles === false)
            {
                $respuesta['descripcion'] = 'Ocurrió un error al buscar los perfiles (L 101).';
            }
            // Si la consulta fue exitosa.
            else
            {
                // Prepara la consulta.
                $query = "SELECT id, descripcion 
                          FROM tipos_documentos
                          WHERE habilitado = 1";

                // Consulta los tipos de documentos habilitados.
                $tipos_documentos = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($tipos_documentos === false)
                {
                    $respuesta['descripcion'] = 'Ocurrió un error al buscar los tipos de tipos_documentos (L 116).';
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['tipos_perfiles'] = $tipos_perfiles;
                    $respuesta['tipos_documentos'] = $tipos_documentos;
                }
            }
        }

        // NUEVO: Confirmar nuevo usuario.
        else if($accion == "nuevo_confirmar") 
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, "nuevo_buscar", $respuesta, false);

            $usuario = $_POST["usuario"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM usuarios
                      WHERE usuarios.usuario = '" . $usuario['usuario'] . "' LIMIT 1";

            // Consulta si existe usuario antes de insertarlo.
            $usuarioDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($usuarioDB === false)
            {
                $respuesta['descripcion'] = 'Ocurrió un error al guardar nuevo usuario (L 130).';
            }
            // Si la consulta fue exitosa y ya existe el usuario.
            else if(!empty($usuarioDB))
            {
                $respuesta['descripcion'] = 'El usuario ingresado ya existe.';
            }
            // Si la consulta fue exitosa y no existe el nombre de usuario.
            else
            {
                // Prepara la consulta.
                $query = "INSERT INTO usuarios (id_perfil, usuario, clave, nombres, apellidos, id_tipo_documento, documento, email, telefono) "
                           . "VALUES"
                           . "("
                                      . $usuario['id_perfil'] . ", "
                                . "'" . $usuario['usuario'] . "', "
                                . "'" . $usuario['clave'] . "', "
                                . "'" . $usuario['nombres'] . "', "
                                . "'" . $usuario['apellidos'] . "', "
                                      . $usuario['id_tipo_documento'] . ", "
                                      . $usuario['documento'] . ", "
                                . "'" . $usuario['email'] . "', "
                                . "'" . $usuario['telefono'] . "' "
                           . ")";

                // Inserta un nuevo usuario.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = 'Ocurrió un error al guardar nuevo usuario (L 157).';
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['descripcion'] = "<b>" . $usuario["usuario"] . "</b> se agregó correctamente a Usuarios.";
                }
            }
        }
        
        // EDITAR: Buscar información para editar usuario.
        else if($accion == "editar_buscar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT usuarios.id, usuarios.id_perfil, usuarios.usuario, usuarios.clave, usuarios.nombres, usuarios.apellidos, usuarios.id_tipo_documento, usuarios.documento, usuarios.email, usuarios.telefono, DATE_FORMAT(usuarios.fecha_registro, '%d/%m/%Y') as 'fecha_registro' 
                      FROM usuarios 
                      WHERE usuarios.id = $id LIMIT 1";

            // Consulta información del usuario a editar.
            $usuario = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($usuario === false)
            {
                $respuesta['descripcion'] = 'Ocurrió un error al buscar información de usuario (L 187).';
            }
            // Si la consulta fue exitosa y no existe el usuario.
            else if(empty($usuario))
            {
                $respuesta['descripcion'] = 'El usuario buscado no existe.';
            }
            // Si la consulta fue exitosa y existe el usuario.
            else
            {
                // Prepara la consulta.
                $query = "SELECT id, descripcion 
                          FROM perfiles
                          WHERE habilitado = 1";

                // Consulta los perfiles habilitados.
                $tipos_perfiles = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($tipos_perfiles === false)
                {
                    $respuesta['descripcion'] = 'Ocurrió un error al buscar los perfiles (L 231).';
                }
                // Si la consulta fue exitosa.
                else
                {
                    // Prepara la consulta.
                    $query = "SELECT id, descripcion 
                              FROM tipos_documentos
                              WHERE habilitado = 1";

                    // Consulta los tipos de documentos habilitados.
                    $tipos_documentos = consultar_listado($conexion, $query);

                    // Si hubo error ejecutando la consulta.
                    if($tipos_documentos === false)
                    {
                        $respuesta['descripcion'] = 'Ocurrió un error al buscar los tipos de documentos (L 207).';
                    }
                    // Si la consulta fue exitosa.
                    else
                    {
                        $respuesta['exito'] = true;
                        $respuesta['usuario'] = $usuario;
                        $respuesta['tipos_perfiles'] = $tipos_perfiles;
                        $respuesta['tipos_documentos'] = $tipos_documentos;
                    }
                }
            }
        }

        // EDITAR: Confirmar edición de usuario.
        else if($accion == "editar_confirmar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, "editar_buscar", $respuesta, false);

            $usuario = $_POST["usuario"];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM usuarios
                      WHERE usuarios.id = " . $usuario['id'] . " LIMIT 1";

            // Consulta información del usuario a editar.
            $usuarioDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($usuarioDB === false)
            {
                $respuesta['descripcion'] = 'Ocurrió un error al buscar información del usuario (L 238).';
            }
            // Si la consulta fue exitosa y no existe el usuario.
            else if(empty($usuarioDB))
            {
                $respuesta['descripcion'] = 'El usuario que se intenta editar no existe.';
            }
            // Si la consulta fue exitosa y existe el usuario.
            else
            {
                // Si el nombre de usuario cambió.
                if($usuario['usuario'] != $usuarioDB->usuario)
                {
                    // Prepara la consulta.
                    $query = "SELECT * 
                              FROM usuarios
                              WHERE usuarios.usuario = '" . $usuario['usuario'] . "' LIMIT 1";;

                    // Consulta información de usuario.
                    $usuarioDB = consultar_registro($conexion, $query);

                    // Si hubo error ejecutando la consulta.
                    if($usuarioDB === false)
                    {
                        $respuesta['descripcion'] = 'Ocurrió un error al buscar información del usuario (L 262).';
                    }
                    // Si la consulta fue exitosa y ya existe el nombre de usuario que se intenta editar.
                    else if(!empty($usuarioDB))
                    {
                        $respuesta['descripcion'] = 'El nombre de usuario ingresado ya se encuentra en uso.';
                    }
                    // Si la consulta fue exitosa y no existe el nombre de usuario que se intenta editar.
                    else
                    {
                        // Prepara la consulta.
                        $query = "UPDATE usuarios 
                                  SET id_perfil = " . $usuario['id_perfil'] . ", 
                                  usuario = '" . $usuario['usuario'] . "', 
                                  nombres = '" . $usuario['nombres'] . "', 
                                  apellidos = '" . $usuario['apellidos'] . ", '
                                  id_tipo_documento = '" . $usuario['id_tipo_documento'] . "', 
                                  documento = '" . $usuario['documento'] . "
                                  email = '" . $usuario['email'] . "', 
                                  telefono = '" . $usuario['telefono'] . "'
                                  WHERE id = " . $usuario['id'];
                        
                        // Actualizo la información del usuario.
                        $resultado = ejecutar($conexion, $query);
                        
                        // Si hubo error ejecutando la consulta.
                        if($resultado === false)
                        {
                            $respuesta['descripcion'] = 'Ocrrió un error al editar usuario (L 332).';
                        }
                        // Si la consulta fue exitosa.
                        else
                        {
                            $respuesta['exito'] = true;
                            $respuesta['descripcion'] = "<b>" . $usuario['usuario'] . "</b> se editó correctamente.";
                        }
                    }
                }
                // Si el nombre de usuario no cambió.
                else
                {
                    // Prepara la consulta.
                    $query = "UPDATE usuarios 
                                  SET id_perfil = " . $usuario['id_perfil'] . ", 
                                  usuario = '" . $usuario['usuario'] . "', 
                                  nombres = '" . $usuario['nombres'] . "', 
                                  apellidos = '" . $usuario['apellidos'] . "' , 
                                  id_tipo_documento = " . $usuario['id_tipo_documento'] . ", 
                                  documento = " . $usuario['documento'] . ", 
                                  email = '" . $usuario['email'] . "', 
                                  telefono = '" . $usuario['telefono'] . "'
                                  WHERE id = " . $usuario['id'];

                    // Actualizo la información del usuario.
                    $resultado = ejecutar($conexion, $query);
                    
                    // Si hubo error ejecutando la consulta.
                    if($resultado === false)
                    {
                        $respuesta['descripcion'] = 'Ocrrió un error al editar usuario (L 363).';
                    }
                    // Si la consulta fue exitosa.
                    else
                    {
                        $respuesta['exito'] = true;
                        $respuesta['descripcion'] = "<b>" . $usuario['usuario'] . "</b> se editó correctamente.";
                    }
                }
            }
        }

        // ELIMINAR: Confirmar eliminación de usuario.
        else if($accion == "eliminar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM usuarios 
                      WHERE id = $id LIMIT 1";

            // Consulta información del usuario a eliminar.
            $usuarioDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($usuarioDB === false)
            {
                $respuesta['descripcion'] = 'Ocurrió un error al buscar información de usuario (L 344).';
            }
            // Si la consulta fue exitosa y no existe el usuario.
            else if(empty($usuarioDB))
            {
                $respuesta['descripcion'] = 'El usuario que se intenta eliminar no existe.';
            }
            // Si la consulta fue exitosa y existe el usuario.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE usuarios 
                          SET eliminado = 1 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del usuario.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = 'Ocrrió un error al eliminar usuario (L 365).';
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = 'Usuario eliminado correctamente.';
                }
            }
        }

        // DESHABILITAR: Confirmar deshabilitación de usuario.
        else if($accion == "deshabilitar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM usuarios 
                      WHERE id = $id LIMIT 1";

            // Consulta información del usuario a deshabilitar.
            $usuarioDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($usuarioDB === false)
            {
                $respuesta['descripcion'] = 'Ocurrió un error al buscar información de usuario (L 396).';
            }
            // Si la consulta fue exitosa y no existe el usuario.
            else if(empty($usuarioDB))
            {
                $respuesta['descripcion'] = 'El usuario que se intenta deshabilitar no existe.';
            }
            // Si la consulta fue exitosa y existe el usuario.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE usuarios 
                          SET habilitado = 0 
                          WHERE id = $id LIMIT 1";

                // Actualiza la información del usuario.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al deshabilitar usuario (L 417).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Usuario deshabilitado correctamente.";
                }
            }
        }

        // HABILITAR: Confirmar habilitación de usuario.
        else if($accion == "habilitar")
        {
            // Valida si el perfil de usuario tiene permiso para realizar esa acción.
            validarPermiso($conexion, $area, $modulo, $accion, $respuesta, false);

            $id = $_POST['id'];

            // Prepara la consulta.
            $query = "SELECT * 
                      FROM usuarios 
                      WHERE id = $id LIMIT 1";

            // Consulta información del usuario a habilitar.
            $usuarioDB = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($usuarioDB === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de usuario (L 448).";
            }
            // Si la consulta fue exitosa y no existe el usuario.
            else if(empty($usuarioDB))
            {
                $respuesta['descripcion'] = "El usuario que se intenta habilitar no existe.";
            }
            // Si la consulta fue exitosa y existe el usuario.
            else
            {
                // Prepara la consulta.
                $query = "UPDATE usuarios 
                          SET habilitado = 1 
                          WHERE id = $id";

                // Actualiza la información del usuario.
                $resultado = ejecutar($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($resultado === false)
                {
                    $respuesta['descripcion'] = "Ocrrió un error al habilitar usuario (L 469).";
                }
                // Si la consulta fue exitosa.
                else
                {
                    $respuesta['exito'] = true;
                    $respuesta['id'] = $id;
                    $respuesta['descripcion'] = "Usuario habilitado correctamente.";
                }
            }
        }

        // Iniciar sesión.
        else if($accion == "iniciarSesion")
        {
            $nombreUsuario = $_POST['usuario'];
            $clave = $_POST['clave'];

            // Prepara la consulta.
            $query = "SELECT id, id_perfil, usuario, nombres, apellidos 
                      FROM usuarios 
                      WHERE usuario = '$nombreUsuario' AND clave = '$clave' LIMIT 1";

            // Consulta información del usuario que inicia sesión.
            $usuario = consultar_registro($conexion, $query);

            // Si hubo error ejecutando la consulta.
            if($usuario === false)
            {
                $respuesta['descripcion'] = "Ocurrió un error al buscar información de usuario (L 498).";
            }
            // Si la consulta fue exitosa y no existe el usuario.
            else if(empty($usuario))
            {
                $respuesta['descripcion'] = "Usuario o clave incorrectos.";
            }
            // Si la consulta fue exitosa y existe el usuario.
            else
            {
                // Prepara la consulta.
                $query = "SELECT perfiles_permisos.id_permiso
                          FROM perfiles_permisos 
                          INNER JOIN permisos
                            ON perfiles_permisos.id_permiso = permisos.id
                          WHERE perfiles_permisos.habilitado = 1 AND perfiles_permisos.id_perfil = " . $usuario->id_perfil;

                // Consulta los permisos de usuario.
                $permisos = consultar_listado($conexion, $query);

                // Si hubo error ejecutando la consulta.
                if($permisos === false)
                {
                    $respuesta['descripcion'] = "Ocurrió un error al buscar información de usuario (L 521).";
                }
                // Si la consulta fue exitosa .
                else
                {
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['usuario']->permisos = $permisos;

                    $respuesta['exito'] = true;
                    $respuesta['usuario'] = $usuario->usuario;
                    $respuesta['url'] = (isset($_SESSION['paginaRedireccion']) ? $_SESSION['paginaRedireccion'] : "inicio.php");
                    unset($_SESSION['paginaRedireccion']);
                }
            }
        }

        // Cerrar sesión.
        else if($accion == "cerrarSesion")
        {
            session_destroy();

            $respuesta['exito'] = true;
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