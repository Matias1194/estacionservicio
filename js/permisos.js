$(function() 
{
	permisos.inicializar();
});

var permisos =
{
    modulo : 'permisos',

    inicializar : function()
    {
        this.listado.$div = $('#listado');

        this.listado.buscar();
    },
	
    // Ocultar pantallas.
	ocultarPantallas : function() 
    {
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

            this.$div.find('select').unbind('change');

            this.$div.find('select').change(() => 
            {
                let id_perfil = this.$div.find('select[name="id_perfil"]').val();
                let id_modulo = this.$div.find('select[name="id_modulo"]').val();
                let id_area = this.$div.find('select[name="id_area"]').val();
                
                this.buscar(id_perfil, id_modulo, id_area);
            });

            // Botón Habilitar.
            this.$div.find('button[name="habilitar"]').click((e) => this.habilitar($(e.target).closest('tr').data('id')));

            // Botón Deshabilitar.
            this.$div.find('button[name="deshabilitar"]').click((e) => this.deshabilitar($(e.target).closest('tr').data('id')));
            
        },

        mostrar : function()
        {
            permisos.ocultarPantallas();
            this.$div.fadeIn();
        },
        
        buscar : function(id_perfil, id_modulo, id_area)
        {
            // Prepara los datos.
            var datos = {
                accion : 'listado',
                id_perfil : id_perfil ? id_perfil : 0,
                id_modulo : id_modulo ? id_modulo : 0,
                id_area : id_area ? id_area : 0,
            };
            
            // Envía los datos.
            bd.enviar(datos, permisos.modulo, (respuesta) => 
            {
                var tablaPermisos = $('#listado table');
                var barraCargando = $('#listado .barraCargando');
                $(tablaPermisos).find('tbody').html("");
    
                if(respuesta.permisos.length == 0)
                {
                    $(tablaPermisos)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append("No se encontraron registros.")
                                .attr('class', 'text-center')
                                .attr('colspan', 6)
                            )
                        );
                }
                else
                {
                    $.each(respuesta.permisos, function(i, fila)
                    {
                        $(tablaPermisos)
                            .find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                    .append(fila.id)
                                    .attr('class', 'ocultable')
                                )
                                .append($('<td>')
                                    .append(fila.perfil)
                                    .attr('class', 'ocultable')
                                )
                                .append($('<td>')
                                    .append(fila.area)
                                    .attr('class', 'ocultable')
                                )
                                .append($('<td>')
                                    .append(fila.modulo)
                                    .attr('class', 'ocultable')
                                )
                                .append($('<td>')
                                    .append(fila.permiso)
                                )
                                .append($('<td>')
                                    .attr('class', 'text-center')
                                )
                                .attr('data-id', fila.id)
                            )

                        // Botón Deshabilitar.
                        if(fila.habilitado == "1")
                        {
                            var boton = '<button type="button" name="deshabilitar" class="btn btn-sm btn-success" title="Deshabilitar">'
                                            + '<span class="fa fa-thumbs-up"></span>'
                                      + '</button>';
                        }
                        // Botón Habilitar.
                        else
                        {
                            var boton = '<button type="button" name="habilitar" class="btn btn-sm btn-secondary" title="Habilitar">'
                                            + '<span class="fa fa-thumbs-down"></span>'
                                      + '</button>';
                        }
                        
                        $(tablaPermisos).find('tbody tr:last td:last').append(boton);
                    });
                }
                
                $(barraCargando).slideUp();
                $(tablaPermisos).fadeIn();
    
                this.asignarEventos();
            });
        },

        habilitar : function(id)
            {
                // Prepara los datos.
                var datos = 
                {
                    accion : 'habilitar',
                    id : id
                };
                
                // Envía los datos.
                bd.enviar(datos, permisos.modulo, (respuesta) => 
                {
                    var $tabla = permisos.listado.$div.find('table');
                    var $fila = $tabla.find('tr[data-id="' + respuesta.id + '"]');
                    var $boton = $fila.find('td:last button[name="habilitar"]');
                    
                    $boton.empty();
                    $boton.removeClass('btn-secondary').addClass('btn-success');
                    $boton.attr('name', 'deshabilitar');
                    $boton.attr('title', 'Deshabilitar');
                    $boton.append($('<span>').addClass('fa fa-thumbs-up'));
                    
                    this.asignarEventos();
                });
            },

            deshabilitar : function(id)
            {
                // Prepara los datos.
                var datos = 
                {
                    accion : 'deshabilitar',
                    id : id
                };
                
                // Envía los datos.
                bd.enviar(datos, permisos.modulo, (respuesta) => 
                {
                    var $tabla = permisos.listado.$div.find('table');
                    var $fila = $tabla.find('tr[data-id="' + respuesta.id + '"]');
                    var $boton = $fila.find('td:last button[name="deshabilitar"]');
                    
                    $boton.empty();
                    $boton.removeClass('btn-success').addClass('btn-secondary');
                    $boton.attr('name', 'habilitar');
                    $boton.attr('title', 'Habilitar');
                    $boton.append($('<span>').addClass('fa fa-thumbs-down'));
                    
                    this.asignarEventos();
                });
            }
    }
}