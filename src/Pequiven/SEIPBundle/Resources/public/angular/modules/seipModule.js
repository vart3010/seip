'use strict';
// Declare app level module which depends on filters, and services
var seipModule = angular.module('seipModule', [
    'ng-fusioncharts',
    'ngRoute',
    'seipModule.controllers',
    'notificationBarModule',
    'ngCookies'
]);
seipModule
        .filter('myNumberFormat', function () {
            return function (numberToFormat, limit) {
                if (limit == undefined) {
                    var limit = 2;
                }
                var numberFormat = $.number(numberToFormat, limit, ',', '.');
                return numberFormat;
            };
        });
function confirm() {

}

function getMappingModel(data, idEntity) {
    var selected = null;
    angular.forEach(data, function (val, i) {
        if (val != undefined) {
            if (val.id == idEntity) {
                selected = val;
            }
        }
    });
    return selected;
}

$.fn.serializeObject = function ()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
//Establece el valor de un select2
function setValueSelect2(idSelect2, idEntity, data, callBack) {
    var selected = null;
    var i = 0, j = null;
    angular.forEach(data, function (val, i) {
        if (val != undefined) {
            if (val.id == idEntity) {
                selected = val;
                j = i;
            }
        }
        i++;
    });
    $("#" + idSelect2).select2('val', j);
    if (callBack) {
        if (data && data[j] != undefined) {
            callBack(data[j]);
        }
    }
//    $("#"+idSelect2).trigger("select2-selecting");
}
function setValueSelect2Multiple(idSelect2, entities, data, callBack) {
    var selected = [];
    var selectedIds = [];
    var i = 0, j = null;
    angular.forEach(data, function (val, i) {
        if (val != undefined) {
            angular.forEach(entities, function (entity) {
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
        .controller("ArrangementProgramController", function ($scope, notificationBarService, $http, $filter, $timeout, $cookies) {
            $scope.entity = null;
            $scope.complejo = null;
            $scope.data.responsibleGoals = null;
            $scope.data.typeGoals = null;
            $scope.data.operationalObjectives = null;
            var model = {
                goalCount: null,
                arrangementprogramResponsibles: [],
                arrangementProgram: {
                    categoryArrangementProgram: null
                },
                managementSystem: null
            };
            $scope.templateOptions.setModel(model);
            var arrangementprogramResponsibles = angular.element('#arrangementprogram_responsibles');
            //Se ejecuta cuando le da click a incluir los responsables de las gerencia
            var changeIncludeResponsibleManagement = changeIncludeResponsibleManagement = function () {
                if ($scope.model.goal.includeResponsibleManagement) {
                    var reponsibleId = arrangementprogramResponsibles.val();
                    var urlResponsiblesByGerencia = Routing.generate("pequiven_arrangementprogram_data_responsible_goals", {responsibles: reponsibleId, gerencia: $scope.gerenciaOfObjetive.id});
                    $("#div_goal_responsibles").select2('data', []);
                    notificationBarService.getLoadStatus().loading();
                    $http.get(urlResponsiblesByGerencia).success(function (data) {
                        setUrlResponsibles(data);
                        notificationBarService.getLoadStatus().done();
                    });
                } else {
                    $("#div_goal_responsibles").select2('data', []);
                }
            };
            $scope.templateOptions.setVar('changeIncludeResponsibleManagement', changeIncludeResponsibleManagement);
            //Inicializar modelo de meta
            $scope.initModelGoal = function (goal) {
                $scope.model.goal = {
                    name: null,
                    typeGoal: null,
                    startDate: null,
                    endDate: null,
                    responsibles: null,
                    weight: null,
                    observations: null,
                    includeResponsibleManagement: false
                };
                $scope.changeIncludeResponsibleManagement();
                $("#goalForms select").each(function () {
                    $(this).select2("val", "");
                });
                if (goal) {
                    $scope.model.goal = goal;
                    $scope.model.goal.startDate = $filter('myDate')(goal.startDate);
                    $scope.model.goal.endDate = $filter('myDate')(goal.endDate);
                    var setTypeGoalCall = function (selected) {
                        $scope.model.goal.typeGoal = selected;
                    };
                    if (goal.typeGoal != undefined && goal.typeGoal.id != undefined) {
                        setValueSelect2("goal_typeGoal", goal.typeGoal.id, $scope.data.typeGoals, setTypeGoalCall);
                    } else {
                        setValueSelect2("goal_typeGoal", null, $scope.data.typeGoals, setTypeGoalCall);
                    }
                    setUrlResponsibles($scope.model.goal.responsibles);
                } else {
                    angular.element('#div_goal_responsibles').select2('data', []);
                }
            };
            //Metas
            $scope.goals = [];
            $scope.initModelGoal();
            $scope.addGoal = function () {
                var valid = $scope.validFormTypeGoal();
                if (valid) {
                    var startDate = angular.element('#goal_startDate').val();
                    var endDate = angular.element('#goal_endDate').val();
                    $scope.model.goal.startDate = startDate;
                    $scope.model.goal.endDate = endDate;
                    if (startDate == endDate) {
                        $scope.model.goal.endDate = $scope.model.goal.startDate;
                    }
                    $timeout(function () {
                        $scope.$apply();
                    });
                    if (!$scope.goals.contains($scope.model.goal)) {
                        $scope.goals.push($scope.model.goal);
                        $scope.initModelGoal();
                    }
                }
                return valid;
            };
            $scope.validFormTypeGoal = function () {
                var valid = $('#goalForms').validationEngine('validate');
                if (valid) {
                    $scope.model.goal.responsibles = $("#div_goal_responsibles").select2('data');
                    if ($scope.model.goal.responsibles == undefined) {
                        $scope.sendMessageError('pequiven.validators.arrangement_program.select_responsible_person', 's2id_div_goal_responsibles');
                        valid = false;
                    }
                }
                return valid;
            };
            $scope.cancelEditGoal = function () {
                return $scope.validFormTypeGoal();
            };
            $scope.getClassForMeter = function (percentaje, numMeter) {
                var className = '';
                if (numMeter == 1) {
                    if (percentaje > 0 && percentaje <= 30) {
                        className = 'red-gradient';
                    } else if (percentaje > 30 && percentaje < 70) {
                        className = 'orange-gradient';
                    } else if (percentaje >= 70) {
                        className = 'green-gradient';
                    }
                } else if (numMeter == 2) {
                    if (percentaje > 30 && percentaje < 70) {
                        className = 'orange-gradient';
                    } else if (percentaje >= 70) {
                        className = 'green-gradient';
                    }
                } else if (numMeter == 3) {
                    if (percentaje >= 70) {
                        className = 'green-gradient';
                    }
                }
                return 'meter ' + className;
            };
            //Funcion que carga el template de la meta
            $scope.loadTemplateMeta = function (goal, index) {
                $scope.model.goalCount = index;
                var responsibles = arrangementprogramResponsibles.val();
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
                    try {
                        $scope.openModalAuto(applyDatePickerDatePG);
                    } catch (err) {
                        $scope.openModalAuto();
                    }

                }
            };
            //Setea la data del formulario
            $scope.setDataFormGoal = function (goal) {
                $scope.initModelGoal(goal);
            };
            $scope.removeGoal = function (goal) {
                $scope.openModalConfirm('pequiven.modal.confirm.goal.delete_this_goal', function () {
                    $scope.goals.remove(goal);
                });
            };
            $scope.getTypeGoal = function (c) {
                if (c) {
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_arrangementprogram_data_type_goal", {category: c})).success(function (data) {
                        $scope.data.typeGoals = data;
                        notificationBarService.getLoadStatus().done();
                    });
                } else {
                    $scope.data.typeGoals = null;
                }
            };
            var urlGoal = Routing.generate("goal_get_form", {}, true);
            var initCallBack = function () {
                return false;
            };
            var managementSystem = angular.element('#arrangementprogram_managementSystem');
            var tacticalObjective = angular.element('#arrangementprogram_tacticalObjective');
            var operationalObjective = angular.element('#arrangementprogram_operationalObjective');
            var loadTemplateMetaButton = angular.element('#loadTemplateMeta');
            var categoryArrangementProgramId = angular.element('#categoryArrangementProgramValue');
            $scope.setOperationalObjective = function (tacticalObjetive, selected) {
                if (tacticalObjetive) {
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_arrangementprogram_data_operational_objectives", {idObjetiveTactical: tacticalObjetive, idCategoryArrangementProgram: categoryArrangementProgramId.val()})).success(function (data) {
                        var dataIndex = [];
                        angular.forEach(data, function (value) {
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
            managementSystem.on('change', function (e) {
                if (e.val) {
                    var managementSystemId = e.val;
                    tacticalObjective.find('option').remove().end();
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_arrangementprogram_data_tactical_objectives", {idManagementSystem: managementSystemId})).success(function (data) {
                        tacticalObjective.append('<option value="">' + Translator.trans('pequiven.select') + '</option>');
                        angular.forEach(data, function (value) {
                            tacticalObjective.append('<option value="' + value.id + '">' + value.ref + " " + value.description + ' - ' + value.gerencia.description + '</option>');
                        });
                        if (data.length > 0) {
                            tacticalObjective.select2('val', e.val);
                            tacticalObjective.select2('enable', true);
                        } else {
                            tacticalObjective.select2('val', '');
                            tacticalObjective.select2('enable', false);
                        }
                        notificationBarService.getLoadStatus().done();
                    });
                } else {
                    tacticalObjective.select2('val', '');
                    tacticalObjective.select2('enable', false);
                }
            });
            tacticalObjective.on('change', function (e) {
                if (e.val) {
                    if ($scope.entityType == 1) {
                        $scope.getLocationByTactical(e.val);
                    } else {
                        var tacticalObjetive = e.val;
                        operationalObjective.find('option').remove().end();
                        notificationBarService.getLoadStatus().loading();
                        $http.get(Routing.generate("pequiven_arrangementprogram_data_operational_objectives", {idObjetiveTactical: tacticalObjetive, idCategoryArrangementProgram: categoryArrangementProgramId.val()})).success(function (data) {
                            operationalObjective.append('<option value="">' + Translator.trans('pequiven.select') + '</option>');
                            angular.forEach(data, function (value) {
                                operationalObjective.append('<option value="' + value.id + '">' + value.ref + " " + value.description + ' - ' + value.gerenciaSecond.description + '</option>');
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
                    }
                } else {
                    operationalObjective.select2('val', '');
                    operationalObjective.select2('enable', false);
                }
            });
            operationalObjective.on('change', function () {
                $scope.getLocationByOperative(operationalObjective.val());
            });
            arrangementprogramResponsibles.on('change', function (object) {
                var data = arrangementprogramResponsibles.select2('data');
                $scope.model.arrangementprogramResponsibles = data;
                $timeout(function () {
                    $scope.$apply();
                });
                var reponsibleId = object.val;
                $scope.validButtomAddGoal();
                $scope.getResponsiblesGoal(reponsibleId);
            });
            $scope.validButtomAddGoal = function () {

                if (arrangementprogramResponsibles.val() != null && arrangementprogramResponsibles.val().length > 0) {
                    loadTemplateMetaButton.removeClass('disabled');
                } else {
                    loadTemplateMetaButton.addClass('disabled');
                }
            };
            $scope.getResponsiblesGoal = function (reponsibleId) {
                if (reponsibleId == '') {
                    $scope.data.responsibleGoals = [];
                } else {
//                    notificationBarService.getLoadStatus().loading();
//                    $scope.urlResponsibles = Routing.generate("pequiven_arrangementprogram_data_responsible_goals", {responsibles: reponsibleId});
//                    $http.get($scope.urlResponsibles).success(function(data) {
//                        $scope.data.responsibleGoals = data;
//                        notificationBarService.getLoadStatus().done();
//                    });
                }
            };
            $scope.getLocationByTactical = function (value) {
                if (value != '') {
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("objetiveTactic_show", {id: value, _format: 'json', _groups: ['complejo']})).success(function (data) {
                        $scope.complejo = data.entity.gerencia.complejo;
                        $scope.templateOptions.setVar('gerenciaOfObjetive', data.entity.gerencia);
                        notificationBarService.getLoadStatus().done();
                    });
                }
            };
            $scope.getLocationByOperative = function (val) {
                if (val != '') {
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("objetiveOperative_show", {id: val, _format: 'json', _groups: ['complejo']})).success(function (data) {
                        $scope.complejo = data.entity.complejo;
                        $scope.templateOptions.setVar('gerenciaOfObjetive', data.entity.gerenciaSecond);
                        notificationBarService.getLoadStatus().done();
                    });
                }
            };
            $scope.setEntityType = function (entity) {
                $scope.entityType = entity;
                if ($scope.entityType == 1) {
                    $scope.getLocationByTactical(tacticalObjective.val());
                }
                if ($scope.entityType == 2) {
                    $scope.getLocationByOperative(operationalObjective.val());
                }
            };
            $scope.formReady = false;
            var form = angular.element('#formArrangementProgram');
            form.submit(function (e) {
                var valid = true;
                //Select de responsables
                if (arrangementprogramResponsibles) {
                    var v = arrangementprogramResponsibles.val();
                    if (v == '' || v == null) {
                        $scope.sendMessageError("pequiven.validators.arrangement_program.select_responsible_person", "s2id_arrangementprogram_responsibles");
                        valid = false;
                    }
                }
                if (valid) {
                    var autoOpenOnSave = angular.element('#autoOpenOnSave');
                    if ($scope.goals.length > 0) {
                        $scope.openModalConfirm(Translator.trans('pequiven.modal.confirm.arrangement_program.open_on_save'), function () {
                            autoOpenOnSave.val(1);
                            $scope.formReady = true;
                            form.submit();
                        }, function () {
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
            $scope.sendMessageError = function (message, id) {
                if (message === null) {
                    message = 'pequiven.validations.blank_text';
                }
                var messageTrans = "* " + Translator.trans(message);
                if (id == undefined) {
                    id = 'message-errors';
                }
                jQuery('#' + id).validationEngine('showPrompt', messageTrans, 'error');
                $timeout(function () {
                    jQuery('#' + id).validationEngine('hide');
                }, 3000);
            };
            //Calcula el total de peso distribuido en las metas
            $scope.getTotalWeight = function () {
                var total = 0;
                angular.forEach($scope.goals, function (goal) {
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
//                    initCallBack: initCallBack
                }
            ];
//            $scope.templateOptions.setTemplate($scope.templates[0]);

            $scope.init = function () {
                if (arrangementprogramResponsibles.val() != undefined && arrangementprogramResponsibles.val() != '') {
                    $scope.getResponsiblesGoal(arrangementprogramResponsibles.val());
                }
                if (operationalObjective.val() == '' || operationalObjective.val() == null) {
                    operationalObjective.select2('enable', false)
                }
                $scope.validButtomAddGoal();
            };
            $scope.init();
        })
        .controller("ArrangementProgramTemplateController", function ($scope, notificationBarService, $http, $filter, $timeout, $cookies) {
            $scope.entity = null;
            $scope.complejo = null;
            $scope.data.responsibleGoals = null;
            $scope.data.typeGoals = null;
            $scope.data.operationalObjectives = null;
            $scope.model.goalCount = null;
            $scope.model.arrangementProgram = {
                categoryArrangementProgram: null
            };
            //Inicializar modelo de meta
            $scope.initModelGoal = function (goal) {
                $scope.model.goal = {
                    name: null,
                    typeGoal: null,
                    startDate: null,
                    endDate: null,
                    weight: null,
                    observations: null
                };
                $("#goalForms select").each(function () {
                    $(this).select2("val", "");
                });
                if (goal) {
                    $scope.model.goal = goal;
                    $scope.model.goal.startDate = $filter('myDate')(goal.startDate);
                    $scope.model.goal.endDate = $filter('myDate')(goal.endDate);
                    var setTypeGoalCall = function (selected) {
                        $scope.model.goal.typeGoal = selected;
                    };
                    if (goal.typeGoal != undefined && goal.typeGoal.id != undefined) {
                        setValueSelect2("goal_typeGoal", goal.typeGoal.id, $scope.data.typeGoals, setTypeGoalCall);
                    } else {
                        setValueSelect2("goal_typeGoal", null, $scope.data.typeGoals, setTypeGoalCall);
                    }
                }
            };
            //Metas
            $scope.goals = [];
            $scope.initModelGoal();
            $scope.addGoal = function () {
                var valid = $scope.validFormTypeGoal();
                if (valid) {
                    if (!$scope.goals.contains($scope.model.goal)) {
                        $scope.goals.push($scope.model.goal);
                        $scope.initModelGoal();
                    }
                }
                return valid;
            };
            $scope.validFormTypeGoal = function () {
                var valid = true;
                return valid;
            };
            $scope.cancelEditGoal = function () {
                return $scope.validFormTypeGoal();
            };
            //Funcion que carga el template de la meta
            $scope.loadTemplateMeta = function (goal, index) {
                $scope.model.goalCount = index;
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
            $scope.setDataFormGoal = function (goal) {
                $scope.initModelGoal(goal);
            };
            $scope.removeGoal = function (goal) {
                $scope.openModalConfirm('pequiven.modal.confirm.goal.delete_this_goal', function () {
                    $scope.goals.remove(goal);
                });
            };
            $scope.getTypeGoal = function (c) {
                if (c) {
                    notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_arrangementprogram_data_type_goal", {category: c})).success(function (data) {
                        $scope.data.typeGoals = data;
                        notificationBarService.getLoadStatus().done();
                    });
                } else {
                    $scope.data.typeGoals = null;
                }
            };
            var urlGoal = Routing.generate("goal_get_form", {typeForm: 'template'}, true);
            var initCallBack = function () {
                return false;
            };
            $scope.formReady = false;
            var form = angular.element('#formArrangementProgram');
            form.submit(function (e) {
                var autoOpenOnSave = angular.element('#autoOpenOnSave');
                if ($scope.goals.length > 0) {
                    $scope.openModalConfirm(Translator.trans('pequiven.modal.confirm.arrangement_program.open_on_save'), function () {
                        autoOpenOnSave.val(1);
                        $scope.formReady = true;
                        form.submit();
                    }, function () {
                        autoOpenOnSave.val(0);
                        $scope.formReady = true;
                        form.submit();
                    });
                } else {
                    $scope.formReady = true;
                }
                if ($scope.formReady == true) {
                    return true;
                }
                e.preventDefault();
            });
            $scope.sendMessageError = function (message, id) {
                if (message === null) {
                    message = 'pequiven.validations.blank_text';
                }
                var messageTrans = "* " + Translator.trans(message);
                if (id == undefined) {
                    id = 'message-errors';
                }
                jQuery('#' + id).validationEngine('showPrompt', messageTrans, 'error');
                $timeout(function () {
                    jQuery('#' + id).validationEngine('hide');
                }, 3000);
            };
            //Calcula el total de peso distribuido en las metas
            $scope.getTotalWeight = function () {
                var total = 0;
                angular.forEach($scope.goals, function (goal) {
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
        })
        .controller('ReportArrangementProgramTemplateController', function ($scope, $http) {
            $scope.createProgramFrom = function (arrangementProgramTemplate) {
                var url = Routing.generate('pequiven_arrangementprogram_create', {
                    type: arrangementProgramTemplate.type,
                    associate: 2,
                    templateSource: arrangementProgramTemplate.id
                });
                document.location = url;
            };
        })
        .controller('ReportArrangementProgramController', function ($scope, $http) {
            var planning = angular.element('#planning');
            var isPlanning = (planning.val() != undefined) ? true : false;
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
            var selectsDisable = [];
            $scope.disableSelect = function (id) {
                selectsDisable.push(id);
                angular.element('#' + id).select('enable', false);
            };
            var setEnableSelect = function (id, enabled) {
                var i;
                var isEnable = true;
                for (i = 0; i < selectsDisable.length; i++) {
                    if (selectsDisable[i] == id) {
                        isEnable = false;
                    }
                }
                if (isEnable == true) {
                    angular.element('#selectComplejos').select2("enable", enabled)
                } else {
                    angular.element('#selectComplejos').select2("enable", false)
                }
            };
            //Objetivo Táctico
            if (!isPlanning) {
                var parameters = {
                    filter: {}
                };
                parameters.filter['view_planning'] = false;
                $http.get(Routing.generate('pequiven_arrangementprogram_data_tactical_objectives', parameters))
                        .success(function (data) {
                            $scope.data.tacticals = data;
                        });
            } else {
                var parameters = {
                    filter: {}
                };
                var gerencia = angular.element('#idGerencia');
                parameters.filter['gerencia'] = gerencia.val();
                parameters.filter['view_planning'] = true;
                $http.get(Routing.generate('pequiven_arrangementprogram_data_tactical_objectives', parameters))
                        .success(function (data) {
                            $scope.data.tacticals = data;
                        });
            }
            // Objetivo Operativo
            $scope.getOperatives = function (objetiveTactical) {
                var parameters = {
                    filter: {}
                };
                parameters.filter['view_planning'] = false;
                if (objetiveTactical != undefined) {
                    parameters.filter['objetiveTactical'] = objetiveTactical;
                }
                if (objetiveTactical == undefined && isPlanning) {
                    var gerencia = angular.element('#idGerencia');
                    parameters.filter['gerencia'] = gerencia.val();
                    parameters.filter['view_planning'] = true;
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_operatives_objectives', parameters))
                        .success(function (data) {
                            $scope.data.operatives = data;
                        });
            };
            $scope.getOperatives();
            //Gerencia Primera Línea
            if (isPlanning) {
                var complejo = angular.element('#idComplejo');
                var parameters = {
                    filter: {}
                };
                parameters.filter['complejo'] = complejo.val();
                $http.get(Routing.generate('pequiven_arrangementprogram_data_first_line_management', parameters))
                        .success(function (data) {
                            $scope.data.first_line_managements = data;
                            if ($scope.model.firstLineManagement != null) {
                                $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.data.first_line_managements, function (selected) {
                                    $scope.model.firstLineManagement = selected;
                                });
                                var selectFirstLineManagement = angular.element('#firstLineManagement');
                                selectFirstLineManagement.select2("enable", false);
                            }
                        });
            }
            $scope.setSelectFirsLineManagement = function (value) {
                $scope.model.firstLineManagement = value;
            };
            //Busca las gerencias de segunda linea
            $scope.getSecondLineManagement = function (gerencia) {
                var parameters = {
                    filter: {}
                };
                parameters.filter['view_planning'] = false;
                if ($scope.model.firstLineManagement != null) {
                    parameters.filter['gerencia'] = $scope.model.firstLineManagement.id;
                }
                if ($scope.model.typeManagement != null) {
                    parameters.filter['typeManagement'] = $scope.model.typeManagement.id;
                    if ($scope.model.complejo) {
                        parameters.filter['complejo'] = $scope.model.complejo.id;
                    }
                }
                if (isPlanning) {
                    parameters.filter['view_planning'] = true;
                    var gerencia = angular.element("#idGerencia");
                    parameters.filter['gerencia'] = gerencia.val();
                }

                $http.get(Routing.generate('pequiven_arrangementprogram_data_second_line_management', parameters))
                        .success(function (data) {
                            $scope.data.second_line_managements = data;
                            if ($scope.model.secondLineManagement != null) {
                                $scope.setValueSelect2("secondLineManagement", $scope.model.secondLineManagement, $scope.data.second_line_managements, function (selected) {
                                    $scope.model.secondLineManagement = selected;
                                });
                            }
                        });
            };
            $scope.getSecondLineManagement();
            //Carga de Filtro Localidad
            if (!isPlanning) {
                $http.get(Routing.generate('pequiven_arrangementprogram_data_complejos'))
                        .success(function (data) {
                            $scope.data.complejos = data;
                            if ($scope.model.complejo != null) {
                                $scope.setValueSelect2("selectComplejos", $scope.model.complejo, $scope.data.complejos, function (selected) {
                                    $scope.model.complejo = selected;
                                    if ($scope.model.firstLineManagement != undefined) {
                                        $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.model.complejo.gerencias, function (selected) {
                                            $scope.model.firstLineManagement = selected;
                                        });
                                    }
                                });
                            }
                        });
            } else {
                var parameters = {
                    filter: {}
                };
                var complejo = angular.element('#idComplejo');
                parameters.filter['id'] = complejo.val();
                $http.get(Routing.generate('pequiven_arrangementprogram_data_complejos', parameters))
                        .success(function (data) {
                            $scope.data.complejos = data;
                            if ($scope.model.complejo != null) {
                                $scope.setValueSelect2("selectComplejos", $scope.model.complejo, $scope.data.complejos, function (selected) {
                                    $scope.model.complejo = selected;
                                });
                                var selectComplejos = angular.element('#');
                                setEnableSelect('selectComplejos', false);
                            }
                        });
            }
            $http.get(Routing.generate('pequiven_arrangementprogram_data_responsibles'))
                    .success(function (data) {
                        $scope.data.responsibles = data;
                    });
            //Programas de Gestión Notificados, No Notificados y con Proceso de Notificación sin cerrar
            $scope.viewNotified = function (type) {
                $scope.tableParams.$params.filter['view_planning'] = true;
                $scope.tableParams.$params.filter['type'] = type;
                $scope.tableParams.$params.filter['status'] = null;
                var selectStatus = angular.element('#selectStatus');
                selectStatus.select2("val", '');
            };
            //Método que reinicia los filtros para la vista de planificación
            $scope.resetViewNotified = function () {
                $scope.tableParams.$params.filter['view_planning'] = null;
                $scope.tableParams.$params.filter['type'] = null;
            };
            //Ver el resumen de programas de gestión por status
            $scope.viewByStatus = function (status) {
                $scope.tableParams.$params.filter['status'] = status;
                var selectStatus = angular.element('#selectStatus');
                selectStatus.select2("val", status);
                $scope.resetViewNotified();
            };
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {

                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            });
            $scope.$watch("model.arrangementProgramStatus", function (newParams, oldParams) {
                if ($scope.model.arrangementProgramStatus != null && $scope.model.arrangementProgramStatus.id != undefined) {
                    $scope.tableParams.$params.filter['status'] = $scope.model.arrangementProgramStatus.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['status'] = null;
                }
            });
            $scope.$watch("model.responsibles", function (newParams, oldParams) {
                if ($scope.model.responsibles != null) {
                    var responsiblesId = [], i = 0;
                    var responsibles = angular.element("#responsibles").select2('data');
                    angular.forEach(responsibles, function (value) {
                        responsiblesId.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['responsibles'] = angular.toJson(responsiblesId);
                        $scope.resetViewNotified();
                    } else {
                        $scope.tableParams.$params.filter['responsibles'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['responsibles'] = null;
                }
            });
            $scope.$watch("model.responsiblesGoals", function (newParams, oldParams) {
                if ($scope.model.responsiblesGoals != null) {
                    var responsiblesId = [], i = 0;
                    var responsibles = angular.element("#responsiblesGoals").select2('data');
                    angular.forEach(responsibles, function (value) {
                        responsiblesId.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['responsiblesGoals'] = angular.toJson(responsiblesId);
                        $scope.resetViewNotified();
                    } else {
                        $scope.tableParams.$params.filter['responsiblesGoals'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['responsiblesGoals'] = null;
                }
            });
            $scope.$watch("model.tacticalObjective", function (newParams, oldParams) {
                if ($scope.model.tacticalObjective != null && $scope.model.tacticalObjective.id != undefined) {
                    $scope.tableParams.$params.filter['tacticalObjective'] = $scope.model.tacticalObjective.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['tacticalObjective'] = null;
                }
            });
            $scope.$watch("model.operationalObjective", function (newParams, oldParams) {
                if ($scope.model.operationalObjective != null && $scope.model.operationalObjective.id != undefined) {
                    $scope.tableParams.$params.filter['operationalObjective'] = $scope.model.operationalObjective.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['operationalObjective'] = null;
                }
            });
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
                }
            });
            $scope.$watch("model.secondLineManagement", function (newParams, oldParams) {
                if ($scope.model.secondLineManagement != null && $scope.model.secondLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['secondLineManagement'] = $scope.model.secondLineManagement.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                }
            });
            //Filtro de modular y vinculante
            $scope.$watch("model.typeManagement", function (newParams, oldParams) {
                var firstLineManagement = angular.element('#firstLineManagement');
                if ($scope.model.typeManagement != null && $scope.model.typeManagement.id != undefined) {
                    $scope.tableParams.$params.filter['typeManagement'] = $scope.model.typeManagement.id;
                    $scope.resetViewNotified();
                    if ($scope.model.typeManagement.id == 0) {//Si el filtro es modular
                        setEnableSelect('selectComplejos', false);
                        setEnableSelect('firstLineManagement', false);
                    }
                } else {
                    $scope.tableParams.$params.filter['typeManagement'] = null;
                    setEnableSelect('selectComplejos', true);
                    setEnableSelect('firstLineManagement', true);
                }
            });
        })
        .controller('ReportTemplateIndexActionController', function ($scope) {
            var format = function (data)
            {
                var text = data.name;
                if (text == undefined && data.description != undefined) {
                    text = data.description;
                }
                return text;
            };
            var buldSelect2 = function (id, data)
            {
                var myData = getDefaultSelect(data);
                var select = $("#" + id).select2(myData)
                        .on('change', function () {

                            var me = $(this);
                            var value = me.val();
                            var multiple = me.attr('multiple');
                            var name = me.attr('name');
                            if (multiple != undefined && value != "") {
                                value = angular.toJson(value.split(','));
                            } else {

                            }
                            if (value != '') {
                                $scope.tableParams.$params.filter[name] = value;
                            } else {
                                $scope.tableParams.$params.filter[name] = null;
                            }
                            $scope.tableParams.reload();
                        })
                        ;
                select.attr('multiple', myData.multiple);
                return select;
            };
            var urlSearchService = Routing.generate('pequiven_seip_search_service');
            var urlSearchProduct = Routing.generate('pequiven_seip_search_product');
            var urlSearchEntity = Routing.generate('pequiven_seip_search_entity');
            var urlSearchPlant = Routing.generate('pequiven_seip_search_plant');
            var urlSearchRegion = Routing.generate('pequiven_seip_search_region');
            var urlSearchLocation = Routing.generate('pequiven_seip_search_location');
            var urlSearchCompany = Routing.generate('pequiven_seip_search_company');
            var urlSearchPeriod = Routing.generate('pequiven_seip_search_period');
            function getDefaultSelect(data) {
                var dataDefault = {
                    placeholder: ' ',
                    allowClear: true,
                    minimumInputLength: 2,
                    multiple: false,
                    ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                        url: data.url,
                        dataType: 'json',
                        quietMillis: 250,
                        data: function (term, page) {
                            return {
                                q: term, // search term
                            };
                        },
                        results: function (data, page) { // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to alter the remote JSON data
                            return {results: data};
                        },
                        cache: true
                    },
                    initSelection: function (element, callback) {
                        // the input tag has a value attribute preloaded that points to a preselected repository's id
                        // this function resolves that id attribute to an object that select2 can render
                        // using its formatResult renderer - that way the repository name is shown preselected
                    },
                    formatResult: format, // omitted for brevity, see the source of this page
                    formatSelection: format, // omitted for brevity, see the source of this page
                    escapeMarkup: function (m) {
                        return m;
                    } // we do not want to escape markup since we are displaying html in results
                };
                var result = $.extend(dataDefault, data);
                return result;
            }
            buldSelect2('select-service', {
                url: urlSearchService,
                multiple: true
            });
            buldSelect2('select-product', {
                url: urlSearchProduct,
                multiple: true
            });
            buldSelect2('select-entity', {
                url: urlSearchEntity
            });
            buldSelect2('select-plant', {
                url: urlSearchPlant
            });
            buldSelect2('select-region', {
                url: urlSearchRegion
            });
            buldSelect2('select-location', {
                url: urlSearchLocation
            });
            buldSelect2('select-company', {
                url: urlSearchCompany
            });
            buldSelect2('select-period', {
                url: urlSearchPeriod
            });
        })
        .controller('ReportArrangementProgramAllController', function ($scope, $http) {
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
            var selectsDisable = [];
            $scope.disableSelect = function (id) {
                selectsDisable.push(id);
                angular.element('#' + id).select('enable', false);
            };
            var setEnableSelect = function (id, enabled) {
                var i;
                var isEnable = true;
                for (i = 0; i < selectsDisable.length; i++) {
                    if (selectsDisable[i] == id) {
                        isEnable = false;
                    }
                }
                if (isEnable == true) {
                    angular.element('#selectComplejos').select2("enable", enabled)
                } else {
                    angular.element('#selectComplejos').select2("enable", false)
                }
            };
            //Carga de Filtro Localidad
            $http.get(Routing.generate('pequiven_arrangementprogram_data_complejos'))
                    .success(function (data) {
                        $scope.data.complejos = data;
                        if ($scope.model.complejo != null) {
                            $scope.setValueSelect2("selectComplejos", $scope.model.complejo, $scope.data.complejos, function (selected) {
                                $scope.model.complejo = selected;
                                $scope.getFirstLineManagement($scope.model.complejo);
//                            if($scope.model.firstLineManagement != undefined){
//                                $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.model.complejo.gerencias, function(selected) {
//                                    $scope.model.firstLineManagement = selected;
//                                });
//                            }
                            });
                        }
                    });
            // Filtro Gerencia 1ra Línea
            $scope.getFirstLineManagement = function (complejo) {
                var parameters = {
                    filter: {}
                };
                if (complejo != undefined) {
                    parameters.filter['complejo'] = complejo;
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_first_line_management', parameters))
                        .success(function (data) {
                            $scope.data.first_line_managements = data;
                            if ($scope.model.firstLineManagement != null) {
                                $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.data.first_line_managements, function (selected) {
                                    $scope.model.firstLineManagement = selected;
                                });
//                            var selectFirstLineManagement = angular.element('#firstLineManagement');
                            }
                        });
            };
            $scope.getFirstLineManagement();
//            
            //Filtro Gerencia 2da Línea
            $scope.getSecondLineManagement = function (gerencia, complejo) {
                var parameters = {
                    filter: {}
                };
                if (gerencia != undefined) {
                    parameters.filter['gerencia'] = gerencia;
                } else {
                    if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                        parameters.filter['complejo'] = $scope.model.complejo.id;
                    }
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_second_line_management', parameters))
                        .success(function (data) {
                            $scope.data.second_line_managements = data;
                            if ($scope.model.secondLineManagement != null) {
                                $scope.setValueSelect2("secondLineManagement", $scope.model.secondLineManagement, $scope.data.second_line_managements, function (selected) {
                                    $scope.model.secondLineManagement = selected;
                                });
                            }
                        });
            };
            $scope.getSecondLineManagement();
            //Objetivo Táctico
            $scope.getTactics = function (gerencia) {
                var parameters = {
                    filter: {}
                };
                parameters.filter['view_planning'] = false;
                if (gerencia != undefined) {
                    parameters.filter['view_planning'] = true;
                    parameters.filter['gerencia'] = gerencia;
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_tactical_objectives', parameters))
                        .success(function (data) {
                            $scope.data.tacticals = data;
                        });
            };
            $scope.getTactics();
            // Objetivo Operativo
            $scope.getOperatives = function (objetiveTactical) {
                var parameters = {
                    filter: {}
                };
                parameters.filter['view_planning'] = false;
                if (objetiveTactical != undefined) {
                    parameters.filter['objetiveTactical'] = objetiveTactical;
                }
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    parameters.filter['gerencia'] = $scope.model.firstLineManagement.id;
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_operatives_objectives', parameters))
                        .success(function (data) {
                            $scope.data.operatives = data;
                        });
            };
            $scope.getOperatives();
            $http.get(Routing.generate('pequiven_arrangementprogram_data_responsibles'))
                    .success(function (data) {
                        $scope.data.responsibles = data;
                    });
            //Ver el resumen de programas de gestión por status
            $scope.viewByStatus = function (status) {
                $scope.tableParams.$params.filter['status'] = status;
                var selectStatus = angular.element('#selectStatus');
                selectStatus.select2("val", status);
//                $scope.resetViewNotified();
            }

            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
//                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            });
            $scope.$watch("model.arrangementProgramStatus", function (newParams, oldParams) {
                if ($scope.model.arrangementProgramStatus != null && $scope.model.arrangementProgramStatus.id != undefined) {
                    $scope.tableParams.$params.filter['status'] = $scope.model.arrangementProgramStatus.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['status'] = null;
                }
            });
            $scope.$watch("model.responsibles", function (newParams, oldParams) {
                if ($scope.model.responsibles != null) {
                    var responsiblesId = [], i = 0;
                    var responsibles = angular.element("#responsibles").select2('data');
                    angular.forEach(responsibles, function (value) {
                        responsiblesId.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['responsibles'] = angular.toJson(responsiblesId);
                        $scope.resetViewNotified();
                    } else {
                        $scope.tableParams.$params.filter['responsibles'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['responsibles'] = null;
                }
            });
            $scope.$watch("model.responsiblesGoals", function (newParams, oldParams) {
                if ($scope.model.responsiblesGoals != null) {
                    var responsiblesId = [], i = 0;
                    var responsibles = angular.element("#responsiblesGoals").select2('data');
                    angular.forEach(responsibles, function (value) {
                        responsiblesId.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['responsiblesGoals'] = angular.toJson(responsiblesId);
                        $scope.resetViewNotified();
                    } else {
                        $scope.tableParams.$params.filter['responsiblesGoals'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['responsiblesGoals'] = null;
                }
            });
            $scope.$watch("model.tacticalObjective", function (newParams, oldParams) {
                if ($scope.model.tacticalObjective != null && $scope.model.tacticalObjective.id != undefined) {
                    $scope.tableParams.$params.filter['tacticalObjective'] = $scope.model.tacticalObjective.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['tacticalObjective'] = null;
                }
            });
            $scope.$watch("model.operationalObjective", function (newParams, oldParams) {
                if ($scope.model.operationalObjective != null && $scope.model.operationalObjective.id != undefined) {
                    $scope.tableParams.$params.filter['operationalObjective'] = $scope.model.operationalObjective.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['operationalObjective'] = null;
                }
            });
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
                }
            });
            $scope.$watch("model.secondLineManagement", function (newParams, oldParams) {
                if ($scope.model.secondLineManagement != null && $scope.model.secondLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['secondLineManagement'] = $scope.model.secondLineManagement.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                }
            });
            //Filtro de modular y vinculante
            $scope.$watch("model.typeManagement", function (newParams, oldParams) {
                var firstLineManagement = angular.element('#firstLineManagement');
                if ($scope.model.typeManagement != null && $scope.model.typeManagement.id != undefined) {
                    $scope.tableParams.$params.filter['typeManagement'] = $scope.model.typeManagement.id;
                    $scope.resetViewNotified();
                    if ($scope.model.typeManagement.id == 0) {//Si el filtro es modular
                        setEnableSelect('selectComplejos', false);
                        setEnableSelect('firstLineManagement', false);
                    }
                } else {
                    $scope.tableParams.$params.filter['typeManagement'] = null;
                    setEnableSelect('selectComplejos', true);
                    setEnableSelect('firstLineManagement', true);
                }
            });
        })
        .controller('ReportArrangementProgramSigAllController', function ($scope, $http) {
            $scope.data = {
                managementSystems: null,
                responsibles: null,
                arrangementProgramStatusLabels: null,
            };
            $scope.model = {
                managementSystem: null,
                arrangementProgramStatus: null,
                responsiblesGoals: null,
                responsibles: null,
            };
            var selectsDisable = [];
            $scope.disableSelect = function (id) {
                selectsDisable.push(id);
                angular.element('#' + id).select('enable', false);
            };
            //Carga de Sistemas de Calidad
            $http.get(Routing.generate('pequiven_arrangementprogram_data_management_system'))
                    .success(function (data) {
                        $scope.data.managementSystems = data;
                        if ($scope.model.managementSystem != null) {
                            $scope.setValueSelect2("selectManagementSystems", $scope.model.managementSystem, $scope.data.managementSystems, function (selected) {
                                $scope.model.managementSystem = selected;
                            });
                        }
                    });
            $http.get(Routing.generate('pequiven_arrangementprogram_data_responsibles'))
                    .success(function (data) {
                        $scope.data.responsibles = data;
                    });
            //Ver el resumen de programas de gestión por status
            $scope.viewByStatus = function (status) {
                $scope.tableParams.$params.filter['status'] = status;
                var selectStatus = angular.element('#selectStatus');
                selectStatus.select2("val", status);
//                $scope.resetViewNotified();
            }

            $scope.$watch("model.managementSystem", function (newParams, oldParams) {
                if ($scope.model.managementSystem != null && $scope.model.managementSystem.id != undefined) {
                    $scope.tableParams.$params.filter['managementSystem'] = $scope.model.managementSystem.id;
//                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['managementSystem'] = null;
                }
            });
            $scope.$watch("model.arrangementProgramStatus", function (newParams, oldParams) {
                if ($scope.model.arrangementProgramStatus != null && $scope.model.arrangementProgramStatus.id != undefined) {
                    $scope.tableParams.$params.filter['status'] = $scope.model.arrangementProgramStatus.id;
                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['status'] = null;
                }
            });
            $scope.$watch("model.responsibles", function (newParams, oldParams) {
                if ($scope.model.responsibles != null) {
                    var responsiblesId = [], i = 0;
                    var responsibles = angular.element("#responsibles").select2('data');
                    angular.forEach(responsibles, function (value) {
                        responsiblesId.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['responsibles'] = angular.toJson(responsiblesId);
                        $scope.resetViewNotified();
                    } else {
                        $scope.tableParams.$params.filter['responsibles'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['responsibles'] = null;
                }
            });
            $scope.$watch("model.responsiblesGoals", function (newParams, oldParams) {
                if ($scope.model.responsiblesGoals != null) {
                    var responsiblesId = [], i = 0;
                    var responsibles = angular.element("#responsiblesGoals").select2('data');
                    angular.forEach(responsibles, function (value) {
                        responsiblesId.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['responsiblesGoals'] = angular.toJson(responsiblesId);
                        $scope.resetViewNotified();
                    } else {
                        $scope.tableParams.$params.filter['responsiblesGoals'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['responsiblesGoals'] = null;
                }
            });
        })
        .controller('IndicatorResultController', function ($scope, notificationBarService, $http, notifyService, $filter) {

            $scope.urlValueIndicatorForm = null;
            $scope.indicator = null;
            var isInit = false;
            //Carga el formulario de los valores del indicador
            $scope.loadTemplateValueIndicator = function (resource) {
                $scope.initForm(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                $scope.templateOptions.setVar('evaluationResult', 0);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario de los los puntos de atencion del indicador
            $scope.loadTemplateFeatureIndicator = function (resource) {
                $scope.initForm(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[1]);
                $scope.templateOptions.setParameterCallBack(resource);
                $scope.templateOptions.setVar('evaluationResult', 0);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            $scope.removeFeatureIndicator = function (featureIndicator) {
                $scope.openModalConfirm('pequiven.modal.confirm.indicator.delete_feature', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_feature_indicator_delete", {id: featureIndicator.id});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        $scope.templateOptions.setVar("form", {errors: {}});
                        $scope.indicator.featuresIndicator.remove(featureIndicator);
                        notificationBarService.getLoadStatus().done();
                        return true;
                    }).error(function (data, status, headers, config) {
                        $scope.templateOptions.setVar("form", {errors: {}});
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                            $scope.templateOptions.setVar("form", {errors: data.errors.children});
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                });
            };
            var evaluateFormula = function (save, successCallBack) {
                var formValueIndicator = angular.element('#form_value_indicator');
                var formData = formValueIndicator.serialize();
                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_value_indicator_add', {idIndicator: $scope.indicator.id});
                } else {
                    var url = Routing.generate('pequiven_value_indicator_calculate', {idIndicator: $scope.indicator.id});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    $scope.templateOptions.setVar('evaluationResult', data.result);
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    return true;
                }).error(function (data, status, headers, config) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (data.errors) {
                        if (data.errors.errors) {
                            $.each(data.errors.errors, function (index, value) {
                                notifyService.error(Translator.trans(value));
                            });
                        }
                        $scope.templateOptions.setVar("form", {errors: data.errors.children});
                    }
                    $scope.templateOptions.setVar('evaluationResult', 0);
                    notificationBarService.getLoadStatus().done();
                    return false;
                });
            };
            var sendFeatureIndicator = function (successCallBack) {
                var formValueIndicator = angular.element('#form_feature_indicator');
                var formData = formValueIndicator.serialize();
                var url = Routing.generate('pequiven_feature_indicator_add', {idIndicator: $scope.indicator.id});
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    $scope.templateOptions.setVar('evaluationResult', data.result);
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    return true;
                }).error(function (data, status, headers, config) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (data.errors) {
                        if (data.errors.errors) {
                            $.each(data.errors.errors, function (index, value) {
                                notifyService.error(Translator.trans(value));
                            });
                        }
                        $scope.templateOptions.setVar("form", {errors: data.errors.children});
                    }
                    $scope.templateOptions.setVar('evaluationResult', 0);
                    notificationBarService.getLoadStatus().done();
                    return false;
                });
            };
            $scope.templateOptions.setVar('evaluateFormula', evaluateFormula);
            $scope.templateOptions.setVar('sendFeatureIndicator', sendFeatureIndicator);
            $scope.templateOptions.setVar('evaluationResult', 0);
            var confirmCallBack = function () {
                evaluateFormula(true, function (data) {
                    $scope.indicator = data.indicator;
                });
                return true;
            };
            var confirmCallBack2 = function () {
                sendFeatureIndicator(function (data) {
                    $scope.indicator = data.indicator;
                });
                return true;
            };
            $scope.initForm = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                var parameters = {
                    idIndicator: $scope.indicator.id,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_value_indicator_get_form', parameters);
                var url2 = Routing.generate('pequiven_feature_indicator_get_form', parameters);
                $scope.templates = [
                    {
                        name: 'pequiven.modal.title.value_indicator',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    },
                    {
                        name: 'SEIP',
                        url: url2,
                        confirmCallBack: confirmCallBack2,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            var initCallBack = function () {
                return false;
            };
            $scope.getUrlForValueIndicator = function (valueIndicator, numResult)
            {
                var url = Routing.generate('pequiven_value_indicator_show_detail', {id: valueIndicator.id, numResult: (numResult + 1)});
                return url;
            };
            $scope.openPopUp = function (url) {
                var horizontalPadding = 10;
                var verticalPadding = 10;
                var width = 1200;
                var heigth = 600;
                $('<iframe id="site" src="' + url + '" style="padding:0"/>').dialog({
                    title: 'SEIP',
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
            };
        })
        .controller("MainContentController", function ($scope, notificationBarService, sfTranslator, $timeout) {

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
                angular.forEach(data, function (val, i) {
                    if (val != undefined) {
                        if (val.id == idEntity) {
                            selected = val;
                            j = i;
                        }
                    }
                    i++;
                });
                $("#" + idSelect2).select2('val', j);
                if (callBack) {
                    callBack(data[j]);
                }
                $timeout(function () {
                    $("#" + idSelect2).trigger("change");
                });
//                    $("#"+idSelect2).trigger("select2-selecting");
            };
            //Pre seleccionar elementos en un select2 simple
            $scope.setPreselectedData = function (id, data, model) {
                var preselected = [];
                $.each(data, function (index, value) {
                    preselected.push(value.id);
                });
                $(function () {
                    angular.element('#' + id).select2('data', data);
                    angular.element('#' + id).select2('val', preselected);
                });
                $scope.model[model] = data;
                $timeout(function () {
                    $scope.$apply();
                });
            };
            //Funcion para remover un elemento de un array
            Array.prototype.remove = function (value) {
                var idx = this.indexOf(value);
                if (idx != -1) {
                    return this.splice(idx, 1);
                }
                return false;
            };
            //Verifica si existe un elemento en un array
            Array.prototype.contains = function (value) {
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
            $scope.templateOptions.setConfirmCallBack = function (callBack) {
                $scope.template.confirmCallBack = callBack;
            };
            $scope.templateOptions.enableModeEdit = function () {
                $scope.template.modeEdit = true;
            };
            $scope.templateOptions.setParameterCallBack = function (parameterCallBack) {
                $scope.template.parameterCallBack = parameterCallBack;
            };
            $scope.templateOptions.setUrl = function (callBack) {
                $scope.template.url = callBack;
            };
            $scope.templateOptions.setTemplate = function (template) {
                $scope.template = template;
            };
            $scope.templateOptions.setData = function (data) {
                $scope.data = data;
            };
            $scope.templateOptions.setModel = function (model) {
                $scope.model = model;
            };
            $scope.templateOptions.setVar = function (name, object) {
                $scope[name] = object;
            };
            $scope.templateOptions.getTemplate = function () {
                return $scope.template;
            };
            var modalOpen, modalConfirm;
            jQuery(document).ready(function () {
                var angular = jQuery("#dialog-form");
                if (angular) {
                    modalOpen = angular.dialog({
                        autoOpen: false,
                        height: 650,
                        width: 800,
                        modal: true,
                        buttons: {
                            "Add": confirm,
                            Cancel: function () {
                                modalOpen.dialog("close");
                            }
                        },
                        close: function () {
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
                        Si: function () {
                            $(this).dialog("close");
                        },
                        No: function () {
                            $(this).dialog("close");
                        }
                    }
                });
            });
            $scope.templateLoad = function (template) {
                template.load = true;
                if (template.initCallBack) {
                    if (template.initCallBack()) {
                        return openModal();
                    }
                } else {
                    return openModal();
                }
            };
            $scope.openModalAuto = function (callback) {
                notificationBarService.getLoadStatus().loading();
                if ($scope.template.load == true) {
                    openModal(callback);
                }
            };
            function openModal(callback) {
                if ($scope.template.name) {
                    modalOpen.dialog("option", "title", sfTranslator.trans($scope.template.name));
                }

                if ($scope.template.modeEdit) {
                    $scope.template.modeEdit = false;
                    // setter
                    modalOpen.dialog("option", "buttons", [
                        {text: "Guardar", click: function () {
                                if ($scope.template.confirmCallBack) {
                                    if ($scope.template.confirmCallBack()) {
                                        modalOpen.dialog("close");
                                    }
                                } else {
                                    modalOpen.dialog("close");
                                }
                            }},
                        {text: "Cancelar", click: function () {
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
                        {text: "Añadir", click: function () {
                                if ($scope.template.confirmCallBack) {
                                    if ($scope.template.confirmCallBack()) {
                                        modalOpen.dialog("close");
                                    }
                                } else {
                                    modalOpen.dialog("close");
                                }
                                $timeout(function () {
                                    $scope.$apply();
                                });
                            }},
                        {text: "Cancelar", click: function () {
                                modalOpen.dialog("close");
                                $timeout(function () {
                                    $scope.$apply();
                                });
                            }
                        }
                    ]);
                }
                modalOpen.dialog("open");
                if ($scope.template.loadCallBack) {
                    $scope.template.loadCallBack($scope.template.parameterCallBack);
                }
                $scope.template.parameterCallBack = null;
                if (callback) {
                    callback();
                }
                notificationBarService.getLoadStatus().done();
            }

            $scope.openModalConfirm = function (content, confirmCallBack, cancelCallBack) {
                $scope.dialog.confirm.content = sfTranslator.trans(content);
                // setter
                modalConfirm.dialog("option", "buttons", [
                    {text: "Si", click: function () {
                            if (confirmCallBack) {
                                confirmCallBack();
                                modalConfirm.dialog("close");
                                $scope.$apply();
                            } else {
                                modalConfirm.dialog("close");
                            }
                        }},
                    {text: "No", click: function () {
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
            $scope.printFormErrors = function (formErrors) {
                if (formErrors !== undefined && formErrors.errors !== undefined) {
                    var divError = '<div class="alert alert-danger">';
                    angular.forEach(formErrors.errors, function (error) {
                        divError += error;
                        divError += '<br />';
                    });
                    divError += '</div>';
                    return divError;
                }
            };
        })
        .controller('TableObjetiveController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.data = {
                objetiveStatusLabels: null,
                first_line_managements: null,
                second_line_managements: null,
                complejos: null
            };
            $scope.model = {
                objetiveStatus: null,
                complejo: null,
                firstLineManagement: null,
                secondLineManagement: null
            };
            //Carga de Filtro Localidad
            $http.get(Routing.generate('pequiven_arrangementprogram_data_complejos'))
                    .success(function (data) {
                        $scope.data.complejos = data;
                        if ($scope.model.complejo != null) {
                            $scope.setValueSelect2("selectComplejos", $scope.model.complejo, $scope.data.complejos, function (selected) {
                                $scope.model.complejo = selected;
                                $scope.getFirstLineManagement($scope.model.complejo);
//                            if($scope.model.firstLineManagement != undefined){
//                                $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.model.complejo.gerencias, function(selected) {
//                                    $scope.model.firstLineManagement = selected;
//                                });
//                            }
                            });
                        }
                    });
            // Filtro Gerencia 1ra Línea
            $scope.getFirstLineManagement = function (complejo) {
                var parameters = {
                    filter: {}
                };
                if (complejo != undefined) {
                    parameters.filter['complejo'] = complejo;
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_first_line_management', parameters))
                        .success(function (data) {
                            $scope.data.first_line_managements = data;
                            if ($scope.model.firstLineManagement != null) {
                                $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.data.first_line_managements, function (selected) {
                                    $scope.model.firstLineManagement = selected;
                                });
//                            var selectFirstLineManagement = angular.element('#firstLineManagement');
                            }
                        });
            };
            $scope.getFirstLineManagement();
//            
            //Filtro Gerencia 2da Línea
            $scope.getSecondLineManagement = function (gerencia, complejo) {
                var parameters = {
                    filter: {}
                };
                if (gerencia != undefined) {
                    parameters.filter['gerencia'] = gerencia;
                    console.log(gerencia);
                } else {
                    if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                        parameters.filter['complejo'] = $scope.model.complejo.id;
                    }
                }
                $http.get(Routing.generate('pequiven_arrangementprogram_data_second_line_management', parameters))
                        .success(function (data) {
                            $scope.data.second_line_managements = data;
                            if ($scope.model.secondLineManagement != null) {
                                $scope.setValueSelect2("secondLineManagement", $scope.model.secondLineManagement, $scope.data.second_line_managements, function (selected) {
                                    $scope.model.secondLineManagement = selected;
                                });
                            }
                        });
            };
            $scope.getSecondLineManagement();
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
//                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            });
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
//                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
                }
            });
            $scope.$watch("model.secondLineManagement", function (newParams, oldParams) {
                if ($scope.model.secondLineManagement != null && $scope.model.secondLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['secondLineManagement'] = $scope.model.secondLineManagement.id;
//                    $scope.resetViewNotified();
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                }
            });
            $scope.$watch("model.objetiveStatus", function (newParams, oldParams) {
                if ($scope.model.objetiveStatus != null && $scope.model.objetiveStatus.id != undefined) {
                    $scope.tableParams.$params.filter['status'] = $scope.model.objetiveStatus.id;
                } else {
                    $scope.tableParams.$params.filter['status'] = null;
                }
            });
//            $scope.gerenciaSecond = null;
//            $scope.gerenciaFirst = null;
//            var gerencia = 0;
//            $scope.$watch("gerenciaFirst", function() {
//                if ($scope.gerenciaFirst != null && $scope.gerenciaFirst != undefined)
//                {
//                    if(gerencia != $scope.gerenciaFirst){
//                        gerencia = $scope.gerenciaFirst;
//                        $scope.tableParams.$params.filter['gerenciaSecond'] = null;
//                    }
//                    $scope.tableParams.$params.filter['gerenciaFirst'] = $scope.gerenciaFirst;
//                } else {
//                    $scope.tableParams.$params.filter['gerenciaFirst'] = null;
//                }
//            });
//            $scope.$watch("gerenciaSecond", function() {
//                if ($scope.gerenciaSecond != null && $scope.gerenciaSecond != undefined)
//                {
//                    $scope.tableParams.$params.filter['gerenciaSecond'] = $scope.gerenciaSecond;
//                } else {
//                    $scope.tableParams.$params.filter['gerenciaSecond'] = null;
//                }
//            });
        })
        .controller("ObjetiveStrategicController", function ($scope, notificationBarService, $http, $filter, $timeout) {
            var form = angular.element('#registerObjetiveStrategicForm');
        })
        .controller('TableObjetiveStrategicController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

        })
        .controller('TableObjetiveTacticController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.gerenciaFirst = null;
            $scope.$watch("gerenciaFirst", function () {
                if ($scope.gerenciaFirst != null && $scope.gerenciaFirst != undefined)
                {
                    $scope.tableParams.$params.filter['gerencia'] = $scope.gerenciaFirst;
                } else {
                    $scope.tableParams.$params.filter['gerencia'] = null;
                }
            });
        })
        .controller('TableObjetiveOperativeController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.gerenciaSecond = null;
            $scope.gerenciaFirst = null;
            var gerencia = 0;
            $scope.$watch("gerenciaFirst", function () {
                if ($scope.gerenciaFirst != null && $scope.gerenciaFirst != undefined)
                {
                    if (gerencia != $scope.gerenciaFirst) {
                        gerencia = $scope.gerenciaFirst;
                        $scope.tableParams.$params.filter['gerenciaSecond'] = null;
                    }
                    $scope.tableParams.$params.filter['gerenciaFirst'] = $scope.gerenciaFirst;
                } else {
                    $scope.tableParams.$params.filter['gerenciaFirst'] = null;
                }
            });
            $scope.$watch("gerenciaSecond", function () {
                if ($scope.gerenciaSecond != null && $scope.gerenciaSecond != undefined)
                {
                    $scope.tableParams.$params.filter['gerenciaSecond'] = $scope.gerenciaSecond;
                } else {
                    $scope.tableParams.$params.filter['gerenciaSecond'] = null;
                }
            });
        })
        .controller('TableIndicatorController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            var fieldLevel = angular.element('#level');
            var level = fieldLevel.val();
            var selectComplejo = angular.element("#selectComplejos");
            var selectFirstLineManagement = angular.element("#selectFirstLineManagement");
            var selectSecondLineManagement = angular.element("#selectSecondLineManagement");
            var selectExclude = angular.element('#excludeGerenciaSecondSupport');
            var selectInclude = angular.element('#includeGerenciaSecondSupport');
            var sectionExcludeGerenciaSecondSupport = angular.element("#sectionExcludeGerenciaSecondSupport");
            var sectionIncludeGerenciaSecondSupport = angular.element("#sectionIncludeGerenciaSecondSupport");
            $scope.data = {
                complejos: null,
                first_line_managements: null,
                second_line_managements: null,
                indicatorSummaryLabels: null
            };
            $scope.model = {
                complejo: null,
                firstLineManagement: null,
                secondLineManagement: null,
                indicatorMiscellaneous: null
            };
            //Carga de Configuración por defecto
            $scope.initPage = function () {
                selectSecondLineManagement.select2("enable", false);
            };
            $scope.initPage();
            //Busca las localidades
            $scope.getComplejos = function () {
                var parameters = {
                    filter: {}
                };
                $http.get(Routing.generate('pequiven_seip_complejos', parameters))
                        .success(function (data) {
                            $scope.data.complejos = data;
                            if ($scope.model.complejo != null) {
                                $scope.setValueSelect2("selectComplejos", $scope.model.complejo, $scope.data.complejos, function (selected) {
                                    $scope.model.complejo = selected;
                                });
                            }
                        });
            };
            //Busca las Gerencias de 1ra Línea
            $scope.getFirstLineManagement = function (complejo) {
                var parameters = {
                    filter: {}
                };
                if ($scope.model.complejo != null) {
                    parameters.filter['complejo'] = $scope.model.complejo.id;
                }
                $http.get(Routing.generate('pequiven_seip_first_line_management', parameters))
                        .success(function (data) {
                            $scope.data.first_line_managements = data;
                            if ($scope.model.firstLineManagement != null) {
                                $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.data.first_line_managements, function (selected) {
                                    $scope.model.firstLineManagement = selected;
                                });
                            }
                        });
            };
            //Busca las Gerencias de 2da Línea
            $scope.getSecondLineManagement = function (gerencia) {
                var parameters = {
                    filter: {}
                };
                if ($scope.model.firstLineManagement != null) {
                    parameters.filter['gerencia'] = $scope.model.firstLineManagement.id;
                }

                if (selectExclude.is(':checked')) {
                    parameters.filter['type_gerencia_support'] = 'TYPE_WITHOUT_GERENCIA_SECOND_SUPPORT';
                    parameters.filter['complejo'] = $scope.model.complejo.id;
                } else {

                }

                if (selectInclude.is(':checked')) {
                    parameters.filter['type_gerencia_support'] = 'TYPE_WITH_GERENCIA_SECOND_SUPPORT';
                    parameters.filter['gerencia'] = $scope.model.firstLineManagement.id;
                } else {

                }

                $http.get(Routing.generate('pequiven_seip_second_line_management', parameters))
                        .success(function (data) {
                            $scope.data.second_line_managements = data;
                            if ($scope.model.secondLineManagement != null) {
                                $scope.setValueSelect2("secondLineManagement", $scope.model.secondLineManagement, $scope.data.second_line_managements, function (selected) {
                                    $scope.model.secondLineManagement = selected;
                                });
                            }
                        });
            };
            //Al hacer click en el check de exclusión de gerencias de apoyo
            $scope.excludeGerenciaSecondSupport = function () {
                if (selectExclude.is(':checked')) {
                    if ($scope.model.firstLineManagement != null) {
                        $scope.getSecondLineManagement();
                        selectSecondLineManagement.select2("val", '');
                        $scope.tableParams.$params.filter['type_gerencia_support'] = 'TYPE_WITHOUT_GERENCIA_SECOND_SUPPORT';
                    } else {
                        $scope.tableParams.$params.filter['type_gerencia_support'] = 'TYPE_WITHOUT_GERENCIA_SECOND_SUPPORT';
                    }
                } else {
                    $scope.getSecondLineManagement();
                    selectSecondLineManagement.select2("val", '');
                    $scope.tableParams.$params.filter['type_gerencia_support'] = null;
                }
            };
            $scope.includeGerenciaSecondSupport = function () {
                if (selectInclude.is(':checked')) {
                    $scope.getSecondLineManagement();
                    selectSecondLineManagement.select2("val", '');
                    $scope.tableParams.$params.filter['type_gerencia_support'] = 'TYPE_WITH_GERENCIA_SECOND_SUPPORT';
                } else {
                    $scope.getSecondLineManagement();
                    selectSecondLineManagement.select2("val", '');
                    $scope.tableParams.$params.filter['type_gerencia_support'] = null;
                }
            };
            if (level == 1) {

            } else if (level > 1) {
                $scope.getComplejos();
                $scope.getFirstLineManagement();
            } else if (level > 2) {
                $scope.getSecondLineManagement();
            }

            //Scope de Localidad
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                    if (level > 2) {
                        if ($scope.model.complejo.ref == 'CORP.') {
                            sectionExcludeGerenciaSecondSupport.show();
                            sectionIncludeGerenciaSecondSupport.hide();
                        } else {
                            sectionExcludeGerenciaSecondSupport.hide();
                            sectionIncludeGerenciaSecondSupport.show();
                        }
                    }
                    //Al cambiar el select de localidad
                    selectComplejo.change(function () {
                        selectFirstLineManagement.select2("val", '');
                        if (level > 2) {//Nivel Operativo
                            selectSecondLineManagement.select2("val", '');
                        }
                    });
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                    selectExclude.prop("checked", false);
                    selectSecondLineManagement.select2("enable", false);
                    selectSecondLineManagement.select2("val", '');
                }
            });
            //Scope de Gerencia de 1ra Línea
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                    selectSecondLineManagement.select2("enable", true);
                    if ($scope.model.firstLineManagement.gerenciaGroup.groupName == 'CORP') {
                        sectionExcludeGerenciaSecondSupport.show();
                        sectionIncludeGerenciaSecondSupport.hide();
                    } else if ($scope.model.firstLineManagement.gerenciaGroup.groupName == 'COMP') {
                        sectionExcludeGerenciaSecondSupport.hide();
                        sectionIncludeGerenciaSecondSupport.show();
                    }
                    //Al cambiar la gerencia de 1ra línea
                    selectFirstLineManagement.change(function () {
                        if (level > 2) {
                            selectSecondLineManagement.select2("val", '');
                        }
                    });
                } else {
                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
                    selectSecondLineManagement.select2("enable", false);
                    selectSecondLineManagement.select2("val", '');
                }
            });
            //Scope de Gerencia de 2da Línea
            $scope.$watch("model.secondLineManagement", function (newParams, oldParams) {
                if ($scope.model.secondLineManagement != null && $scope.model.secondLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['secondLineManagement'] = $scope.model.secondLineManagement.id;
                    selectExclude.prop("checked", false);
                    selectInclude.prop("checked", false);
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                    $scope.tableParams.$params.filter['type_gerencia_support'] = null;
                }
            });
            //Scope de Misceláneo                                                              
            $scope.$watch("model.indicatorMiscellaneous", function (newParams, oldParams) {
                if ($scope.model.indicatorMiscellaneous != null && $scope.model.indicatorMiscellaneous.id != undefined) {
                    $scope.tableParams.$params.filter['miscellaneous'] = $scope.model.indicatorMiscellaneous.id;
                } else {
                    $scope.tableParams.$params.filter['miscellaneous'] = null;
                }
            });
        })
        .controller('TableIndicatorWithErrorController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

        })
        .controller('TableIndicatorStrategicController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

        })
        .controller('TableIndicatorTacticController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.gerenciaFirst = null;
            $scope.$watch("gerenciaFirst", function () {
                if ($scope.gerenciaFirst != null && $scope.gerenciaFirst != undefined)
                {
                    $scope.tableParams.$params.filter['gerencia'] = $scope.gerenciaFirst;
                } else {
                    $scope.tableParams.$params.filter['gerencia'] = null;
                }
            });
        })
        .controller('TableIndicatorOperativeController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.gerenciaSecond = null;
            $scope.gerenciaFirst = null;
            var gerencia = 0;
            $scope.$watch("gerenciaFirst", function () {
                if ($scope.gerenciaFirst != null && $scope.gerenciaFirst != undefined)
                {
                    if (gerencia != $scope.gerenciaFirst) {
                        gerencia = $scope.gerenciaFirst;
                        $scope.tableParams.$params.filter['gerenciaSecond'] = null;
                    }
                    $scope.tableParams.$params.filter['gerenciaFirst'] = $scope.gerenciaFirst;
                } else {
                    $scope.tableParams.$params.filter['gerenciaFirst'] = null;
                }
            });
            $scope.$watch("gerenciaSecond", function () {
                if ($scope.gerenciaSecond != null && $scope.gerenciaSecond != undefined)
                {
                    $scope.tableParams.$params.filter['gerenciaSecond'] = $scope.gerenciaSecond;
                } else {
                    $scope.tableParams.$params.filter['gerenciaSecond'] = null;
                }
            });
        })
        .controller('TableMonitorTypeGroupController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            //Porcentaje Cargado
            $scope.porcCargado = function (data) {
                var res = 0;
                res = (data.RealObjTactic / data.PlanObjTactic) * 100;
                //res = parseFloat(res).toFixed(2);
                return res;
            };
            $scope.textType = function (data) {

            };
            //Total Planificados
            $scope.totalizePlan = function (data) {
                var cont = parseInt(0);
                angular.forEach(data, function (value) {
                    cont = cont + parseInt(value.PlanObjTactic);
                });
                return cont;
            };
            //Total Cargados
            $scope.totalizeReal = function (data) {
                var cont = parseInt(0);
                angular.forEach(data, function (value) {
                    cont = cont + parseInt(value.RealObjTactic);
                });
                return cont;
            };
            //Porcentaje Cargados
            $scope.totalizeCargado = function (totalPlan, totalReal) {
                var res = 0;
                res = (totalReal / totalPlan) * 100;
                //res = parseFloat(res).toFixed(2);
                return res;
            }
            $scope.semaforo = function (data) {

            }
        })
        .controller('TableMonitorTacticController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.totalizePlan = function (data) {
                var cont = 0;
                angular.forEach(data, function (value) {
                    cont = cont + value.objTacticOriginal;
                });
                return cont;
            };
        })

        //Controlador para los gráficos a mostrar en el dashboard del indicador
        .controller('ChartsDashboardController', function ($scope, $http) {

            //Gráfico en forma de dona para mostrar los indicadores asociados (Resumen, Referencia y Resultado de la Medición)
            $scope.chargeChartDoughnut2dIndicatorsAssociated = function (indicatorId, render, width, height) {
//                var getDataChartDoughnut = Routing.generate("getDataChartDoughnut", {id: indicatorId});
//                $scope.chartDoughnut2d = {};
//                $http.get(getDataChartDoughnut).success(function (data) {
//                    $scope.chartDoughnut2d = {
//                        "chart": data.dataSource.chart,
//                        "data": data.dataSource.dataSet
//                    }
//                });
                var getDataChartDoughnutIndicatorsAssociated = Routing.generate("getDataChartDoughnutIndicatorsAssociated", {id: indicatorId});
                $http.get(getDataChartDoughnutIndicatorsAssociated).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartDoughnutIndicatorsAssociated = new FusionCharts({
                            "type": "doughnut2d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.dataSet
                            }
                        });
                        revenueChartDoughnutIndicatorsAssociated.setTransparent(true);
                        revenueChartDoughnutIndicatorsAssociated.render();
                    });
                });
            }

            //Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), de los indicadores asociados
            $scope.chargeChartColumnLineDualAxisIndicatorsAssociated = function (indicatorId, render, width, height) {
                var getDataChartColumnLineDualAxisIndicatorsAssociated = Routing.generate("getDataChartColumnLineDualAxisIndicatorsAssociated", {id: indicatorId});
                $http.get(getDataChartColumnLineDualAxisIndicatorsAssociated).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnLineDualAxisIndicatorsAssociated = new FusionCharts({
                            "type": "mscolumn3dlinedy",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset
                            }
                        });
                        revenueChartColumnLineDualAxisIndicatorsAssociated.setTransparent(true);
                        revenueChartColumnLineDualAxisIndicatorsAssociated.render();
                    });
                });
            }
            
            //Gráfico en forma de dona para mostrar las variables plan y real a partir de ecuación de la fórmula del indicador
            $scope.chargeChartDoughnut2dWithVariablesFromEquation = function (indicatorId, render, width, height)  {
                var getdataChartDoughnut2dWithVariablesFromEquation = Routing.generate("getDataChartDoughnutWithVariablesFromEquation", {id: indicatorId});
                $http.get(getdataChartDoughnut2dWithVariablesFromEquation).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartDoughnut2dWithVariablesFromEquation = new FusionCharts({
                            "type": "doughnut2d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.dataSet
                            }
                        });
                        revenueChartDoughnut2dWithVariablesFromEquation.setTransparent(true);
                        revenueChartDoughnut2dWithVariablesFromEquation.render();
                    });
                });
            }
            
            //Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), del indicador
            $scope.chargeChartColumnLineDualAxisRealPlan = function (indicatorId, render, width, height) {
                var getDataChartColumnLineDualAxisRealPlan = Routing.generate("getDataChartColumnLineDualAxisRealPlan", {id: indicatorId});
                $http.get(getDataChartColumnLineDualAxisRealPlan).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnLineDualAxisRealPlan = new FusionCharts({
                            "type": "mscolumn3dlinedy",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset
                            }
                        });
                        revenueChartColumnLineDualAxisRealPlan.setTransparent(true);
                        revenueChartColumnLineDualAxisRealPlan.render();
                    });
                });
            }

            //Gráfico en forma de dona para mostrar las variables plan y real a partir de ecuación de la fórmula del indicador
            $scope.chargeChartDoughnut2dWithVariablesRealPlan = function (indicatorId, render, width, height)  {
                var getdataChartDoughnut2dWithVariablesRealPlan = Routing.generate("getDataChartDoughnutWithVariablesRealPlan", {id: indicatorId});
                $http.get(getdataChartDoughnut2dWithVariablesRealPlan).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartDoughnut2dWithVariablesRealPlan = new FusionCharts({
                            "type": "doughnut2d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.dataSet
                            }
                        });
                        revenueChartDoughnut2dWithVariablesRealPlan.setTransparent(true);
                        revenueChartDoughnut2dWithVariablesRealPlan.render();
                    });
                });
            }

            //Gráfico en forma de dona para mostrar las variables de la fórmula del indicador
            $scope.chargeChartPieVariablesOrTags = function (indicatorId, render, width, height) {
                var getDataChartPieVariablesOrTags = Routing.generate("getDataChartPieVariablesOrTags", {id: indicatorId});
                $http.get(getDataChartPieVariablesOrTags).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartTactic = new FusionCharts({
                            "type": "pie2d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset
                            }
                        });
                        revenueChartTactic.setTransparent(true);
                        revenueChartTactic.render();
                    });
                });
            }

            //Gráfico para mostrar las variables (sumativas al plan) de un indicador con fórmula a partir de ecuación
            $scope.chargeChartPieVariablesPlanFromEquation = function (indicatorId, render, width, height) {
                var getDataChartPieVariablesPlanFromEquation = Routing.generate("getDataChartPieVariablesPlanFromEquation", {id: indicatorId});
                $http.get(getDataChartPieVariablesPlanFromEquation).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartPieVariablesPlanFromEquation = new FusionCharts({
                            "type": "pie3d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.data,
                            }
                        });
                        revenueChartPieVariablesPlanFromEquation.setTransparent(true);
                        revenueChartPieVariablesPlanFromEquation.render();
                    });
                });
            }
            
            //Gráfico para mostrar las variables (sumativas al real) de un indicador con fórmula a partir de ecuación
            $scope.chargeChartPieVariablesRealFromEquation = function (indicatorId, render, width, height) {
                var getDataChartPieVariablesRealFromEquation = Routing.generate("getDataChartPieVariablesRealFromEquation", {id: indicatorId});
                $http.get(getDataChartPieVariablesRealFromEquation).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartPieVariablesRealFromEquation = new FusionCharts({
                            "type": "pie3d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.data,
                            }
                        });
                        revenueChartPieVariablesRealFromEquation.setTransparent(true);
                        revenueChartPieVariablesRealFromEquation.render();
                    });
                });
            }
            
            //Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), del indicador
            $scope.chargeChartColumnLineDualAxisByFrequencyNotification = function (indicatorId, render, width, height) {
                var getDataChartColumnLineDualAxisByFrequencyNotification = Routing.generate("getDataChartColumnLineDualAxisByFrequencyNotification", {id: indicatorId});
                $http.get(getDataChartColumnLineDualAxisByFrequencyNotification).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnLineDualAxisByFrequencyNotification = new FusionCharts({
                            "type": "mscolumn3dlinedy",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset
                            }
                        });
                        revenueChartColumnLineDualAxisByFrequencyNotification.setTransparent(true);
                        revenueChartColumnLineDualAxisByFrequencyNotification.render();
                    });
                });
            }
        })

        .controller('ToolsController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.isGrantedButtonEdit = function (id,index) {
                //index = index+1;
                var data;;
                var getdataBarsArea = Routing.generate("getIsGrantEditButton", {id: id,index:index});
                $http.get(getdataBarsArea).success(function (data) {
                    //console.log(index+"->"+data);
                    //console.log(data);
                    if(data=="1") {
                        $("div#target_"+index).show();
                    } 
                });

            }
        })

        .controller('DashboardController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

            $scope.renderChartTactic = function (id, categories, dataPlanTactic, dataRealTactic, dataPorcTactic, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChartTactic = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        "renderAt": id,
                        "width": "100%",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                "caption": caption,
                                "xAxisName": Translator.trans('chart.objetives.xAxisName'),
                                "pYAxisName": Translator.trans('chart.objetives.pYAxisName'),
                                "sYAxisName": Translator.trans('chart.objetives.sYAxisName'),
                                "sYAxisMaxValue": "100",
                                "sYAxisMinValue": "0",
                                "showValues": "1",
                                "placeValuesInside": "0",
                                "valueFontColor": "#000000",
                                "rotateValues": "0",
                                "labelDisplay": typeLabelDisplay,
                                "sNumberSuffix": "%",
                                "bgAlpha": "0,0",
                                "baseFontColor": "#ffffff",
                                "outCnvBaseFontColor": "#ffffff",
                                "theme": "fint"
                            },
                            "categories": [
                                {
                                    "category": categories
                                }
                            ],
                            "dataset": [
                                {
                                    "seriesname": Translator.trans("chart.objetives.seriesNamePlan"),
                                    "parentYAxis": "P",
                                    "data": dataPlanTactic
                                },
                                {
                                    "seriesname": Translator.trans("chart.objetives.seriesNameReal"),
                                    "parentYAxis": "P",
                                    "data": dataRealTactic
                                },
                                {
                                    "seriesname": Translator.trans("chart.objetives.seriesNameCarga"),
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
            $scope.renderChartOperative = function (id, categories, dataPlanOperative, dataRealOperative, dataPorcOperative, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChartOperative = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        "renderAt": id,
                        "width": "100%",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                "caption": caption,
                                "xAxisName": Translator.trans('chart.objetives.xAxisName'),
                                "pYAxisName": Translator.trans('chart.objetives.pYAxisName'),
                                "sYAxisName": Translator.trans('chart.objetives.sYAxisName'),
                                "sYAxisMaxValue": "100",
                                "sYAxisMinValue": "0",
                                "showValues": "1",
                                "placeValuesInside": "0",
                                "valueFontColor": "#000000",
                                "rotateValues": "0",
                                "labelDisplay": typeLabelDisplay,
                                "sNumberSuffix": "%",
                                "bgAlpha": "0,0",
                                "baseFontColor": "#ffffff",
                                "outCnvBaseFontColor": "#ffffff",
                                "visible": "0",
                                "theme": "fint"
                            },
                            "categories": [
                                {
                                    "category": categories
                                }
                            ],
                            "dataset": [
                                {
                                    "seriesname": Translator.trans("chart.objetives.seriesNamePlan"),
                                    "parentYAxis": "P",
                                    "data": dataPlanOperative
                                },
                                {
                                    "seriesname": Translator.trans("chart.objetives.seriesNameReal"),
                                    "parentYAxis": "P",
                                    "data": dataRealOperative
                                },
                                {
                                    "seriesname": Translator.trans("chart.objetives.seriesNameCarga"),
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
            $scope.renderChartArrangementProgram = function (id, categories, dataPlan, dataReal, dataPorc, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        "renderAt": id,
                        "width": "100%",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                "caption": caption,
                                "xAxisName": Translator.trans('chart.arrangementPrograms.xAxisName'),
                                "pYAxisName": Translator.trans('chart.arrangementPrograms.pYAxisName'),
                                "sYAxisName": Translator.trans('chart.arrangementPrograms.sYAxisName'),
                                "sYAxisMaxValue": "100",
                                "sYAxisMinValue": "0",
                                "showValues": "1",
                                "placeValuesInside": "0",
                                "valueFontColor": "#000000",
                                "rotateValues": "0",
                                "labelDisplay": typeLabelDisplay,
                                "sNumberSuffix": "%",
                                "bgAlpha": "0,0",
                                "baseFontColor": "#ffffff",
                                "outCnvBaseFontColor": "#ffffff",
                                "visible": "0",
                                "theme": "fint",
                                "formatNumberScale": "0",
                            },
                            "categories": [
                                {
                                    "category": categories
                                }
                            ],
                            "dataset": [
                                {
                                    "seriesname": Translator.trans("chart.arrangementPrograms.seriesNamePlan"),
                                    "parentYAxis": "P",
                                    "data": dataPlan
                                },
                                {
                                    "seriesname": Translator.trans("chart.arrangementPrograms.seriesNameReal"),
                                    "parentYAxis": "P",
                                    "data": dataReal
                                },
                                {
                                    "seriesname": Translator.trans("chart.arrangementPrograms.seriesNameCarga"),
                                    "parentYAxis": "S",
                                    "renderas": "column",
                                    "data": dataPorc
                                }
                            ]
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            $scope.renderChartResult = function (id, data, gerencia, url) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "stackedbar3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "100%",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                "caption": data.dataSource.chart.caption,
                                "subCaption": data.dataSource.chart.subCaption,
                                "exportenabled": "1",
                                "exportatclient": "0",
                                "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                                "exportFileName": "Grafico Resultados " + gerencia,
                                "exporthandler": "http://107.21.74.91/",
                                "html5exporthandler": "http://107.21.74.91/",
                                "xAxisname": Translator.trans('chart.result.objetiveOperative.xAxisName'),
                                "yAxisName": Translator.trans('chart.result.objetiveOperative.yAxisName'),
                                "showSum": "1",
                                "numberSuffix": "%",
                                "bgAlpha": "0,0",
                                "baseFontColor": "#000000",
                                "bgColor": "#DDDDDD",
                                "outCnvBaseFontColor": "#000000",
                                "valueFontColor": "#000000",
                                "visible": "0",
                                "theme": "fint",
                                "formatNumberScale": "0",
                                "xAxisLineColor": "#ffffff",
                                "yAxisMaxValue": "100",
                                "yAxisMinValue": "0",
                                "stack100Percent": "0",
                                "plotgradientcolor": "",
                                "showalternatehgridcolor": "0",
                                "showplotborder": "0",
                            },
                            "categories": [
                                {
                                    "category": data.dataSource.categories.category
                                }
                            ],
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //Widget de los rangos de gestión de los indicadores
            $scope.renderWidgetRange = function (id, data) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "HLinearGauge",
                        "renderAt": id,
                        "width": "100%",
                        "height": "4%",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "colorRange": {
                                "color": data.dataSource.colorRange.color
                            }
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //Widget de los indicadores en forma de bulbo (Por ejemplo en el dashboard de los indicadores estratégicos)
            $scope.renderWidgetIndicatorStrategic = function (id, data, width, height) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "bulb",
                        "renderAt": id,
                        "width": width,
                        "height": height,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "colorrange": {
                                "color": data.dataSource.colorRange.color
                            }
                        },
                        "value": "0"
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            $scope.renderWidgetMultiLevelPie = function (id, data, width, height) {
                FusionCharts.ready(function () {
                    var widgetMultiLevelPieChart = new FusionCharts({
                        "type": "multilevelpie",
                        "renderAt": id,
                        "width": width,
                        "height": height,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "category": data.dataSource.category
                        }
                    });
                    widgetMultiLevelPieChart.setTransparent(true);
                    widgetMultiLevelPieChart.render();
                })
            };
            //Gráfico en forma de dona para mostrar los indicadores asociados (Resumen, Referencia y Resultado de la Medición)
            $scope.renderWidgetDoughnut2d = function (id, data, width, height) {
                FusionCharts.ready(function () {
                    var widgetDoughnut2d = new FusionCharts({
                        "type": "doughnut2d",
                        "renderAt": id,
                        "width": width,
                        "height": height,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "data": data.dataSource.dataSet
                        }
                    });
                    widgetDoughnut2d.setTransparent(true);
                    widgetDoughnut2d.render();
                })
            };
            //Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual)
            $scope.renderChartColumnLineDualAxis = function (id, data) {
                FusionCharts.ready(function () {
                    var chartColumnLineDualAxis = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        "renderAt": id,
                        "width": "100%",
                        "height": "500",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset,
                        }
                    });
                    chartColumnLineDualAxis.setTransparent(true);
                    chartColumnLineDualAxis.render();
                })
            }

            $scope.renderChartColumnLineSingleAxis = function (id, data) {
                FusionCharts.ready(function () {
                    var chartColumnLineSingleAxis = new FusionCharts({
                        "type": "MSColumnLine3D",
                        "renderAt": id,
                        "width": "100%",
                        "height": "500",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset,
                        }
                    });
                    chartColumnLineSingleAxis.setTransparent(true);
                    chartColumnLineSingleAxis.render();
                })
            }

            //Gráfico en forma tacómetro (Usado para mostrar el resultado de los indicadores estratégicos en el dashboard)
            $scope.renderChartAngularGauge = function (id, data, width, height) {
                FusionCharts.ready(function () {
                    var chartAngularGauge = new FusionCharts({
                        "type": "angulargauge",
                        "renderAt": id,
                        "width": width,
                        "height": height,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "colorrange": {
                                "color": data.dataSource.colorRange.color
                            },
                            "dials": {
                                "dial": data.dataSource.dials.dial
                            },
                        }
                    });
                    chartAngularGauge.setTransparent(true);
                    chartAngularGauge.render();
                })
            }

            //Gráfico en forma tacómetro (Usado para mostrar el resultado de los indicadores estratégicos en el dashboard)
            $scope.renderChartPie2d = function (id, data, width, height) {
                FusionCharts.ready(function () {
                    var chartPie2d = new FusionCharts({
                        "type": "pie2d",
                        "renderAt": id,
                        "width": width,
                        "height": height,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "data": data.dataSource.data
                        }
                    });
                    chartPie2d.setTransparent(true);
                    chartPie2d.render();
                });
            }

            $scope.renderChartStackedSingleAxis = function (id) {
                FusionCharts.ready(function () {
                    var chartStackedSingleAxis = new FusionCharts({
                        "type": "stackedcolumn3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "500",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                "caption": "% Cumplimiento del Plan Producción Bruta de Fertilizantes",
//                                "subCaption": "Harry's SuperMart",
                                "xAxisname": "Productos",
                                "yAxisName": "TM",
                                "paletteColors": "#0075c2,#1aaf5d",
                                "bgColor": "#ffffff",
                                "borderAlpha": "20",
                                "showCanvasBorder": "0",
                                "usePlotGradientColor": "0",
                                "plotBorderAlpha": "10",
                                "legendBorderAlpha": "0",
                                "legendShadow": "0",
                                "valueFontColor": "#ffffff",
                                "showXAxisLine": "1",
                                "xAxisLineColor": "#999999",
                                "divlineColor": "#999999",
                                "divLineDashed": "1",
                                "showAlternateHGridColor": "0",
                                "subcaptionFontBold": "0",
                                "subcaptionFontSize": "14",
                                "showHoverEffect": "1",
                                "formatNumberScale": "0",
                                "thousandSeparator": ".",
                                "decimalSeparator": ",",
                                "decimals": "2",
                                "labelDisplay": "ROTATE"
                            },
                            "categories": [
                                {
                                    "category": [
                                        {
                                            "label": "Enero"
                                        },
                                        {
                                            "label": "Febrero"
                                        },
                                        {
                                            "label": "Marzo"
                                        },
                                        {
                                            "label": "Abril"
                                        },
                                        {
                                            "label": "Mayo"
                                        },
                                        {
                                            "label": "Junio"
                                        },
                                        {
                                            "label": "Julio"
                                        },
                                        {
                                            "label": "Agosto"
                                        },
                                        {
                                            "label": "Septiembre"
                                        },
                                        {
                                            "label": "Octubre"
                                        },
                                        {
                                            "label": "Noviembre"
                                        },
                                        {
                                            "label": "Diciembre"
                                        }
                                    ]
                                }
                            ],
                            "dataset": [
                                {
                                    "seriesname": "Amoníaco",
                                    "data": [
                                        {
                                            "value": "2582"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "3032"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "8514"
                                        },
                                        {
                                            "value": "4346"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "6634"
                                        },
                                        {
                                            "value": "0"
                                        }
                                    ]
                                },
                                {
                                    "seriesname": "Urea",
                                    "data": [
                                        {
                                            "value": "206"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        },
                                        {
                                            "value": "0"
                                        }
                                    ]
                                }
                            ]
                        }
                    });
                    chartStackedSingleAxis.setTransparent(true);
                    chartStackedSingleAxis.render();
                })
            }
        })
        .controller('TableMonitorOperativeController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

        })
        .controller('TableUserController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

        })
        .controller('UserController', function ($scope, $timeout) {
            var model = {
                arrangementProgramUserToRevisers: [],
                arrangementProgramUsersToApproveTactical: [],
                arrangementProgramUsersToApproveOperative: [],
                arrangementProgramUsersToNotify: [],
                arrangementProgramSigUsersToReviser: [],
                arrangementProgramSigUsersToApprove: [],
                arrangementProgramSigUsersToNotify: []
            };
            $scope.templateOptions.setModel(model);
            var arrangementProgramUsersToApproveTactical = angular.element('#gerencia_configuration_arrangementProgramUsersToApproveTactical');
            arrangementProgramUsersToApproveTactical.change(function () {
                var data = arrangementProgramUsersToApproveTactical.select2('data');
                $scope.model.arrangementProgramUsersToApproveTactical = data;
                $timeout(function () {
                    $scope.$apply();
                });
            });
            var arrangementProgramUserToRevisers = angular.element('#gerencia_configuration_arrangementProgramUserToRevisers');
            arrangementProgramUserToRevisers.change(function () {
                var data = arrangementProgramUserToRevisers.select2('data');
                $scope.model.arrangementProgramUserToRevisers = data;
                $timeout(function () {
                    $scope.$apply();
                });
            });
            var arrangementProgramUsersToApproveOperative = angular.element('#gerencia_configuration_arrangementProgramUsersToApproveOperative');
            arrangementProgramUsersToApproveOperative.change(function () {
                var data = arrangementProgramUsersToApproveOperative.select2('data');
                $scope.model.arrangementProgramUsersToApproveOperative = data;
                $timeout(function () {
                    $scope.$apply();
                });
            });
            var arrangementProgramUsersToNotify = angular.element('#gerencia_configuration_arrangementProgramUsersToNotify');
            arrangementProgramUsersToNotify.change(function () {
                var data = arrangementProgramUsersToNotify.select2('data');
                $scope.model.arrangementProgramUsersToNotify = data;
                $timeout(function () {
                    $scope.$apply();
                });
            });
            var arrangementProgramSigUsersToReviser = angular.element('#gerencia_configuration_arrangementProgramSigUsersToReviser');
            arrangementProgramSigUsersToReviser.change(function () {
                var data = arrangementProgramSigUsersToReviser.select2('data');
                $scope.model.arrangementProgramSigUsersToReviser = data;
                $timeout(function () {
                    $scope.$apply();
                });
            });
            var arrangementProgramSigUsersToApprove = angular.element('#gerencia_configuration_arrangementProgramSigUsersToApprove');
            arrangementProgramSigUsersToApprove.change(function () {
                var data = arrangementProgramSigUsersToApprove.select2('data');
                $scope.model.arrangementProgramSigUsersToApprove = data;
                $timeout(function () {
                    $scope.$apply();
                });
            });
            var arrangementProgramSigUsersToNotify = angular.element('#gerencia_configuration_arrangementProgramSigUsersToNotify');
            arrangementProgramSigUsersToNotify.change(function () {
                var data = arrangementProgramSigUsersToNotify.select2('data');
                $scope.model.arrangementProgramSigUsersToNotify = data;
                $timeout(function () {
                    $scope.$apply();
                });
            });
        })
        .controller('TableGerenciaController', function ($scope) {
            $scope.model = {
                ManagementSystem: []
            };
            $scope.exportToXLS = function (id)
            {
                var parameters = {
                    id: id
                };
                if ($scope.model.ManagementSystem != null && $scope.model.ManagementSystem.id != undefined) {
                    parameters.ManagementSystem = $scope.model.ManagementSystem.id;
                }
                var url = 'pequiven_gerenciafirst_export';
                $scope.urlExport = Routing.generate(url, parameters);
            };
        })
        ;
