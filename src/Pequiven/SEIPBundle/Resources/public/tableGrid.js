var index = 0; //INDICE DE ELEMENTOS DE LA TABLA
var table = ""; //ID DE LA TABLA
var campo;      //NOMBRE DE LOS CAMPOS EN FORMA DE ARRAY, QUE DEVOLVERA EL JSON
var fieldRsJson; // CAMPO DONDE SE COLOCARA EL STRING EN JSON RESULTANTE
var columsTotals; //INDICES DE LAS COLUMNAS QUE SE QUIERES SUMAR EMPEZANDO DESDE 0..1....N
var campoClave; //CAMPO CLAVE PARA NO REPETIR REGISTROS AL MOMENTO DE AGREGAR REGISTROS

var idsClaves = new Array();


function setTable(obj) {
    table = obj;
}

function setFieldRsJson(field) {
    fieldRsJson = field;
}

function campoClave(clave) {
    campoClave = clave;
}

function setNameCampos(arrayNames) {
    campo = arrayNames;
}

function setColumsTotals(index) {
    columsTotals = index;
}

function delRowDefault() {
    $('#' + table + ' tbody tr').each(function (i, row) {
        var clas = $(this).attr("class");
        //alert(clas);
        if (clas == "odd") {
            $(this).remove();
        }
    });
}

function addRow(data) {

    var allow = idsClaves.indexOf(data[campoClave][0]);
    if (allow < 0) {
        var fila = "<tr class='id_" + index + "'>";
        for (i = 0; i < data.length; i++) {
            fila = fila + "<td class='" + data[i][0] + "'>" + data[i][1] + "</td>";
            if (i == campoClave) {
                idsClaves.push(data[i][0]);
            }
        }
        fila = fila + "</tr>";

        $("#" + table).find("tbody").append(fila);
    } else {
        alert("El producto ya se encuentra!");
    }
    totals();
    
}

function delRow(id, idProduct) {
    $("#" + table + " tbody").find("tr.id_" + id).remove();

    var allow = idsClaves.indexOf(idProduct);

    if (allow >= 0) {
        idsClaves[allow] = "";
    }
    getJson();
    totals();
}

function getRows() {
    var result = [];
    $("#" + table + " tbody tr").each(function (index) {
        var fila = [];
        $(this).find("td").each(function (ind) {
            var celda = $(this).attr("class");
            fila.push(celda);
        });
        result.push(fila);
    });

    return result;
}

function convertRows(rows) {
    var registros = new Object();
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var filas = {};

        for (var y = 0; y < row.length - 1; y++) {
            filas[campo[y]] = row[y];
        }
        registros["row" + i] = filas;
    }
    var rs = new Object();
    rs.datos = registros;
    return rs;
}

function getJson() {
    var rows = getRows(table);
    var obj = convertRows(rows);
    console.log(obj);
    var jsonStr = JSON.stringify(obj);
    $("input" + fieldRsJson).val(jsonStr);
}

function totals(){
    var totals = new Array();
    var total=0;
  for(var i=0;i<columsTotals.length;i++){
        total = parseFloat(total) + parseFloat(getTotal(columsTotals[i]));
        totals[i] = total;
  }
  alert(totals);
  //return totals;
}

function getTotal(numField) {
    var total = 0;
    $("#" + table + " tbody tr").each(function (index) {
        var cont=0;
        $(this).find("td").each(function (ind) {
            if(cont==numField) { 
                var celda = $(this).attr("class");
                total = parseFloat(total)+parseFloat(celda);
            }
            cont++;
        });
        
    });
    return total;
    
}
