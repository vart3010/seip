<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reporte de planta
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PlantReportController extends SEIPController
{
    public function createNew() 
    {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $reportTemplateId = $request->get("reportTemplate");
        if($reportTemplateId > 0){
            $em = $this->getDoctrine()->getManager();
            $reportTemplate = $em->find("Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate", $reportTemplateId);
            $entity->init($reportTemplate);
        }
        return $entity;
    }
}