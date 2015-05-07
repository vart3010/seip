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
        $className = ClassUtils::getRealClass(get_class($object));
        
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
    
    /**
     * Retorna la instancia del objeto que se quiere clonar.
     * @param PrePlanning $prePlanning
     * @return type
     */
    public function findInstancePrePlanning(PrePlanning $prePlanning)
    {
        $idSourceObject = $prePlanning->getIdSourceObject();
        $typeObject = $prePlanning->getTypeObject();
        $itemInstance = $this->findItemInstance($idSourceObject,$typeObject);
        
        return $itemInstance;
    }
    
    /**
     * Busca una instancia del objeto que se quiere clonar.
     * @param type $idSourceObject
     * @param type $typeObject
     * @return type
     */
    public function findItemInstance($idSourceObject,$typeObject) 
    {
        $em = $this->getDoctrine()->getManager();
        
        $typeObjectRepository = PrePlanning::getTypeObjectOf($typeObject);
        $entityToClone = $em->getRepository($typeObjectRepository)->find($idSourceObject);
        return $entityToClone;
    }
    
    /**
     * Retorna la instancia de un objeto si ya fue clonado.
     * @param type $object
     * @return type
     */
    public function findCloneInstance($object,$throwException = false) 
    {
        $em = $this->getDoctrine()->getManager();
        
        $className = ClassUtils::getRealClass(get_class($object));
        $typeObject = PrePlanning::getTypeByClass($className);
        
        $prePlanningCloneEntityInstance = $this->findPrePlanningItemForObject($object);
        $entity = $classNameClonned = null;
        if($prePlanningCloneEntityInstance){
            $typeObject = $prePlanningCloneEntityInstance->getTypeObject();
            $idCloneObject = $prePlanningCloneEntityInstance->getIdCloneObject();
            $classNameClonned = PrePlanningItemClone::getTypeObjectOf($typeObject);
            $entity = $em->getRepository($classNameClonned)->find($idCloneObject);
        }
        
        if($entity){
            $this->addToCache($entity,$this->generateId($object));
            $this->addToCache($entity,$this->generateId($entity));
        }else if($throwException){
            throw new Exception(sprintf('The object instance for "%s" not found!',$className));
        }
        return $entity;
    }
    
    private function findPrePlanningItemForObject($object)
    {
        $className = ClassUtils::getRealClass(get_class($object));
        $typeObject = PrePlanning::getTypeByClass($className);
        
        $em = $this->getDoctrine()->getManager();
        $periodActive = $this->getPeriodService()->getPeriodActive();
        $idSourceObject = $object->getId();
        
        $prePlanningCloneEntityInstance = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItemClone')->findOneBy(array(
            'idSourceObject' => $idSourceObject,
            'typeObject' => $typeObject,
            'period' => $periodActive
        ));
        return $prePlanningCloneEntityInstance;
    }


    private function cloneObjetive(Objetive $objetive)
    {
        $entity = $this->findCloneInstance($objetive);
        if(!$entity){
            $cloneAll = false;
            $level = $objetive->getObjetiveLevel()->getLevel();
            if($level == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO){
                $cloneAll = true;
            }
            $entity = $this->_clone($objetive);
            
            if($entity->getArrangementRange()){
                $entity->setArrangementRange($this->cloneObject($objetive->getArrangementRange(),true));
            }
            
//                $em = $this->getDoctrine()->getManager();
//                foreach ($entity->getChildrens() as $child) {
//                    $entity->getChildrens()->removeElement($child);
//                }
            
            $this->saveClone($entity, $objetive);
            
//            if($cloneAll){
//                $indicators = new ArrayCollection();
//                foreach ($entity->getIndicators() as $indicator) {
//                    $indicators->add($this->cloneObject($indicator));
//                }
//                $entity->setIndicators($indicators);
//            }

            $entity->setIndicators(new ArrayCollection());
            $results = $entity->getResults();
            $entity->setResults(new ArrayCollection());
            
            foreach ($results as $result) {
                $cloneResult = $this->cloneObject($result,true);
                $entity->addResult($cloneResult);
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
            $objetives = new ArrayCollection($indicator->getObjetives()->toArray());
            $tagsIndicator = new ArrayCollection($indicator->getTagsIndicator()->toArray());
            
            $entity = $this->_clone($indicator);
            
//            foreach ($entity->getObjetives() as $objetive) {
//                var_dump($objetive->getId());
//                var_dump($objetive->getRef());
//                var_dump(get_class($objetive));
////                var_dump($this->cloneObject($objetive));
//            }
//            die;
            if($entity->getTendency()){
                $entity->setTendency($this->cloneObject($entity->getTendency()));
            }
            if($entity->getFormula()){
                $entity->setFormula($this->cloneObject($entity->getFormula()));
            }
            
            if($entity->getFrequencyNotificationIndicator()){
                $entity->setFrequencyNotificationIndicator($this->cloneObject($entity->getFrequencyNotificationIndicator()));
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
            
            foreach ($objetives as $objetive) {
                $entity->addObjetive($this->cloneObject($objetive));
            }
            
            $this->saveClone($entity, $indicator,$andFlush);
            
            foreach ($tagsIndicator as $tagIndicator) 
            {
                $tagIndicator->setIndicator($entity);
                $indicator->addTagsIndicator($this->cloneObject($tagIndicator,true));
            }
        }
        return $entity;
    }
    
    private function cloneTendency(\Pequiven\MasterBundle\Entity\Tendency $tendency)
    {
        $entity = $tendency;
//        $entity = $this->findCloneInstance($tendency);
//        if(!$entity){
//            $entity = $this->_clone($tendency);
//            $this->saveClone($entity, $tendency);
//        }
        return $entity;
    }
    
    private function cloneFormula(\Pequiven\MasterBundle\Entity\Formula $formula)
    {
        $entity = $formula;
//        $entity = $this->findCloneInstance($formula);
//        if(!$entity){
//            $entity = $this->_clone($formula);
//            
//            if($entity->getFormulaLevel()){
//                $entity->setFormulaLevel($this->cloneObject($entity->getFormulaLevel()));
//            }
//            $variables = new ArrayCollection();
//            foreach ($entity->getVariables() as $variable) 
//            {
//                $variables->add($this->cloneObject($variable));
//            }
//            $entity->setVariables($variables);
//            
//            if($entity->getVariableToRealValue()){
//                $entity->setVariableToRealValue($this->cloneObject($entity->getVariableToRealValue()));
//            }
//            if($entity->getVariableToPlanValue()){
//                $entity->setVariableToPlanValue($this->cloneObject($entity->getVariableToPlanValue()));
//            }
//            
//            $this->saveClone($entity, $formula);
//        }
        return $entity;
    }

    private function cloneResult(Result $result,$andFlush = true)
    {
        $entity = $this->findCloneInstance($result);
        if(!$entity){
            $entity = $this->_clone($result);
            
            if($result->getParent() !== null){
                
            }
            
            $childrens = $entity->getChildrens();
            $entity->setChildrens(new ArrayCollection());
            $this->saveClone($entity, $result,$andFlush);
            
            foreach ($childrens as $child) {
                $entity->addChildren($this->cloneObject($child));
            }
            //Bug de recursividad aqui cuando se clona un objetivo
//            if($entity->getObjetive()){
//                $entity->setObjetive($this->cloneObject($entity->getObjetive()));
//            }
            $this->persist($entity,true);
        }
        
        return $entity;
    }
    
    private function cloneFormulaLevel(\Pequiven\MasterBundle\Entity\FormulaLevel $formulaLevel) 
    {
        $entity = $formulaLevel;
//        $entity = $this->findCloneInstance($formulaLevel);
//        if(!$entity){
//            $entity = $this->_clone($formulaLevel);
//            $this->saveClone($entity, $formulaLevel);
//        }
//        
        return $entity;
    }


    private function cloneArrangementRange(ArrangementRange $arrangementRange,$andFlush = true)
    {
        $entity = $this->findCloneInstance($arrangementRange);
        if(!$entity){
            $entity = $this->_clone($arrangementRange);
            
//            if($arrangementRange->getTypeRangeTop()){
//                $arrangementRange->setTypeRangeTop($this->cloneObject($arrangementRange->getTypeRangeTop()));
//            }
//            if($arrangementRange->getTypeRangeMiddleTop()){
//                $arrangementRange->setTypeRangeMiddleTop($this->cloneObject($arrangementRange->getTypeRangeMiddleTop()));
//            }
//            if($arrangementRange->getTypeRangeMiddleBottom()){
//                $arrangementRange->setTypeRangeMiddleBottom($this->cloneObject($arrangementRange->getTypeRangeMiddleBottom()));
//            }
//            if($arrangementRange->getTypeRangeBottom()){
//                $arrangementRange->setTypeRangeBottom($this->cloneObject($arrangementRange->getTypeRangeBottom()));
//            }
            
            $this->saveClone($entity, $arrangementRange,$andFlush);
        }
        
        return $entity;
    }
    
    private function cloneObjetiveLevel(\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel $objetiveLevel,$andFlush = true)
    {
        $entity = $objetiveLevel;
//        $entity = $this->findCloneInstance($objetiveLevel);
//        if(!$entity){
//            $entity = $this->_clone($objetiveLevel);
//            $this->saveClone($entity, $objetiveLevel,$andFlush);
//        }
        
        return $entity;
    }
    
    private function cloneIndicatorLevel(\Pequiven\IndicatorBundle\Entity\IndicatorLevel $objetiveLevel,$andFlush = true)
    {
        $entity = $objetiveLevel;
//        $entity = $this->findCloneInstance($objetiveLevel);
//        if(!$entity){
//            $entity = $this->_clone($objetiveLevel);
//            $this->saveClone($entity, $objetiveLevel,$andFlush);
//        }
        return $entity;
    }
    
    private function cloneFrequencyNotificationIndicator(Indicator\FrequencyNotificationIndicator $frequencyNotificationIndicator)
    {
        $entity = $frequencyNotificationIndicator;
//        $entity = $this->findCloneInstance($frequencyNotificationIndicator);
//        if(!$entity){
//            $entity = $this->_clone($frequencyNotificationIndicator);
//            $this->saveClone($entity, $frequencyNotificationIndicator);
//        }
        return $entity;
    }
    
    private function cloneVariable(\Pequiven\MasterBundle\Entity\Formula\Variable $variable)
    {
        $entity = $variable;
//        $entity = $this->findCloneInstance($variable);
//        if(!$entity){
//            $entity = $this->_clone($variable);
//            $this->saveClone($entity, $variable);
//        }
        return $entity;
    }
    
    private function cloneArrangementProgram(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $arrangementProgram,$andFlush = true)
    {
        $entity = $this->findCloneInstance($arrangementProgram);
        if(!$entity){
            $entity = $this->_clone($arrangementProgram);
            
            if($entity->getTacticalObjective()){
                $entity->setTacticalObjective($this->cloneObject($entity->getTacticalObjective()));
            }
            
            if($entity->getOperationalObjective()){
                $entity->setOperationalObjective($this->cloneObject($entity->getOperationalObjective()));
            }
            
            $entity->setPeriod($this->getPeriodToClone());
            $sequenceGenerator = $this->container->get('seip.sequence_generator');
            
            $entity->setRef($sequenceGenerator->getNextArrangementProgram($entity));
            $entity->setCreatedBy($this->getUser());
            
            $this->saveClone($entity, $arrangementProgram,$andFlush);
        }
        return $entity;
    }
    
    private function cloneArrangementProgramGoal(\Pequiven\ArrangementProgramBundle\Entity\Goal $goal,$andFlush = true)
    {
        $entity = $this->findCloneInstance($goal);
        if(!$entity){
            $entity = $this->_clone($goal);
            
            $arrangementProgramCloned = $this->cloneObject($entity->getTimeline()->getArrangementProgram());
            $timeline = $arrangementProgramCloned->getTimeline();
            
            $entity->setGoalDetails(new \Pequiven\ArrangementProgramBundle\Entity\GoalDetails());
            $entity->setTimeline($timeline);
            
            $this->saveClone($entity, $goal,$andFlush);
        }
        return $entity;
    }
    
    private function cloneTagIndicator(Indicator\TagIndicator $tagIndicator,$andFlush = true)
    {
        $entity = $this->findCloneInstance($tagIndicator);
        if(!$entity){
//            $indicator = $tagIndicator->getIndicator();
            $entity = $this->_clone($tagIndicator);
//            $entity->setIndicator($this->findCloneInstance($indicator,true));
            
            $this->saveClone($entity, $tagIndicator,$andFlush);
        }
        return $entity;
    }
    
    private function cloneExample(\Pequiven\MasterBundle\Entity\Operator $operator,$andFlush = true)
    {
        throw new Exception('IMPLEMENTAME '.__FUNCTION__);
    }

    private function saveClone(&$cloneObject,&$sourceObject,$andFlush = true)
    {
        
        $prePlanningItemClone = $this->findPrePlanningItemForObject($sourceObject);
        if(!$prePlanningItemClone){
            $prePlanningItemClone = new PrePlanningItemClone();
        }
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
        $prePlanningItemClone->setPeriod($this->getPeriodService()->getEntityPeriodActive());
        $prePlanningItemClone->setTypeObject($typeObject);
        $prePlanningItemClone->setUser($this->getUser());
        
        $this->persist($prePlanningItemClone,$andFlush);
        
        $this->addToCache($cloneObject,$this->generateId($sourceObject));
        $this->addToCache($cloneObject,$this->generateId($cloneObject));
    }

    public function cloneObject($sourceObject,$andFlush = true) 
    {
        $className = ClassUtils::getRealClass(get_class($sourceObject));
        $typeObject = PrePlanning::getTypeByClass($className);
        
        $supportObjects = array(
            PrePlanning::TYPE_OBJECT_OBJETIVE => 'cloneObjetive',
            PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM => 'cloneArrangementProgram',
            PrePlanning::TYPE_OBJECT_INDICATOR => 'cloneIndicator',
            PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL => 'cloneArrangementProgramGoal',
            PrePlanning::TYPE_OBJECT_RESULT => 'cloneResult',
            PrePlanning::TYPE_OBJECT_TENDENCY => 'cloneTendency',
            PrePlanning::TYPE_OBJECT_FORMULA => 'cloneFormula',
            PrePlanning::TYPE_OBJECT_FORMULA_LEVEL => 'cloneFormulaLevel',
            PrePlanning::TYPE_OBJECT_ARRANGEMENT_RANGE => 'cloneArrangementRange',
            PrePlanning::TYPE_OBJECT_OBJETIVE_LEVEL => 'cloneObjetiveLevel',
            PrePlanning::TYPE_OBJECT_FREQUENCY_NOTIFICATION_INDICATOR => 'cloneFrequencyNotificationIndicator',
            PrePlanning::TYPE_OBJECT_VARIABLE => 'cloneVariable',
            PrePlanning::TYPE_OBJECT_INDICATOR_LEVEL => 'cloneIndicatorLevel',
            PrePlanning::TYPE_OBJECT_TAG_INDICATOR => 'cloneTagIndicator',
        );
        $method = $supportObjects[$typeObject];
        $entity = $this->getFromCache($sourceObject);
        if($entity === null){
            $entity = call_user_func_array(array($this,$method), array($sourceObject,$andFlush));
        }
        return $entity;
    }
    
    private function addToCache(&$object,$idCache)
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
    
    private function _clone(&$object) 
    {
        $cloneObject = clone $object;
//        $em = $this->getDoctrine()->getManager();
//        $em->detach($cloneObject);
        return $cloneObject;
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
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
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
