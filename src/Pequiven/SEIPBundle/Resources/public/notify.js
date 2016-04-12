/*
    Notify.js - Funciones jQuery para la seccion de notificación del SEIP

    Máximo Sojo <maximosojo@atechnologies.com.ve>
*/

var urlData;

var urlMessage;

var urlMessageDelete;

var urlFavMessage;

var urlMessages;

var notify;

$("#reload").click(function(){    
    getData(urlData); 
    loadAllDataMessage();   
});

function setNotifications(dataNotify){     
    $('#notifyAll').text(dataNotify['notify']);
    $('#notifyFav').text(dataNotify['fav']);
    $('#notifyTrash').text(dataNotify['trash']);

    $('#objetives').text(dataNotify['objetives']);            
    $('#programt').text(dataNotify['programt']);            
    $('#indicators').text(dataNotify['indicators']);            
    $('#standardization').text(dataNotify['standardization']);            
    $('#production').text(dataNotify['production']);            
    $('#evolution').text(dataNotify['evolution']);           

    if (dataNotify['notifyUser'] > 0) {
        $('#userNotify').show().text(dataNotify['notifyUser']);
    }else{
        $('#userNotify').hide();        
    };
}

function setUrlData(urlGetData){
    urlData = urlGetData;
    getData(urlData);
}

function setUrlMessage(urlGetMessage){
    urlMessage = urlGetMessage;
}

function setUrlMessageDelete(urlGetMessageDelete){
    urlMessageDelete = urlGetMessageDelete;
}

function setUrlMessageFav(urlFav){
    urlFavMessage = urlFav;
}

function setUrlMessagesData(urlMessagesData){
    urlMessages = urlMessagesData;
}

function getData(urlData){    
    var data = {
        id: 1,                    
    }; 

    $.ajax({
            type: 'get',
            url: urlData,
            data: data,                              
            beforeSend:function(){
                $('#loading').css({display:'block'});                            
            },
            complete:function(){
                $('#loading').css('display','none');                        
            },
            success: function (data) {                                                        
                setNotifications(data);
            }
    });
}

function showMessage(id){  
    var data = {
        idMessage: id,                    
    };            
    $.ajax({
            type: 'get',
            url: urlMessage,
            data: data,
            beforeSend:function(){
                $('#loading').css({display:'block'});                            
            },
            complete:function(){
                $('#loading').css('display','none');                        
            },                    
            success: function (data) {                        
                $(location).attr('href', data["url"]);                                                
                //$('#new-message_' + id).css('display','none');                        
                $('#out-message_' + id).css('display','block');
                $('#buttonToll').css('display', 'block');                        
                $('#messageNone').html(data['description']);                
                
                $('#new-message_' + id).html('<i class="fa fa-envelope-o" id="new-message_'+ id +'"></i>');

                var path = data['path'];                                
                $('#href').html("<a href data='"+path+"' id='visualize' class='button red-gradient float-right with-tooltip' title='Visualizar' onclick='visualize();'>Visualizar</a>");
                $('#sectionButton').html('<a href class="button" title="Eliminar" onclick="deleteMessage('+id+');"><span class="icon-trash"></span></a><a href class="button" title="Marcar como Importante" onclick="favouriteMessage('+id+');"><span class="icon-flag"></span></a>');
                getData(urlData);                
            }
    });
}   

function visualize(){    
    url = $('#visualize').attr('data');    
    window.open(url, '_blank');
}

function deleteMessage(id){    
    var data = {
        idMessage: id,                    
    };             
    $.ajax({
            type: 'get',
            url: urlMessageDelete,
            data: data, 
            beforeSend:function(){
                $('#loading').css({display:'block'});                            
            },
            complete:function(){
                $('#loading').css('display','none');                        
            },                    
            success: function (data) {                        
                $(location).attr('href', data["url"]);                                                
                $('#iMessage_' + id).css('display','none');  
                $('#buttonToll').css('display', 'none');                       
                $('#messageNone').html('<i class="fa fa-check"></i> Notificación Eliminada Satisfactoriamente');
                getData(urlData);
            }
    });
} 

function favouriteMessage(id){          
    var data = {
        idMessage: id,                    
    };     
    $.ajax({
            type: 'get',
            url: urlFavMessage,
            data: data, 
            beforeSend:function(){
                    $('#loading').css({display:'block'});                            
            },
            complete:function(){
                $('#loading').css('display','none');                        
            },                    
            success: function (data) {                        
                $(location).attr('href', data["url"]);                                                
                $('#iMessage_' + id).css('display','none');  
    			$('#buttonToll').css('display', 'none');                       
                $('#messageNone').html('<i class="fa fa-check"></i> Notificación enviada a Importantes');
                getData(urlData);
            }
    });
}   

function getMessagesData(type, tag, typeData){    
    var data = {
        type: type, 
        typeData: typeData                   
    };     

    $.ajax({
            type: 'get',
            url: urlMessages,
            data: data, 
            beforeSend:function(){
                $('#loading').css({display:'block'});                            
            },
            complete:function(){
                $('#loading').css('display','none');
            },                    
            success: function (data) {
                createMessages(type, tag, typeData, data);                    
            }
    }); 
}

function createMessages(type, tag, typeData, data){
    var myArray = [];    
    var arraylength = data.length;
    
    for (var i=0; i<data['cont']; i++) {
        var id = data['id'][i]; 
        
        if (data['read'][id] == true) {
            var font = "fa-envelope-o";
        }else{
            var font = "fa-envelope";            
        };  

        if (data['status'][id] == 1) {
            var color = "ff0000";
        }else if(data['status'][id] == 2){
            var color = "3bc600";            
        }else if(data['status'][id] == 3){
            var color = "00d518";            
        };

        myArray.push('<li id="iMessage_'+ data['id'][i] +'"  onclick="showMessage('+id+');"><span class="message-status"><a href="javascript:void(0);" style="color:#ebd106;" title="Mensaje sin leer" id="new-message_'+ data['id'][i] +'"><i class="fa '+font+'"></i></a><a href="javascript:void(0);" class="" style="color:#'+color+';"><i class="fa fa-tag"></i></a></span><a href title="Leer Notificación" id="title" onclick=""><strong class="blue">'+data['title'][id]+'</strong><br><strong>'+data['date'][id]+'</strong></a></li>');
    }
        if (type == 1) {
            $(tag+"_tag").html(myArray);
        }else{
            $(tag).html(myArray);                
        };     
}

/*$("#objetives_data").click(function(){
    getMessagesData(1,"#objetives", 1);
    $('#messageNone').text('Selecciones un mensaje.');
}); 

$("#programt_data").click(function(){
    getMessagesData(1,"#programt", 2);
    $('#messageNone').text('Selecciones un mensaje.');
}); 

$("#indicators_data").click(function(){
    getMessagesData(1,"#indicators", 3);
    $('#messageNone').text('Selecciones un mensaje.');
}); 

$("#standardization_data").click(function(){
    getMessagesData(1,"#standardization", 4);
    $('#messageNone').text('Selecciones un mensaje.');
}); 

$("#production_data").click(function(){
    getMessagesData(1,"#production", 5);
    $('#messageNone').text('Selecciones un mensaje.');
}); 

$("#evolution_data").click(function(){
    getMessagesData(1,"#evolution", 6);
    $('#messageNone').text('Selecciones un mensaje.');
});*/

function loadAllDataMessage(){
    var arrayData = [];
    arrayData = ['objetives', 'programt', 'indicators', 'standardization', 'production', 'evolution'];
    
    for (var i=0; i<arrayData.length; i++) {
        var typeData = i+1;   
        var tag = "#"+arrayData[i];     
        getMessagesData(1, tag, typeData);         
    }
}

/*$( "#prueba" ).click(function() {
  $( "#notify" ).click();
});*/

$("#notify").click(function(){ 
    getData(urlData); 
    loadAllDataMessage();
});

$("#fav").click(function(){
    getMessagesData(2,"#favMessage", 0);
    //createMessages(2,"#favMessage");
    $('#messageNone').text('Sección importantes, selecciones un mensaje.');
});	

$("#trash").click(function(){
    getMessagesData(3,"#trashMessage", 0);
    //createMessages(3,"#trashMessage");    
    $('#messageNone').text('Sección eliminados, selecciones un mensaje.');    
}); 