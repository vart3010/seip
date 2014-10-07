'use strict';

// Declare app level module which depends on filters, and services
var seipModule = angular.module('seipModule', [
    'ngRoute',
    'seipModule.controllers',
    'notificationBarModule',
    'ngCookies'
]);
function confirm(){
    
}
//Establece el valor de un select2
function setValueSelect2(idSelect2,idEntity,data,callBack){
    var selected = null;
    var i = 0,j=null;
    angular.forEach(data,function(val,i){
        if(val != undefined){
            if(val.id == idEntity){
                selected = val;
                j = i;
            }
        }
        i++;
    });
//    console.log(idSelect2);
//    console.log(idEntity);
//    console.log(j);
//    $("#"+idSelect2).select2("destroy");
//    $("#"+idSelect2).val(j);
//    $("#"+idSelect2).select2();
    $("#"+idSelect2).select2('val',j);
    if(callBack){
        callBack(data[j]);
    }
//    $("#"+idSelect2).trigger("select2-selecting");
}


angular.module('seipModule.controllers', [])
    .controller("ArrangementProgramController",function($scope,notificationBarService,$http,$filter){
        $scope.data.responsibleGoals = null;
        $scope.data.typeGoals = null;
        $scope.data.operationalObjectives = null;
        
        $scope.model.arrangementProgram = {
            categoryArrangementProgram: null
        };
        //Inicializar modelo de meta
        $scope.initModelGoal = function(goal){
            $scope.model.goal = {
                    name: null,
                    typeGoal: null,
                    startDate: null,
                    endDate: null,
                    responsible: null,
                    weight: null,
                    observations: null
                };
            $("#goalForms select").each(function(){
                $(this).select2("val","");
            });
            if(goal){
                $scope.model.goal = goal;
                $scope.model.goal.startDate = $filter('myDate')(goal.startDate);
                $scope.model.goal.endDate = $filter('myDate')(goal.endDate);
                var setTypeGoalCall = function(selected){
                    $scope.model.goal.typeGoal = selected;
                };
                if(goal.typeGoal != undefined && goal.typeGoal.id != undefined){
                    setValueSelect2("goal_typeGoal",goal.typeGoal.id,$scope.data.typeGoals,setTypeGoalCall);
                }else{
                    setValueSelect2("goal_typeGoal",null,$scope.data.typeGoals,setTypeGoalCall);
                }
                if(goal.responsible != undefined && goal.responsible.id != undefined){
                    setValueSelect2("goal_responsible",goal.responsible.id,$scope.data.responsibleGoals,function(selected){
                        $scope.model.goal.responsible = selected;
                    });
                }
//                $scope.$apply();
            }
        };
        //Metas
        $scope.goals = [];
        $scope.initModelGoal();
        $scope.addGoal = function(){
            var valid = $scope.validFormTypeGoal();
            if(valid){
                if(!$scope.goals.contains($scope.model.goal)){
                    $scope.goals.push($scope.model.goal);
                    $scope.initModelGoal();
                }
            }
            return valid;
        };
        $scope.validFormTypeGoal = function(){
            var valid = $('#goalForms').validationEngine('validate');
            if(valid){
                if($scope.model.goal.responsible == undefined){
                    jQuery('#goal_responsible').validationEngine('showPrompt', 'seip.validators.rasadasdasesponsive', 'error') 
                    valid = false;
                }
            }
            return valid;
        };
        $scope.cancelEditGoal = function(){
            return $scope.validFormTypeGoal();
        };
        $scope.init = function(){
            notificationBarService.getLoadStatus().loading();
            $http.get(Routing.generate("pequiven_arrangementprogram_data_responsible_goals")).success(function(data){
                $scope.data.responsibleGoals = data;
                notificationBarService.getLoadStatus().done();
            });
        };
        
        //Funcion que carga el template de la meta
        $scope.loadTemplateMeta = function(goal){
            $scope.templateOptions.setTemplate($scope.templates[0]);
            $scope.templateOptions.setParameterCallBack(goal);
            if(goal){
                $scope.templateOptions.enableModeEdit();
                $scope.openModalAuto();
            }else{
                $scope.openModalAuto();
            }
        };
        
        //Setea la dta del formulario
        $scope.setDataFormGoal = function(goal){
            $scope.initModelGoal(goal);
        };
        
        $scope.removeGoal = function(goal){
            $scope.openModalConfirm('pequiven.modal.confirm.goal.delete_this_goal',function(){
                $scope.goals.remove(goal);
            });
        };
        
        $scope.getTypeGoal = function(c){
            notificationBarService.getLoadStatus().loading();
            $http.get(Routing.generate("pequiven_arrangementprogram_data_type_goal",{category : c})).success(function(data){
                $scope.data.typeGoals = data;
                notificationBarService.getLoadStatus().done();
            });
        };
        
        $scope.init();
        
        var urlGoal = Routing.generate("goal_get_form",{},true);
        var initCallBack = function(){
            return false;
        };
        
        $scope.setOperationalObjective = function(tacticalObjetive,selected){
            var operationalObjective = angular.element('#arrangementprogram_operationalObjective');
            if(tacticalObjetive){
                notificationBarService.getLoadStatus().loading();
                $http.get(Routing.generate("pequiven_arrangementprogram_data_operational_objectives",{idObjetiveTactical : tacticalObjetive})).success(function(data){
                    var dataIndex = [];
                    angular.forEach(data,function(value){
                        dataIndex[value.id] = value;
                    });
                    $scope.data.operationalObjectives = dataIndex;
                    operationalObjective.select2('enable',true);
                    notificationBarService.getLoadStatus().done();
                });
            }else{
                $scope.data.operationalObjectives = null;
                $scope.model.arrangementProgram.tacticalObjective = null;
                operationalObjective.select2('val','');
                operationalObjective.select2('enable',false);
            }
        };
        var tacticalObjective = angular.element('#arrangementprogram_tacticalObjective');
        var operationalObjective = angular.element('#arrangementprogram_operationalObjective');
        tacticalObjective.on('change',function(e){
            
            console.log(e.val);
            if(e.val){
                var tacticalObjetive = e.val;
//                selectObjetiveStrategic.remove();
                notificationBarService.getLoadStatus().loading();
                $http.get(Routing.generate("pequiven_arrangementprogram_data_operational_objectives",{idObjetiveTactical : tacticalObjetive})).success(function(data){
                    angular.forEach(data,function(value){
                        
                    });
                    operationalObjective.select2('val',e.val);
                    operationalObjective.select2('enable',true);
                });
            }else{
                operationalObjective.select2('val','');
                operationalObjective.select2('enable',false);
            }
        });
        
        $scope.submitForm = function(){
            console.log("submitForm");
            //var operationalObjective = angular.element('#arrangementprogram_operationalObjective');
//            setValueSelect2("arrangementprogram_operationalObjective",$scope.model.arrangementProgram.operationalObjective.id,$scope.data.operationalObjectives);
        };
        $scope.templates = [
            {
                name: 'pequiven.modal.title.goal',
                url:urlGoal,
                confirmCallBack: $scope.addGoal,
                cancelCallBack: $scope.cancelEditGoal,
                loadCallBack: $scope.setDataFormGoal,
                initCallBack: initCallBack
            }
        ];
        $scope.templateOptions.setTemplate($scope.templates[0]);
    })
    .controller("MainContentController",function($scope,notificationBarService,sfTranslator,$timeout){
        $scope.model = {};
        $scope.data = {};
        $scope.dialog = {
            confirm: {
                title: sfTranslator.trans("pequiven.dialog.confirm")
            }
        };
        $scope.setValueSelect2 = setValueSelect2;
        //Funcion para remover un elemento de un array
        Array.prototype.remove = function(value){
            var idx = this.indexOf(value);
            if(idx != -1){
                return this.splice(idx,1);
            }
            return false;
        };
        //Verifica si existe un elemento en un array
        Array.prototype.contains = function(value){
            var idx = this.indexOf(value);
            if(idx != -1){
                return true
            }
            return false;
        };
        
        $scope.template = {
            name: null,
            url: null,
            load: false,
            confirmCallBack: null,
            cancelCallBack: null,
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

        var modalOpen,modalConfirm;
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
            modalConfirm = $( "#dialog-confirm" ).dialog({
                autoOpen: false,
                resizable: false,
                height:200,
                modal: true,
                buttons: {
                  Si: function() {
                    $( this ).dialog( "close" );
                  },
                  No: function() {
                    $( this ).dialog( "close" );
                  }
                }
              });
        });
        
        $scope.templateLoad = function(template){
          template.load = true;
          if(template.initCallBack){
             if(template.initCallBack()){
                return openModal();
             }
          }else{
              return openModal();
          }
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
                                if($scope.template.confirmCallBack){
                                    if($scope.template.confirmCallBack()){
                                        modalOpen.dialog( "close" );
                                    }
                                }else{
                                    modalOpen.dialog( "close" );
                                }
                        } },
                        { text: "Cancelar", click: function() {
                                if($scope.template.cancelCallBack){
                                    if($scope.template.cancelCallBack()){
                                        modalOpen.dialog( "close" );
                                    }
                                }else{
                                    modalOpen.dialog( "close" );
                                }
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
        
        $scope.openModalConfirm = function(content,confirmCallBack,cancelCallBack){
                $scope.dialog.confirm.content = sfTranslator.trans(content);
                
                // setter
                modalConfirm.dialog( "option", "buttons", [ 
                    { text: "Si", click: function(){
                            if(confirmCallBack){
                                confirmCallBack();
                                modalConfirm.dialog( "close" );
                                $scope.$apply();
                            }else{
                                modalConfirm.dialog( "close" );
                            }
                    } },
                    { text: "No", click: function() {
                            if(cancelCallBack){
                                cancelCallBack();
                            }
                            modalConfirm.dialog( "close" );
                        } 
                    }
                ] );
                
            modalConfirm.dialog( "open" );
            notificationBarService.getLoadStatus().done();
        };
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
        $scope.gerenciaSecond = null;
        $scope.$watch("gerenciaSecond", function () {
            if($scope.gerenciaSecond != null && $scope.gerenciaSecond != undefined)
            {
                 $scope.tableParams.$params.filter['gerenciaSecond'] = $scope.gerenciaSecond;
            }else{
                 $scope.tableParams.$params.filter['gerenciaSecond'] = null;
            }
        });
    })
    .controller('TableIndicatorStrategicController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {

    })
    .controller('TableIndicatorTacticController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {

    })
    .controller('TableIndicatorOperativeController', function($scope, ngTableParams, $http,sfTranslator,notifyService) {

    })
    ;        