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
            SeipEvents::RESULT_ARRANGEMENT_PROGRAM_UPDATE => 'onPostFinishTheNotificationProcess',
//            SeipEvents::VALUE_INDICATOR_PRE_UPDATE => 'onPreValueIndicatorPreUpdate',
//            SeipEvents::VALUE_INDICATOR_PRE_ADD => 'onPreValueIndicatorPreUpdate',
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
            $resultService = $this->getResultService();
            $myResult = $resultService->getResultByType($objetive->getResults(),\Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_ARRANGEMENT_PROGRAM);
            
            if($myResult){
                $resultService->calculateResult($myResult);
            }
        }
    }
    
    /**
     * Se agrega calcula el resultado que impacta el programa de gestion
     * @param ResourceEvent $event
     */
    function onPreValueIndicatorPreUpdate(ResourceEvent $event) {
        /**
         * @var \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator
         */
        $object = $event->getSubject();
        $indicator = $object->getIndicator();
        $parent = $indicator->getParent();//Indicador que impacta este indicador
        
        $resultService = $this->getResultService();
        if($parent){
            
        }else{
            $objetives = $indicator->getObjetives();
            foreach ($objetives as $objetive) {
                $myResult = $resultService->getResultByType($objetive->getResults(),\Pequiven\SEIPBundle\Entity\Result\Result::TYPE_RESULT_INDICATOR);
                if($myResult){
                    $resultService->calculateResult($myResult);
                }
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
    
    /**
     * Servicio que calcula los resultados
     * @return \Pequiven\SEIPBundle\Service\ResultService
     */
    public function getResultService()
    {
        return $this->container->get('seip.service.result');
    }
}
