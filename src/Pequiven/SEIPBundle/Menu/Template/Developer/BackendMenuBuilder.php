<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Menu\Template\Developer;

use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Vzla\GovernmentBundle\Menu\MenuBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\SEIPBundle\Entity\CEI\Company;

/**
 * Main menu builder.
 *
 * @author Anais Ortega <adcom23@tecnocreaciones.com.ve>
 */
class BackendMenuBuilder extends MenuBuilder implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    /**
     * Base de segundo nivel de sidebar
     * @var array 
     */
    private $secondLevelOptions = array('childrenAttributes' => array('class' => 'big-menu'));
    
    const ROUTE_DEFAULT = 'pequiven_seip_menu_home';
    
    protected $container;
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    /**
     * Builds backend sidebar menu (Construye el menu lateral del layout principal).
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createSidebarMenu(Request $request)
    {
        $seipConfiguration = $this->getSeipConfiguration();
        
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'big-menu',
            )
        ));
        $section = 'sidebar';
        $menu->addChild('home',array(
            'route' => self::ROUTE_DEFAULT,//Route
            'labelAttributes' => array('icon' => 'icon-home'),
        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.home', $section)));
        
        if($seipConfiguration->isEnablePrePlanning() && $this->isGranted('ROLE_SEIP_PRE_PLANNING_*')){
            $this->addMenuPrePlanning($menu, $section);
        }
        //$this->addExampleMenu($menu, $section);

        //Menu de objetivos
        if($this->isGranted('ROLE_SEIP_OBJECTIVE_*')){
            $this->addMenuObjetives($menu, $section);
        }
        
        //Menú Programas de Gestión
        if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_*')){
            $this->addArrangementProgramsMenu($menu, $section);
        }
        
        //Menu de indicadores
        if($this->isGranted('ROLE_SEIP_INDICATOR_*')){
            $this->addMenuIndicators($menu, $section);
        }
        
        //Menu de Resultados
        if($this->isGranted('ROLE_SEIP_RESULT_*')){
            $this->addMenuResults($menu, $section);
        }
        
        //Menú Estadística e Información
        if($this->isGranted('ROLE_SEIP_PLANNING_*')){
            $this->addPlanningMenu($menu, $section);
        }
        
        //Menú SIG
        if($this->isGranted('ROLE_SEIP_SIG_MENU')){
            $this->addMenuSIG($menu, $section);
        }
        
        //Menú Administración
        if($this->securityContext->isGranted(array('ROLE_SONATA_ADMIN'))){
            $menu->addChild('admin', array(
                'route' => 'sonata_admin_dashboard',
                'labelAttributes' => array('icon' => 'icon-card'),
            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.main',$section)));
        }

        return $menu;
    }
    
    public function createBreadcrumbsMenu(Request $request) {
    	//
        $bcmenu = $this->createSidebarMenu($request);
        return $this->getCurrentMenuItem($bcmenu);
    }
    
    /**
     * Construye y añade el menu de objetivos
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuSIG(ItemInterface $menu, $section) {
        $menuSig = $this->factory->createItem('sig',
                $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'fa fa-cubes',),
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.main', $section)));
        
            
                //Menú Nivel 2: Visualizar
                $objective = $this->factory->createItem('objective.main',
                        $this->getSubLevelOptions(array(
                        'uri' => 'objetive',
                        'labelAttributes' => array('icon' => '',),
                        ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.objective.main', $section)));
               //Ver 
                $objective->addChild('sig.objective.list', array(
                        'route' => '',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.objective.visualize', $section)));

                $objective->addChild('sig.objective.matrices_objectives', array(
                        'route' => '',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.objective.matrices_objectives', $section)));

                $menuSig->addChild($objective);
                
                $indicator = $this->factory->createItem('indicator.main',
                        $this->getSubLevelOptions(array(
                        'uri' => 'indicator',
                        'labelAttributes' => array('icon' => '',),
                        ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.indicator.main', $section)));
               //Ver 
                $indicator->addChild('sig.indicator.list', array(
                        'route' => '',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.indicator.visualize', $section)));

                $menuSig->addChild($indicator);
                
                
                //Sección Programas de Gestión
                $arrangementProgram = $this->factory->createItem('arrangement_program.main',
                        $this->getSubLevelOptions(array(
                        'uri' => 'arrangement_program',
                        'labelAttributes' => array('icon' => '',),
                        ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.main', $section)));
                
                if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_*'))
                {
                    //Menú Nivel 2: Visualizar
                     $visualize = $this->factory->createItem('sig.arrangement_programs.visualize',
                            $this->getSubLevelOptions(array(
                            'uri' => 'null',
                            'labelAttributes' => array('icon' => '',),
                            ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.main', $section)));
                     if($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_LIST_ALL')){
                        $visualize
                            ->addChild('sig.arrangement_program.visualize.listAll', array(
                                'route' => 'pequiven_seip_sig_arrangementprogram_all',
                            ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.listAll', $section)));
                     }

                    $arrangementProgram->addChild($visualize);
                }
                
                //Añadir
                if($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_CREATE_*')){

                    $subchild = $this->factory->createItem('sig.arrangement_program.add.main',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.main', $section)));

                    if($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_CREATE_TACTIC')){
                        $subchild
                        ->addChild('sig.arrangement_program.add.tactic', array(
                            'route' => 'pequiven_arrangementprogram_create',
                            'routeParameters' => array('type' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC, 'associate' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG),
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.add.tactic', $section)));
                    }
                    if($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_CREATE_OPERATIVE')){
                        $subchild->addChild('sig.arrangement_program.add.operative', array(
                            'route' => 'pequiven_arrangementprogram_create',
                            'routeParameters' => array('type' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE, 'associate' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG),
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.add.operative', $section)));
                    }

                    $arrangementProgram->addChild($subchild);
                }

                $menuSig->addChild($arrangementProgram);
                
        $menu->addChild($menuSig);
    }
    
    /**
     * Construye el menú de Administración
     * @param \Knp\Menu\ItemInterface $menu
     * @param type $section
     */
    function addAdministrationMenu(ItemInterface $menu, $section){
        $child = $this->factory->createItem('admin',
                $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'icon-book',),
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.main', $section)));
        
                //Gerencia de 1ra Línea
                $subchild = $this->factory->createItem('admin.gerencia_first',
                        $this->getSubLevelOptions(array(
                        'uri' => 'gerencia_first',
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.gerencia_first.main', $section)));
                
                $subchild->addChild('admin.gerencia_first.list', array(
                            'route' => 'pequiven_master_menu_list_gerenciaFirst',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.gerencia_first.list', $section)));
                $subchild->addChild('admin.gerencia_first.add', array(
                            'route' => 'pequiven_master_menu_add_gerenciaFirst',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.gerencia_first.add', $section)));
                
                $child->addChild($subchild);
        
                //Gerencia de 2da Línea
                $subchild = $this->factory->createItem('admin.gerencia_second',
                        $this->getSubLevelOptions(array(
                        'uri' => 'gerencia_second',
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.gerencia_second.main', $section)));
                
                $subchild->addChild('admin.gerencia_second.list', array(
                            'route' => 'pequiven_master_menu_list_gerenciaSecond',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.gerencia_second.list', $section)));
                $subchild->addChild('admin.gerencia_second.add', array(
                            'route' => 'pequiven_master_menu_add_gerenciaSecond',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.gerencia_second.add', $section)));
                
                $child->addChild($subchild);
                
        $menu->addChild($child);
    }
    
    /**
     * Agregando menu de planificacion
     * 
     * @param ItemInterface $menu
     * @param type $section
     */
    function addPlanningMenu(ItemInterface $menu, $section) 
    {
        $title = $this->trans('statisticsAndInformation', array(), 'PequivenSEIPBundle');
        $gerenciasResume = \Pequiven\MasterBundle\Entity\Gerencia::getLabelsResume();
        if($this->getUser()->getGerencia() && $this->getUser()->getGerencia()->getRef() == $gerenciasResume[\Pequiven\MasterBundle\Entity\Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]){
            $title = $this->trans('internalAudit', array(), 'PequivenSEIPBundle');
        }
        
        $child = $this->factory->createItem('planning',
            $this->getSubLevelOptions(array(
                'uri' => null,
                'labelAttributes' => array('icon' => 'fa fa-bar-chart',),
            )))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.main', $section),array('%titulo%' => $title)));
        
        if($this->isGranted('ROLE_SEIP_PLANNING_LIST_*')){
            
            $visualize = $this->factory->createItem('planning.visualize',
                $this->getSubLevelOptions(array(
                'labelAttributes' => array('icon' => '',),
                ))
            )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
            
            if($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_*')){
                $subchild = $this->factory->createItem('planning.visualize.objetives',
                            $this->getSubLevelOptions(array(
                            'uri' => null,
                            'labelAttributes' => array('icon' => 'fa fa-cubes',),
                            ))
                        )
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.main', $section)));
                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_STRATEGIC')){
                    $subchild->addChild('planning.visualize.objetives.strategic', array(
                                'route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_ESTRATEGICO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.strategic', $section)));
                }

                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_TACTIC')){
                    $subchild->addChild('planning.visualize.objetives.tactic', array(
                                'route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_TACTICO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.tactic', $section)));
                }
                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_OPERATIVE')){
                    $subchild->addChild('planning.visualize.objetives.operative', array(
                                'route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_OPERATIVO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.operative', $section)));
                }
                
                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_MATRIX_OBJECTIVES')){
                    $subchild->addChild('planning.visualize.objetive.matriz',
                    array(
                    'uri' => null,
                    'route' => 'pequiven_master_menu_list_gerenciaFirst',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.matriz', $section)));
                }

                $visualize->addChild($subchild);
            }//Fin sub Ver - menu objetivos
            
            if($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_*')){
                $subchild = $this->factory->createItem('planning.visualize.indicators',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'fa fa-line-chart',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.main', $section)));
                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_STRATEGIC')){
                    $subchild->addChild('planning.visualize.indicators.strategic', array(
                        'route' => 'pequiven_indicator_list',
                        'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_ESTRATEGICO)
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.strategic', $section)));
                }
                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_TACTIC')){
                    $subchild->addChild('planning.visualize.indicators.tactic', array(
                        'route' => 'pequiven_indicator_list',
                        'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_TACTICO)
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.tactic', $section)));
                }
                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_OPERATIVE')){
                    $subchild->addChild('planning.visualize.indicators.operative', array(
                        'route' => 'pequiven_indicator_list',
                        'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO)
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.operative', $section)));
                }
                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_ERROR')){
                    $subchild->addChild('planning.visualize.indicators.error', array(
                        'route' => 'pequiven_indicator_list_error',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.withError', $section)));
                }

                $visualize->addChild($subchild);
            }//Fin menu Ver - Indicadores
            
            if($this->isGranted('ROLE_SEIP_PLANNING_LIST_ARRANGEMENT_PROGRAM')){
                $subchild = $this->factory->createItem('planning.visualize.arrangement_programs',
                    $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'fa fa-tasks',),
                    ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.arrangement_programs.main', $section)));
                
                $subchild->addChild('planning.visualize.arrangement_programs.list', array(
                    'route' => 'pequiven_seip_arrangementprogram_all'
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.arrangement_programs.list', $section)));
                
                $visualize->addChild($subchild);
            }
            
            if($this->isGranted('ROLE_SEIP_PLANNING_LIST_RESULT_*')){
                
                if($this->isGranted('ROLE_SEIP_PLANNING_LIST_RESULT_ALL')){
                    $visualize->addChild('planning.visualize.results.all', array(
                        'route' => 'pequiven_result_list',
                        'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO)
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.results.main', $section)));
                }
            }
            $child->addChild($visualize);
        }
                
        if($this->isGranted('ROLE_SEIP_PLANNING_OPERATION_*')){
            $subchild = $this->factory->createItem('planning.operations',
                $this->getSubLevelOptions(array(
                'uri' => null,
                ))
            )->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.operations.main', $section)));
            
            if($this->isGranted('ROLE_SEIP_PLANNING_OPERATION_RECALCULATE_RESULT')){
                $subchild->addChild('planning.operations.recalculate_result', array(
                    'route' => 'pequiven_result_recalculate',
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.operations.recalculate_results', $section)));
            }

            $child->addChild($subchild);
        }
        
        if($this->isGranted('ROLE_SEIP_PLANNING_MONITOR_*')){
            $subchild = $this->factory->createItem('planning.monitor',
                $this->getSubLevelOptions(array(
                    'uri' => null,
                ))
            )->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.monitor.main',$section)));
            
            if($this->isGranted('ROLE_SEIP_PLANNING_MONITOR_OBJECTIVE_TACTIC')){
                $subchild->addChild('planning.monitor.objective_tactic', array(
                    'route' => 'monitorObjetiveTactic',
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.monitor.objective_tactic', $section)));
            }
            if($this->isGranted('ROLE_SEIP_PLANNING_MONITOR_OBJECTIVE_OPERATIVE')){
                $subchild->addChild('planning.monitor.objective_operative', array(
                    'route' => 'monitorObjetiveOperative',
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.monitor.objective_operative', $section)));
            }
            if($this->isGranted('ROLE_SEIP_PLANNING_MONITOR_ARRANGEMENT_PROGRAM')){
                $subchild->addChild('planning.monitor.arrangement_program', array(
                    'route' => 'monitorArrangementProgram',
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.monitor.arrangement_program', $section)));
            }
            
            $child->addChild($subchild);
        }
        
        //Menu de carga de datos
        if($this->isGranted('ROLE_SEIP_DATA_LOAD_*')){
            $this->addDataLoad($child, $section);
        }
        
        $menu->addChild($child);
    }
    
    private function addMenuPrePlanning(ItemInterface $menu, $section) {
        $nextPeriod = $this->getPeriodService()->getNextPeriod();
        $periodName = null;
        if($nextPeriod){
            $periodName = $nextPeriod->getName();
        }
        if($periodName === null){
            return;
        }
        $child = $this->factory->createItem('preplanning',
            $this->getSubLevelOptions(array(
                'uri' => null,
                'labelAttributes' => array('icon' => 'fa fa-calendar',),
            )))
            ->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.main', $section),array('%period%' => $periodName)));
        
        if($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_*')){
            $preplanningAdd = $this->factory->createItem('preplanning.add',
                $this->getSubLevelOptions(array(
                    'uri' => 'add',
                    'labelAttributes' => array('icon' => 'icon-book'),
                ))
            )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.main',$section)));
            
            if($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC')){
                $preplanningAdd->addChild('preplanning.add.tactic',array(
                    'route' => 'pequiven_pre_planning_create',//Route
                    'labelAttributes' => array('icon' => 'fa fa-cube'),
                    'routeParameters' => array('period' => $periodName,'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO),
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.tactic', $section)));
            }

            if($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE')){
                $preplanningAdd->addChild('preplanning.add.operative',array(
                    'route' => 'pequiven_pre_planning_create',//Route
                    'labelAttributes' => array('icon' => 'fa fa-cog'),
                    'routeParameters' => array('period' => $periodName,'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO),
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.operative', $section)));
            }
            $child->addChild($preplanningAdd);
        }
        
        if($this->isGranted('ROLE_SEIP_PRE_PLANNING_LIST_*')){
            $visualize = $this->factory->createItem('preplanning.visualize',
                $this->getSubLevelOptions(array(
                'labelAttributes' => array('icon' => 'fa fa-sitemap',),
                ))
            )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
            if($nextPeriod){
                if($this->isGranted('ROLE_SEIP_PRE_PLANNING_LIST_PLANNING')){
                    $visualize->addChild('preplanning.visualize.planning',array(
                        'route' => 'pequiven_pre_planning_user_index',//Route
                        'labelAttributes' => array('icon' => ''),
                        'routeParameters' => array('period' => $periodName,'type' => \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser::FORM_PLANNING),
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.planning', $section)));
                }
                if($this->isGranted('ROLE_SEIP_PRE_PLANNING_LIST_STATISTICS')){
                    $visualize->addChild('preplanning.visualize.statistics',array(
                        'route' => 'pequiven_pre_planning_user_index',//Route
                        'labelAttributes' => array('icon' => ''),
                        'routeParameters' => array('period' => $periodName,'type' => \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser::FORM_STATISTICS),
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.statistics', $section)));
                }
            }
            $child->addChild($visualize);
        }
        
        $menu->addChild($child);
    }


    /**
     * Construye y añade el menu de objetivos
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuObjetives(ItemInterface $menu, $section) {
        $menuObjetives = $this->factory->createItem('objetives',
                $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'fa fa-cubes',),
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.main', $section)));
        
            
                if($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_*')){
                    //Menú Nivel 2: Visualizar
                    $visualize = $this->factory->createItem('objetives.visualize',
                            $this->getSubLevelOptions(array(
                            'uri' => 'objetive',
                            'labelAttributes' => array('icon' => '',),
                            ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
                    //Menú Nivel 3: Item de visulizar
                    if($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_STRATEGIC')){
                        $visualize->addChild('arrangement_strategic.objetives.list.strategic', array(
                                'route' => 'pequiven_objetive_menu_list_strategic',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.strategic', $section)));
                    }
                    if($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_TACTIC')){
                        $visualize->addChild('arrangement_strategic.objetives.list.tactic', array(
                                'route' => 'pequiven_objetive_menu_list_tactic',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.tactic', $section)));
                    }
                    if($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_OPERATIVE')){
                        $visualize->addChild('arrangement_strategic.objetives.list.operative', array(
                                'route' => 'pequiven_objetive_menu_list_operative',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.operative', $section)));
                    }
                    
                    if($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_MATRIX_OBJECTIVES')){
                        //Matrices objectives
                        $visualize->addChild('objetives.matrices_objectives',
                            array(
                                'route' => 'pequiven_master_menu_list_gerenciaFirst',
                            )
                        )
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.matrices_objectives', $section)));
                    }
                    
                    $menuObjetives->addChild($visualize);
                }
            
                if($this->isGranted('ROLE_SEIP_OBJECTIVE_CREATE_*')){
                    $thirdchild = $this->factory->createItem('arrangement_strategic.objetives.add',
                            $this->getSubLevelOptions(array(
                                'uri' => 'add',
                                'labelAttributes' => array('icon' => 'icon-book'),
                            ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.main',$section)));
                    
                    //Si el usuario logueado es Rol Ejecutivo o Ejecutivo Asignado
                    if($this->isGranted('ROLE_SEIP_OBJECTIVE_CREATE_STRATEGIC')){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.strategic', array(
                            'route' => 'pequiven_objetive_menu_add_strategic',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.strategic', $section)));
                    }
                    if($this->isGranted('ROLE_SEIP_OBJECTIVE_CREATE_TACTIC')){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.tactic', array(
                            'route' => 'pequiven_objetive_menu_add_tactic',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.tactic', $section)));
                    }
                    if($this->isGranted('ROLE_SEIP_OBJECTIVE_CREATE_OPERATIVE')){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.operative', array(
                            'route' => 'pequiven_objetive_menu_add_operative',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.operative', $section)));
                    }
                    
                    $menuObjetives->addChild($thirdchild);
                }
                
        $menu->addChild($menuObjetives);
    }
    
    /**
     * Construye y añade el menu de indicadores
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuIndicators(ItemInterface $menu, $section) {
        $menuIndicators = $this->factory->createItem('indicators',
                $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'fa fa-line-chart',),
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.main', $section)));
               
                if($this->isGranted('ROLE_SEIP_INDICATOR_LIST_*')){
                    //Menú Nivel 3: Lista de Indicadores
                    $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.list',
                        $this->getSubLevelOptions(array(
                            'uri' => 'list',
                        )))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.main',$section)));
                    
                    if($this->isGranted('ROLE_SEIP_INDICATOR_LIST_STRATEGIC')){
                        $itemIndicatorsStrategic = $this->factory->createItem('arrangement_strategic.indicators.list.strategic', array(
                            'route' => 'pequiven_indicator_menu_list_strategic',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.strategic', $section)));
                        $thirdchild->addChild($itemIndicatorsStrategic);
                    }
                    if($this->isGranted('ROLE_SEIP_INDICATOR_LIST_TACTIC')){
                        $itemIndicatorsTactic = $this->factory->createItem('arrangement_strategic.indicators.list.tactic', array(
                            'route' => 'pequiven_indicator_menu_list_tactic',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.tactic', $section)));
                        $thirdchild->addChild($itemIndicatorsTactic);
                    }
                    if($this->isGranted('ROLE_SEIP_INDICATOR_LIST_OPERATIVE')){
                        $itemIndicatorsOperative = $this->factory->createItem('arrangement_strategic.indicators.list.operative', array(
                            'route' => 'pequiven_indicator_menu_list_operative',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.operative', $section)));
                        $thirdchild->addChild($itemIndicatorsOperative);
                    }
                    
                    $menuIndicators->addChild($thirdchild);
                }
                    
                if($this->isGranted('ROLE_SEIP_INDICATOR_CREATE_*')){
                    //Menú Nivel 3: Registro de Indicadores
                        $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.add',
                                $this->getSubLevelOptions(array(
                                    'uri' => 'add',
                                ))
                            )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.main',$section)));

                        if($this->isGranted('ROLE_SEIP_INDICATOR_CREATE_STRATEGIC')){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.strategic', array(
                                'route' => 'pequiven_indicator_menu_add_strategic',
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.strategic', $section)));
                        }
                        if($this->isGranted('ROLE_SEIP_INDICATOR_CREATE_TACTIC')){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.tactic', array(
                                'route' => 'pequiven_indicator_menu_add_tactic',
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.tactic', $section)));
                        }
                        if($this->isGranted('ROLE_SEIP_INDICATOR_CREATE_OPERATIVE')){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.operative', array(
                                'route' => 'pequiven_indicator_menu_add_operative',
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.operative', $section)));
                        }

                        $menuIndicators->addChild($thirdchild);
                }
        
            //Menu de carga de notificaciones
            if($this->isGranted('ROLE_SEIP_DATA_LOAD_*')){
                $this->addDataLoadNotification($menuIndicators, $section);
            }
        
        $menu->addChild($menuIndicators);
    }
    
    /**
     * Construye y añade el menu de objetivos
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuResults(ItemInterface $menu, $section) {
        $menuResults = $this->factory->createItem('results',
                $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'fa fa-book',),
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.results.main', $section)));
             if($this->isGranted('ROLE_SEIP_RESULT_LIST_*')){
                //Menú Nivel 2: Visualizar
                $visualize = $this->factory->createItem('results.visualize',
                        $this->getSubLevelOptions(array(
                        'uri' => 'objetive',
                        'labelAttributes' => array('icon' => '',),
                        ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.main', $section)));
                
                    if($this->isGranted('ROLE_SEIP_RESULT_LIST_BY_MANAGEMENT')){
                        $itemByGerenciaVisualize = $this->factory->createItem('results.visualize.by_gerencia', array(
                            'route' => 'pequiven_seip_result_visualize_by_gerencia',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.by_gerencia', $section)));
                        $visualize->addChild($itemByGerenciaVisualize);
                    }
                    
                    if($this->isGranted('ROLE_SEIP_RESULT_LIST_STRATEGICS')){
                        $itemStrategicsVisualize = $this->factory->createItem('results.visualize.by_lineStrategic', array(
                            'route' => 'pequiven_line_strategic_view_dashboard',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.by_lineStrategic', $section)));
                        $visualize->addChild($itemStrategicsVisualize);
                        
                        $itemStrategicsVisualize = $this->factory->createItem('results.visualize.indicator.strategics', array(
                            'route' => 'pequiven_line_strategic_indicators_strategics',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.indicator.strategics', $section)));
                        $visualize->addChild($itemStrategicsVisualize);
                        
                        $itemStrategicsObjetives = $this->factory->createItem('results.visualize.objetive.strategics', array(
                            'route' => 'pequiven_line_strategic_view_objetives_strategics',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.objetive.strategics', $section)));
                        $visualize->addChild($itemStrategicsObjetives);
                    }
                    
                     $itemPeriod = $this->factory->createItem('results.period',$this->getSubLevelOptions())
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.main', $section)));
                
                if($this->isGranted('ROLE_SEIP_RESULT_LIST_PERIOD')){
                    //Periodos
                    $periods = $this->container->get('pequiven.repository.period')->findAllForConsultation();
                    foreach ($periods as $period) {
                        $_period = $period->getId();
                        $year = $period->getYear();
                        $itemName = 'results.notify.period.'.$period->getId();
                        $itemPeriodConsultation = $this->factory->createItem($itemName,$this->getSubLevelOptions(
                             array()
                        ))->setLabel($year);

                        $itemPeriodConsultationObjetives = $this->factory->createItem($itemName.$_period.'objetives',$this->getSubLevelOptions(
                             array(
                            )
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.objetives', $section)));

                            $itemPeriodConsultationStrategic = $this->factory->createItem($itemName.$_period.'objetives'.'strategic',$this->getSubLevelOptions(
                                 array(
                                    'route' => "pequiven_seip_result_visualize_objetives",
                                    'routeParameters' => array('_period' => $_period,'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO),
                                )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.strategic', $section)));
                            $itemPeriodConsultationObjetives->addChild($itemPeriodConsultationStrategic);

                            $itemPeriodConsultationTactic = $this->factory->createItem($itemName.$_period.'objetives'.'tactic',$this->getSubLevelOptions(
                                 array(
                                    'route' => "pequiven_seip_result_visualize_objetives",
                                    'routeParameters' => array('_period' => $_period,'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO),
                                )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.tactic', $section)));
                            $itemPeriodConsultationObjetives->addChild($itemPeriodConsultationTactic);

                            $itemPeriodConsultationOperative = $this->factory->createItem($itemName.$_period.'objetives'.'operative',$this->getSubLevelOptions(
                                 array(
                                    'route' => "pequiven_seip_result_visualize_objetives",
                                    'routeParameters' => array('_period' => $_period,'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO),
                                )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.operative', $section)));
                            $itemPeriodConsultationObjetives->addChild($itemPeriodConsultationOperative);
                            
                        $itemPeriodConsultation->addChild($itemPeriodConsultationObjetives);

                        $itemPeriodConsultationIndicators = $this->factory->createItem($itemName.$_period.'indicators',$this->getSubLevelOptions(
                             array(
                            )
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.indicators', $section)));
                            $itemPeriodConsultationIndicatorsStrategic = $this->factory->createItem($itemName.$_period.'indicators'.'strategic',$this->getSubLevelOptions(
                                     array(
                                        'route' => "pequiven_seip_result_visualize_indicators",
                                        'routeParameters' => array('_period' => $_period,'level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_ESTRATEGICO),
                                    )
                                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.strategic', $section)));
                            $itemPeriodConsultationIndicators->addChild($itemPeriodConsultationIndicatorsStrategic);
                            
                            $itemPeriodConsultationIndicatorsTactic = $this->factory->createItem($itemName.$_period.'indicators'.'tactic',$this->getSubLevelOptions(
                                     array(
                                        'route' => "pequiven_seip_result_visualize_indicators",
                                        'routeParameters' => array('_period' => $_period,'level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_TACTICO),
                                    )
                                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.tactic', $section)));
                            $itemPeriodConsultationIndicators->addChild($itemPeriodConsultationIndicatorsTactic);
                            
                            $itemPeriodConsultationIndicatorsOperative = $this->factory->createItem($itemName.$_period.'indicators'.'operative',$this->getSubLevelOptions(
                                     array(
                                        'route' => "pequiven_seip_result_visualize_indicators",
                                        'routeParameters' => array('_period' => $_period,'level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO),
                                    )
                                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.operative', $section)));
                            $itemPeriodConsultationIndicators->addChild($itemPeriodConsultationIndicatorsOperative);
                            
                        $itemPeriodConsultation->addChild($itemPeriodConsultationIndicators);
                        

                        $itemPeriodArrangementPrograms = $this->factory->createItem($itemName.$_period.'arrangement_programs',$this->getSubLevelOptions(
                             array(
                                'route' => "pequiven_seip_result_visualize_arrangement_programs",
                                'routeParameters' => array('_period' => $_period),
                            )
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.arrangement_programs', $section)));
                        $itemPeriodConsultation->addChild($itemPeriodArrangementPrograms);
                        

                        $itemPeriod->addChild($itemPeriodConsultation);
                    }
                    $visualize->addChild($itemPeriod);
                }
                    
                $menuResults->addChild($visualize);
             }
                
                
//                    $thirdchild = $this->factory->createItem('results.notify',
//                            $this->getSubLevelOptions(array(
//                                'uri' => 'add',
//                            )))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.notify.main',$section)));
//                    
//                    //Menu y sub menu de notificar indicadores
//                    $itemNotifyIndicators = $this->factory->createItem('results.notify.indicators', $this->getSubLevelOptions())->setLabel($this->translate(sprintf('app.backend.menu.%s.results.notify.indicators', $section)));
//                    
//                    $itemIndicatorsStrategic = $this->factory->createItem('results.notify.indicators.strategic', array(
//                        'route' => 'pequiven_seip_result_notify_indicator_strategic',
//                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.strategic', $section)));
//                    
//                    $itemIndicatorsTactic = $this->factory->createItem('results.notify.indicators.tactic', array(
//                        'route' => 'pequiven_seip_result_notify_indicator_tactic',
//                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.tactic', $section)));
//                    
//                    $itemIndicatorsOperative = $this->factory->createItem('results.notify.indicators.operative', array(
//                        'route' => 'pequiven_seip_result_notify_indicator_operative',
//                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.operative', $section)));
//                    
//                    $itemNotifyIndicators->addChild($itemIndicatorsStrategic);
//
//                    $itemNotifyIndicators->addChild($itemIndicatorsTactic);
//
//                    $itemNotifyIndicators->addChild($itemIndicatorsOperative);
//                    
//                    
//                    $itemNotifyArrangementPrograms = $this->factory->createItem('results.notify.arrangement_programs', array(
//                            'route' => 'pequiven_seip_result_notify_arrangementprogram',
//                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.notify.arrangement_programs', $section)));
//                    
//                    $thirdchild->addChild($itemNotifyIndicators);
//                    $thirdchild->addChild($itemNotifyArrangementPrograms);
//                        
//                    $menuResults->addChild($thirdchild);
               
        $menu->addChild($menuResults);
    }
    
    private function addDataLoad(ItemInterface $menu, $section)
    {
        $child = $this->factory->createItem('data_load',
                    $this->getSubLevelOptions(array(
                        'uri' => null,
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.main', $section)));
        
             $list = $this->factory->createItem('indicators.data_load.production',
                    $this->getSubLevelOptions(array(
                        "route" => "pequiven_report_template_index",
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.production', $section)));
        
        $child->addChild($list);
        
        $listAdd = $this->factory->createItem('indicators.data_load.reports.sales',
                    $this->getSubLevelOptions(array(
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.sales', $section)));
        $child->addChild($listAdd);
        
        $listAdd = $this->factory->createItem('indicators.data_load.reports.finance',
                    $this->getSubLevelOptions(array(
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.finance', $section)));
        $child->addChild($listAdd);
        
//        $em = $this->getDoctrine()->getManager();
//        $locationRepository = $em->getRepository("Pequiven\SEIPBundle\Entity\CEI\Location");
//        $locationsProduction = $locationRepository->findByCodeTypeLocation(\Pequiven\SEIPBundle\Model\CEI\TypeLocation::CODE_PLANT_PRODUCTION);
//        $locationsByTypeCompany = array();
//        foreach ($locationsProduction as $locationProduction) {
//            $typeOfCompany = $locationProduction->getCompany()->getTypeOfCompany();
//            if(!isset($locationsByTypeCompany[$typeOfCompany])){
//                $locationsByTypeCompany[$typeOfCompany] = array();
//            }
//            $locationsByTypeCompany[$typeOfCompany][] = $locationProduction;
//        }
//                //Proceso de produccion
//                 $processProduction = $this->factory->createItem('data_load.process_production',
//                        $this->getSubLevelOptions(array(
//                        ))
//                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.process.production.main', $section)));
//                 
//                 $processProductionMatriz = $this->factory->createItem('data_load.process_production.matriz',
//                        $this->getSubLevelOptions(array(
//                        ))
//                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.process.production.matriz', $section)));
//                 if(isset($locationsByTypeCompany[Company::TYPE_OF_COMPANY_MATRIZ]) && is_array($locationsByTypeCompany[Company::TYPE_OF_COMPANY_MATRIZ]))
//                 {
//                     $companies = $locationsByTypeCompany[Company::TYPE_OF_COMPANY_MATRIZ];
//                     foreach ($companies as $company) {
//                         $processProductionMatriz->addChild('data_load.process_production.matriz.'.$company->getId(), array(
//                            'route' => 'pequiven_master_menu_list_gerenciaFirst',
//                        ))->setLabel($company->getAlias());
//                     }
//                 }
//                 
//                 $processProduction->addChild($processProductionMatriz);
//                 
//                 $processProductionAffiliated = $this->factory->createItem('data_load.process.production.affiliated',
//                        $this->getSubLevelOptions(array(
//                        ))
//                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.process.production.affiliated', $section)));
//                 if(isset($locationsByTypeCompany[Company::TYPE_OF_COMPANY_AFFILIATED]) && is_array($locationsByTypeCompany[Company::TYPE_OF_COMPANY_AFFILIATED]))
//                 {
//                     $companies = $locationsByTypeCompany[Company::TYPE_OF_COMPANY_AFFILIATED];
//                     foreach ($companies as $company) {
//                         $processProductionAffiliated->addChild('data_load.process_production.affiliated.'.$company->getId(), array(
//                            'route' => 'pequiven_master_menu_list_gerenciaFirst',
//                        ))->setLabel($company->getAlias());
//                     }
//                 }
//                 $processProduction->addChild($processProductionAffiliated);
//                 
//                 $processProductionMixta = $this->factory->createItem('data_load.process.production.mixta',
//                        $this->getSubLevelOptions(array(
//                        ))
//                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.process.production.mixta', $section)));
//                 if(isset($locationsByTypeCompany[Company::TYPE_OF_COMPANY_MIXTA]) && is_array($locationsByTypeCompany[Company::TYPE_OF_COMPANY_MIXTA]))
//                 {
//                     $companies = $locationsByTypeCompany[Company::TYPE_OF_COMPANY_MIXTA];
//                     foreach ($companies as $company) {
//                         $processProductionMixta->addChild('data_load.process_production.mixta.'.$company->getId(), array(
//                            'route' => 'pequiven_master_menu_list_gerenciaFirst',
//                        ))->setLabel($company->getAlias());
//                     }
//                 }
//                 $processProduction->addChild($processProductionMixta);
//                 
//         $child->addChild($processProduction);
                 
        $menu->addChild($child);
    }
    
    private function addDataLoadNotification(ItemInterface $menu, $section)
    {
        $child = $this->factory->createItem('data_load.notification',
                    $this->getSubLevelOptions(array(
                        'uri' => null,
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.notification', $section)));
        
             $list = $this->factory->createItem('indicators.data_load.notification.production',
                    $this->getSubLevelOptions(array(
                        "route" => "pequiven_report_template_index",
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.production', $section)));
        
        $child->addChild($list);
        
        $listAdd = $this->factory->createItem('indicators.data_load.notification.sales',
                    $this->getSubLevelOptions(array(
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.sales', $section)));
        $child->addChild($listAdd);
        
        $listAdd = $this->factory->createItem('indicators.data_load.notification.finance',
                    $this->getSubLevelOptions(array(
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.finance', $section)));
        $child->addChild($listAdd);
        
        $menu->addChild($child);
    }


    /**
     * Construye el menu de Programa de Gestión
     * 
     * @param \Knp\Menu\ItemInterface $menu
     * @param type $section
     */
    
    function addArrangementProgramsMenu(ItemInterface $menu, $section) {
            $child = $this->factory->createItem('arrangement_programs',
                    $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'fa fa-tasks',),
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.main', $section)));

            if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_*'))
            {
                $pending = $this->factory->createItem('arrangement_programs.list.pending',
                    $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => '',),
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.pending', $section)));
                
                //Menú Nivel 2: Visualizar
                 $visualize = $this->factory->createItem('arrangement_programs.visualize',
                        $this->getSubLevelOptions(array(
                        'uri' => 'arrangement_programs',
                        ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
                 if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_ALL')){
                    $visualize
                        ->addChild('arrangement_programs.list', array(
                            'route' => 'pequiven_seip_arrangementprogram_index',
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.list', $section)));
                 }
                 if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_ASSIGNED')){
                    $visualize
                        ->addChild('arrangement_programs.assigned', array(
                            'route' => 'pequiven_seip_arrangementprogram_assigned',
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.assigned', $section)));
                 }

                 if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_FOR_REVIEWING')){
                    $pending
                        ->addChild('arrangement_programs.for_reviewing', array(
                            'route' => 'pequiven_seip_arrangementprogram_for_reviewing',
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_reviewing', $section)));
                 }
                 if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_FOR_APPROVING')){
                    $pending
                        ->addChild('arrangement_programs.for_approving', array(
                            'route' => 'pequiven_seip_arrangementprogram_for_approving',
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_approving', $section)));
                 }
                 if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_FOR_NOTIFYING')){
                    $pending
                        ->addChild('arrangement_programs.for_notifying', array(
                            'route' => 'pequiven_seip_arrangementprogram_for_notifying',
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_notifying', $section)));
                 }
                
                $visualize->addChild($pending);
                $child->addChild($visualize);
            }
            
            if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_*')){
                
                $subchild = $this->factory->createItem('arrangement_programs.add.main',
                    $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'icon-book',),
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.main', $section)));
                
                if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_TACTIC')){
                    $subchild
                    ->addChild('arrangement_programs.tactic', array(
                        'route' => 'pequiven_arrangementprogram_create',
                        'routeParameters' => array('type' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC, 'associate' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA),
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.tactic', $section)));
                }
                if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_OPERATIVE')){
                    $subchild->addChild('arrangement_programs.operative', array(
                        'route' => 'pequiven_arrangementprogram_create',
                        'routeParameters' => array('type' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE, 'associate' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA),
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.operative', $section)));
                }

                if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_FROM_TEMPLATE')){
                    $subchild->addChild('arrangement_programs.temaplate', array(
                        'route' => 'pequiven_seip_arrangementprogram_template_index',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.temaplate', $section)));
                }
                
                $child->addChild($subchild);
            }
            
            $menu->addChild($child);
    }
    
    /**
     * Construye el menu de ejemplo
     * 
     * @param \Knp\Menu\ItemInterface $menu
     * @param type $section
     */
    function addExampleMenu(ItemInterface $menu, $section) {
        $child = $this->factory->createItem('example',
                    $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'icon-book',),
                    ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.main', $section)));
        $child
                ->addChild('example.company', array(
                    'route' => null,
                    ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.company', $section)));
        $child
                ->addChild('example.technical_reports', array(
                    'route' => null,
                    ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.technical_reports', $section)));
        
        
            $subchild = $this->factory->createItem('subexample',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.other.main', $section)));
            $subchild
                    ->addChild('example.other.admin', array(
                        'route' => null,
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.other.admin', $section)));

            $subchild->addChild('example.other.groups', array(
                        'route' => null,
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.other.groups', $section)));
        
            $child->addChild($subchild);
               
        $menu->addChild($child);
    }
    
    protected function getSubLevelOptions(array $parameters = array()) {
        return array_merge($this->secondLevelOptions,$parameters);
    }
    
    protected function getSecondLevelOptions(array $parameters = array()) {
        return array_merge($this->secondLevelOptions,$parameters);
    }
    
//    public function getCurrentMenuItem($menu)
//    {
//        $voter = $this->container->get('pequiven.seip.menu.voter');
//		
//        foreach ($menu as $item) {
//            if ($voter->matchItem($item)) {
//                return $item;
//            }
//			
//            if ($item->getChildren() && $currentChild = $this->getCurrentMenuItem($item)) {
//                return $currentChild;
//            }
//        }
//		
//        return null;
//    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\Configuration
     */
    private function getSeipConfiguration()
    {
        return $this->container->get('seip.configuration');
    }
    
    private function isGranted($roles,$object = null) {
        return $this->securityContext->isGranted($roles,$object);
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
}
