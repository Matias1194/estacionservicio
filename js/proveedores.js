$(function() 
{
	proveedores.inicializar();
});

var proveedores =
{
    area : null,
    modulo : 'proveedores',

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
        $('.botonVolver').unbind('click').click((e) => proveedores.mostrar($(e.target).data('pantalla')));
        
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
        $('button[name="editar"]').unbind('click').click((e) => proveedores.editar.buscar($(e.target).closest('tr').data('id')));

        // Confirmar editar proveedor.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', proveedores.editar.confirmar));
    
    /* Eliminar proveedor */
        // Confirmar uliminar proveedor.
        $('button[name="eliminar"]').unbind('click').click((e) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => proveedores.eliminar.confirmar($(e.target).closest('tr').data('id'))));
    
    /* Deshabilitar proveedor */
        // Confirmar deshabilitar proveedor.
        $('button[name="deshabilitar"]').unbind('click').click((e) => alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => proveedores.deshabilitar.confirmar($(e.target).closest('tr').data('id'))));

    /* Habilitar proveedor */
        // Confirmar uabilitar proveedor.
        $('button[name="habilitar"]').unbind('click').click((e) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => proveedores.habilitar.confirmar($(e.target).closest('tr').data('id'))));

	},
	
    // Pantallas.
	ocultarDivs : function() 
    {
        $('.tooltip').tooltip('hide');
        $('#divListadoProveedores').hide();
        $('#divNuevoProveedor').hide();
        $('#divEditarProveedor').hide();
    },

    mostrar : function(pantalla)
    {
        proveedores.ocultarDivs();
        $('#div' + pantalla + 'Proveedores').fadeIn();
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
                area : proveedores.area,
                accion : 'listado'
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
                $.each(respuesta.proveedores, function(i, proveedor) 
                {
                    $(tablaProveedores)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(proveedor.razon_social)
                            )
                            .append($('<td>')
                                .append(proveedor.documento)
                            )
                            .append($('<td>')
                                .append(proveedor.calle)
                            )
                            .append($('<td>')
                                .append(proveedor.email)
                            )
                            .append($('<td>')
                                .append(proveedor.telefono)
                            )
                            .append($('<td>')
                                .attr('class', 'text-center')
                            )
                            .attr('data-id', proveedor.id)
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
                        if((utilidades.tienePermiso(respuesta.permisos, 8) || utilidades.tienePermiso(respuesta.permisos, 65)) && proveedor.habilitado == "1")
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
                            
                            $(tablaProveedores).find('tbody tr:last').addClass('table-danger');
                        }
    
                        $(tablaProveedores).find('tbody tr:last td:last').append(acciones);
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
                area : proveedores.area,
                accion : 'nuevo_buscar'
            };

            bd.enviar(datos, proveedores.modulo, proveedores.nuevo.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Tipo Documento.
            var comboTipoDocumento = $('#comboTipoDocumentoNuevo').html("");
            $(comboTipoDocumento).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
            
            $.each(respuesta.tipos_documentos, function(i, tipo_documento)
            {
                $(comboTipoDocumento).append($("<option>").val(tipo_documento.id).html(tipo_documento.descripcion));
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
                area : proveedores.area,
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
            alertas.exito(respuesta.descripcion, '' , redireccionar.pagina('proveedores.php?area=' + proveedores.area));
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
                area : proveedores.area,
                accion : 'editar_buscar',
                id : id
            };
            
            bd.enviar(datos, proveedores.modulo, proveedores.editar.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // Lleno combo Tipo Documento.
            var comboTipoDocumento = $('#comboTipoDocumentoEditar').html("");
            $(comboTipoDocumento).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
            
            $.each(respuesta.tipos_documentos, function(i, opcion)
            {
                $(comboTipoDocumento).append($("<option>").val(opcion.id).html(opcion.descripcion));
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
                area : proveedores.area,
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
            alertas.exito(respuesta.descripcion, '' , redireccionar.pagina('proveedores.php?area=' + proveedores.area));
        }
    },

    // Eliminar proveedor.
    eliminar :
    {
        // Confirmar eliminación de proveedor.
        confirmar : function(id)
        {
            var datos = {
                area : proveedores.area,
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
                area : proveedores.area,
                accion : 'deshabilitar',
                id : id
            };
            
            bd.enviar(datos, proveedores.modulo, proveedores.deshabilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            
            var $fila = $('#divListadoProveedores tr[data-id="' + id + '"]');
            var $boton = $fila.find('td:last button[name="deshabilitar"]');
            
            $fila.addClass('table-danger');
            $boton.empty();
            $boton.removeClass('btn-danger').addClass('btn-success');
            $boton.attr('name', 'habilitar');
            $boton.attr('title', 'Habilitar');
            $boton.append($('<span>').addClass('fa fa-check'));
            
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
                area : proveedores.area,
                accion : 'habilitar',
                id : id
            };
            
            bd.enviar(datos, proveedores.modulo, proveedores.habilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            
            var $fila = $('#divListadoProveedores tr[data-id="' + id + '"]');
            var $boton = $fila.find('td:last button[name="habilitar"]');
            
            $fila.removeClass('table-danger');
            $boton.empty();
            $boton.removeClass('btn-success').addClass('btn-danger');
            $boton.attr('name', 'deshabilitar');
            $boton.attr('title', 'Deshabilitar');
            $boton.append($('<span>').addClass('fa fa-ban'));
            
            proveedores.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    }
}