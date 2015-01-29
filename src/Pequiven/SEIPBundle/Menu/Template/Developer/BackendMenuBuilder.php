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
        
        if($seipConfiguration->isEnablePrePlanning() && $this->isGranted('ROLE_PRE_PLANNING_ENABLE')){
            $this->addMenuPrePlanning($menu, $section);
        }
        //$this->addExampleMenu($menu, $section);

//        $menu->addChild('support', array(
//            'route' => null,
//            'labelAttributes' => array('icon' => 'icon-info'),
//        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.support', $section)));
//        
        //Menu de objetivos
        $this->addMenuObjetives($menu, $section);
        
        //Menú Programas de Gestión
        $this->addArrangementProgramsMenu($menu, $section);
        
        //Menu de indicadores
        $this->addMenuIndicators($menu, $section);
        
        //Menu de Resultados
        $this->addMenuResults($menu, $section);
        
        
        //Menú Gestión Estratégica
//        $this->addArrangementStrategicMenu($menu, $section);
        
        if($this->securityContext->isGranted('ROLE_WORKER_PLANNING')){
            $this->addPlanningMenu($menu, $section);
        }
        
        //Menú Administración
        if($this->securityContext->isGranted('ROLE_ADMIN')){
            $menu->addChild('admin', array(
                'route' => 'sonata_admin_dashboard',
                'labelAttributes' => array('icon' => 'icon-card'),
                //'linkAttributes' => array('target' => '_blank'),
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
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.main', $section)));
        
        $subchild = $this->factory->createItem('planning.objetives',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.main', $section)));
        
        $subchild->addChild('planning.objetives.strategic', array(
                                'route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_ESTRATEGICO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.strategic', $section)));
        
        $subchild->addChild('planning.objetives.tactic', array(
                                'route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_TACTICO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.tactic', $section)));

        $subchild->addChild('planning.objetives.operative', array(
                                'route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_OPERATIVO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.operative', $section)));
        
        $child->addChild($subchild);
                
        $subchild = $this->factory->createItem('planning.indicators',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.main', $section)));
        
        $subchild->addChild('planning.indicators.strategic', array(
                                'route' => 'pequiven_indicator_list',
                                'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_ESTRATEGICO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.strategic', $section)));
        
        $subchild->addChild('planning.indicators.tactic', array(
                                'route' => 'pequiven_indicator_list',
                                'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_TACTICO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.tactic', $section)));

        $subchild->addChild('planning.indicators.operative', array(
                                'route' => 'pequiven_indicator_list',
                                'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.operative', $section)));
        
        $child->addChild($subchild);
        
        $subchild = $this->factory->createItem('planning.matriz',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'route' => 'pequiven_master_menu_list_gerenciaFirst',
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.matriz', $section)));
        
        $child->addChild($subchild);
        
        $subchild = $this->factory->createItem('planning.results',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.results.main', $section)));
        
        $subchild->addChild('planning.results.strategic', array(
                                'route' => '',
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.results.strategic', $section)));
        
        $subchild->addChild('planning.results.tactic', array(
                                'route' => '',
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.results.tactic', $section)));

        $subchild->addChild('planning.results.operative', array(
                                'route' => 'pequiven_result_list',
                                'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO)
                            ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.results.operative', $section)));
        
        $child->addChild($subchild);
        
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
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.main', $section),array('%period%' => $periodName)));
        $child->addChild('preplanning_tactic',array(
            'route' => 'pequiven_pre_planning_index',//Route
            'labelAttributes' => array('icon' => 'fa fa-cube'),
            'routeParameters' => array('period' => $periodName,'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO),
        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.tactic', $section)));
        
        $child->addChild('preplanning_operative',array(
            'route' => 'pequiven_pre_planning_index',//Route
            'labelAttributes' => array('icon' => 'fa fa-cog'),
            'routeParameters' => array('period' => $periodName,'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO),
        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.operative', $section)));
        
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
        
            //Menú Nivel 2: Visualizar
            $visualize = $this->factory->createItem('objetives.visualize',
                    $this->getSubLevelOptions(array(
                    'uri' => 'objetive',
                    'labelAttributes' => array('icon' => '',),
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
            $menuObjetives->addChild($visualize);
            
                //Menú Nivel 3: Item de visulizar
                if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'))){
                    $visualize->addChild('arrangement_strategic.objetives.list.strategic', array(
                            'route' => 'pequiven_objetive_menu_list_strategic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.strategic', $section)));
                    $visualize->addChild('arrangement_strategic.objetives.list.tactic', array(
                            'route' => 'pequiven_objetive_menu_list_tactic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.tactic', $section)));
                    $visualize->addChild('arrangement_strategic.objetives.list.operative', array(
                            'route' => 'pequiven_objetive_menu_list_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.operative', $section)));
                } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                    $visualize->addChild('arrangement_strategic.objetives.list.tactic', array(
                            'route' => 'pequiven_objetive_menu_list_tactic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.tactic', $section)));
                    $visualize->addChild('arrangement_strategic.objetives.list.operative', array(
                            'route' => 'pequiven_objetive_menu_list_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.operative', $section)));
                } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                    $visualize->addChild('arrangement_strategic.objetives.list.operative', array(
                            'route' => 'pequiven_objetive_menu_list_operative',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.operative', $section)));
                }
                
                if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){//Si el usuario tiene un rol superior o igual que gerente de 2da línea o que tenga rol de planificación
                    $thirdchild = $this->factory->createItem('arrangement_strategic.objetives.add',
                            $this->getSubLevelOptions(array(
                                'uri' => 'add',
                                'labelAttributes' => array('icon' => 'icon-book'),
                            ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.main',$section)));
                    
                    //Si el usuario logueado es Rol Ejecutivo o Ejecutivo Asignado
                    if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.strategic', array(
                            'route' => 'pequiven_objetive_menu_add_strategic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.strategic', $section)));
                        $thirdchild->addChild('arrangement_strategic.objetives.add.tactic', array(
                            'route' => 'pequiven_objetive_menu_add_tactic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.tactic', $section)));
                        $thirdchild->addChild('arrangement_strategic.objetives.add.operative', array(
                            'route' => 'pequiven_objetive_menu_add_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.operative', $section)));
                    //Si el usuario logueado es Rol Gerente Primera Línea, Gerente Primera Línea Asignado, Gerente General de Complejo o Gerente General de Complejo Asignado
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.tactic', array(
                            'route' => 'pequiven_objetive_menu_add_tactic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.tactic', $section)));
                        $thirdchild->addChild('arrangement_strategic.objetives.add.operative', array(
                            'route' => 'pequiven_objetive_menu_add_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.operative', $section)));
                    //Si el usuario logueado es Rol Gerente Segunda Línea o Gerente Segunda Línea Asignado
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.operative', array(
                            'route' => 'pequiven_objetive_menu_add_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.operative', $section)));
                    }
                    $menuObjetives->addChild($thirdchild);
                }
                //Matrices objectives
                $matricesObjectivesItem = $this->factory->createItem('objetives.matrices_objectives',
                    $this->getSubLevelOptions(array(
                    'route' => 'pequiven_master_menu_list_gerenciaFirst',
                    ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.matrices_objectives', $section)));
                $menuObjetives->addChild($matricesObjectivesItem);
               
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
               
                //Menú Nivel 3: Lista de Indicadores
                    $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.list',
                        $this->getSubLevelOptions(array(
                            'uri' => 'list',
                        )))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.main',$section)));
                    
                    $itemIndicatorsStrategic = $this->factory->createItem('arrangement_strategic.indicators.list.strategic', array(
                        'route' => 'pequiven_indicator_menu_list_strategic',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.strategic', $section)));
                    
                    $itemIndicatorsTactic = $this->factory->createItem('arrangement_strategic.indicators.list.tactic', array(
                        'route' => 'pequiven_indicator_menu_list_tactic',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.tactic', $section)));
                    
                    $itemIndicatorsOperative = $this->factory->createItem('arrangement_strategic.indicators.list.operative', array(
                        'route' => 'pequiven_indicator_menu_list_operative',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.operative', $section)));
                    
                    if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                        $thirdchild->addChild($itemIndicatorsStrategic);
                        
                        $thirdchild->addChild($itemIndicatorsTactic);
                        
                        $thirdchild->addChild($itemIndicatorsOperative);
                        
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_INDICATOR_ADD_RESULT'))){
                        $thirdchild->addChild($itemIndicatorsTactic);
                        
                        $thirdchild->addChild($itemIndicatorsOperative);
                        
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                        $thirdchild->addChild($itemIndicatorsOperative);
                    }
                    $menuIndicators->addChild($thirdchild);
                    
                     //Menú Nivel 3: Registro de Indicadores
                    if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'))){//Si el usuario tiene un rol superior o igual que gerente de 2da línea
                        $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.add',
                                $this->getSubLevelOptions(array(
                                    'uri' => 'add',
                                ))
                            )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.main',$section)));

                        //Si el usuario logueado es Rol Ejecutivo o Ejecutivo Asignado
                        if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.strategic', array(
                                'route' => 'pequiven_indicator_menu_add_strategic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.strategic', $section)));
                            $thirdchild->addChild('arrangement_strategic.indicators.add.tactic', array(
                                'route' => 'pequiven_indicator_menu_add_tactic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.tactic', $section)));
                            $thirdchild->addChild('arrangement_strategic.indicators.add.operative', array(
                                'route' => 'pequiven_indicator_menu_add_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.operative', $section)));
                        //Si el usuario logueado es Rol Gerente Primera Línea, Gerente Primera Línea Asignado, Gerente General de Complejo o Gerente General de Complejo Asignado
                        } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.tactic', array(
                                'route' => 'pequiven_indicator_menu_add_tactic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.tactic', $section)));
                            $thirdchild->addChild('arrangement_strategic.indicators.add.operative', array(
                                'route' => 'pequiven_indicator_menu_add_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.operative', $section)));
                        //Si el usuario logueado es Rol Gerente Segunda Línea o Gerente Segunda Línea Asignado
                        } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.operative', array(
                                'route' => 'pequiven_indicator_menu_add_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.operative', $section)));
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
        
            //Menú Nivel 2: Visualizar
            $visualize = $this->factory->createItem('results.visualize',
                    $this->getSubLevelOptions(array(
                    'uri' => 'objetive',
                    'labelAttributes' => array('icon' => '',),
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.main', $section)));
            $menuResults->addChild($visualize);
                
                $itemOperativeVisualize = $this->factory->createItem('results.visualize.by_gerencia', array(
                    'route' => 'pequiven_seip_result_visualize_by_gerencia',
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.by_gerencia', $section)));
                
                $visualize->addChild($itemOperativeVisualize);
                
                if(!$this->securityContext->isGranted(array('ROLE_SUPERVISER')) && $this->securityContext->isGranted('ROLE_WORKER_PLANNING')){//Si el usuario tiene un rol superior o igual que gerente de 2da línea
                    $thirdchild = $this->factory->createItem('results.notify',
                            $this->getSubLevelOptions(array(
                                'uri' => 'add',
                            )))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.notify.main',$section)));
                    
                    //Menu y sub menu de notificar indicadores
                    $itemNotifyIndicators = $this->factory->createItem('results.notify.indicators', $this->getSubLevelOptions())->setLabel($this->translate(sprintf('app.backend.menu.%s.results.notify.indicators', $section)));
                    
                    $itemIndicatorsStrategic = $this->factory->createItem('results.notify.indicators.strategic', array(
                        'route' => 'pequiven_seip_result_notify_indicator_strategic',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.strategic', $section)));
                    
                    $itemIndicatorsTactic = $this->factory->createItem('results.notify.indicators.tactic', array(
                        'route' => 'pequiven_seip_result_notify_indicator_tactic',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.tactic', $section)));
                    
                    $itemIndicatorsOperative = $this->factory->createItem('results.notify.indicators.operative', array(
                        'route' => 'pequiven_seip_result_notify_indicator_operative',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.operative', $section)));
                    
                    if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                        $itemNotifyIndicators->addChild($itemIndicatorsStrategic);
                        
                        $itemNotifyIndicators->addChild($itemIndicatorsTactic);
                        
                        $itemNotifyIndicators->addChild($itemIndicatorsOperative);
                        
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                        $itemNotifyIndicators->addChild($itemIndicatorsTactic);
                        
                        $itemNotifyIndicators->addChild($itemIndicatorsOperative);
                        
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                        $itemNotifyIndicators->addChild($itemIndicatorsOperative);
                    }
                    
                    $itemNotifyArrangementPrograms = $this->factory->createItem('results.notify.arrangement_programs', array(
                            'route' => 'pequiven_seip_result_notify_arrangementprogram',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.notify.arrangement_programs', $section)));
                    
                    $thirdchild->addChild($itemNotifyIndicators);
                    $thirdchild->addChild($itemNotifyArrangementPrograms);
                        
                    $menuResults->addChild($thirdchild);
                }
                $itemPeriod = $this->factory->createItem('results.period',$this->getSubLevelOptions())
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.main', $section)));
                
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
                //$menuResults->addChild($itemPeriod);
                
               
        $menu->addChild($menuResults);
    }
    
    /**
     * Construye el menu de Gestión Estratégica
     * 
     * @param \Knp\Menu\ItemInterface $menu
     * @param type $section
     * @deprecated since version number
     */
    function addArrangementStrategicMenu(ItemInterface $menu, $section) {
        //Menú Nivel 1: Gestión Estratégica
        $child = $this->factory->createItem('arrangement_strategic',
                $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'icon-book',),
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.main', $section)));

            //Sub menú Objetivos
//        $child
//                ->addChild('arrangement.objetives', array(
//                    'route' => '',
//                    ))
//                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.objetives', $section)));
            //Menú Nivel 2: Objetivos
            $subchild = $this->factory->createItem('arrangement_strategic.objetives',
                    $this->getSubLevelOptions(array(
                    'uri' => 'objetive',
                    'labelAttributes' => array('icon' => 'icon-book',),
                    ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.main', $section)));
                
                //Menú Nivel 3: Lista de Objetivos
                $thirdchild = $this->factory->createItem('arrangement_strategic.objetives.list',
                            $this->getSubLevelOptions(array(
                                'uri' => 'list',
                                'labelAttributes' => array('icon' => 'icon-book'),
                            ))
                        )
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.main',$section)));
                
                if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'))){
                    $thirdchild->addChild('arrangement_strategic.objetives.list.strategic', array(
                            'route' => 'pequiven_objetive_menu_list_strategic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.strategic', $section)));
                    $thirdchild->addChild('arrangement_strategic.objetives.list.tactic', array(
                            'route' => 'pequiven_objetive_menu_list_tactic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.tactic', $section)));
                    $thirdchild->addChild('arrangement_strategic.objetives.list.operative', array(
                            'route' => 'pequiven_objetive_menu_list_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.operative', $section)));
                } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                    $thirdchild->addChild('arrangement_strategic.objetives.list.tactic', array(
                            'route' => 'pequiven_objetive_menu_list_tactic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.tactic', $section)));
                    $thirdchild->addChild('arrangement_strategic.objetives.list.operative', array(
                            'route' => 'pequiven_objetive_menu_list_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.operative', $section)));
                } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                    $thirdchild->addChild('arrangement_strategic.objetives.list.operative', array(
                            'route' => 'pequiven_objetive_menu_list_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.operative', $section)));
                }
                    
            $subchild->addChild($thirdchild);
            
                //Menú Nivel 3: Registro de Objetivos//Menú Nivel 3: Lista de Indicadores
                    $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.list',
                                $this->getSubLevelOptions(array(
                                    'uri' => 'list',
                                    'labelAttributes' => array('icon' => 'icon-book'),
                                ))
                            )
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.main',$section)));
                if(!$this->securityContext->isGranted(array('ROLE_SUPERVISER')) && $this->securityContext->isGranted('ROLE_WORKER_PLANNING')){//Si el usuario tiene un rol superior o igual que gerente de 2da línea
                    $thirdchild = $this->factory->createItem('arrangement_strategic.objetives.add',
                            $this->getSubLevelOptions(array(
                                'uri' => 'add',
                                'labelAttributes' => array('icon' => 'icon-book'),
                            ))
                        )
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.main',$section)));
                    
                    //Si el usuario logueado es Rol Ejecutivo o Ejecutivo Asignado
                    if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.strategic', array(
                            'route' => 'pequiven_objetive_menu_add_strategic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.strategic', $section)));
                        $thirdchild->addChild('arrangement_strategic.objetives.add.tactic', array(
                            'route' => 'pequiven_objetive_menu_add_tactic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.tactic', $section)));
                        $thirdchild->addChild('arrangement_strategic.objetives.add.operative', array(
                            'route' => 'pequiven_objetive_menu_add_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.operative', $section)));
                    //Si el usuario logueado es Rol Gerente Primera Línea, Gerente Primera Línea Asignado, Gerente General de Complejo o Gerente General de Complejo Asignado
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.tactic', array(
                            'route' => 'pequiven_objetive_menu_add_tactic',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.tactic', $section)));
                        $thirdchild->addChild('arrangement_strategic.objetives.add.operative', array(
                            'route' => 'pequiven_objetive_menu_add_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.operative', $section)));
                    //Si el usuario logueado es Rol Gerente Segunda Línea o Gerente Segunda Línea Asignado
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                        $thirdchild->addChild('arrangement_strategic.objetives.add.operative', array(
                            'route' => 'pequiven_objetive_menu_add_operative',
                        ))
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.operative', $section)));
                    }
                    
                    $subchild->addChild($thirdchild);
                }
            $child->addChild($subchild);
            
            //Menú Nivel 2: Indicadores
                $subchild = $this->factory->createItem('arrangement_strategic.indicators',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.main', $section)));
                
                    //Menú Nivel 3: Lista de Indicadores
                    $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.list',
                                $this->getSubLevelOptions(array(
                                    'uri' => 'list',
                                    'labelAttributes' => array('icon' => 'icon-book'),
                                ))
                            )
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.main',$section)));

                    if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                    $thirdchild->addChild('arrangement_strategic.indicators.list.strategic', array(
                                'route' => 'pequiven_indicator_menu_list_strategic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.strategic', $section)));
                        $thirdchild->addChild('arrangement_strategic.indicators.list.tactic', array(
                                'route' => 'pequiven_indicator_menu_list_tactic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.tactic', $section)));
                        $thirdchild->addChild('arrangement_strategic.indicators.list.operative', array(
                                'route' => 'pequiven_indicator_menu_list_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.operative', $section)));
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                        $thirdchild->addChild('arrangement_strategic.indicators.list.tactic', array(
                                'route' => 'pequiven_indicator_menu_list_tactic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.tactic', $section)));
                        $thirdchild->addChild('arrangement_strategic.indicators.list.operative', array(
                                'route' => 'pequiven_indicator_menu_list_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.operative', $section)));
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                        $thirdchild->addChild('arrangement_strategic.indicators.list.operative', array(
                                'route' => 'pequiven_indicator_menu_list_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.operative', $section)));
                    }

                $subchild->addChild($thirdchild);
                
                    //Menú Nivel 3: Registro de Indicadores
                    if(!$this->securityContext->isGranted(array('ROLE_WORKER_PQV','ROLE_SUPERVISER'))){//Si el usuario tiene un rol superior o igual que gerente de 2da línea
                        $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.add',
                                $this->getSubLevelOptions(array(
                                    'uri' => 'add',
                                    'labelAttributes' => array('icon' => 'icon-book'),
                                ))
                            )
                                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.main',$section)));

                        //Si el usuario logueado es Rol Ejecutivo o Ejecutivo Asignado
                        if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.strategic', array(
                                'route' => 'pequiven_indicator_menu_add_strategic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.strategic', $section)));
                            $thirdchild->addChild('arrangement_strategic.indicators.add.tactic', array(
                                'route' => 'pequiven_indicator_menu_add_tactic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.tactic', $section)));
                            $thirdchild->addChild('arrangement_strategic.indicators.add.operative', array(
                                'route' => 'pequiven_indicator_menu_add_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.operative', $section)));
                        //Si el usuario logueado es Rol Gerente Primera Línea, Gerente Primera Línea Asignado, Gerente General de Complejo o Gerente General de Complejo Asignado
                        } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.tactic', array(
                                'route' => 'pequiven_indicator_menu_add_tactic',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.tactic', $section)));
                            $thirdchild->addChild('arrangement_strategic.indicators.add.operative', array(
                                'route' => 'pequiven_indicator_menu_add_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.operative', $section)));
                        //Si el usuario logueado es Rol Gerente Segunda Línea o Gerente Segunda Línea Asignado
                        } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                            $thirdchild->addChild('arrangement_strategic.indicators.add.operative', array(
                                'route' => 'pequiven_indicator_menu_add_operative',
                            ))
                                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.operative', $section)));
                        }

                        $subchild->addChild($thirdchild);
                    }
            $child->addChild($subchild);
        
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

            //Menú Nivel 2: Visualizar
            $visualize = $this->factory->createItem('arrangement_programs.visualize',
                    $this->getSubLevelOptions(array(
                    'uri' => 'arrangement_programs',
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
            $child->addChild($visualize);
            
            
            $visualize
                ->addChild('arrangement_programs.list', array(
                    'route' => 'pequiven_seip_arrangementprogram_index',
                ))
            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.list', $section)));
            
            $visualize
                ->addChild('arrangement_programs.assigned', array(
                    'route' => 'pequiven_seip_arrangementprogram_assigned',
                ))
            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.assigned', $section)));
            
            $visualize
                ->addChild('arrangement_programs.for_reviewing_or_approving', array(
                    'route' => 'pequiven_seip_arrangementprogram_for_reviewing_or_approving',
                ))
            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_reviewing_or_approving', $section)));
            
            $visualize
                ->addChild('arrangement_programs.for_notifying', array(
                    'route' => 'pequiven_seip_arrangementprogram_for_notifying',
                ))
            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_notifying', $section)));
            
            $subchild = $this->factory->createItem('arrangement_programs.add.main',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.main', $section)));
            $subchild
                    ->addChild('arrangement_programs.tactic', array(
                        'route' => 'pequiven_arrangementprogram_create',
                        'routeParameters' => array('type' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC),
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.tactic', $section)));

            $subchild->addChild('arrangement_programs.operative', array(
                        'route' => 'pequiven_arrangementprogram_create',
                        'routeParameters' => array('type' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE),
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.operative', $section)));
            $subchild->addChild('arrangement_programs.temaplate', array(
                        'route' => 'pequiven_seip_arrangementprogram_template_index',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.temaplate', $section)));
            $child->addChild($subchild);
            
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
    
    private function isGranted($roles) {
        return $this->securityContext->isGranted($roles);
    }
}
