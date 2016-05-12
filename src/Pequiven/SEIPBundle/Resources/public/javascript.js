var ajaxFormaterSelect2 = function(response){
    return response.text;
};

var ajaxToSelect = {
    formaterData: ajaxFormaterSelect2,
    addEmptyValue: true
};
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
    if(ajaxToSelect.addEmptyValue === true){
        select.append('<option value=""></option>');
    }
    $.each(data,function(index,value){
        var response = {
            id: value.id,
            text: value.name
        };
        //myData.push(response);
        select.append('<option value="' + response.id + '">' + ajaxToSelect.formaterData(value) + '</option>');
    });
    if(data.length > 0){
        select.select2('enable');
        select.select2("val",null);
    }else{
        select.select2('disable');
    }
};

var myNumberFormat = function(numberToFormat,limit){
    if(limit == undefined){
        var limit = 2;
    }
    var numberFormat = $.number(numberToFormat, limit, ',', '.');
    return numberFormat;
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

//Tabs
$(document).ready(function(){
    $(this).find('div.standard-tabs').parent('div')
    .prepend('<div class="tabs-arrows" style="font-size: 1.543em; margin-top: -16px; height: 16px;"><a class="move-tab" href="#!" style="float: left;">&#65513;</a><a class="move-tab" href="#!" style="float: right;">&#65515;</a></div>')
    .on('click', 'a.move-tab', function(e){
        var tabsWidth = 0;
        $('ul.tabs li').each(function(index) {
            tabsWidth += parseInt($(this).width(), 10);
        });
        var act_tab = $(document).find('ul.tabs li.active'),
            mov_tab = tabsWidth > $('div.standard-tabs').innerWidth();
        switch($(this).css('float')){
            case 'left':
                if(act_tab.prev().length){
                    if(mov_tab){
                        act_tab.next().next().css('display','none');
                        act_tab.prev().prev().css('display','inherit');
                    } act_tab = act_tab.prev()
                }
                break;
            case 'right':
                if(act_tab.next().length){
                    if(mov_tab){
                        act_tab.prev().prev().css('display','none');
                        act_tab.next().next().css('display','inherit');
                    } act_tab = act_tab.next()
                }
                break;
        } $('a[href="'+act_tab.children('a').attr('href')+'"]').click();
    });
});