<?php

namespace Pequiven\MasterBundle\Controller\Configuration;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tecnocreaciones\Bundle\ResourceBundle\Controller\ResourceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;

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
        foreach ($results as $valueProgram) {
            $data[] = ['id'=>$valueProgram->getId(),'ref'=>$valueProgram->getRef(),'description'=>$valueProgram->getDescription()];
        }        
        $data[] = ['count'=>count($id)];        
        $response->setData($data);
        return $response;
	}

	public function findByDataAction(Request $request){
		$response = new JsonResponse();
		$data = [];

		$idObject = $request->get('idObject');
		$typeObject = $request->get('typeObject');
        $em = $this->getDoctrine()->getManager();                        
        $config = $em->getRepository("\Pequiven\MasterBundle\Entity\Configurations\ConfigurationNotification")->findBy(array('idObject' => $idObject, 'typeObject' => $typeObject));
        		
		$response->setData($data);
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