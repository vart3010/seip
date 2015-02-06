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
        
        if($this->isGranted('ROLE_SEIP_PLANNING_*')){
            $this->addPlanningMenu($menu, $section);
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
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.gerencia_first.list', $section)));
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
        $child = $this->factory->createItem('planning',
            $this->getSubLevelOptions(array(
                'uri' => null,
                'labelAttributes' => array('icon' => 'fa fa-bar-chart',),
            )))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.main', $section)));
        
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
                            'labelAttributes' => array('icon' => 'icon-book',),
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
                        'labelAttributes' => array('icon' => 'icon-book',),
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

                $visualize->addChild($subchild);
            }//Fin menu Ver - Indicadores
            
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
        
        $menu->addChild($child);
    }
    
    private function addMenuPrePlanning(ItemInterface $menu, $section) {
        $nextPeriod = $this->getPeriodService()->getNextPeriod();
        $periodName = 'No Definido';
        if($nextPeriod){
            $periodName = $nextPeriod->getName();
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
                'labelAttributes' => array('icon' => '',),
                ))
            )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
            
            if($this->isGranted('ROLE_SEIP_PRE_PLANNING_LIST_REVIEW')){
                $visualize->addChild('preplanning.visualize.review',array(
                    'route' => 'pequiven_pre_planning_user_index',//Route
                    'labelAttributes' => array('icon' => 'fa fa-sitemap'),
                    'routeParameters' => array('period' => $periodName),
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.review', $section)));
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
                        $itemOperativeVisualize = $this->factory->createItem('results.visualize.by_gerencia', array(
                            'route' => 'pequiven_seip_result_visualize_by_gerencia',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.by_gerencia', $section)));
                        $visualize->addChild($itemOperativeVisualize);
                    }
                    
                     $itemPeriod = $this->factory->createItem('results.period',$this->getSubLevelOptions())
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.main', $section)));
                
                if($this->isGranted('ROLE_SEIP_RESULT_LIST_PERIOD')){
                    //Periodos
                    $periods = $this->container->get('pequiven.repository.period')->findAllForConsultation();
                    foreach ($periods as $period) {
                        $year = $period->getYear();
                        $itemName = 'results.notify.period.'.$period->getId();
                        $itemPeriodConsultation = $this->factory->createItem($itemName,$this->getSubLevelOptions(
                             array(
                                'route' => self::ROUTE_DEFAULT,
                                'routeParameters' => array('year' => $year),
                            )
                        ))->setLabel($year);

                        $itemPeriodConsultationObjetives = $this->factory->createItem($itemName.$year.'objetives',$this->getSubLevelOptions(
                             array(
                                'route' => self::ROUTE_DEFAULT,
                                'routeParameters' => array('year' => $year),
                            )
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.objetives', $section)));
                        $itemPeriodConsultation->addChild($itemPeriodConsultationObjetives);

                        $itemPeriodConsultationIndicators = $this->factory->createItem($itemName.$year.'indicators',$this->getSubLevelOptions(
                             array(
                                'route' => self::ROUTE_DEFAULT,
                                'routeParameters' => array('year' => $year),
                            )
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.indicators', $section)));
                        $itemPeriodConsultation->addChild($itemPeriodConsultationIndicators);

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

                 if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_REVIEWING_OR_APPROVING')){
                    $visualize
                        ->addChild('arrangement_programs.for_reviewing_or_approving', array(
                            'route' => 'pequiven_seip_arrangementprogram_for_reviewing_or_approving',
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_reviewing_or_approving', $section)));
                 }
                 if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_FOR_NOTIFYING')){
                    $visualize
                        ->addChild('arrangement_programs.for_notifying', array(
                            'route' => 'pequiven_seip_arrangementprogram_for_notifying',
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_notifying', $section)));
                 }
                
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
                        'routeParameters' => array('type' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC),
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.tactic', $section)));
                }
                if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_OPERATIVE')){
                    $subchild->addChild('arrangement_programs.operative', array(
                        'route' => 'pequiven_arrangementprogram_create',
                        'routeParameters' => array('type' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE),
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
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    private function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
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
}
