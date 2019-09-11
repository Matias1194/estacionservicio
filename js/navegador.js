$(function() 
{
    navegador.asignarEventos();
});

var navegador = 
{
    asignarEventos : function() 
    {
        // Botones del Menú.
        $('nav a[data-url]').unbind('click').click((event) => redireccionar.pagina($(event.currentTarget).data('url') + '.php'))

        // Cerrar Sesión.
        $('nav #botonCerrarSesion').unbind('click').click(navegador.cerrarSesion);
    },

    cerrarSesion : function() 
    {
        var datos = 
        {
            accion: 'cerrarSesion'
        };

        bd.enviar(datos, 'usuarios', navegador.cerrarSesionExito);        
    },

    cerrarSesionExito : function()
    {
        redireccionar.ingreso();
    }
};

var redireccionar = 
{
    pagina : function(url)
    {
        window.location.href = url;
    },

    proveedores : function() 
    {
        redireccionar.pagina('proveedores.php');
    },

    clientes : function() 
    {
        redireccionar.pagina('clientes.php');
    },
    
    usuarios : function() 
    {
        redireccionar.pagina('usuarios.php');
    },
    
    compras : function() 
    {
        redireccionar.pagina('compras.php');
    },

    ventas : function() 
    {
        redireccionar.pagina('ventas.php');
    },
    
    ingreso : function() 
    {
        redireccionar.pagina('ingreso.php');
    },
    
    inicio : function() 
    {
        redireccionar.pagina('inicio.php');
    },
}