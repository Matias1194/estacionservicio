$(function() 
{
	clientes.inicializar();
});

var clientes =
{
    area : null,
    modulo : 'clientes',

    inicializar : function() 
    {
        this.area = $('#area').val();
        if(this.area == "1")
        {
            this.modulo = 'playa_' + this.modulo;
        }
        
        this.buscar.listado();
    },

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();

        // Vuelve a la pantalla anterior.
        $('.botonVolver').unbind('click').click((e) => clientes.mostrar($(e.target).data('pantalla')));
        
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
        $('button[name="editar"]').unbind('click').click((e) => clientes.editar.buscar($(e.target).closest('tr').data('id')));

        // Confirmar editar cliente.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', clientes.editar.confirmar));
    
    /* Eliminar cliente */
        // Confirmar uliminar cliente.
        $('button[name="eliminar"]').unbind('click').click((e) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => clientes.eliminar.confirmar($(e.target).closest('tr').data('id'))));
    
    /* Deshabilitar cliente */
        // Confirmar deshabilitar cliente.
        $('button[name="deshabilitar"]').unbind('click').click((e) => alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => clientes.deshabilitar.confirmar($(e.target).closest('tr').data('id'))));

    /* Habilitar cliente */
        // Confirmar uabilitar cliente.
        $('button[name="habilitar"]').unbind('click').click((e) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => clientes.habilitar.confirmar($(e.target).closest('tr').data('id'))));

	},
	
    // Pantallas.
	ocultarDivs : function() 
    {
        $('.tooltip').tooltip('hide');
        $('#divListadoClientes').hide();
        $('#divNuevoCliente').hide();
        $('#divEditarCliente').hide();
    },

    mostrar : function(pantalla)
    {
        clientes.ocultarDivs();
        $('#div' + pantalla + 'Clientes').fadeIn();
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
                area : clientes.area,
                accion : 'listado'
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
                $.each(respuesta.clientes, function(i, cliente) 
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
                                .append(cliente.domicilio)
                            )
                            .append($('<td>')
                                .append(cliente.email)
                            )
                            .append($('<td>')
                                .append(cliente.telefono)
                            )
                            .append($('<td>')
                                .attr('class', 'text-center')
                            )
                            .attr('data-id', cliente.id)
                        );

                    
                    let acciones = "";
                    
                    // Botón Editar.
                    if(utilidades.tienePermiso(respuesta.permisos, 16) || utilidades.tienePermiso(respuesta.permisos, 73))
                    {
                        acciones += '<button type="button" name="editar" class="btn btn-sm btn-warning" title="Editar">'
                                        + '<span class="fa fa-pencil-alt"></span>'
                                + '</button>';
                    }
                    // Botón Eliminar.
                    if(utilidades.tienePermiso(respuesta.permisos, 18) || utilidades.tienePermiso(respuesta.permisos, 75))
                    {
                        acciones += '&nbsp;<button type="button" name="eliminar" class="btn btn-sm btn-secondary" title="Eliminar">'
                                        + '<span class="fa fa-trash"></span>'
                                + '</button>';
                    }

                    // Botón Deshabilitar.
                    if((utilidades.tienePermiso(respuesta.permisos, 19) || utilidades.tienePermiso(respuesta.permisos, 76)) && cliente.habilitado == "1")
                    {
                        acciones += '&nbsp;<button type="button" name="deshabilitar" class="btn btn-sm btn-danger" title="Deshabilitar">'
                                        + '<span class="fa fa-ban"></span>'
                                + '</button>';
                    }
                    // Botón Habilitar.
                    else if(utilidades.tienePermiso(respuesta.permisos, 20) || utilidades.tienePermiso(respuesta.permisos, 77)) 
                    {
                        acciones += '&nbsp;<button type="button" name="habilitar" class="btn btn-sm btn-success" title="Habilitar">'
                                        + '<span class="fa fa-check"></span>'
                                + '</button>';
                        
                        $(tablaClientes).find('tbody tr:last').addClass('table-danger');
                    }

                    $(tablaClientes).find('tbody tr:last td:last').append(acciones);
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
                area : clientes.area,
                accion : 'nuevo_buscar'
            };

            bd.enviar(datos, clientes.modulo, clientes.nuevo.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // Borro los datos en los campos.
            $('#divNuevoCliente form').find('input:not([readonly])').val("");
            
            clientes.mostrarNuevo();
        },

        // Confirmar nuevo cliente.
        confirmar : function() 
        {
            var datos = 
            {
                area : clientes.area,
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
            alertas.exito(respuesta.descripcion, '' , () => redireccionar.pagina('clientes.php?area=' + clientes.area));
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
                area : clientes.area,
                accion : 'editar_buscar',
                id : id
            };
            
            bd.enviar(datos, clientes.modulo, clientes.editar.buscarExito);
        },

        buscarExito : function(respuesta)
        {
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
                area : clientes.area,
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
            alertas.exito(respuesta.descripcion, '' , () => redireccionar.pagina('clientes.php?area=' + clientes.area));
        }
    },

    // Eliminar cliente.
    eliminar :
    {
        // Confirmar eliminación de cliente.
        confirmar : function(id)
        {
            var datos = {
                area : clientes.area,
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
                area : clientes.area,
                accion : 'deshabilitar',
                id : id
            };
            
            bd.enviar(datos, clientes.modulo, clientes.deshabilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            
            var $fila = $('#divListadoClientes tr[data-id="' + id + '"]');
            var $boton = $fila.find('td:last button[name="deshabilitar"]');
            
            $fila.addClass('table-danger');
            $boton.empty();
            $boton.removeClass('btn-danger').addClass('btn-success');
            $boton.attr('name', 'habilitar');
            $boton.attr('title', 'Habilitar');
            $boton.append($('<span>').addClass('fa fa-check'));
            
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
                area : clientes.area,
                accion : 'habilitar',
                id : id
            };
            
            bd.enviar(datos, clientes.modulo, clientes.habilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            
            var $fila = $('#divListadoClientes tr[data-id="' + id + '"]');
            var $boton = $fila.find('td:last button[name="habilitar"]');
            
            $fila.removeClass('table-danger');
            $boton.empty();
            $boton.removeClass('btn-success').addClass('btn-danger');
            $boton.attr('name', 'deshabilitar');
            $boton.attr('title', 'Deshabilitar');
            $boton.append($('<span>').addClass('fa fa-ban'));
            
            clientes.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    }
}