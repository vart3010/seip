<?php

namespace Pequiven\SEIPBundle\Service;

use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Generador de links de objetos
 * 
 * @service seip.service.link_generator
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class LinkGeneratorService extends LinkGenerator
{
    /**
     * Tipo de link por defecto o categoria (Se usa para crear links diferentes del mismo objeto)
     */
    const TYPE_LINK_OBJETIVE_RESULT = 1;
    
    static function getConfigObjects()
    {
        return array(
            array('class' => 'Pequiven\IndicatorBundle\Entity\Indicator','icon' => 'fa fa-line-chart','route' => 'pequiven_indicator_show'),
            array('class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram','icon' => 'fa fa-tasks','route' => 'pequiven_seip_arrangementprogram_show'),
            array('class' => 'Pequiven\ObjetiveBundle\Entity\Objetive','icon' => 'fa fa-cogs','method' => 'renderObjetive'),
            array('class' => 'Pequiven\ObjetiveBundle\Entity\Objetive','icon' => 'fa fa-cogs','method' => 'renderObjetiveResult','type' => self::TYPE_LINK_OBJETIVE_RESULT),
        );
    }
    
    /**
     * Genera los links por defecto de los objetivos
     * @param Objetive $entity
     * @param type $entityConfig
     * @param type $type
     * @return type
     */
    function renderObjetive(Objetive $entity,$entityConfig,$type = self::TYPE_LINK_DEFAULT,array $parameters = array()) 
    {
        $levelRoute = array(
            ObjetiveLevel::LEVEL_ESTRATEGICO => 'objetiveStrategic_show',
            ObjetiveLevel::LEVEL_TACTICO => 'objetiveTactic_show',
            ObjetiveLevel::LEVEL_OPERATIVO => 'objetiveOperative_show',
        );
        $levelIcon = array(
            ObjetiveLevel::LEVEL_ESTRATEGICO => 'fa fa-cubes',
            ObjetiveLevel::LEVEL_TACTICO => 'fa fa-cube',
            ObjetiveLevel::LEVEL_OPERATIVO => 'fa fa-cog',
        );
        $level = $entity->getObjetiveLevel()->getLevel();
        $route = $levelRoute[$level];
        $icon = $levelIcon[$level];
        $entityConfig['route'] = $route;
        $entityConfig['icon'] = $icon;
        
        return $this->renderDefault($entity, $entityConfig,$type,$parameters);
    }
    /**
     * Genera los links por defecto de los objetivos
     * @param Objetive $entity
     * @param type $entityConfig
     * @param type $type
     * @return type
     */
    function renderObjetiveResult(Objetive $entity,$entityConfig,$type = self::TYPE_LINK_DEFAULT,array $parameters = array()) 
    {
        $levelRoute = array(
            ObjetiveLevel::LEVEL_ESTRATEGICO => 'objetiveStrategic_show',
            ObjetiveLevel::LEVEL_TACTICO => 'objetiveTactic_show',
            ObjetiveLevel::LEVEL_OPERATIVO => 'objetiveOperative_show',
        );
        $levelIcon = array(
            ObjetiveLevel::LEVEL_ESTRATEGICO => 'fa fa-cubes',
            ObjetiveLevel::LEVEL_TACTICO => 'fa fa-cube',
            ObjetiveLevel::LEVEL_OPERATIVO => 'fa fa-cog',
        );
        $level = $entity->getObjetiveLevel()->getLevel();
        $route = $levelRoute[$level];
        $icon = $levelIcon[$level];
        $entityConfig['route'] = $route;
        $entityConfig['icon'] = $icon;
        
        $levelRequest = $parameters['level'];
        $routeParameters = array();
        $routeResult = 'pequiven_seip_result_visualize_gerencia';
        $route = null;
        if($levelRequest == CommonObject::LEVEL_GERENCIA){
            if($level == ObjetiveLevel::LEVEL_OPERATIVO){
                $route = $routeResult;
                $routeParameters = array(
                    'level' => CommonObject::LEVEL_GERENCIA_SECOND,
                    'id' => $entity->getGerenciaSecond()->getId(),
                );
            }
        }elseif($levelRequest == CommonObject::LEVEL_GERENCIA_SECOND){
            if($level == ObjetiveLevel::LEVEL_TACTICO){
                $route = $routeResult;
                $routeParameters = array(
                    'level' => CommonObject::LEVEL_GERENCIA,
                    'id' => $entity->getGerencia()->getId(),
                );
            }
        }
        
        $entityConfig['route'] = $route;
        $entityConfig['routeParameters'] = $routeParameters;
        return $this->renderDefault($entity, $entityConfig,$type,$parameters);
    }
}