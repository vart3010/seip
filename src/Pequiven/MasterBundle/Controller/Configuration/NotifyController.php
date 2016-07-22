<?php

namespace Pequiven\MasterBundle\Controller\Configuration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * 
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class NotifyController extends ResourceController{
	public function indexAction(Request $request){
		return $this->render('PequivenMasterBundle:Configuration:index.html.twig');
	}
}