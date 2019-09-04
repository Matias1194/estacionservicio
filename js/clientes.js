$(function() 
{
	clientes.buscar.listado();
});

var clientes =
{
    modulo : 'clientes',

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();

        // Vuelve al listado de clientes.
        $('.botonVolver').unbind('click').click(clientes.mostrarListado);
        
    /* Nuevo cliente */
        // Carga la pantalla para crear un nuevo cliente.
        $('#botonNuevoCliente').unbind('click').click(clientes.nuevo.buscar);

        // Confirmar nuevo cliente.
        $('#botonConfirmarNuevo').unbind('click').click(clientes.nuevo.confirmar);
        
        // Confirmar nuevo cliente al presionar la tecla Enter en el campo Clave.
        $('#campoClave')
            .keypress((k) => k.keyCode && k.keyCode == '13' ? this.nuevo.confirmar() : k.which && k.which == '13' ? this.nuevo.confirmar() : null);

    /* Editar cliente */
        // Carga la pantalla para editar al cliente.
        $('.botonEditarCliente').unbind('click').click((event) => clientes.editar.buscar($(event.currentTarget).closest('tr').data('id')));

        // Confirmar editar cliente.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', clientes.editar.confirmar));
    
    /* Eliminar cliente */
        // Confirmar uliminar cliente.
        $('.botonEliminarCliente').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => clientes.eliminar.confirmar($(event.currentTarget).closest('tr').data('id'))));
    
    /* Deshabilitar cliente */
        // Confirmar deshabilitar cliente.
        $('.botonDeshabilitarCliente').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => clientes.deshabilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

    /* Habilitar cliente */
        // Confirmar uabilitar cliente.
        $('.botonHabilitarCliente').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => clientes.habilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

	},
	
    // Pantallas.
	ocultarDivs : function() 
    {
        $('.tooltip').tooltip('hide');
        $('#divListadoClientes').hide();
        $('#divNuevoCliente').hide();
        $('#divEditarCliente').hide();
    },

    mostrarListado : function() 
    {
        clientes.ocultarDivs();
        $('#divListadoClientes').fadeIn();
    },

    mostrarNuevo : function() 
    {
        clientes.ocultarDivs();
        $('#divNuevoCliente').fadeIn();
    },

    mostrarEditar : function() 
    {
        clientes.ocultarDivs();
        $('#divEditarCliente').fadeIn();
    },

    // Buscar Listado.
    buscar :
    {
        listado : function()
        {
            var datos = {
                accion : 'buscar_listado'
            };

            bd.enviar(datos, clientes.modulo, clientes.buscar.listadoExito);
        },

        listadoExito : function(respuesta)
        {
            var tablaClientes = $('#divListadoClientes table');
            var barraCargando = $('#divListadoClientes .barraCargando');
            $(tablaClientes).find('tbody').html("");

            if(respuesta.clientes.length == 0)
            {
                $(tablaClientes)
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
                $.each(respuesta.clientes, function(indice, cliente) 
                {
                    $(tablaClientes)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(cliente.razon_social)
                            )
                            .append($('<td>')
                                .append(cliente.cuit)
                            )
                            .append($('<td>')
                                .append(cliente.tipo)
                            )
                            .append($('<td>')
                                .append(cliente.domicilio)
                            )
                            .append($('<td>')
                                .append(cliente.email)
                            )
                            .append($('<td>')
                                .append(cliente.telefono)
                            )
                            .attr('data-id', cliente.id)
                        )

                    // Botón Detalles Cliente.
                    //if(utilidades.tienePermiso(respuesta.permisos, 2))
                    //{
                        $(tablaClientes)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonDetallesCliente btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Detalles">'
                                        + '<span class="fa fa-eye"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}
                    
                    // Botón Editar Cliente.
                    //if(utilidades.tienePermiso(respuesta.permisos, 4))
                    //{
                        $(tablaClientes)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEditarCliente btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">'
                                        + '<span class="fa fa-pencil-alt"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}

                    // Botón Eliminar Cliente.
                    //if(utilidades.tienePermiso(respuesta.permisos, 7))
                    //{
                        $(tablaClientes)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEliminarCliente btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                        + '<span class="fa fa-trash"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}

                    // Si el cliente está habilitado.
                    //if(utilidades.tienePermiso(respuesta.permisos, 6) && cliente.habilitado == "1")
                    //{
                    if(cliente.habilitado == "1")
                    {
                        $(tablaClientes)
                            .find('tbody tr:last') 
                            .append($('<td>')
                                // Botón Deshabilitar Cliente.
                                .append('<button type="button" class="botonDeshabilitarCliente btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                                        + '<span class="fa fa-ban"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    }
                    // Si el cliente está deshabilitado.
                    //else if(utilidades.tienePermiso(respuesta.permisos, 5))
                    //{
                    else
                    {
                        $(tablaClientes)
                            .find('tbody tr:last')
                            .append($('<td>')
                                // Botón Habilitar Cliente.
                                .append('<button type="button" class="botonHabilitarCliente btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
                                        + '<span class="fa fa-check"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            )
                        // Fila de color rojo.
                        .attr('class', 'table-danger');
                    }
                });
            }

            $(barraCargando).slideUp();
            $(tablaClientes).fadeIn();
            
            clientes.asignarEventos();
        }
    },

    // Nuevo cliente.
    nuevo :
    {
        // Buscar información para crear cliente.
        buscar : function()
        {
            var datos = {
                accion : 'nuevo_buscar'
            };

            bd.enviar(datos, clientes.modulo, clientes.nuevo.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Tipo Cliente.
            var comboTipoCliente = $('#comboTipoClienteNuevo').html("");
            $(comboTipoCliente).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
            $.each(respuesta.tipos_clientes, function(i, tipo_cliente)
            {
                $(comboTipoCliente).append($("<option>").val(tipo_cliente.id).html(tipo_cliente.descripcion));
            });

            // Borro los datos en los campos.
            $('#divNuevoCliente form').find('input:not([readonly])').val("");
            
            clientes.mostrarNuevo();
        },

        // Confirmar nuevo cliente.
        confirmar : function() 
        {
            var datos = 
            {
                accion: 'nuevo_confirmar',
                cliente: {}
            };
            
            var mensajeError = "";
            var funcionCerrar;

            $.each($('#divNuevoCliente form').find('input:not([readonly]), select'), function(i, campo) 
            {
                if(!$(campo).val()) 
                {
                    mensajeError = "Falta completar el campo ";
                    if($(campo).prev().length > 0) 
                    {
                        mensajeError += $.trim($(campo).prev().html());
                    }
                    else
                    {
                        mensajeError += $.trim($(campo).parent().prev().html());
                    }

                    funcionCerrar = ()=> $(campo).focus();
                    return false;
                }

                datos.cliente[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError, '', funcionCerrar);
                return;
            }

            bd.enviar(datos, clientes.modulo, clientes.nuevo.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.clientes);
        }
    },

    // Editar cliente.
    editar :
    {
        // Buscar información para editar cliente.
        buscar : function(id)
        {
            var datos = 
            {
                accion : 'editar_buscar',
                id : id
            };
            
            bd.enviar(datos, clientes.modulo, clientes.editar.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Tipo Cliente.
            var comboTipoCliente = $('#comboTipoClienteEditar').html("");
            $.each(respuesta.tipos_clientes, function(i, opcion)
            {
                $(comboTipoCliente).append($("<option>").val(opcion.id).html(opcion.descripcion));
            });

            // Lleno los campos.
            $.each(respuesta.cliente, function(campo, valor)
            {
                $('#divEditarCliente form [name="' + campo + '"').val(valor);
            });

            clientes.mostrarEditar();
        },
        
        // Confirmar edición de cliente.
        confirmar : function()
        {
            var datos = 
            {
                accion: 'editar_confirmar',
                cliente: {}
            };
            var mensajeError = "";

            $.each($('#divEditarCliente form').find('input:not([readonly]), select'), function(i, campo) 
            {
                if(!$(campo).val()) 
                {
                    mensajeError = "Falta completar el campo ";
                    if($(campo).prev().length > 0) 
                    {
                        mensajeError += $.trim($(campo).prev().html());
                    }
                    else
                    {
                        mensajeError += $.trim($(campo).parent().prev().html());
                    }

                    $(campo).focus();
                    return false;
                }

                datos.cliente[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError);
                return;
            }

            bd.enviar(datos, clientes.modulo, clientes.editar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.clientes);
        }
    },

    // Eliminar cliente.
    eliminar :
    {
        // Confirmar eliminación de cliente.
        confirmar : function(id)
        {
            var datos = {
                accion : 'eliminar',
                id : id
            };
            
            bd.enviar(datos, clientes.modulo, clientes.eliminar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;

            $('#divListadoClientes tr[data-id="' + id + '"]')
                .fadeOut(
                    function() 
                    {
                        $(this).remove();
                    }
                );

            alertas.exito(respuesta.descripcion);
        }
    },

    // Deshabilitar cliente.
    deshabilitar :
    {
        // Confirmar deshabilitación de cliente.
        confirmar : function(id)
        {
            var datos = {
                accion : 'deshabilitar',
                id : id
            };
            
            bd.enviar(datos, clientes.modulo, clientes.deshabilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            var fila = $('#divListadoClientes tr[data-id="' + id + '"]');
            
            $(fila).addClass("table-danger");
            $(fila).find('td:last').html
            (
                '<button type="button" class="botonHabilitarCliente btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
                    + '<span class="fa fa-check"></span>'
                + ' </button>'
            );
            clientes.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    },

    // Habilitar cliente.
    habilitar :
    {
        // Confirmar habilitación de cliente.
        confirmar : function(id)
        {
            var datos = {
                accion : 'habilitar',
                id : id
            };
            
            bd.enviar(datos, clientes.modulo, clientes.habilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            var fila = $('#divListadoClientes tr[data-id="' + id + '"]');
            
            $(fila).removeClass();
            $(fila).find('td:last').html
            (
                '<button type="button" class="botonDeshabilitarCliente btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                    + '<span class="fa fa-ban"></span>'
                + ' </button>'
            );
            
            clientes.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    }
}