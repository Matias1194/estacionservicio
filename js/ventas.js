$(function() 
{
	ventas.inicializar();
});

var ventas =
{
    modulo : 'ventas',

    inicializar : function()
    {
        this.inicio.$div = $('#inicio');
        this.tickets.$div = $('#tickets');

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
            this.$div.find('button[name="abrir_turno"]').click(() => ventas.turno.abrir());

            // Cierra el turno.
            this.$div.find('button[name="cerrar_turno"]').click(() => ventas.turno.cerrar());
            
            // Carga la pantalla para un nueva venta con tickets.
            this.$div.find('button[name="tickets"]').click(() => ventas.tickets.buscar());

            // Carga la pantalla para un nueva venta con factura A.
            this.$div.find('button[name="factura"]').click(() => ventas.factura.mostrar());
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
                accion : 'caja_estado',
            };

            var $boton_tickets = this.$div.find('button[name="tickets"]');
            var $boton_factura = this.$div.find('button[name="factura"]');
            var $boton_abrir_caja = this.$div.find('button[name="abrir_caja"]');
            var $boton_cerrar_caja = this.$div.find('button[name="cerrar_caja"]');
            var $boton_abrir_turno = this.$div.find('button[name="abrir_turno"]');
            var $boton_cerrar_turno = this.$div.find('button[name="cerrar_turno"]');

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                if(respuesta.caja_estado)
                {
                    if(respuesta.turno_estado)
                    {
                        $boton_tickets.show();
                        $boton_factura.show();
                        $boton_cerrar_turno.show();
                    }
                    else 
                    {
                        $boton_abrir_turno.show();
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
                redireccionar.ventas();
            });
        },

        cerrar_mostrar : function() {
            $('form[name="cerrar_caja"]').fadeIn();
        },

        cerrar_confirmar : function() {
            // Prepara los datos.
            var datos = 
            {
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
                redireccionar.ventas();
            });
        },
    },

    turno: {
        abrir : function() {
            // Prepara los datos.
            var datos = 
            {
                accion : 'abrir_turno',
            };

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                redireccionar.ventas();
            });
        },

        cerrar: function() {
            // Prepara los datos.
            var datos = 
            {
                accion : 'cerrar_turno',
            };

            bd.enviar(datos, ventas.modulo, (respuesta) =>
            {
                redireccionar.ventas();
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
            this.$div.find('select[name="id_producto"]').change((e) => {
                this.$div.find('input[name="precio_unitario"]').val($(':selected', e.target).data('precio'));
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
                accion : 'nueva_buscar'
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
            redireccionar.pagina('reportes/reporte_ticket.php?id=' + id);
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
                accion : 'nueva_confirmar',
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
                alertas.exito(respuesta.descripcion, '' , redireccionar.ventas);
                ventas.tickets.descargar(respuesta.id_venta);
            });
        }
    }   
}