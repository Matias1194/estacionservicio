var alertas = 
{
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

		// Cerrar alerta.
		$('#botonCerrarAlerta').unbind('click').click(() => $('#alerta').modal('hide'));

		// Función al cerrar alerta.
		if(funcionCerrar) 
		{
			$('#botonCerrarAlerta').click(funcionCerrar);
		}

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

		// Cerrar alerta.
		$('#botonCerrarAlerta').unbind('click').click(() => $('#alerta').modal('hide'));

		// Función al cerrar alerta.
		if(funcionCerrar) 
		{
			$('#botonCerrarAlerta').click(funcionCerrar);
		}

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

		// Cerrar alerta.
		$('#botonCerrarAlerta').unbind('click').click(() => $('#alerta').modal('hide'));

		// Función al cerrar alerta.
		if(funcionCerrar) 
		{
			$('#botonCerrarAlerta').click(funcionCerrar);
		}

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
		$('#botonConfirmarAlerta').unbind('click').click(() => $('#alerta').modal('hide'));

		if(funcionConfirmar)
		{
			$('#botonConfirmarAlerta').unbind('click').click(funcionConfirmar);
		}
		
		// Cerrar alerta.
		$('#botonCerrarAlerta').unbind('click').click(() => $('#alerta').modal('hide'));

		if(funcionCerrar)
		{
			$('#botonCerrarAlerta').click(funcionCerrar);
		}

		$('#alerta #alertaCabecera').removeClass().addClass('modal-header alert-info');
		$('#alerta #alertaTitulo').html('<span class="fa fa-question-circle"></span> ' + titulo);
		$('#alerta #alertaDescripcion').html(descripcion);
		$('#botonConfirmarAlerta').show();
		$('#alerta').modal('show');
	}
}