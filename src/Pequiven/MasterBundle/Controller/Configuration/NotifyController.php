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
class NotifyController extends ResourceController{
	public function indexAction(Request $request){
		return $this->render('PequivenMasterBundle:Configuration:index.html.twig');
	}

	function getProgramAction(Request $request){
		$response = new JsonResponse();
        $query = $request->get('query');
        $results = array();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $repository = $this->get('pequiven_seip.repository.arrangementprogram');
        $dataArrangementProgram = $repository->findAll();
        
        if (!$dataArrangementProgram) {
            throw $this->createNotFoundException();
        }
        
        $criteria = array(                                  
            'ref' => $query,
            'description' => $query,
        );
        $data = [];
        $results = $this->get('pequiven_seip.repository.arrangementprogram')->findToArrangementProgramsStrategic($dataArrangementProgram, $criteria);
        $id = $ref = $description = [];
        $data[] = ['count'=>count($id),'program'=>true];//seteo de data para saber que la consulta es de programa
        foreach ($results as $valueProgram) {
            $data[] = ['id'=>$valueProgram->getId(),'ref'=>$valueProgram->getRef(),'description'=>$valueProgram->getDescription()];
        }        
        $response->setData($data);
        return $response;
	}

	public function findByDataAction(Request $request){
		$response = new JsonResponse();
		$data = [];

        $filterSet = $request->get('filterSet');
		$idObject = $request->get('idObject');
		$typeObject = $request->get('typeObject');
        $em = $this->getDoctrine()->getManager();
        $id = $idUser = $user = $action = $actionId = [];
        $config = $em->getRepository("\Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification")->findBy(array('id' => $idObject, 'typeObject' => $typeObject));
        
        foreach ($config as $value) {
        	$id[] = $value->getId();
        	$idObject = $value->getId();
            if ($filterSet != 0) {
                $userConfig = $em->getRepository("\Pequiven\MasterBundle\Entity\Configurations\NotificationUser")->findBy(array('idObject' => $idObject, 'action' => $filterSet));
            }else{
                $userConfig = $em->getRepository("\Pequiven\MasterBundle\Entity\Configurations\NotificationUser")->findBy(array('idObject' => $idObject));
            }            

        	foreach ($userConfig as $userC) {
	        	$idUser[] = $userC->getId();        	
	        	$user[] = $userC->getUser()->getFullNameUser();        	
	        	$actionId[] = $userC->getAction();
	        	$action[] = ConfigurationNotification::getActions()[$userC->getAction()];        			        	
        	}
        }
        
        $data = [
        	'id'         => $id,
        	'idUser'     => $idUser,
        	'user'       => $user,
        	'actionId'     => $actionId,
        	'action'     => $action,
        	'count'      => count($idUser),
        	'idObject'   => $idObject,
        	'typeObject' => $typeObject
        ];

		$response->setData($data);
        return $response;
	}

	public function setDataUsersAction(Request $request){
		$response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();

		$action = $request->get('action');
		$idObject = $request->get('idObject');
		$user = $this->get('pequiven_seip.repository.user')->find($request->get('user'));
        $config = $em->getRepository("\Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification")->find($idObject);
        if (count($config) === 0) {
			$em = $this->getDoctrine()->getManager();
			$config = new ConfigurationNotification;
			$config->setId($idObject);
			$config->setTypeObject(2);
			$config->setLevelObject(0);
	 		$em->persist($config);            
	        $em->flush();        	
        }
		
		$configUser = new NotificationUser;        
		$configUser->setAction($action);
		$configUser->setUser($user);
		$configUser->setIdObject($config);
		$em->persist($configUser);            
        $em->flush();

        $response->setData(true);
        return $response;		
	}
    
    public function deleteDataUsersAction(Request $request){
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        //$user = $this->get('pequiven_seip.repository.user')->find($request->get('idUser'));        
        $userConfig = $em->getRepository("\Pequiven\MasterBundle\Entity\Configurations\NotificationUser")->find($request->get('idUser'));
        if($userConfig){
            $em->remove($userConfig);
            $em->flush();            
            //$this->get('session')->getFlashBag()->add('success', $this->trans('flashes.messages.deleteCauseAnalysis', array(), 'PequivenSIGBundle'));
            $response->setData(array('message'=>'Usuario eliminado exirosamente.'));
        }  
        return $response;
    }

	public function setDataSession(Request $request){
		// set and get session attributes		
		$session = $request->getSession();
		$data = ['foo'=>'Maximo', 'bar'=>'Sojo'];
    	$session->set('max',$data);
    	$foo = $session->get('max');
		var_dump($foo);
		die();
    	$filters = $session->get('filters', array());
	}
}