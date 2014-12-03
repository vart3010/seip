<?php

namespace Pequiven\SEIPBundle\Service;

/**
 * Generador de links de objetos
 * 
 * @service seip.service.link_generator
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class LinkGeneratorService extends LinkGenerator
{
    static function getConfigObjects()
    {
        return array(
            array('class' => 'Pequiven\IndicatorBundle\Entity\Indicator','icon' => 'fa fa-line-chart','route' => 'pequiven_indicator_show'),
            array('class' => 'Pequiven\ObjetiveBundle\Entity\Objetive','icon' => 'fa fa-cogs','method' => 'renderObjetive'),
            array('class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram','icon' => 'fa fa-tasks','route' => 'pequiven_seip_arrangementprogram_show'),
        );
    }
    
    function renderObjetive(\Pequiven\ObjetiveBundle\Entity\Objetive $entity,$entityConfig,$type = self::TYPE_LINK_DEFAULT) 
    {
        $levelRoute = array(
            \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO => 'objetiveStrategic_show',
            \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO => 'objetiveTactic_show',
            \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO => 'objetiveOperative_show',
        );
        $levelIcon = array(
            \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO => 'fa fa-cubes',
            \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO => 'fa fa-cube',
            \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_OPERATIVO => 'fa fa-cog',
        );
        $level = $entity->getObjetiveLevel()->getLevel();
        $route = $levelRoute[$level];
        $icon = $levelIcon[$level];
        $entityConfig['route'] = $route;
        $entityConfig['icon'] = $icon;
        
        return $this->renderDefault($entity, $entityConfig,$type);
    }
}