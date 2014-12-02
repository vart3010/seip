<?php

namespace Pequiven\SEIPBundle\EventListener;

use Pequiven\ArrangementProgramBundle\ArrangementProgramEvents;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Captura los eventos del sistema para calcular los resultados
 *
 * @author inhack20
 */
class ResultListerner implements EventSubscriberInterface, ContainerAwareInterface
{
    protected $container;
    
    public static function getSubscribedEvents() {
        return array(
            ArrangementProgramEvents::ARRANGEMENT_PROGRAM_POST_FINISH_THE_NOTIFICATION_PROCESS => 'onPostFinishTheNotificationProcess',
        );
    }
    
    /**
     * Se agrega calcula el resultado que impacta el programa de gestion
     * @param ResourceEvent $event
     */
    function onPostFinishTheNotificationProcess(ResourceEvent $event) {
        /**
         * \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram
         */
        $object = $event->getSubject();
        
        $objetive = $object->getObjetiveByType();
        if($objetive){
            
            $results = $objetive->getResults();
            $myResult = null;
            foreach ($results as $result) {
                if($result->getTypeResult() == \Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM){
                    $myResult = $result;
                    break;
                }
            }
            if($myResult){
                $arrangementPrograms = $objetive->getArrangementPrograms();
                $countArrangementPrograms = count($arrangementPrograms);
                if($countArrangementPrograms > 0){
                    $total = 0.0;
                    foreach ($arrangementPrograms as $arrangementProgram){
                        $total += $arrangementProgram->getTotalForResult();
                    }
                    $total = $total / $countArrangementPrograms;
                }
                $myResult->setTotal($total);
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
        }
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
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
