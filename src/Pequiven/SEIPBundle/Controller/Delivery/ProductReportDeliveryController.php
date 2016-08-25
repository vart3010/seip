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
 * Controlador de productos despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class ProductReportDeliveryController extends SEIPController {

    public function createNew() {
        $entity = parent::createNew();
        $request = $this->getRequest();
        $productGroupDeliveryId = $request->get("productGroup");
        $data = array(
            "id" => $productGroupDeliveryId
        );

        if ($productGroupDeliveryId > 0) {
            $em = $this->getDoctrine()->getManager();
            $productGroupDelivery = $em->find("Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery", $data);
            $entity->setProductGroupDelivery($productGroupDelivery);
        }

        return $entity;
    }

    /**
     * 
     * @return type
     */
    protected function getPhpExcelReaderService() {
        return $this->container->get('seip.service.phpexcelreader');
    }

}
