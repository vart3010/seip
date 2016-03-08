var urlData;

var urlMessage;

var urlMessageDelete;

var urlFavMessage;

var urlMessages;

$("#reload").click(function(){    
    getData(urlData);    
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
                $('#new-message_' + id).css('display','none');                        
                $('#out-message_' + id).css('display','block');
                $('#buttonToll').css('display', 'block');                        
                $('#messageNone').html(data['description']);
                //document.getElementById("messageNone").innerHTML = "<a href=\"{{ path('pequiven_sig_monitoring_show',{'id': 1 })}}\">Ver</a>";
                var path = data['path'];                
                $('#href').html("<a href='{{ path('pequiven_sig_monitoring_show',{'id': 1 })}}' class='button red-gradient float-right with-tooltip' title='Visualizar'>Visualizar</a>");
                $('#sectionButton').html('<a href class="button" title="Eliminar" onclick="deleteMessage('+id+');"><span class="icon-trash"></span></a><a href class="button" title="Marcar como Importante" onclick="favouriteMessage('+id+');"><span class="icon-flag"></span></a>');
            }
    });
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

function getMessagesData(type, tag){    
    var data = {
        type: type,                    
    };     

    $.post(urlMessages, data, function(){
        createMessages();
    });

    /*$.ajax({
            type: 'get',
            url: urlMessages,
            data: data, 
            /*beforeSend:function(){
                    $('#loading').css({display:'block'});                            
            },
            complete:function(){
                //$('#loading').css('display','none');                        
            },                    
            success: function (data) {                                                        
                createMessages();
            }
    });  */
}

function createMessages(){
    var myArray = [];    
    //var arraylength = myArray.length;
    for (var i=0; i<5; i++) {        
        myArray.push('<li id="iMessage_'+ i +'"><span class="message-status"><a href="javascript:void(0);" style="color:#ebd106;" id="" title="Mensaje sin leer"><i class="fa fa-envelope-o" id="new-message_"></i></a><a href="javascript:void(0);" class="" style="color:#3bc600;"><i class="fa fa-tag"></i></a></span><a href title="Leer Notificación" id="title" onclick=""><strong class="blue">Importantes</strong><br><strong>12/02/2015</strong></a></li>');
    }
    $('#favMessage').html(myArray);
    console.log(myArray);
}

$("#notify").click(function(){
    console.log('Notify'); 
}); 

$("#fav").click(function(){
    getMessagesData(2,"#favMessage");
    //createMessages(2,"#favMessage");
    $('#messageNone').text('Sección importantes, selecciones un mensaje.');
});	

$("#trash").click(function(){
    getMessagesData(3,"#favMessage");
    $('#messageNone').text('Sección eliminados, selecciones un mensaje.');    
}); 