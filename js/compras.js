$(function() 
{
	compras.inicio.inicializar();
});

var compras =
{
    modulo : 'compras',

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();

    /* Editar compra */
        // Confirmar editar compra.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', compras.editar.confirmar));
	},
	
    // Pantallas.
	ocultarPantallas : function() 
    {
        $('.tooltip').tooltip('hide');
        $('main').children().hide();
    },

    mostrarNueva : function() 
    {
        compras.ocultarPantallas();
        $('#nueva').fadeIn();
    },

    mostrarEditar : function() 
    {
        compras.ocultarPantallas();
        $('#editar').fadeIn();
    },

    // Inicio.
    inicio : 
    {
        $div : null,

        inicializar : function()
        {
            this.asignarEventos();
            this.mostrar();
        },

        asignarEventos : function() 
        {
            this.$div = $('#inicio');

            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Cargar el listado de compras.
            this.$div.find('button[name="consultar"]').click(() => compras.listado.buscar());

            // Carga la pantalla para crear un nueva compra.
            this.$div.find('button[name="nueva"]').click(() => compras.nueva.buscar());
        },

        mostrar : function()
        {
            compras.ocultarPantallas();
            this.$div.fadeIn();
        }
    },

    // Buscar Listado.
    listado : 
    {
        $div : null,

        asignarEventos : function()
        {
            this.$div = $('#listado');

            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => compras.inicio.mostrar());

            // Editar.
            this.$div.find('button[name="editar"]').click((e) => compras.editar.buscar($(e.currentTarget).closest('tr').data('id')));
            
            // Eliminar.
            this.$div.find('button[name="eliminar"]').click((e) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => compras.eliminar.confirmar($(e.currentTarget).closest('tr').data('id'))));
            
            // Deshabilitar.
            this.$div.find('button[name="deshabilitar"]').click((e) => compras.deshabilitar($e.currentTarget).closest('tr').data('id'));// alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => compras.deshabilitar.confirmar($(e.currentTarget).closest('tr').data('id'))));

            // Habilitar.
            this.$div.find('button[name="habilitar"]').click((e) => alertas.confirmar('¿Está seguro?', 'Confirmar Habilitación', () => compras.habilitar.confirmar($(e.currentTarget).closest('tr').data('id'))));
        },

        mostrar : function()
        {
            compras.ocultarPantallas();
            this.$div.fadeIn();
        },
        
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                accion : 'buscar_listado'
            };
            
            // Envía los datos.
            bd.enviar(datos, compras.modulo, (respuesta) => 
            {
                var tablaCompras = $('#listado table');
                var barraCargando = $('#listado .barraCargando');
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
    
                this.asignarEventos();
                this.mostrar();
            });
        }
    },

    // Nueva compra.
    nueva :
    {
        $div : null,

        asignarEventos : function()
        {
            this.$div = $('#nueva');

            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => compras.inicio.mostrar());

            // Agregar Producto.
            this.$div.find('button[name="agregar-producto"]').click(() => this.agregarProducto());

            // Eliminar Producto.
            this.$div.find('button[name="eliminar-producto"]').click(() => compras.nueva.eliminarProducto()); //(event) => alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', () => compras.nueva.eliminarProducto($(event.currentTarget).closest('tr'))));

            // Confirmar nueva compra.
            this.$div.find('button[name="confirmar"]').click(() => this.confirmar());
        },

        mostrar : function()
        {
            compras.ocultarPantallas();
            this.$div.fadeIn();
        },

        // Buscar información para crear compra.
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                accion : 'nueva_buscar'
            };

            // Envía los datos.
            bd.enviar(datos, compras.modulo, function(respuesta)
            {
                var $formulario = $('#nueva').find('form:first');
                // lLeno combo Proveedores.
                var comboProveedores = $formulario.find('select[name="id_proveedor"]').html("");
                $(comboProveedores).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.proveedores, function(i, proveedor)
                {
                    $(comboProveedores).append($("<option>").val(proveedor.id).html(proveedor.razon_social));
                });

                // lLeno combo Tipo Comprobante.
                var comboTipoComprobante = $formulario.find('select[name="id_tipo_comprobante"]').html("");
                $(comboTipoComprobante).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_comprobantes, function(i, tipo_comprobante)
                {
                    $(comboTipoComprobante).append($("<option>").val(tipo_comprobante.id).html(tipo_comprobante.descripcion));
                });

                // lLeno combo Tipo Comprobante.
                var comboProductos = $formulario.find('select[name="id_producto"]').html("");
                $(comboProductos).append($('<option>').html("Producto").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.productos, function(i, producto)
                {
                    $(comboProductos).append($("<option>").val(producto.id).html(producto.descripcion));
                });

                // Borro los datos en los campos.
                $('#nueva form').find('input:not([readonly])').val("");
                
                compras.nueva.asignarEventos();
                compras.nueva.mostrar();
            });
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
                            .append($('select[name="id_producto"] :selected').html())
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

            $(filaProducto).fadeOut(
                () => 
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
                accion : 'nueva_confirmar',
                compra : {
                    cabecera : {},
                    cuerpo: {}
                }
            };
            
            var mensajeError = "";
            var funcionCerrar;

            $.each($('#nueva form').find('input:required, select:required'), function(i, campo) 
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

                datos.compra.cabecera[$(campo).attr('name')] = $(campo).val();
            });

            if(mensajeError != "")
            {
                alertas.advertencia(mensajeError, '', funcionCerrar);
                return;
            }
            
            datos.compra.cuerpo = compras.nueva.productos;

            console.log(datos);
            
            bd.enviar(datos, compras.modulo, compras.nueva.confirmarExito);         
        },

        confirmarExito : function(respuesta)
        {
            alertas.exito(respuesta.descripcion, '' , redireccionar.compras);
        }
    },

    // Editar compra.
    editar :
    {

        mostrar : function()
        {
            compras.ocultarPantallas();
            this.$div.fadeIn();
        },

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
                $('#editar form [name="' + campo + '"').val(valor);
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

            $.each($('#editar form').find('input:not([readonly]), select'), function(i, campo) 
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
            // Prepara los datos.
            var datos = {
                accion : 'eliminar',
                id : id
            };
            
            // Envía los datos.
            bd.enviar(datos, compras.modulo, (respuesta) =>
            {
                // Actualizar fila.
                $('#listado tr[data-id="' + respuesta.id + '"]')
                    .fadeOut(() => $(this).remove());

                alertas.exito(respuesta.descripcion);
            });
        }
    },

    // Deshabilitar compra.
    deshabilitar : (id) =>
    {
        // Confirmar deshabilitación de compra.
        alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => 
        {
            // Prepara los datos.
            var datos = {
                accion : 'deshabilitar',
                id : id
            };
            
            // Envía los datos.
            bd.enviar(datos, compras.modulo, (respuesta) =>
            {
                // Actualizar fila.
                var id = respuesta.id;
                var fila = $('#listado tr[data-id="' + id + '"]');
                
                $(fila).addClass("table-danger");
                $(fila).find('td:last').html
                (
                    '<button type="button" class="botonHabilitarCompra btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Habilitar">'
                        + '<span class="fa fa-check"></span>'
                    + ' </button>'
                );
                compras.asignarEventos();
    
                alertas.exito(respuesta.descripcion);
            });
        });
    },

    // Habilitar compra.
    habilitar : (id) =>
    {
        // Confirmar deshabilitación de compra.
        alertas.confirmar('¿Está seguro?', 'Confirmar Deshabilitación', () => 
        {
            // Prepara los datos.
            var datos = {
                accion : 'habilitar',
                id : id
            };

            // Envía los datos.
            bd.enviar(datos, compras.modulo, (respuesta) =>
            {
                // Actualizar fila.
                var id = respuesta.id;
                var fila = $('#listado tr[data-id="' + id + '"]');
                
                $(fila).removeClass();
                $(fila).find('td:last').html
                (
                    '<button type="button" class="botonDeshabilitarCompra btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Deshabilitar">'
                        + '<span class="fa fa-ban"></span>'
                    + ' </button>'
                );
                compras.asignarEventos();
    
                alertas.exito(respuesta.descripcion);
            });
        });
    }
}