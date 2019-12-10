$(function() 
{
	reportes.inicializar();
});

var reportes =
{
    $div: null,
    area : null,
    modulo : 'reportes',

    inicializar : function()
    {
        this.$div = $('#inicio');
        this.area = $('#area').val();
        if(this.area == "1")
        {
            this.modulo = 'playa_' + this.modulo;
        }

        this.$div.fadeIn();
        
        this.asignarEventos();
    },

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();
        
        // Desasignar eventos.
        this.$div.find('button').unbind('click');

        // Descargar Ventas.
        this.$div.find('button[name="descargar_ventas"]').click(() => reportes.descargar_ventas());

        // Descargar Compras.
        this.$div.find('button[name="descargar_compras"]').click(() => reportes.descargar_compras());

        // Descargar Stock.
        this.$div.find('button[name="descargar_stock"]').click(() => reportes.descargar_stock());
	},
	
    // Ocultar pantallas.
	ocultarPantallas : function() 
    {
        $('.tooltip').tooltip('hide');
        $('.container').children().hide();
    },

    descargar_ventas : function()
    {   
        redireccionar.pagina('reportes/reporte_ventas.php?id_area=' + reportes.area);
    },

    descargar_compras : function()
    {   
        redireccionar.pagina('reportes/reporte_compras.php?id_area=' + reportes.area);
    },

    descargar_stock : function()
    {   
        redireccionar.pagina('reportes/reporte_stock.php?id_area=' + reportes.area);
    },
}