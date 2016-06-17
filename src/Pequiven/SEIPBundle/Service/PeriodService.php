<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Servicio para obtener datos del periodo (pequiven_seip.service.period)
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PeriodService extends ContainerAware {

    /**
     * Retorna si se encuetra habilitada la notificacion del programa de gestion para el periodo activo.
     * @return boolean
     */
    function isAllowNotifyArrangementProgram() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();

        $periodsAll = $this->getPeriodsAvailableConsultation();
        if (
                ($now >= $period->getDateStartNotificationArrangementProgram() && $now <= $period->getDateEndNotificationArrangementProgram())
        ) {
            $result = true;
        }
//        else{
//            foreach($periodsAll as $itemPeriod){
//                if($period->getId() == $itemPeriod->getId()){
//                    if($itemPeriod->getStatus() == 1){
//                        $result = true;
//                    }
//                }
//            }
//        }

        return $result;
    }

    /**
     * Puede notificar en periodo de holgura
     * @return boolean
     */
    function isAllowNotifyArrangementProgramInClearance() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();
        if ($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_OPERATION_NOTIFY_CLEARANCE') && ($now >= $period->getDateStartClearanceNotificationArrangementProgram() && $now <= $period->getDateEndClearanceNotificationArrangementProgram())) {
            $result = true;
        }
        return $result;
    }

    /**
     * Evalua si se debe aplicar la penalizacion al resultado
     * @return boolean
     */
    function isPenaltyInResult(\DateTime $dateToEvaluate = null) {
        if ($dateToEvaluate === null) {
            return false;
        }
        $period = $this->getPeriodActive();
        $r = ($dateToEvaluate >= $period->getDateStartPenalty() && $dateToEvaluate <= $period->getDateEndPenalty());
        return $r;
    }

    /**
     * Retorna si se encuetra habilitada la carga de programa de gestion para el periodo activo.
     * @return boolean
     */
    function isAllowLoadArrangementProgram() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();
        $periodsAll = $this->getPeriodsAvailableConsultation();

        if (($now >= $period->getDateStartLoadArrangementProgram() && $now <= $period->getDateEndLoadArrangementProgram())) {
            $result = true;
        } else {
            foreach ($periodsAll as $itemPeriod) {
                if ($itemPeriod->getOpened() == 1 && $itemPeriod->getId() == $period->getId()) {
                    if ($now >= $itemPeriod->getDateStartLoadArrangementProgram() && $now <= $itemPeriod->getDateEndLoadArrangementProgram()) {
                        $result = true;
                    }
                }
            }
        }

        if ($period->getName() == '2016' && ($this->getUser()->getId() == 104 || $this->getUser()->getId() == 103 || $this->getUser()->getId() == 295 || $this->getUser()->getId() == 4642 || $this->getUser()->getId() == 110 || $this->getUser()->getId() == 63)) {
            $result = true;
        }

//        var_dump($period->getName());die();
        return $result;
    }

    /**
     * Retorna si se encuetra habilitada la carga de programa de gestion para SIG en el periodo activo.
     * @return boolean
     */
    function isAllowLoadSigArrangementProgram() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();

        if ($now >= $period->getDateStartLoadSigArrangementProgram() && $now <= $period->getDateEndLoadSigArrangementProgram()) {
            $result = true;
        }
        return $result;
    }

    /**
     * Retorna si se encuetra habilitada la carga de objetivos para el periodo activo.
     * @return boolean
     */
    function isAllowLoadObjetive() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();

        $periodsAll = $this->getPeriodsAvailableConsultation();
        if ($now >= $period->getDateStartLoadObjetive() && $now <= $period->getDateEndLoadObjetive()) {
            $result = true;
        } else {
            foreach ($periodsAll as $itemPeriod) {
                if ($itemPeriod->getOpened() == 1 && $itemPeriod->getId() == $period->getId()) {
                    if ($now >= $itemPeriod->getDateStartLoadObjetive() && $now <= $itemPeriod->getDateEndLoadObjetive()) {
                        $result = true;
                    }
                }
            }
        }
        
        $user = $this->getUser();
        if ($period->getName() == '2016' && ($user->getId() == 100 || $user->getId() == 110)) {
            $result = true;
        }


        return $result;
    }

    /**
     * Retorna si se encuetra habilitada la carga de indicadores para el periodo activo.
     * @return boolean
     */
    function isAllowLoadIndicator() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();

        $periodsAll = $this->getPeriodsAvailableConsultation();
        if ($now >= $period->getDateStartLoadIndicator() && $now <= $period->getDateEndLoadIndicator()) {
            $result = true;
        } else {
            foreach ($periodsAll as $itemPeriod) {
                if ($itemPeriod->getOpened() == 1 && $itemPeriod->getId() == $period->getId()) {
                    if ($now >= $itemPeriod->getDateStartLoadIndicator() && $now <= $itemPeriod->getDateEndLoadIndicator()) {
                        $result = true;
                    }
                }
            }
        }
        
        $user = $this->getUser();
        if ($period->getName() == '2016' && ($user->getId() == 64)) {
            $result = true;
        }

        return $result;
    }

    /**
     * Retorna si se encuetra habilitada la carga de Circulos de Estudio y Trabajo para el periodo activo.
     * @return boolean
     */
    function isAllowLoadWorkStudyCircle() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();

        if ($now >= $period->getDateStartLoadWorkStudyCircle() && $now <= $period->getDateEndLoadWorkStudyCircle()) {
            $result = true;
        }

        return $result;
    }

    /**
     * Retorna si se encuetra habilitada la carga de planificacion de plantas
     * @return boolean
     */
    function isAllowPlanningReport() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();


        if ($period->getIsPlanningReportEnabled() === true && $now >= $period->getDateStartPlanningReport() && $now <= $period->getDateEndPlanningReport()) {
            $result = true;
        }

        $user = $this->getUser();
        if ($period->getName() == '2016' && ($user->getId() == 330 || $user->getId() == 5816 || $user->getId() == 104)) {
            $result = true;
        }

        return $result;
    }

    /**
     * Retorna si se encuetra habilitada la carga de grupos de productos 
     * @return boolean
     */
    function isAllowPlanningGroupProduct() {
        $result = false;
        $period = $this->getPeriodActive();
        $now = new \DateTime();

        if ($period->getIsLoadGroupProductEnabled() === true && $now >= $period->getDateStartLoadGroupProduct() && $now <= $period->getDateEndLoadGroupProduct()) {
            $result = true;
        }

        $user = $this->getUser();
        if ($period->getName() == '2016' && ($user->getId() == 1668 || $user->getId() == 1798 || $user->getId() == 5816)) {
            $result = true;
        }


        return $result;
    }

    /**
     * Retorna el periodo activo
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    public function getPeriodActive($type = \Pequiven\SEIPBundle\Entity\Period::VIEW_ALL_PERIODS) {
        $request = $this->getRequest();
        $session = $request->getSession();
        $periodActiveSerialize = $session->get('periodActiveSerialize');
        $periodRepository = $this->getRepository();
        $period = null;
//        if($periodActiveSerialize !== null){
//            $period = unserialize($periodActiveSerialize);
//            if($period){
//                $class = get_class($period);
//                if (true === $pos = strrpos($class, '\\'.\Doctrine\Common\Persistence\Proxy::MARKER.'\\')) {
////                    $period = $this->getDoctrine()->getManager()->merge($period);
//                    $period = $periodRepository->find($period->getId());
//                }
//            }
//        }
        if (!$period && (($type == \Pequiven\SEIPBundle\Entity\Period::VIEW_ALL_PERIODS) || ($type == \Pequiven\SEIPBundle\Entity\Period::VIEW_ONLY_PERIOD_ACTIVE))) {
            $period = $this->getUser()->getPeriod();
        }
        if (!$period) {
            $period = $periodRepository->findOneActive();
        }
//        $period = $periodRepository->find($period->getId());
//        var_dump($periodActiveSerialize);
//        var_dump($period);
//        var_dump($period->getName());
//        var_dump($period);
//        die;

        return $period;
    }

    /**
     * Guardar el perido activo que selecciono el usuario
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     */
    function setPeriodActive(\Pequiven\SEIPBundle\Entity\Period $period) {
        $request = $this->getRequest();
        $session = $request->getSession();
        $periodSerialize = serialize($period);
        $session->set('periodActiveSerialize', $periodSerialize);
        $user = $this->getUser();
        $user->setPeriod($period);
        $this->getUserManager()->updateUser($user);
    }

    /**
     * Retorna la entidad del periodo activo para persistir en la base de datos la relacion
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    public function getEntityPeriodActive($forPersist = false) {
        $period = $this->getPeriodActive();
//        $periodRepository = $this->getRepository();
//        return $periodRepository->find($period->getId());
        return $period;
    }

    /**
     * Retornando si esta abierto o no, el periodo activo
     * @return type
     * @throws Exception
     */
    public function isOpened() {
        $periodActive = $this->getPeriodActive(\Pequiven\SEIPBundle\Entity\Period::VIEW_ONLY_PERIOD_ACTIVE);
        if ($periodActive === null) {
            throw new Exception("No hay periodo activo.");
        }

        return $periodActive->isOpened();
    }

    /**
     * Lanza una excepcion de seguridad si el periodo no se encuentra abierto
     * 
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function checkIsOpen() {
        if ($this->isOpened() === false) {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException(sprintf('El periodo "%s", se encuentra cerrado.', (string) $this->getPeriodActive()));
        }
    }

    /**
     * Limpia de la cache el periodo selecionado
     */
    public function clearCachePeriodActive() {
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->remove('periodActiveSerialize');
    }

    /**
     * Retorna el periodo siguiente
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    public function getNextPeriod() {
        $nextPeriod = null;
        $periodActive = $this->getEntityPeriodActive();
        if ($periodActive) {
            $nextPeriod = $periodActive->getChild();
        }
        return $nextPeriod;
    }

    /**
     * Retorna la lista de periodos disponibles para consultar
     * @return type
     */
    public function getPeriodsAvailableConsultation() {
        return $this->getRepository()->findAll();
    }

    public function getListArrayPeriodsAvailableConsultation($type = \Pequiven\SEIPBundle\Entity\Period::VIEW_ALL_PERIODS) {
        $request = $this->getRequest();
        $session = $request->getSession();
        if ($type == \Pequiven\SEIPBundle\Entity\Period::VIEW_ALL_PERIODS) {
            $listArrayPeriods = $session->get('listPeriods');
        } else {
            $listArrayPeriods = array();
        }
        if ($listArrayPeriods !== null) {
            return $listArrayPeriods;
        }

        if ($type == \Pequiven\SEIPBundle\Entity\Period::VIEW_ALL_PERIODS) {
            $periods = $this->getPeriodsAvailableConsultation();
        } else {
            $periods = $this->getPeriodActive($type);
        }

        foreach ($periods as $period) {
            $listArrayPeriods[] = array(
                'id' => $period->getId(),
                'description' => (string) $period
            );
        }
        $session->set('listPeriods', $listArrayPeriods);
        return $listArrayPeriods;
    }

    public function find($id) {
        return $this->getRepository()->find($id);
    }

    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    public function getUser() {
        if (!$this->container->has('security.context')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }

    private function isGranted($roles) {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context')->isGranted($roles);
    }

    /**
     * 
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest() {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    /**
     * Repositorio del periodo
     * @return \Pequiven\SEIPBundle\Repository\PeriodRepository
     */
    private function getRepository() {
        return $this->container->get('pequiven.repository.period');
    }

    /**
     * @return \FOS\UserBundle\Model\UserManager
     */
    private function getUserManager() {
        return $this->container->get('fos_user.user_manager');
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
