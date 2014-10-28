'use strict';

// Declare app level module which depends on filters, and services
var seipModule = angular.module('seipModule', [
    'ngRoute',
    'seipModule.controllers',
    'notificationBarModule',
    'ngCookies'
]);

seipModule
        .filter('myNumberFormat', function() {
            return function(numberToFormat) {
                var numberFormat = $.number(numberToFormat, 2, ',', '.');
                return numberFormat;
            };
        });

function confirm() {

}

function getMappingModel(data,idEntity){
//    console.log("getMappingModel");
    //console.log(idEntity);
    var selected = null;
    angular.forEach(data,function(val,i){
        if(val != undefined){
            if(val.id == idEntity){
                selected = val;
            }
        }
    });
    return selected;
}

//Establece el valor de un select2
function setValueSelect2(idSelect2, idEntity, data, callBack) {
    var selected = null;
    var i = 0, j = null;
    angular.forEach(data, function(val, i) {
        if (val != undefined) {
            if (val.id == idEntity) {
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
    $("#" + idSelect2).select2('val', j);
    if (callBack) {
        callBack(data[j]);
    }
//    $("#"+idSelect2).trigger("select2-selecting");
}
function setValueSelect2Multiple(idSelect2, entities, data, callBack) {
    var selected = [];
    var selectedIds = [];
    var i = 0, j = null;
    angular.forEach(data, function(val, i) {
        if (val != undefined) {
            angular.forEach(entities, function(entity) {
                if (val.id == entity.id) {
                    selected.push(val);
                    selectedIds.push(i);
                }
            });
        }
        i++;
    });
    $("#" + idSelect2).select2('val', selectedIds);
    if (callBack) {
        callBack(selected);
    }
}


angular.module('seipModule.controllers', [])
        .controller("ArrangementProgramController", function($scope, notificationBarService, $http, $filter, $timeout, $cookies) {
            $scope.data.responsibleGoals = null;
            $scope.data.typeGoals = null;
            $scope.data.operationalObjectives = null;
        $scope.model.goalCount = null;

            $scope.model.arrangementProgram = {
                categoryArrangementProgram: null
            };
            //Inicializar modelo de meta
            $scope.initModelGoal = function(goal) {
                $scope.model.goal = {
                    name: null,
                    typeGoal: null,
                    startDate: null,
                    endDate: null,
                    responsibles: null,
                    weight: null,
                    observations: null
                };
                $("#goalForms select").each(function() {
                    $(this).select2("val", "");
                });
                if (goal) {
                    $scope.model.goal = goal;
                    $scope.model.goal.startDate = $filter('myDate')(goal.startDate);
                    $scope.model.goal.endDate = $filter('myDate')(goal.endDate);
                    var setTypeGoalCall = function(selected) {
                        $scope.model.goal.typeGoal = selected;
                    };
                    if (goal.typeGoal != undefined && goal.typeGoal.id != undefined) {
                        setValueSelect2("goal_typeGoal", goal.typeGoal.id, $scope.data.typeGoals, setTypeGoalCall);
                    } else {
                        setValueSelect2("goal_typeGoal", null, $scope.data.typeGoals, setTypeGoalCall);
                    }
                    if (goal.responsibles != undefined) {
                        setValueSelect2Multiple("goal_responsibles", goal.responsibles, $scope.data.responsibleGoals, function(selected) {
                            $scope.model.goal.responsibles = selected;
                        });
                    }
//                $scope.$apply();
                }
            };
            //Metas
            $scope.goals = [];
            $scope.initModelGoal();
            $scope.addGoal = function() {
                var valid = $scope.validFormTypeGoal();
                if (valid) {
                    if (!$scope.goals.contains($scope.model.goal)) {
                        $scope.goals.push($scope.model.goal);
                        $scope.initModelGoal();
                    }
                }
                return valid;
            };

            $scope.validFormTypeGoal = function() {
                var valid = $('#goalForms').validationEngine('validate');
                if (valid) {
                    if ($scope.model.goal.responsibles == undefined) {
                        $scope.sendMessageError('pequiven.validators.arrangement_program.select_responsible_person', 's2id_goal_responsibles');
                        valid = false;
                    }
                }
                return valid;
            };
            $scope.cancelEditGoal = function() {
                return $scope.validFormTypeGoal();
            };


            //Funcion que carga el template de la meta
        $scope.loadTemplateMeta = function(goal,index){
            $scope.model.goalCount = index;
                var responsibles = programResponsible.val();
                if ($scope.model.arrangementProgram.categoryArrangementProgram == null || $scope.model.arrangementProgram.categoryArrangementProgram == '') {
                    $scope.sendMessageError(null, 's2id_arrangementprogram_categoryArrangementProgram');
                    return;
                }
                if (responsibles == null) {
                    $scope.sendMessageError(null, 's2id_arrangementprogram_responsibles');
                    return;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(goal);
                if (goal) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            //Setea la dta del formulario
            $scope.setDataFormGoal = function(goal) {
                $scope.initModelGoal(goal);
            };

            $scope.removeGoal = function(goal) {
                $scope.openModalConfirm('pequiven.modal.confirm.goal.delete_this_goal', function() {
                    $scope.goals.remove(goal);
                });
            };

            $scope.getTypeGoal = function(c) {
                if (c) {
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_arrangementprogram_data_type_goal", {category: c})).success(function(data) {
                        $scope.data.typeGoals = data;
                        notificationBarService.getLoadStatus().done();
                    });
                } else {
                    $scope.data.typeGoals = null;
                }
            };

            var urlGoal = Routing.generate("goal_get_form", {}, true);
            var initCallBack = function() {
                return false;
            };

            $scope.setOperationalObjective = function(tacticalObjetive, selected) {
                var operationalObjective = angular.element('#arrangementprogram_operationalObjective');
                if (tacticalObjetive) {
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_arrangementprogram_data_operational_objectives", {idObjetiveTactical: tacticalObjetive})).success(function(data) {
                        var dataIndex = [];
                        angular.forEach(data, function(value) {
                            dataIndex[value.id] = value;
                        });
                        $scope.data.operationalObjectives = dataIndex;
                        operationalObjective.select2('enable', true);
                        notificationBarService.getLoadStatus().done();
                    });
                } else {
                    $scope.data.operationalObjectives = null;
                    $scope.model.arrangementProgram.tacticalObjective = null;
                    operationalObjective.select2('val', '');
                    operationalObjective.select2('enable', false);
                }
            };
            var tacticalObjective = angular.element('#arrangementprogram_tacticalObjective');
            var programResponsible = angular.element('#arrangementprogram_responsibles');//Responsable del programa de gestion
            var operationalObjective = angular.element('#arrangementprogram_operationalObjective');
            var loadTemplateMetaButton = angular.element('#loadTemplateMeta');
            tacticalObjective.on('change', function(e) {

                if (e.val) {
                    var tacticalObjetive = e.val;
                    operationalObjective.find('option').remove().end();
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_arrangementprogram_data_operational_objectives", {idObjetiveTactical: tacticalObjetive})).success(function(data) {
                        operationalObjective.append('<option value="">' + Translator.trans('pequiven.select') + '</option>');
                        angular.forEach(data, function(value) {
                            operationalObjective.append('<option value="' + value.id + '">' + value.ref + " " + value.description + '</option>');
                        });
                        if (data.length > 0) {
                            operationalObjective.select2('val', e.val);
                            operationalObjective.select2('enable', true);
                        } else {
                            operationalObjective.select2('val', '');
                            operationalObjective.select2('enable', false);
                        }
                        notificationBarService.getLoadStatus().done();
                    });
                } else {
                    operationalObjective.select2('val', '');
                    operationalObjective.select2('enable', false);
                }
            });
            programResponsible.on('change', function(object) {
                var reponsibleId = object.val;
                $scope.validButtomAddGoal();
                $scope.getResponsiblesGoal(reponsibleId);
            });
            $scope.validButtomAddGoal = function() {

                if (programResponsible.val() != null && programResponsible.val() > 0) {
                    loadTemplateMetaButton.removeClass('disabled');
                } else {
                    loadTemplateMetaButton.addClass('disabled');
                }
            };
            $scope.getResponsiblesGoal = function(reponsibleId) {
                if (reponsibleId == '') {
                    $scope.data.responsibleGoals = [];
                } else {
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_arrangementprogram_data_responsible_goals", {responsibles: reponsibleId})).success(function(data) {
                        $scope.data.responsibleGoals = data;
                        notificationBarService.getLoadStatus().done();
                    });
                }
            };

            $scope.formReady = false;
            var form = angular.element('form');
            form.submit(function(e) {
                var valid = true;
                //Select de responsables
                var arrangementprogramResponsible = angular.element('#arrangementprogram_responsibles');
                if (arrangementprogramResponsible) {
                    var v = arrangementprogramResponsible.val();
                    if (v == '' || v == null) {
                        $scope.sendMessageError("pequiven.validators.arrangement_program.select_responsible_person", "s2id_arrangementprogram_responsibles");
                        valid = false;
                    }
                }
            if(valid){
                    var autoOpenOnSave = angular.element('#autoOpenOnSave');
                    if ($scope.goals.length > 0) {
                        $scope.openModalConfirm(Translator.trans('pequiven.modal.confirm.arrangement_program.open_on_save'), function() {
                            autoOpenOnSave.val(1);
                            $scope.formReady = true;
                            form.submit();
                        }, function() {
                            autoOpenOnSave.val(0);
                            $scope.formReady = true;
                            form.submit();
                        });
                    } else {
                        $scope.formReady = true;
                    }
                }
                if ($scope.formReady == true) {
                    return true;
                }
                e.preventDefault();
            });

            $scope.sendMessageError = function(message, id) {
                if (message === null) {
                    message = 'pequiven.validations.blank_text';
                }
                var messageTrans = "* " + Translator.trans(message);
                if (id == undefined) {
                    id = 'message-errors';
                }
                jQuery('#' + id).validationEngine('showPrompt', messageTrans, 'error');
                $timeout(function() {
                    jQuery('#' + id).validationEngine('hide');
                }, 3000);
            };
            //Calcula el total de peso distribuido en las metas
            $scope.getTotalWeight = function(){
                var total = 0;
                angular.forEach($scope.goals,function(goal){
                    total += goal.weight;
                });
                return total;
            };

            $scope.templates = [
                {
                    name: 'pequiven.modal.title.goal',
                    url: urlGoal,
                    confirmCallBack: $scope.addGoal,
                    cancelCallBack: $scope.cancelEditGoal,
                    loadCallBack: $scope.setDataFormGoal,
                    initCallBack: initCallBack
                }
            ];
            $scope.templateOptions.setTemplate($scope.templates[0]);

            $scope.init = function() {
                if(programResponsible.val() != undefined && programResponsible.val() != ''){
                    $scope.getResponsiblesGoal(programResponsible.val());
                }
                if (operationalObjective.val() == '' || operationalObjective.val() == null) {
                    operationalObjective.select2('enable', false)
                }
                $scope.validButtomAddGoal();
            };

            $scope.init();
        })
        .controller('ReportArrangementProgramController', function($scope, $http) {
            $scope.data = {
                tacticals: null,
                operatives: null,
                first_line_managements: null,
                second_line_managements: null,
                complejos: null,
                responsibles: null,
                arrangementProgramStatusLabels: null,
                typesManagement: null
            };
            $scope.model = {
                complejo: null,
                arrangementProgramStatus: null,
                responsiblesGoals: null,
                responsibles: null,
                tacticalObjective: null,
                operationalObjective: null,
                firstLineManagement: null,
                secondLineManagement: null,
                typeManagement: null
            };

            $http.get(Routing.generate('pequiven_arrangementprogram_data_tactical_objectives'))
                    .success(function(data) {
                        $scope.data.tacticals = data;
                    });
            //objetiveTactical
            $scope.getOperatives = function(objetiveTactical){
                var parameters = {
                    filter: {}
                };
                if(objetiveTactical != undefined){
                    parameters.filter['objetiveTactical'] = objetiveTactical;
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_operatives_objectives',parameters))
                .success(function(data) {
                    $scope.data.operatives = data;
                });
            };
            $scope.getOperatives();
            
            $http.get(Routing.generate('pequiven_arrangementprogram_data_first_line_management'))
                    .success(function(data) {
                        $scope.data.first_line_managements = data;
                        if($scope.model.firstLineManagement != null){
                            $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.data.first_line_managements, function(selected) {
                                $scope.model.firstLineManagement = selected;
                            });
                        }
                    });
            //Busca las gerencias de segunda linea
            $scope.getSecondLineManagement = function(gerencia){
                var parameters = {
                    filter: {}
                };
                if($scope.model.firstLineManagement != null){
                    parameters.filter['gerencia'] = $scope.model.firstLineManagement.id;
                }
                if($scope.model.typeManagement != null){
                    parameters.filter['typeManagement'] = $scope.model.typeManagement.id;
                    parameters.filter['complejo'] = $scope.model.complejo.id;
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_second_line_management',parameters))
                    .success(function(data) {
                        $scope.data.second_line_managements = data;
                        if($scope.model.secondLineManagement != null){
                            $scope.setValueSelect2("secondLineManagement", $scope.model.secondLineManagement, $scope.data.second_line_managements, function(selected) {
                                $scope.model.secondLineManagement = selected;
                            });
                        }
                    });
            };
            $scope.getSecondLineManagement();
            $http.get(Routing.generate('pequiven_arrangementprogram_data_complejos'))
                    .success(function(data) {
                        $scope.data.complejos = data;
                
                        if($scope.model.complejo != null){
                            $scope.setValueSelect2("selectComplejos", $scope.model.complejo, $scope.data.complejos, function(selected) {
                                $scope.model.complejo = selected;
                            });
                        }
                    });
            $http.get(Routing.generate('pequiven_arrangementprogram_data_responsibles'))
                    .success(function(data) {
                        $scope.data.responsibles = data;
                    });

            $scope.$watch("model.complejo", function(newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {

                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            });
            $scope.$watch("model.arrangementProgramStatus", function(newParams, oldParams) {
                if ($scope.model.arrangementProgramStatus != null && $scope.model.arrangementProgramStatus.id != undefined) {
                    $scope.tableParams.$params.filter['status'] = $scope.model.arrangementProgramStatus.id;
                } else {
                    $scope.tableParams.$params.filter['status'] = null;
                }
            });
            $scope.$watch("model.responsibles", function(newParams, oldParams) {
                if ($scope.model.responsibles != null) {
                    var responsibles = [], i = 0;
                    angular.forEach($scope.model.responsibles, function(value) {
                        responsibles.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['responsibles'] = angular.toJson(responsibles);
                    } else {
                        $scope.tableParams.$params.filter['responsibles'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['responsibles'] = null;
                }
            });
            $scope.$watch("model.responsiblesGoals", function(newParams, oldParams) {
                if ($scope.model.responsiblesGoals != null) {
                    var responsibles = [], i = 0;
                    angular.forEach($scope.model.responsiblesGoals, function(value) {
                        responsibles.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['responsiblesGoals'] = angular.toJson(responsibles);
                    } else {
                        $scope.tableParams.$params.filter['responsiblesGoals'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['responsiblesGoals'] = null;
                }
            });
            $scope.$watch("model.tacticalObjective", function(newParams, oldParams) {
                if ($scope.model.tacticalObjective != null && $scope.model.tacticalObjective.id != undefined) {
                    $scope.tableParams.$params.filter['tacticalObjective'] = $scope.model.tacticalObjective.id;
                } else {
                    $scope.tableParams.$params.filter['tacticalObjective'] = null;
                }
            });
            $scope.$watch("model.operationalObjective", function(newParams, oldParams) {
                if ($scope.model.operationalObjective != null && $scope.model.operationalObjective.id != undefined) {
                    $scope.tableParams.$params.filter['operationalObjective'] = $scope.model.operationalObjective.id;
                } else {
                    $scope.tableParams.$params.filter['operationalObjective'] = null;
                }
            });
            $scope.$watch("model.firstLineManagement", function(newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                } else {
                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
                }
            });
            $scope.$watch("model.secondLineManagement", function(newParams, oldParams) {
                if ($scope.model.secondLineManagement != null && $scope.model.secondLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['secondLineManagement'] = $scope.model.secondLineManagement.id;
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                }
            });
            //Filtro de modular y vinculante
            $scope.$watch("model.typeManagement", function(newParams, oldParams) {
                if ($scope.model.typeManagement != null && $scope.model.typeManagement.id != undefined) {
                    $scope.tableParams.$params.filter['typeManagement'] = $scope.model.typeManagement.id;
                } else {
                    $scope.tableParams.$params.filter['typeManagement'] = null;
                }
            });
        })
        .controller("MainContentController", function($scope, notificationBarService, sfTranslator, $timeout) {

            $scope.model = {};
            $scope.form = {};
            $scope.data = {};
            $scope.dialog = {
                confirm: {
                    title: sfTranslator.trans("pequiven.dialog.confirm")
                }
            };
            //Establece el valor de un select2
            $scope.setValueSelect2 = function setValueSelect2(idSelect2, idEntity, data, callBack) {
                var selected = null;
                var i = 0, j = null;
                angular.forEach(data, function(val, i) {
                    if (val != undefined) {
                        if (val.id == idEntity) {
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
                $("#" + idSelect2).select2('val', j);
                if (callBack) {
                    callBack(data[j]);
                }
                $timeout(function(){
                    $("#"+idSelect2).trigger("change");
                });
//                    $("#"+idSelect2).trigger("select2-selecting");
            };
            //Funcion para remover un elemento de un array
            Array.prototype.remove = function(value) {
                var idx = this.indexOf(value);
                if (idx != -1) {
                    return this.splice(idx, 1);
                }
                return false;
            };
            //Verifica si existe un elemento en un array
            Array.prototype.contains = function(value) {
                var idx = this.indexOf(value);
                if (idx != -1) {
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
            $scope.templateOptions.setConfirmCallBack = function(callBack) {
                $scope.template.confirmCallBack = callBack;
            };
            $scope.templateOptions.enableModeEdit = function() {
                $scope.template.modeEdit = true;
            };
            $scope.templateOptions.setParameterCallBack = function(parameterCallBack) {
                $scope.template.parameterCallBack = parameterCallBack;
            };
            $scope.templateOptions.setUrl = function(callBack) {
                $scope.template.url = callBack;
            };
            $scope.templateOptions.setTemplate = function(template) {
                $scope.template = template;
            };

            var modalOpen, modalConfirm;
            jQuery(document).ready(function() {
                var angular = jQuery("#dialog-form");
                if (angular) {
                    modalOpen = angular.dialog({
                        autoOpen: false,
                        height: 650,
                        width: 800,
                        modal: true,
                        buttons: {
                            "Add": confirm,
                            Cancel: function() {
                                modalOpen.dialog("close");
                            }
                        },
                        close: function() {
                            //form[ 0 ].reset();
                            //allFields.removeClass( "ui-state-error" );
                        }
                    });
                }
                modalConfirm = $("#dialog-confirm").dialog({
                    autoOpen: false,
                    resizable: false,
                    height: 200,
                    modal: true,
                    buttons: {
                        Si: function() {
                            $(this).dialog("close");
                        },
                        No: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            });

            $scope.templateLoad = function(template) {
                template.load = true;
                if (template.initCallBack) {
                    if (template.initCallBack()) {
                        return openModal();
                    }
                } else {
                    return openModal();
                }
            };

            $scope.openModalAuto = function() {
                notificationBarService.getLoadStatus().loading();
                if ($scope.template.load == true) {
                    openModal();
                }
            };

            function openModal() {
                if ($scope.template.name) {
                    modalOpen.dialog("option", "title", sfTranslator.trans($scope.template.name));
                }

                if ($scope.template.modeEdit) {
                    $scope.template.modeEdit = false;
                    // setter
                    modalOpen.dialog("option", "buttons", [
                        {text: "Guardar", click: function() {
                                if ($scope.template.confirmCallBack) {
                                    if ($scope.template.confirmCallBack()) {
                                        modalOpen.dialog("close");
                                    }
                                } else {
                                    modalOpen.dialog("close");
                                }
                            }},
                        {text: "Cancelar", click: function() {
                                if ($scope.template.cancelCallBack) {
                                    if ($scope.template.cancelCallBack()) {
                                        modalOpen.dialog("close");
                                    }
                                } else {
                                    modalOpen.dialog("close");
                                }
                            }
                        }
                    ]);
                } else {
                    // setter
                    modalOpen.dialog("option", "buttons", [
                        {text: "Añadir", click: function() {
                                //console.log($scope.template.confirmCallBack);
                                if ($scope.template.confirmCallBack) {
                                    if ($scope.template.confirmCallBack()) {
                                        modalOpen.dialog("close");
                                        $scope.$apply();
                                    }
                                } else {
                                    modalOpen.dialog("close");
                                }
                            }},
                        {text: "Cancelar", click: function() {
                                modalOpen.dialog("close");
                            }
                        }
                    ]);
                }
                modalOpen.dialog("open");
                if ($scope.template.loadCallBack) {
                    $scope.template.loadCallBack($scope.template.parameterCallBack);
                }
                $scope.template.parameterCallBack = null;
                notificationBarService.getLoadStatus().done();
            }

            $scope.openModalConfirm = function(content, confirmCallBack, cancelCallBack) {
                $scope.dialog.confirm.content = sfTranslator.trans(content);

                // setter
                modalConfirm.dialog("option", "buttons", [
                    {text: "Si", click: function() {
                            if (confirmCallBack) {
                                confirmCallBack();
                                modalConfirm.dialog("close");
                                $scope.$apply();
                            } else {
                                modalConfirm.dialog("close");
                            }
                        }},
                    {text: "No", click: function() {
                            if (cancelCallBack) {
                                cancelCallBack();
                            }
                            modalConfirm.dialog("close");
                        }
                    }
                ]);

                modalConfirm.dialog("open");
                notificationBarService.getLoadStatus().done();
            };

            $scope.printFormErrors = function(formErrors) {
                if (formErrors !== undefined && formErrors.errors !== undefined) {
                    var divError = '<div class="alert alert-danger">';
                    angular.forEach(formErrors.errors, function(error) {
                        divError += error;
                        divError += '<br />';
                    });
                    divError += '</div>';
                    return divError;
                }
            };

        })
        .controller("ObjetiveStrategicController", function($scope, notificationBarService, $http, $filter, $timeout) {
            var form = angular.element('#registerObjetiveStrategicForm');

        })
        .controller('TableObjetiveStrategicController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {
//        $scope.tableParams.$params.groupBy = 'line_strategics[0].description';
//        console.log($scope.tableParams.$params.groupBy);
//        console.log($scope.tableParams);
//        console.log($scope.tableParams.settings().pages);
        })
        .controller('TableObjetiveTacticController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.gerenciaFirst = null;
            $scope.$watch("gerenciaFirst", function() {
                if ($scope.gerenciaFirst != null && $scope.gerenciaFirst != undefined)
                {
                    $scope.tableParams.$params.filter['gerencia'] = $scope.gerenciaFirst;
                } else {
                    $scope.tableParams.$params.filter['gerencia'] = null;
                }
            });
        })
        .controller('TableObjetiveOperativeController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.gerenciaSecond = null;
            $scope.gerenciaFirst = null;
            $scope.$watch("gerenciaFirst", function() {
                if ($scope.gerenciaFirst != null && $scope.gerenciaFirst != undefined)
                {
                    $scope.tableParams.$params.filter['gerencia'] = $scope.gerenciaFirst;
                } else {
                    $scope.tableParams.$params.filter['gerencia'] = null;
                }
            });
            $scope.$watch("gerenciaSecond", function() {
                if ($scope.gerenciaSecond != null && $scope.gerenciaSecond != undefined)
                {
                    $scope.tableParams.$params.filter['gerenciaSecond'] = $scope.gerenciaSecond;
                } else {
                    $scope.tableParams.$params.filter['gerenciaSecond'] = null;
                }
            });
        })
        .controller('TableIndicatorStrategicController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {

        })
        .controller('TableIndicatorTacticController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {

        })
        .controller('TableIndicatorOperativeController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {

        })
        .controller('TableMonitorTypeGroupController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {
            //Porcentaje Cargado
            $scope.porcCargado = function(data) {
                var res = 0;
                res = (data.RealObjTactic / data.PlanObjTactic) * 100;
                //res = parseFloat(res).toFixed(2);
                return res;
            };
            $scope.textType = function(data) {

            };
            //Total Planificados
            $scope.totalizePlan = function(data) {
                var cont = parseInt(0);
                angular.forEach(data, function(value) {
                    cont = cont + parseInt(value.PlanObjTactic);
                });
                return cont;
            };
            //Total Cargados
            $scope.totalizeReal = function(data) {
                var cont = parseInt(0);
                angular.forEach(data, function(value) {
                    cont = cont + parseInt(value.RealObjTactic);
                });
                return cont;
            };
            //Porcentaje Cargados
            $scope.totalizeCargado = function(totalPlan, totalReal) {
                var res = 0;
                res = (totalReal / totalPlan) * 100;
                //res = parseFloat(res).toFixed(2);
                return res;
            }
            $scope.semaforo = function(data) {

            }
        })
        .controller('TableMonitorTacticController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.totalizePlan = function(data) {
                var cont = 0;
                angular.forEach(data, function(value) {
                    cont = cont + value.objTacticOriginal;
                });
                return cont;
            };
        })
        .controller('DashboardController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {

            $scope.renderChartTactic = function(id,categories,dataPlanTactic,dataRealTactic,dataPorcTactic) {
                FusionCharts.ready(function() {
                    var revenueChartTactic = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        "renderAt": id,
                        "width": "600",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                "caption": Translator.trans('chart.captionObjTactic'),
                                "xAxisName": "Gerencias",
                                "pYAxisName": "N° de Objetivos",
                                "sYAxisName": "% Carga",
                                "sYAxisMaxValue": "100",
                                "sYAxisMinValue": "0",
                                "showValues" : "1",
                                "placeValuesInside": "0",
                                "valueFontColor": "#000000",
                                "rotateValues": "0",
                                "sNumberSuffix": "%",
                                "bgAlpha" : "0,0",
                                "baseFontColor" : "#ffffff",
                                "outCnvBaseFontColor" : "#ffffff",
                                "theme": "fint"
                            },
                            "categories": [
                                {
                                    "category": categories
                                }
                            ],
                            "dataset":[
                                {
                                    "seriesname": "Plan",
                                    "parentYAxis": "P",
                                    "data": dataPlanTactic
                                },
                                {
                                    "seriesname": "Real",
                                    "parentYAxis": "P",
                                    "data": dataRealTactic
                                },
                                {
                                    "seriesname": "Porc",
                                    "parentYAxis": "S",
                                    "renderas": "column",
                                    "data": dataPorcTactic
                                }
                            ]
                        }
                    });
                    revenueChartTactic.setTransparent(true);
                    revenueChartTactic.render();
                })
            };
            
            $scope.renderChartOperative = function(id,categories,dataPlanOperative,dataRealOperative,dataPorcOperative) {
                FusionCharts.ready(function() {
                    var revenueChartOperative = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        "renderAt": id,
                        "width": "600",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                "caption": Translator.trans('chart.captionObjOperative'),
                                "xAxisName": "Gerencias",
                                "pYAxisName": "N° de Objetivos",
                                "sYAxisName": "% Carga",
                                "sYAxisMaxValue": "100",
                                "sYAxisMinValue": "0",
                                "showValues" : "1",
                                "placeValuesInside": "0",
                                "valueFontColor": "#000000",
                                "rotateValues": "0",
                                "sNumberSuffix": "%",
                                "bgAlpha" : "0,0",
                                "baseFontColor" : "#ffffff",
                                "outCnvBaseFontColor" : "#ffffff",
                                "visible" : "0",
                                "theme": "fint"
                            },
                            "categories": [
                                {
                                    "category": categories
                                }
                            ],
                            "dataset":[
                                {
                                    "seriesname": "Plan",
                                    "parentYAxis": "P",
                                    "data": dataPlanOperative
                                },
                                {
                                    "seriesname": "Real",
                                    "parentYAxis": "P",
                                    "data": dataRealOperative
                                },
                                {
                                    "seriesname": "Porc",
                                    "parentYAxis": "S",
                                    "renderas": "column",
                                    "data": dataPorcOperative
                                }
                            ]
                        }
                    });
                    
                    revenueChartOperative.setTransparent(true);
                    revenueChartOperative.render();
                })
            };
        })
        .controller('TableMonitorOperativeController', function($scope, ngTableParams, $http, sfTranslator, notifyService) {

        });
