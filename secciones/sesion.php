<?php
    // Comienza o reanuda la sesión.
    session_start();
    
    // Validar sesión.
    if(!isset($_SESSION['usuario']))
    {
        $_SESSION['paginaRedireccion'] = $_SERVER['PHP_SELF'];
        header("location: ingreso.php");
    }

    function tienePermiso($id_permiso)
    {
		if(array_search($id_permiso, array_column($_SESSION['usuario']->permisos, 'codigo_permiso')) !== false)
		{
			return true;
		}
		return false;
    }
?>