<?php

namespace Pequiven\MasterBundle\Controller\Configuration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;

use Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification;


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

		$idObject = $request->get('idObject');
		$typeObject = $request->get('typeObject');
        $em = $this->getDoctrine()->getManager();
        $id = $user = $action = [];
        $config = $em->getRepository("\Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification")->findBy(array('idObject' => $idObject, 'typeObject' => $typeObject));
        
        foreach ($config as $value) {
        	$id[] = $value->getId();
        	$user[] = $value->getUser()->getFullNameUser();
        	$action[] = ConfigurationNotification::getActions()[$value->getAction()];
        }
        
        $data = [
        	'id'         => $id,
        	'user'       => $user,
        	'action'     => $action,
        	'count'      => count($id),
        	'idObject'   => $idObject,
        	'typeObject' => $typeObject
        ];

		$response->setData($data);
        return $response;
	}

	public function setDataUsersAction(Request $request){
		$response = new JsonResponse();

		$action = $request->get('action');
		$idObject = $request->get('idObject');
		$user = $this->get('pequiven_seip.repository.user')->find($request->get('user'));

		$em = $this->getDoctrine()->getManager();
		$config = new ConfigurationNotification;
		$config->setAction($action);
		$config->setTypeObject(2);
		$config->setIdObject($idObject);
		$config->setLevelObject(0);
		$config->setUser($user);
 		$em->persist($config);            
        $em->flush();

        $response->setData(true);
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