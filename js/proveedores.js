$(function() 
{
	proveedores.buscar.listado();
});

var proveedores =
{
    modulo : 'proveedores',

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();

        // Vuelve al listado de proveedores.
        $('.botonVolver').unbind('click').click(proveedores.mostrarListado);
        
    /* Nuevo proveedor */
        // Carga la pantalla para crear un nuevo proveedor.
        $('#botonNuevoProveedor').unbind('click').click(proveedores.nuevo.buscar);

        // Confirmar nuevo proveedor.
        $('#botonConfirmarNuevo').unbind('click').click(proveedores.nuevo.confirmar);
        
        // Confirmar nuevo proveedor al presionar la tecla Enter en el campo Clave.
        $('#campoClave')
            .keypress((k) => k.keyCode && k.keyCode == '13' ? this.nuevo.confirmar() : k.which && k.which == '13' ? this.nuevo.confirmar() : null);

    /* Editar proveedor */
        // Carga la pantalla para editar al proveedor.
        $('.botonEditarProveedor').unbind('click').click((event) => proveedores.editar.buscar($(event.currentTarget).closest('tr').data('id')));

        // Confirmar editar proveedor.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', proveedores.editar.confirmar));
    
    /* Eliminar proveedor */
        // Confirmar uliminar proveedor.
        $('.botonEliminarProveedor').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => proveedores.eliminar.confirmar($(event.currentTarget).closest('tr').data('id'))));
    
    /* Deshabilitar proveedor */
        // Confirmar deshabilitar proveedor.
        $('.botonDeshabilitarProveedor').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => proveedores.deshabilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

    /* Habilitar proveedor */
        // Confirmar uabilitar proveedor.
        $('.botonHabilitarProveedor').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => proveedores.habilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

	},
	
    // Pantallas.
	ocultarDivs : function() 
    {
        $('.tooltip').tooltip('hide');
        $('#divListadoProveedores').hide();
        $('#divNuevoProveedor').hide();
        $('#divEditarProveedor').hide();
    },

    mostrarListado : function() 
    {
        proveedores.ocultarDivs();
        $('#divListadoProveedores').fadeIn();
    },

    mostrarNuevo : function() 
    {
        proveedores.ocultarDivs();
        $('#divNuevoProveedor').fadeIn();
    },

    mostrarEditar : function() 
    {
        proveedores.ocultarDivs();
        $('#divEditarProveedor').fadeIn();
    },

    // Buscar Listado.
    buscar :
    {
        listado : function()
        {
            var datos = {
                accion : 'buscar_listado'
            };

            bd.enviar(datos, proveedores.modulo, proveedores.buscar.listadoExito);
        },

        listadoExito : function(respuesta)
        {
            var tablaProveedores = $('#divListadoProveedores table');
            var barraCargando = $('#divListadoProveedores .barraCargando');
            $(tablaProveedores).find('tbody').html("");

            if(respuesta.proveedores.length == 0)
            {
                $(tablaProveedores)
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
                $.each(respuesta.proveedores, function(indice, proveedor) 
                {
                    $(tablaProveedores)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(proveedor.razon_social)
                            )
                            .append($('<td>')
                                .append(proveedor.cuit)
                            )
                            .append($('<td>')
                                .append(proveedor.domicilio)
                            )
                            .append($('<td>')
                                .append(proveedor.email)
                            )
                            .append($('<td>')
                                .append(proveedor.telefono)
                            )
                            .attr('data-id', proveedor.id)
                        )

                    // Botón Detalles Proveedor.
                    //if(utilidades.tienePermiso(respuesta.permisos, 2))
                    //{
                        $(tablaProveedores)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonDetallesProveedor btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Detalles">'
                                        + '<span class="fa fa-eye"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}
                    
                    // Botón Editar Proveedor.
                    //if(utilidades.tienePermiso(respuesta.permisos, 4))
                    //{
                        $(tablaProveedores)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEditarProveedor btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">'
                                        + '<span class="fa fa-pencil-alt"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}

                    // Botón Eliminar Proveedor.
                    //if(utilidades.tienePermiso(respuesta.permisos, 7))
                    //{
                        $(tablaProveedores)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEliminarProveedor btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                        + '<span class="fa fa-trash"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}

                    // Si el proveedor está habilitado.
                    //if(utilidades.tienePermiso(respuesta.permisos, 6) && proveedor.habilitado == "1")
                    //{
                    if(proveedor.habilitado == "1")
                    {
                        $(tablaProveedores)
                            .find('tbody tr:last') 
                            .append($('<td>')
                                // Botón Deshabilitar Proveedor.
                                .append('<button type="button" class="botonDeshabilitarProveedor btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                                        + '<span class="fa fa-ban"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    }
                    // Si el proveedor está deshabilitado.
                    //else if(utilidades.tienePermiso(respuesta.permisos, 5))
                    //{
                    else
                    {
                        $(tablaProveedores)
                            .find('tbody tr:last')
                            .append($('<td>')
                                // Botón Habilitar Proveedor.
                                .append('<button type="button" class="botonHabilitarProveedor btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
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
            $(tablaProveedores).fadeIn();
            
            proveedores.asignarEventos();
        }
    },

    // Nuevo proveedor.
    nuevo :
    {
        // Buscar información para crear proveedor.
        buscar : function()
        {
            var datos = {
                accion : 'nuevo_buscar'
            };

            proveedores.mostrarNuevo();
            //bd.enviar(datos, proveedores.modulo, proveedores.nuevo.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Tipo Perfil.
            var comboTipoPerfil = $('#comboTipoPerfilNuevo').html("");
            $(comboTipoPerfil).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
            $.each(respuesta.tipos_perfiles, function(i, tipo_perfil)
            {
                $(comboTipoPerfil).append($("<option>").val(tipo_perfil.id).html(tipo_perfil.descripcion));
            });

            // Borro los datos en los campos.
            $('#divNuevoProveedor form').find('input:not([readonly])').val("");
            
            proveedores.mostrarNuevo();
        },

        // Confirmar nuevo proveedor.
        confirmar : function() 
        {
            var datos = 
            {
                accion: 'nuevo_confirmar',
                proveedor: {}
            };
            
            var mensajeError = "";
            var funcionCerrar;

            $.each($('#divNuevoProveedor form').find('input:not([readonly]), select'), function(i, campo) 
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

                datos.proveedor[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError, '', funcionCerrar);
                return;
            }

            bd.enviar(datos, proveedores.modulo, proveedores.nuevo.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.proveedores);
        }
    },

    // Editar proveedor.
    editar :
    {
        // Buscar información para editar proveedor.
        buscar : function(id)
        {
            var datos = 
            {
                accion : 'editar_buscar',
                id : id
            };
            
            bd.enviar(datos, proveedores.modulo, proveedores.editar.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Tipo Perfil.
            var comboTipoPerfil = $('#comboTipoPerfilEditar').html("");
            $.each(respuesta.tipos_perfiles, function(i, opcion)
            {
                $(comboTipoPerfil).append($("<option>").val(opcion.id).html(opcion.descripcion));
            });

            // Lleno los campos.
            $.each(respuesta.proveedor, function(campo, valor)
            {
                $('#divEditarProveedor form [name="' + campo + '"').val(valor);
            });

            proveedores.mostrarEditar();
        },
        
        // Confirmar edición de proveedor.
        confirmar : function()
        {
            var datos = 
            {
                accion: 'editar_confirmar',
                proveedor: {}
            };
            var mensajeError = "";

            $.each($('#divEditarProveedor form').find('input:not([readonly]), select'), function(i, campo) 
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

                datos.proveedor[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError);
                return;
            }

            bd.enviar(datos, proveedores.modulo, proveedores.editar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.proveedores);
        }
    },

    // Eliminar proveedor.
    eliminar :
    {
        // Confirmar eliminación de proveedor.
        confirmar : function(id)
        {
            var datos = {
                accion : 'eliminar',
                id : id
            };
            
            bd.enviar(datos, proveedores.modulo, proveedores.eliminar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;

            $('#divListadoProveedores tr[data-id="' + id + '"]')
                .fadeOut(
                    function() 
                    {
                        $(this).remove();
                    }
                );

            alertas.exito(respuesta.descripcion);
        }
    },

    // Deshabilitar proveedor.
    deshabilitar :
    {
        // Confirmar deshabilitación de proveedor.
        confirmar : function(id)
        {
            var datos = {
                accion : 'deshabilitar',
                id : id
            };
            
            bd.enviar(datos, proveedores.modulo, proveedores.deshabilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            var fila = $('#divListadoProveedores tr[data-id="' + id + '"]');
            
            $(fila).addClass("table-danger");
            $(fila).find('td:last').html
            (
                '<button type="button" class="botonHabilitarProveedor btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
                    + '<span class="fa fa-check"></span>'
                + ' </button>'
            );
            proveedores.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    },

    // Habilitar proveedor.
    habilitar :
    {
        // Confirmar habilitación de proveedor.
        confirmar : function(id)
        {
            var datos = {
                accion : 'habilitar',
                id : id
            };
            
            bd.enviar(datos, proveedores.modulo, proveedores.habilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            var fila = $('#divListadoProveedores tr[data-id="' + id + '"]');
            
            $(fila).removeClass();
            $(fila).find('td:last').html
            (
                '<button type="button" class="botonDeshabilitarProveedor btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                    + '<span class="fa fa-ban"></span>'
                + ' </button>'
            );
            proveedores.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    }
}