var index = 0;
var table = "";
var campo;

var campoClave;
var idsClaves = new Array();

function setTable(obj) {
    table = obj;
}

function campoClave(clave) {
    campoClave = clave;
}

function setNameCampos(arrayNames) {
    campo = arrayNames;
}

function delRowDefault() {
		$('#'+table+' tbody tr').each(function (i, row) {
		var clas = $(this).attr("class");
		//alert(clas);
		if(clas=="odd"){
			$(this).remove();
		}
	});
 }

function addRow(data){
    

	var fila = "<tr class='id_"+index+"'>"
	for(i=0;i<data.length;i++) {
        fila = fila + "<td class='"+data[i][0]+"'>"+data[i][1]+"</td>";
        if(i==campoClave) { 
           idsClaves.push(data[i][0]);
        }
	}
	fila = fila + "</tr>";

    if(idsClaves.indexOf) {}

	$("#"+table).find("tbody").append(fila);
}

function delRow(id) {
	$("#"+table+" tbody").find("tr.id_"+id).remove();
}

function getRows() {
	var result = [];
$("#"+table+" tbody tr").each(function( index ) {
	var fila = [];
	$(this).find("td").each(function(ind){
		//alert($(this).html());
		//if(!$(this).attr("form-control")) { 
			var celda = $(this).attr("class");
			fila.push(celda);
		//}

	});
	result.push(fila);
});

return result;
}

function convertRows(rows) {
	var registros = new Object();
	for(var i=0; i<rows.length; i++) {
		var row = rows[i];
		var filas = {};

		for(var y=0;y<row.length-1;y++) {   
            filas[campo[y]] = row[y];
		}
		registros["row"+i] = filas;
	}
    var rs = new Object();
    rs.datos = registros;
    return rs;
}
