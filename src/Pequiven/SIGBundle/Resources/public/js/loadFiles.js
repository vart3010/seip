var urlLoadFile;

function setUrlFiles(urlFiles){
    urlLoadFile = urlFiles;  
}

//Load File
$(".messages").hide();
$('#subir').hide();

//queremos que esta variable sea global
var fileExtension = "";
//función que observa los cambios del campo file y obtiene información
$(':file').change(function()
{
    //obtenemos un array con los datos del archivo
    var file = $("#imagen")[0].files[0];
    //obtenemos el nombre del archivo
    var fileName = file.name;
    //obtenemos la extensión del archivo
    fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
    //obtenemos el tamaño del archivo
    var fileSize = file.size;
    //obtenemos el tipo de archivo image/png ejemplo
    var fileType = file.type;
    //console.log(file);
    //mensaje con la información del archivo
    showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
    if(isImage(fileExtension) == false){
        showMessage("<span class='error'>Archivo para subir debe ser formato PDF</span>");
        $('#subir').hide();                
    }else{
        $('#subir').show();
    }
});

//Enviando formulario
$(':button').click(function(){            
    var formData = [];
    var formData = new FormData($(".formulario")[0]);
    var message = ""; 

    $.ajax({
        url: urlLoadFile,  
        type: 'POST',
        // Form data                
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){
            message = $("<span class='before'>Subiendo archivo, por favor espere...</span>");
            showMessage(message)        
        },
        //una vez finalizado correctamente
        success: function(data){
            message = $("<span class='success'>El archivo ha subido correctamente.</span>");
            $('#imagen').hide();                
            $('#subir').hide();      
            showMessage(message);
            $('#fileName').val(data);                    
            if (data == 1) {
                location.reload();               
            };
        },
        //si ha ocurrido un error
        error: function(){
            message = $("<span class='error'>Ha ocurrido un error.</span>");
            showMessage(message);
        }
    });
});

function showMessage(message){
        $(".messages").html("").show();
        $(".messages").html(message);
    }
     
    function isImage(extension)
    {
        switch(extension.toLowerCase()) 
        {   
            case 'jpg': case 'gif': case 'png': case 'jpeg':                
                return false;
            break;
            case 'html': case 'xls': case 'xlsx': case 'sql':
                return false;
            break;
            case 'pdf':                
                return true;
            break;
            default:                
                return true;
            break;
        }
    }  