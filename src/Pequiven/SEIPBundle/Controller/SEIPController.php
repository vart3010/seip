<?php

namespace Pequiven\SEIPBundle\Controller;

use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;

/**
 * Base de controlador SEIP
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class SEIPController extends ResourceController
{
    /**
     * 
     * @param type $id
     * @return \Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository
     */
    function getRepositoryById($id) {
        return $this->get('pequiven.repository.'.$id);
    }
    
    function save($entity,$flush = false)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        if($flush === true){
            $em->flush();
        }
    }
    
    protected function flush(){
        $em = $this->getDoctrine()->getManager();
        $em->flush();
    }
            
    function remove($entity,$flush = false)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        if($flush === true){
            $em->flush();
        }
    }
    
    /**
     * Configuracion global del SEIP
     * 
     * @return \Pequiven\SEIPBundle\Service\Configuration
     */
    protected function getSeipConfiguration() {
        return $this->get('seip.configuration');
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->container->get('seip.service.security');
    }
    
    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService()
    {
        return $this->get('pequiven_seip.service.period');
    }
}
