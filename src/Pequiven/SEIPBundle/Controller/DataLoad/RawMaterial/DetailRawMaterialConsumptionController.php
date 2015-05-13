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
 * Controlador de detalles de consumo de materia prima
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class DetailRawMaterialConsumptionController extends SEIPController 
{
    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $rawMaterialConsumptionPlanningId = $request->get("rawMaterialConsumption");
        if($rawMaterialConsumptionPlanningId > 0){
            $em = $this->getDoctrine()->getManager();
            $rawMaterialConsumptionPlanning = $em->getRepository("Pequiven\SEIPBundle\Entity\DataLoad\RawMaterial\RawMaterialConsumptionPlanning")->find($rawMaterialConsumptionPlanningId);
            $entity->setRawMaterialConsumptionPlanning($rawMaterialConsumptionPlanning);
        }
        return $entity;
    }
}
