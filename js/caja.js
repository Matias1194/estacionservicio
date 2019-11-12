$(function() 
{
	caja.inicializar();
});

var caja =
{
    area : null,
    modulo : 'caja',

    inicializar : function()
    {
        this.area = $('#area').val();
        if(this.area == "1")
        {
            this.modulo = 'playa_' + this.modulo;
        }
        
        this.listado.$div = $('#listado');

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
        $('.container').children().hide();
    },

    // Listado.
    listado : 
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');
        },

        mostrar : function()
        {
            caja.ocultarPantallas();
            this.$div.fadeIn();
        },
        
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                area : caja.area,
                accion : 'listado'
            };
            
            // Envía los datos.
            bd.enviar(datos, caja.modulo, (respuesta) => 
            {
                var tablaStock = $('#listado table');
                var barraCargando = $('#listado .barraCargando');
                $(tablaStock).find('tbody').html("");
    
                if(respuesta.movimientos_caja.length == 0)
                {
                    $(tablaStock)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append("No se encontraron registros.")
                                .attr('class', 'text-center')
                                .attr('colspan', 7)
                            )
                        );
                }
                else
                {
                    $.each(respuesta.movimientos_caja, function(i, fila) 
                    {
                        $(tablaStock)
                            .find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                    .append(fila.fecha)
                                )
                                .append($('<td>')
                                    .append(fila.registro)
                                )
                                .append($('<td>')
                                    .append(fila.entrada ? utilidades.formatearDinero(fila.entrada): '')
                                )
                                .append($('<td>')
                                    .append(fila.salida ? utilidades.formatearDinero(fila.salida) : '')
                                )
                                .append($('<td>')
                                    .append(fila.saldo ? utilidades.formatearDinero(fila.saldo): '')
                                )
                                .append($('<td>')
                                    .append(fila.tipo_pago)
                                )
                                .append($('<td>')
                                    .append(fila.usuario)
                                )
                                .attr('data-id', fila.id)
                            )
                    });

                    $(tablaStock).DataTable({order:[]});
                }

                // Llena combo Registros.
                var comboRegistros = this.$div.find('select[name="id_registro"]').html("");
                $(comboRegistros).append($('<option>').html("Registro").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_registros_caja, function(i, opcion)
                {
                    $(comboRegistros).append($("<option>")
                            .val(opcion.id)
                            .html(opcion.descripcion)
                        );
                });
    
                $(barraCargando).slideUp();
                $(tablaStock).fadeIn();
    
                this.asignarEventos();
                this.mostrar();
            });
        }
    }
}