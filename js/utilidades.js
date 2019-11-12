var utilidades = 
{
	formatearDinero : function(valor)
	{
		return '$ ' + Number(valor).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
	},

	desformatearDinero : function(valor)
	{
		return valor.replace('$ ', '').replace(/\./gi, '').replace(',', '.');
	},

	tienePermiso : function(permisos, id)
	{
		return permisos.find(permiso => permiso.id_permiso == id) != undefined;
	}
}