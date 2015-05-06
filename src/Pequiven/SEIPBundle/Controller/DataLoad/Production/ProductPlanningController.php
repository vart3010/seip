<?php
/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad\Production;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de planificacion de productos
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductPlanningController extends SEIPController
{
    public function deleteAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $resource = $this->findOr404($request);
        
        $url = $this->generateUrl("pequiven_product_report_show",array(
            "id" => $resource->getProductReport()->getId(),
        ));
        
        $this->domainManager->delete($resource);
        return $this->redirect($url);
    }
}