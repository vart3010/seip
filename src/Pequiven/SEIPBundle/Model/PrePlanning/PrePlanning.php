<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model\PrePlanning;

/**
 * Modelo de pre-planificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class PrePlanning  implements PrePlanningInterface
{
    private $originObject;

    /**
     * Nombre para el nodo root.
     */
    const DEFAULT_NAME = 'ROOT-NODE';
    
    /**
     * Tipo objetivo
     */
    const TYPE_OBJECT_ROOT_NODE = 0;
    
    /**
     * Tipo objetivo
     */
    const TYPE_OBJECT_OBJETIVE = 1;
    /**
     * Tipo programa de gestion
     */
    const TYPE_OBJECT_ARRANGEMENT_PROGRAM = 2;
    /**
     * Tipo indicador
     */
    const TYPE_OBJECT_INDICATOR = 3;
    
    /**
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;
    
    protected $parameters;
    
    public function setOriginObject($object)
    {
        $idObject = $object->getId();
        $class = \Doctrine\Common\Util\ClassUtils::getRealClass(get_class($object));
        if($class == 'Pequiven\ObjetiveBundle\Entity\Objetive'){
            $typeObject = self::TYPE_OBJECT_OBJETIVE;
        }else if($class == 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram'){
            $typeObject = self::TYPE_OBJECT_ARRANGEMENT_PROGRAM;
        }else if($class == 'Pequiven\IndicatorBundle\Entity\Indicator'){
            $typeObject = self::TYPE_OBJECT_INDICATOR;
        }else {
            throw new \InvalidArgumentException(sprintf('The object class "%s" is not admited',$class));
        }
        $this->setName((string)$object);
        $this->setTypeObject($typeObject);
        $this->setIdObject($idObject);
        $this->originObject = $object;
//        var_dump($class);
    }
    function getOriginObject() {
        return $this->originObject;
    }
    
    function getParameter($name)
    {
        $parameters = $this->getParameters();
        if(isset($parameters[$name])){
            return $parameters[$name];
        }
        return null;
    }
    
    function setParameter($key,$value) {
        $this->parameters[$key] = $value;
    }
}
