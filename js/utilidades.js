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

	tienePermiso : function(permisos, codigo)
	{
		return permisos.find(permiso => permiso.codigo_permiso == codigo) != undefined;
	}
}