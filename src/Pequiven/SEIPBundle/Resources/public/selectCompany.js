function loadMapa(envi){
$("#dialog").dialog({
    autoOpen: false,
    show: {
        //effect: "blind",
        duration: 800
    },
    hide: {
        effect: "explode",
        duration: 800
    },
    width: 615,
    height: 350,
});

var default_attributes = {
    fill: '#C6D5DA',
    stroke: 'white',
    'stroke-width': '2'
};

var capital = {
    fill: '#00FFFF',
    stroke: 'white',
    'stroke-width': '2',
    opacity:0.8,
    cursor: 'pointer',
};

var central = {
    fill: '#ff9999',
    stroke: 'white',
    'stroke-width': '2',
    cursor: 'pointer',
};

var occidental = {
    fill: '#ff6666',
    stroke: 'white',
    'stroke-width': '2',
    cursor: 'pointer',
};

var zuliana = {
    fill: '#00CED1',
    stroke: 'white',
    'stroke-width': '2',
    opacity:0.5,
    cursor: 'pointer',
};

var andina = {
    fill: '#ffe6e6',
    stroke: 'white',
    'stroke-width': '2',
//    cursor: 'pointer',
};

var oriental = {
    fill: '#ffcccc',
    stroke: 'white',
    'stroke-width': '2',
    cursor: 'pointer',
};

var guayana = {
    fill: '#ffe6e6',
    stroke: 'white',
    'stroke-width': '2',
//    cursor: 'pointer',
};

var insular = {
    fill: '#ffe6e6',
    stroke: 'white',
    'stroke-width': '2',
//    cursor: 'pointer',
};

var llanera = {
    fill: '#ffe6e6',
    stroke: 'white',
    'stroke-width': '2',
//    cursor: 'pointer',
};

$.ajax({
    url: '../bundles/pequivenseip/imgSelectCompany/vzla2.svg',
    type: 'GET',
    dataType: 'xml',
    success: function (xml) {
        var rjs = Raphael('mapa');
        rjs.setViewBox(0, 0, 800, 780, true);
        rjs.setSize('100%', '100%');

        $(xml).find('svg > g > g > path').each(function () {
            var path = $(this).attr('d');
            var pid = $(this).attr('id');
            var region = $(this).attr('class');
            var munic = rjs.path(path);
            munic.attr(default_attributes);
            /*
            switch (region) {
                case 'capital':
                    munic.attr(capital);
                    break;
                case 'central':
                    munic.attr(central);
                    break;
                case 'occidental':
                    munic.attr(occidental);
                    break;
                case 'zuliana':
                    munic.attr(zuliana);
                    break;
                case 'andina':
                    munic.attr(andina);
                    break;
                case 'oriental':
                    munic.attr(oriental);
                    break;
                case 'llanos':
                    munic.attr(llanera);
                    break;
                case 'guayana':
                    munic.attr(guayana);
                    break;
                case 'insular':
                    munic.attr(insular);
                    break;
                default:
                    munic.attr(default_attributes);
            }*/
            
            munic.hover(function () {
                this.animate({fill: '#87CEFA'});
            }, function () {
                this.animate({fill: default_attributes.fill, opacity: '1'});
                /*
                    switch (region) {
                        case 'capital':
                            this.animate({fill: capital.fill, opacity: '1'});
                            break;
                        case 'central':
                            this.animate({fill: central.fill, opacity: '1'});
                            break;
                        case 'occidental':
                            this.animate({fill: occidental.fill, opacity: '1'});
                            break;
                        case 'zuliana':
                            this.animate({fill: zuliana.fill, opacity: '1'});
                            break;
                        case 'andina':
                            this.animate({fill: andina.fill, opacity: '1'});
                            break;
                        case 'oriental':
                            this.animate({fill: oriental.fill, opacity: '1'});
                            break;
                        case 'llanos':
                            this.animate({fill: llanera.fill, opacity: '1'});
                            break;
                        case 'guayana':
                            this.animate({fill: guayana.fill, opacity: '1'});
                            break;
                        case 'insular':
                            this.animate({fill: insular.fill, opacity: '1'});
                            break;
                        default:
                            this.animate({fill: default_attributes.fill, opacity: '1'});
                        }*/                
            }).click(function () {
                //var urlAjax = '../app.php/selectCompanyC';
                 var urlAjax='';
                 var company_link='';
                 
                    if(envi == 'dev'){
                        urlAjax = '../app_dev.php/selectCompanyC';
                        company_link = '../app_dev.php/';
                    }
                    else{
                        urlAjax = '../app.php/selectCompanyC';
                        company_link = '../app.php/';
                    }
                    $.get(urlAjax, function (data, status) {
//                        $("#dialog").dialog("close");
                        var data = $.parseJSON(data);
                        var cont = '';
                        for (var i = 0; i < data.companies.length; i++) {
                            if (data.companies[i].enabled != 0) {
                                if (data.companies[i].ubicacion == "-1" && data.companies[i].alias == "PEQUIVEN" && (region == "oriental" || region == "central" || region == "occidental" || region == "capital")) {
                                    cont += '<div class="contentLogoCompany button contentLc"><a href="' + company_link + '"><div class=""><img class="logoCompany" src="' + data.companies[i].base64image + '"/></div><div class="button red-gradient glossy contentAlias"><p class="companyName title-icon-strategic" style="font-size: 13px; font-weight: bold;">' + data.companies[i].alias + '</p></div></a></div>';
                                    $("#dialog").html(cont);
                                    $("#dialog").dialog({title: "Región" + " " + region}).dialog("open");
                                }
                                if (data.companies[i].ubicacion == region) {
                                    cont += '<div class="contentLogoCompany button disabled contentLc"><a href="#"><div class=""><img class="logoCompany" src="' + data.companies[i].base64image + '"/></div><div class="button red-gradient glossy contentAlias"><p class="companyName">' + data.companies[i].alias + '</p></div></a></div>';
                                    $("#dialog").html(cont);
                                    $("#dialog").dialog({title: "Región" + " " + region}).dialog("open");
                                    //$("#divDatos").append(div);
                                }
                            }
                        }//for
                        /*if (data.companies[0].enabled != 0) {
                            if (data.companies[0].ubicacion == "-1" && data.companies[0].alias == "PEQUIVEN" && (region == "oriental" || region == "central" || region == "occidental" || region == "capital")) {
                                cont += '<div class="contentLogoCompany"><a href="' + company_link + '"><div class="companySelected"><img class="logoCompany" src="' + data.companies[0].base64image + '"/></div><p class="companyName">' + data.companies[0].alias + '</p></a></div>';
                                $("#dialog").html(cont);
                                $("#dialog").dialog({title: "Región" + " " + region}).dialog("open");
                            }
                        }*/
                    });
                });
                $("#mensaje").animate({left: '61%'},3000);
            });
        }
    });
}
