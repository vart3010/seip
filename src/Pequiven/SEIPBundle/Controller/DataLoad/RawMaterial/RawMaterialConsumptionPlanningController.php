<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad\RawMaterial;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de presupuesto de materia prima
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class RawMaterialConsumptionPlanningController extends SEIPController 
{
    
    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $productReportId = $request->get("productReport");
        if($productReportId > 0){
            $em = $this->getDoctrine()->getManager();
            $productReport = $em->getRepository("Pequiven\SEIPBundle\Entity\DataLoad\ProductReport")->find($productReportId);
            $entity->setProductReport($productReport);
        }
        return $entity;
    }
}
