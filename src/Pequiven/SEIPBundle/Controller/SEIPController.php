<?php

namespace Pequiven\SEIPBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

/**
 * Base de controlador SEIP
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class SEIPController extends FOSRestController
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
    
    function remove($entity,$flush = false)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        if($flush === true){
            $em->flush();
        }
    }
}
