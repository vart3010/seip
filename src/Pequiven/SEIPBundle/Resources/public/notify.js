function reload(){
    location.reload();
}

$(document).ready(function() {
    $('#notifyAll').text("0");
	$('#notifyFav').text("0");
	$('#notifyTrash').text("0");
	//alert($("#notify").text());
});

function showMessage(id){			
	var data = {
        idMessage: id,                    
    };            
	$.ajax({
            type: 'get',
            url: '{{ path("seip_notification_view_message") }}',
            data: data,
            beforeSend:function(objeto){
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
            url: '{{ path("seip_notification_delete_message") }}',
            data: data, 
            beforeSend:function(objeto){
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

	/*$.ajax({
            type: 'get',
            url: '{{ path("seip_notification_favourite_message") }}',
            data: data, 
            beforeSend:function(objeto){
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
    });*/
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