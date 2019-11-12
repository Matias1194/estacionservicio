$(function() 
{
	reportes.inicializar();
});

var reportes =
{
    area : null,
    modulo : 'reportes',

    inicializar : function()
    {
        this.area = $('#area').val();
        if(this.area == "1")
        {
            this.modulo = 'playa_' + this.modulo;
        }

        $('#inicio').fadeIn();
    },

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();
        
        // Desasignar eventos.
        this.$div.find('button').unbind('click');

        // Descargar.
        this.$div.find('button[name="descargar"]').click(() => reportes.ventas_descargar());
	},
	
    // Ocultar pantallas.
	ocultarPantallas : function() 
    {
        $('.tooltip').tooltip('hide');
        $('.container').children().hide();
    },

    descargar : function(id)
    {   
        redireccionar.pagina('reportes/reporte_ticket.php?id=' + id + '&id_area=' + reportes.area);
    },
}