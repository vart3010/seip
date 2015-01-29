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
    public function cloneObject($object) 
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
                $entity = $this->cloneObjetive($object);
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
        return $entity;
    }
    
    private function cloneObjetive(Objetive $objetive)
    {
        $entity = $this->findCloneInstance($objetive);
        
        if(!$entity){
            $entity = clone($objetive);
            $indicators = new ArrayCollection();
            foreach ($entity->getIndicators() as $indicator) {
                $indicators->add($this->cloneIndicator($indicator));
            }
            $entity->setIndicators($indicators);

            $results = $entity->getResults();
            $entity->setResults(new ArrayCollection());
            
            foreach ($results as $result) {
                $cloneResult = $this->cloneResult($result);
                $entity->addResult($cloneResult);
            }

            if($entity->getArrangementRange()){
                $entity->setArrangementRange($this->cloneArrangementRange($entity->getArrangementRange()));
            }
            if($objetive->getObjetiveLevel()){
                $objetiveLevel = $objetive->getObjetiveLevel();
                if($objetiveLevel->getLevel() == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO){
                    $entity->setRef($objetive->getRef());
                }
                $entity->setObjetiveLevel($this->cloneObjetiveLevel($objetive->getObjetiveLevel()));
            }
            $this->saveClone($entity, $objetive);
        }
        return $entity;
    }

    private function cloneIndicator(Indicator $indicator) 
    {
        $entity = $this->findCloneInstance($indicator);
        if(!$entity){
            $entity = clone($indicator);
            
            if($entity->getTendency()){
                $entity->setTendency($this->cloneTendency($entity->getTendency()));
            }
            if($entity->getFormula()){
                $entity->setFormula($this->cloneFormula($entity->getFormula()));
            }
            
        }
        throw new Exception('Implementame'.__FUNCTION__);
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
                $entity->setFormulaLevel($this->cloneFormulaLevel($entity->getFormulaLevel()));
            }
        }
        return $entity;
    }


    private function cloneResult(Result $result)
    {
        $entity = $this->findCloneInstance($result);
        if(!$entity){
            $entity = clone($result);
            
            $childrens = $entity->getChildrens();
            $entity->setChildrens(new ArrayCollection());
            foreach ($childrens as $child) {
                $result->addChildren($this->cloneResult($child));
            }
            
//            Bucle
//            if($entity->getParent()){
//                $entity->setParent($this->cloneResult($entity->getParent()));
//            }
            if($entity->getObjetive()){
                $entity->setObjetive($this->cloneObjetive($entity->getObjetive()));
            }
            $this->saveClone($entity, $result);
        }
        
        return $entity;
    }
    
    private function cloneFormulaLevel(\Pequiven\MasterBundle\Entity\FormulaLevel $formulaLevel) {
        throw new Exception('Implementame '.__FUNCTION__);
    }


    private function cloneArrangementRange(ArrangementRange $arrangementRange)
    {
        throw new Exception('Implementame '.__FUNCTION__);
    }
    
    private function cloneObjetiveLevel(\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel $objetiveLevel)
    {
        throw new Exception('Implementame '.__FUNCTION__);
    }
    
    private function cloneVariable(\Pequiven\MasterBundle\Entity\Formula\Variable $variable)
    {
        throw new Exception('Implementame '.__FUNCTION__);
    }
    
    private function saveClone(&$cloneObject,$sourceObject)
    {
        $cloneObject->setPeriod($this->getPeriodToClone());
        
        $this->persist($cloneObject,true);
        $prePlanningItemClone = new PrePlanningItemClone();
        
        $idCloneObject = $cloneObject->getId();
        $idSourceObject = $sourceObject->getId();
        
        $className = ClassUtils::getRealClass(get_class($sourceObject));
        $typeObject = PrePlanning::getTypeByClass($className);
        
        $prePlanningItemClone->setIdCloneObject($idCloneObject);
        $prePlanningItemClone->setIdSourceObject($idSourceObject);
        $prePlanningItemClone->setPeriod($this->getPeriodService()->getPeriodActive());
        $prePlanningItemClone->setTypeObject($typeObject);
        $prePlanningItemClone->setUser($this->getUser());
        
        $this->persist($prePlanningItemClone,true);
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
