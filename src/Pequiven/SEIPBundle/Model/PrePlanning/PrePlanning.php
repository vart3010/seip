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
     * Estatus borrador
     */
    const STATUS_DRAFT = 0;
    
    /**
     * Estatus aprobado
     */
    const STATUS_APPROVED = 1;
    
    /**
     * Parametros de la pre planificacion
     * @var type 
     */
    protected $parameters;
    
    public function setOriginObject($object)
    {
        $idObject = $object->getId();
        $class = \Doctrine\Common\Util\ClassUtils::getRealClass(get_class($object));
        if($class == 'Pequiven\ObjetiveBundle\Entity\Objetive'){
            $typeObject = self::TYPE_OBJECT_OBJETIVE;
            if($object->getObjetiveLevel()->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO){
                $this->setRequiresApproval(true);
            }
        }else if($class == 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram'){
            $typeObject = self::TYPE_OBJECT_ARRANGEMENT_PROGRAM;
        }else if($class == 'Pequiven\IndicatorBundle\Entity\Indicator'){
            $typeObject = self::TYPE_OBJECT_INDICATOR;
        }else if($class == 'Pequiven\ArrangementProgramBundle\Entity\Goal'){
            $typeObject = self::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL;
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
    
    function getParameter($name,$default = null)
    {
        $parameters = $this->getParameters();
        if(isset($parameters[$name])){
            return $parameters[$name];
        }
        return $default;
    }
    
    function setParameter($key,$value) {
        $this->parameters[$key] = $value;
    }
}
