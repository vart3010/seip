<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Pequiven\ArrangementBundle\Entity\ArrangementRange;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning;
use Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone;
use Pequiven\SEIPBundle\Entity\Result\Result;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Util\ClassUtils;
use LogicException;
use Exception;

/**
 * Servicio para clonar objetos (seip.service.clone)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class CloneService extends ContainerAware
{
    private $cacheObject;
    
    public function cloneItem($object) 
    {
        $user = $this->getUser();
        
        $className = ClassUtils::getRealClass(get_class($object));
        $idSourceObject = $object->getId();
        
        $prePlanningItemClone = new PrePlanningItemClone();
        $prePlanningItemClone->setUser($user);
        $prePlanningItemClone->setIdSourceObject($idSourceObject);
        
        $type = PrePlanningItemClone::getTypeByClass($className);
        
        $entity = null;
        switch ($type):
            case PrePlanningItemClone::TYPE_OBJECT_OBJETIVE:
                $entity = $this->cloneObject($object);
                break;
            default :
                throw new Exception(sprintf('No se puede clonar este objeto "%s"',$className));
        endswitch;
        
        return $entity;
    }
    
    public function findItemInstance($idSourceObject,$typeObject) 
    {
        $em = $this->getDoctrine()->getManager();
        
        $typeObjectRepository = PrePlanning::getTypeObjectOf($typeObject);
        $entityToClone = $em->getRepository($typeObjectRepository)->find($idSourceObject);
        return $entityToClone;
    }
    
    public function findCloneInstance($object) 
    {
        $em = $this->getDoctrine()->getManager();
        $periodActive = $this->getPeriodService()->getPeriodActive();
        $idSourceObject = $object->getId();
        
        $className = ClassUtils::getRealClass(get_class($object));
        $typeObject = PrePlanning::getTypeByClass($className);
        
        $cloneEntityInstance = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone')->findOneBy(array(
            'idSourceObject' => $idSourceObject,
            'typeObject' => $typeObject,
            'period' => $periodActive
        ));
        $entity = null;
        if($cloneEntityInstance){
            $typeObject = $cloneEntityInstance->getTypeObject();
            $idCloneObject = $cloneEntityInstance->getIdCloneObject();
            $classNameClonned = PrePlanningItemClone::getTypeObjectOf($typeObject);
            $entity = $em->getRepository($classNameClonned)->find($idCloneObject);
        }
        
        if($entity){
            $this->addToCache($entity,$this->generateId($object));
            $this->addToCache($entity,$this->generateId($entity));
        }
        return $entity;
    }
    
    private function cloneObjetive(Objetive $objetive)
    {
        $entity = $this->findCloneInstance($objetive);
        
        if(!$entity){
            $entity = clone($objetive);
            $this->saveClone($entity, $objetive);
            
            $indicators = new ArrayCollection();
            foreach ($entity->getIndicators() as $indicator) {
                $indicators->add($this->cloneObject($indicator));
            }
            $entity->setIndicators($indicators);

            $results = $entity->getResults();
            $entity->setResults(new ArrayCollection());
            
            foreach ($results as $result) {
                $cloneResult = $this->cloneObject($result,true);
                $entity->addResult($cloneResult);
            }

            if($entity->getArrangementRange()){
                $entity->setArrangementRange($this->cloneObject($entity->getArrangementRange(),true));
            }
            if($entity->getObjetiveLevel())
            {
                $objetiveLevel = $entity->getObjetiveLevel();
                if($objetiveLevel->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO){
                    $entity->setRef($objetive->getRef());
                }
                $entity->setObjetiveLevel($this->cloneObject($entity->getObjetiveLevel(),true));
            }
            $this->persist($entity, true);
        }
        return $entity;
    }

    private function cloneIndicator(Indicator $indicator,$andFlush = true) 
    {
        $entity = $this->findCloneInstance($indicator);
        if(!$entity){
            $entity = clone($indicator);
            
            if($entity->getTendency()){
                $entity->setTendency($this->cloneObject($entity->getTendency()));
            }
            if($entity->getFormula()){
                $entity->setFormula($this->cloneObject($entity->getFormula()));
            }
            
            if($entity->getFrequencyNotificationIndicator()){
                $entity->setFrequencyNotificationIndicator($this->cloneFrequencyNotificationIndicator($entity->getFrequencyNotificationIndicator()));
            }
            if($indicator->getParent()){
                $indicator->setParent($this->cloneObject($indicator->getParent()));
            }
            if($entity->getParent()){
                $entity->setParent($this->cloneObject($entity->getParent()));
            }
            if($entity->getArrangementRange()){
                $entity->setArrangementRange($this->cloneObject($entity->getArrangementRange()));
            }
            if($entity->getIndicatorLevel()){
                $entity->setIndicatorLevel($this->cloneObject($entity->getIndicatorLevel()));
            }
            $this->saveClone($entity, $indicator,$andFlush);
        }
        return $entity;
    }
    
    private function cloneTendency(\Pequiven\MasterBundle\Entity\Tendency $tendency)
    {
        $entity = $this->findCloneInstance($tendency);
        if(!$entity){
            $entity = clone($tendency);
            $this->saveClone($entity, $tendency);
        }
        return $entity;
    }
    
    private function cloneFormula(\Pequiven\MasterBundle\Entity\Formula $formula)
    {
        $entity = $this->findCloneInstance($formula);
        if(!$entity){
            $entity = clone($formula);
            
            if($entity->getFormulaLevel()){
                $entity->setFormulaLevel($this->cloneObject($entity->getFormulaLevel()));
            }
            $variables = new ArrayCollection();
            foreach ($entity->getVariables() as $variable) 
            {
                $variables->add($this->cloneObject($variable));
            }
            $entity->setVariables($variables);
            
            if($entity->getVariableToRealValue()){
                $entity->setVariableToRealValue($this->cloneObject($entity->getVariableToRealValue()));
            }
            if($entity->getVariableToPlanValue()){
                $entity->setVariableToPlanValue($this->cloneObject($entity->getVariableToPlanValue()));
            }
            
            $this->saveClone($entity, $formula);
        }
        return $entity;
    }

    private function cloneResult(Result $result,$andFlush = true)
    {
        $entity = $this->findCloneInstance($result);
        if(!$entity){
            $entity = clone($result);
            
            $childrens = $entity->getChildrens();
            $entity->setChildrens(new ArrayCollection());
            foreach ($childrens as $child) {
                $entity->addChildren($this->cloneObject($child));
            }
            //Bug de recursividad aqui cuando se clona un objetivo
//            if($entity->getObjetive()){
//                $entity->setObjetive($this->cloneObject($entity->getObjetive()));
//            }
            $this->saveClone($entity, $result,$andFlush);
        }
        
        return $entity;
    }
    
    private function cloneFormulaLevel(\Pequiven\MasterBundle\Entity\FormulaLevel $formulaLevel) 
    {
        $entity = $this->findCloneInstance($formulaLevel);
        if(!$entity){
            $entity = clone($formulaLevel);
            $this->saveClone($entity, $formulaLevel);
        }
        
        return $entity;
    }


    private function cloneArrangementRange(ArrangementRange $arrangementRange,$andFlush = true)
    {
        throw new Exception('Implementame '.__FUNCTION__);
    }
    
    private function cloneObjetiveLevel(\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel $objetiveLevel,$andFlush = true)
    {
        $entity = $this->findCloneInstance($objetiveLevel);
        if(!$entity){
            $entity = clone($objetiveLevel);
            $this->saveClone($entity, $objetiveLevel,$andFlush);
        }
        
        return $entity;
    }
    
    private function cloneIndicatorLevel(\Pequiven\IndicatorBundle\Entity\IndicatorLevel $objetiveLevel,$andFlush = true)
    {
        $entity = $this->findCloneInstance($objetiveLevel);
        if(!$entity){
            $entity = clone($objetiveLevel);
            $this->saveClone($entity, $objetiveLevel,$andFlush);
        }
        return $entity;
    }
    
    private function cloneFrequencyNotificationIndicator(Indicator\FrequencyNotificationIndicator $frequencyNotificationIndicator)
    {
        $entity = $this->findCloneInstance($frequencyNotificationIndicator);
        if(!$entity){
            $entity = clone($frequencyNotificationIndicator);
            $this->saveClone($entity, $frequencyNotificationIndicator);
        }
        return $entity;
    }
    
    private function cloneVariable(\Pequiven\MasterBundle\Entity\Formula\Variable $variable)
    {
        $entity = $this->findCloneInstance($variable);
        if(!$entity){
            $entity = clone($variable);
            $this->saveClone($entity, $variable);
        }
        return $entity;
    }
    
    private function saveClone(&$cloneObject,$sourceObject,$andFlush = true)
    {
//        var_dump($this->getPeriodToClone()->getId());
        $prePlanningItemClone = new PrePlanningItemClone();
        $cloneObject->setPeriod($this->getPeriodToClone());
        
        $this->persist($cloneObject,$andFlush);
        
        $idCloneObject = $cloneObject->getId();
        $idSourceObject = $sourceObject->getId();
        
        $className = ClassUtils::getRealClass(get_class($sourceObject));
        $typeObject = PrePlanning::getTypeByClass($className);
        
        if($idCloneObject === null || $idSourceObject === null){
            throw new Exception(sprintf('The idSourceObject(%s) or idCloneObject(%s) can not  be null. Log andFlush(%s),ClassName(%s).',$idSourceObject,$idCloneObject,$andFlush,$className));
        }
        $prePlanningItemClone->setIdCloneObject($idCloneObject);
        $prePlanningItemClone->setIdSourceObject($idSourceObject);
        $prePlanningItemClone->setPeriod($this->getPeriodService()->getPeriodActive());
        $prePlanningItemClone->setTypeObject($typeObject);
        $prePlanningItemClone->setUser($this->getUser());
        
        $this->persist($prePlanningItemClone,$andFlush);
        
        $this->addToCache($cloneObject,$this->generateId($sourceObject));
        $this->addToCache($cloneObject,$this->generateId($cloneObject));
    }

    private function cloneObject($sourceObject,$andFlush = true) 
    {
        $className = ClassUtils::getRealClass(get_class($sourceObject));
        $typeObject = PrePlanning::getTypeByClass($className);
        
        $supportObjects = array(
            PrePlanning::TYPE_OBJECT_OBJETIVE => 'cloneObjetive',
            PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM => 'SIM_IMPLEMENTAR',
            PrePlanning::TYPE_OBJECT_INDICATOR => 'cloneIndicator',
            PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL => 'SIM_IMPLEMENTAR',
            PrePlanning::TYPE_OBJECT_RESULT => 'cloneResult',
            PrePlanning::TYPE_OBJECT_TENDENCY => 'cloneTendency',
            PrePlanning::TYPE_OBJECT_FORMULA => 'cloneFormula',
            PrePlanning::TYPE_OBJECT_FORMULA_LEVEL => 'cloneFormulaLevel',
            PrePlanning::TYPE_OBJECT_ARRANGEMENT_RANGE => 'cloneArrangementRange',
            PrePlanning::TYPE_OBJECT_OBJETIVE_LEVEL => 'cloneObjetiveLevel',
            PrePlanning::TYPE_OBJECT_FREQUENCY_NOTIFICATION_INDICATOR => 'cloneFrequencyNotificationIndicator',
            PrePlanning::TYPE_OBJECT_VARIABLE => 'cloneVariable',
            PrePlanning::TYPE_OBJECT_INDICATOR_LEVEL => 'cloneIndicatorLevel',
        );
        $method = $supportObjects[$typeObject];
        $entity = $this->getFromCache($sourceObject);
        if($entity === null){
            $entity = call_user_func_array(array($this,$method), array($sourceObject,$andFlush));
        }
        return $entity;
    }
    
    private function addToCache($object,$idCache)
    {
        $this->cacheObject[$idCache] = $object;
    }
    
    private function getFromCache($object)
    {
        $entity = null;
        $idCache = $this->generateId($object);
        if(isset($this->cacheObject[$idCache])){
            $entity = $this->cacheObject[$idCache];
        }
        return $entity;
    }


    private function generateId($object)
    {
        $className = ClassUtils::getRealClass(get_class($object));
        $idCache = md5($className).'__'.$object->getId();
        return $idCache;
    }


    private function persist(&$object,$andFlush = false) {
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($object);
        if($andFlush === true){
            $em->flush();
        }
    }

    private function isGranted($roles)
    {
        return $this->container->get('security.context')->isGranted($roles);
    }
    
    private function getPeriodToClone()
    {
        $period = $this->getPeriodService()->getNextPeriod();
        return $period;
    }

        /**
     * @return PeriodService
     */
    private function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
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
    public function getUser()
    {
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
}
