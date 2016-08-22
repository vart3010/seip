<?php

namespace Pequiven\MasterBundle\Controller\Configuration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;

use Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification;
use Pequiven\MasterBundle\Entity\Configurations\NotificationUser;


/**
 * 
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class ConfigurationController extends ResourceController{
	public function indexAction(Request $request){		
		return $this->render('PequivenMasterBundle:Configuration:config.html.twig');
	}
}