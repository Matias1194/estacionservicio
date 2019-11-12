$(function() 
{
    navegador.asignarEventos();
});

var navegador = 
{
    asignarEventos : function() 
    {
        // Botones del Menú.
        $('nav a[data-url]').unbind('click').click((e) => redireccionar.pagina($(e.target).data('url') + '.php?area=' + $(e.target).data('area')))

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

    inicio : function() 
    {
        redireccionar.pagina('inicio.php');
    },
    
    usuarios : function() 
    {
        redireccionar.pagina('usuarios.php');
    },
    
    ingreso : function() 
    {
        redireccionar.pagina('ingreso.php');
    },

    clientes : function() 
    {
        redireccionar.pagina('clientes.php');
    },
    
    productos : function() 
    {
        redireccionar.pagina('productos.php');
    },
    
    compras : function() 
    {
        redireccionar.pagina('compras.php');
    },

    ventas : function() 
    {
        redireccionar.pagina('ventas.php');
    },

    stock : function() 
    {
        redireccionar.pagina('stock.php');
    }
}