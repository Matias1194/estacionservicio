$(function() 
{
	compras.asignarEventos();
});

var compras =
{
    modulo : 'compras',

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();

        // Vuelve a la pantalla anterior.
        $('.botonVolver').unbind('click').click((event) => compras.mostrar($(event.currentTarget).data('pantalla')));
        
    /* Inicio compra */
        // Cargar el listado de compras.
        $('#botonConsultarCompras').unbind('click').click(compras.buscar.listado);

        // Carga la pantalla para crear un nueva compra.
        $('#botonNuevaCompra').unbind('click').click(compras.nueva.buscar);

    /* Nueva compra */
        // Agregar Producto.
        $('#botonAgregarProductoNueva').unbind('click').click(compras.nueva.agregarProducto);

        // Eliminar Producto.
        $('.botonEliminarProductoNueva').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => compras.nueva.eliminarProducto($(event.currentTarget).closest('tr'))));

        // Confirmar nueva compra.
        $('#botonConfirmarNueva').unbind('click').click(compras.nueva.confirmar);

    /* Editar compra */
        // Carga la pantalla para editar al compra.
        $('.botonEditarCompra').unbind('click').click((event) => compras.editar.buscar($(event.currentTarget).closest('tr').data('id')));

        // Confirmar editar compra.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', compras.editar.confirmar));
    
    /* Eliminar compra */
        // Confirmar uliminar compra.
        $('.botonEliminarCompra').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => compras.eliminar.confirmar($(event.currentTarget).closest('tr').data('id'))));
    
    /* Deshabilitar compra */
        // Confirmar deshabilitar compra.
        $('.botonDeshabilitarCompra').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => compras.deshabilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

    /* Habilitar compra */
        // Confirmar uabilitar compra.
        $('.botonHabilitarCompra').unbind('click').click((event) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => compras.habilitar.confirmar($(event.currentTarget).closest('tr').data('id'))));

	},
	
    // Pantallas.
	ocultarDivs : function() 
    {
        $('.tooltip').tooltip('hide');
        $('#divInicioCompras').hide();
        $('#divListadoCompras').hide();
        $('#divNuevaCompra').hide();
        $('#divEditarCompra').hide();
    },

    mostrar : function(pantalla)
    {
        compras.ocultarDivs();
        $('#div' + pantalla + 'Compras').fadeIn();
    },

    mostrarInicio : function() 
    {
        compras.ocultarDivs();
        $('#divInicioCompras').fadeIn();
    },

    mostrarListado : function() 
    {
        compras.ocultarDivs();
        $('#divListadoCompras').fadeIn();
    },

    mostrarNueva : function() 
    {
        compras.ocultarDivs();
        $('#divNuevaCompra').fadeIn();
    },

    mostrarEditar : function() 
    {
        compras.ocultarDivs();
        $('#divEditarCompra').fadeIn();
    },

    // Buscar Listado.
    buscar :
    {
        listado : function()
        {
            var datos = {
                accion : 'buscar_listado'
            };

            bd.enviar(datos, compras.modulo, compras.buscar.listadoExito);
        },

        listadoExito : function(respuesta)
        {
            var tablaCompras = $('#divListadoCompras table');
            var barraCargando = $('#divListadoCompras .barraCargando');
            $(tablaCompras).find('tbody').html("");

            if(respuesta.compras.length == 0)
            {
                $(tablaCompras)
                    .find('tbody')
                    .append($('<tr>')
                        .append($('<td>')
                            .append("No se encontraron registros.")
                            .attr('class', 'text-center')
                            .attr('colspan', 4)
                        )
                    );
            }
            else
            {
                $.each(respuesta.compras, function(indice, compra) 
                {
                    $(tablaCompras)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(compra.razon_social)
                            )
                            .append($('<td>')
                                .append(compra.documento)
                            )
                            .append($('<td>')
                                .append(compra.calle)
                            )
                            .append($('<td>')
                                .append(compra.email)
                            )
                            .append($('<td>')
                                .append(compra.telefono)
                            )
                            .attr('data-id', compra.id)
                        )

                    // Botón Detalles Compra.
                    //if(utilidades.tienePermiso(respuesta.permisos, 2))
                    //{
                        $(tablaCompras)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonDetallesCompra btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Detalles">'
                                        + '<span class="fa fa-eye"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}
                    
                    // Botón Editar Compra.
                    //if(utilidades.tienePermiso(respuesta.permisos, 4))
                    //{
                        $(tablaCompras)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEditarCompra btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">'
                                        + '<span class="fa fa-pencil-alt"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}

                    // Botón Eliminar Compra.
                    //if(utilidades.tienePermiso(respuesta.permisos, 7))
                    //{
                        $(tablaCompras)
                            .find('tbody tr:last')
                            .append($('<td>')
                                .append('<button type="button" class="botonEliminarCompra btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                        + '<span class="fa fa-trash"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    //}

                    // Si el compra está habilitado.
                    //if(utilidades.tienePermiso(respuesta.permisos, 6) && compra.habilitado == "1")
                    //{
                    if(compra.habilitado == "1")
                    {
                        $(tablaCompras)
                            .find('tbody tr:last') 
                            .append($('<td>')
                                // Botón Deshabilitar Compra.
                                .append('<button type="button" class="botonDeshabilitarCompra btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                                        + '<span class="fa fa-ban"></span>'
                                    + ' </button>'
                                )
                                .attr('class', 'text-center')
                            );
                    }
                    // Si el compra está deshabilitado.
                    //else if(utilidades.tienePermiso(respuesta.permisos, 5))
                    //{
                    else
                    {
                        $(tablaCompras)
                            .find('tbody tr:last')
                            .append($('<td>')
                                // Botón Habilitar Compra.
                                .append('<button type="button" class="botonHabilitarCompra btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
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
            $(tablaCompras).fadeIn();
            
            compras.mostrarListado();
            compras.asignarEventos();
        }
    },

    // Nueva compra.
    nueva :
    {
        // Buscar información para crear compra.
        buscar : function()
        {
            var datos = {
                accion : 'nueva_buscar'
            };

            bd.enviar(datos, compras.modulo, compras.nueva.buscarExito);
        },

        buscarExito : function(respuesta)
        {
            // lLeno combo Proveedores.
            var comboProveedores = $('#comboProveedoresNueva').html("");
            $(comboProveedores).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
            
            $.each(respuesta.proveedores, function(i, proveedor)
            {
                $(comboProveedores).append($("<option>").val(proveedor.id).html(proveedor.razon_social));
            });

            // lLeno combo Tipo Comprobante.
            var comboTipoComprobante = $('#comboTipoComprobanteNueva').html("");
            $(comboTipoComprobante).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
            
            $.each(respuesta.tipos_comprobantes, function(i, tipo_comprobante)
            {
                $(comboTipoComprobante).append($("<option>").val(tipo_comprobante.id).html(tipo_comprobante.descripcion));
            });

            // lLeno combo Tipo Comprobante.
            var comboProductos = $('#comboProductosNueva').html("");
            $(comboProductos).append($('<option>').html("Producto").val("").attr({'disabled': true, 'selected': true}));
            
            $.each(respuesta.productos, function(i, producto)
            {
                $(comboProductos).append($("<option>").val(producto.id).html(producto.descripcion));
            });

            // Borro los datos en los campos.
            $('#divNuevaCompra form').find('input:not([readonly])').val("");
            
            compras.mostrarNueva();
        },

        productos : [],

        agregarProducto : function()
        {
            var producto = {};
            var camposCompletos = true;

            $.each($('#divAgregarProductoNueva').find('input:not([readonly]), select'), function(i, campo) 
            {
                if(!$(campo).val()) 
                {
                    $(campo).focus();
                    camposCompletos = false;

                    return false;
                }

                producto[$(campo).attr('name')] = $(campo).val();
            });

            if(camposCompletos)
            {
                var tablaCompras = $('#divProductosAgregadosNueva table');

                if(compras.nueva.productos.length == 0)
                {
                    $(tablaCompras).find('tbody').html("");
                }

                $(tablaCompras)
                    .find('tbody')
                    .append($('<tr>')
                        .append($('<td>')
                            .append(producto.id_producto)
                        )
                        .append($('<td>')
                            .append($('#comboProductosNueva :selected').html())
                        )
                        .append($('<td>')
                            .append(producto.cantidad)
                        )
                        .append($('<td>')
                            .append(utilidades.formatearDinero(producto.precio_unitario))
                        )
                        .append($('<td>')
                            .append(utilidades.formatearDinero(producto.cantidad * producto.precio_unitario))
                        )
                        .attr('data-id_producto', producto.id_producto)
                        .attr('style', 'display:none')
                    );

                $(tablaCompras)
                    .find('tbody tr:last')
                    .append($('<td>')
                        .append('<button type="button" class="botonEliminarProductoNueva btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                + '<span class="fa fa-trash"></span>'
                            + ' </button>'
                        )
                        .attr('class', 'text-center')
                    );

                $(tablaCompras).find('tbody tr:last').fadeIn();

                // Borro los datos en los campos.
                $('#divAgregarProductoNueva').find('input:not([readonly]), select').val("");
                
                compras.nueva.productos.push(producto);

                compras.asignarEventos();
            }

        },

        eliminarProducto : function(filaProducto)
        {
            compras.nueva.productos = $.grep(compras.nueva.productos, (producto) => producto.id_producto == $(filaProducto).data('id_producto') , true);

            $(filaProducto)
                .fadeOut(() => 
                {
                    $(this).remove();

                    if(compras.nueva.productos.length == 0)
                    {
                        var tablaCompras = $('#divProductosAgregadosNueva table');
                        
                        $(tablaCompras)
                            .find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                    .append("No se encontraron registros.")
                                    .attr('class', 'text-center')
                                    .attr('colspan', 6)
                                )
                            );
                    }
                });
        },

        // Confirmar nueva compra.
        confirmar : function() 
        {
            var datos = 
            {
                accion: 'nueva_confirmar',
                compra: {}
            };
            
            var mensajeError = "";
            var funcionCerrar;

            $.each($('#divNuevaCompra form').find('input:not([readonly]), select'), function(i, campo) 
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

                datos.compra[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError, '', funcionCerrar);
                return;
            }

            //bd.enviar(datos, compras.modulo, compras.nueva.confirmarExito);
            alertas.advertencia("En desarrollo");
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.compras);
        }
    },

    // Editar compra.
    editar :
    {
        // Buscar información para editar compra.
        buscar : function(id)
        {
            var datos = 
            {
                accion : 'editar_buscar',
                id : id
            };
            
            bd.enviar(datos, compras.modulo, compras.editar.buscarExito);
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
            $.each(respuesta.compra, function(campo, valor)
            {
                $('#divEditarCompra form [name="' + campo + '"').val(valor);
            });

            compras.mostrarEditar();
        },
        
        // Confirmar edición de compra.
        confirmar : function()
        {
            var datos = 
            {
                accion: 'editar_confirmar',
                compra: {}
            };
            var mensajeError = "";

            $.each($('#divEditarCompra form').find('input:not([readonly]), select'), function(i, campo) 
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

                datos.compra[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError);
                return;
            }

            bd.enviar(datos, compras.modulo, compras.editar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.compras);
        }
    },

    // Eliminar compra.
    eliminar :
    {
        // Confirmar eliminación de compra.
        confirmar : function(id)
        {
            var datos = {
                accion : 'eliminar',
                id : id
            };
            
            bd.enviar(datos, compras.modulo, compras.eliminar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            $('#divListadoCompras tr[data-id="' + respuesta.id + '"]')
                .fadeOut(() => $(this).remove());

            alertas.exito(respuesta.descripcion);
        }
    },

    // Deshabilitar compra.
    deshabilitar :
    {
        // Confirmar deshabilitación de compra.
        confirmar : function(id)
        {
            var datos = {
                accion : 'deshabilitar',
                id : id
            };
            
            bd.enviar(datos, compras.modulo, compras.deshabilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            var fila = $('#divListadoCompras tr[data-id="' + id + '"]');
            
            $(fila).addClass("table-danger");
            $(fila).find('td:last').html
            (
                '<button type="button" class="botonHabilitarCompra btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
                    + '<span class="fa fa-check"></span>'
                + ' </button>'
            );
            compras.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    },

    // Habilitar compra.
    habilitar :
    {
        // Confirmar habilitación de compra.
        confirmar : function(id)
        {
            var datos = {
                accion : 'habilitar',
                id : id
            };
            
            bd.enviar(datos, compras.modulo, compras.habilitar.confirmarExito);
        },

        confirmarExito : function(respuesta)
        {
            // Actualizar fila.
            var id = respuesta.id;
            var fila = $('#divListadoCompras tr[data-id="' + id + '"]');
            
            $(fila).removeClass();
            $(fila).find('td:last').html
            (
                '<button type="button" class="botonDeshabilitarCompra btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                    + '<span class="fa fa-ban"></span>'
                + ' </button>'
            );
            compras.asignarEventos();

            alertas.exito(respuesta.descripcion);
        }
    }
}