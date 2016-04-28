<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad\Production;

use Pequiven\SEIPBundle\Controller\SEIPController;

/**
 * Controlador de detalles de produccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ProductDetailDailyMonthController extends SEIPController 
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
    
    public function calculateAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $resource = $this->findOr404($request);
        $resource->preUpdate();
        $this->save($resource,true);
        return $this->redirectHandler->redirectTo($resource);
    }
}
