{% trans_default_domain 'PequivenIndicatorBundle' %}


<div class="block" ng-init="urlValueIndicatorForm='{{ path('pequiven_value_indicator_get_form',{'idIndicator':indicator.id}) }}'">
    <div class="block-title">
        <h3 class="ng-binding">{$ indicator.valuesIndicator.length $} {{ 'pequiven_indicator.results'|trans }}</h3>
        {#        {% if is_granted(['ROLE_WORKER_PLANNING','ROLE_INDICATOR_ADD_RESULT']) and indicator.typeOfCalculation == constant('Pequiven\\IndicatorBundle\\Model\\Indicator::TYPE_CALCULATION_FORMULA_MANUALLY')  %}#}

        {#        {% if (is_granted(['ROLE_SEIP_INDICATOR_ADD_NOTIFICATION_SPECIAL']) or (is_granted(['ROLE_SEIP_INDICATOR_ADD_NOTIFICATION_SPECIAL']) and (indicatorService.isIndicatorHasParents(indicator))  ) ) and indicator.typeOfCalculation == constant('Pequiven\\IndicatorBundle\\Model\\Indicator::TYPE_CALCULATION_FORMULA_MANUALLY')  %}#}
        {% if (
       (
        (is_granted(['ROLE_INDICATOR_ADD_RESULT']) and  indicatorService.isIndicatorHasParents(indicator) != true) 
        or 
        (is_granted(['ROLE_SEIP_INDICATOR_ADD_NOTIFICATION_SPECIAL']) and (indicatorService.isIndicatorHasParents(indicator)))
       ) and (indicatorService.isGrantedButton(indicator)) ) and
    indicator.typeOfCalculation == constant('Pequiven\\IndicatorBundle\\Model\\Indicator::TYPE_CALCULATION_FORMULA_MANUALLY') %}


        {% set textAbbr = indicator.frequencyNotificationIndicator ? indicator.frequencyNotificationIndicator.textAbbr : '' %}
        <div class="button-group absolute-right compact">
            <a class="button icon-list-add " href="" ng-click="loadTemplateValueIndicator()" title="">{{ 'pequiven.add'|trans({},'messages') ~ ' ' ~ (textAbbr|lower) }}&nbsp;#{$ (indicator.valuesIndicator.length + 1) $}</a>
        </div>

        {% endif %}
        </div>



        <div class="with-padding">
            {% set colspan = 5 %}
            <table class="simple-table responsive-table tables-extras" id="sorting-example2">
                <thead>
                    <tr>
                        <th scope="col" width="2%" class="header">{{ 'seip.table.header.nro'|trans({},'PequivenArrangementProgramBundle') }}</th>
                        <th scope="col" width="15%" class="header">
                            {{ 'seip.table.header.value'|trans({},'PequivenArrangementProgramBundle') }}</th>
                        <th scope="col" width="15%" class="hide-on-tablet header">{{ 'seip.table.header.created_at'|trans({},'PequivenArrangementProgramBundle') }}</th>
                        <th scope="col" width="30%" class="hide-on-mobile-portrait header">{{ 'seip.table.header.created_by'|trans({},'PequivenArrangementProgramBundle') }}</th>
                            {% if is_granted(['ROLE_WORKER_PLANNING','ROLE_INDICATOR_EDIT']) %}
                                {% set colspan = 6 %}
                            <th scope="col" width="15%" class="hide-on-mobile-portrait header">&nbsp;</th>
                            {% endif %}
                    </tr>
                </thead>
                <tbody>

                    <tr ng-repeat="valueIndicator in indicator.valuesIndicator"  ng-init="paso=$index;">

                        <td>{$ (paso+1) $}</td>
                        <th scope="row">
                            {% if isValueIndicatorConfig == true %}
                                <a href="#" ng-click="openPopUp(getUrlForValueIndicator(valueIndicator,paso))" class="showPopup">
                                {% endif %}
                                {$ valueIndicator.valueOfIndicator | myNumberFormat:2 $}
                                {% if isValueIndicatorConfig == true %}
                                </a>
                            {% endif %}
                        </th>
                        <td>{$ valueIndicator.createdAt | myDateTime $}</td>
                        <td>
                            {$ valueIndicator.createdBy.firstname + " "+ valueIndicator.createdBy.lastname $} <small class="tag">{$ " ("+valueIndicator.createdBy.username+")" $}</small>
                        </td>
                        {#                    {% if is_granted(['ROLE_WORKER_PLANNING','ROLE_INDICATOR_EDIT','ROLE_INDICATOR_ADD_RESULT']) %}#}
                        {#                    {% if is_granted(['ROLE_SEIP_INDICATOR_ADD_NOTIFICATION_SPECIAL']) %}#}
                        {#                        {% if is_granted(['ROLE_SEIP_INDICATOR_ADD_NOTIFICATION_SPECIAL','ROLE_INDICATOR_EDIT','ROLE_INDICATOR_ADD_RESULT']) %}#}
                        {% if ( 
                            ((is_granted(['ROLE_INDICATOR_EDIT']) and  indicatorService.isIndicatorHasParents(indicator) != true) 
                               or 
                              (is_granted(['ROLE_SEIP_INDICATOR_ADD_NOTIFICATION_SPECIAL']) and (indicatorService.isIndicatorHasParents(indicator))) 
                            ) 
                            or is_granted(['ROLE_SEIP_PLANNING_INDICATOR_EDIT'])
                        ) %}

                        <td class="align-right vertical-center">
                            <div ng-controller="ToolsController" ng-init="isGrantedButtonEdit({{ indicator.id }},paso+1)">
                                <form style="display: none" id="form_{$ valueIndicator.id $}" action="{{ path("pequiven_indicator_show",{id:indicator.id,uploadFile:(true)}) }}" method="POST" enctype="multipart/form-data">
                                    <input name="archivo" onChange="submitUploadFile(this.id)" id="indicatorFilePdf_{$ valueIndicator.id $}" type="file">
                                    {#                                    <input name="submit" type="submit" value="submit">#}
                                    <input type="hidden" name="valueIndicatorId" id="field_{$ valueIndicator.id $}" value="">
                                </form>
                            </div>
                            <div ng-controller="ToolsController" style="display: none;" id="target_{$ paso+1 $}">

                                <span class="select compact">
                                    <a href class="select-value form-edit">{{ 'pequiven.actions'|trans({},'messages') }}</a>
                                    <span class="select-arrow"></span>
                                    <span class="drop-down">
                                        <a href ng-click="loadTemplateValueIndicator(valueIndicator)" class="button icon-pencil">{{ "pequiven.actions.edit"|trans({},"messages") }}</a>
                                        {% if(is_granted(['ROLE_SEIP_PLANNING_INDICATOR_UPLOAD_FILE'])) %}
                                            <span class=" button icon-outbox" id="{$ valueIndicator.id $}" onClick="uploadFilePdf(this.id)">{{ "pequiven.actions.upload_file"|trans({},"messages") }}</span>
                                        {% endif %}
                                        {% if(is_granted(['ROLE_SEIP_PLANNING_INDICATOR_SHOW_FILE'])) %}
                                            <span ng-app ng-init="validLoad(valueIndicator.id)" class=" button icon-download" onClick="openFile(this.id)" id="open_{$ valueIndicator.id $}">
                                                {{ "pequiven.actions.download_file"|trans({},"messages") }}
                                            </span>
                                        {% endif %}
                                    </span>


                                </span>
                            </div>
                        </td>
                        {% endif %}



                        </tr>

                        <tr ng-if="indicator.valuesIndicator.length == 0">
                            <td colspan="{{ colspan }}" class="empty_row">
                                {{ "seip.table.empty.results"|trans({},'PequivenArrangementProgramBundle') }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>