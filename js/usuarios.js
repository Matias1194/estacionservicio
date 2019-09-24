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

        // Vuelve a la pantalla anterior.
        $('.botonVolver').unbind('click').click((event) => usuarios.mostrar($(event.currentTarget).data('pantalla')));
        
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
        $('.botonDetallesUsuario').unbind('click').click((event) => usuarios.buscar.detalles($(event.currentTarget).closest('tr').data('id')));

    /* Editar usuario */
        // Carga la pantalla para editar al usuario.
        $('.botonEditarUsuario').unbind('click').click((event) => usuarios.editar.buscar($(event.currentTarget).closest('tr').data('id')));

        // Confirmar editar usuario.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', usuarios.editar.confirmar));
    
    /* Eliminar usuario */
        // Confirmar uliminar usuario.
        $('.botonEliminarUsuario').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => usuarios.eliminar.confirmar($(event.currentTarget).closest('tr').data('id'))));
    
    /* Deshabilitar usuario */
        // Confirmar deshabilitar usuario.
        $('.botonDeshabilitarUsuario').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => usuarios.deshabilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

    /* Habilitar usuario */
        // Confirmar uabilitar usuario.
        $('.botonHabilitarUsuario').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => usuarios.habilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

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

    mostrar : function(pantalla)
    {
        usuarios.ocultarDivs();
        $('#div' + pantalla + 'Usuarios').fadeIn();
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
                var tablaUsuarios = $('#divListadoUsuarios table');
                var barraCargando = $('#divListadoUsuarios .barraCargando');
                $(tablaUsuarios).find('tbody').html("");

                $.each(respuesta.usuarios, function(indice, usuario) 
                {
                    $(tablaUsuarios)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(usuario.usuario)
                            )
                            .append($('<td>')
                                .append(usuario.perfil)
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
                            .attr('data-id', usuario.id)
                        );

                    // Botón Detalles Usuario.
                    //if(utilidades.tienePermiso(respuesta.permisos, 2))
                    //{
                        /*$(tablaUsuarios)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonDetallesUsuario btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Detalles">'
                                        + '<span class="fa fa-eye"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );*/
                    //}
                    
                    // Botón Editar Usuario.
                    //if(utilidades.tienePermiso(respuesta.permisos, 4))
                    //{
                        $(tablaUsuarios)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEditarUsuario btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">'
                                        + '<span class="fa fa-pencil-alt"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}

                    // Botón Eliminar Usuario.
                    //if(utilidades.tienePermiso(respuesta.permisos, 7))
                    //{
                        $(tablaUsuarios)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEliminarUsuario btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                        + '<span class="fa fa-trash"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}

                    // Si el usuario está habilitado.
                    //if(utilidades.tienePermiso(respuesta.permisos, 6) && usuario.habilitado == "1")
                    if(usuario.habilitado == "1")
                    {
                        $(tablaUsuarios)
                            .find('tbody tr:last') 
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
                    //else if(utilidades.tienePermiso(respuesta.permisos, 5))
                    if(usuario.habilitado == "0")
                    {
                        $(tablaUsuarios)
                            .find('tbody tr:last')
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

            $(barraCargando).slideUp();
            $(tablaUsuarios).fadeIn();
            
            usuarios.asignarEventos();
        },

        detalles : function(id)
        {
            var datos = {
                accion : 'buscar_detalles',
                id : id
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.buscar.detallesExito);
        },

        detallesExito : function(respuesta)
        {
            // Llena los campos.
            $.each($('#divDetallesUsuario label[data-label]'), function(i, label) 
            {
                var valor = respuesta.ficha_medica[$(label).data('label')];
                $(label).find('b').html(valor == '' ? '-' : (valor == '1' ? 'Si' : (valor == '0' ? 'No' : valor)));
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
            $.each(respuesta.tipos_perfiles, function(i, opcion)
            {
                $(comboTipoPerfil).append($("<option>").val(opcion.id).html(opcion.descripcion));
            });

            // lLeno combo Tipo Documento.
            var comboTipoDocumento = $('#comboTipoDocumentoNuevo').html("");
            $(comboTipoDocumento).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
            $.each(respuesta.tipos_documentos, function(i, opcion)
            {
                $(comboTipoDocumento).append($("<option>").val(opcion.id).html(opcion.descripcion));
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
        buscar : function(id)
        {
            var datos = {
                accion : 'editar_buscar',
                id : id
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.editar.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Tipo Perfil.
            var comboTipoPerfil = $('#comboTipoPerfilEditar').html("");
            $.each(respuesta.tipos_perfiles, function(i, opcion)
            {
                $(comboTipoPerfil).append($("<option>").val(opcion.id).html(opcion.descripcion));
            });

            // lLeno combo Tipo Documento.
            var comboTipoDocumento = $('#comboTipoDocumentoEditar').html("");
            $.each(respuesta.tipos_documentos, function(i, opcion)
            {
                $(comboTipoDocumento).append($("<option>").val(opcion.id).html(opcion.descripcion));
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
        confirmar : function(id)
        {
            var datos = {
                accion : 'eliminar',
                id : id
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.eliminar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;

            $('#divListadoUsuarios tr[data-id="' + id + '"]')
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
        confirmar : function(id)
        {
            var datos = {
                accion : 'deshabilitar',
                id : id
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.deshabilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            var fila = $('#divListadoUsuarios tr[data-id="' + id + '"]');
            
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
        confirmar : function(id)
        {
            var datos = {
                accion : 'habilitar',
                id : id
            };
            
            bd.enviar(datos, usuarios.tabla, usuarios.habilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            var fila = $('#divListadoUsuarios tr[data-id="' + id + '"]');
            
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