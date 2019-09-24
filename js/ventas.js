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

        this.inicio.asignarEventos();
        this.inicio.mostrar();
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

            // Carga la pantalla para un nueva venta con factura A.
            this.$div.find('button[name="factura"]').click(() => ventas.factura.mostrar());

            // Carga la pantalla para un nueva venta con tarjeta.
            this.$div.find('button[name="tarjeta"]').click(() => ventas.tarjeta.mostrar());

            // Carga la pantalla para un nueva venta con tickets.
            this.$div.find('button[name="tickets"]').click(() => ventas.tickets.buscar());
        },

        mostrar : function()
        {
            ventas.ocultarPantallas();
            this.$div.fadeIn();
        }
    },

    // Nueva venta con tickets.
    tickets :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => ventas.inicio.mostrar());

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
                    $(comboProductos).append($("<option>").val(producto.id).html(producto.descripcion));
                });

                // Borro los datos en los campos.
                $formulario.find('input:not([readonly])').val("");
                
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
            });
        }
    }    
}