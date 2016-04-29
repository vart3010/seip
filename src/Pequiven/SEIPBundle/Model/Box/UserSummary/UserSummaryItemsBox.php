<?php

namespace Pequiven\SEIPBundle\Model\Box\UserSummary;

/**
 * Muestra un resumen de usuario en pantalla princiapal sistema
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class UserSummaryItemsBox extends \Tecnocreaciones\Bundle\BoxBundle\Model\GenericBox {

    public function getName() {
        return 'pequiven_seip_box_user_summary_items';
    }

    public function getParameters() {
        //OBTENEMOS PROGRAMAS DE GESTION ASOCIADOS
        $criteria = array();
        $orderBy = array();
        $datosUser = null;
        $repository = $this->container->get('pequiven_seip.repository.arrangementprogram');

        $period = $this->getPeriodService()->getPeriodActive()->getName();
        
//        if ($this->getRequest()->get('numPersonal') != null) {
        if ($this->getRequest()->get('idUser') != null) {
//            $numPersonal = $this->getRequest()->get('numPersonal');
            $idUser = $this->getRequest()->get('idUser');

            //USUARIO BUSCADO Pequiven\SEIPBundle\Repository
            //$em = $this->getDoctrine()->getManager();
//            $searchUser = $this->container->get("pequiven.repository.user")->findUserByNumPersonal($numPersonal);
            $searchUser = $this->container->get("pequiven.repository.user")->find($idUser);

            $datosUser = array("nombre" => $searchUser->getFullNameUser(),"idUser"=>$searchUser->getId());
        } else {
//            $numPersonal = $this->getUser()->getNumPersonal();
            $idUser = $this->getUser()->getId();
        }
        $resultService = $this->getResultService();
//        $userItems = $resultService->getUserItems($numPersonal, $period);
        $userItems = $resultService->getUserItems($idUser, $period);

//        $groupsUsers = $this->getUser()->getGroups();
//        $securityService = $this->getSecurityService();



        return array(
            'management' => $userItems["data"]["evaluation"]["management"],
            'objetives' => $userItems["data"]["evaluation"]["results"]["objetives"],
            //'error' => $userItems["errors"],
            'datosUser' => $userItems["data"]['user'],
            'userItems'=>$userItems
        );
    }

    public function getTranslationDomain() {
        return 'PequivenSEIPBundle';
    }

    public function getDescription() {
        return 'Muestra un resumen de las metas del usuario';
    }

    public function getTemplateName() {
        return 'PequivenSEIPBundle:Monitor:User\UserSummaryItems.html.twig';
    }

    public function getAreasNotPermitted() {
        return array(
        );
    }

    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }

    /**
     * 
     * @return type
     */
    public function getResultService() {
        return $this->container->get('seip.service.result');
    }

}
