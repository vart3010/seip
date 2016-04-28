<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\Delivery;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Controlador de producto de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductReportDeliveryController extends SEIPController {

    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $productGroupDeliveryId = $request->get("productGroup");
        
        if ($productGroupDeliveryId > 0) {
            $em = $this->getDoctrine()->getManager();
            $productGroupDelivery = $em->find("Pequiven\SEIPBundle\Entity\Delivery\productGroupDelivery", $productGroupDeliveryId);
            $entity->setProductGroupDelivery($productGroupDelivery);
        }
        
        return $entity;
    }

}
