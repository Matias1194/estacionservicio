$(function() 
{
	productos.inicializar();
});

var productos =
{
    modulo : 'productos',

    inicializar : function()
    {
        this.listado.$div = $('#listado');
        this.nuevo.$div = $('#nuevo');
        this.editar.$div = $('#editar');

        this.listado.buscar();
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

    // Listado.
    listado : 
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Nuevo.
            this.$div.find('button[name="nuevo"]').click((e) => productos.nuevo.buscar());

            // Editar.
            this.$div.find('button[name="editar"]').click((e) => productos.editar.buscar($(e.currentTarget).closest('tr').data('id')));
            
            // Eliminar.
            this.$div.find('button[name="eliminar"]').click((e) => productos.eliminar($(e.currentTarget).closest('tr').data('id')));
        },

        mostrar : function()
        {
            productos.ocultarPantallas();
            this.$div.fadeIn();
        },
        
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                accion : 'buscar_listado'
            };
            
            // Envía los datos.
            bd.enviar(datos, productos.modulo, (respuesta) => 
            {
                var tablaProductos = $('#listado table');
                var barraCargando = $('#listado .barraCargando');
                $(tablaProductos).find('tbody').html("");
    
                if(respuesta.productos.length == 0)
                {
                    $(tablaProductos)
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
                    $.each(respuesta.productos, function(indice, producto) 
                    {
                        $(tablaProductos)
                            .find('tbody')
                            .append($('<tr>')
                                .append($('<td>')
                                    .append(producto.id)
                                )
                                .append($('<td>')
                                    .append(producto.descripcion)
                                )
                                .append($('<td>')
                                    .append(producto.tipo_producto)
                                )
                                .append($('<td>')
                                    .append(producto.unidades)
                                )
                                .attr('data-id', producto.id)
                            )
                        
                        // Botón Editar Producto.
                        //if(utilidades.tienePermiso(respuesta.permisos, 4))
                        //{
                            $(tablaProductos)
                                .find('tbody tr:last')
                                .append($('<td>')
                                    .append('<button type="button" class="btn btn-sm btn-warning" name="editar" data-toggle="tooltip" data-placement="top" title="Editar">'
                                            + '<span class="fa fa-pencil-alt"></span>'
                                        + ' </button>'
                                    )
                                    .attr('class', 'text-center')
                                );
                        //}
    
                        // Botón Eliminar Producto.
                        //if(utilidades.tienePermiso(respuesta.permisos, 7))
                        //{
                            $(tablaProductos)
                                .find('tbody tr:last')
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
                $(tablaProductos).fadeIn();
    
                this.asignarEventos();
                this.mostrar();
            });
        }
    },

    // Nueva producto.
    nuevo :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => productos.listado.buscar());

            // Confirmar nuevo producto.
            this.$div.find('button[name="confirmar"]').click(() => this.confirmar());
        },

        mostrar : function()
        {
            productos.ocultarPantallas();
            this.$div.fadeIn();
        },

        // Buscar información para crear producto.
        buscar : function()
        {
            // Prepara los datos.
            var datos = {
                accion : 'nuevo_buscar'
            };

            // Envía los datos.
            bd.enviar(datos, productos.modulo, (respuesta) =>
            {
                var $formulario = this.$div.find('form');

                // Lleno combo Tipo Producto.
                var comboTipoProducto = $formulario.find('select[name="id_tipo_producto"]').html("");
                $(comboTipoProducto).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_productos, function(i, opcion)
                {
                    $(comboTipoProducto).append($("<option>").val(opcion.id).html(opcion.descripcion));
                });

                // Borro los datos en los campos.
                $('#nuevo form').find('input:not([readonly])').val("");
                
                this.asignarEventos();
                this.mostrar();
            });
        },

        // Confirmar nuevo producto.
        confirmar : function() 
        {
            // Prepara los datos.
            var datos = 
            {
                accion : 'nuevo_confirmar',
                producto : {}
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

                datos.producto[$(campo).attr('name')] = $(campo).val();
            });
            
            if(mensajeError)
            {
                alertas.advertencia(mensajeError, '', funcionCerrar);
                return;
            }
            
            // Envía los datos.
            bd.enviar(datos, productos.modulo, (respuesta) =>
            {
                alertas.exito(respuesta.descripcion, '' , redireccionar.productos);
            });
        }
    },

    // Editar producto.
    editar :
    {
        $div : null,

        asignarEventos : function()
        {
            // Desasignar eventos.
            this.$div.find('button').unbind('click');

            // Vuelve a la pantalla anterior.
            this.$div.find('button[name="volver"]').click(() => productos.inicio.mostrar());

            // Agregar Producto.
            this.$div.find('button[name="agregar-producto"]').click(() => this.agregarProducto());

            // Eliminar Producto.
            this.$div.find('button[name="eliminar-producto"]').click((e) => this.eliminarProducto($(e.target).closest('tr'))); 

            // Confirmar editar producto.
            this.$div.find('button[name="confirmar"]').click(() => this.confirmar());
        },

        mostrar : function()
        {
            productos.ocultarPantallas();
            this.$div.fadeIn();
        },

        // Buscar información para generar producto.
        buscar : function(id)
        {
            // Prepara los datos.
            var datos = {
                accion : 'editar_buscar',
                id: id
            };

            // Envía los datos.
            bd.enviar(datos, productos.modulo, (respuesta) =>
            {
                var $formulario = this.$div.find('form');

                // Lleno combo Tipo Producto.
                var comboTipoProducto = $formulario.find('select[name="id_tipo_producto"]').html("");
                $(comboTipoProducto).append($('<option>').html("Elegir").attr({'disabled': true, 'selected': true}));
                
                $.each(respuesta.tipos_productos, function(i, opcion)
                {
                    $(comboTipoProducto).append($("<option>").val(opcion.id).html(opcion.razon_social));
                });

                // Lleno los campos.
                $.each(respuesta.producto, function(campo, valor)
                {
                    $formulario.find('[name="' + campo + '"').val(valor);
                });

                this.asignarEventos();
                this.mostrar();
            });
        },

        // Confirmar edición de producto.
        confirmar : function() 
        {
            // Prepara los datos.
            var datos = 
            {
                accion : 'editar_confirmar',
                producto : {
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

                datos.producto[$(campo).attr('name')] = $(campo).val();
            });

            datos.producto.importe_total = utilidades.desformatearDinero(datos.producto.importe_total);
            
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

            datos.producto.productos = this.productos;
            
            // Envía los datos.
            bd.enviar(datos, productos.modulo, (respuesta) =>
            {
                alertas.exito(respuesta.descripcion, '' , redireccionar.productos);
            });
        }
    },

    // Eliminar producto.
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
            bd.enviar(datos, productos.modulo, (respuesta) =>
            {
                // Actualizar fila.
                $('#listado tr[data-id="' + respuesta.id + '"]')
                    .fadeOut(() => $(this).remove());

                alertas.exito(respuesta.descripcion);
            });
        });
    }
}