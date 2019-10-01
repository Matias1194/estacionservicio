$(function() 
{
	compras.inicializar();
});

var compras =
{
    modulo : 'compras',

    inicializar : function()
    {
        this.inicio.$div = $('#inicio');
        this.listado.$div = $('#listado');
        this.detalles.$div = $('#detalles');
        this.nueva.$div = $('#nueva');
        this.editar.$div = $('#editar');

        this.inicio.asignarEventos();
        this.inicio.mostrar();
    },

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();
	},
	
    // Ocultar pantallas.
	ocultarPantallas : function() 
    {
        $('.tooltip').tooltip('hide');
        $('.container').children().hide();
    },

    // Inicio.
    inicio : 
    {
        $div : null,

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

    // Listado.
    listado : 
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => compras.inicio.mostrar());

            // Detalles.
            this.$div.find('button[name="detalles"]').click((e) => compras.detalles.buscar($(e.currentTarget).closest('tr').data('id')));

            // Editar.
            this.$div.find('button[name="editar"]').click((e) => compras.editar.buscar($(e.currentTarget).closest('tr').data('id')));
            
            // Eliminar.
            this.$div.find('button[name="eliminar"]').click((e) => compras.eliminar($(e.currentTarget).closest('tr').data('id')));
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
                                .attr('colspan', 5)
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
                                    .append(compra.detalle)
                                )
                                .append($('<td>')
                                    .append(compra.proveedor)
                                )
                                .append($('<td>')
                                    .append(utilidades.formatearDinero(compra.importe_total))
                                )
                                .append($('<td>')
                                    .append(compra.fecha_compra)
                                )
                                .attr('data-id', compra.id)
                            )
                    });
                    
                    $(tablaCompras).DataTable();
    
                    $.each(respuesta.compras, function(indice, compra)
                    {
    
                        // Botón Detalles Compra.
                        //if(utilidades.tienePermiso(respuesta.permisos, 2))
                        //{
                            $(tablaCompras)
                                .find('tbody tr[data-id=' + compra.id + ']')
                                .append($('<td>')
                                    .append('<button type="button" class="btn btn-sm btn-info" name="detalles" data-toggle="tooltip" data-placement="top" title="Detalles">'
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
                                .find('tbody tr[data-id=' + compra.id + ']')
                                .append($('<td>')
                                    .append('<button type="button" class="btn btn-sm btn-warning" name="editar" data-toggle="tooltip" data-placement="top" title="Editar">'
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
                                .find('tbody tr[data-id=' + compra.id + ']')
                                .append($('<td>')
                                    .append('<button type="button" class="btn btn-sm btn-secondary" name="eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                            + '<span class="fa fa-trash"></span>'
                                        + ' </button>'
                                    )
                                    .attr('class', 'text-center')
                                );
                        //}
                    });
                }
    
                $(barraCargando).slideUp();
                $(tablaCompras).fadeIn();
    
                this.asignarEventos();
                this.mostrar();
            });
        }
    },

    // Detalles.
    detalles :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => compras.listado.mostrar());
        },

        mostrar : function()
        {
            compras.ocultarPantallas();
            this.$div.fadeIn();
        },

        buscar : function(id)
        {
            var datos = {
                accion : 'buscar_detalles',
                id : id
            };
            
            bd.enviar(datos, compras.modulo, (respuesta) =>
            {
                $.each($('#detalles label[data-label]'), function(i, label) 
                {
                    $(label).find('b').html(respuesta.compra[$(label).data('label')]);
                });

                var tablaDetalles = $('#detalles table');
                $(tablaDetalles).find('tbody').html("");

                $.each(respuesta.detalles, function(indice, detalle) 
                {
                    $(tablaDetalles)
                        .find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .append(detalle.descripcion)
                            )
                            .append($('<td>')
                                .append(detalle.cantidad)
                            )
                            .append($('<td>')
                                .append(utilidades.formatearDinero(detalle.precio_unitario))
                            )
                            .append($('<td>')
                                .append(utilidades.formatearDinero(detalle.precio_total))
                            )
                        );
                });
                
                compras.detalles.asignarEventos();
                compras.detalles.mostrar();
            });
        }
    },

    // Nueva compra.
    nueva :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => compras.inicio.mostrar());

            // Agregar Producto.
            this.$div.find('button[name="agregar-producto"]').click(() => this.agregarProducto());

            // Eliminar Producto.
            this.$div.find('button[name="eliminar-producto"]').click((e) => this.eliminarProducto($(e.target).closest('tr')));

            // Confirmar nueva compra.
            this.$div.find('button[name="confirmar"]').click(() => this.confirmar());
        },

        mostrar : function()
        {
            compras.ocultarPantallas();
            this.$div.fadeIn();
        },

        // Buscar información para generar compra.
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                accion : 'nueva_buscar'
            };

            // Envía los datos.
            bd.enviar(datos, compras.modulo, (respuesta) =>
            {
                var $formulario = this.$div.find('form');

                // Lleno combo Proveedores.
                var comboProveedores = $formulario.find('select[name="id_proveedor"]').html("");
                $(comboProveedores).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.proveedores, function(i, proveedor)
                {
                    $(comboProveedores).append($("<option>").val(proveedor.id).html(proveedor.razon_social));
                });

                // Lleno combo Tipo Comprobante.
                var comboTipoComprobante = $formulario.find('select[name="id_tipo_comprobante"]').html("");
                $(comboTipoComprobante).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_comprobantes, function(i, tipo_comprobante)
                {
                    $(comboTipoComprobante).append($("<option>").val(tipo_comprobante.id).html(tipo_comprobante.descripcion));
                });

                // Lleno combo Tipo Comprobante.
                var comboProductos = $formulario.find('select[name="id_producto"]').html("");
                $(comboProductos).append($('<option>').html("Producto").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.productos, function(i, producto)
                {
                    $(comboProductos).append($("<option>").val(producto.id).html(producto.descripcion));
                });

                // Borro los datos en los campos.
                $('#nueva form').find('input:not([readonly])').val("");

                var tablaCompras = $formulario.find('table');
                        
                $(tablaCompras)
                    .find('tbody')
                    .html($('<tr>')
                        .append($('<td>')
                            .append("No se encontraron registros.")
                            .attr('class', 'text-center')
                            .attr('colspan', 6)
                        )
                    );
                
                $formulario.find('[name="importe_total"]').val('$ 0,00');
                
                this.asignarEventos();
                this.mostrar();
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

                producto[$(campo).attr('name')] = Number($(campo).val());
            });

            if(camposCompletos)
            {
                var tablaCompras = $('#divProductosAgregadosNueva table');

                if(compras.nueva.productos.length == 0)
                {
                    $(tablaCompras).find('tbody').html("");
                }
                
                producto.precio_total = producto.precio_unitario * producto.cantidad;

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
                            .append(utilidades.formatearDinero(producto.precio_total))
                        )
                        .append($('<td>')
                            .append('<button type="button" class="btn btn-sm btn-secondary" name="eliminar-producto" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                    + '<span class="fa fa-trash"></span>'
                                + ' </button>'
                            )
                            .attr('class', 'text-center')
                        )
                        .attr('data-id_producto', producto.id_producto)
                    )
                    .hide()
                    .fadeIn();

                // Borro los datos en los campos.
                $('#divAgregarProductoNueva').find('input:not([readonly]), select').val("");
                
                compras.nueva.productos.push(producto);

                var $importe_total = this.$div.find('[name="importe_total"]');
                $importe_total.val(utilidades.formatearDinero(Number(utilidades.desformatearDinero($importe_total.val())) + producto.precio_total));

                compras.nueva.asignarEventos();
                compras.asignarEventos();
            }
        },

        eliminarProducto : function(filaProducto)
        {
            var id_producto = $(filaProducto).data('id_producto');
            var $importe_total = this.$div.find('[name="importe_total"]');
            var precio_total = compras.nueva.productos.find(producto => producto.id_producto == id_producto).precio_total;

            $importe_total.val(utilidades.formatearDinero(utilidades.desformatearDinero($importe_total.val()) - precio_total));

            compras.nueva.productos = $.grep(compras.nueva.productos, (producto) => producto.id_producto == id_producto , true);

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
            // Prepara los datos.
            var datos = 
            {
                accion : 'nueva_confirmar',
                compra : {
                    importe_total : 0,
                    productos : {}
                }
            };
            
            var $formulario = this.$div.find('form');
            
            var mensajeError;
            var funcionCerrar;

            $.each($formulario.find('[data-requerido]'), (i, campo) =>
            {
                if(!$(campo).val()) 
                {
                    mensajeError = "Falta completar el campo " + $.trim($(campo).prev('label').html()) || $(campo).prop('placeholder');

                    funcionCerrar = () => $(campo).focus();
                    return false;
                }

                datos.compra[$(campo).attr('name')] = $(campo).val();
            });

            
            if(mensajeError)
            {
                alertas.advertencia(mensajeError, '', funcionCerrar);
                return;
            }
            
            if(this.productos.length == 0)
            {
                alertas.advertencia("No se ingresaron productos", '', () => $formulario.find('[name="id_producto"]').focus());
                return;
            }
            
            datos.compra.importe_total = utilidades.desformatearDinero(datos.compra.importe_total);
            datos.compra.productos = this.productos;
            
            // Envía los datos.
            bd.enviar(datos, compras.modulo, (respuesta) =>
            {
                alertas.exito(respuesta.descripcion, '' , redireccionar.compras);
            });
        }
    },

    // Editar compra.
    editar :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => compras.listado.buscar());

            // Agregar Producto.
            this.$div.find('button[name="agregar-producto"]').click(() => this.agregarProducto());

            // Eliminar Producto.
            this.$div.find('button[name="eliminar-producto"]').click((e) => this.eliminarProducto($(e.target).closest('tr'))); 

            // Confirmar editar compra.
            this.$div.find('button[name="confirmar"]').click(() => this.confirmar());
        },

        mostrar : function()
        {
            compras.ocultarPantallas();
            this.$div.fadeIn();
        },

        // Buscar información para generar compra.
        buscar : function(id)
        {
            // Prepara los datos.
            var datos = {
                accion : 'editar_buscar',
                id: id
            };

            // Envía los datos.
            bd.enviar(datos, compras.modulo, (respuesta) =>
            {
                var $formulario = this.$div.find('form');

                // Lleno combo Proveedores.
                var comboProveedores = $formulario.find('select[name="id_proveedor"]').html("");
                $(comboProveedores).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.proveedores, function(i, proveedor)
                {
                    $(comboProveedores).append($("<option>").val(proveedor.id).html(proveedor.razon_social));
                });

                // Lleno combo Tipo Comprobante.
                var comboTipoComprobante = $formulario.find('select[name="id_tipo_comprobante"]').html("");
                $(comboTipoComprobante).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_comprobantes, function(i, tipo_comprobante)
                {
                    $(comboTipoComprobante).append($("<option>").val(tipo_comprobante.id).html(tipo_comprobante.descripcion));
                });

                // Lleno combo Tipo Comprobante.
                var comboProductos = $formulario.find('select[name="id_producto"]').html("");
                $(comboProductos).append($('<option>').html("Producto").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.productos, function(i, producto)
                {
                    $(comboProductos).append($("<option>").val(producto.id).html(producto.descripcion));
                });

                // Lleno los campos.
                $.each(respuesta.compra, function(campo, valor)
                {
                    $formulario.find('[name="' + campo + '"').val(valor);
                });
                
                // Lleno los productos.
                this.productos = [];
                                
                $.each(respuesta.detalles, (i, producto) => {
                    this.agregarProducto(producto);
                })

                this.asignarEventos();
                this.mostrar();
            });
        },

        productos : [],

        agregarProducto : function(producto)
        {
            producto = producto ? producto : {};
            
            if($.isEmptyObject(producto))
            {
                var camposCompletos = true;
    
                $.each($('#divAgregarProductoEditar').find('input:not([readonly]), select'), function(i, campo) 
                {
                    if(!$(campo).val()) 
                    {
                        $(campo).focus();
                        camposCompletos = false;
    
                        return false;
                    }
    
                    producto[$(campo).attr('name')] = Number($(campo).val());
                });
                
                if(!camposCompletos)
                {
                    return;
                }
            }
            
            var tablaCompras = $('#divProductosAgregadosEditar table');

            if(compras.editar.productos.length == 0)
            {
                $(tablaCompras).find('tbody').html("");
            }
            
            producto.precio_total = producto.precio_unitario * producto.cantidad;

            $(tablaCompras)
                .find('tbody')
                .append($('<tr>')
                    .append($('<td>')
                        .append(producto.id_producto)
                    )
                    .append($('<td>')
                        .append(producto.descripcion || $('select[name="id_producto"] :selected').html())
                    )
                    .append($('<td>')
                        .append(producto.cantidad)
                    )
                    .append($('<td>')
                        .append(utilidades.formatearDinero(producto.precio_unitario))
                    )
                    .append($('<td>')
                        .append(utilidades.formatearDinero(producto.precio_total))
                    )
                    .append($('<td>')
                        .append('<button type="button" class="btn btn-sm btn-secondary" name="eliminar-producto" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                + '<span class="fa fa-trash"></span>'
                            + ' </button>'
                        )
                        .attr('class', 'text-center')
                    )
                    .attr('data-id_producto', producto.id_producto)
                )
                .hide()
                .fadeIn();

            // Borro los datos en los campos.
            $('#divAgregarProductoEditar').find('input:not([readonly]), select').val("");
            
            compras.editar.productos.push(producto);

            var $importe_total = this.$div.find('[name="importe_total"]');
            $importe_total.val(utilidades.formatearDinero(Number(utilidades.desformatearDinero($importe_total.val())) + producto.precio_total));

            compras.editar.asignarEventos();
            compras.asignarEventos();
        },

        eliminarProducto : function(filaProducto)
        {
            var id_producto = $(filaProducto).data('id_producto');
            var $importe_total = this.$div.find('[name="importe_total"]');
            var precio_total = compras.editar.productos.find(producto => producto.id_producto == id_producto).precio_total;

            $importe_total.val(utilidades.formatearDinero(utilidades.desformatearDinero($importe_total.val()) - precio_total));

            compras.editar.productos = $.grep(compras.editar.productos, (producto) => producto.id_producto == id_producto , true);

            $(filaProducto).fadeOut(
                () => 
                {
                    $(this).remove();

                    if(compras.editar.productos.length == 0)
                    {
                        var tablaCompras = $('#divProductosAgregadosEditar table');
                        
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
                }
            );
        },

        // Confirmar edición de compra.
        confirmar : function() 
        {
            // Prepara los datos.
            var datos = 
            {
                accion : 'editar_confirmar',
                compra : {
                    importe_total : 0,
                    productos : {}
                }
            };
            
            var $formulario = this.$div.find('form');
            
            var mensajeError;
            var funcionCerrar;

            $.each($formulario.find('[data-requerido]'), (i, campo) =>
            {
                if(!$(campo).val()) 
                {
                    mensajeError = "Falta completar el campo " + $.trim($(campo).prev('label').html()) || $(campo).prop('placeholder');

                    funcionCerrar = () => $(campo).focus();
                    return false;
                }

                datos.compra[$(campo).attr('name')] = $(campo).val();
            });

            datos.compra.importe_total = utilidades.desformatearDinero(datos.compra.importe_total);
            
            if(mensajeError)
            {
                alertas.advertencia(mensajeError, '', funcionCerrar);
                return;
            }

            if(this.productos.length == 0)
            {
                alertas.advertencia("No se ingresaron productos", '', () => $formulario.find('[name="id_producto"]').focus());
                return;
            }

            datos.compra.productos = this.productos;
            
            // Envía los datos.
            bd.enviar(datos, compras.modulo, (respuesta) =>
            {
                alertas.exito(respuesta.descripcion, '' , redireccionar.compras);
            });
        }
    },

    // Eliminar compra.
    eliminar : function(id)
    {
        alertas.confirmar('¿Está seguro?', 'Confirmar Eliminación', function()
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
        });
    }
}