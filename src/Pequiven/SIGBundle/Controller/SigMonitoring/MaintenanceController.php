<?php

namespace Pequiven\SIGBundle\Controller\SigMonitoring;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pequiven\SIGBundle\Entity\Tracing\Maintenance;
use Pequiven\SIGBundle\Form\Tracing\MaintenanceType;

/**
 * Controlador Seguimiento y Eficacia (Mantenimiento)
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class MaintenanceController extends ResourceController
{
    public function addAction(Request $request){
        
        $id = $request->get('id');  
        $period = $this->getPeriodService()->getPeriodActive();

        $maintenance = new maintenance();
        $form  = $this->createForm(new MaintenanceType($period), $maintenance);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $managemensystems = $this->container->get('pequiven.repository.sig_management_system')->find($id); 
            $em = $this->getDoctrine()->getManager();                        

            if ($request->get('analysis')) {
                $maintenance->setAnalysis(1);
            }

            $maintenance->setManagementSystem($managemensystems);
            $em->persist($maintenance);            
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Datos Cargados Exitosamente");
            die();
        }                

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Tracing/Form/form_maintenance.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(                
                'form' => $form->createView(),
                'period_valid'        => '2016'
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    /**
     *  Notification
     *
     */
    protected function getNotificationService() {        
        return $this->container->get('seip.service.notification');
    }

    /**
     *  Period
     *
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }
}
