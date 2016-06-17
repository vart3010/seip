<?php

namespace Pequiven\SIGBundle\Controller\SigMonitoring;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pequiven\SIGBundle\Entity\Tracing\Maintenance;
use Pequiven\SIGBundle\Entity\Tracing\MaintenanceAdvance;
use Pequiven\SIGBundle\Form\Tracing\MaintenanceType;
use Pequiven\SIGBundle\Form\Tracing\MaintenanceAdvanceType;
use Pequiven\SIGBundle\Entity\Tracing\Standardization;

/**
 * Controlador Seguimiento y Eficacia (Mantenimiento)
 *
 * @author Maximo Sojo <maximosojo@atechnologies.com.ve> 
 */
class MaintenanceController extends ResourceController
{
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();                        
        
        $id = $request->get('id');  
        $valueCharge = $advance = $dataAdvance = 0;
        $valid = 100;

        $period = $this->getPeriodService()->getPeriodActive();

        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->find($id);
        
        foreach ($standardization->getMaintenance() as $valueMaintenance) {            
            $idMaintenance = $valueMaintenance->getId();            
            $advance = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\MaintenanceAdvance")->findBy(array('maintenance' => $idMaintenance)); 
            foreach ($advance as $value) {
                $dataAdvance = $value->getAdvance();
                $valid = $dataAdvance - $valid;
            }
        }
        
        $maintenance = new maintenance();
        $maintenanceAdvance = new maintenanceAdvance();

        $form  = $this->createForm(new MaintenanceType($period), $maintenance);
        $formAdvance  = $this->createForm(new MaintenanceAdvanceType($valid), $maintenanceAdvance);

        if ($advance) {
            $valueCharge = 1;
        }
        
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);             
            $advance = $request->get('sig_maintenance_advance')['advance'];
            
            if ($valueCharge == 0 ) {
                $maintenance->addStandardization($standardization);            
                $maintenance->setAnalysis($request->get('sig_maintenance')['analysis']);
                $em->persist($maintenance);            
                $em->flush();                
                $idMaintenance = $maintenance->getId();
            }else{
                $advance = $advance + $dataAdvance;                
            }

            $maintenanceData = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Maintenance")->findOneById($idMaintenance);                        
            
            if ($advance == 100) {
                $maintenanceData->setStatus(2);                                                     
                $em->flush();   
            }

            $maintenanceAdvance->setMaintenance($maintenanceData);
            $maintenanceAdvance->setAdvance($advance);
            $maintenanceAdvance->setObservations($request->get('sig_maintenance_advance')['observations']);

            $em->persist($maintenanceAdvance);            
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Datos Cargados Exitosamente");
            die();
        }    

        foreach (Standardization::getDetectionArray() as $key => $value) {
                $labelsDetection[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }

        foreach (Standardization::getTypeNcArray() as $key => $value) {
                $labelsTypeNc[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }

        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->find($id);

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Tracing/Form/form_maintenance.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(                
                'form' => $form->createView(),
                'formAdvance' => $formAdvance->createView(),
                'period_valid'        => '2016',
                'standardization'     => $standardization,
                'labelsDetection'     => $labelsDetection,
                'labelsTypeNc'        => $labelsTypeNc,
                'valueCharge'         => $valueCharge,
                'dataAdvance'         => $dataAdvance
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }

    public function showAction(Request $request){
        $em = $this->getDoctrine()->getManager(); 
        $id = $request->get('id');  
        $period = $this->getPeriodService()->getPeriodActive();
        $idMaintenance = 0;

        $standardization = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Standardization")->find($id);
        foreach ($standardization->getMaintenance() as  $value) {
            $idMaintenance = $value->getId();
        }
        
        $advance = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\MaintenanceAdvance")->findBy(array('maintenance' => $idMaintenance));                                        
        
        foreach (Standardization::getDetectionArray() as $key => $value) {
                $labelsDetection[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }

        foreach (Standardization::getTypeNcArray() as $key => $value) {
                $labelsTypeNc[] = array(
                    'id' => $key,
                    'description' => $this->trans($value, array(), 'PequivenSIGBundle'),
                );
            }
        
        $statusMaintanence = [
            0 => "Abierta No Vencia",
            1 => "Cerrada",
            2 => "Abierta Vencida"            
        ];

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Tracing/Form/formShow.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData(array(                              
                'period_valid'        => '2016',
                'standardization'     => $standardization,
                'labelsDetection'     => $labelsDetection,
                'labelsTypeNc'        => $labelsTypeNc,
                'statusMaintanence'   => $statusMaintanence,
                'advance'             => $advance
            ))
        ;
        $view->getSerializationContext()->setGroups(array('id','api_list'));
        return $view;
    }
    
    /**
     *
     *  Metodo de Verificación
     *  1 Eficaz, 2 No Eficaz
     */
    public function addVerificationAction(Request $request){
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();                        
        $maintenance = $em->getRepository("\Pequiven\SIGBundle\Entity\Tracing\Maintenance")->find($id);
        
        if ($request->isMethod('POST')) { 
            $date = date("Y-m-d H:i");
            $date = date_create_from_format("Y-m-d H:i", $date);
            
            $maintenance->setStatusVerification($request->get('verification'));            
            $maintenance->setDateVerification($date);
            $em->persist($maintenance);            
            $em->flush();                                

            $this->get('session')->getFlashBag()->add('success', "Verificación Realizada Exitosamente");
            die();
        }    

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('Tracing/Form/formVerification.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
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
