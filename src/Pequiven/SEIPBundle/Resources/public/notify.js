var urlData;
var urlMessage;
var urlMessageDelete;
var urlFavMessage;

$("#reload").click(function(){
    console.log('reload');
    //getData();
    /*$.ajax({
        url: "",
        context: document.body,
        success: function(s,x){
            $(this).html(s);
        }
    });*/
    $('#notifyAll').load();
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

function setUrlMessage(urlGetMessage){
    urlMessage = urlGetMessage;
}

function setUrlMessageDelete(urlGetMessageDelete){
    urlMessageDelete = urlGetMessageDelete;
}

function setUrlMessageFav(urlFav){
    urlFavMessage = urlFav;
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
                document.getElementById("messageNone").innerHTML = data['description'];
                //document.getElementById("messageNone").innerHTML = "<a href=\"{{ path('pequiven_sig_monitoring_show',{'id': 1 })}}\">Ver</a>";
                var path = data['path'];
                //console.log(path);
                document.getElementById("href").innerHTML = "<a href='{{ path('pequiven_sig_monitoring_show',{'id': 1 })}}' class='button red-gradient float-right with-tooltip' title='Visualizar'>Visualizar</a>";
                document.getElementById("sectionButton").innerHTML = '<a href class="button" title="Eliminar" onclick="deleteMessage('+id+');"><span class="icon-trash"></span></a><a href class="button" title="Marcar como Importante" onclick="favouriteMessage('+id+');"><span class="icon-flag"></span></a>';                                                
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
                document.getElementById("messageNone").innerHTML = '<i class="fa fa-check"></i> Notificación Eliminada Satisfactoriamente';
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
                document.getElementById("messageNone").innerHTML = '<i class="fa fa-check"></i> Notificación enviada a Importantes';
            }
    });
}   

$("#notify").click(function(){
    console.log('Notify');
}); 

$("#fav").click(function(){
    console.log('Favoritos');
});	

$("#trash").click(function(){
    console.log('Trash');
}); 