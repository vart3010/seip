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
    
    public function updateResultOfObjetives(\Pequiven\SEIPBundle\Entity\Result\Result $myResult)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($myResult->getResultDetails());
        $objetives = $myResult->getObjetives();
        foreach ($objetives as $objetive) {
            $results = $objetive->getResults();
            $total = 0;
            foreach ($results as $result) {
                $resultDetails = $result->getResultDetails();
                $total += $resultDetails->getGlobalResultWithWeight();
            }
            $objetive->setResultOfObjetive($total);
            $em->persist($objetive);
        }

        $em->flush();
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
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
