Se agrego menu nuevo de los programas de gestion en el admin.
Se agrego eliminacion logica a los programas de gestion y sus items.

Se implemento acl:
app/console init:acl
app/console sonata:admin:setup-acl --env=prod
php -d memory_limit=-1 app/console sonata:admin:generate-object-acl --env=prod

Se agrego nuevas entidades al administrador (Gerencia, Gerencia de segunda, Grupo de gerencia, Complejo).

UPDATE `seip_indicator` SET `lastDateCalculateResult`=null WHERE 1;
UPDATE `ArrangementProgram` SET `lastDateCalculateResult`=null WHERE 1;

Lista de objetos Sonata
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.formula                                  Pequiven\MasterBundle\Entity\Formula
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.formula.variable                         Pequiven\MasterBundle\Entity\Formula\Variable
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.formula.formula_detail                   Pequiven\MasterBundle\Entity\Formula\FormulaDetail
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.indicator.value_indicator                Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.indicator.tag_indicator                  Pequiven\IndicatorBundle\Entity\Indicator\TagIndicator
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.indicator.type_feature_indicator         Pequiven\MasterBundle\Entity\Indicator\TypeFeatureIndicator
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.objetive                                 Pequiven\ObjetiveBundle\Entity\Objetive
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.result                                   Pequiven\SEIPBundle\Entity\Result\Result
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.indicator.frequency_notification         Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicator
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.indicator.indicator                      Pequiven\IndicatorBundle\Entity\Indicator
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.indicator.indicator_details_admin        Pequiven\IndicatorBundle\Entity\Indicator\IndicatorDetails
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.indicator.report_template                Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.core.period                              Pequiven\SEIPBundle\Entity\Period
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.arrangement_program.arrangement_program  Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.arrangement_program.goal                 Pequiven\ArrangementProgramBundle\Entity\Goal
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.arrangement_program.goal_details         Pequiven\ArrangementProgramBundle\Entity\GoalDetails
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.arrangement_program.timeline             Pequiven\ArrangementProgramBundle\Entity\Timeline
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.arrangement_range.arrangement_range      Pequiven\ArrangementBundle\Entity\ArrangementRange
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.line_strategic.line_strategic            Pequiven\MasterBundle\Entity\LineStrategic
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.chart                                    Pequiven\SEIPBundle\Entity\Chart
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.user.complejo                            Pequiven\MasterBundle\Entity\Complejo
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.user.gerencia                            Pequiven\MasterBundle\Entity\Gerencia
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.user.gerencia_second                     Pequiven\MasterBundle\Entity\GerenciaSecond
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.user.gerencia_group                      Pequiven\MasterBundle\Entity\GerenciaGroup
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.cause_stop                           Pequiven\SEIPBundle\Entity\CEI\CauseStop
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.company                              Pequiven\SEIPBundle\Entity\CEI\Company
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.location                             Pequiven\SEIPBundle\Entity\CEI\Location
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.entity                               Pequiven\SEIPBundle\Entity\CEI\Entity
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.plant                                Pequiven\SEIPBundle\Entity\CEI\Plant
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.product                              Pequiven\SEIPBundle\Entity\CEI\Product
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.service                              Pequiven\SEIPBundle\Entity\CEI\Service
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.country                              Pequiven\SEIPBundle\Entity\CEI\Country
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.currency                             Pequiven\SEIPBundle\Entity\CEI\Currency
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.production_line                      Pequiven\SEIPBundle\Entity\CEI\ProductionLine
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.record_type                          Pequiven\SEIPBundle\Entity\CEI\RecordType
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.sector                               Pequiven\SEIPBundle\Entity\CEI\Sector
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.sub_sector                           Pequiven\SEIPBundle\Entity\CEI\SubSector
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.type_incidence                       Pequiven\SEIPBundle\Entity\CEI\TypeIncidence
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.type_location                        Pequiven\SEIPBundle\Entity\CEI\TypeLocation
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.fail                                 Pequiven\SEIPBundle\Entity\CEI\Fail
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.unit_measure                         Pequiven\SEIPBundle\Entity\CEI\UnitMeasure
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.region                               Pequiven\SEIPBundle\Entity\CEI\Region
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.cei.stop_time                            Pequiven\SEIPBundle\Entity\CEI\StopTime
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.configuration                            Tecnocreaciones\Bundle\ToolsBundle\Entity\Configuration\Configuration
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.configuration_group                      Tecnocreaciones\Bundle\ToolsBundle\Entity\Configuration\BaseGroup
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.sig_management_system                    Pequiven\SIGBundle\Entity\ManagementSystem
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.sig_politic_management_system            Pequiven\SIGBundle\Entity\PoliticManagementSystem
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.vzla_entity.country                      Tecnocreaciones\Vzla\EntityBundle\Entity\Country
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.vzla_entity.region                       Tecnocreaciones\Vzla\EntityBundle\Entity\Region
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.vzla_entity.state                        Tecnocreaciones\Vzla\EntityBundle\Entity\State
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.vzla_entity.municipality                 Tecnocreaciones\Vzla\EntityBundle\Entity\Municipality
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.vzla_entity.parish                       Tecnocreaciones\Vzla\EntityBundle\Entity\Parish
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.admin.vzla_entity.city                         Tecnocreaciones\Vzla\EntityBundle\Entity\City
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.user.admin.user                                Pequiven\SEIPBundle\Entity\User
sonata:admin:generate-object-acl --env=prod --object_specific=sonata.user.admin.group                               Pequiven\MasterBundle\Entity\Rol