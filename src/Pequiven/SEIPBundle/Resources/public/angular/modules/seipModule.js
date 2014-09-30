'use strict';

// Declare app level module which depends on filters, and services
var seipModule = angular.module('seipModule', [
    'ngRoute',
    'seipModule.controllers',
    'notificationBarModule'
]);
function confirm(){
    
}
//Establece el valor de un select2
function setValueSelect2(idSelect2,idEntity,data){
    var selected = null;
    var i = 0,j=0;
    angular.forEach(data,function(val,i){
        if(val != undefined){
            if(val.id == idEntity){
                selected = val;
                j = i;
            }
        }
        i++;
    });
    $("#"+idSelect2).select2("val",j);
}


angular.module('seipModule.controllers', [])
    .controller("ArrangementProgramController",function($scope,notificationBarService,$http){
        $scope.data = {
            responsible_goals: null,
            type_goals: null
        };
        //Inicializar modelo de meta
        $scope.initModelGoal = function(goal){
            $scope.model = {
                goal: {
                    name: null,
                    type_goal: null,
                    start_date: null,
                    end_date: null,
                    responsible: null,
                    weight: null,
                    observations: null
                }
            };
            $("#goalForms select").each(function(){
                    //$(this).select2("destroy");
                    //$(this).select2();
                    $(this).select2("val","");
                });
            if(goal){
                $scope.model.goal = goal;
                
                setValueSelect2("goal_typeGoal",goal.type_goal.id,$scope.data.type_goals);
                setValueSelect2("goal_responsible",goal.responsible.id,$scope.data.responsible_goals);
            }
        };
        //Metas
        $scope.goals = [];
        $scope.initModelGoal();
        $scope.addGoal = function(){
            var valid = $('#goalForms').validationEngine('validate');
            if(valid){
                $scope.goals.push($scope.model.goal);
                $scope.initModelGoal();
            }
            return valid;
        };
        $scope.initGoalCallBack = function(){
            $http.get(Routing.generate("pequiven_arrangementprogram_data_responsible_goals")).success(function(data){
                $scope.data.responsible_goals = data;
            });
            $http.get(Routing.generate("pequiven_arrangementprogram_data_type_goal")).success(function(data){
                $scope.data.type_goals = data;
            });
        };
        
        //Funcion que carga el template de la meta
        $scope.loadTemplateMeta = function(goal){
            $scope.templateOptions.setTemplate($scope.templates[0]);
            $scope.templateOptions.setParameterCallBack(goal);
            if(goal){
                $scope.templateOptions.enableModeEdit();
                $scope.openModalAuto(true);
            }else{
                $scope.openModalAuto(false);
            }
        };
        
        //Setea la dta del formulario
        $scope.setDataFormGoal = function(goal){
            $scope.initModelGoal(goal);
        };
        
        $scope.removeGoal = function(goal){
            $scope.goals.remove(goal);
        };
        
        var urlGoal = Routing.generate("goal_get_form",{},true);
        $scope.templates = [
            {
                name: 'pequiven.modal.title.goal',
                url:urlGoal,
                confirmCallBack: $scope.addGoal,
                initCallBack: $scope.initGoalCallBack,
                loadCallBack: $scope.setDataFormGoal
            }
        ];
        console.log("ArrangementProgramController");
    })
    .controller("MainContentController",function($scope,notificationBarService,sfTranslator){
        $scope.model = {};
        //Funcion para remover un elemento de un array
        Array.prototype.remove = function(value){
            var idx = this.indexOf(value);
            if(idx != -1){
                return this.splice(idx,1);
            }
            return false;
        };
        
        $scope.template = {
            name: null,
            url: null,
            load: false,
            confirmCallBack: null,
            parameterCallBack: null,
            loadCallBack: null,
            initCallBack: null,
            modeEdit: false
        };
        $scope.templateOptions = {};
        $scope.templateOptions.setConfirmCallBack = function(callBack){
            $scope.template.confirmCallBack = callBack;
        };
        $scope.templateOptions.enableModeEdit = function(){
            $scope.template.modeEdit = true;
        };
        $scope.templateOptions.setParameterCallBack = function(parameterCallBack){
            $scope.template.parameterCallBack = parameterCallBack;
        };
        $scope.templateOptions.setUrl = function(callBack){
            $scope.template.url = callBack;
        };
        $scope.templateOptions.setTemplate = function(template){
            $scope.template = template;
        };

        var modalOpen;
        jQuery(document).ready(function() {
            var angular = jQuery( "#dialog-form" );
            if(angular){
            modalOpen = angular.dialog({
                autoOpen: false,
                        height: 650,
                        width: 800,
                        modal: true,
                buttons: {
                  "Add": confirm,
                  Cancel: function() {
                    modalOpen.dialog( "close" );
                  }
                },
                close: function() {
                  //form[ 0 ].reset();
                  //allFields.removeClass( "ui-state-error" );
                }
          });
            }
        });
        
        $scope.templateLoad = function(template){
          template.load = true;
          if(template.initCallBack){
             template.initCallBack(); 
          }
          return openModal();
        };
        
        $scope.openModalAuto = function (){
            notificationBarService.getLoadStatus().loading();
            if($scope.template.load == true){
                openModal();
            }
        };
        
        function openModal(){
                if($scope.template.name){
                    modalOpen.dialog( "option", "title", sfTranslator.trans($scope.template.name));
                }
                
                if($scope.template.modeEdit){
                    $scope.template.modeEdit = false;
                    // setter
                    modalOpen.dialog( "option", "buttons", [ 
                        { text: "Guardar", click: function(){
                                $scope.$apply();
                                modalOpen.dialog( "close" );
                        } },
                        { text: "Cancelar", click: function() {
                                modalOpen.dialog( "close" );
                            } 
                        }
                    ] );
                }else{
                    // setter
                    modalOpen.dialog( "option", "buttons", [ 
                        { text: "Añadir", click: function(){
                                //console.log($scope.template.confirmCallBack);
                                if($scope.template.confirmCallBack){
                                    if($scope.template.confirmCallBack()){
                                        modalOpen.dialog( "close" );
                                        $scope.$apply();
                                    }
                                }else{
                                    modalOpen.dialog( "close" );
                                }
                        } },
                        { text: "Cancelar", click: function() {
                                modalOpen.dialog( "close" );
                            } 
                        }
                    ] );
                }
                
            modalOpen.dialog( "open" );
            if($scope.template.loadCallBack){
               $scope.template.loadCallBack($scope.template.parameterCallBack); 
            }
            $scope.template.parameterCallBack = null;
            
            notificationBarService.getLoadStatus().done();
        }
    })
    
    .controller('TableObjetiveStrategicController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {
//        $scope.tableParams.$params.groupBy = 'line_strategics[0].description';
//        console.log($scope.tableParams.$params.groupBy);
//        console.log($scope.tableParams);
//        console.log($scope.tableParams.settings().pages);
    })
    .controller('TableObjetiveTacticController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {
        $scope.gerenciaFirst = null;
        $scope.$watch("gerenciaFirst", function () {
            if($scope.gerenciaFirst != null && $scope.gerenciaFirst != undefined)
            {
                 $scope.tableParams.$params.filter['gerencia'] = $scope.gerenciaFirst;
            }else{
                 $scope.tableParams.$params.filter['gerencia'] = null;
            }
        });
    })
    .controller('TableObjetiveOperativeController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {

    })
    .controller('TableIndicatorStrategicController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {

    })
    .controller('TableIndicatorTacticController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {

    })
    .controller('TableIndicatorOperativeController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {

    })
    ;        