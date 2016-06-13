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
                    if (percentaje > 0 && percentaje <= 50) {
                        className = 'red-gradient';
                    } else if (percentaje > 50 && percentaje <= 80) {
                        className = 'orange-gradient';
                    } else if (percentaje > 80) {
                        className = 'green-gradient';
                    }
                } else if (numMeter == 2) {
                    if (percentaje > 50 && percentaje <= 80) {
                        className = 'orange-gradient';
                    } else if (percentaje > 80) {
                        className = 'green-gradient';
                    }
                } else if (numMeter == 3) {
                    if (percentaje > 80) {
                        className = 'green-gradient';
                    }
                }
                return 'meter ' + className;
            };

            //FUNCIÓN UTILIZADA PARA VER LA PENALIZACIÓN EN LA VISTA DE ARRAGEMENT PROGRAM SOLO SI EXISTE
            $scope.getPenaltyForm = function (penalty) {

                if (penalty > 0) {
                    return "";
                } else {
                    return "hideClass";
                }

            };

            //FUNCIÓN UTILIZADA PARA VER EL VALOR REAL SI LA META SOBREPASA EL 120% O CON VALOR NEGATIVO
            $scope.getOverflowForm = function (overflow) {

                if ((overflow < 0) || (overflow > 120)) {
                    return "";
                } else {
                    return "hideClass";
                }

            };

            $scope.getUrlMovement = function (idGoal, url) {

                var redirect = url + "?idGoal=" + idGoal;

                //PENDIENTE AVERIGUAR PORQUE NO SIRVE:
                //var redirect = Routing.generate(url, {idGoal: idGoal});

                location.href = redirect;

            };


            $scope.getUrlMovementAP = function (idAP, url) {

                var redirect = url + "?idAP=" + idAP;

                //PENDIENTE AVERIGUAR PORQUE NO SIRVE:
                //var redirect = Routing.generate(url, {idGoal: idGoal});

                location.href = redirect;

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
            //$scope.setOperationalObjective();

            managementSystem.on('change', function (e) {
                console.log(e.val);
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

        .controller("PlantReportGroupController", function ($scope, notificationBarService, $http, $filter, $timeout, $cookies) {
            var entity = angular.element('#pequiven_seipbundle_dataload_plantreport_group_entity');
            var childrensPlants = angular.element('#pequiven_seipbundle_dataload_plantreport_group_childrensGroup');
            var setUpdate = $("#setUpdate");

            if (setUpdate.val() == 0) {
                console.log(setUpdate.val());
                childrensPlants.select2('val', '');
                childrensPlants.select2('enable', false);
            }

            entity.on('change', function (e) {
                console.log(e.val);
                if (e.val) {
                    var entityId = e.val;
                    childrensPlants.find('option').remove().end();
                    //notificationBarService.getLoadStatus().loading();
                    $http.get(Routing.generate("pequiven_entity_load_data_group", {entityId: entityId})).success(function (data) {
                        childrensPlants.append('<option value="">' + Translator.trans('pequiven.select') + '</option>');
                        //console.log(data);

                        angular.forEach(data, function (value) {
                            //console.log(value.plant);
                            if (value.plant != null) {
                                childrensPlants.append('<option value="' + value.id + '">' + value.plant.name + '</option>');
                            }
                        });
                        if (data.length > 0) {
                            childrensPlants.select2('val', e.val);
                            childrensPlants.select2('enable', true);
                        } else {
                            childrensPlants.select2('val', '');
                            childrensPlants.select2('enable', false);
                        }
                        notificationBarService.getLoadStatus().done();
                    });
                } else {
                    childrensPlants.select2('val', '');
                    childrensPlants.select2('enable', false);
                }
            });


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

        .controller('ListUserItemsController', function ($scope, $http) {
            $scope.model = {users: null};
            $scope.$watch("model.users", function (newParams, oldParams) {
                if ($scope.model.users != null) {
                    var selectedUser = [];
                    var selectedUser = angular.element("#users").select2('data');
                    //console.log(selectedUser["numPersonal"]);
//                    $("input#ruta").val(selectedUser["numPersonal"]);
                    $("input#ruta").val(selectedUser["id"]);
                }
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
        //Controladores SIG
        .controller('IndicatorSigEvolutionController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {
            $scope.urlCausesEvolutionForm = null;
            $scope.indicator = null;
            var isInit = false;

            //Carga del formulario para la relacion del indicador 2014
            $scope.loadTemplateAnalysisTrend = function (resource) {
                $scope.initFormTrend(resource);
                if (isInit == false) {
                    isInit = true;
                }

                $scope.templateOptions.setParameterCallBack(resource);

                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario del plan de Acción
            $scope.loadTemplateActionEvolution = function (resource) {
                $scope.initFormActionAdd(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setParameterCallBack(resource);

                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga del formulario para actualizar los resultados
            $scope.loadTemplateActionAdd = function (resource) {
                $scope.initFormAction(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setParameterCallBack(resource);

                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario de las Causas de Desviacion
            $scope.loadTemplateCausesDesviation = function (resource) {
                $scope.initFormCausesAdd(resource);
                if (isInit == false) {
                    isInit = true;
                }

                $scope.templateOptions.setParameterCallBack(resource);

                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Añadir Causa de Desviación
            var addCause = function (save, successCallBack) {
                var formValueIndicator = angular.element('#form_causes_evolution');
                var formData = formValueIndicator.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_causes_evolution_add', {idObject: $scope.idObject, typeObj: $scope.typeObj});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});

                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    $timeout(callAtTimeout, 1500);
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
                function callAtTimeout() {
                    location.reload();
                }
            };
            //Añadir El Plan de Accion de la desviación
            var addAction = function (save, successCallBack) {
                var formValueIndicator = angular.element('#form_action_evolution');
                var formData = formValueIndicator.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_action_evolution_add', {idObject: $scope.idObject, typeObj: $scope.typeObj});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    $timeout(callAtTimeout, 3000);
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
                function callAtTimeout() {
                    location.reload();
                }
            };
            //Añadir Valores del Plan de Accion de la desviación
            var addActionValues = function (save, successCallBack) {
                var formValueIndicator = angular.element('#form_action_values_evolution');
                var formData = formValueIndicator.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_action_values_evolution_add', {idObject: $scope.idObject, idAction: $scope.idAction, month: $scope.month});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    $timeout(callAtTimeout, 1500);
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
                function callAtTimeout() {
                    location.reload();
                }
            };
            //añade el analisis de la tendencia del indicador
            var addTrendEvolution = function (save, successCallBack) {
                var formValueIndicator = angular.element('#form_trend_evolution');
                var formData = formValueIndicator.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_trend_evolution_add', {idObject: $scope.idObject, typeObj: $scope.typeObj});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    $timeout(callAtTimeout, 1500);
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
                function callAtTimeout() {
                    location.reload();
                }
            };
            $scope.templateOptions.setVar('addCause', addCause);
            $scope.templateOptions.setVar('addAction', addAction);
            $scope.templateOptions.setVar('addActionValues', addActionValues);
            $scope.templateOptions.setVar('addTrendEvolution', addTrendEvolution);
            var confirmCallBackCauses = function () {
                addCause(true, function (data) {
                });
                return true;
            };
            var confirmCallBackAction = function () {
                addAction(true, function (data) {
                });
                return true;
            };
            var confirmCallBackActionValues = function () {
                addActionValues(true, function (data) {
                });
                return true;
            };
            var confirmCallBackTrend = function () {
                addTrendEvolution(true, function (data) {
                });
                return true;
            };
            //Formulario Analisis de la tendencia
            $scope.initFormTrend = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(350);

                var parameters = {
                    idObject: $scope.idObject,
                    typeObj: $scope.typeObj,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_indicatortrend_get_form', parameters);
                $scope.templates = [
                    {
                        name: 'Analisis de la Tendencia',
                        url: url,
                        confirmCallBack: confirmCallBackTrend,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Carga del fomrulario
            $scope.initFormActionAdd = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(750);

                var parameters = {
                    idObject: $scope.idObject,
                    typeObj: $scope.typeObj,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_indicatoraction_get_form', parameters);
                $scope.templates = [
                    {
                        name: 'Plan de Acción',
                        url: url,
                        confirmCallBack: confirmCallBackAction,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Carga del fomrulario de la actualizacion de las acciones
            $scope.initFormAction = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(350);

                var parameters = {
                    idObject: $scope.idObject,
                    typeObj: $scope.typeObj,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_indicator_action_add_get_form', parameters);
                $scope.templates = [
                    {
                        name: 'Carga de Avance y Observaciones',
                        url: url,
                        confirmCallBack: confirmCallBackActionValues,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Formulario Cause
            $scope.initFormCausesAdd = function (resource) {

                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(420);

                var parameters = {
                    idObject: $scope.idObject,
                    typeObj: $scope.typeObj,
                    month: $scope.month,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_indicatorcauses_get_form', parameters);
                $scope.templates = [
                    {
                        name: 'Causas de Desviación del Indicador',
                        url: url,
                        confirmCallBack: confirmCallBackCauses,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Removiendo el Analisis de la Tendencia
            $scope.removeAnalysisTrend = function (AnalysisTrend) {
                $scope.openModalConfirm('¿Desea eliminar el Analisis de la Tendencia?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_trend_evolution_delete", {id: $scope.data_trend});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });

                function callAtTimeout() {
                    //console.log("Timeout occurred");
                    location.reload();
                }
            };
            //Removiendo las causas
            $scope.removeCausesEvolution = function (causesEvolution) {
                $scope.openModalConfirm('¿Desea eliminar la causa?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_causes_evolution_delete", {id: $scope.cause_data});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
            //Removiendo las acciones
            $scope.removeActionEvolution = function (actionEvolution) {
                $scope.openModalConfirm('¿Desea eliminar la acción?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_action_evolution_delete", {id: $scope.action_data});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
        })
        .controller('IndicatorSigEvolutionCauseController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            $scope.urlCausesEvolutionForm = null;
            $scope.indicator = null;
            var isInit = false;

            //Carga el formulario de las Causas de Desviacion
            $scope.loadTemplateCausesAnalysis = function (resource) {
                $scope.initFormCausesAnalysis(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                //$scope.templateOptions.setVar('evaluationResult', 0);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Añadir Causa de Desviación
            var addCauseAnalysis = function (save, successCallBack) {
                var formCauseAnalysis = angular.element('#form_causes_analysis_evolution');
                var formData = formCauseAnalysis.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_analysis_cause_evolution_add', {idObject: $scope.idObject, typeObj: $scope.typeObj});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            $scope.templateOptions.setVar('addCauseAnalysis', addCauseAnalysis);
            var confirmCallBack = function () {
                addCauseAnalysis(true, function (data) {
                    $scope.indicator = data.indicator;
                });
                return true;
            };
            //Formulario Cause
            $scope.initFormCausesAnalysis = function (resource) {

                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(350);

                var parameters = {
                    idObject: $scope.idObject,
                    typeObj: $scope.typeObj,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_causes_analysis_get_form', parameters);
                $scope.templates = [
                    {
                        name: 'Analisis de las Causas de Desviación',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Removiendo el Analisis de Causas
            $scope.removeAnalysisCause = function (AnalysisCause) {
                $scope.openModalConfirm('¿Desea eliminar el Analisis de Causas?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_cause_analysis_evolution_delete", {id: $scope.data_cause});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
        })
        .controller('IndicatorSigEvolutionVerificationController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            $scope.indicator = null;
            var isInit = false;

            //Carga el formulario de las Causas de Desviacion
            $scope.loadTemplateVerification = function (resource) {
                $scope.initFormVerification(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Añadir Causa de Desviación
            var addVerification = function (save, successCallBack) {
                var formVerification = angular.element('#form_action_verification');
                var formData = formVerification.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_verification_evolution_add', {idObject: $scope.idObject, month: $scope.month, typeObj: $scope.typeObj});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    //$scope.templateOptions.setVar('evaluationResult', data.result);
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
                    //$scope.templateOptions.setVar('evaluationResult', 0);
                    notificationBarService.getLoadStatus().done();
                    return false;
                });
            };
            $scope.templateOptions.setVar('addVerification', addVerification);
            var confirmCallBack = function () {
                addVerification(true, function (data) {
                    $scope.indicator = data.indicator;
                });
                return true;
            };
            //Formulario Verificación
            $scope.initFormVerification = function (resource) {

                var d = new Date();
                var numero = d.getTime();

                var parameters = {
                    idObject: $scope.idObject,
                    typeObj: $scope.typeObj,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_verification_get_form', parameters);
                $scope.templates = [
                    {
                        name: 'Verificación del Plan de Acción y Seguimiento',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Removiendo las acciones
            $scope.removeVerificationEvolution = function (actionEvolution) {
                //console.log($scope.verf);//id verification
                $scope.openModalConfirm('¿Desea eliminar la Verificación?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_verification_evolution_delete", {id: $scope.verf});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
        })
        .controller('EvolutionIndicatorConfig', function ($scope, notificationBarService, $http, notifyService, $filter) {

            $scope.indicator = null;
            var isInit = false;

            //Carga el formulario de configuracion de la gráfica
            $scope.loadTemplateConfig = function (resource) {
                $scope.initFormConfig(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario para clonar informe de evolucion
            $scope.loadTemplateCloning = function (resource) {
                $scope.initFormCloning(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Añadir Causa de Desviación
            var addConfig = function (save, successCallBack) {
                var formConfig = angular.element('#form_config_sig');
                var formData = formConfig.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_config_chart_get_form', {idObject: $scope.idObject});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    //$timeout(callAtTimeout, 3000);
                    location.reload();
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
                function callAtTimeout() {
                    location.reload();
                }
            };

            //Añadir padre cloning
            var addCloning = function (save, successCallBack) {
                var formConfig = angular.element('#form_cloning');
                var formData = formConfig.serialize();
                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_indicator_clonig_data_evolution', {id: $scope.idObject});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    //$timeout(callAtTimeout, 3000);
                    location.reload();
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
                function callAtTimeout() {
                    location.reload();
                }
            };
            $scope.templateOptions.setVar('addConfig', addConfig);
            var confirmCallBack = function () {
                addConfig(true, function (data) {
                });
                return true;
            };
            $scope.templateOptions.setVar('addCloning', addCloning);
            var confirmCallBackCloning = function () {
                addCloning(true, function (data) {
                });
                return true;
            };
            //Formulario Config
            $scope.initFormConfig = function (resource) {

                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(350);

                var parameters = {
                    idObject: $scope.idObject,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_config_chart_get_form', parameters);
                $scope.templates = [
                    {
                        name: 'Configuración Gráfica Informe de Evolución',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Formulario Cloning
            $scope.initFormCloning = function (resource) {

                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(350);

                var parameters = {
                    id: $scope.idObject,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_indicator_clonig_data_evolution', parameters);
                $scope.templates = [
                    {
                        name: 'Clonar Informe de Evolución',
                        url: url,
                        confirmCallBack: confirmCallBackCloning,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
        })
        .controller('IndicatorLastPeriodController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            $scope.urlCausesEvolutionForm = null;
            $scope.indicator = null;
            var isInit = false;
            //Carga del formulario para la relacion del indicador 2014
            $scope.loadTemplateIndicatorlastPeriod = function (resource) {
                $scope.initFormAsocLast(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Añadir la Relación con el Indicador 2014
            var addLastPeriod = function (save, successCallBack) {
                var formValueIndicator = angular.element('#form_asoc_last_period');
                var formData = formValueIndicator.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_indicator_last_period', {idObject: $scope.idObject});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    $timeout(callAtTimeout, 3000);
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
                function callAtTimeout() {
                    location.reload();
                }
            };
            //Removiendo la relación con el indicador 2014
            $scope.removeLastPeriod = function (relatioLastPeriod) {
                $scope.openModalConfirm('¿Desea eliminar la relación?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_indicator_last_period_delete", {id: $scope.idObject});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
            $scope.templateOptions.setVar('addLastPeriod', addLastPeriod);
            var confirmCallBack = function () {
                addLastPeriod(true, function (data) {
                    $scope.indicator = data.indicator;
                });
                return true;
            };
            //Carga del fomrulario
            $scope.initFormAsocLast = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(350);
                var parameters = {
                    idObject: $scope.idObject,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_indicator_last_period_form', parameters);
                $scope.templates = [
                    {
                        name: 'Indicador Periodo Anterior',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
        })

        .controller('MonitoringTracingSigController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            var isInit = false;
            //Carga el formulario
            $scope.loadTemplateTracing = function (resource) {
                $scope.initFormTracing(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            $scope.loadTemplateMaintenance = function (resource) {
                $scope.initFormMaintenace(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            $scope.loadTemplateMaintenanceVerification = function (resource) {
                $scope.initFormMaintenaceVerification(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            $scope.loadTemplateMaintenanceShow = function (resource) {
                $scope.initFormMaintenaceShow(resource);
                $scope.openModalAuto();
            };

            $scope.loadNotify = function (resource) {
                $scope.initFormNotify(resource);
                $scope.openModalAuto();
            };

            //Removiendo 
            $scope.removeStandardization = function (AnalysisTrend) {
                $scope.openModalConfirm('¿Desea eliminar el registro?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_sig_monitoring_delete", {id: $scope.dataMonitoring});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 1000);
                });
                function callAtTimeout() {
                    location.reload();
                }

            };

            //Añadir
            var addStandardization = function (save, successCallBack) {
                var formConfig = angular.element('#form_tracing_add');
                var formData = formConfig.serialize();
                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sig_monitoring_add', {id: $scope.id_managementSystem, type: $scope.type});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    //$timeout(callAtTimeout, 3000);
                    location.reload();
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
            };

            //Añadir
            var addMaintenance = function (save, successCallBack) {
                var formConfig = angular.element('#form_maintenance_add');
                var formData = formConfig.serialize();
                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sig_monitoring_maintenance', {id: $scope.id_standardization});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    //$timeout(callAtTimeout, 3000);
                    location.reload();
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
            };

            //Añadir Verification
            var addMaintenanceVerification = function (save, successCallBack) {
                var formConfig = angular.element('#form_verification_add');
                var formData = formConfig.serialize();
                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sig_monitoring_maintenance_verification', {id: $scope.id_maintenance});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    //$timeout(callAtTimeout, 3000);
                    location.reload();
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
            };

            //Añadir
            var addNotify = function (save, successCallBack) {
                var formConfig = angular.element('#form_notify_add');
                var formData = formConfig.serialize();
                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sig_monitoring_notification', {id: $scope.dataNotify, type: $scope.type, idObject: $scope.id_managementSystem});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            $scope.templateOptions.setVar('addStandardization', addStandardization);
            var confirmCallBack = function () {
                addStandardization(true, function (data) {
                });
                return true;
            };

            $scope.templateOptions.setVar('addMaintenance', addMaintenance);
            var confirmCallBackMaintenace = function () {
                addMaintenance(true, function (data) {
                });
                return true;
            };

            $scope.templateOptions.setVar('addMaintenanceVerification', addMaintenanceVerification);
            var confirmCallBackMaintenaceVerification = function () {
                addMaintenanceVerification(true, function (data) {
                });
                return true;
            };

            $scope.templateOptions.setVar('addNotify', addNotify);
            var confirmCallBackNotify = function () {
                addNotify(true, function (data) {
                });
                return true;
            };

            var confirmCallBackShow = function () {
                return true;
            };
            //Formulario Tracing
            $scope.initFormTracing = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(800);
                $scope.setWidth(800);

                var parameters = {
                    id: $scope.id_managementSystem,
                    type: $scope.type,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sig_monitoring_add', parameters);
                $scope.templates = [
                    {
                        name: 'Estandarización',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Formulario Maintenance
            $scope.initFormMaintenace = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(800);
                $scope.setWidth(800);
                var parameters = {
                    id: $scope.id_standardization,
                    _dc: numero
                };
                var url = Routing.generate('pequiven_sig_monitoring_maintenance', parameters);
                $scope.templates = [
                    {
                        name: 'Mantenimiento',
                        url: url,
                        confirmCallBack: confirmCallBackMaintenace,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Formulario Maintenance
            $scope.initFormMaintenaceShow = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(700);
                $scope.setWidth(1000);
                var parameters = {
                    id: $scope.id_standardization,
                    _dc: numero
                };
                var url = Routing.generate('pequiven_sig_monitoring_maintenance_show', parameters);
                $scope.templates = [
                    {
                        name: 'Ficha Detalles',
                        url: url,
                        confirmCallBack: confirmCallBackShow,
                        setTemplateLoad: true
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            $scope.initFormNotify = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(300);
                $scope.setWidth(800);
                var parameters = {
                    id: $scope.dataNotify,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sig_monitoring_notification', parameters);
                $scope.templates = [
                    {
                        name: 'Notificación de Usuario',
                        url: url,
                        confirmCallBack: confirmCallBackNotify,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Formulario Verificación
            $scope.initFormMaintenaceVerification = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(300);
                //$scope.setWidth(800);
                var parameters = {
                    id: $scope.id_maintenance,
                    _dc: numero
                };
                var url = Routing.generate('pequiven_sig_monitoring_maintenance_verification', parameters);
                $scope.templates = [
                    {
                        name: 'Mantenimiento',
                        url: url,
                        confirmCallBack: confirmCallBackMaintenaceVerification,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
        })
        //Fin controladores SIG

        //Controlador SIP Centro
        .controller('SipCenterObservationController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            var isInit = false;
            //Carga el formulario de las observaciones
            $scope.loadTemplateObservations = function (resource) {
                $scope.initFormObservations(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario del reporte de 1x10 y observaciones
            $scope.loadTemplateOnePerTen = function (resource) {
                $scope.initFormOnePerTen(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario cargo ubch
            $scope.loadTemplateCargoUbch = function (resource) {
                $scope.initFormCargoUbch(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario para cambiar de status
            $scope.loadTemplateStatus = function (resource) {
                $scope.initFormStatus(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario para cambiar las categorias
            $scope.loadTemplateEditRequest = function (resource) {
                $scope.initFormEditRequest(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Añadir Observations
            var addObservations = function (save, successCallBack) {
                var formCauseAnalysis = angular.element('#form_sip_center_observations');
                var formData = formCauseAnalysis.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_observations_add', {idCenter: $scope.idCenter});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };
            //Cambiando status
            var addStatus = function (save, successCallBack) {
                var formCauseAnalysis = angular.element('#form_sip_center_observations_status');
                var formData = formCauseAnalysis.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_observations_add_status', {idObs: $scope.Status});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            //Añadir Observations
            var addOnePerTen = function (save, successCallBack) {
                var formOnePerTen = angular.element('#form_sip_ubch_OnePerTen');
                var formData = formOnePerTen.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_ubch_add_report', {id: $scope.ubch});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            //Añadir Observations
            var addCargoUbch = function (save, successCallBack) {
                var formCargoUbch = angular.element('#form_sip_ubch_Cargo_Ubch');
                var formData = formCargoUbch.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_ubch_cargo_update', {id: $scope.id});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            //Añadir Observations
            var editRequest = function (save, successCallBack) {
                var formEditRequest = angular.element('#form_request_edit');
                var formData = formEditRequest.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_observations_edit', {idObs: $scope.Status});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            $scope.templateOptions.setVar('addObservations', addObservations);
            var confirmCallBack = function () {
                addObservations(true, function (data) {
                });
                return true;
            };
            $scope.templateOptions.setVar('addStatus', addStatus);
            var confirmCallBackStatus = function () {
                addStatus(true, function (data) {
                });
                return true;
            };
            $scope.templateOptions.setVar('addOnePerTen', addOnePerTen);
            var confirmCallBackOnePerTen = function () {
                addOnePerTen(true, function (data) {
                });
                return true;
            };
            $scope.templateOptions.setVar('addCargoUbch', addCargoUbch);
            var confirmCallBackCargoUbch = function () {
                addCargoUbch(true, function (data) {
                });
                return true;
            };
            $scope.templateOptions.setVar('editRequest', editRequest);
            var confirmCallBackEditRequest = function () {
                editRequest(true, function (data) {
                });
                return true;
            };
            //Formulario Observaciones
            $scope.initFormObservations = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(450);
                var parameters = {
                    idCenter: $scope.idCenter,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_center_observations', parameters);
                $scope.templates = [
                    {
                        name: 'Requerimiento',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Formulario del Estatus
            $scope.initFormStatus = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(450);
                var parameters = {
                    idObs: $scope.Status,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_center_observations_status', parameters);
                $scope.templates = [
                    {
                        name: 'Revisión de Requerimiento',
                        url: url,
                        confirmCallBack: confirmCallBackStatus,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Formulario editar categoria
            $scope.initFormEditRequest = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(450);
                var parameters = {
                    idObs: $scope.Status,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }

                var url = Routing.generate('pequiven_sip_center_observations_edit', parameters);
                $scope.templates = [
                    {
                        name: 'Edición Categoria',
                        url: url,
                        confirmCallBack: confirmCallBackEditRequest,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Formulario del Estatus
            $scope.initFormCargoUbch = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(450);
                var parameters = {
                    id: $scope.id,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_ubch_cargo_edit', parameters);
                $scope.templates = [
                    {
                        name: 'Edición Cargo de Miembro UBCH',
                        url: url,
                        confirmCallBack: confirmCallBackCargoUbch,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Formulario OnePerTen
            $scope.initFormOnePerTen = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(450);
                var parameters = {
                    idCenter: $scope.idCenter,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_ubch_form_report', parameters);
                $scope.templates = [
                    {
                        name: 'Reporte de 1 x 10 Cargado',
                        url: url,
                        confirmCallBack: confirmCallBackOnePerTen,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Removiendo las asistencias
            $scope.removeObservations = function () {
                $scope.openModalConfirm('¿Desea eliminar el Requerimiento?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_sip_center_observations_delete", {id: $scope.observations});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
            //Removiendo las asistencias
            $scope.removeUbch = function () {
                $scope.openModalConfirm('¿Desea eliminar el Miembro?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_ubch_delete_member", {id: $scope.ubch});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
        })
        .controller('SipCenterAssistsController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            var isInit = false;
            //Carga el formulario de las Asistencias
            $scope.loadTemplateAssists = function (resource) {
                $scope.initFormAssists(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            $scope.loadTemplateCenter = function (resource) {
                $scope.initFormCenter(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario de las Asistencias para editar
            $scope.loadTemplateAssistsEdit = function (resource) {
                $scope.initFormAssistsEdit(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };


            //Añadir Observations
            var addAssists = function (save, successCallBack) {
                var formCauseAnalysis = angular.element('#form_sip_center_assists');
                var formData = formCauseAnalysis.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_assists_add', {idCenter: $scope.idCenter});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            //Añadir Observations
            var editAssists = function (save, successCallBack) {
                var formCauseAnalysis = angular.element('#form_sip_center_assists_edit');
                var formData = formCauseAnalysis.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_assists_edit_center', {idCenter: $scope.idCenter});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            //Añadir Observations
            var addCenter = function (save, successCallBack) {
                var formCauseAnalysis = angular.element('#form_sip_center_add');
                var formData = formCauseAnalysis.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_activo', {idCenter: $scope.idCenter});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };
            $scope.templateOptions.setVar('addAssists', addAssists);
            $scope.templateOptions.setVar('editAssists', editAssists);
            $scope.templateOptions.setVar('addCenter', addCenter);
            var confirmCallBack = function () {
                addAssists(true, function (data) {
                });
                return true;
            };

            var confirmCallBackEdit = function () {
                editAssists(true, function (data) {
                });
                return true;
            };

            var confirmCallBackCenter = function () {
                addCenter(true, function (data) {
                });
                return true;
            };
            //Formulario Asistencias
            $scope.initFormAssists = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(650);
                var parameters = {
                    idCenter: $scope.idCenter,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_center_assists', parameters);
                $scope.templates = [
                    {
                        name: 'Asistencias',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Formulario Asistencias para editar
            $scope.initFormAssistsEdit = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(650);
                var parameters = {
                    idCenter: $scope.idCenter,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_center_assists_edit', parameters);
                $scope.templates = [
                    {
                        name: 'Edición de Asistencias',
                        url: url,
                        confirmCallBack: confirmCallBackEdit,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Formulario centro activo
            $scope.initFormCenter = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(350);
                var parameters = {
                    idCenter: $scope.idCenter,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_center_activo', parameters);
                $scope.templates = [
                    {
                        name: 'Centro Activo',
                        url: url,
                        confirmCallBack: confirmCallBackCenter,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Removiendo las asistencias
            $scope.removeAssists = function () {
                $scope.openModalConfirm('¿Desea eliminar la Asistencia?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_sip_center_assists_delete", {id: $scope.assists});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
        })

        .controller('SipCenterReportController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            var isInit = false;
            //Carga el formulario de las Asistencias
            $scope.loadTemplateReportCenter = function (resource) {
                $scope.initFormReportCenter(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };
            //Carga el formulario Registro de Votos
            $scope.loadTemplateReportVoto = function (resource) {
                $scope.initFormReportVoto(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            //Añadir Reporte
            var addReport = function (save, successCallBack) {
                var formAddReport = angular.element('#form_sip_center_report');
                var formData = formAddReport.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_report_add', {idCenter: $scope.idCenter, mesa: $scope.mesa});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            //Añadir Reporte
            var addVotos = function (save, successCallBack) {
                var formAddReport = angular.element('#form_sip_center_report_votos');
                var formData = formAddReport.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_report_voto', {idCenter: $scope.idCenter});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            $scope.templateOptions.setVar('addReport', addReport);
            var confirmCallBack = function () {
                addReport(true, function (data) {
                });
                return true;
            };

            $scope.templateOptions.setVar('addVotos', addVotos);
            var confirmCallBackVotos = function () {
                addVotos(true, function (data) {
                });
                return true;
            };

            //Formulario reporte de mesas
            $scope.initFormReportCenter = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(650);
                var parameters = {
                    idCenter: $scope.idCenter,
                    mesa: $scope.mesa,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_center_report', parameters);
                $scope.templates = [
                    {
                        name: 'Reporte Apertura de Mesa',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Formulario reporte de Votos por Centro
            $scope.initFormReportVoto = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(350);
                var parameters = {
                    idCenter: $scope.idCenter,
                    mesa: $scope.mesa,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_center_report_voto', parameters);
                $scope.templates = [
                    {
                        name: 'Reporte de Votos',
                        url: url,
                        confirmCallBack: confirmCallBackVotos,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
        })
        //fin
        .controller('SipCenterInventoryController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            var isInit = false;
            //Carga el formulario de las Asistencias
            $scope.loadTemplateInventory = function (resource) {
                $scope.initFormInventory(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            //Añadir Observations
            var addInventory = function (save, successCallBack) {
                var formCauseAnalysis = angular.element('#form_sip_center_inventory');
                var formData = formCauseAnalysis.serialize();

                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_sip_center_inventory_add', {idCenter: $scope.idCenter});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            $scope.templateOptions.setVar('addInventory', addInventory);
            var confirmCallBack = function () {
                addInventory(true, function (data) {
                    $scope.indicator = data.indicator;
                });

                return true;
            };

            //Formulario Asistencias
            $scope.initFormInventory = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                $scope.setHeight(550);
                var parameters = {
                    idCenter: $scope.idCenter,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_sip_center_inventory', parameters);
                $scope.templates = [
                    {
                        name: 'Inventario',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
            //Removiendo las asistencias
            $scope.removeInventory = function () {
                $scope.openModalConfirm('¿Desea eliminar de Inventario?', function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_sip_center_inventory_delete", {id: $scope.inventory});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
        })

        .controller('SipRequestGetFilters', function ($scope, $http) {
            $scope.data = {
                LabelsRequestStatus: null,
                LabelsCategorias: null,
            };
            $scope.model = {
                RequestStatus: null,
                Categorias: null,
            };
            //STATUS DE REQUERIMIENTOS
            $scope.viewByStatus = function (status) {
                $scope.tableParams.$params.filter['status'] = status;
                var selectStatus = angular.element('#selectStatus');
                selectStatus.select2("val", status);
//                $scope.resetViewNotified();
            }

            $scope.$watch("model.RequestStatus", function (newParams, oldParams) {
                if ($scope.model.RequestStatus != null && $scope.model.RequestStatus.id != undefined) {
                    $scope.tableParams.$params.filter['status'] = $scope.model.RequestStatus.id;
                } else {
                    $scope.tableParams.$params.filter['status'] = null;
                }
            });

            //CATEGORIAS DE REQUERIMIENTOS
            $scope.viewByCategorias = function (categoria) {
                $scope.tableParams.$params.filter['categoria'] = status;
                var selectCategorias = angular.element('#selectCategorias');
                selectCategorias.select2("val", categoria);
//                $scope.resetViewNotified();
            }

            $scope.$watch("model.Categorias", function (newParams, oldParams) {
                if ($scope.model.Categorias != null && $scope.model.Categorias.id != undefined) {
                    $scope.tableParams.$params.filter['categoria'] = $scope.model.Categorias.id;
                } else {
                    $scope.tableParams.$params.filter['categoria'] = null;
                }
            });
        })
        //fin
        .controller('ReportTemplateController', function ($scope, notificationBarService, $http, notifyService, $filter) {

        })

        .controller('MeetingController', function ($scope, $http) {
            var formFile = angular.element('form#formFile');
            $scope.idMeeting = null;
            var isInit = false;

            $scope.loadUploadFileMetting = function (resource) {
                $scope.initFormUpload(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.setHeight(350);

                //$scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);

                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            var addFile = function (save, successCallBack) {
                $("#saveFile").click();
                console.log(formFile);
            };

            $scope.templateOptions.setVar('addFile', addFile);

            var confirmCallBack = function () {
                addFile(true, function (data) {
                    idMeeting: $scope.idMeeting;
                });
                return true;
            };

            $scope.initFormUpload = function (resource) {
                var d = new Date();
                var numero = d.getTime();

                var parameters = {
                    idMeeting: $scope.idMeeting,
                    _dc: numero
                };

                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_meeting_upload_form', parameters);

                $scope.templates = [
                    {
                        name: 'Cargar Archivos',
                        url: url,
                        confirmCallBack: confirmCallBack
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };


            $scope.renderPie3dDocuments = function (id, data, width, height) {
                FusionCharts.ready(function () {
                    var pie3dDocument = new FusionCharts({
                        type: 'pie3d',
                        renderAt: id,
                        width: width,
                        height: height,
                        dataFormat: 'json',
                        dataSource: {
                            "chart": data.dataSource.chart,
                            "data": data.dataSource.dataset
                        }
                    });
                    pie3dDocument.setTransparent(true);
                    pie3dDocument.render();
                }
                );
            }
        })
        .controller('FeeStructureController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            var isInit = false;
            var valueChar = angular.element('#value').val();
            //Carga del formulario
            $scope.addCargo = function (resource) {
                //console.log(valueChar);
                $scope.initForm(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            //Carga del formulario Remove
            $scope.removeCargo = function (resource) {
                //console.log(valueChar);                
                $scope.initFormRemove(resource);
                if (isInit == false) {
                    isInit = true;
                }
                $scope.templateOptions.setTemplate($scope.templates[0]);
                $scope.templateOptions.setParameterCallBack(resource);
                if (resource) {
                    $scope.templateOptions.enableModeEdit();
                    $scope.openModalAuto();
                } else {
                    $scope.openModalAuto();
                }
            };

            //Añadir Observations
            var addCargoData = function (save, successCallBack) {
                var formDataAssing = angular.element('#form_fee_structure_assign');
                var formData = formDataAssing.serialize();
                var valueChar = angular.element('#value').val();
                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_user_feestructure_add', {id: valueChar});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };

            //Añadir Observations
            var removeCargoData = function (save, successCallBack) {
                var formDataAssing = angular.element('#form_fee_structure_remove');
                var formData = formDataAssing.serialize();
                var valueChar = angular.element('#value').val();
                if (save == undefined) {
                    var save = false;
                }
                if (save == true) {
                    var url = Routing.generate('pequiven_user_feestructure_remove', {id: valueChar});
                }
                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    if (successCallBack) {
                        successCallBack(data);
                    }
                    notificationBarService.getLoadStatus().done();
                    location.reload();
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
            };
            $scope.templateOptions.setVar('addCargoData', addCargoData);
            $scope.templateOptions.setVar('removeCargoData', removeCargoData);
            var confirmCallBack = function () {
                addCargoData(true, function (data) {
                });
                return true;
            };
            var confirmCallBackRemove = function () {
                removeCargoData(true, function (data) {
                });
                return true;
            };

            //Carga del fomrulario
            $scope.initForm = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                var valueChar = angular.element('#value').val();
                //$scope.setHeight(350);                
                var parameters = {
                    id: valueChar,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_user_feestructure_add', parameters);
                $scope.templates = [
                    {
                        name: 'Asignación Cargo',
                        url: url,
                        confirmCallBack: confirmCallBack,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };

            //Carga del fomrulario Remove
            $scope.initFormRemove = function (resource) {
                var d = new Date();
                var numero = d.getTime();
                var valueChar = angular.element('#value').val();
                //$scope.setHeight(350);
                var parameters = {
                    id: valueChar,
                    _dc: numero
                };
                if (resource) {
                    parameters.id = resource.id;
                }
                var url = Routing.generate('pequiven_user_feestructure_remove', parameters);
                $scope.templates = [
                    {
                        name: 'Remover Cargo',
                        url: url,
                        confirmCallBack: confirmCallBackRemove,
                    }
                ];
                $scope.templateOptions.setTemplate($scope.templates[0]);
            };
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
            var obtainValues = function (save, successCallBack) {
                var formValueIndicator = angular.element('#form_value_indicator');
                var formData = formValueIndicator.serialize();

                var url = Routing.generate('pequiven_value_indicator_obtain_values', {idIndicator: $scope.indicator.id});

                notificationBarService.getLoadStatus().loading();
                return $http({
                    method: 'POST',
                    url: url,
                    data: formData,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                }).success(function (data) {
                    $scope.templateOptions.setVar("form", {errors: {}});
                    $scope.templateOptions.setVar('evaluationResult', data.result);
                    var formVarRealName = '#form_' + data.varRealName;
                    angular.element(formVarRealName).val(data.real);
                    $scope.templateOptions.setVar('real', data.real);
                    if (data.showBoth == 1) {
                        var formVarPlanName = '#form_' + data.varPlanName;
                        angular.element(formVarPlanName).val(data.plan);
                        $scope.templateOptions.setVar('plan', data.plan);
                    }
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
            $scope.templateOptions.setVar('obtainValues', obtainValues);
            $scope.templateOptions.setVar('sendFeatureIndicator', sendFeatureIndicator);
            $scope.templateOptions.setVar('evaluationResult', 0);
            var confirmCallBack = function () {
                evaluateFormula(true, function (data) {
                    $scope.indicator = data.indicator;
                });
                obtainValues(true, function (data) {
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

            $scope.height = 650;

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
                setTemplateLoad: null,
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
            $scope.setHeight = function (h) {
                $scope.height = h;
            };

            $scope.setWidth = function (w) {
                $scope.width = w;
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
                var height = $scope.height;
                var width = $scope.width;
                if ($scope.template.name) {
                    modalOpen.dialog("option", "title", sfTranslator.trans($scope.template.name));
                    modalOpen.dialog("option", "height", height);
                    modalOpen.dialog("option", "width", width);
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
                } else if ($scope.template.setTemplateLoad) {
                    // setter
                    modalOpen.dialog("option", "buttons", [
                        {text: "Aceptar", click: function () {
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
                            }}
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

        .controller('TableWorkStudyCircleFileController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            var selectCategoryFile = angular.element("#selectCategoryFile");

            $scope.data = {
                category: null
            };
            $scope.model = {
                category: null
            };

            //Busca las categorias de archivos
            $scope.getCategoryFile = function () {
                var parameters = {
                    filter: {}
                };
                $http.get(Routing.generate('pequiven_seip_work_study_circle_category_file', parameters))
                        .success(function (data) {
                            $scope.data.category = data;
                            if ($scope.model.category != null) {
                                $scope.setValueSelect2("selectCategoryFile", $scope.model.category, $scope.data.category, function (selected) {
                                    $scope.model.category = selected;
                                });
                            }
                        });
            };
            $scope.getCategoryFile();

        })


        .controller('TableWorkStudyCircleController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            var selectComplejo = angular.element("#selectComplejos");
            var selectFirstLineManagement = angular.element("#selectFirstLineManagement");
            var selectSecondLineManagement = angular.element("#selectSecondLineManagement");
            var selectCoordinator = angular.element("#selectCoordinator");

            $scope.data = {
                complejos: null,
                first_line_managements: null,
                second_line_managements: null,
                coordinators: null,
            };
            $scope.model = {
                complejo: null,
                firstLineManagement: null,
                secondLineManagement: null,
                coordinator: null,
            };

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

            //Busca las localidades
            $scope.getCoordinators = function () {
                var parameters = {
                    filter: {}
                };
                $http.get(Routing.generate('pequiven_work_study_circle_coordinators', parameters))
                        .success(function (data) {
                            $scope.data.coordinators = data;
                            if ($scope.model.coordinator != null) {
                                $scope.setValueSelect2("selectCoordinators", $scope.model.coordinator, $scope.data.coordinators, function (selected) {
                                    $scope.model.coordinator = selected;
                                });
                            }
                        });
            };

            $scope.getComplejos();
            $scope.getFirstLineManagement();
//            $scope.getCoordinators();

            //Scope de Localidad
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                    //Al cambiar el select de localidad
                    selectComplejo.change(function () {
                        selectFirstLineManagement.select2("val", '');
                        selectSecondLineManagement.select2("val", '');
                    });
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            }
            );
            //Scope de Gerencia de 1ra Línea
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                    selectSecondLineManagement.select2("enable", true);
                    //Al cambiar la gerencia de 1ra línea
                    selectFirstLineManagement.change(function () {
                        selectSecondLineManagement.select2("val", '');
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
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                }
            });

            //Scope de Coordinadores
            $scope.$watch("model.coordinator", function (newParams, oldParams) {
                if ($scope.model.coordinator != null) {
                    var coordinatorsId = [], i = 0;
                    var coordinators = angular.element("#coordinators").select2('data');
                    angular.forEach(coordinators, function (value) {
                        coordinatorsId.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['coordinators'] = angular.toJson(coordinatorsId);
                    } else {
                        $scope.tableParams.$params.filter['coordinators'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['coordinators'] = null;
                }
            });

        })

        .controller('ReportSipController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            var selectComplejo = angular.element("#selectComplejos");
            var selectComplejoId = angular.element("#selectComplejosid");
            var selectFirstLineManagement = angular.element("#selectFirstLineManagement");
            var selectFirstLineManagementId = angular.element("#selectFirstLineManagementid");
            var selectSecondLineManagement = angular.element("#selectSecondLineManagement");
            var selectSecondLineManagementId = angular.element("#selectSecondLineManagementid");

            $scope.data = {
                complejos: null,
                first_line_managements: null,
                second_line_managements: null
            };
            $scope.model = {
                complejo: null,
                firstLineManagement: null,
                secondLineManagement: null
            };

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

//            //Busca las Gerencias de 1ra Línea
//            $scope.getFirstLineManagement = function (complejo) {
//                var parameters = {
//                    filter: {}
//                };
//                if ($scope.model.complejo != null) {
//                    parameters.filter['complejo'] = $scope.model.complejo.id;
//                }
//                $http.get(Routing.generate('pequiven_seip_first_line_management', parameters))
//                        .success(function (data) {
//                            $scope.data.first_line_managements = data;
//                            if ($scope.model.firstLineManagement != null) {
//                                $scope.setValueSelect2("firstLineManagement", $scope.model.firstLineManagement, $scope.data.first_line_managements, function (selected) {
//                                    $scope.model.firstLineManagement = selected;
//                                });
//                            }
//                        });
//            };

            //Busca las Gerencias de 2da Línea
            $scope.getSecondLineManagement = function (gerencia) {
                var parameters = {
                    filter: {}
                };
                if ($scope.model.complejo != null) {
                    parameters.filter['complejo'] = $scope.model.complejo.id;
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

            $scope.getComplejos();
            //    $scope.getFirstLineManagement();
//            $scope.getCoordinators();

            //Scope de Localidad
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    //    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                    selectComplejoId.val($scope.model.complejo.id);
                    selectSecondLineManagement.select2("enable", true);
                    selectSecondLineManagement.select2("val", '');
                    //Al cambiar el select de localidad
                    //      selectFirstLineManagement.select2("enable", true);
//                    selectFirstLineManagement.change(function () {                        
//                        selectFirstLineManagement.select2("val", '');                        
//                    });
                } else {
//                    selectFirstLineManagement.select2("enable", false);
//                    selectFirstLineManagement.select2("val", '');
                    // selectSecondLineManagement.select2("enable", false);
                    selectSecondLineManagement.select2("val", '');
//                    $scope.tableParams.$params.filter['complejo'] = null;
                    selectComplejoId.val('');

                }
            }
            );
            //Scope de Gerencia de 1ra Línea
//            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
//                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
////                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
//                    selectFirstLineManagementId.val($scope.model.firstLineManagement.id);
//                    selectSecondLineManagement.select2("enable", true);
//                    //Al cambiar la gerencia de 1ra línea
//                    selectFirstLineManagement.change(function () {
//                        selectSecondLineManagement.select2("val", '');                         
//                    });
//                } else {
////                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
//                    selectSecondLineManagement.select2("enable", false);
//                    selectSecondLineManagement.select2("val", '');
//                    selectFirstLineManagementId.val('');
//                }
//            });
            //Scope de Gerencia de 2da Línea
            $scope.$watch("model.secondLineManagement", function (newParams, oldParams) {
                if ($scope.model.secondLineManagement != null && $scope.model.secondLineManagement.id != undefined) {
//                    $scope.tableParams.$params.filter['secondLineManagement'] = $scope.model.secondLineManagement.id;
                    selectSecondLineManagementId.val($scope.model.secondLineManagement.id);
                } else {
//                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                    selectSecondLineManagementId.val('');
                }
            });
        })

        .controller('TableDocumentController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            var selectComplejo = angular.element("#selectComplejos");
            var selectFirstLineManagement = angular.element("#selectFirstLineManagement");
            var selectWorkStudyCircle = angular.element("#selectWorkStudyCircle");
            var selectCategoryFile = angular.element("#selectCategoryFile");

            $scope.data = {
                complejos: null,
                first_line_managements: null,
                work_study_circles: null,
                category_files: null
            };
            $scope.model = {
                complejos: null,
                first_line_managements: null,
                work_study_circles: null,
                category_files: null
            };


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

            $scope.getComplejos();


            //Scope de Localidad
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                    //Al cambiar el select de localidad
                    selectComplejo.change(function () {
                        selectFirstLineManagement.select2("val", '');
                        //selectWorkStudyCircle.select2("val", '');
                    });
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            }
            );

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
            //Scope de Gerencia de 1ra Línea
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                    //selectSecondLineManagement.select2("enable", true);
                    //Al cambiar la gerencia de 1ra línea
//                    selectFirstLineManagement.change(function () {
//                        selectSecondLineManagement.select2("val", '');
//                    });
                } else {
                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
                    //Cambia status enable en segunda linea
//                    selectSecondLineManagement.select2("enable", false);
//                    selectSecondLineManagement.select2("val", '');
                }
            });
            $scope.getFirstLineManagement();


            //Busca los Círculos de Estudio de Trabajo
            $scope.getWorkStudyCircle = function (complejo) {
                var parameters = {
                    filter: {}
                };
                if ($scope.model.complejo != null) {
                    parameters.filter['complejo'] = $scope.model.complejo.id;
                }
                $http.get(Routing.generate('pequiven_seip_work_study_circle', parameters))
                        .success(function (data) {
                            $scope.data.work_study_circles = data;
                            if ($scope.model.workStudyCircle != null) {
                                $scope.setValueSelect2("workStudyCircle", $scope.model.workStudyCircle, $scope.data.work_study_circles, function (selected) {
                                    $scope.model.workStudyCircle = selected;
                                });
                            }
                        });
            };

            //Scope de Círculo de Estudio de Trabajo
            $scope.$watch("model.workStudyCircle", function (newParams, oldParams) {
                if ($scope.model.workStudyCircle != null && $scope.model.workStudyCircle.id != undefined) {
                    $scope.tableParams.$params.filter['workStudyCircle'] = $scope.model.workStudyCircle.id;
                    //Al cambiar el círculo de estudio de trabajo
                    selectWorkStudyCircle.change(function () {
                    });
                } else {
                    $scope.tableParams.$params.filter['workStudyCircle'] = null;
                }
            });

            $scope.getWorkStudyCircle();


            //Busca las categorias de archivos
            $scope.getCategoryFile = function () {
                var parameters = {
                    filter: {}
                };
                $http.get(Routing.generate('pequiven_seip_category_file', parameters))
                        .success(function (data) {
                            $scope.data.category_files = data;
                            if ($scope.model.category_file != null) {
                                $scope.setValueSelect2("selectCategoryFile", $scope.model.category_file, $scope.data.category_files, function (selected) {
                                    $scope.model.category_file = selected;
                                });
                            }
                        });
            };

            //Scope de categorias de archivos
            $scope.$watch("model.category_file", function (newParams, oldParams) {
                if ($scope.model.category_file != null && $scope.model.category_file.id != undefined) {
                    $scope.tableParams.$params.filter['categoryFile'] = $scope.model.category_file.id;

                } else {
                    $scope.tableParams.$params.filter['categoryFile'] = null;
                }
            });
            $scope.getCategoryFile();


        })

        //ONE PER TEN 
        .controller('TableOnePerTenController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            var selectComplejo = angular.element("#selectComplejos");
            var selectFirstLineManagement = angular.element("#selectFirstLineManagement");
            var selectSecondLineManagement = angular.element("#selectSecondLineManagement");
            var selectWorkStudyCircle = angular.element("#selectWorkStudyCircle");
            var selectProfilesPoliticEvaluation = angular.element("#selectProfilesPoliticEvaluation");


            $scope.data = {
                complejos: null,
                first_line_managements: null,
                second_line_managements: null,
                work_study_circles: null,
                profiles_politic_evaluation: null,
            };

            $scope.model = {
                complejo: null,
                firstLineManagement: null,
                secondLineManagement: null,
                workStudyCircle: null,
                profilesPoliticEvaluation: null,
            };

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

            //Busca los Círculos de Estudio de Trabajo
            $scope.getWorkStudyCircle = function (complejo, phase) {
                var parameters = {
                    filter: {}
                };
                if ($scope.model.complejo != null) {
                    parameters.filter['complejo'] = $scope.model.complejo.id;
                }
                if (phase != '' && phase != undefined) {
                    parameters.filter['phase'] = phase;
                }
                $http.get(Routing.generate('pequiven_seip_work_study_circle', parameters))
                        .success(function (data) {
                            $scope.data.work_study_circles = data;
                            if ($scope.model.workStudyCircle != null) {
                                $scope.setValueSelect2("workStudyCircle", $scope.model.workStudyCircle, $scope.data.work_study_circles, function (selected) {
                                    $scope.model.workStudyCircle = selected;
                                });
                            }
                        });
            };
            
            //Busca los Perfiles de Evaluación Política
//            $scope.getProfilesPoliticEvaluation = function () {
//                var parameters = {
//                    filter: {}
//                };
//                $http.get(Routing.generate('pequiven_seip_profiles_politic_evaluation', parameters))
//                        .success(function (data) {
//                            $scope.data.profiles_politic_evaluation = data;
//                            if ($scope.model.profilesPoliticEvaluation != null) {
//                                $scope.setValueSelect2("profilesPoliticEvaluation", $scope.model.profilesPoliticEvaluation, $scope.data.profiles_politic_evaluation, function (selected) {
//                                    $scope.model.profilesPoliticEvaluation = selected;
//                                });
//                            }
//                        });
//            };

            $scope.getComplejos();
            $scope.getFirstLineManagement();
            $scope.getWorkStudyCircle();
//            $scope.getProfilesPoliticEvaluation();

            //Scope de Localidad
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                    //Al cambiar el select de localidad
                    selectComplejo.change(function () {
                        selectFirstLineManagement.select2("val", '');
                        selectWorkStudyCircle.select2("val", '');
                    });
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            }
            );

            //Scope de Gerencia de 1ra Línea
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                    selectSecondLineManagement.select2("enable", true);
                    //Al cambiar la gerencia de 1ra línea
                    selectFirstLineManagement.change(function () {
                        selectSecondLineManagement.select2("val", '');
                    });
                } else {
                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
                    //Cambia status enable en segunda linea
                    selectSecondLineManagement.select2("enable", false);
                    selectSecondLineManagement.select2("val", '');
                }
            });

            //Scope de Gerencia de 2da Línea
            $scope.$watch("model.secondLineManagement", function (newParams, oldParams) {
                if ($scope.model.secondLineManagement != null && $scope.model.secondLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['secondLineManagement'] = $scope.model.secondLineManagement.id;
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                }
            });

            //Scope de Círculo de Estudio de Trabajo
            $scope.$watch("model.workStudyCircle", function (newParams, oldParams) {
                if ($scope.model.workStudyCircle != null && $scope.model.workStudyCircle.id != undefined) {
                    $scope.tableParams.$params.filter['workStudyCircle'] = $scope.model.workStudyCircle.id;
                    //Al cambiar el círculo de estudio de trabajo
                    selectWorkStudyCircle.change(function () {
                    });
                } else {
                    $scope.tableParams.$params.filter['workStudyCircle'] = null;
                }
            });

            //Scope de Perfiles de Evaluación Política
            $scope.$watch("model.profilesPoliticEvaluation", function (newParams, oldParams) {
                if ($scope.model.profilesPoliticEvaluation != null && $scope.model.profilesPoliticEvaluation.id != undefined) {
                    $scope.tableParams.$params.filter['profilesPoliticEvaluation'] = $scope.model.profilesPoliticEvaluation.id;
                    //Al cambiar el círculo de estudio de trabajo
                    selectProfilesPoliticEvaluation.change(function () {
                    });
                } else {
                    $scope.tableParams.$params.filter['profilesPoliticEvaluation'] = null;
                }
            });


        })
        //FIN ONE PER TEN


        .controller('TableProposalController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            var selectComplejo = angular.element("#selectComplejos");
            var selectFirstLineManagement = angular.element("#selectFirstLineManagement");
            var selectSecondLineManagement = angular.element("#selectSecondLineManagement");
            var selectWorkStudyCircle = angular.element("#selectWorkStudyCircle");
            var selectWorkStudyCircleInherited = angular.element("#selectWorkStudyCircleInherited");
            var selectLineStrategic = angular.element("#selectLineStrategic");

            $scope.data = {
                complejos: null,
                first_line_managements: null,
                second_line_managements: null,
                work_study_circles: null,
                work_sutyd_circles_inherited: null,
                line_strategics: null,
            };
            $scope.model = {
                complejo: null,
                firstLineManagement: null,
                secondLineManagement: null,
                workStudyCircle: null,
                workStudyCircleInherited: null,
                lineStrategic: null,
            };

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

            //Busca los Círculos de Estudio de Trabajo
            $scope.getWorkStudyCircle = function (complejo, phase) {
                var parameters = {
                    filter: {}
                };
                if ($scope.model.complejo != null) {
                    parameters.filter['complejo'] = $scope.model.complejo.id;
                }
                if (phase != '' && phase != undefined) {
                    parameters.filter['phase'] = phase;
                }
                $http.get(Routing.generate('pequiven_seip_work_study_circle', parameters))
                        .success(function (data) {
                            $scope.data.work_study_circles = data;
                            if ($scope.model.workStudyCircle != null) {
                                $scope.setValueSelect2("workStudyCircle", $scope.model.workStudyCircle, $scope.data.work_study_circles, function (selected) {
                                    $scope.model.workStudyCircle = selected;
                                });
                            }
                        });
            };

            //Busca los Círculos de Estudio de Trabajo
            $scope.getWorkStudyCircleInherited = function (workStudyCircleParent) {
                var parameters = {
                    filter: {
                        workStudyCircleParent: workStudyCircleParent
                    }
                };
                $http.get(Routing.generate('pequiven_seip_work_study_circle', parameters))
                        .success(function (data) {
                            $scope.data.work_study_circles = data;
                            if ($scope.model.workStudyCircle != null) {
                                $scope.setValueSelect2("workStudyCircle", $scope.model.workStudyCircle, $scope.data.work_study_circles, function (selected) {
                                    $scope.model.workStudyCircle = selected;
                                });
                            }
                        });
            };

            //Busca las Líneas Estratégicas
            $scope.getLineStrategic = function (complejo) {
                var parameters = {
                    filter: {}
                };
                $http.get(Routing.generate('pequiven_seip_line_strategic', parameters))
                        .success(function (data) {
                            $scope.data.line_strategics = data;
                            if ($scope.model.lineStrategic != null) {
                                $scope.setValueSelect2("lineStrategic", $scope.model.lineStrategic, $scope.data.line_strategics, function (selected) {
                                    $scope.model.lineStrategic = selected;
                                });
                            }
                        });
            };

            $scope.getComplejos();
            $scope.getFirstLineManagement();
//            $scope.getWorkStudyCircle();
            $scope.getLineStrategic();

            //Scope de Localidad
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                    //Al cambiar el select de localidad
                    selectComplejo.change(function () {
                        selectFirstLineManagement.select2("val", '');
                        selectWorkStudyCircle.select2("val", '');
                    });
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            }
            );
            //Scope de Gerencia de 1ra Línea
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                    selectSecondLineManagement.select2("enable", true);
                    //Al cambiar la gerencia de 1ra línea
                    selectFirstLineManagement.change(function () {
                        selectSecondLineManagement.select2("val", '');
                    });
                } else {
                    $scope.tableParams.$params.filter['firstLineManagement'] = null;
                    //Cambia status enable en segunda linea
                    selectSecondLineManagement.select2("enable", false);
                    selectSecondLineManagement.select2("val", '');
                }
            });

            //Scope de Gerencia de 2da Línea
            $scope.$watch("model.secondLineManagement", function (newParams, oldParams) {
                if ($scope.model.secondLineManagement != null && $scope.model.secondLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['secondLineManagement'] = $scope.model.secondLineManagement.id;
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                }
            });

            //Scope de Círculo de Estudio de Trabajo
            $scope.$watch("model.workStudyCircle", function (newParams, oldParams) {
                if ($scope.model.workStudyCircle != null && $scope.model.workStudyCircle.id != undefined) {
                    $scope.tableParams.$params.filter['workStudyCircle'] = $scope.model.workStudyCircle.id;
                    //Al cambiar el círculo de estudio de trabajo
                    selectWorkStudyCircle.change(function () {
                    });
                } else {
                    $scope.tableParams.$params.filter['workStudyCircle'] = null;
                }
            });
            //Scope de Línea Estratégica
            $scope.$watch("model.lineStrategic", function (newParams, oldParams) {
                if ($scope.model.lineStrategic != null && $scope.model.lineStrategic.id != undefined) {
                    $scope.tableParams.$params.filter['lineStrategic'] = $scope.model.lineStrategic.id;
                    //Al cambiar la línea estratégica
                    selectLineStrategic.change(function () {
                    });
                } else {
                    $scope.tableParams.$params.filter['lineStrategic'] = null;
                }
            });
        })



        .controller('graphicsWorkStudyCircle', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

            $scope.renderMultiSerie3d = function (id, data, width, height) {
                FusionCharts.ready(function () {
                    var multiSerie3d = new FusionCharts({
                        type: 'mscolumn3dlinedy',
                        renderAt: id,
                        width: width,
                        height: height,
                        dataFormat: 'json',
                        dataSource: {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    multiSerie3d.setTransparent(true);
                    multiSerie3d.render();
                }
                );
            }
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
            var selectManagementSystems = angular.element("#selectManagementSystems");
            $scope.data = {
                complejos: null,
                first_line_managements: null,
                second_line_managements: null,
                indicatorSummaryLabels: null,
                frequency_notifications: null,
                managementSystems: null
            };
            $scope.model = {
                complejo: null,
                firstLineManagement: null,
                secondLineManagement: null,
                indicatorMiscellaneous: null,
                frequencyNotification: null,
                managementSystem: null
            };
            //Carga de Configuración por defecto
            $scope.initPage = function () {
                selectSecondLineManagement.select2("enable", false);
            };
            $scope.initPage();
            //Carga de Sistemas de Calidad
            $scope.getManagementSystems = function () {
                var parameters = {
                    filter: {}
                }
            }
            $http.get(Routing.generate('pequiven_arrangementprogram_data_management_system'))
                    .success(function (data) {
                        $scope.data.managementSystems = data;
                        if ($scope.model.managementSystem != null) {
                            $scope.setValueSelect2("selectManagementSystems", $scope.model.managementSystem, $scope.data.managementSystems, function (selected) {
                                $scope.model.managementSystem = selected;
                            });
                        }
                    });
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
            //Busca las frecuencias de notificación
            $scope.getFrequencyNotifications = function () {
                var parameters = {
                    filter: {}
                };
                $http.get(Routing.generate('pequiven_seip_frequency_notification', parameters))
                        .success(function (data) {
                            $scope.data.frequency_notifications = data;
                            if ($scope.model.frequencyNotification != null) {
                                $scope.setValueSelect2("selectFrequencyNotifications", $scope.model.frequencyNotification, $scope.data.frequency_notifications, function (selected) {
                                    $scope.model.frequencyNotification = selected;
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
                $scope.getFrequencyNotifications();
            } else if (level > 1) {
                $scope.getComplejos();
                $scope.getFirstLineManagement();
                $scope.getFrequencyNotifications();
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
            //Scope ManagementSystems
            $scope.$watch("model.managementSystem", function (newParams, oldParams) {
                if ($scope.model.managementSystem != null && $scope.model.managementSystem.id != undefined) {
                    $scope.tableParams.$params.filter['managementSystems'] = $scope.model.managementSystem.id;
                } else {
                    $scope.tableParams.$params.filter['managementSystems'] = null;
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
            //Scope de Frecuencias de Notificación
            $scope.$watch("model.frequencyNotification", function (newParams, oldParams) {
                if ($scope.model.frequencyNotification != null && $scope.model.frequencyNotification.id != undefined) {
                    $scope.tableParams.$params.filter['frequencyNotification'] = $scope.model.frequencyNotification.id;
                } else {
                    $scope.tableParams.$params.filter['frequencyNotification'] = null;
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

        .controller('WorkStudyCircleController', function ($scope, notificationBarService, $http, notifyService, $filter, $timeout) {

            $scope.removeMember = function () {
                var TextName = '¿Desea Sacar a ' + $scope.userName + ' del Círculo de Estudio y Trabajo ' + $scope.workStudyCircleName + '?';
                $scope.openModalConfirm(TextName, function () {
                    notificationBarService.getLoadStatus().loading();
                    var url = Routing.generate("pequiven_work_study_circle_delete_member", {idUser: $scope.user});
                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}  // set the headers so angular passing info as form data (not request payload)
                    }).success(function (data) {
                        return true;
                    }).error(function (data, status, headers, config) {
                        if (data.errors) {
                            if (data.errors.errors) {
                                $.each(data.errors.errors, function (index, value) {
                                    notifyService.error(Translator.trans(value));
                                });
                            }
                        }
                        notificationBarService.getLoadStatus().done();
                        return false;
                    });
                    $timeout(callAtTimeout, 3000);
                });
                function callAtTimeout() {
                    location.reload();
                }
            };
        })

//Controlador para los gráficos a mostrar en el dashboard del indicador
        .controller('ChartsDashboardController', function ($scope, $http) {

//        var month = 0;
            $scope.data = {
                monthsLabels: null,
            };

            $scope.model = {
                months: null,
                monthsGroupByCompany: null,
            };

            $scope.$watch("model.months", function (newParams, oldParams) {
                if ($scope.model.months != null && $scope.model.months.id != undefined) {
//                    setValueSelect2("month", $scope.model.months.id, $scope.data.monthsLabel);
                }
            });
            $scope.$watch("model.monthsGroupByCompany", function (newParams, oldParams) {
                if ($scope.model.monthsGroupByCompany != null && $scope.model.monthsGroupByCompany.id != undefined) {
//                    setValueSelect2("month2", $scope.model.months2.id, $scope.data.monthsLabel);
                }
            });

            //0-Gráfico en forma de dona para mostrar los indicadores asociados (Resumen, Referencia y Resultado de la Medición)
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

            //1-Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), de los indicadores asociados
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

            //2-Gráfico en forma de dona para mostrar las variables plan y real a partir de ecuación de la fórmula del indicador
            $scope.chargeChartDoughnut2dWithVariablesRealPlan = function (indicatorId, render, width, height) {
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

            //3-Gráfico para mostrar las variables de un indicador que esten marcadas como "real"
            $scope.chargeChartPieVariablesMarkedReal = function (indicatorId, render, width, height) {
                var getDataChartPieVariablesMarkedReal = Routing.generate("getDataChartPieVariablesMarkedReal", {id: indicatorId});
                $http.get(getDataChartPieVariablesMarkedReal).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartPieVariablesMarkedReal = new FusionCharts({
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
                        revenueChartPieVariablesMarkedReal.setTransparent(true);
                        revenueChartPieVariablesMarkedReal.render();
                    });
                });
            }

            //4-Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), del indicador
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

            //5-Gráfico para mostrar las variables de un indicador que esten marcadas como "plan"
            $scope.chargeChartPieVariablesMarkedPlan = function (indicatorId, render, width, height) {
                var getDataChartPieVariablesMarkedPlan = Routing.generate("getDataChartPieVariablesMarkedPlan", {id: indicatorId});
                $http.get(getDataChartPieVariablesMarkedPlan).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartPieVariablesMarkedPlan = new FusionCharts({
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
                        revenueChartPieVariablesMarkedPlan.setTransparent(true);
                        revenueChartPieVariablesMarkedPlan.render();
                    });
                });
            }

            //6-Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), del indicador
            $scope.chargeChartBarsAreaVariablesRealPlanByFrequencyNotification = function (indicatorId, render, width, height) {
                var getDataChartBarsAreaVariablesRealPlanByFrequencyNotification = Routing.generate("getDataChartBarsAreaVariablesRealPlanByFrequencyNotification", {id: indicatorId});
                $http.get(getDataChartBarsAreaVariablesRealPlanByFrequencyNotification).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartBarsAreaVariablesRealPlanByFrequencyNotification = new FusionCharts({
                            "type": "mscombi2d",
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
                        revenueChartBarsAreaVariablesRealPlanByFrequencyNotification.setTransparent(true);
                        revenueChartBarsAreaVariablesRealPlanByFrequencyNotification.render();
                    });
                });
            }

            //7-Gráfico para mostrar las variables (sumativas al plan) de un indicador con fórmula a partir de ecuación
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

            //8-Gráfico para mostrar las variables (sumativas al real) de un indicador con fórmula a partir de ecuación
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

            //9-Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), del indicador
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

            //10-Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), del indicador (Variables marcadas como real/plan)
            $scope.chargeChartBarsAreaVariablesMarkedRealPlanByFrequencyNotification = function (indicatorId, render, width, height) {
                var getDataChartBarsAreaVariablesMarkedRealPlanByFrequencyNotification = Routing.generate("getDataChartBarsAreaVariablesMarkedRealPlanByFrequencyNotification", {id: indicatorId});
                $http.get(getDataChartBarsAreaVariablesMarkedRealPlanByFrequencyNotification).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartBarsAreaVariablesMarkedRealPlanByFrequencyNotification = new FusionCharts({
                            "type": "mscombi2d",
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
                        revenueChartBarsAreaVariablesMarkedRealPlanByFrequencyNotification.setTransparent(true);
                        revenueChartBarsAreaVariablesMarkedRealPlanByFrequencyNotification.render();
                    });
                });
            }

            //11-Gráfico tipo barras vertical para mostrar las variables marcadas como real/plan de la fórmula del indicador respecto al eje izquierdo, de acuerdo a la frecuencia de notificación
            $scope.chargeChartColumnVariablesMarkedRealPlanByFrequencyNotification = function (indicatorId, render, width, height) {
                var getDataChartColumnVariablesMarkedRealPlanByFrequencyNotification = Routing.generate("getDataChartColumnVariablesMarkedRealPlanByFrequencyNotification", {id: indicatorId});
                $http.get(getDataChartColumnVariablesMarkedRealPlanByFrequencyNotification).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnVariablesMarkedRealPlanByFrequencyNotification = new FusionCharts({
                            "type": "mscolumn3d",
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
                        revenueChartColumnVariablesMarkedRealPlanByFrequencyNotification.setTransparent(true);
                        revenueChartColumnVariablesMarkedRealPlanByFrequencyNotification.render();
                    });
                });
            }

            //12-Gráfico en forma de dona para mostrar los resultados real/plan a partir de la ecuación para gráficos de la fórmula del indicador
            $scope.chargeChartVariablesRealPlanFromDashboardEquationDoughnut = function (indicatorId, render, width, height) {
                var getdataChartVariablesRealPlanFromDashboardEquationDoughnut = Routing.generate("getDataChartVariablesRealPlanFromDashboardEquationDoughnut", {id: indicatorId});
                $http.get(getdataChartVariablesRealPlanFromDashboardEquationDoughnut).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartVariablesRealPlanFromDashboardEquationDoughnut = new FusionCharts({
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
                        revenueChartVariablesRealPlanFromDashboardEquationDoughnut.setTransparent(true);
                        revenueChartVariablesRealPlanFromDashboardEquationDoughnut.render();
                    });
                });
            }

            //13-Gráfico tipo barras vertical para mostrar los resultados real/plan de la fórmula del indicador respecto al eje izquierdo, de los indicadores asociados.
            $scope.chargeChartColumnRealPlanIndicatorsAssociatedFromDashboardEquation = function (indicatorId, render, width, height) {
                var getDataChartColumnRealPlanIndicatorsAssociatedFromDashboardEquation = Routing.generate("getDataChartColumnRealPlanIndicatorsAssociatedFromDashboardEquation", {id: indicatorId});
                $http.get(getDataChartColumnRealPlanIndicatorsAssociatedFromDashboardEquation).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnRealPlanIndicatorsAssociatedFromDashboardEquation = new FusionCharts({
                            "type": "mscolumn3d",
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
                        revenueChartColumnRealPlanIndicatorsAssociatedFromDashboardEquation.setTransparent(true);
                        revenueChartColumnRealPlanIndicatorsAssociatedFromDashboardEquation.render();
                    });
                });
            }

            //14-Gráfico tipo columna 3d para mostrar el resultado real/plan de la ecuación para gráficos de la fórmula del indicador respecto al eje izquierdo, de acuerdo a la frecuencia de notificación.
            $scope.chargeChartColumnRealPlanByFrequencyNotificationFromDashboardEquation = function (indicatorId, render, width, height) {
                var getDataChartColumnRealPlanByFrequencyNotificationFromDashboardEquation = Routing.generate("getDataChartColumnRealPlanByFrequencyNotificationFromDashboardEquation", {id: indicatorId});
                $http.get(getDataChartColumnRealPlanByFrequencyNotificationFromDashboardEquation).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnRealPlanByFrequencyNotificationFromDashboardEquation = new FusionCharts({
                            "type": "mscolumn3d",
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
                        revenueChartColumnRealPlanByFrequencyNotificationFromDashboardEquation.setTransparent(true);
                        revenueChartColumnRealPlanByFrequencyNotificationFromDashboardEquation.render();
                    });
                });
            }

            //15-Gráfico tipo stacked column 3d para mostrar el resultado , de acuerdo a la frecuencia de notificación de los indicadores asociados, además del total del indicador padre.
            $scope.chargeChartStackedColumnVariableByFrequencyNotificationWithTotal = function (indicatorId, render, width, height) {
                var getDataChartStackedColumnVariableByFrequencyNotificationWithTotal = Routing.generate("getDataChartStackedColumnVariableByFrequencyNotificationWithTotal", {id: indicatorId});
                $http.get(getDataChartStackedColumnVariableByFrequencyNotificationWithTotal).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartStackedColumnVariableByFrequencyNotificationWithTotal = new FusionCharts({
                            "type": "stackedcolumn3d",
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
                        revenueChartStackedColumnVariableByFrequencyNotificationWithTotal.setTransparent(true);
                        revenueChartStackedColumnVariableByFrequencyNotificationWithTotal.render();
                    });
                });
            }

            //16-Gráfico tipo column 3d para mostrar el resultado de un mes (Ideado para aquellos indicadores con fórmula acumulativo de cada carga) de los indicadores asociados, con el total acumulado al final
            $scope.chargeChartColumnResultIndicatorsAssociatedWithTotalByMonth = function (indicatorId, month, render, width, height) {
                var getDataChartColumnResultIndicatorsAssociatedWithTotalByMonth = Routing.generate("getDataChartColumnResultIndicatorsAssociatedWithTotalByMonth", {id: indicatorId, month: month});
                $http.get(getDataChartColumnResultIndicatorsAssociatedWithTotalByMonth).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnResultIndicatorsAssociatedWithTotalByMonth = new FusionCharts({
                            "type": "column3d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.data
                            }
                        });
                        revenueChartColumnResultIndicatorsAssociatedWithTotalByMonth.setTransparent(true);
                        revenueChartColumnResultIndicatorsAssociatedWithTotalByMonth.render();
                    });
                });
            }

            //17-Gráfico tipo column 3d para mostrar el resultado de un mes (Ideado para aquellos indicadores con fórmula acumulativo de cada carga) de los indicadores asociados agrupados por tipo de empresa, con el total acumulado al final
            $scope.chargeChartColumnResultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth = function (indicatorId, month, render, width, height) {
                var getDataChartColumnResultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth = Routing.generate("getDataChartColumnResultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth", {id: indicatorId, month: month});
                $http.get(getDataChartColumnResultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnResultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth = new FusionCharts({
                            "type": "column3d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.data
                            }
                        });
                        revenueChartColumnResultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth.setTransparent(true);
                        revenueChartColumnResultIndicatorsAssociatedGroupByTypeCompanyWithTotalByMonth.render();
                    });
                });
            }

            //18-Gráfico tipo multiseries de línea, para las lesiones personales con tiempo, acumulados, sólo del indicador (período actual y anterior)
            $scope.chargeChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTime = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTime = Routing.generate("getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTime", {id: indicatorId});
                $http.get(getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTime).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTime = new FusionCharts({
                            "type": "msline",
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
                        revenueChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTime.setTransparent(true);
                        revenueChartMultiSeriesLineIndicatorPersonalInjuryWithAccumulatedTime.render();
                    });
                });
            }

            //19-Gráfico tipo multiseries de línea, para las lesiones personales sin tiempo, sólo del indicador (período actual y anterior)
            $scope.chargeChartMultiSeriesLineIndicatorPersonalInjuryWithoutAccumulatedTime = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesLineIndicatorPersonalInjuryWithoutAccumulatedTime = Routing.generate("getDataChartMultiSeriesLineIndicatorPersonalInjuryWithoutAccumulatedTime", {id: indicatorId});
                $http.get(getDataChartMultiSeriesLineIndicatorPersonalInjuryWithoutAccumulatedTime).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesLineIndicatorPersonalInjuryWithoutAccumulatedTime = new FusionCharts({
                            "type": "msline",
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
                        revenueChartMultiSeriesLineIndicatorPersonalInjuryWithoutAccumulatedTime.setTransparent(true);
                        revenueChartMultiSeriesLineIndicatorPersonalInjuryWithoutAccumulatedTime.render();
                    });
                });
            }

            //20-Gráfico tipo multiseries de línea, para las lesiones personales con y sin tiempo, acumulados, de los hijos del indicador
            $scope.chargeChartMultiSeriesLineIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens = Routing.generate("getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens", {id: indicatorId});
                $http.get(getDataChartMultiSeriesLineIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesLineIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens = new FusionCharts({
                            "type": "msline",
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
                        revenueChartMultiSeriesLineIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens.setTransparent(true);
                        revenueChartMultiSeriesLineIndicatorPersonalInjuryWithAndWithoutAccumulatedTimeFromChildrens.render();
                    });
                });
            }

            //21-Gráfico tipo multiseries de línea, para los días perdidos, sólo del indicador (período actual y anterior)
            $scope.chargeChartMultiSeriesLineIndicatorLostDaysAccumulatedTime = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesLineIndicatorLostDaysAccumulatedTime = Routing.generate("getDataChartMultiSeriesLineIndicatorLostDaysAccumulatedTime", {id: indicatorId});
                $http.get(getDataChartMultiSeriesLineIndicatorLostDaysAccumulatedTime).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesLineIndicatorLostDaysAccumulatedTime = new FusionCharts({
                            "type": "msline",
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
                        revenueChartMultiSeriesLineIndicatorLostDaysAccumulatedTime.setTransparent(true);
                        revenueChartMultiSeriesLineIndicatorLostDaysAccumulatedTime.render();
                    });
                });
            }

            //22-Gráfico tipo multiseries columna 3d, para mostrar el resultado de una suma de variables de los indicadores hijos (lesionados con tiempo perdidoa, sin tiempo perdido y días perdidos), según sea el caso del período actual y anterior
            $scope.chargeChartMultiSeriesIndicatorAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulated = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesIndicatorAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulated = Routing.generate("getDataChartMultiSeriesIndicatorAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulated", {id: indicatorId});
                $http.get(getDataChartMultiSeriesIndicatorAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulated).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesIndicatorAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulated = new FusionCharts({
                            "type": "mscolumn3d",
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
                        revenueChartMultiSeriesIndicatorAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulated.setTransparent(true);
                        revenueChartMultiSeriesIndicatorAssociatedPersonalInjuryWithAndWithoutAndLostDaysByPeriodWithAccumulated.render();
                    });
                });
            }

            //23-Gráfico tipo multiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de la suma de variables por frecuencia del indicador agrupados por compañia y del período actual y anterior (línea) y el acumulado por período (columna) al final.
            $scope.chargeChartMultiSeriesColumnLineIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulated = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulated = Routing.generate("getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulated", {id: indicatorId});
                $http.get(getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulated).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulated = new FusionCharts({
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
                        revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulated.setTransparent(true);
                        revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithAndWithoutAndLostDaysByFrequencyNotificationByPeriodGroupByCompanyWithAccumulated.render();
                    });
                });
            }

            //24-Gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de las lesiones con tiempo perdido por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
            $scope.chargeChartMultiSeriesColumnLineIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulated = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulated = Routing.generate("getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulated", {id: indicatorId});
                $http.get(getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulated).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulated = new FusionCharts({
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
                        revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulated.setTransparent(true);
                        revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithLostTimeByFrequencyNotificationByPeriodWithAccumulated.render();
                    });
                });
            }

            //25-Gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de las lesiones sin tiempo perdido por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
            $scope.chargeChartMultiSeriesColumnLineIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulated = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulated = Routing.generate("getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulated", {id: indicatorId});
                $http.get(getDataChartMultiSeriesColumnLineIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulated).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulated = new FusionCharts({
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
                        revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulated.setTransparent(true);
                        revenueChartMultiSeriesColumnLineIndicatorPersonalInjuryWithoutLostTimeByFrequencyNotificationByPeriodWithAccumulated.render();
                    });
                });
            }

            //26-Gráfico tipo mulsiseries columna + línea, todo respecto al mismo eje, para mostrar el resultado de los días perdidos por frecuencia de notificación del indicador del período actual y anterior (línea) y el acumulado por período (columna) al final.
            $scope.chargeChartMultiSeriesColumnLineIndicatorLostDaysByFrequencyNotificationByPeriodWithAccumulated = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesColumnLineIndicatorLostDaysByFrequencyNotificationByPeriodWithAccumulated = Routing.generate("getDataChartMultiSeriesColumnLineIndicatorLostDaysByFrequencyNotificationByPeriodWithAccumulated", {id: indicatorId});
                $http.get(getDataChartMultiSeriesColumnLineIndicatorLostDaysByFrequencyNotificationByPeriodWithAccumulated).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesColumnLineIndicatorLostDaysByFrequencyNotificationByPeriodWithAccumulated = new FusionCharts({
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
                        revenueChartMultiSeriesColumnLineIndicatorLostDaysByFrequencyNotificationByPeriodWithAccumulated.setTransparent(true);
                        revenueChartMultiSeriesColumnLineIndicatorLostDaysByFrequencyNotificationByPeriodWithAccumulated.render();
                    });
                });
            }

            //27-Gráfico sólo para avances de proyectos
            $scope.chargeChartProgressProjectsByFrequencyNotification = function (indicatorId, render, width, height) {
                var getDataChartProgressProjectsByFrequencyNotification = Routing.generate("getDataChartChartProgressProjectsByFrequencyNotification", {id: indicatorId});
                $http.get(getDataChartProgressProjectsByFrequencyNotification).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartProgressProjectsByFrequencyNotification = new FusionCharts({
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
                        revenueChartProgressProjectsByFrequencyNotification.setTransparent(true);
                        revenueChartProgressProjectsByFrequencyNotification.render();
                    });
                });
            }

            //28-Gráfico para mostrar información de 2 variables (respecto al eje izquierdo) y el resultado de la medición (respecto al eje derecho en valor porcentual), del indicador
            $scope.chargeChartColumnLineDualAxisByDifferentFrequencyNotification = function (indicatorId, render, width, height) {
                var getDataChartColumnLineDualAxisByDifferentFrequencyNotification = Routing.generate("getDataChartColumnLineDualAxisByDifferentFrequencyNotification", {id: indicatorId});
                $http.get(getDataChartColumnLineDualAxisByDifferentFrequencyNotification).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartColumnLineDualAxisByDifferentFrequencyNotification = new FusionCharts({
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
                        revenueChartColumnLineDualAxisByDifferentFrequencyNotification.setTransparent(true);
                        revenueChartColumnLineDualAxisByDifferentFrequencyNotification.render();
                    });
                });
            }

            //29-Gráfico tipo multiseries de línea, con un trendline de forma horizontal
            $scope.chargeChartMultiSeriesLineIndicatorWithTrendlineHorizontal = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesLineIndicatorWithTrendlineHorizontal = Routing.generate("getDataChartMultiSeriesLineIndicatorWithTrendlineHorizontal", {id: indicatorId});
                $http.get(getDataChartMultiSeriesLineIndicatorWithTrendlineHorizontal).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesLineIndicatorWithTrendlineHorizontal = new FusionCharts({
                            "type": "msline",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset,
                                "trendlines": data.dataSource.trendlines
                            }
                        });
                        revenueChartMultiSeriesLineIndicatorWithTrendlineHorizontal.setTransparent(true);
                        revenueChartMultiSeriesLineIndicatorWithTrendlineHorizontal.render();
                    });
                });
            }

            //30-Gráfico tipo Piramide 3D Seccionada Real
            $scope.chargeChartRealPyramid3DSectioned = function (indicatorId, render, width, height) {
                var getDataPyramid3DSectioned = Routing.generate("getDataPyramid3DSectioned", {id: indicatorId, type: 'real'});
                $http.get(getDataPyramid3DSectioned).success(function (data) {
                    FusionCharts.ready(function () {
//                        console.log(data.dataSource.data);
                        var pyramid3DSectioned = new FusionCharts({
                            "type": 'pyramid',
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": 'json',
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.data
                            }
                        });
                        pyramid3DSectioned.setTransparent(true);
                        pyramid3DSectioned.render();
                    });
                });
            }
            //31-Gráfico tipo Piramide 3D Seccionada Plan
            $scope.chargeChartPlanPyramid3DSectioned = function (indicatorId, render, width, height) {
                var getDataPyramid3DSectioned = Routing.generate("getDataPyramid3DSectioned", {id: indicatorId, type: 'plan'});
                $http.get(getDataPyramid3DSectioned).success(function (data) {
                    FusionCharts.ready(function () {
//                        console.log(data.dataSource.data);
                        var pyramid3DSectioned = new FusionCharts({
                            "type": 'pyramid',
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": 'json',
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "data": data.dataSource.data
                            }
                        });
                        pyramid3DSectioned.setTransparent(true);
                        pyramid3DSectioned.render();
                    });
                });
            }

            //32- GRAFICO DE COLUMNA APILADA QUE MUESTRA EL PLAN/REAL DE TODAS LAS VARIABLES DEL INDICADOR
            $scope.chargeChartStackedColumn3DbyIndicator = function (indicatorId, render, width, height) {
                var getDataStackedColumn3DbyIndicator = Routing.generate("getDataStackedColumn3DbyIndicator", {id: indicatorId});
                $http.get(getDataStackedColumn3DbyIndicator).success(function (data) {
                    FusionCharts.ready(function () {
                        var ChartStackedColumn3DbyIndicator = new FusionCharts({
                            "type": 'stackedcolumn2d',                            
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": 'json',                            
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,                                
                                "dataset": data.dataSource.dataset
                            }
                        });
                        ChartStackedColumn3DbyIndicator.setTransparent(true);
                        ChartStackedColumn3DbyIndicator.render();
                    });
                });
            }
            
            //33-Gráfico tipo multiseries de línea, con un trendline de forma horizontal y el valor de los resultados
            $scope.chargeChartMultiSeriesLineIndicatorWithTrendlineHorizontalOnlyResult = function (indicatorId, render, width, height) {
                var getDataChartMultiSeriesLineIndicatorWithTrendlineHorizontalOnlyResult = Routing.generate("getDataChartMultiSeriesLineIndicatorWithTrendlineHorizontalOnlyResult", {id: indicatorId});
                $http.get(getDataChartMultiSeriesLineIndicatorWithTrendlineHorizontalOnlyResult).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartMultiSeriesLineIndicatorWithTrendlineHorizontalOnlyResult = new FusionCharts({
                            "type": "msline",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset,
                                "trendlines": data.dataSource.trendlines
                            }
                        });
                        revenueChartMultiSeriesLineIndicatorWithTrendlineHorizontalOnlyResult.setTransparent(true);
                        revenueChartMultiSeriesLineIndicatorWithTrendlineHorizontalOnlyResult.render();
                    });
                });
            }

            //PRO_RT_PQV-Gráfico para ver la producción consolidada por los ReportTemplates de PQV
            $scope.chargeChartProductionReportTemplateByDate = function (reportTemplateId, dateSearch, render, width, height) {
                var dateParse = $scope.parseDate(dateSearch);
                var getDataChartProductionReportTemplateByDate = Routing.generate("getDataChartProductionReportTemplateByDate", {id: reportTemplateId, dateSearch: dateParse});

                $http.get(getDataChartProductionReportTemplateByDate).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartProductionReportTemplateByDate = new FusionCharts({
                            "type": "stackedcolumn3d",
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
                        revenueChartProductionReportTemplateByDate.setTransparent(true);
                        revenueChartProductionReportTemplateByDate.render();
                    });
                });
            }

            //PRO_RT_PQV-Gráfico para ver la producción consolidada por los ReportTemplates de PQV
            $scope.chargeChartProductionReportTemplateByDateGroupByCompany = function (typeCompany, dateSearch, render, width, height) {
                var dateParse = $scope.parseDate(dateSearch);
                var getDataChartProductionReportTemplateByDateGroupByCompany = Routing.generate("getDataChartProductionReportTemplateByDateGroupByCompany", {typeCompany: typeCompany, dateSearch: dateParse});

                $http.get(getDataChartProductionReportTemplateByDateGroupByCompany).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartProductionReportTemplateByDateGroupByCompany = new FusionCharts({
                            "type": "mscolumn3d",
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset,
                                "annotations": data.dataSource.annotations
                            }
                        });
                        revenueChartProductionReportTemplateByDateGroupByCompany.setTransparent(true);
                        revenueChartProductionReportTemplateByDateGroupByCompany.render();
                    });
                });
            }

            //PRO_RT_PQV-Gráfico para ver la producción consolidada por los ReportTemplates de PQV
            $scope.chargeChartProductionReportTemplateByDateCorporation = function (dateSearch, render, width, height, typeView) {
                var dateParse = $scope.parseDate(dateSearch);
                var getDataChartProductionReportTemplateByDateCorporation = Routing.generate("getDataChartProductionReportTemplateByDateCorporation", {dateSearch: dateParse, typeView: typeView});

                //Definimos el tipo de gráfico, de acuerdo al tipo de vista a visualizar
                var typeChart = "mscolumn3d";
                if (typeView == 1) {
                    typeChart = "mscolumn3dlinedy";
                }

                $http.get(getDataChartProductionReportTemplateByDateCorporation).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartProductionReportTemplateByDateCorporation = new FusionCharts({
                            "type": typeChart,
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset,
                                "annotations": data.dataSource.annotations
                            }
                        });
                        revenueChartProductionReportTemplateByDateCorporation.setTransparent(true);
                        revenueChartProductionReportTemplateByDateCorporation.render();
                    });
                });
            }

            $scope.chargeChartProductionByReportTemplateByDate = function (reportTemplateId, dateSearch, render, width, height, typeView, typeDate) {
                var dateParse = $scope.parseDate(dateSearch);
                console.log('hola');
                var getDataChartProductionByReportTemplateByDate = Routing.generate("getDataChartProductionByReportTemplateByDate", {reportTemplateId: reportTemplateId, dateSearch: dateParse, typeView: typeView, typeDate: typeDate});

                //Definimos el tipo de gráfico, de acuerdo al tipo de vista a visualizar
                var typeChart = "mscolumn3d";
                if (typeView == 1) {
                    typeChart = "mscolumn3dlinedy";
                }

                $http.get(getDataChartProductionByReportTemplateByDate).success(function (data) {
                    FusionCharts.ready(function () {
                        var revenueChartProductionByReportTemplateByDate = new FusionCharts({
                            "type": typeChart,
                            "renderAt": render,
                            "width": width + "%",
                            "height": height,
                            "dataFormat": "json",
                            "dataSource": {
                                "chart": data.dataSource.chart,
                                "categories": data.dataSource.categories,
                                "dataset": data.dataSource.dataset,
                                "annotations": data.dataSource.annotations
                            }
                        });
                        revenueChartProductionByReportTemplateByDate.setTransparent(true);
                        revenueChartProductionByReportTemplateByDate.render();
                    });
                });
            }

            // Función que devuelve una data formateada dd/mm/yyyy y recibe en dd-mm-yyyy
            $scope.parseDate = function parseDate(dateToParse) {
                var dateParse = new Date(dateToParse);
                var dd = dateParse.getDate();
                var mm = dateParse.getMonth() + 1; //January is 0!

                var yyyy = dateParse.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd;
                }
                if (mm < 10) {
                    mm = '0' + mm;
                }

                var dateParse = dd + '/' + mm + '/' + yyyy;

                return dateParse;
            };
            //PRO_RT_EEMM_FIL-Gráfico para ver la producción consolidada por los ReportTemplates de las Mixtas y Filiales


            //Gráfico en forma tacómetro (Usado para mostrar el resultado de los indicadores estratégicos en el dashboard)
            $scope.renderChartExample = function (indicatorId, render, width, height) {
                FusionCharts.ready(function () {
                    var chartAngularGauge = new FusionCharts({
                        "type": "angulargauge",
                        "renderAt": render,
                        "width": width + "%",
                        "height": height,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                "caption": "Speedometer",
                                "captionFont": "Arial",
                                "captionFontColor": "#333333",
                                "manageresize": "1",
                                "origw": "320",
                                "origh": "320",
                                "tickvaluedistance": "-10",
                                "bgcolor": "#FFFFFF",
                                "upperlimit": "240",
                                "lowerlimit": "0",
                                "basefontcolor": "#FFFFFF",
                                "majortmnumber": "9",
                                "majortmcolor": "#FFFFFF",
                                "majortmheight": "8",
                                "majortmthickness": "5",
                                "minortmnumber": "5",
                                "minortmcolor": "#FFFFFF",
                                "minortmheight": "3",
                                "minortmthickness": "2",
                                "pivotradius": "10",
                                "pivotbgcolor": "#000000",
                                "pivotbordercolor": "#FFFFFF",
                                "pivotborderthickness": "2",
                                "tooltipbordercolor": "#FFFFFF",
                                "tooltipbgcolor": "#333333",
                                "gaugeouterradius": "115",
                                "gaugestartangle": "240",
                                "gaugeendangle": "-60",
                                "gaugealpha": "0",
                                "decimals": "0",
                                "showcolorrange": "1",
                                "placevaluesinside": "1",
                                "pivotfillmix": "",
                                "showpivotborder": "1",
                                "annrenderdelay": "0",
                                "gaugeoriginx": "160",
                                "gaugeoriginy": "160",
                                "showborder": "0"
                            },
                            "dials": {
                                "dial": [
                                    {
                                        "value": "65",
                                        "bgcolor": "000000",
                                        "bordercolor": "#FFFFFF",
                                        "borderalpha": "100",
                                        "basewidth": "4",
                                        "topwidth": "4",
                                        "borderthickness": "2",
                                        "valuey": "260"
                                    }
                                ]
                            },
                            "annotations": {
                                "groups": [
                                    {
                                        "x": "160",
                                        "y": "160",
                                        "items": [
                                            {
                                                "type": "circle",
                                                "radius": "130",
                                                "fillasgradient": "1",
                                                "fillcolor": "#4B4B4B,#AAAAAA",
                                                "fillalpha": "100,100",
                                                "fillratio": "95,5"
                                            },
//                                            {
//                                                "type": "circle",
//                                                "x": "0",
//                                                "y": "0",
//                                                "radius": "120",
//                                                "showborder": "1",
//                                                "bordercolor": "cccccc",
//                                                "fillasgradient": "1",
//                                                "fillcolor": "#ffffff,#000000",
//                                                "fillalpha": "50,100",
//                                                "fillratio": "1,99"
//                                            }
                                        ]
                                    },
                                    {
                                        "x": "160",
                                        "y": "160",
                                        "showbelow": "0",
                                        "scaletext": "1",
                                        "items": [
                                            {
                                                "type": "text",
                                                "y": "100",
                                                "label": "KPH",
                                                "fontcolor": "#FFFFFF",
                                                "fontsize": "14",
                                                "bold": "1"
                                            }
                                        ]
                                    }
                                ]
                            }
                        }
                    });
                    chartAngularGauge.setTransparent(true);
                    chartAngularGauge.render();
                })
            }
        })

        .controller('ToolsController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {
            $scope.data = "none";

            $scope.isGrantedButtonEdit = function (id, index) {
                //index = index+1;
                var data;
                ;
                var getdataBarsArea = Routing.generate("getIsGrantEditButton", {id: id, index: index});
                $http.get(getdataBarsArea).success(function (data) {
                    //console.log(index+"->"+data);
                    //console.log(data);
                    if (data.data == "1") {
                        $("div#target_" + index).show();
                    }
                });

            }

            $scope.uploadFile = function () {
                //alert("hola");
                var f = document.getElementById('form_archivo').files[0],
                        r = new FileReader();
                r.onloadend = function (e) {
                    $scope.data = e.target.result;
                    //send you binary data via $http or $resource or do anything else with it
                }
                r.readAsBinaryString(f);
            }

            $scope.validLoad = function (valueIndicatorId) {
                var getValidLoad = Routing.generate("showButtonDownload", {id: valueIndicatorId});
                $http.get(getValidLoad).success(function (data) {
                    console.log(data);
                    if (data.data != "true") {
                        $("span#open_" + valueIndicatorId).hide();
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
                                "exportFormats": "PNG= Exportar Resultados",
                                "exportFileName": "Grafico Resultados " + gerencia,
                                "exporthandler": data.dataSource.chart.exporthandler,
                                "html5exporthandler": data.dataSource.chart.exporthandler,
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
                        },
                        "events": {
                            "renderComplete": function (e, a) {

                                // Cross-browser event listening
                                var addListener = function (elem, evt, fn) {
                                    if (elem && elem.addEventListener) {
                                        elem.addEventListener(evt, fn);
                                    } else if (elem && elem.attachEvent) {
                                        elem.attachEvent("on" + evt, fn);
                                    } else {
                                        elem["on" + evt] = fn;
                                    }
                                };

                                // Export chart method
                                var exportFC = function () {
                                    var types = {
                                        "exportpng": "png"
                                    };
                                    if (e && e.sender && e.sender.exportChart) {
                                        e.sender.exportChart({
                                            exportFileName: "FC_sample_export",
                                            exportFormat: types[this.id]
                                        });
                                    }
                                };
                                // Attach events 
                                addListener(document.getElementById("exportpng"), "click", exportFC);
                            }
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
                        "type": "pie3d",
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
        //Controlador Graficos SIG
        .controller('ChartsSigController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

            //Charts SIG - Evolution
            $scope.renderChartEvolutionSig = function (id, data, categories, dataPlan, dataReal, dataAcum, dataPorc, caption, typeLabelDisplay, urlExportFromChart) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "mscolumnline3d",
                        "renderAt": id,
                        "width": "95%",
                        //"height": "300%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "Gráfico Evolución Indicador",
                        "exporthandler": urlExportFromChart,
                        "html5exporthandler": urlExportFromChart,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        },
                        "events": {
                            "renderComplete": function (e, a) {

                                // Cross-browser event listening
                                var addListener = function (elem, evt, fn) {
                                    if (elem && elem.addEventListener) {
                                        elem.addEventListener(evt, fn);
                                    } else if (elem && elem.attachEvent) {
                                        elem.attachEvent("on" + evt, fn);
                                    } else {
                                        elem["on" + evt] = fn;
                                    }
                                };

                                // Export chart method
                                var exportFC = function () {
                                    var types = {
                                        "exportpng": "png"
                                    };
                                    if (e && e.sender && e.sender.exportChart) {
                                        e.sender.exportChart({
                                            exportFileName: "FC_sample_export",
                                            exportFormat: types[this.id]
                                        });
                                    }
                                };

                                // Attach events 
                                addListener(document.getElementById("exportpng"), "click", exportFC);
                            }
                        }

                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //FIN

            //Charts SIG - Causas de Desviación
            $scope.renderChartSigCs = function (id, data, categories, dataCause, caption, typeLabelDisplay, urlExportFromChart) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "stackedbar3d",
                        "renderAt": id,
                        "width": "95%",
                        "height": "650%",
                        "exportenabled": "1",
                        //"exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "Gráfico Causas de Desviación del Indicador",
                        "exporthandler": urlExportFromChart,
                        "html5exporthandler": urlExportFromChart,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        },
                        "events": {
                            "renderComplete": function (e, a) {

                                // Cross-browser event listening
                                var addListener = function (elem, evt, fn) {
                                    if (elem && elem.addEventListener) {
                                        elem.addEventListener(evt, fn);
                                    } else if (elem && elem.attachEvent) {
                                        elem.attachEvent("on" + evt, fn);
                                    } else {
                                        elem["on" + evt] = fn;
                                    }
                                };

                                // Export chart method
                                var exportFC = function () {
                                    var types = {
                                        "export_causespng": "png"
                                    };
                                    if (e && e.sender && e.sender.exportChart) {
                                        e.sender.exportChart({
                                            exportFileName: "FC_sample_export",
                                            exportFormat: types[this.id]
                                        });
                                    }
                                };

                                // Attach events 
                                addListener(document.getElementById("export_causespng"), "click", exportFC);
                            }
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //FIN
        })
        //

        .controller('ChartsProposalController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

            //Charts Proposal por linea
            $scope.renderChartProposal = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        //"type": "pie3d",                        
                        "renderAt": id,
                        "width": "95%",
                        "height": "500%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //FIN        
            //Charts Proposal por localidad
            $scope.renderChartProposalLocalidad = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        //"type": "pie3d",                        
                        "renderAt": id,
                        "width": "95%",
                        "height": "500%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //FIN
        })
        .controller('ChartsMeetingsController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

            //Charts 
            $scope.renderChartMeetings = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "pie3d",
                        "renderAt": id,
                        "width": "95%",
                        "height": "500%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //FIN   
        })

        .controller('displayCenterController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

            //Charts Votos General
            $scope.renderChartVotoGeneral = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "pie3d",
                        "renderAt": id,
                        "width": "120%",
                        "height": "65%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General
            $scope.renderChartVotoGeneral_2 = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "pie3d",
                        "renderAt": id,
                        "width": "80%",
                        "height": "35%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General
            $scope.renderChartVotoGeneral_3 = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "pie3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "45%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General
            $scope.renderChartVotoGeneralCircuito = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "pie3d",
                        "renderAt": id,
                        "width": "150%",
                        "height": "35%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General Horas
            $scope.renderChartVotoGeneralHours = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "mscolumnline3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "65%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General Horas
            $scope.renderChartVotoGeneralMcpo = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        "renderAt": id,
                        "width": "100%",
                        "height": "80%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General Parroquia
            $scope.renderChartVotoGeneralParroq = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "mscolumnline3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "90%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //Grafica de Barras para localidades
            $scope.renderChartVotoGeneralLocalidad = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "mscolumnline3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "45%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General
            $scope.renderChartVotoGeneralEstados = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "pie3d",
                        "renderAt": id,
                        "width": "120%",
                        //"height": "65%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General
            $scope.renderChartVotoGeneralParroquia = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        "type": "pie3d",
                        "renderAt": id,
                        "width": "120%",
                        //"height": "65%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //FIN   

            //Charts Votos PQV
            $scope.renderChartVotoPqv = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "pie3d",
                        "renderAt": id,
                        "width": "120%",
                        //"height": "100%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General Parroquia
            $scope.renderChartVotoGeneralCircuito5 = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "mscolumnline3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "70%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General Parroquia
            $scope.renderChartVotoGeneralCircuitoPoll = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "mscolumnline3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "48%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };

            //Charts Votos General Horas
            $scope.renderChartVotoGeneralHoursCircuito = function (id, data, categories, caption, typeLabelDisplay) {
                FusionCharts.ready(function () {
                    var revenueChart = new FusionCharts({
                        //"type": "mscolumn3dlinedy",
                        "type": "mscolumnline3d",
                        "renderAt": id,
                        "width": "100%",
                        "height": "55%",
                        "exportFormats": "PNG= Exportar como PNG|PDF= Exportar como PDF",
                        "exportFileName": "",
                        "exporthandler": "http://107.21.74.91/",
                        "html5exporthandler": "http://107.21.74.91/",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }
                    });
                    revenueChart.setTransparent(true);
                    revenueChart.render();
                })
            };
            //FIN   
        })

        .controller('ProductionController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {


            $scope.renderChartColumn3dLinedy = function (id, data, width, height) {
                FusionCharts.ready(function () {
                    var renderChartColumn3dLinedy = new FusionCharts({
                        "type": "mscolumn3dlinedy",
                        "renderAt": id,
                        "width": width + "%",
                        "height": height,
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": data.dataSource.chart,
                            "categories": data.dataSource.categories,
                            "dataset": data.dataSource.dataset
                        }


                    });
                    renderChartColumn3dLinedy.setTransparent(true);
                    renderChartColumn3dLinedy.render();
                });
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
            $scope.model = {ManagementSystem: []
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
        .controller('TableCenterListsController', function ($scope, ngTableParams, $http, sfTranslator, notifyService) {

            $scope.data = {
                complejos: null,
                first_line_managements: null,
                second_line_managements: null,
                coordinators: null,
            };
            $scope.model = {
                complejo: null,
                firstLineManagement: null,
                secondLineManagement: null,
                coordinator: null,
            };

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

            //Busca las localidades
            $scope.getCoordinators = function () {
                var parameters = {
                    filter: {}
                };
                $http.get(Routing.generate('pequiven_work_study_circle_coordinators', parameters))
                        .success(function (data) {
                            $scope.data.coordinators = data;
                            if ($scope.model.coordinator != null) {
                                $scope.setValueSelect2("selectCoordinators", $scope.model.coordinator, $scope.data.coordinators, function (selected) {
                                    $scope.model.coordinator = selected;
                                });
                            }
                        });
            };

            $scope.getComplejos();
            $scope.getFirstLineManagement();
//            $scope.getCoordinators();

            //Scope de Localidad
            $scope.$watch("model.complejo", function (newParams, oldParams) {
                if ($scope.model.complejo != null && $scope.model.complejo.id != undefined) {
                    $scope.tableParams.$params.filter['complejo'] = $scope.model.complejo.id;
                    //Al cambiar el select de localidad
                    selectComplejo.change(function () {
                        selectFirstLineManagement.select2("val", '');
                        selectSecondLineManagement.select2("val", '');
                    });
                } else {
                    $scope.tableParams.$params.filter['complejo'] = null;
                }
            }
            );
            //Scope de Gerencia de 1ra Línea
            $scope.$watch("model.firstLineManagement", function (newParams, oldParams) {
                if ($scope.model.firstLineManagement != null && $scope.model.firstLineManagement.id != undefined) {
                    $scope.tableParams.$params.filter['firstLineManagement'] = $scope.model.firstLineManagement.id;
                    selectSecondLineManagement.select2("enable", true);
                    //Al cambiar la gerencia de 1ra línea
                    selectFirstLineManagement.change(function () {
                        selectSecondLineManagement.select2("val", '');
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
                } else {
                    $scope.tableParams.$params.filter['secondLineManagement'] = null;
                }
            });

            //Scope de Coordinadores
            $scope.$watch("model.coordinator", function (newParams, oldParams) {
                if ($scope.model.coordinator != null) {
                    var coordinatorsId = [], i = 0;
                    var coordinators = angular.element("#coordinators").select2('data');
                    angular.forEach(coordinators, function (value) {
                        coordinatorsId.push(value.id);
                        i++;
                    });
                    if (i > 0) {
                        $scope.tableParams.$params.filter['coordinators'] = angular.toJson(coordinatorsId);
                    } else {
                        $scope.tableParams.$params.filter['coordinators'] = null;
                    }
                } else {
                    $scope.tableParams.$params.filter['coordinators'] = null;
                }
            });
        })
        ;
