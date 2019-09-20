$(function() 
{
	stock.inicializar();
});

var stock =
{
    modulo : 'stock',

    inicializar : function()
    {
        this.listado.$div = $('#listado');
        this.detalles.$div = $('#detalles');

        this.listado.buscar();
    },

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();
	},
	
    // Ocultar pantallas.
	ocultarPantallas : function() 
    {
        $('.tooltip').tooltip('hide');
        $('main').children().hide();
    },

    // Listado.
    listado : 
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Detalles.
            this.$div.find('button[name="detalles"]').click((e) => stock.detalles.buscar($(e.currentTarget).closest('tr').data('id')));
        },

        mostrar : function()
        {
            stock.ocultarPantallas();
            this.$div.fadeIn();
        },
        
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                accion : 'buscar_listado'
            };
            
            // Envía los datos.
            bd.enviar(datos, stock.modulo, (respuesta) => 
            {
                var tablaStock = $('#listado table');
                var barraCargando = $('#listado .barraCargando');
                $(tablaStock).find('tbody').html("");
    
                if(respuesta.stock.length == 0)
                {
                    $(tablaStock)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append("No se encontraron registros.")
                                .attr('class', 'text-center')
                                .attr('colspan', 5)
                            )
                        );
                }
                else
                {
                    $.each(respuesta.stock, function(indice, stock) 
                    {
                        $(tablaStock)
                            .find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                    .append(stock.id_producto)
                                )
                                .append($('<td>')
                                    .append(stock.producto)
                                )
                                .append($('<td>')
                                    .append(stock.unidades)
                                )
                                .attr('data-id', stock.id)
                            )
    
                        // Botón Detalles Stock.
                        //if(utilidades.tienePermiso(respuesta.permisos, 2))
                        //{
                            $(tablaStock)
                                .find('tbody tr:last')
                                .append($('<td>')
                                    .append('<button type="button" class="btn btn-sm btn-info" name="detalles" data-toggle="tooltip" data-placement="top" title="Detalles">'
                                            + '<span class="fa fa-eye"></span>'
                                        + ' </button>'
                                    )
                                    .attr('class', 'text-center')
                                );
                    });
                }
    
                $(barraCargando).slideUp();
                $(tablaStock).fadeIn();
    
                this.asignarEventos();
                this.mostrar();
            });
        }
    },

    // Detalles.
    detalles :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => stock.listado.mostrar());
        },

        mostrar : function()
        {
            stock.ocultarPantallas();
            this.$div.fadeIn();
        },

        buscar : function(id)
        {
            var datos = {
                accion : 'buscar_detalles',
                id : id
            };
            
            bd.enviar(datos, stock.modulo, (respuesta) =>
            {
                $.each($('#detalles label[data-label]'), function(i, label) 
                {
                    $(label).find('b').html(respuesta.stock[$(label).data('label')]);
                });

                var tablaDetalles = $('#detalles table');
                $(tablaDetalles).find('tbody').html("");

                $.each(respuesta.detalles, function(indice, detalle) 
                {
                    $(tablaDetalles)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(detalle.descripcion)
                            )
                            .append($('<td>')
                                .append(detalle.cantidad)
                            )
                            .append($('<td>')
                                .append(utilidades.formatearDinero(detalle.precio_unitario))
                            )
                            .append($('<td>')
                                .append(utilidades.formatearDinero(detalle.precio_total))
                            )
                        );
                });
                
                stock.detalles.asignarEventos();
                stock.detalles.mostrar();
            });
        }
    }
}