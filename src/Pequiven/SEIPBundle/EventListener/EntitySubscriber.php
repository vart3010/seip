<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\EventListener;

/**
 * Description of EntitySubscriber
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class EntitySubscriber extends \Symfony\Component\DependencyInjection\ContainerAware implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public static function getSubscribedEvents() {
        return array(
            SeipEvents::REPORT_TEMPLATE_PRE_CREATE => "onReportTemplatePreCreate"
        );
    }
    
    public function onReportTemplatePreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();
        
        $entity->setPeriod($this->getPeriodService()->getPeriodActive(true));
        $entity->setRef($this->getSequenceGenerator()->getNextRefReportTemplate($entity));
        
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SequenceGenerator
     */
    private function getSequenceGenerator() 
    {
        return $this->container->get('seip.sequence_generator');
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    private function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
}
