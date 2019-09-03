$(function() 
{
	usuarios.buscar.listado();
});

var usuarios =
{
    tabla : 'usuarios',

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();

        // Vuelve al listado de usuarios.
        $('.botonVolver').unbind('click').click(usuarios.mostrarListado);
        
    /* Nuevo usuario */
        // Carga la pantalla para crear un nuevo usuario.
        $('#botonNuevoUsuario').unbind('click').click(usuarios.nuevo.buscar);

        // Confirmar nuevo usuario.
        $('#botonConfirmarNuevo').unbind('click').click(usuarios.nuevo.confirmar);
        
        // Confirmar nuevo usuario al presionar la tecla Enter en el campo Clave.
        $('#campoClave')
            .keypress((k) => k.keyCode && k.keyCode == '13' ? this.nuevo.confirmar() : k.which && k.which == '13' ? this.nuevo.confirmar() : null);

    /* Detalles usuario*/
        // Carga la pantalla parar ver los detalles de usuario.
        $('.botonDetallesUsuario').unbind('click').click((event) => usuarios.buscar.detalles($(event.currentTarget).closest('tr').data('codigo')));

    /* Editar usuario */
        // Carga la pantalla para editar al usuario.
        $('.botonEditarUsuario').unbind('click').click((event) => usuarios.editar.buscar($(event.currentTarget).closest('tr').data('codigo')));

        // Confirmar editar usuario.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', usuarios.editar.confirmar));
    
    /* Eliminar usuario */
        // Confirmar uliminar usuario.
        $('.botonEliminarUsuario').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => usuarios.eliminar.confirmar($(event.currentTarget).closest('tr').data('codigo'))));
    
    /* Deshabilitar usuario */
        // Confirmar deshabilitar usuario.
        $('.botonDeshabilitarUsuario').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => usuarios.deshabilitar.confirmar($(event.currentTarget).closest('tr').data('codigo'))));

    /* Habilitar usuario */
        // Confirmar uabilitar usuario.
        $('.botonHabilitarUsuario').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => usuarios.habilitar.confirmar($(event.currentTarget).closest('tr').data('codigo'))));

	},
	
    // Pantallas.
	ocultarDivs : function() 
    {
        $('.tooltip').tooltip('hide');
        $('#divListadoUsuarios').hide();
        $('#divNuevoUsuario').hide();
        $('#divDetallesUsuario').hide();
        $('#divEditarUsuario').hide();
    },

    mostrarListado : function() 
    {
        usuarios.ocultarDivs();
        $('#divListadoUsuarios').fadeIn();
    },

    mostrarDetalles : function() 
    {
        usuarios.ocultarDivs();
        $('#divDetallesUsuario').fadeIn();
    },

    mostrarNuevo : function() 
    {
        usuarios.ocultarDivs();
        $('#divNuevoUsuario').fadeIn();
    },

    mostrarEditar : function() 
    {
        usuarios.ocultarDivs();
        $('#divEditarUsuario').fadeIn();
    },

    // Buscar Listado y Detalles.
    buscar :
    {
        listado : function()
        {
            var datos = {
                accion : 'buscar_listado'
            };

            bd.enviar(datos, usuarios.tabla, usuarios.buscar.listadoExito);
        },

        listadoExito : function(respuesta)
        {
            if(respuesta.usuarios.length == 0)
            {
                $('#tablaListadoUsuarios tbody')
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
                $.each(respuesta.usuarios, function(indice, usuario) 
                {
                    $('#tablaListadoUsuarios tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(usuario.usuario)
                            )
                            .append($('<td>')
                                .append(usuario.perfil_descripcion)
                            )
                            .append($('<td>')
                                .append(usuario.nombres)
                            )
                            .append($('<td>')
                                .append(usuario.apellidos)
                            )
                            .append($('<td>')
                                .append(usuario.fecha_registro)
                            )
                            .attr('data-codigo', usuario.codigo)
                        );

                    // Botón Detalles Usuario.
                    if(utilidades.tienePermiso(respuesta.permisos, 2))
                    {
                        $('#tablaListadoUsuarios tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonDetallesUsuario btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Detalles">'
                                        + '<span class="fa fa-eye"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    }
                    
                    // Botón Editar Usuario.
                    if(utilidades.tienePermiso(respuesta.permisos, 4))
                    {
                        $('#tablaListadoUsuarios tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEditarUsuario btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">'
                                        + '<span class="fa fa-pencil-alt"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    }

                    // Botón Eliminar Usuario.
                    if(utilidades.tienePermiso(respuesta.permisos, 7))
                    {
                        $('#tablaListadoUsuarios tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEliminarUsuario btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                        + '<span class="fa fa-trash"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    }

                    // Si el usuario está habilitado.
                    if(utilidades.tienePermiso(respuesta.permisos, 6) && usuario.habilitado == "1")
                    {
                        $('#tablaListadoUsuarios tbody tr:last') 
                            .append($('<td>')
                                // Botón Deshabilitar Usuario.
                                .append('<button type="button" class="botonDeshabilitarUsuario btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                                        + '<span class="fa fa-ban"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    }
                    // Si el usuario está deshabilitado.
                    else if(utilidades.tienePermiso(respuesta.permisos, 5))
                    {
                        $('#tablaListadoUsuarios tbody tr:last')
                            .append($('<td>')
                                // Botón Habilitar Usuario.
                                .append('<button type="button" class="botonHabilitarUsuario btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
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

            $('#divCargando').slideUp();
            $('#tablaListadoUsuarios').fadeIn();
            
            usuarios.asignarEventos();
        },

        detalles : function(codigo)
        {
            var datos = {
                accion : 'buscar_detalles',
                codigo : codigo
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.buscar.detallesExito);
        },

        detallesExito : function(respuesta)
        {
            $.each($('#divDetallesUsuario label[data-label]'), function(i, label) 
            {
                if($(label).data('label') == "habilitado")
                {
                    $(label).find('b').html(respuesta.usuario[$(label).data('label')] == "1" ? "Si" : "No");
                }
                else
                {
                    $(label).find('b').html(respuesta.usuario[$(label).data('label')]);
                }
            });

            usuarios.mostrarDetalles();
        }
    },

    // Nuevo usuario.
    nuevo :
    {
        // Buscar información para crear usuario.
        buscar : function()
        {
            var datos = {
                accion : 'nuevo_buscar'
            };

            bd.enviar(datos, usuarios.tabla, usuarios.nuevo.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Tipo Perfil.
            var comboTipoPerfil = $('#comboTipoPerfilNuevo').html("");
            $(comboTipoPerfil).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
            $.each(respuesta.tipos_perfiles, function(i, tipo_perfil)
            {
                $(comboTipoPerfil).append($("<option>").val(tipo_perfil.codigo).html(tipo_perfil.descripcion));
            });

            // Borro los datos en los campos.
            $('#divNuevoUsuario form').find('input:not([readonly])').val("");
            
            usuarios.mostrarNuevo();
        },

        // Confirmar nuevo usuario.
        confirmar : function() 
        {
            var datos = 
            {
                accion: 'nuevo_confirmar',
                usuario: {}
            };
            var mensajeError = "";

            $.each($('#divNuevoUsuario form').find('input:not([readonly]), select'), function(i, campo) 
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

                datos.usuario[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError);
                return;
            }

            bd.enviar(datos, usuarios.tabla, usuarios.nuevo.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.usuarios);
        }
    },

    // Editar usuario.
    editar :
    {
        // Buscar información para editar usuario.
        buscar : function(codigo)
        {
            var datos = {
                accion : 'editar_buscar',
                codigo : codigo
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.editar.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Tipo Perfil.
            var comboTipoPerfil = $('#comboTipoPerfilEditar').html("");
            $.each(respuesta.tipos_perfiles, function(i, opcion)
            {
                $(comboTipoPerfil).append($("<option>").val(opcion.codigo).html(opcion.descripcion));
            });

            // Lleno los campos.
            $.each(respuesta.usuario, function(campo, valor)
            {
                $('#divEditarUsuario form [name="' + campo + '"').val(valor);
            });

            usuarios.mostrarEditar();
        },
        
        // Confirmar edición de usuario.
        confirmar : function()
        {
            var datos = 
            {
                accion: 'editar_confirmar',
                usuario: {}
            };
            var mensajeError = "";

            $.each($('#divEditarUsuario form').find('input:not([readonly]), select'), function(i, campo) 
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

                datos.usuario[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError);
                return;
            }

            bd.enviar(datos, usuarios.tabla, usuarios.editar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.usuarios);
        }
    },

    // Eliminar usuario.
    eliminar :
    {
        // Confirmar eliminación de usuario.
        confirmar : function(codigo)
        {
            var datos = {
                accion : 'eliminar',
                codigo : codigo
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.eliminar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var codigo = respuesta.codigo;

            $('#divListadoUsuarios tr[data-codigo="' + codigo + '"]')
                .fadeOut(
                    function() 
                    {
                        $(this).remove();
                    }
                );

            alertas.exito(respuesta.descripcion);
        }
    },

    // Deshabilitar usuario.
    deshabilitar :
    {
        // Confirmar deshabilitación de usuario.
        confirmar : function(codigo)
        {
            var datos = {
                accion : 'deshabilitar',
                codigo : codigo
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.deshabilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var codigo = respuesta.codigo;
            var fila = $('#divListadoUsuarios tr[data-codigo="' + codigo + '"]');
            
            $(fila).addClass("table-danger");
            $(fila).find('td:last').html
            (
                '<button type="button" class="botonHabilitarUsuario btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
                    + '<span class="fa fa-check"></span>'
                + ' </button>'
            );
            usuarios.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    },

    // Habilitar usuario.
    habilitar :
    {
        // Confirmar habilitación de usuario.
        confirmar : function(codigo)
        {
            var datos = {
                accion : 'habilitar',
                codigo : codigo
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.habilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var codigo = respuesta.codigo;
            var fila = $('#divListadoUsuarios tr[data-codigo="' + codigo + '"]');
            
            $(fila).removeClass();
            $(fila).find('td:last').html
            (
                '<button type="button" class="botonDeshabilitarUsuario btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                    + '<span class="fa fa-ban"></span>'
                + ' </button>'
            );
            usuarios.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    }
}