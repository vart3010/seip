'use strict';

// Declare app level module which depends on filters, and services
var seipModule = angular.module('seipModule', [
    'ngRoute',
    'seipModule.controllers',
    'notificationBarModule'
]);
function confirm(){
    
}


angular.module('seipModule.controllers', [])
    .controller("ArrangementProgramController",function($scope,notificationBarService,$http){
        $scope.data = {
            responsible_goals: null,
            type_goal: null
        };
        //Inicializar modelo de meta
        $scope.initModelGoal = function(){
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
            console.log(valid);
            return valid;
        };
        $scope.initGoalCallBack = function(){
            $http.get(Routing.generate("pequiven_arrangementprogram_data_responsible_goals")).success(function(data){
                $scope.data.responsible_goals = data;
                console.log(data);
            });
            $http.get(Routing.generate("pequiven_arrangementprogram_data_type_goal")).success(function(data){
                $scope.data.type_goal = data;
                console.log(data);
            });
            console.log("initGoalCallBack");
        };
        
        //Funcion que carga el template de la meta
        $scope.loadTemplateMeta = function(){
            $scope.templateOptions.setTemplate($scope.templates[0]);
            $scope.openModalAuto();
        };
        
        var urlGoal = Routing.generate("goal_get_form",{},true);
        $scope.templates = [
            {
                name: 'goalForm',
                url:urlGoal,
                confirmCallBack: $scope.addGoal,
                initCallBack: $scope.initGoalCallBack,
            }
        ];
        
    })
    .controller("MainContentController",function($scope,notificationBarService){
        $scope.template = {
            url: null,
            load: false,
            confirmCallBack: null,
            loadCallBack: null,
            initCallBack: null
        };
        $scope.templateOptions = {};
        $scope.templateOptions.setConfirmCallBack = function(callBack){
            $scope.template.confirmCallBack = callBack;
        };
        $scope.templateOptions.setUrl = function(callBack){
            $scope.template.url = callBack;
        };
        $scope.templateOptions.setTemplate = function(template){
            $scope.template = template;
        };

        var modalOpen;
        jQuery(document).ready(function() {
            modalOpen = angular.element( "#dialog-form" ).dialog({
                autoOpen: false,
                        height: 800,
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
        });
        
        $scope.templateLoad = function(template,reload){
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
            modalOpen.dialog( "open" );
            if($scope.template.loadCallBack){
               $scope.template.loadCallBack(); 
            }
            
            notificationBarService.getLoadStatus().done();
        }
    })
    ;