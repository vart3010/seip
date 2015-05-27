var ajaxToSelect2 = function(url,selectDestination,parameters){
    selectDestination.empty();
    selectDestination.select2('disable');
    selectDestination.select2("val",null);
    $.ajax({
        url: url,
        data: parameters,
        success: function(data){
            setDataSelect2(selectDestination,data);
        }
    });
};

var setDataSelect2 = function(select,data,callData){
    //var myData = [];
    select.empty();
    select.append('<option value=""></option>');
    $.each(data,function(index,value){
        var response = {
            id: value.id,
            text: value.name
        };
        //myData.push(response);
        select.append('<option value="' + response.id + '">' + response.text + '</option>');
    });
    if(data.length > 0){
        select.select2('enable');
        select.select2("val",null);
    }else{
        select.select2('disable');
    }
};

$(function() {
        $('a.showPopup').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var horizontalPadding = 10;
            var verticalPadding = 10;
            var width = 1200;
            var heigth = 600;
            $('<iframe id="site" src="' + this.href + '" style="padding:0"/>').dialog({
                title: ($this.attr('title')) ? $this.attr('title') : 'Site',
                autoOpen: true,
                width: width,
                height: heigth,
                modal: true,
                resizable: true,
                autoResize: true,
                overlay: {
                    opacity: 0.5,
                    background: "black"
                }
            }).width(width - horizontalPadding).height(heigth - verticalPadding);
        });
});