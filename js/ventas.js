$(function() 
{
	ventas.inicializar();
});

var ventas =
{
    area : null,
    modulo : 'ventas',

    inicializar : function()
    {
        this.area = $('#area').val();
        if(this.area == "1")
        {
            this.modulo = 'playa_' + this.modulo;
        }

        this.inicio.$div = $('#inicio');
        this.tickets.$div = $('#tickets');
        this.factura.$div = $('#factura');

        this.inicio.buscar();
    },

	asignarEventos : function() 
	{
        // Asigna los eventos de los tooltip.
        $('[data-toggle="tooltip"]').tooltip();

        /* Editar venta */
        // Confirmar editar venta.
        $('#botonConfirmarEditar').unbind('click').click(() => alertas.confirmar('¿Está seguro?', 'Confirmar Edición', ventas.editar.confirmar));
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
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Abrir Caja > Ingresar saldo.
            this.$div.find('button[name="abrir_caja"]').click(() => ventas.caja.abrir_mostrar());

            // Abrir Caja > Confirmar.
            this.$div.find('form[name="abrir_caja"]').find('button[name="confirmar"]').click(() => ventas.caja.abrir_confirmar());

            // Cerrar Caja > Ingresar saldo.
            this.$div.find('button[name="cerrar_caja"]').click(() => ventas.caja.cerrar_mostrar());

            // Cerrar Caja > Confirmar.
            this.$div.find('form[name="cerrar_caja"]').find('button[name="confirmar"]').click(() => ventas.caja.cerrar_confirmar());

            // Abre el turno.
            this.$div.find('button[name="comenzar_turno"]').click(() => ventas.turno.comenzar());

            // Cierra el turno.
            this.$div.find('button[name="finalizar_turno"]').click(() => ventas.turno.finalizar());

            // Consulta conceptos.
            this.$div.find('button[name="otros"]').click(() => ventas.otros.buscar());

            // Confirma movimiento.
            this.$div.find('form[name="otros"]').find('button[name="confirmar"]').click(() => ventas.otros.confirmar());
            
            // Carga la pantalla para un nueva venta con tickets.
            this.$div.find('button[name="tickets"]').click(() => ventas.tickets.buscar());

            // Carga la pantalla para un nueva venta con factura A.
            this.$div.find('button[name="factura"]').click(() => ventas.factura.buscar());
        },

        mostrar : function()
        {
            ventas.ocultarPantallas();
            this.$div.fadeIn();
        },

        buscar : function() {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'caja_estado',
            };

            var $boton_tickets = this.$div.find('button[name="tickets"]');
            var $boton_factura = this.$div.find('button[name="factura"]');
            var $boton_abrir_caja = this.$div.find('button[name="abrir_caja"]');
            var $boton_cerrar_caja = this.$div.find('button[name="cerrar_caja"]');
            var $boton_comenzar_turno = this.$div.find('button[name="comenzar_turno"]');
            var $boton_finalizar_turno = this.$div.find('button[name="finalizar_turno"]');
            var $boton_otros = this.$div.find('button[name="otros"]');

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                if(respuesta.caja_estado)
                {
                    if(respuesta.turno_estado)
                    {
                        $boton_tickets.show();
                        $boton_factura.show();
                        $boton_otros.show();
                        $boton_finalizar_turno.show();
                    }
                    else
                    {
                        $boton_comenzar_turno.show();
                        $boton_otros.parent().hide();
                        $boton_cerrar_caja.show();
                    }
                }
                else
                {
                    $boton_abrir_caja.show();
                }
                
                this.asignarEventos();
                this.mostrar();
            });
        }
    },

    caja: {
        abrir_mostrar : function() {
            $('form[name="abrir_caja"]').fadeIn();
        },

        abrir_confirmar : function() {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'abrir_caja',
                saldo: 0,
            };

            var saldo = $('form[name="abrir_caja"]').find('input[name="saldo"]').val();

            if(saldo == '') {
                alertas.advertencia('Debe ingresar un saldo para abrir la caja');
                return;
            }

            datos.saldo = saldo;

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                redireccionar.pagina('ventas.php?area=' + ventas.area);
            });
        },

        cerrar_mostrar : function() {
            $('form[name="cerrar_caja"]').fadeIn();
        },

        cerrar_confirmar : function() {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'cerrar_caja',
                saldo: 0,
            };

            var saldo = $('form[name="cerrar_caja"]').find('input[name="saldo"]').val();

            if(saldo == '') {
                alertas.advertencia('Debe ingresar un saldo para cerrar la caja');
                return;
            }

            datos.saldo = saldo;

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                redireccionar.pagina('ventas.php?area=' + ventas.area);
            });
        },
    },

    turno: {
        comenzar : function() {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'comenzar_turno',
            };

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                redireccionar.pagina('ventas.php?area=' + ventas.area);
            });
        },

        finalizar: function() {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'finalizar_turno',
            };

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                redireccionar.pagina('ventas.php?area=' + ventas.area);
            });
        }
    },

    tickets :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos click.
            this.$div.find('button').unbind('click');

            // Desasignar eventos click.
            this.$div.find('select').unbind('change');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => ventas.inicio.mostrar());

            // Actualiza el precio unitario del producto seleccionado.
            this.$div.find('select[name="id_producto"]').change((e) => 
            {
                this.$div.find('input[name="precio_unitario"]')
                    .val($(':selected', e.target).data('precio'));
                
                this.$div.find('input[name="cantidad"]')
                    .attr('max', $(':selected', e.target).data('max'));
            });

            // Agregar Producto.
            this.$div.find('button[name="agregar-producto"]').click(() => this.agregarProducto());

            // Eliminar Producto.
            this.$div.find('button[name="eliminar-producto"]').click(() => ventas.tickets.eliminarProducto());

            // Confirmar nueva venta.
            this.$div.find('button[name="confirmar"]').click(() => this.confirmar());
        },

        mostrar : function()
        {
            ventas.ocultarPantallas();
            this.$div.fadeIn();
        },

        // Buscar información para generar venta.
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                area : ventas.area,
                accion : 'nuevo_buscar'
            };

            // Envía los datos.
            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                var $formulario = this.$div.find('form');
                
                // Llena combo Productos.
                var comboProductos = $formulario.find('select[name="id_producto"]').html("");
                $(comboProductos).append($('<option>').html("Producto").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.productos, function(i, producto)
                {
                    $(comboProductos).append($("<option>")
                            .val(producto.id)
                            .html(producto.descripcion)
                            .attr('data-precio', producto.precio_unitario)
                            .attr('data-max', producto.unidades)
                        );
                });

                // Llena combo Productos.
                var comboTiposPago = $formulario.find('select[name="id_tipo_pago"]').html("");
                $(comboTiposPago).append($('<option>').html("Tipo pago").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_pagos, function(i, opcion)
                {
                    $(comboTiposPago).append($("<option>")
                            .val(opcion.id)
                            .html(opcion.descripcion)
                        );
                });

                // Borro los datos en los campos.
                $formulario.find('input').val("");
                
                this.asignarEventos();
                this.mostrar();
            });
        },

        descargar : function(id)
        {   
            redireccionar.pagina('reportes/reporte_ticket.php?id=' + id + '&id_area=' + ventas.area);
        },

        productos: [],

        agregarProducto : function()
        {
            var producto = {};
            var camposCompletos = true;

            $.each($('#divAgregarProductoNueva').find('input, select'), function(i, campo) 
            {
                if($(campo).data('requerido') && !$(campo).val()) 
                {
                    $(campo).focus();
                    camposCompletos = false;

                    return false;
                }

                producto[$(campo).attr('name')] = Number($(campo).val());
            });

            if(Number($('#tickets input[name="cantidad"]').val()) > Number($('#tickets input[name="cantidad"]').attr('max')))
            {
                $('#tickets input[name="cantidad"]').focus();
                
                return false;
            }

            if(camposCompletos)
            {
                var tablaVentas = $('#divProductosAgregadosNueva table');

                if(ventas.tickets.productos.length == 0)
                {
                    $(tablaVentas).find('tbody').html("");
                }
                
                producto.precio_total = producto.precio_unitario * producto.cantidad;

                $(tablaVentas)
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
                
                ventas.tickets.productos.push(producto);

                var $importe_total = this.$div.find('[name="importe_total"]');
                $importe_total.val(utilidades.formatearDinero(Number(utilidades.desformatearDinero($importe_total.val())) + producto.precio_total));

                ventas.tickets.asignarEventos();
                ventas.asignarEventos();
            }
        },

        eliminarProducto : function(filaProducto)
        {
            ventas.tickets.productos = $.grep(ventas.tickets.productos, (producto) => producto.id_producto == $(filaProducto).data('id_producto') , true);

            $(filaProducto).fadeOut(
                () => 
                {
                    $(this).remove();

                    if(ventas.tickets.productos.length == 0)
                    {
                        var tablaVentas = $('#divProductosAgregadosNueva table');
                        
                        $(tablaVentas)
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

        // Confirmar nueva venta.
        confirmar : function() 
        {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'nuevo_confirmar',
                venta : {
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

                datos.venta[$(campo).attr('name')] = $(campo).val();
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
            
            datos.venta.importe_total = utilidades.desformatearDinero(datos.venta.importe_total);
            datos.venta.productos = this.productos;
            
            // Envía los datos.
            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                alertas.exito(respuesta.descripcion, '' , () => redireccionar.pagina('ventas.php?area=' + ventas.area));
                ventas.tickets.descargar(respuesta.id_venta);
            });
        }
    },

    factura :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos click.
            this.$div.find('button').unbind('click');

            // Desasignar eventos click.
            this.$div.find('select').unbind('change');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => ventas.inicio.mostrar());

            // Busca y muestra los datos para cada tipo de cliente.
            this.$div.find('select[name="id_tipo_cliente"]').change((e) => {
                var id_tipo_cliente = $(':selected', e.target).val();
                
                // Frecuente.
                if(id_tipo_cliente == 1) 
                {
                    // Buscar clientes.
                    ventas.factura.buscar_clientes();
                }
                // De mostrador.
                else if(id_tipo_cliente == 2) 
                {
                    // Ocultar Clientes.
                    this.$div.find('select[name="id_cliente"]').parent().hide();

                    // Mostrar formulario.
                    $formulario = this.$div.find('div[name="cliente_demostrador"]').show();
                }
            });

            // Actualiza el precio unitario del producto seleccionado.
            this.$div.find('select[name="id_producto"]').change((e) => {
                this.$div.find('input[name="precio_unitario"]')
                    .val($(':selected', e.target).data('precio'));

                this.$div.find('input[name="cantidad"]')
                    .attr('max', $(':selected', e.target).data('max'));
            });

            // Agregar Producto.
            this.$div.find('button[name="agregar-producto"]').click(() => this.agregarProducto());

            // Eliminar Producto.
            this.$div.find('button[name="eliminar-producto"]').click(() => ventas.tickets.eliminarProducto());

            // Confirmar nueva venta.
            this.$div.find('button[name="confirmar"]').click(() => this.confirmar());
        },

        mostrar : function()
        {
            ventas.ocultarPantallas();
            this.$div.fadeIn();
        },

        // Buscar información para generar venta.
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                area : ventas.area,
                accion : 'factura_nueva_buscar'
            };

            // Envía los datos.
            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                var $formulario = this.$div.find('form');

                // Llena combo Tipo Cliente.
                var comboTipoCliente = $formulario.find('select[name="id_tipo_cliente"]').html("");
                $(comboTipoCliente).append($('<option>').html("Elegir").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_clientes, function(i, opcion)
                {
                    $(comboTipoCliente).append($("<option>")
                            .val(opcion.id)
                            .html(opcion.descripcion)
                        );
                });

                // Llena combo Productos.
                var comboProductos = $formulario.find('select[name="id_producto"]').html("");
                $(comboProductos).append($('<option>').html("Producto").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.productos, function(i, producto)
                {
                    $(comboProductos).append($("<option>")
                            .val(producto.id)
                            .html(producto.descripcion)
                            .attr('data-precio', producto.precio_unitario)
                            .attr('data-max', producto.unidades)
                        );
                });

                // Llena combo Tipos de pago.
                var comboTiposPago = $formulario.find('select[name="id_tipo_pago"]').html("");
                $(comboTiposPago).append($('<option>').html("Tipo pago").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_pagos, function(i, opcion)
                {
                    $(comboTiposPago).append($("<option>")
                            .val(opcion.id)
                            .html(opcion.descripcion)
                        );
                });

                // Borro los datos en los campos.
                $formulario.find('input').val("");
                
                this.asignarEventos();
                this.mostrar();
            });
        },

        buscar_clientes : function() {
             // Prepara los datos.
             var datos = {
                area : ventas.area,
                accion : 'factura_nueva_clientes_buscar'
            };

            // Envía los datos.
            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                var $formulario = this.$div.find('form');

                // Llena combo Tipo Cliente.
                var $comboClientes = $formulario.find('select[name="id_cliente"]').html("");
                $($comboClientes).append($('<option>').html("Elegir").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.clientes, function(i, opcion)
                {
                    $($comboClientes).append($("<option>")
                            .val(opcion.id)
                            .html(opcion.razon_social)
                        );
                });
                
                $comboClientes.parent().fadeIn();
                $formulario.find('div[name="cliente_demostrador"]').hide();
            });
        },

        descargar : function(id)
        {   
            redireccionar.pagina('reportes/reporte_factura.php?id=' + id + '&id_area=' + ventas.area);
        },

        productos: [],

        agregarProducto : function()
        {
            var producto = {};
            var camposCompletos = true;

            $.each($('#factura_divAgregarProductoNueva').find('input, select'), function(i, campo) 
            {
                if($(campo).data('requerido') && !$(campo).val()) 
                {
                    $(campo).focus();
                    camposCompletos = false;

                    return false;
                }

                producto[$(campo).attr('name')] = Number($(campo).val());
            });

            if(Number($('#factura input[name="cantidad"]').val()) > Number($('#factura input[name="cantidad"]').attr('max')))
            {
                $('#factura input[name="cantidad"]').focus();
                
                return false;
            }

            if(camposCompletos)
            {
                var tablaVentas = $('#factura_divProductosAgregadosNueva table');

                if(ventas.factura.productos.length == 0)
                {
                    $(tablaVentas).find('tbody').html("");
                }
                
                producto.precio_total = producto.precio_unitario * producto.cantidad;

                $(tablaVentas)
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
                        /*.append($('<td>')
                            .append('<button type="button" class="btn btn-sm btn-secondary" name="eliminar-producto" data-toggle="tooltip" data-placement="top" title="Eliminar">'
                                    + '<span class="fa fa-trash"></span>'
                                + ' </button>'
                            )
                            .attr('class', 'text-center')
                        )*/
                        .attr('data-id_producto', producto.id_producto)
                    )
                    .hide()
                    .fadeIn();

                // Borro los datos en los campos.
                $('#factura_divAgregarProductoNueva').find('input:not([readonly]), select').val("");
                
                ventas.factura.productos.push(producto);

                var $importe_total = this.$div.find('[name="importe_total"]');
                $importe_total.val(utilidades.formatearDinero(Number(utilidades.desformatearDinero($importe_total.val())) + producto.precio_total));

                ventas.factura.asignarEventos();
                ventas.asignarEventos();
            }
        },

        eliminarProducto : function(filaProducto)
        {
            ventas.factura.productos = $.grep(ventas.factura.productos, (producto) => producto.id_producto == $(filaProducto).data('id_producto') , true);

            $(filaProducto).fadeOut(
                () => 
                {
                    $(this).remove();

                    if(ventas.factura.productos.length == 0)
                    {
                        var tablaVentas = $('#divProductosAgregadosNueva table');
                        
                        $(tablaVentas)
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

        // Confirmar nueva venta.
        confirmar : function() 
        {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'factura_nueva_confirmar',
                venta : {
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

                datos.venta[$(campo).attr('name')] = $(campo).val();
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
            
            // Frecuente.
            if(datos.venta.id_tipo_cliente == 1) 
            {
                datos.venta.id_cliente = $formulario.find('select[name="id_cliente"]').val();
            } 
            // De mostrador.
            else if(datos.venta.id_tipo_cliente == 2)
            {
                datos.venta.razon_social = $formulario.find('input[name="razon_social"]').val();
                datos.venta.cuit = $formulario.find('input[name="cuit"]').val();
                datos.venta.domicilio = $formulario.find('input[name="domicilio"]').val();
                datos.venta.telefono = $formulario.find('input[name="telefono"]').val();
                datos.venta.email = $formulario.find('input[name="email"]').val();
            }
            
            datos.venta.importe_total = utilidades.desformatearDinero(datos.venta.importe_total);
            datos.venta.productos = this.productos;
            
            // Envía los datos.
            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                alertas.exito(respuesta.descripcion, '' , () => redireccionar.pagina('ventas.php?area=' + ventas.area));
                ventas.factura.descargar(respuesta.id_venta);
            });
        }
    },

    otros: {
        buscar: function() {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'otros_buscar',
            };

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                var $formulario = $('form[name="otros"]');
                
                // Llena combo Concepto.
                var comboConcepto = $formulario.find('select[name="id_concepto"]').html("");
                $(comboConcepto).append($('<option>').html("Elegir").val("").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.conceptos, function(i, opcion)
                {
                    $(comboConcepto).append($("<option>")
                            .val(opcion.id)
                            .html(opcion.descripcion)
                        );
                });

                $formulario.slideDown();
            });
        },

        confirmar: function() {
            // Prepara los datos.
            var datos = 
            {
                area : ventas.area,
                accion : 'otros_confirmar',
                id_concepto: 0,
                importe: 0
            };

            var $formulario = $('form[name="otros"]');
            
            var id_concepto = $formulario.find('select[name="id_concepto"]').val();
            var importe = $formulario.find('input[name="importe"]').val();

            if(!id_concepto) {
                alertas.advertencia('Debe ingresar el concepto.');
                return;
            }

            if(importe == '') {
                alertas.advertencia('Debe ingresar un importe.');
                return;
            }
            
            datos.id_concepto = id_concepto;
            datos.importe = importe;

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                alertas.exito(respuesta.descripcion);
                var $formulario = $('form[name="otros"]');
                $formulario.find('input[name="importe"]').val("");
                $formulario.slideUp();
            });
        }
    }
}