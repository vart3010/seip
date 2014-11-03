<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\TemplateBundle\Menu\Template\Developer;

use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Tecnocreaciones\Vzla\GovernmentBundle\Menu\MenuBuilder;

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
    
    const ROUTE_DEFAULT = '';
    
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
            'route' => '',//Route
            'labelAttributes' => array('icon' => 'icon-home'),
        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.home', $section)));
        
        $this->addExampleMenu($menu, $section);
        
        $menu->addChild('support', array(
            'route' => self::ROUTE_DEFAULT,
            'labelAttributes' => array('icon' => 'icon-info'),
        ))->setLabel($this->translate(sprintf('app.backend.menu.%s.support', $section)));
        
        $this->addArrangementMenu($menu, $section);//Menú de Gestión
        return $menu;
    }
    
    /**
     * Construye el menu de Gestión
     * 
     * @param \Knp\Menu\ItemInterface $menu
     * @param type $section
     */
    
    function addArrangementMenu(ItemInterface $menu, $section) {
        $child = $this->factory->createItem('arrangement',
                $this->getSubLevelOptions(array(
                    'uri' => null,
                    'labelAttributes' => array('icon' => 'icon-book',),
                ))
                )
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.main', $section)));

            //Sub menú Objetivos
//        $child
//                ->addChild('arrangement.objetives', array(
//                    'route' => '',
//                    ))
//                ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.objetives', $section)));
        
                $subchild = $this->factory->createItem('arrangement.objetives',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.objetives.main', $section)));
                $subchild
                        ->addChild('arrangement.objetives.list', array(
                            'route' => self::ROUTE_DEFAULT,
                            ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.objetives.list', $section)));
            $child->addChild($subchild);
            
            //Sub menú Indicadores
                $subchild = $this->factory->createItem('arrangement.indicators',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.indicators.main', $section)));
                $subchild
                        ->addChild('arrangement.objetives.list', array(
                            'route' => self::ROUTE_DEFAULT,
                            ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.indicators.list', $section)));
            $child->addChild($subchild);
            
            //Sub menú Programas de Gestión
                $subchild = $this->factory->createItem('arrangement.arrangement_programs',
                        $this->getSubLevelOptions(array(
                        'uri' => null,
                        'labelAttributes' => array('icon' => 'icon-book',),
                        ))
                    )
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.arrangement_programs.main', $section)));
                $subchild
                        ->addChild('arrangement.objetives.list', array(
                            'route' => self::ROUTE_DEFAULT,
                            ))
                        ->setLabel($this->translate(sprintf('app.backend.menu.%s.arrangement.arrangement_programs.list', $section)));
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
                    'route' => '',
                    ))
                ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.company', $section)));
        $child
                ->addChild('example.technical_reports', array(
                    'route' => '',
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
                        'route' => self::ROUTE_DEFAULT,
                        ))
                    ->setLabel($this->translate(sprintf('app.backend.menu.%s.example.other.admin', $section)));

            $subchild->addChild('example.other.groups', array(
                        'route' => self::ROUTE_DEFAULT,
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
}
