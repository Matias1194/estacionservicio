$(function() 
{
	ingreso.asignarEventos();
});

var ingreso = 
{
	asignarEventos : function() 
	{
        // Iniciar sesión al presionar la tecla Enter.
        $('#campoClave')
            .keypress((k) => k.keyCode && k.keyCode == '13' ? this.iniciarSesion() : k.which && k.which == '13' ? this.iniciarSesion() : null);

		// Botón Ingresar.
        $('#botonIngresar').unbind('click').click(() => this.iniciarSesion());
	},

	iniciarSesion : function()
    {
        var usuario = $('#campoUsuario').val();
        var clave = $('#campoClave').val();
        var mensajeError = "";
        
        if(usuario == "")
        {
            mensajeError += "Debe ingresar el usuario";
        }
        else if(clave == "")
        {
            mensajeError += "Debe ingresar la clave";
        }
        
        if(mensajeError != "") 
        {
            alertas.advertencia(mensajeError);
            return;
        }

        var datos = 
        {
            accion: 'iniciarSesion',
            usuario: usuario,
            clave: clave
        };

        bd.enviar(datos, 'usuarios', ingreso.ingresarExito);
    },

    ingresarExito : function(respuesta)
    {
        redireccionar.pagina(respuesta.url);
    }
}