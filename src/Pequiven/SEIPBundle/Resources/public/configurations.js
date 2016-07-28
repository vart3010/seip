//configuracion de formulario
function confForm(idObject){
	var arrayOnjects = {1:'Objetivos',2:'Programas de Gestión',3:'Indicadores'};
	var arraRoutes = {1:' ',2:'pequiven_configurations_get_to_programs',3:' '};
    $('#title-form').text(arrayOnjects[idObject]); 
    if (idObject == 2) { 
    	$('#label').html('<label class="label">Consulta</label><input type="text" id="select_to_data" name="select_to[data]" style="width: 270px">');
    	loadDataForm('', Routing.generate(arraRoutes[idObject]),'select_to_data');
    }else{
    	$('#label').html('');
    };
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
        if(object.firstname){
          	value += object.firstname;
      	}
      	if(object.lastname){
        	value +=  ' '+ object.lastname;
      	}
      	if(object.numPersonal){
        	value +=  " ("+object.numPersonal+")";
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
            	if (data[0]['program']){validChangeData(data,select);};
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
		findData($(this).val());
		$('#list-data').show();
	});
}

$("#addUser").click(function(){	
	if ($('#idObject').val()) {
		$('#formAddUser').show();   
		loadDataForm('',Routing.generate('pequiven_responsibles_to_plan'),'data_user_select'); 		
	};
});

$('#save-to-form').click(function(){
	var data = {
		user:       $('#data_user_select').val(),
		action:     $('select#select-action').val(),
		idObject:   $('#idObject').val(),
		typeObject: 2
	};
	if (data['user'].length != 0) {
		$.ajax({
            type: 'post',
            url: Routing.generate('pequiven_configuration_set_data_users'),
            data: data,                              
            beforeSend:function(){
                $('#loading').css({display:'block'});                            
            },
            complete:function(){
                $('#loading').css('display','none');                        
            },
            success: function (data) {                                                        
             	if (data == true) {$('#formAddUser').hide();};
             	findData($('#idObject').val());
            }
    	});
	};
});

$('#cancel-to-form').click(function(){
	$('#formAddUser').hide();   	
});

$('#reload').click(function(){
	findData($('#idObject').val());
});

function findData(idObject){    
	$('#idObject').val(idObject);
    var data = {idObject: idObject, typeObject:2};    
    $.ajax({
            type: 'get',
            url: Routing.generate('pequiven_configuration_find_data'),
            data: data,                              
            beforeSend:function(){
                $('#loading').css({display:'block'});                            
            },
            complete:function(){
                $('#loading').css('display','none');                        
            },
            success: function (data) {                                                        
             	loadListUser(data);
            }
    });
}

function loadListUser(data){
	var listUser = "";	
    //$('#addUser').show();
	if (data['count'] > 0) {
		for (var i=0; i<data['count']; i++) {
	    	listUser += '<li>'+
							'<a href="javascript:void(0);" class="list-link icon-user" title="Click to edit">'+								
								'&nbsp;<strong>'+data['user'][i]+'</strong> - <b>Acción:</b>&nbsp;'+data['action'][i]+''+
							'</a>'+
							'<div class="button-group absolute-right compact show-on-parent-hover">'+
								'<a href="" class="button icon-pencil" onClick="editUser('+data['idUser'][i]+');">Edit</a>'+
								'<a href="" class="button icon-gear with-tooltip" title="Other actions"></a>'+
								'<a href="" class="button icon-trash with-tooltip confirm" title="Delete" onClick="deleteUser('+data['idUser'][i]+');"></a>'+
							'</div>'+
						'</li>';		
		};
		$('#body-list').html(listUser);		
    }else{
    	//$('#addUser').prop('disabled', true);    	
    	$('#body-list').html('<li class="new-row twelve-columns empty_row" align="center">Sin Usuarios Cargados</li>');
    };
}

function editUser(idUser){
	console.log(idUser);
}

function deleteUser(idUser){
	console.log(idUser);
}