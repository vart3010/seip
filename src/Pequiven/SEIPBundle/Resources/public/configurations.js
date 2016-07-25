//configuracion de formulario
function confForm(idObject){
	var arrayOnjects = {1:'Objetivos',2:'Programas de Gestión',3:'Indicadores'};
	var arraRoutes = {1:' ',2:'pequiven_configurations_get_to_programs',3:' '};
    $('#title-form').text(arrayOnjects[idObject]); 
    loadDataForm('', Routing.generate(arraRoutes[idObject]),'select_to_data');      		
}
//Carga de formularios
function loadDataForm(data,route,select) {
    var urlResponsibles = route; 
    var objectFormatResult = function(object){
        var value = '';
        if(object.ref){
            value += object.ref;
        }
        if(object.description){
            value +=  ' - '+ object.description;
        }                      
        return value;
    };

    if (data == undefined) {        
        data = [];
    }
    $("#"+select).select2({
        minimumInputLength: 3,
        maximumSelectionLength: 1,
        maximumSelectionSize: 1,
        multiple: true,      
            formatInputTooShort: function () {
                return "Por favor, introduzca 3 o más caracteres";
            },
            formatSelectionTooBig: function (limit) {
                return 'Máximo seleccionado.';
            },
        ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
            url: urlResponsibles,
            dataType: 'json',
            quietMillis: 250,
            data: function (term, page) {
                return {query: term}; // search term                
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                validChangeData(data,select);
                return {results: data};                
            },
            cache: true
        },
        initSelection: function (element, callback) {             
        },
        formatResult: objectFormatResult, // omitted for brevity, see the source of this page
        formatSelection: objectFormatResult, // omitted for brevity, see the source of this page
        escapeMarkup: function (m) {            
            return m;
        } // we do not want to escape markup since we are displaying html in results
    });
    if (data != undefined) {  
        var preselected = [];
        $.each(data, function (index, value) {
            preselected.push(value.id);
        });                
        $('#'+select).select2('data', data);
        $('#'+select).select2('val', preselected);         
    }
};

//validacion y muestra de lista responsables
function validChangeData(data,select){
	$('#'+select).on('change',function(){
		//console.log(data[1]['count']);
		findData($(this).val());
		$('#list-data').show();
	});
}

function findData(idObject){    
    var data = {idObject: idObject, typeObject:2};    
    $.ajax({
            type: 'get',
            url: Routing.generate('pequiven_configuration_find_data'),
            data: data,                              
            beforeSend:function(){
                //$('#loading').css({display:'block'});                            
            },
            complete:function(){
                //$('#loading').css('display','none');                        
            },
            success: function (data) {                                                        
             	loadListUser(data, data.length);
            }
    });
}

function loadListUser(data, count){
	if (count > 0) {
    	$('#body-list').html('<li>'+
								'<a href="javascript:void(0);" class="list-link icon-user" title="Click to edit">'+
									'<span class="meter orange-gradient"></span>'+
									'<span class="meter orange-gradient"></span>'+
									'<span class="meter"></span>'+
									'<span class="meter"></span>'+
									'<strong>John</strong> Doe'+
								'</a>'+
								'<div class="button-group absolute-right compact show-on-parent-hover">'+
									'<a href="" class="button icon-pencil">Edit</a>'+
									'<a href="" class="button icon-gear with-tooltip" title="Other actions"></a>'+
									'<a href="" class="button icon-trash with-tooltip confirm" title="Delete"></a>'+
								'</div>'+
							'</li>');
    }else{
    	$('#body-list').html('<li class="new-row twelve-columns empty_row" align="center">Sin Usuarios Cargados</li>');
    };
}