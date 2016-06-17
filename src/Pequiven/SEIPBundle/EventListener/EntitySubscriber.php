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
class EntitySubscriber extends BaseEventListerner
{
    public static function getSubscribedEvents() {
        return array(
            SeipEvents::REPORT_TEMPLATE_PRE_CREATE => "onReportTemplatePreCreate",
            SeipEvents::REPORT_TEMPLATE_DELIVERY_PRE_CREATE => "onReportTemplateDeliveryPreCreate",
            SeipEvents::PRODUCT_PLANNING_PRE_CREATE => "onProductPlanningPreCreate",
            SeipEvents::PRODUCT_RANGE_CREATE => "onProductRangePreCreate",
            SeipEvents::PRODUCT_PRODUCT_DETAIL_DAILY_MONTH_PRE_CREATE => "onDetailDailyMonthPreCreate",
            SeipEvents::PLANT_STOP_PLANNING_PRE_UPDATE => "onPlantStopPlanningPreUpdate",
            SeipEvents::REPORT_PLANT_PRE_CREATE => "onReportPlantPreCreate",
            SeipEvents::PRODUCT_REPORT_PRE_CREATE => "onReportProductPreCreate",
            SeipEvents::REPORT_UNREALIZED_PRODUCT_PRE_CREATE => "onReportUnrealizedProductPreCreate",
            SeipEvents::REPORT_INVENTORY_PRE_CREATE => "onReportInventoryProductPreCreate",
        );
    }
    
    public function onReportTemplatePreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();
        
        $entity->setPeriod($this->getPeriodService()->getPeriodActive());
        $entity->setRef($this->getSequenceGenerator()->getNextRefReportTemplate($entity));
        
    }
    
    public function onReportTemplateDeliveryPreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();
        
        $entity->setPeriod($this->getPeriodService()->getPeriodActive());
        $entity->setRef($this->getSequenceGenerator()->getNextRefReportTemplateDelivery($entity));
        
    }
    

    public function onReportPlantPreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();        
        $entity->setPeriod($this->getPeriodService()->getPeriodActive());                
    }

    public function onReportUnrealizedProductPreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();        
        $entity->setPeriod($this->getPeriodService()->getPeriodActive());                
    }

    public function onReportInventoryProductPreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();        
        $entity->setPeriod($this->getPeriodService()->getPeriodActive());                
    }

    public function onReportProductPreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();        
        $entity->setPeriod($this->getPeriodService()->getPeriodActive());                
    }
    
    public function onProductPlanningPreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();
        $request = $this->getRequest();
        $productReportId = $request->get("productReport");
        $productReport = $this->find("Pequiven\SEIPBundle\Entity\DataLoad\ProductReport", $productReportId);
        $entity->setProductReport($productReport);
        $entity->setType($request->get("type"));
    }
    
    public function onProductRangePreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        var_dump('epa');die();
        $entity = $event->getSubject();
        $request = $this->getRequest();
        $productPlanningId = $request->get("productPlanning");
        $productPlanning = $this->find("Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning", $productPlanningId);
        $entity->setProductPlanning($productPlanning);
    }
    
    public function onDetailDailyMonthPreCreate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();
        $request = $this->getRequest();
        $productReportId = $request->get("productReport");
        $productReport = $this->find("Pequiven\SEIPBundle\Entity\DataLoad\ProductReport", $productReportId);
        $entity->setProductReport($productReport);
        $entity->setPeriod($this->getPeriodService()->getPeriodActive());
    }
    
    public function onPlantStopPlanningPreUpdate(\Sylius\Bundle\ResourceBundle\Event\ResourceEvent $event)
    {
        $entity = $event->getSubject();
        $entity->calculate();
    }
}
