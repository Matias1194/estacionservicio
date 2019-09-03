var bd = 
{
	enviar : function(datos, modulo, funcionExito)
	{
		$.ajax(
		{
		    type : "POST",
		    url : "bd/bd_" + modulo + ".php",
		    data : datos,
		    datatype : "json",

		    success : function(respuestaBD)
		    {
		    	try 
		        {
		            var respuesta = JSON.parse(respuestaBD);
		            if(respuesta.exito)
		            {
		            	if(funcionExito)
		            	{
		            		funcionExito(respuesta);
		            	}
		            } 
		            else
		            {
		                alertas.error(respuesta.descripcion, '', (respuesta.redireccionar ? redireccionar.inicio : null));
		            }
		        }
		        catch(error)
		        {
		            alertas.error("Ocurrió un error al intentar conectarse con la base de datos.");
		            console.log(error.stack);
		            console.log(respuesta);
		        }
		    },

		    error : function (xhr, ajaxOptions, thrownError)
		    {
		        alertas.error("Ocurrió un error al intentar conectarse con la base de datos.");
		        console.log(xhr.status);
		        console.log(thrownError);
		    }
		});
	}
}