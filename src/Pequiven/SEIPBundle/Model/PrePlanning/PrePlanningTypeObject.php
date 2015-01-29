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
 * Description of PrePlanningTypeObject
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class PrePlanningTypeObject implements TypePrePlanningInterface
{
    public static function getTypeObjectRepository($typeObject) 
    {
        $typeObjectsRepository = self::getTypeObjectsRepository();
        if(!isset($typeObjectsRepository[$typeObject])){
            throw new \InvalidArgumentException(sprintf('The type object repository "%s", is not defined for prePlanning',$typeObject));
        }
        return $typeObjectsRepository[$typeObject];
    }
    
    /**
     * Devuelve los repositorios de los tipos de objetos que se pueden importar
     * 
     * @return array
     */
    public static function getTypeObjectsRepository()
    {
        return array(
            self::TYPE_OBJECT_OBJETIVE => 'Pequiven\\ObjetiveBundle\\Repository\\ObjetiveRepository',
            self::TYPE_OBJECT_ARRANGEMENT_PROGRAM => 'Pequiven\ArrangementProgramBundle\Repository\ArrangementProgramRepository',
            self::TYPE_OBJECT_INDICATOR => 'Pequiven\IndicatorBundle\Repository\IndicatorRepository',
            self::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL => 'Pequiven\ArrangementProgramBundle\Repository\GoalRepository',
        );
    }
    
    /**
     * Devuelve los tipos de objetos que se pueden importar
     * 
     * @return array
     */
    public static function getTypeObjects()
    {
        return array(
            self::TYPE_OBJECT_OBJETIVE => 'Pequiven\ObjetiveBundle\Entity\Objetive',
            self::TYPE_OBJECT_ARRANGEMENT_PROGRAM => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram',
            self::TYPE_OBJECT_INDICATOR => 'Pequiven\IndicatorBundle\Entity\Indicator',
            self::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL => 'Pequiven\ArrangementProgramBundle\Entity\Goal',
            self::TYPE_OBJECT_RESULT => 'Pequiven\SEIPBundle\Entity\Result\Result',
        );
    }
    
    public static function getTypeObjectOf($typeObject) {
        $typeObjectsRepository = self::getTypeObjects();
        if(!isset($typeObjectsRepository[$typeObject])){
            throw new \InvalidArgumentException(sprintf('The type object "%s", is not defined for prePlanning',$typeObject));
        }
        return $typeObjectsRepository[$typeObject];
    }
    
    public static function getTypeByClass($className)
    {
        $typeObjectsRepository = self::getTypeObjects();
        $typeObject = array_search($className, $typeObjectsRepository);
        if($typeObject === false){
            throw new \Exception(sprintf('The type object for class "%s" is not defined',$className));
        }
        return $typeObject;
    }
}
