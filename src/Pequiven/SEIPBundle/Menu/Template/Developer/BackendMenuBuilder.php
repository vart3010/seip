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
class BackendMenuBuilder extends MenuBuilder
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
        
        //$this->addExampleMenu($menu, $section);

//        $menu->addChild('support', array(
//            'route' => null,
//            'labelAttributes' => array('icon' => 'icon-info'),
//        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.support', $section)));
        
        //Menú Administración
        //$this->addAdministrationMenu($menu, $section);
        //Menú Gestión Estratégica
        $this->addArrangementStrategicMenu($menu, $section);
        //Menú Programas de Gestión
        $this->addArrangementProgramsMenu($menu, $section);
        //Menú Reportes
//        $menu->addChild('reports', array(
//            'route' => null,
//            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.reports', $section)));
        
    //$menu->setCurrent($this->request->getRequestUri());
        
        if($this->securityContext->isGranted('ROLE_WORKER_PLANNING')){
            $this->addPlanningMenu($menu, $section);
        }
        if($this->securityContext->isGranted('ROLE_SUPER_ADMIN')){
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
                    'labelAttributes' => array('icon' => 'icon-calendar',),
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.main', $section)));
                
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
        
        $menu->addChild($child);
    }
    
    /**
     * Construye el menu de Gestión Estratégica
     * 
     * @param \Knp\Menu\ItemInterface $menu
     * @param type $section
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
            
                //Menú Nivel 3: Registro de Objetivos
                if(!$this->securityContext->isGranted(array('ROLE_WORKER_PQV','ROLE_SUPERVISER'))){//Si el usuario tiene un rol superior o igual que gerente de 2da línea
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
                        'labelAttributes' => array('icon' => 'icon-book',),
                    ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.main', $section)));

            $child
                ->addChild('arrangement_programs.list', array(
                    'route' => 'pequiven_seip_arrangementprogram_index',
                ))
            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.list', $section)));
            
            $child
                ->addChild('arrangement_programs.assigned', array(
                    'route' => 'pequiven_seip_arrangementprogram_assigned',
                ))
            ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.assigned', $section)));
            
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
}
