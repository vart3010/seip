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
class BackendMenuBuilder extends MenuBuilder implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

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
    public function createSidebarMenu(Request $request) {
        $seipConfiguration = $this->getSeipConfiguration();
        $user = $this->getUser();
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'big-menu',
            )
        ));
        $section = 'sidebar';
        $menu->addChild('home', array(
            'route' => self::ROUTE_DEFAULT, //Route
            'labelAttributes' => array('icon' => 'icon-home'),
        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.home', $section)));

        if ($seipConfiguration->isEnablePrePlanning() && $this->isGranted('ROLE_SEIP_PRE_PLANNING_*')) {
            $this->addMenuPrePlanning($menu, $section);
        }
        //$this->addExampleMenu($menu, $section);
        //Menu de objetivos
        if ($this->isGranted('ROLE_SEIP_OBJECTIVE_*')) {
            $this->addMenuObjetives($menu, $section);
        }

        //Menú Programas de Gestión
        if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_*')) {
            $this->addArrangementProgramsMenu($menu, $section);
        }

        //Menu de indicadores
        if ($this->isGranted('ROLE_SEIP_INDICATOR_*')) {
            $this->addMenuIndicators($menu, $section);
        }

//        //Menu de Resultados INTEGRADO CON ESTADISTICA E INFORMACION
//        if ($this->isGranted('ROLE_SEIP_RESULT_*')) {
//            $this->addMenuResults($menu, $section);
//        }
//        
        //Menú Estadística e Información
        if (($this->isGranted('ROLE_SEIP_PLANNING_*')) || ($this->isGranted('ROLE_SEIP_RESULT_*'))) {
            $this->addPlanningMenu($menu, $section);
        }

        //Menú Operaciones
        if ($this->isGranted('ROLE_SEIP_OPERATION_*')) {
            $this->addMenuOperation($menu, $section);
        }

        //Menú SIG
        if ($this->isGranted('ROLE_SEIP_SIG_MENU')) {
            $this->addMenuSIG($menu, $section);
        }

        //Menú Círculos de Estudio de Trabajo
        if ($this->isGranted('ROLE_SEIP_WORK_STUDY_CIRCLES_*')) {
            $this->addMenuWorkStudyCircles($menu, $section);
        }

        if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_USER_FEESTRUCTURE*')) {
            $this->addMenuUsuarios($menu, $section);
        }

        //Menú Sistema de Informacion Politica
        if ($this->isGranted('ROLE_SEIP_SIP_*') && $user->getId() != 5942) {
            $this->addMenuSip($menu, $section);
        }

        //Menú Administración         
        if (($this->isGranted('ROLE_SEIP_PLANNING_LIST_USER')) && ($this->isGranted('ROLE_SONATA_ADMIN'))) {
            $this->addAdministrationMenu($menu, $section);
        }

        //Modulos en Construcción        
        $this->addMenuModules($menu, $section);

        return $menu;
    }

    public function createBreadcrumbsMenu(Request

    $request) {
        //
        $bcmenu = $this->createSidebarMenu($request);
        return $this->getCurrentMenuItem($bcmenu);
    }

    /**
     * 
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuManagementUser(ItemInterface $menu, $section) {
        //if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_USER_ITEMS')) {
        $menuManagement = $this->factory->createItem('userManagement', $this->getSubLevelOptions(array(
                            'route' => 'pequiven_list_user_items',
                            'labelAttributes' => array('icon' => 'fa fa-users',),
                        ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.user.item_user_list', $section)));


        //}
        $menu->addChild($menuManagement);
    }

    /**
     * Construye y añade el menu SIG
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuSIG(ItemInterface

    $menu, $section) {
        $menuSig = $this->factory->createItem('sig', $this->getSubLevelOptions(array(
                            'uri' => null,
                            'labelAttributes' => array('icon' => 'fa fa-cubes',),
                        ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.main', $section)));
        if ($this->isGranted('ROLE_SEIP_SIG_OBJECTIVE')) {
            //Menú Nivel 2: Visualizar
            $objective = $this->factory->createItem('objective.main', $this->getSubLevelOptions(array(
                                'uri' => 'objetive',
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.objective.main', $section)));
            //Ver 
            $visualize = $this->factory->createItem('sig.indicator.visualize', $this->getSubLevelOptions(array(
                                'uri' => 'null',
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.indicator.visualize', $section)));
            //Nivel 3
            $visualize->addChild('planning.visualize.objetives.strategic', array(
                'route' => 'pequiven_objetives_list_sig',
                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_ESTRATEGICO)
            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.strategic', $section)));

            $visualize->addChild('planning.visualize.objetives.tactic', array(
                'route' => 'pequiven_objetives_list_sig',
                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_TACTICO)
            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.tactic', $section)));

            $visualize->addChild('planning.visualize.objetives.operative', array(
                'route' => 'pequiven_objetives_list_sig',
                'routeParameters' => array('level' => \Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_OPERATIVO)
            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.operative', $section)));

            $visualize->addChild('sig.objective.matrices_objectives', array(
                        'route' => 'pequiven_objetives_gerencia_list_sig',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.objective.matrices_objectives', $section)));
            //Lista de Informe de Evolución Consolidado
            $visualize->addChild('planning.visualize.objetives.consolid', array(
                'route' => 'pequiven_objetives_list_sig_evolution',                
            ))->setLabel($this->translate(sprintf('Informe de Evolución Consolidado', $section)));

            $objective->addChild($visualize);

            $menuSig->addChild($objective);
        }
        if ($this->isGranted('ROLE_SEIP_SIG_INDICATOR')) {
            //Indicator                
            $indicator = $this->factory->createItem('indicator.main', $this->getSubLevelOptions(array(
                                'uri' => 'indicator',
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.indicator.main', $section)));
            //Nivel 2                
            //Ver 
            $visualize = $this->factory->createItem('sig.indicator.list', $this->getSubLevelOptions(array(
                                'uri' => 'null',
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.indicator.visualize', $section)));
            //Nivel 3
            if ($this->isGranted('ROLE_SEIP_SIG_INDICATOR_LIST')) {
                $visualize->addChild('planning.visualize.indicators.strategic', array(
                    'route' => 'pequiven_indicatorsig_list',
                    'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_ESTRATEGICO)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.strategic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_SIG_INDICATOR_LIST')) {
                $visualize->addChild('planning.visualize.indicators.tactic', array(
                    'route' => 'pequiven_indicatorsig_list',
                    'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_TACTICO)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.tactic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_SIG_INDICATOR_LIST')) {
                $visualize->addChild('planning.visualize.indicators.operative', array(
                    'route' => 'pequiven_indicatorsig_list',
                    'routeParameters' => array('level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.operative', $section)));
            }

            $indicator->addChild($visualize);

            $menuSig->addChild($indicator);
            //Fin indicadores
        }
        if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM')) {
            //Sección Programas de Gestión
            //Pendientes
            $pending = $this->factory->createItem('arrangement_programs.list.pending', $this->getSubLevelOptions(array('uri' => null,
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.pending', $section)));
            //Visualizar general
            $arrangementProgram = $this->factory->createItem('arrangement_program.main', $this->getSubLevelOptions(array(
                                'uri' => 'arrangement_program',
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.main', $section)));

            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_*')) {
                //Menú Nivel 2: Visualizar
                $visualize = $this->factory->createItem('sig.arrangement_programs.visualize', $this->getSubLevelOptions(array('uri' => 'null',
                                    'labelAttributes' => array('icon' => '',),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.main', $section)));
                if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_LIST_ALL')) {
                    $visualize
                            ->addChild('sig.arrangement_program.visualize.listAllManagementSystem', array(
                                'route' => 'pequiven_seip_sig_arrangementprogram_all_managementSystem',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.listManegementSystem', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_LIST_ALL')) {
                    $visualize
                            ->addChild('sig.arrangement_program.visualize.listAll', array(
                                'route' => 'pequiven_seip_sig_arrangementprogram_all',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.listAll', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_LIST_ALL')) {
                    $visualize
                            ->addChild('sig.arrangement_program.visualize.assigned', array(
                                'route' => 'pequiven_seip_arrangementprogram_assigned_sig',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.assigned', $section)));
                }
                //Pendientes
                if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_LIST_ALL')) {
                    $pending
                            ->addChild('sig.arrangement_program.visualize.for_reviewing', array(
                                'route' => 'pequiven_seip_arrangementprogram_for_reviewing_sig',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.for_reviewing', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_LIST_ALL')) {
                    $pending
                            ->addChild('sig.arrangement_program.visualize.for_approving', array(
                                'route' => 'pequiven_seip_arrangementprogram_for_approving_sig',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.for_approving', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_LIST_ALL')) {
                    $pending
                            ->addChild('sig.arrangement_program.visualize.for_notifying', array(
                                'route' => 'pequiven_seip_arrangementprogram_for_notifying_sig',
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.visualize.for_notifying', $section)));
                }
                $visualize->addChild($pending);

                $arrangementProgram->addChild($visualize);
            }


            //Añadir
            if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_CREATE_*')) {
                $subchild = $this->factory->createItem('sig.arrangement_program.add.main', $this->getSubLevelOptions(array(
                                    'uri' => null,
                                    'labelAttributes' => array('icon' => 'icon-book',),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.main', $section)));

                if ($this->isGranted('ROLE_SEIP_SIG_ARRANGEMENT_PROGRAM_CREATE_OPERATIVE')) {
                    $subchild->addChild('sig.arrangement_program.add.find', array(
                                'route' => 'pequiven_arrangementprogram_create',
                                'routeParameters' => array('type' => \Pequiven \ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE, 'associate' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG),
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.arrangement_program.add.find', $section)));
                }

                $arrangementProgram->addChild($subchild);
            }

            $menuSig->addChild($arrangementProgram);
            $menu->addChild($menuSig);
        }

        if ($this->isGranted('ROLE_SEIP_SIG_MONITORING')) {
            $child = $this->factory->createItem('sig.monitoring.add.main', $this->getSubLevelOptions(array(
                                'route' => null,
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.monitoring.title', $section)));

            $child->addChild('sig.monitoring.vizualice.list-managementSystem', array(
                        'route' => 'pequiven_sig_monitoring_list',
                        'routeParameters' => array('type' => 1),
                        'labelAttributes' => array('icon' => ''),
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.monitoring.list_managementSystem', $section)));

            $child->addChild('sig.monitoring.vizualice.list-gerencias', array(
                        'route' => 'pequiven_sig_monitoring_list',
                        'routeParameters' => array('type' => 2),
                        'labelAttributes' => array('icon' => ''),
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.monitoring.list_gerencias', $section)));

            $menuSig->addChild($child);
        }
    }

    /**
     * Construye el menú de Administración
     * @param \Knp\Menu\ItemInterface $menu
     * @param type $section
     */
    function addAdministrationMenu(ItemInterface $menu, $section) {
        $user = $this->getUser();
        $child = $this->factory->createItem('admin', $this->getSubLevelOptions(array(
                            'uri' => '',
                            'labelAttributes' => array('icon' => 'icon-card'),
                        ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.main', $section)));

        if ($this->securityContext->isGranted(array('ROLE_SONATA_ADMIN')) && $user->getId() != 5942) {
            $child->addChild('admin', array(
                'route' => 'sonata_admin_dashboard',
            ))->setLabel($this->translate(sprintf('General', $section)));
        }

        //Gerencia de 1ra Línea
        if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_USER')) {
            $subchild = $this->factory->createItem('admin.gerencia_first', $this->getSubLevelOptions(array(
//                            'uri' => 'gerencia_first',
//                            'route' => 'pequiven_master_menu_list_gerenciaFirst',
                            ))
                    )
                    ->setLabel($this->translate(sprintf('Gerencias de 1ra Línea', $section)));

//        $subchild->addChild('admin.gerencia_first.list', array(
//                ))
//                ->setLabel($this->translate(sprintf('app.backend.menu.%s.admin.gerencia_first.list', $section)));

            $child->addChild($subchild);

            //Gerencia de 2da Línea
            $subchild = $this->factory->createItem('admin.gerencia_second', $this->getSubLevelOptions(array(
//                            'uri' => 'gerencia_second',
//                            'route' => 'pequiven_master_menu_list_gerenciaSecond',
                            ))
                    )
                    ->setLabel($this->translate(sprintf('Gerencias de 2da Línea', $section)));

            $child->addChild($subchild);

            $subchild = $this->factory->createItem('planning.visualize.users', $this->getSubLevelOptions(array('uri' => null,
                                'labelAttributes' => array('icon' => ''),
                            ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.users.main', $section)));

            $subchild->addChild('planning.visualize.users.real', array(
                        'route' => 'pequiven_user_list',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.users.real', $section)));

            $subchild->addChild('planning.visualize.users.aux', array(
                        'route' => 'pequiven_user_aux_list',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.users.aux', $section)));

            if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_USER_FEESTRUCTURE*')) {

                $subchild->addChild('planning.visualize.users.feestructure', array(
                            'route' => 'pequiven_user_feestructure',
                            'labelAttributes' => array('icon' => 'fa fa-sitemap'),
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.users.feeStructure', $section)));
            }
            $child->addChild($subchild);
        }

        $menu->addChild($child);
    }

    /**
     * Agregando menu de planificacion
     * 
     * @param ItemInterface $menu
     * @param type $section
     */
    function addPlanningMenu(ItemInterface $menu, $section) {

        $title = $this->trans('statisticsAndInformation', array(), 'PequivenSEIPBundle');
        $gerenciasResume = \ Pequiven \MasterBundle\Entity\Gerencia::getLabelsResume();

        if ($this->getUser()->getGerencia() && $this->getUser()->getGerencia()->getRef() == $gerenciasResume[\Pequiven\MasterBundle\Entity\Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]) {
            $title = $this->trans('internalAudit', array(), 'PequivenSEIPBundle');
        }

        $child = $this->factory->createItem('planning', $this->getSubLevelOptions(array(
                            'uri' => null,
                            'labelAttributes' => array('icon' => 'fa fa-bar-chart',),
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.main', $section), array('%titulo%' => $title)));

        if ($this->isGranted('ROLE_SEIP_RESULT_*')) {
            $this->addMenuResults($child, $section);
        }

        if ($this->isGranted('ROLE_SEIP_PLANNING_*')) {

            $visualize = $this->factory->createItem('planning.visualize', $this->getSubLevelOptions(array(
                                'labelAttributes' => array('icon' => ''),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));



            if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_*')) {
                $subchild = $this->factory->createItem('planning.visualize.objetives', $this->getSubLevelOptions(array('uri' => null,
                                    'labelAttributes' => array('icon' => 'fa fa-cubes',),
                                ))
                        )
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.main', $section)));
                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_STRATEGIC')) {
                    $subchild->addChild('planning.visualize.objetives.strategic', array('route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \ Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_ESTRATEGICO)
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.strategic', $section)));
                }

                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_TACTIC')) {
                    $subchild->addChild('planning.visualize.objetives.tactic', array(
                                'route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \ Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_TACTICO)
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.tactic', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_OPERATIVE')) {
                    $subchild->addChild('planning.visualize.objetives.operative', array('route' => 'pequiven_objetive_list',
                                'routeParameters' => array('level' => \ Pequiven\ObjetiveBundle\Model\ObjetiveLevel::LEVEL_OPERATIVO)
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.objetives.operative', $section)));
                }

                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_OBJECTIVE_MATRIX_OBJECTIVES')) {
                    $subchild->addChild('planning.visualize.objetive.matriz', array(
                        'uri' => null, 'route' => 'pequiven_master_menu_list_gerenciaFirst',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.matriz', $section)));
                }

                $visualize->addChild($subchild);
            }

            if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_*')) {
                $subchild = $this->factory->createItem('planning.visualize.indicators', $this->getSubLevelOptions(array(
                                    'uri' => null,
                                    'labelAttributes' => array('icon' => 'fa fa-line-chart',),
                                ))
                        )
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.main', $section)));
                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_STRATEGIC')) {
                    $subchild->addChild('planning.visualize.indicators.strategic', array('route' => 'pequiven_indicator_list',
                                'routeParameters' => array('level' => \ Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_ESTRATEGICO)
                            ))
                            ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.strategic', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_TACTIC')) {
                    $subchild->addChild('planning.visualize.indicators.tactic', array(
                        'route' => 'pequiven_indicator_list',
                        'routeParameters' => array('level' => \ Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_TACTICO)
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.tactic', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_OPERATIVE')) {
                    $subchild->addChild('planning.visualize.indicators.operative', array(
                        'route' => 'pequiven_indicator_list',
                        'routeParameters' => array('level' => \ Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO)
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.operative', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_INDICATOR_ERROR')) {
                    $subchild->addChild('planning.visualize.indicators.error', array(
                        'route' => 'pequiven_indicator_list_error',
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.indicators.withError', $section)));
                }

                $visualize->addChild($subchild);
            }//Fin menu Ver - Indicadores

            if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_ARRANGEMENT_PROGRAM')) {
                $subchild = $this->factory->createItem('planning.visualize.arrangement_programs', $this->getSubLevelOptions(array(
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

//            if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_RESULT_*')) {
//
//                if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_RESULT_ALL')) {
//                    $visualize->addChild('planning.visualize.results.all', array(
//                                'route' => 'pequiven_result_list',
//                                'routeParameters' => array('level' => \ Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO),
//                                'labelAttributes' => array('icon' => 'fa fa-calculator')
//                            ))
//                            ->setLabel($this->translate(sprintf('Resultados de Objetivos', $section)));
//                }
//            }
            //SUB-MENU PARA CONSULTAR USUARIO
            if ($this->isGranted('ROLE_SEIP_PLANNING_LIST_USER_ITEMS')) {
                $visualize->addChild('planning.visualize.user.list.user.items', array(
                            'route' => 'pequiven_list_user_items',
                            'labelAttributes' => array('icon' => 'fa fa-users')
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.user.item_user_list', $section)));
            }

            $visualize->addChild('planning.visualize.user.list.user.items', array(
                        'route' => 'pequiven_indicator_evolution_load',
                        'labelAttributes' => array('icon' => 'fa fa-bar-chart')
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.sig.evolution', $section)));


            //Fin sub Ver - menu objetivos
            //Menu de carga de datos
//            if($this->isGranted('ROLE_SEIP_DATA_LOAD_*')){
//                $this->addListDataLoad($visualize, $section);
//            }
            $child->addChild($visualize);
        }

        if ($this->isGranted('ROLE_SEIP_PLANNING_OPERATION_*')) {
            $subchild = $this->factory->createItem('planning.operations', $this->getSubLevelOptions(array(
                                'uri' => null,
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.operations.main', $section)));

            if ($this->isGranted('ROLE_SEIP_PLANNING_OPERATION_RECALCULATE_RESULT')) {
                $subchild->addChild('planning.operations.recalculate_result', array(
                            'route' => 'pequiven_result_recalculate',
                            'labelAttributes' => array('icon' => 'fa fa-calculator')
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.operations.recalculate_results', $section)));
            }

            $child->addChild($subchild);
        }

        if ($this->isGranted('ROLE_SEIP_PLANNING_MONITOR_*')) {
            $subchild = $this->factory->createItem('planning.monitor', $this->getSubLevelOptions(array(
                                'uri' => null,
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.monitor.main', $section)));

            if ($this->isGranted('ROLE_SEIP_PLANNING_MONITOR_OBJECTIVE_TACTIC')) {
                $subchild->addChild('planning.monitor.objective_tactic', array(
                            'route' => 'monitorObjetiveTactic',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.monitor.objective_tactic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_PLANNING_MONITOR_OBJECTIVE_OPERATIVE')) {
                $subchild->addChild('planning.monitor.objective_operative', array(
                            'route' => 'monitorObjetiveOperative',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.monitor.objective_operative', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_PLANNING_MONITOR_ARRANGEMENT_PROGRAM')) {
                $subchild->addChild('planning.monitor.arrangement_program', array(
                            'route' => 'monitorArrangementProgram',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.planning.monitor.arrangement_program', $section)));
            }

            $child->addChild($subchild);
        }

        //Menu de carga de datos
//        if($this->isGranted('ROLE_SEIP_DATA_LOAD_*')){
//            $this->addDataLoad($child, $section);
//        }

        $menu->addChild($child);
    }

    private function addMenuPrePlanning(ItemInterface $menu, $section) {
        $nextPeriod = $this->getPeriodService()->getNextPeriod();
        $periodName = null;
        if ($nextPeriod) {
            $periodName = $nextPeriod->getName();
        }
        if ($periodName === null) {
            return;
        }
        $child = $this->factory->createItem('preplanning', $this->getSubLevelOptions(array(
                            'uri'
                            => null,
                            'labelAttributes' => array('icon' => 'fa fa-calendar',),
                )))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.main', $section), array('%period%' => $periodName)));
        if ($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_*')) {
            $preplanningAdd = $this->factory->createItem('preplanning.add', $this->getSubLevelOptions(array('uri' => 'add',
                                'labelAttributes' => array('icon' => 'icon-book'),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.main', $section)));

            if ($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC')) {
                $preplanningAdd->addChild('preplanning.add.tactic', array(
                    'route' => 'pequiven_pre_planning_create', //Route
                    'labelAttributes' => array('icon' => 'fa fa-cube'),
                    'routeParameters' => array('period' => $periodName, 'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO),
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.tactic', $section)));
            }

            if ($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE')) {
                $preplanningAdd->addChild('preplanning.add.operative', array(
                    'route' => 'pequiven_pre_planning_create', //Route
                    'labelAttributes' => array('icon' => 'fa fa-cog'),
                    'routeParameters' => array('period' => $periodName, 'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO),
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.operative', $section)));
            }
            $child->addChild($preplanningAdd);
        }

        if ($this->isGranted('ROLE_SEIP_PRE_PLANNING_LIST_*')) {
            $visualize = $this->factory->createItem('preplanning.visualize', $this->getSubLevelOptions(array(
                                'labelAttributes' => array('icon' => 'fa fa-sitemap',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
            if ($nextPeriod) {
                if ($this->isGranted('ROLE_SEIP_PRE_PLANNING_LIST_PLANNING')) {
                    $visualize->addChild('preplanning.visualize.planning', array(
                        'route' => 'pequiven_pre_planning_user_index', //Route
                        'labelAttributes' => array('icon' => ''),
                        'routeParameters' => array('period' => $periodName, 'type' => \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser::FORM_PLANNING),
                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.pre_planning.planning', $section)));
                }
                if ($this->isGranted('ROLE_SEIP_PRE_PLANNING_LIST_STATISTICS')) {
                    $visualize->addChild('preplanning.visualize.statistics', array(
                        'route' => 'pequiven_pre_planning_user_index', //Route
                        'labelAttributes' => array('icon' => ''),
                        'routeParameters' => array('period' => $periodName, 'type' => \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser::FORM_STATISTICS),
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
        $menuObjetives = $this->factory->createItem('objetives', $this->getSubLevelOptions(array(
                            'uri'
                            => null,
                            'labelAttributes' => array('icon' => 'fa fa-cubes',),
                        ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.main', $section)));


        if ($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_*')) {
            //Menú Nivel 2: Visualizar
            $visualize = $this->factory->createItem('objetives.visualize', $this->getSubLevelOptions(array('uri' => 'objetive',
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
            //Menú Nivel 3: Item de visulizar
            if ($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_STRATEGIC')) {
                $visualize->addChild('arrangement_strategic.objetives.list.strategic', array(
                            'route' => 'pequiven_objetive_menu_list_strategic',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.strategic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_TACTIC')) {
                $visualize->addChild('arrangement_strategic.objetives.list.tactic', array(
                            'route' => 'pequiven_objetive_menu_list_tactic',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.tactic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_OPERATIVE')) {
                $visualize->addChild('arrangement_strategic.objetives.list.operative', array(
                            'route' => 'pequiven_objetive_menu_list_operative',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.list.operative', $section)));
            }

            if ($this->isGranted('ROLE_SEIP_OBJECTIVE_LIST_MATRIX_OBJECTIVES')) {
                //Matrices objectives
                $visualize->addChild('objetives.matrices_objectives', array(
                            'route' => 'pequiven_master_menu_list_gerenciaFirst',
                                )
                        )
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.matrices_objectives', $section)));
            }

            $menuObjetives->addChild($visualize);
        }

        if ($this->isGranted('ROLE_SEIP_OBJECTIVE_CREATE_*') && $this->getPeriodService()->isAllowLoadObjetive()) {
            $thirdchild = $this->factory->createItem('arrangement_strategic.objetives.add', $this->getSubLevelOptions(array(
                                'uri' => 'add',
                                'labelAttributes' => array('icon' => 'icon-book'),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.main', $section)));

            //Si el usuario logueado es Rol Ejecutivo o Ejecutivo Asignado
            if ($this->isGranted('ROLE_SEIP_OBJECTIVE_CREATE_STRATEGIC')) {
                $thirdchild->addChild('arrangement_strategic.objetives.add.strategic', array(
                            'route' => 'pequiven_objetive_menu_add_strategic',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.strategic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_OBJECTIVE_CREATE_TACTIC')) {
                $thirdchild->addChild('arrangement_strategic.objetives.add.tactic', array(
                            'route' => 'pequiven_objetive_menu_add_tactic',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.objetives.add.tactic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_OBJECTIVE_CREATE_OPERATIVE')) {
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
        $menuIndicators = $this->factory->createItem('indicators', $this->getSubLevelOptions(array(
                            'uri'
                            => null,
                            'labelAttributes' => array('icon' => 'fa fa-line-chart',),
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.main', $section)));

        if ($this->isGranted('ROLE_SEIP_INDICATOR_LIST_*')) {
            //Menú Nivel 3: Lista de Indicadores
            $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.list', $this->getSubLevelOptions(array('uri' => 'list',
                    )))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.main', $section)));

            if ($this->isGranted('ROLE_SEIP_INDICATOR_LIST_STRATEGIC')) {
                $itemIndicatorsStrategic = $this->factory->createItem('arrangement_strategic.indicators.list.strategic', array(
                            'route' => 'pequiven_indicator_menu_list_strategic',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.strategic', $section)));
                $thirdchild->addChild($itemIndicatorsStrategic);
            }
            if ($this->isGranted('ROLE_SEIP_INDICATOR_LIST_TACTIC')) {
                $itemIndicatorsTactic = $this->factory->createItem('arrangement_strategic.indicators.list.tactic', array(
                            'route' => 'pequiven_indicator_menu_list_tactic',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.tactic', $section)));
                $thirdchild->addChild($itemIndicatorsTactic);
            }
            if ($this->isGranted('ROLE_SEIP_INDICATOR_LIST_OPERATIVE')) {
                $itemIndicatorsOperative = $this->factory->createItem('arrangement_strategic.indicators.list.operative', array(
                            'route' => 'pequiven_indicator_menu_list_operative',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.list.operative', $section)));
                $thirdchild->addChild($itemIndicatorsOperative);
            }

            $menuIndicators->addChild($thirdchild);
        }

        if (($this->isGranted('ROLE_SEIP_INDICATOR_CREATE_*') && $this->getPeriodService()->isAllowLoadIndicator()) || $this->isGranted('ROLE_SEIP_INDICATOR_CREATE_SPECIAL')) {
            //Menú Nivel 3: Registro de Indicadores
            $thirdchild = $this->factory->createItem('arrangement_strategic.indicators.add', $this->getSubLevelOptions(array(
                                'uri' => 'add',))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.main', $section)));

            if ($this->isGranted('ROLE_SEIP_INDICATOR_CREATE_STRATEGIC')) {
                $thirdchild->addChild('arrangement_strategic.indicators.add.strategic', array(
                    'route' => 'pequiven_indicator_menu_add_strategic',
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.strategic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_INDICATOR_CREATE_TACTIC')) {
                $thirdchild->addChild('arrangement_strategic.indicators.add.tactic', array(
                    'route' => 'pequiven_indicator_menu_add_tactic',
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.tactic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_INDICATOR_CREATE_OPERATIVE')) {
                $thirdchild->addChild('arrangement_strategic.indicators.add.operative', array(
                    'route' => 'pequiven_indicator_menu_add_operative',
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_strategic.indicators.add.operative', $section)));
            }

            $menuIndicators->addChild($thirdchild);
        }

        //Menu de carga de notificaciones
//            if($this->isGranted('ROLE_SEIP_DATA_LOAD_*')){
//                $this->addDataLoadNotification($menuIndicators, $section);
//            }

        $menu->addChild($menuIndicators);
    }

    /**
     * Construye y añade el menu de objetivos
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuResults(ItemInterface $menu, $section) {
        $visualize = $this->factory->createItem('results', $this->getSubLevelOptions(array(
                            'uri'
                            => null,
                            'labelAttributes' => array('icon' => '',),
                        ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.results.main', $section)));
        if ($this->isGranted(array('ROLE_SEIP_RESULT_LIST_*', 'ROLE_SEIP_RESULT_MANAGEMENT_CONSULTING_USER', 'ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPJAA'))) {
//            //Menú Nivel 2: Visualizar
//            $visualize = $this->factory->createItem('results.visualize', $this->getSubLevelOptions(array('uri' => 'objetive',
//                                'labelAttributes' => array('icon' => '',),
//                            ))
//                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.main', $section)));

            if ($this->isGranted('ROLE_SEIP_RESULT_LIST_BY_MANAGEMENT')) {
                $itemByGerenciaVisualize = $this->factory->createItem('results.visualize.by_gerencia', array(
                            'route' => 'pequiven_seip_result_visualize_by_gerencia',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.by_gerencia', $section)));
                $visualize->addChild($itemByGerenciaVisualize);
            }

//            if ($this->isGranted('ROLE_SEIP_RESULT_LIST_STRATEGICS')) {
            if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_LINE_STRATEGICS')) {
                $itemStrategicsVisualize = $this->factory->createItem('results.visualize.by_lineStrategic', array(
                            'route' => 'pequiven_line_strategic_view_dashboard',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.by_lineStrategic', $section)));
                $visualize->addChild($itemStrategicsVisualize);
            }

            if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_STRATEGICS')) {
                $itemStrategicsIndicators = $this->factory->createItem('results.visualize.indicator.strategics', array(
                            'route' => 'pequiven_line_strategic_indicators_strategics',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.indicator.strategics', $section)));
                $visualize->addChild($itemStrategicsIndicators);
            }

            if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_OBJETIVES_STRATEGICS')) {
                $itemStrategicsObjetives = $this->factory->createItem('results.visualize.objetive.strategics', array(
                            'route' => 'pequiven_line_strategic_view_objetives_strategics',
                        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.objetive.strategics', $section)));
                $visualize->addChild($itemStrategicsObjetives);
            }

            /*             * CPHC
              if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPHC')) {
              $itemStrategicsIndicatorsCphc = $this->factory->createItem('results.visualize.indicator.cphc', array(
              //'route' => 'pequiven_line_strategic_indicators_specific',
              'routeParameters' => array('complejo' => 1),
              'route' => 'pequiven_line_strategic_view_dashboard_complejo',
              ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.indicator.cphc', $section)));
              $visualize->addChild($itemStrategicsIndicatorsCphc);
              }
             */

            /* Mostrar CPAMC
              if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPAMC')) {
              $itemStrategicsIndicatorsCpamc = $this->factory->createItem('results.visualize.indicator.cpamc', array(
              //'route' => 'pequiven_line_strategic_indicators_specific',
              'routeParameters' => array('complejo' => 2),
              'route' => 'pequiven_line_strategic_view_dashboard_complejo',
              ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.indicator.cpamc', $section)));
              $visualize->addChild($itemStrategicsIndicatorsCpamc);
              }
             */

            /* Mostar CPJAA
              if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_CPJAA')){
              $itemStrategicsIndicatorsCpjaa = $this->factory->createItem('results.visualize.indicator.cpjaa', array(
              'route' => 'pequiven_line_strategic_view_dashboard_complejo',
              //'route' => 'pequiven_line_strategic_indicators_specific',
              'routeParameters' => array('complejo' => 3),
              ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.indicator.cpjaa', $section)));
              $visualize->addChild($itemStrategicsIndicatorsCpjaa);
              }
             */

            $itemPeriod = $this->factory->createItem('results.period', $this->getSubLevelOptions())
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.main', $section)));

            if ($this->isGranted('ROLE_SEIP_RESULT_LIST_PERIOD')) {
                //Periodos
                $periods = $this->container->get('pequiven.repository.period')->findAllForConsultation();
                foreach ($periods as $period) {
                    $_period = $period->getId();
                    $year = $period->getYear();
                    $itemName = 'results.notify.period.' . $period->getId();

                    /* Periodo -> */
                    $itemPeriodConsultation = $this->factory->createItem($itemName, $this->getSubLevelOptions(
                                            array()))->setLabel($year);
                    /* Objetivos -> */
                    $itemPeriodConsultationObjetives = $this->factory->createItem($itemName . $_period . 'objetives', $this->getSubLevelOptions(
                                            array()
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.objetives', $section)));

                    $itemPeriodConsultationStrategic = $this->factory->createItem($itemName . $_period . 'objetives' . 'strategic', $this->getSubLevelOptions(
                                            array('route' => "pequiven_seip_result_visualize_objetives",
                                                'routeParameters' => array('_period' => $_period, 'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO),
                                            )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.strategic', $section)));
                    $itemPeriodConsultationObjetives->addChild($itemPeriodConsultationStrategic);

                    $itemPeriodConsultationTactic = $this->factory->createItem($itemName . $_period . 'objetives' . 'tactic', $this->getSubLevelOptions(
                                            array(
                                                'route' => "pequiven_seip_result_visualize_objetives",
                                                'routeParameters' => array('_period' => $_period, 'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO),
                                            )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.tactic', $section)));
                    $itemPeriodConsultationObjetives->addChild($itemPeriodConsultationTactic);

                    $itemPeriodConsultationOperative = $this->factory->createItem($itemName . $_period . 'objetives' . 'operative', $this->getSubLevelOptions(
                                            array(
                                                'route' => "pequiven_seip_result_visualize_objetives",
                                                'routeParameters' => array('_period' => $_period, 'level' => \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO),
                                            )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.operative', $section)));
                    $itemPeriodConsultationObjetives->addChild($itemPeriodConsultationOperative);

                    $itemPeriodConsultation->addChild($itemPeriodConsultationObjetives);

                    /* Indicadores -> */
                    $itemPeriodConsultationIndicators = $this->factory->createItem($itemName . $_period . 'indicators', $this->getSubLevelOptions(
                                            array(
                                            )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.indicators', $section)));

                    $itemPeriodConsultationIndicatorsStrategic = $this->factory->createItem($itemName . $_period . 'indicators' . 'strategic', $this->getSubLevelOptions(
                                            array('route' => "pequiven_seip_result_visualize_indicators",
                                                'routeParameters' => array('_period' => $_period, 'level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_ESTRATEGICO),
                                            )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.strategic', $section)));
                    $itemPeriodConsultationIndicators->addChild($itemPeriodConsultationIndicatorsStrategic);

                    $itemPeriodConsultationIndicatorsTactic = $this->factory->createItem($itemName . $_period . 'indicators' . 'tactic', $this->getSubLevelOptions(
                                            array(
                                                'route' => "pequiven_seip_result_visualize_indicators",
                                                'routeParameters' => array('_period' => $_period, 'level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_TACTICO),
                                            )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.tactic', $section)));
                    $itemPeriodConsultationIndicators->addChild($itemPeriodConsultationIndicatorsTactic);

                    $itemPeriodConsultationIndicatorsOperative = $this->factory->createItem($itemName . $_period . 'indicators' . 'operative', $this->getSubLevelOptions(
                                            array(
                                                'route' => "pequiven_seip_result_visualize_indicators",
                                                'routeParameters' => array('_period' => $_period, 'level' => \Pequiven\IndicatorBundle\Model\IndicatorLevel::LEVEL_OPERATIVO),
                                            )
                            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.results.period.level.operative', $section)));
                    $itemPeriodConsultationIndicators->addChild($itemPeriodConsultationIndicatorsOperative);

                    $itemPeriodConsultation->addChild($itemPeriodConsultationIndicators);

                    /* Programas de gestion -> */
                    $itemPeriodArrangementPrograms = $this->factory->createItem($itemName . $_period . 'arrangement_programs', $this->getSubLevelOptions(
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

            /*             * COMPLEJOS */
            if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_*')) {
                $complejos = $this->factory->createItem('results.visualize.complejo', $this->getSubLevelOptions())
                        ->setLabel($this->translate(sprintf('Tableros de Indicadores', $section)));

                $em = $this->getDoctrine()->getManager();
                $complejos_sql = $em->getRepository('PequivenMasterBundle:Complejo')->findAll();

                foreach ($complejos_sql as $varComplejo) {
                    $idC = $varComplejo->getId();
                    $refC = $varComplejo->getRef();

                    if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_' . $refC)) {
                        $refC = strtolower($refC);
                        $itemStrategicsIndicators = $this->factory->createItem('results.visualize.indicator.' . $refC, array(
                                    'route' => 'pequiven_line_strategic_view_dashboard_complejo',
                                    //'route' => 'pequiven_line_strategic_indicators_specific',
                                    'routeParameters' => array('complejo' => $idC),
                            'labelAttributes' => array('icon' => 'fa fa-industry',),
                                ))->setLabel($this->translate(sprintf(strtoupper($refC), $section)));
                        $complejos->addChild($itemStrategicsIndicators);
                    }
                }

                if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_RRHH')) {
                    $itemsTableros = $this->factory->createItem('results.visualize.tableros.rrhh', array(
                                'route' => 'pequiven_dasboard_linestrategicbygroup',
                                'routeParameters' => array('idGroup' => 5),
                                'labelAttributes' => array('icon' => 'fa fa-cubes',),
                            ))->setLabel($this->translate(sprintf('Recursos Humanos', $section)));
                    $complejos->addChild($itemsTableros);
                }
                if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_FINANZAS')) {
                    $itemsTableros = $this->factory->createItem('results.visualize.tableros.finanzas', array(
                                'route' => 'pequiven_dasboard_linestrategicbygroup',
                                'routeParameters' => array('idGroup' => 6),
                                'labelAttributes' => array('icon' => 'fa fa-cubes',),
                            ))->setLabel($this->translate(sprintf('Finanzas', $section)));
                    $complejos->addChild($itemsTableros);
                }
                if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_SHA')) {
                    $itemsTableros = $this->factory->createItem('results.visualize.tableros.sha', array(
                                'route' => 'pequiven_dasboard_linestrategicbygroup',
                                'routeParameters' => array('idGroup' => 7),
                                'labelAttributes' => array('icon' => 'fa fa-cubes',),
                            ))->setLabel($this->translate(sprintf('SHA', $section)));
                    $complejos->addChild($itemsTableros);
                }
                if ($this->isGranted('ROLE_SEIP_RESULT_VIEW_BY_INDICATORS_SALUD')) {
                    $itemsTableros = $this->factory->createItem('results.visualize.tableros.salud', array(
                                'route' => 'pequiven_dasboard_linestrategicbygroup',
                                'routeParameters' => array('idGroup' => 8),
                                'labelAttributes' => array('icon' => 'fa fa-cubes',),
                            ))->setLabel($this->translate(sprintf('Salud', $section)));
                    $complejos->addChild($itemsTableros);
                }
            }

            $visualize->addChild($complejos);




            //SUB-MENU PARA CONSULTAR USUARIO
            if ($this->isGranted('ROLE_SEIP_RESULT_MANAGEMENT_CONSULTING_USER')) {
                $visualize->addChild('results.visualize.list_user_items', array(
                            'route' => 'pequiven_list_user_items',
                            'labelAttributes' => array('icon' => 'fa fa-users')
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.results.visualize.item_user_list', $section)));
                //}
            }

            // $menuResults->addChild($visualize);
        }

        $menu->addChild($visualize);
    }

    private function addMenuOperation(ItemInterface $menu, $section) {
        $menuOperations = $this->factory->createItem('operations', $this->getSubLevelOptions(array(
                            'uri' => null,
                            'labelAttributes'
                            => array('icon' => 'fa fa-cogs',),
                        ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.main', $section)));

        //Monitor de carga por día
        if ($this->isGranted('ROLE_SEIP_OPERATION_LIST_MONITOR_*')) {

            $monitor = $this->factory->createItem('operations.monitor', $this->getSubLevelOptions(array('uri' => null,
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.monitor.main', $section)));

            if ($this->isGranted(array('ROLE_SEIP_OPERATION_VIEW_MONITOR_PRODUCTION'))) {
                $production = $this->factory->createItem('operations.monitor.production', $this->getSubLevelOptions(array("route" => "",
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.monitor.production.main', $section)));

                if ($this->isGranted(array('ROLE_SEIP_OPERATION_VIEW_MONITOR_PRODUCTION_STATUS_CHARGE'))) {
                    $productionStatusCharge = $this->factory->createItem('operations.monitor.production.status_charge', $this->getSubLevelOptions(array("route" => "pequiven_data_load_dashboard_production",
                                        'routeParameters' => array('typeView' => \Pequiven\SEIPBundle\Entity\Monitor::MONITOR_PRODUCTION_VIEW_STATUS_CHARGE),
                                    ))
                            )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.monitor.production.statusCharge', $section)));

                    $production->addChild($productionStatusCharge);
                }

                if ($this->isGranted(array('ROLE_SEIP_OPERATION_VIEW_MONITOR_PRODUCTION_COMPLIANCE'))) {
                    $productionStatusCharge = $this->factory->createItem('operations.monitor.production.compliance', $this->getSubLevelOptions(array("route" => "pequiven_data_load_dashboard_production",
                                        'routeParameters' => array('typeView' => \Pequiven\SEIPBundle\Entity\Monitor::MONITOR_PRODUCTION_VIEW_COMPLIANCE),
                                    ))
                            )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.monitor.production.compliance', $section)));

                    $production->addChild($productionStatusCharge);
                }

                $monitor->addChild($production);
            }

            $menuOperations->addChild($monitor);
        }

        //Sección de Reportes
        if ($this->isGranted('ROLE_SEIP_OPERATION_LIST_REPORT_*')) {

            $reports = $this->factory->createItem('operations.reports', $this->getSubLevelOptions(array(
                                'uri' => null,
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.reports.main', $section)));

            if ($this->isGranted(array('ROLE_SEIP_OPERATION_LIST_REPORT_PRODUCTION', 'ROLE_SEIP_OPERATION_LIST_REPORT_PRODUCTION_TEMPLATES_ALL'))) {
                $production = $this->factory->createItem('operations.reports.production', $this->getSubLevelOptions(array("route" => "pequiven_report_template_vizualice",
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.reports.production', $section)));

                $reports->addChild($production);
            }
            if ($this->isGranted(array('ROLE_SEIP_OPERATION_LIST_REPORT_DELIVERY'))) {
                $delivery = $this->factory->createItem('operations.reports.delivery', $this->getSubLevelOptions(array("route" => "",
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.reports.delivery', $section)));

                $reports->addChild($delivery);
            }
            $menuOperations->addChild($reports);
        }

        //Sección de Planificación de Plantillas
        if ($this->isGranted('ROLE_SEIP_OPERATION_LIST_PLANNING_*')) {
            $planning = $this->factory->createItem('operations.planning', $this->getSubLevelOptions(array(
                                'uri' => null,
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.planning.main', $section)));

            if ($this->isGranted(array('ROLE_SEIP_OPERATION_LIST_PLANNING_PRODUCTION', 'ROLE_SEIP_OPERATION_LIST_PLANNING_PRODUCTION_TEMPLATES_ALL'))) {
                $production = $this->factory->createItem('operations.planning.production', $this->getSubLevelOptions(array("route" => "pequiven_report_template_index",
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.planning.production', $section)));

                $planning->addChild($production);
            }

            if ($this->isGranted(array('ROLE_SEIP_OPERATION_LIST_PLANNING_DELIVERY'))) {
                $delivery = $this->factory->createItem('operations.planning.delivery', $this->getSubLevelOptions(array("route" => "pequiven_report_template_delivery_index",
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.planning.delivery', $section)));

                $planning->addChild($delivery);
            }

            $menuOperations->addChild($planning);
        }

        //Sección de Notificación
        if ($this->isGranted('ROLE_SEIP_OPERATION_LIST_NOTIFICATION_*')) {
            $notification = $this->factory->createItem('operations.notification', $this->getSubLevelOptions(array(
                                'uri' => null,
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.notification.main', $section)));

            if ($this->isGranted(array('ROLE_SEIP_OPERATION_LIST_NOTIFICATION_PRODUCTION', 'ROLE_SEIP_OPERATION_LIST_NOTIFICATION_PRODUCTION_TEMPLATES_ALL'))) {
                $production = $this->factory->createItem('operations.notification.production', $this->getSubLevelOptions(array("route" => "pequiven_plant_report_index",
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.notification.production', $section)));

                $notification->addChild($production);
            }

            if ($this->isGranted(array('ROLE_SEIP_OPERATION_LIST_NOTIFICATION_DELIVERY'))) {
                $delivery = $this->factory->createItem('operations.notification.delivery', $this->getSubLevelOptions(array("route" => "",
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.operations.notification.delivery', $section)));

                $notification->addChild($delivery);
            }

            $menuOperations->addChild($notification);
        }

        $menu->addChild($menuOperations);
    }

    private function addDataLoad(ItemInterface $menu, $section) {
        $child = $this->factory->createItem('data_load', $this->getSubLevelOptions(array(
                            'uri' =>
                            null,
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.main', $section)));

        $list = $this->factory->createItem('indicators.data_load.production', $this->getSubLevelOptions(array("route" => "pequiven_report_template_index",
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.production', $section)));

        $child->addChild($list);

        $listAdd = $this->factory->createItem('indicators.data_load.reports.sales', $this->getSubLevelOptions(array(
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.sales', $section)));
        $child->addChild($listAdd);

        $listAdd = $this->factory->createItem('indicators.data_load.reports.finance', $this->getSubLevelOptions(array(
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.finance', $section)));
        $child->addChild($listAdd);

        $menu->addChild($child);
    }

    /**
     * Agregando lista de carga de data
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addListDataLoad(ItemInterface $menu, $section) {
        $child = $this->factory->createItem('data_load', $this->getSubLevelOptions(array(
                            'uri'
                            => null,
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.main', $section)));

        $list = $this->factory->createItem('indicators.data_load.production', $this->getSubLevelOptions(array("route" => "pequiven_report_template_vizualice",
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.production', $section)));

        $child->addChild($list);

        $listAdd = $this->factory->createItem('indicators.data_load.reports.sales', $this->getSubLevelOptions(array(
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.sales', $section)));
        $child->addChild($listAdd);

        $listAdd = $this->factory->createItem('indicators.data_load.reports.finance', $this->getSubLevelOptions(array(
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.finance', $section)));
        $child->addChild($listAdd);

        $menu->addChild($child);
    }

    private function addDataLoadNotification(ItemInterface $menu, $section) {
        $child = $this->factory->createItem('data_load.notification', $this->getSubLevelOptions(array(
                            'uri'
                            => null,
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.notification', $section)));

        $list = $this->factory->createItem('indicators.data_load.notification.production', $this->getSubLevelOptions(array("route" => "pequiven_plant_report_index",
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.production', $section)));

        $child->addChild($list);

        $listAdd = $this->factory->createItem('indicators.data_load.notification.sales', $this->getSubLevelOptions(array(
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.sales', $section)));
        $child->addChild($listAdd);

        $listAdd = $this->factory->createItem('indicators.data_load.notification.finance', $this->getSubLevelOptions(array(
                )))->setLabel($this->translate(sprintf('app.backend.menu.%s.data_load.finance', $section)));
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
        $child = $this->factory->createItem('arrangement_programs', $this->getSubLevelOptions(array(
                            'uri'
                            => null,
                            'labelAttributes' => array('icon' => 'fa fa-tasks',),
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.main', $section)));

        if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_*')) {
            $pending = $this->factory->createItem('arrangement_programs.list.pending', $this->getSubLevelOptions(array('uri' => null,
                                'labelAttributes' => array('icon' => '',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.pending', $section)));

            //Menú Nivel 2: Visualizar
            $visualize = $this->factory->createItem('arrangement_programs.visualize', $this->getSubLevelOptions(array('uri' => 'arrangement_programs',
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.objetives.visualize.main', $section)));
            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_ALL')) {
                $visualize
                        ->addChild('arrangement_programs.list', array(
                            'route' => 'pequiven_seip_arrangementprogram_index',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.list', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_ASSIGNED')) {
                $visualize
                        ->addChild('arrangement_programs.assigned', array(
                            'route' => 'pequiven_seip_arrangementprogram_assigned',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.assigned', $section)));
            }

            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_FOR_REVIEWING')) {
                $pending
                        ->addChild('arrangement_programs.for_reviewing', array(
                            'route' => 'pequiven_seip_arrangementprogram_for_reviewing',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_reviewing', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_FOR_APPROVING')) {
                $pending
                        ->addChild('arrangement_programs.for_approving', array(
                            'route' => 'pequiven_seip_arrangementprogram_for_approving',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_approving', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_LIST_FOR_NOTIFYING')) {
                $pending
                        ->addChild('arrangement_programs.for_notifying', array(
                            'route' => 'pequiven_seip_arrangementprogram_for_notifying',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.for_notifying', $section)));
            }

            $visualize->addChild($pending);
            $child->addChild($visualize);
        }

        if (($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_*') && $this->getPeriodService()->isAllowLoadArrangementProgram()) || $this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_SPECIAL')) {
//            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_SPECIAL')) {
            $subchild = $this->factory->createItem('arrangement_programs.add.main', $this->getSubLevelOptions(array(
                                'uri' => null,
                                'labelAttributes' => array('icon' => 'icon-book',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.main', $section)));

            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_TACTIC')) {
                $subchild
                        ->addChild('arrangement_programs.tactic', array(
                            'route' => 'pequiven_arrangementprogram_create',
                            'routeParameters' => array('type' => \Pequiven \ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC, 'associate' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA),
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.tactic', $section)));
            }
            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_OPERATIVE')) {
                $subchild->addChild('arrangement_programs.operative', array(
                            'route' => 'pequiven_arrangementprogram_create',
                            'routeParameters' => array('type' => \Pequiven \ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE, 'associate' => \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA),
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.add.operative', $section)));
            }

            if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_FROM_TEMPLATE')) {
                $subchild->addChild('arrangement_programs.temaplate', array(
                            'route' => 'pequiven_seip_arrangementprogram_template_index',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement_programs.temaplate', $section)));
            }

            $child->addChild($subchild);
//            }
        }

        $menu->addChild($child);
    }

    /**
     * Construye el menú de Círculos de Estudio de Trabajo
     * @param ItemInterface $menu
     * @param type $section
     */
    public function addMenuWorkStudyCircles(ItemInterface $menu, $section) {
        $user = $this->getUser();
        $workStudyCircleService = $this->getWorkStudyCircleService();

        $menuWorkStudyCircles = $this->factory->createItem('work_study_circles', $this->getSubLevelOptions(array(
                            'uri' => null,
                            'labelAttributes' => array('icon' => 'fa fa-users',),
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.main', $section)));

        if ($this->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_CREATE')) && $this->getPeriodService()->isAllowLoadWorkStudyCircle()) {

            $workStudyCirclesRegister = $this->factory->createItem('work_study_circles.register', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-file-text-o',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.register.main', $section)));

            if (!$user->getWorkStudyCircle()) {
                $workStudyCirclesRegisterPhaseOne = $this->factory->createItem('work_study_circles.register.phase_one', $this->getSubLevelOptions(array(
                                    "route" => "pequiven_work_study_circle_create",
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.register.phase_one', $section)));

                $workStudyCirclesRegister->addChild($workStudyCirclesRegisterPhaseOne);
            }

            $menuWorkStudyCircles->addChild($workStudyCirclesRegister);
        }
//        if ($this->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_VIEW')) && $user->getWorkStudyCircle()) {
        if (($workStudyCircle = $workStudyCircleService->obtainWorkStudyCircleByPhase($user, \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE)) != null) {
            $workStudyCirclesVizualice = $this->factory->createItem('work_study_circles.vizualice', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-users',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.vizualice.main', $section)));

            if ($user->getWorkStudyCircle()) {
                $idWorkStudyCircle = $user->getWorkStudyCircle()->getId();
                $workStudyCirclesPhaseOne = $this->factory->createItem('work_study_circles.vizualice.phase_one', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_work_study_circle_show',
                                    'routeParameters' => array('id' => $idWorkStudyCircle),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.vizualice.phase_one', $section)));
                $workStudyCirclesVizualice->addChild($workStudyCirclesPhaseOne);
            }

            if (($workStudyCircle = $workStudyCircleService->obtainWorkStudyCircleByPhase($user, \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_TWO)) != null) {
                $workStudyCirclesPhaseTwo = $this->factory->createItem('work_study_circles.vizualice.phase_two', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_work_study_circle_show_phase',
                                    'routeParameters' => array('id' => $workStudyCircle->getId()),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.vizualice.phase_two', $section)));
                $workStudyCirclesVizualice->addChild($workStudyCirclesPhaseTwo);
            }

            if (($workStudyCircle = $workStudyCircleService->obtainWorkStudyCircleByPhase($user, \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_THREE)) != null) {
                $workStudyCirclesPhaseThree = $this->factory->createItem('work_study_circles.vizualice.phase_three', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_work_study_circle_show_phase',
                                    'routeParameters' => array('id' => $workStudyCircle->getId()),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.vizualice.phase_three', $section)));
                $workStudyCirclesVizualice->addChild($workStudyCirclesPhaseThree);
            }

            if (($workStudyCircle = $workStudyCircleService->obtainWorkStudyCircleByPhase($user, \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_FOUR)) != null) {
                $workStudyCirclesPhaseFour = $this->factory->createItem('work_study_circles.vizualice.phase_four', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_work_study_circle_show_phase',
                                    'routeParameters' => array('id' => $workStudyCircle->getId()),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.vizualice.phase_four', $section)));
                $workStudyCirclesVizualice->addChild($workStudyCirclesPhaseFour);
            }

            $menuWorkStudyCircles->addChild($workStudyCirclesVizualice);
        }
        // REPORTES DE CET
        if ($this->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_VIEW_REPORT'))) {
            $workStudyCirclesReports = $this->factory->createItem('work_study_circles.reports', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.reports.main', $section)));

            $periodActive = $this->getPeriodService()->getPeriodActive();

            //FASE 1
            $reportsPhaseOne = $this->factory->createItem('work_study_circles.reports.phase_one', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.reports.phase_one', $section)));

            $reportsPhaseOneList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_work_study_circle_list',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
            $reportsPhaseOne->addChild($reportsPhaseOneList);

            $reportsPhaseOneGeneral = $this->factory->createItem('work_study_circles.general', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_work_study_circle_general',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.general', $section)));
            $reportsPhaseOne->addChild($reportsPhaseOneGeneral);

            $workStudyCirclesReports->addChild($reportsPhaseOne);

            if ($periodActive->getName() == "2015") {
                //FASE 2
                $reportsPhaseTwo = $this->factory->createItem('work_study_circles.reports.phase_two', $this->getSubLevelOptions(array(
                                    "route" => "",
                                    'labelAttributes' => array('icon' => 'fa fa-table',),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.reports.phase_two', $section)));

                $reportsPhaseTwoList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_work_study_circle_list',
                                    'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_TWO),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
                $reportsPhaseTwo->addChild($reportsPhaseTwoList);

                $workStudyCirclesReports->addChild($reportsPhaseTwo);

                //FASE 3
                $reportsPhaseThree = $this->factory->createItem('work_study_circles.reports.phase_three', $this->getSubLevelOptions(array(
                                    "route" => "",
                                    'labelAttributes' => array('icon' => 'fa fa-table',),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.reports.phase_three', $section)));

                $reportsPhaseThreeList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_work_study_circle_list',
                                    'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_THREE),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
                $reportsPhaseThree->addChild($reportsPhaseThreeList);

                $workStudyCirclesReports->addChild($reportsPhaseThree);


                //FASE 4
                $reportsPhaseFour = $this->factory->createItem('work_study_circles.reports.phase_four', $this->getSubLevelOptions(array(
                                    "route" => "",
                                    'labelAttributes' => array('icon' => 'fa fa-table',),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.reports.phase_four', $section)));

                $reportsPhaseFourList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_work_study_circle_list',
                                    'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_FOUR),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
                $reportsPhaseFour->addChild($reportsPhaseFourList);

                $workStudyCirclesReports->addChild($reportsPhaseFour);
            }

            $menuWorkStudyCircles->addChild($workStudyCirclesReports);
        }
        //Navegación Reuniones
        if ($this->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_MEETING'))) {
            $workStudyCirclesMeeting = $this->factory->createItem('work_study_circles.meeting', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-pencil-square-o',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.meeting', $section)));

            $periodActive = $this->getPeriodService()->getPeriodActive();

            //FASE 1
            $meetingsPhaseOne = $this->factory->createItem('work_study_circles.meeting.phase_one', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.phase_one', $section)));

            $meetingsPhaseOneList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_meeting_list',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
            $meetingsPhaseOne->addChild($meetingsPhaseOneList);

            $meetingsPhaseOneGeneral = $this->factory->createItem('work_study_circles.general', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_meeting_view',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.general', $section)));
            $meetingsPhaseOne->addChild($meetingsPhaseOneGeneral);

            $workStudyCirclesMeeting->addChild($meetingsPhaseOne);

            if ($periodActive->getName() == "2015") {
                //FASE 2
                $meetingsPhaseTwo = $this->factory->createItem('work_study_circles.meeting.phase_two', $this->getSubLevelOptions(array(
                                    "route" => "",
                                    'labelAttributes' => array('icon' => 'fa fa-table',),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.phase_two', $section)));

                $meetingsPhaseTwoList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_meeting_list',
                                    'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_TWO),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
                $meetingsPhaseTwo->addChild($meetingsPhaseTwoList);

                $workStudyCirclesMeeting->addChild($meetingsPhaseTwo);
                //FASE 3
                $meetingsPhaseThree = $this->factory->createItem('work_study_circles.meeting.phase_three', $this->getSubLevelOptions(array(
                                    "route" => "",
                                    'labelAttributes' => array('icon' => 'fa fa-table',),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.phase_three', $section)));

                $meetingsPhaseThreeList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_meeting_list',
                                    'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_THREE),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
                $meetingsPhaseThree->addChild($meetingsPhaseThreeList);

                $workStudyCirclesMeeting->addChild($meetingsPhaseThree);

                //FASE 4
                $meetingsPhaseFour = $this->factory->createItem('work_study_circles.meeting.phase_four', $this->getSubLevelOptions(array(
                                    "route" => "",
                                    'labelAttributes' => array('icon' => 'fa fa-table',),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.phase_four', $section)));

                $meetingsPhaseFourList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                    'route' => 'pequiven_meeting_list',
                                    'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_FOUR),
                                ))
                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
                $meetingsPhaseFour->addChild($meetingsPhaseFourList);

                $workStudyCirclesMeeting->addChild($meetingsPhaseFour);
            }

            $menuWorkStudyCircles->addChild($workStudyCirclesMeeting);
        }
        if ($this->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_STRATEGIC_PLAN'))) {
            $workStudyCirclesStrategicPlan = $this->factory->createItem('work_study_circles.strategic_plan', $this->getSubLevelOptions(array(
                                'route' => '',
                                'labelAttributes' => array('icon' => 'fa fa-bars',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.strategic_plan.main', $section)));

            //FASE 1
            $proposalsPhaseOne = $this->factory->createItem('work_study_circles.strategic_plan.phase_one', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.phase_one', $section)));

            $proposalsPhaseOneList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_proposal_list',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
            $proposalsPhaseOne->addChild($proposalsPhaseOneList);

            $proposalsPhaseOneGeneral = $this->factory->createItem('work_study_circles.general', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_proposal_show_general',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_ONE),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.general', $section)));
            $proposalsPhaseOne->addChild($proposalsPhaseOneGeneral);

            $workStudyCirclesStrategicPlan->addChild($proposalsPhaseOne);

            //FASE 2
            $proposalsPhaseTwo = $this->factory->createItem('work_study_circles.strategic_plan.phase_two', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.phase_two', $section)));

            $proposalsPhaseTwoList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_proposal_list',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_TWO),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
            $proposalsPhaseTwo->addChild($proposalsPhaseTwoList);

            $workStudyCirclesStrategicPlan->addChild($proposalsPhaseTwo);

            //FASE 3
            $proposalsPhaseThree = $this->factory->createItem('work_study_circles.strategic_plan.phase_three', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.phase_three', $section)));

            $proposalsPhaseThreeList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_proposal_list',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_THREE),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
            $proposalsPhaseThree->addChild($proposalsPhaseThreeList);

            $workStudyCirclesStrategicPlan->addChild($proposalsPhaseThree);

            //FASE 4
            $proposalsPhaseFour = $this->factory->createItem('work_study_circles.strategic_plan.phase_four', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.phase_four', $section)));

            $proposalsPhaseFourList = $this->factory->createItem('work_study_circles.list', $this->getSubLevelOptions(array(
                                'route' => 'pequiven_proposal_list',
                                'routeParameters' => array('phase' => \Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle::PHASE_FOUR),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
            $proposalsPhaseFour->addChild($proposalsPhaseFourList);

            $workStudyCirclesStrategicPlan->addChild($proposalsPhaseFour);

            $menuWorkStudyCircles->addChild($workStudyCirclesStrategicPlan);
        }

        if ($this->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_DOCUMENTS_*'))) {
            $workStudyCirclesStrategicPlan = $this->factory->createItem('work_study_circles.documents', $this->getSubLevelOptions(array(
                                'route' => '',
                                'labelAttributes' => array('icon' => 'fa fa-file-pdf-o',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.documents', $section)));

            if ($this->isGranted(array('ROLE_SEIP_WORK_STUDY_CIRCLES_DOCUMENTS_LIST'))) {
                $workStudyCirclesStrategicPlan->addChild('work_study_circles.list', array(
                            'route' => 'pequiven_work_study_circle_document_list',
                        ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.list', $section)));
            }


            $workStudyCirclesStrategicPlan->addChild('work_study_circles.general', array(
                        'route' => 'pequiven_work_study_circle_document_general',
                    ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.work_study_circles.general', $section)));


            $menuWorkStudyCircles->addChild($workStudyCirclesStrategicPlan);
        }

        $menu->addChild($menuWorkStudyCircles);
    }

    /**
     * 
     * Menu se SIP
     * 
     * @param ItemInterface $menu
     * @param type $section
     */
    public function addMenuSip(ItemInterface $menu, $section) {
        $user = $this->getUser();
//        $workStudyCircleService = $this->getWorkStudyCircleService();

        $menuSip = $this->factory->createItem('menu_sip', $this->getSubLevelOptions(array(
                            'uri' => null,
                            'labelAttributes' => array('icon' => 'fa fa-ticket'),
                        ))
                )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.main', $section)));


        if ($this->isGranted(array('ROLE_SEIP_SIP_SEACH_EMPLOYEES')) && ($user->getId() == 112 || $user->getId() == 22 || $user->getId() == 1668 || $user->getId() == 70 || $user->getId() == 1640 || $user->getId() == 96 || $user->getId() == 79)) {
            $menuSip->addChild('sip.list_pqv', array(
                'route' => 'pequiven_onePerTen_list',
                'labelAttributes' => array('icon' => 'fa fa-table',)
            ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list_pqv', $section)));
        }

        if ($this->isGranted(array('ROLE_SEIP_SIP_CENTRO'))) {
            //Centro
            $centro = $this->factory->createItem('sip.centro', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-building',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.centros', $section)));
            //Sub menu
            $centroMenu = $this->factory->createItem('sip.list', $this->getSubLevelOptions(array(
                                "route" => "pequiven_sip_center_list",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list', $section)));

            $centro->addChild($centroMenu);

            $menuSip->addChild($centro);
        }

//        if ($this->isGranted(array('ROLE_SEIP_SIP_ONEPERTEN'))) {
//            $onePerTen = $this->factory->createItem('onePerTen', $this->getSubLevelOptions(array(
//                                'uri' => null,
//                                'labelAttributes' => array('icon' => 'fa fa-ticket'),
//                            ))
//                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.onePerTen', $section)));
//            $register = $this->factory->createItem('RegisterOnePerTen', $this->getSubLevelOptions(array(
//                                'route' => 'pequiven_search_members',
//                            ))
//                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.register', $section)));
//
//            $onePerTen->addChild($register);
//            if ($this->isGranted(array('ROLE_SEIP_SIP_ONEPERTEN_LIST'))) {
//                $list = $this->factory->createItem('listOnePerTen', $this->getSubLevelOptions(array(
//                                    'route' => 'pequiven_onePerTen_list',
//                                ))
//                        )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list', $section)));
//                $onePerTen->addChild($list);
//            }
//            $menuSip->addChild($onePerTen);
//        }

        if ($this->isGranted(array('ROLE_SEIP_SIP_CUTL'))) {
            //CUTL
            $cutl = $this->factory->createItem('sip.cutl', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-user',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.cutl', $section)));
            //Sub menu
            $cutlMenu = $this->factory->createItem('sip.list', $this->getSubLevelOptions(array(
                                "route" => "pequiven_sip_cutl_list",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list', $section)));

            $cutl->addChild($cutlMenu);

            $menuSip->addChild($cutl);
        }

        if ($this->isGranted(array('ROLE_SEIP_SIP_REQ'))) {
            //Requerimientos
            $request = $this->factory->createItem('sip.request', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-user',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.request', $section)));
            //Sub menu
            $requestMenu = $this->factory->createItem('sip.list', $this->getSubLevelOptions(array(
                                "route" => "pequiven_sip_request_list",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list_request', $section)));

            $request->addChild($requestMenu);
            //Inventario
            $requestMenu = $this->factory->createItem('sip.list_inventory', $this->getSubLevelOptions(array(
                                "route" => "pequiven_sip_request_list_inventory",
                                'labelAttributes' => array('icon' => 'fa fa-table',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list_inventory', $section)));

            $request->addChild($requestMenu);

            $menuSip->addChild($request);
        }

        if ($this->isGranted(array('ROLE_SEIP_SIP_REPORTS'))) {
            //REPORTES
            $report = $this->factory->createItem('sip.report', $this->getSubLevelOptions(array(
                                "route" => "pequiven_sip_report",
                                'labelAttributes' => array('icon' => 'fa fa-file-excel-o',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.report', $section)));
            $menuSip->addChild($report);
        }

        if ($this->isGranted(array('ROLE_SEIP_SIP_REGISTER_VOTE'))) {
            //Voto
            $voto = $this->factory->createItem('sip.voto', $this->getSubLevelOptions(array(
                                "route" => "pequiven_sip_report_voto",
                                'labelAttributes' => array('icon' => 'fa fa-pencil-square-o',),
                            ))
                    )->setLabel($this->translate(sprintf('6D - Reporte Voto', $section)));
            $menuSip->addChild($voto);
        }

        if ($this->isGranted(array('ROLE_SEIP_SIP_MONITOR_*'))) {
            //
            $display = $this->factory->createItem('sip.display', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => 'fa fa-desktop',),
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.display', $section)));

            //Sub menu Voto
            $displayMenu = $this->factory->createItem('sip.voto', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => '',)
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.voto', $section)));


            //Menu 3 nivel Voto
            if ($this->isGranted(array('ROLE_SEIP_SIP_MONITOR_GENERAL'))) {
                $displayMenu->addChild('sip.voto_general', array(
                    'route' => 'pequiven_sip_display_voto_general',
                    'labelAttributes' => array('icon' => 'fa fa-bar-chart',)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.voto_general', $section)));
            }

            if ($this->isGranted(array('ROLE_SEIP_SIP_MONITOR_PQV'))) {
                $displayMenu->addChild('sip.voto_pqv', array(
                    'route' => 'pequiven_sip_display_voto_pqv',
                    'labelAttributes' => array('icon' => 'fa fa-bar-chart',)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.voto_pqv', $section)));
            }

            if ($this->isGranted(array('ROLE_SEIP_SIP_MONITOR_1X10'))) {
                $displayMenu->addChild('sip.voto_1x10', array(
                    'route' => 'pequiven_sip_display_voto_1x10',
                    'labelAttributes' => array('icon' => 'fa fa-bar-chart',)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.voto_1x10', $section)));
            }

            if ($this->isGranted(array('ROLE_SEIP_SIP_MONITOR_ONLY_CIRCUITO5'))) {
                $displayMenu->addChild('sip.voto_circuito', array(
                    'route' => 'pequiven_sip_display_voto_circuito_5',
                    'labelAttributes' => array('icon' => 'fa fa-bar-chart',)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.voto_circuito', $section)));
            }

//            if ($this->isGranted(array('ROLE_SEIP_SIP_MONITOR_CET'))) {
//                $displayMenu->addChild('sip.voto_cet', array(
//                        'route' => '',
//                        'labelAttributes' => array('icon' => 'fa fa-bar-chart',)
//                    ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.voto_cet', $section)));
//            }

            if ($this->isGranted(array('ROLE_SEIP_SIP_MONITOR_ONLY_ZULIA'))) {
                $displayMenu->addChild('sip.voto_zulia', array(
                    'route' => 'pequiven_sip_display_voto_general_estado',
                    'routeParameters' => array('type' => 1, 'edo' => 21),
                    'labelAttributes' => array('icon' => 'fa fa-bar-chart',)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.voto_zulia', $section)));
            }

            if ($this->isGranted(array('ROLE_SEIP_SIP_MONITOR_ONLY_ANZOATEGUI'))) {
                $displayMenu->addChild('sip.voto_anzoategui', array(
                    'route' => 'pequiven_sip_display_voto_general_estado',
                    'routeParameters' => array('type' => 1, 'edo' => 2),
                    'labelAttributes' => array('icon' => 'fa fa-bar-chart',)
                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.voto_anzoategui', $section)));
            }

            $display->addChild($displayMenu);

            //Sub menu Voto
            $displayList = $this->factory->createItem('sip.list', $this->getSubLevelOptions(array(
                                "route" => "",
                                'labelAttributes' => array('icon' => '',)
                            ))
                    )->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list_seg', $section)));

//            $displayList->addChild('sip.list_pqv', array(
//                    'route' => 'pequiven_sip_display_voto_pqv',
//                    'labelAttributes' => array('icon' => 'fa fa-list',)
//                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list_pqv', $section)));
//            
//            $displayList->addChild('sip.list_1x10', array(
//                    'route' => '',
//                    'labelAttributes' => array('icon' => 'fa fa-list',)
//                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list_1x10', $section)));
//
//            $displayList->addChild('sip.list_circuito', array(
//                    'route' => '',
//                    'labelAttributes' => array('icon' => 'fa fa-list',)
//                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list_circuito', $section)));
//
//            $displayList->addChild('sip.list_cet', array(
//                    'route' => '',
//                    'labelAttributes' => array('icon' => 'fa fa-list',)
//                ))->setLabel($this->translate(sprintf('app.backend.menu.%s.sip.list_cet', $section)));

            $display->addChild($displayList);

            $menuSip->addChild($display);
        }

        $menu->addChild($menuSip);
    }

    /**
     * CONSTRUYE EL MENU DE EMPLEADOS PARA LA ESTRUCTURA DE CARGOS
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuUsuarios(ItemInterface $menu, $section) {

        $child = $this->factory->createItem('usuarios', $this->getSubLevelOptions(array(
                            'uri' => null,
                            'labelAttributes' => array('icon' => 'fa fa-user',),
                        ))
                )
                ->setLabel($this->translate(sprintf('Empleados', $section)));

        $child->addChild('planning.visualize.users.feestructure', array(
                    'route' => 'pequiven_user_feestructure',
                    'labelAttributes' => array('icon' => 'fa fa-sitemap'),
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.users.feeStructure', $section)));

        $menu->addChild($child);
    }

    /**
     * Modulos en Construcción
     * @param ItemInterface $menu
     * @param type $section
     */
    private function addMenuModules(ItemInterface $menu, $section) {

        $child = $this->factory->createItem('Modulos en Construcción', $this->getSubLevelOptions(array(
                            'uri' => null,
                            'labelAttributes' => array('icon' => 'fa fa-exclamation-triangle',),
                        ))
                )
                ->setLabel($this->translate(sprintf('Modulos en Construcción', $section)));

        $child->addChild('planning.visualize.modules.ventas', array(
                    'route' => 'pequiven_seip_modules_ventas',
                    'labelAttributes' => array('icon' => ''),
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.modules.ventas', $section)));

        $child->addChild('planning.visualize.modules.despachos', array(
                    'route' => 'pequiven_seip_modules_despacho',
                    'labelAttributes' => array('icon' => ''),
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.modules.despachos', $section)));

        $child->addChild('planning.visualize.modules.contrataciones', array(
                    'route' => 'pequiven_seip_modules_contrataciones',
                    'labelAttributes' => array('icon' => ''),
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.modules.contrataciones', $section)));

        $child->addChild('planning.visualize.modules.proyectos', array(
                    'route' => 'pequiven_seip_modules_proyectos',
                    'labelAttributes' => array('icon' => ''),
                ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.modules.proyectos', $section)));

        $menu->addChild($child);
    }

    /**
     * Construye el menu de ejemplo
     * 
     * @param \Knp\Menu\ItemInterface $menu
     * @param type $section
     */
    function addExampleMenu(ItemInterface $menu, $section) {
        $child = $this->factory->createItem('example', $this->getSubLevelOptions(array(
                            'uri'
                            => null,
                            'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.main', $section)));
        $child
                ->addChild('example.company', array(
                    'route' => null,))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.company', $section)));
        $child
                ->addChild('example.technical_reports', array(
                    'route' => null,))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.technical_reports', $section)));


        $subchild = $this->factory->createItem('subexample', $this->getSubLevelOptions(array('uri' => null,
                            'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.other.main', $section)));
        $subchild
                ->addChild('example.other.admin', array(
                    'route' => null,))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.other.admin', $section)));

        $subchild->addChild('example.other.groups', array(
                    'route' => null,))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.other.groups', $section)));

        $child->addChild($subchild);

        $menu->addChild($child);
    }

    protected function getSubLevelOptions(array $parameters = array()) {
        return array_merge($this->secondLevelOptions, $parameters);
    }

    protected function getSecondLevelOptions(array $parameters = array()) {
        return array_merge($this->secondLevelOptions, $parameters);
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

    protected function trans($id, array $parameters = array(), $domain = 'messages') {
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
    public function getUser() {
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
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\Politic\WorkStudyCircleService
     */
    protected function getWorkStudyCircleService() {
        return $this->container->get('seip.service.workStudyCircle');
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\Configuration
     */
    private function getSeipConfiguration() {
        return $this->container->get('seip.configuration');
    }

    private function isGranted($roles, $object = null) {
        return $this->securityContext->isGranted($roles, $object);
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
