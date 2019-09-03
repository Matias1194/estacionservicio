$(function() 
{
	alertas.asignarEventos();
});

var alertas = 
{
	asignarEventos : function() 
	{
		$('.toast').toast(
			{
				delay: 2000
			}
		);
	},

	notificacion : function()
	{
		$('.toast').toast('show');
	},

	exito : function(descripcion, titulo, funcionCerrar)
	{
		if(!descripcion) 
		{
			descripcion = "...";
		}
		if(!titulo) 
		{
			titulo = "Exito";
		}

		$('#botonCerrarAlerta').unbind('click');

		// Función antes cerrar.
		if(funcionCerrar) 
		{
			$('#botonCerrarAlerta').unbind('click').click(funcionCerrar);
		}
		
		// Cerrar alerta.
		$('#botonCerrarAlerta').click(() => $('#alerta').modal('hide'));

		$('#alerta #alertaCabecera').removeClass().addClass('modal-header alert-success');
		$('#alerta #alertaTitulo').html('<span class="fa fa-check-square"></span> ' + titulo);
		$('#alerta #alertaDescripcion').html(descripcion);
		$('#botonConfirmarAlerta').hide();
		$('#alerta').modal('show');
	},

	advertencia : function(descripcion, titulo, funcionCerrar)
	{
		if(!descripcion)
		{
			descripcion = "...";
		}
		if(!titulo) 
		{
			titulo = "Advertencia";
		}

		$('#botonCerrarAlerta').unbind('click');

		// Función antes cerrar.
		if(funcionCerrar) 
		{
			$('#botonCerrarAlerta').unbind('click').click(funcionCerrar);
		}
		
		// Cerrar alerta.
		$('#botonCerrarAlerta').click(() => $('#alerta').modal('hide'));

		$('#alerta #alertaCabecera').removeClass().addClass('modal-header alert-warning');
		$('#alerta #alertaTitulo').html('<span class="fa fa-exclamation-triangle"></span> ' + titulo);
		$('#alerta #alertaDescripcion').html(descripcion);
		$('#botonConfirmarAlerta').hide();
		$('#alerta').modal('show');
	},

	error : function(descripcion, titulo, funcionCerrar)
	{
		if(!descripcion) 
		{
			descripcion = "...";
		}
		if(!titulo) 
		{
			titulo = "Error";
		}

		$('#botonCerrarAlerta').unbind('click');

		// Función antes cerrar.
		if(funcionCerrar) 
		{
			$('#botonCerrarAlerta').unbind('click').click(funcionCerrar);
		}
		
		// Cerrar alerta.
		$('#botonCerrarAlerta').click(() => $('#alerta').modal('hide'));

		$('#alerta #alertaCabecera').removeClass().addClass('modal-header alert-danger');
		$('#alerta #alertaTitulo').html('<span class="fa fa-exclamation-circle"></span> ' + titulo);
		$('#alerta #alertaDescripcion').html(descripcion);
		$('#botonConfirmarAlerta').hide();
		$('#alerta').modal('show');
	},

	confirmar : function(descripcion, titulo, funcionConfirmar, funcionCerrar)
	{
		if(!descripcion) 
		{
			descripcion = "...";
		}
		if(!titulo) 
		{
			titulo = "Confirmar";
		}

		// Confirmar Alerta.
		if(funcionConfirmar)
		{
			$('#botonConfirmarAlerta').unbind('click').click(funcionConfirmar);
		}
		
		$('#botonCerrarAlerta').unbind('click');

		// Función antes cerrar.
		if(funcionCerrar) 
		{
			$('#botonCerrarAlerta').unbind('click').click(funcionCerrar);
		}
		
		// Cerrar alerta.
		$('#botonCerrarAlerta').click(() => $('#alerta').modal('hide'));

		$('#alerta #alertaCabecera').removeClass().addClass('modal-header alert-info');
		$('#alerta #alertaTitulo').html('<span class="fa fa-question-circle"></span> ' + titulo);
		$('#alerta #alertaDescripcion').html(descripcion);
		$('#botonConfirmarAlerta').show();
		$('#alerta').modal('show');
	}
}