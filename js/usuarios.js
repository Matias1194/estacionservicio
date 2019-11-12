$(function() 
{
	usuarios.inicializar();
});

var usuarios =
{
    area : null,
    modulo : 'usuarios',

    inicializar : function() 
    {
        this.area = $('#area').val();
        this.buscar.listado();
    },

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

    /* Editar usuario */
        // Carga la pantalla para editar al usuario.
        $('button[name="editar"]').unbind('click').click((event) => usuarios.editar.buscar($(event.currentTarget).closest('tr').data('id')));

        // Confirmar editar usuario.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', usuarios.editar.confirmar));
    
    /* Eliminar usuario */
        // Confirmar uliminar usuario.
        $('button[name="eliminar"]').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => usuarios.eliminar.confirmar($(event.currentTarget).closest('tr').data('id'))));
    
    /* Deshabilitar usuario */
        // Confirmar deshabilitar usuario.
        $('button[name="deshabilitar"]').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => usuarios.deshabilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

    /* Habilitar usuario */
        // Confirmar uabilitar usuario.
        $('button[name="habilitar"]').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => usuarios.habilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

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
                area : usuarios.area,
                accion : 'listado'
            };

            bd.enviar(datos, usuarios.modulo, usuarios.buscar.listadoExito);
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

                $.each(respuesta.usuarios, function(i, usuario) 
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
                            .append($('<td>')
                                .attr('class', 'text-center')
                            )
                            .attr('data-id', usuario.id)
                        );
                        
                    let acciones = "";
                    
                    // Botón Editar.
                    if(utilidades.tienePermiso(respuesta.permisos, 5) || utilidades.tienePermiso(respuesta.permisos, 62))
                    {
                        acciones += '<button type="button" name="editar" class="btn btn-sm btn-warning" title="Editar">'
                                        + '<span class="fa fa-pencil-alt"></span>'
                                + '</button>';
                    }
                    // Botón Eliminar.
                    if(utilidades.tienePermiso(respuesta.permisos, 7) || utilidades.tienePermiso(respuesta.permisos, 64))
                    {
                        acciones += '&nbsp;<button type="button" name="eliminar" class="btn btn-sm btn-secondary" title="Eliminar">'
                                        + '<span class="fa fa-trash"></span>'
                                + '</button>';
                    }

                    // Botón Deshabilitar.
                    if((utilidades.tienePermiso(respuesta.permisos, 8) || utilidades.tienePermiso(respuesta.permisos, 65)) && usuario.habilitado == "1")
                    {
                        acciones += '&nbsp;<button type="button" name="deshabilitar" class="btn btn-sm btn-danger" title="Deshabilitar">'
                                        + '<span class="fa fa-ban"></span>'
                                + '</button>';
                    }
                    // Botón Habilitar.
                    else if(utilidades.tienePermiso(respuesta.permisos, 9) || utilidades.tienePermiso(respuesta.permisos, 66)) 
                    {
                        acciones += '&nbsp;<button type="button" name="habilitar" class="btn btn-sm btn-success" title="Habilitar">'
                                        + '<span class="fa fa-check"></span>'
                                + '</button>';
                        
                        $(tablaUsuarios).find('tbody tr:last').addClass('table-danger');
                    }

                    $(tablaUsuarios).find('tbody tr:last td:last').append(acciones);
                });
            }
            $(barraCargando).slideUp();
            $(tablaUsuarios).fadeIn();
            
            usuarios.asignarEventos();
        },

        detalles : function(id)
        {
            var datos = {
                area : usuarios.area,
                accion : 'detalles',
                id : id
            };
            
            bd.enviar(datos, usuarios.modulo, usuarios.buscar.detallesExito);
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
                area : usuarios.area,
                accion : 'nuevo_buscar'
            };

            bd.enviar(datos, usuarios.modulo, usuarios.nuevo.buscarExito);
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
                area : usuarios.area,
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

            bd.enviar(datos, usuarios.modulo, usuarios.nuevo.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , () => redireccionar.pagina('usuarios.php?area=' + usuarios.area));
        }
    },

    // Editar usuario.
    editar :
    {
        // Buscar información para editar usuario.
        buscar : function(id)
        {
            var datos = {
                area : usuarios.area,
                accion : 'editar_buscar',
                id : id
            };
            
            bd.enviar(datos, usuarios.modulo, usuarios.editar.buscarExito);
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
                area : usuarios.area,
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

            bd.enviar(datos, usuarios.modulo, usuarios.editar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , () => redireccionar.pagina('usuarios.php?area=' + usuarios.area));
        }
    },

    // Eliminar usuario.
    eliminar :
    {
        // Confirmar eliminación de usuario.
        confirmar : function(id)
        {
            var datos = {
                area : usuarios.area,
                accion : 'eliminar',
                id : id
            };
            
            bd.enviar(datos, usuarios.modulo, usuarios.eliminar.confirmarExito);
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
                area : usuarios.area,
                accion : 'deshabilitar',
                id : id
            };
            
            bd.enviar(datos, usuarios.modulo, usuarios.deshabilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            
            var $fila = $('#divListadoUsuarios tr[data-id="' + id + '"]');
            var $boton = $fila.find('td:last button[name="deshabilitar"]');
            
            $fila.addClass('table-danger');
            $boton.empty();
            $boton.removeClass('btn-danger').addClass('btn-success');
            $boton.attr('name', 'habilitar');
            $boton.attr('title', 'Habilitar');
            $boton.append($('<span>').addClass('fa fa-check'));
            
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
                area : usuarios.area,
                accion : 'habilitar',
                id : id
            };
            
            bd.enviar(datos, usuarios.modulo, usuarios.habilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            
            var $fila = $('#divListadoUsuarios tr[data-id="' + id + '"]');
            var $boton = $fila.find('td:last button[name="habilitar"]');
            
            $fila.removeClass('table-danger');
            $boton.empty();
            $boton.removeClass('btn-success').addClass('btn-danger');
            $boton.attr('name', 'deshabilitar');
            $boton.attr('title', 'Deshabilitar');
            $boton.append($('<span>').addClass('fa fa-ban'));
            
            usuarios.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    }
}