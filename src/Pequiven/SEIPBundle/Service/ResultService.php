<?php

namespace Pequiven\SEIPBundle\Service;

/**
 * Servicio que se encarga de actualizar los resultados
 * 
 * @service seip.service.result
 * @author inhack20
 */
class ResultService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    protected $container;
 
    /**
     * Devuelve un resultado por el tipo
     * @param array $results
     * @param type $type
     * @return array
     */
    public function getResultByType($results,$type)
    {
        $myResult = null;
        if($results != null){
            foreach ($results as $result) {
                if($result->getTypeResult() == $type){
                    $myResult = $result;
                    break;
                }
            }
        }
        return $myResult;
    }
    
    /**
     * Actualiza los resultados de un objetivo
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $myResult
     */
    public function updateResultOfObjetives(\Pequiven\SEIPBundle\Entity\Result\Result $myResult)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($myResult->getResultDetails());
        $objetives = $myResult->getObjetives();
        foreach ($objetives as $objetive) {
            $results = $objetive->getResults();
            $total = 0;
            $countResult = 0;
            foreach ($results as $result) {
                $countResult++;
                if($result->getChildrens()->count() > 0){
                    
                }else{
                    if($myResult->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
                        $total += $myResult->getResult();
                    }elseif($myResult->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
                        $total += $myResult->getResultWithWeight();
                    }
                }
            }
            if($myResult->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
                $total += ($total / $countResult);
            }elseif($myResult->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
                //Nada que hacer
            }
            
            $objetive->setResultOfObjetive($total);
            $em->persist($objetive);
        }

        $em->flush();
    }
    
    function updateResultObjertivesParents(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive)
    {
        $parents = $objetive->getParents();
        foreach ($parents as $parent) {
            
        }
    }
    
    function calculateResult(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        if($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM){
            $this->calculateResultTypeArrangementPrograms($result);
        }elseif($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_INDICATOR){
            $this->calculateResultTypeIndicator($result);
        }
    }
    
    /**
     * Calcula el resultado a partir de los programas de gestion
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    function calculateResultTypeArrangementPrograms(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        $objetives = $result->getObjetives();
        foreach ($objetives as $objetive) {
            $arrangementPrograms = $objetive->getArrangementPrograms();
            $countArrangementPrograms = count($arrangementPrograms);
            $total = 0.0;
            $countResult = 0;
            if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
                if($countArrangementPrograms > 0){
                    foreach ($arrangementPrograms as $arrangementProgram){
                        $countResult++;
                        $total += $arrangementProgram->getResult();
                    }
                }
            }elseif($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
                throw new \LogicException(sprintf('Los programas de gestion no se calculan con promedio ponderado, revise el resultado con id "%s"',$myResult->getId()));
            }

            if($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_SIMPLE_AVERAGE){
                $total += ($total / $countResult);
            }elseif($result->getTypeCalculation() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_CALCULATION_WEIGHTED_AVERAGE){
                //Nada que hacer
            }
            $result->setTotal($total);

            $this->updateResultOfObjetives($result);
        }
    }
    
    /**
     * Calcula los resultados a partir de los indicadores
     * 
     * @param \Pequiven\SEIPBundle\Entity\Result\Result $result
     */
    function calculateResultTypeIndicator(\Pequiven\SEIPBundle\Entity\Result\Result &$result) {
        
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
    
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
