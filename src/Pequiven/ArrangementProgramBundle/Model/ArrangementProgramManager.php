<?php

namespace Pequiven\ArrangementProgramBundle\Model;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Manejador del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class ArrangementProgramManager implements ContainerAwareInterface {

    private $container;

    /**
     * Evalua si el usuario logeado tiene permisos para revisar el programa de gestion
     * @param ArrangementProgram $entity
     * @return boolean
     */
    public function isAllowToReview(ArrangementProgram $entity) {
        $valid = false;
        $user = $this->getUser();
        if ($entity->getCategoryArrangementProgram()->getId() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {
            $configuration = $entity->getTacticalObjective()->getGerencia()->getConfiguration();
            if (!$configuration) {
                return $valid;
            }

            if ($this->getSecurityConext()->isGranted(array('ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_TACTIC', 'ROLE_SEIP_ARRANGEMENT_PROGRAM_CREATE_OPERATIVE'))) {
                $valid = true;
            }

            foreach ($configuration->getArrangementProgramUserToRevisers() as $userToReviser) {
                if ($user === $userToReviser) {
                    $valid = true;
                    break;
                }
            }
        } else {
            $gerencia = $this->container->get('pequiven.repository.gerenciafirst')->findOneBy(array('abbreviation' => 'sigco'));
            $configuration = $gerencia->getConfiguration();
            foreach ($configuration->getArrangementProgramSigUsersToReviser() as $userSigToReviser) {
                if ($user === $userSigToReviser) {
                    $valid = true;
                    break;
                }
            }
        }
        return $valid;
    }

    /**
     * Evalua si el usuario logeado tiene permisos para aprobar el programa de gestion
     * @param ArrangementProgram $entity
     * @return boolean
     */
    public function isAllowToApprove(ArrangementProgram $entity) {

        $valid = false;
        $user = $this->getUser();

        if ($entity->getCategoryArrangementProgram()->getId() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {
            $configuration = $entity->getTacticalObjective()->getGerencia()->getConfiguration();

            if (!$configuration) {
                return $valid;
            }
            if ($entity->getStatus() == ArrangementProgram::STATUS_REJECTED || $entity->getStatus() == ArrangementProgram::STATUS_APPROVED) {
                return $valid;
            }

            if ($entity->getType() === ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC && $configuration->getArrangementProgramUsersToApproveTactical()->contains($user) === true && $entity->getTacticalObjective()->getStatus() == true) {
                $valid = true;
            }
            if ($entity->getType() === ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE && $configuration->getArrangementProgramUsersToApproveOperative()->contains($user) === true && $entity->getTacticalObjective()->getStatus() == true && $entity->getOperationalObjective()->getStatus() == true) {
                $valid = true;
            }
        } else {
            $gerencia = $this->container->get('pequiven.repository.gerenciafirst')->findOneBy(array('abbreviation' => 'sigco'));
            $configuration = $gerencia->getConfiguration();
            if ($configuration->getArrangementProgramSigUsersToApprove()->contains($user) === true) {
                $valid = true;
            }
        }
        return $valid;
    }

    /**
     * Evalua si el usuario logeado tiene permisos para enviar el programa de gestion a revision
     * @param ArrangementProgram $entity
     * @return boolean
     */
    public function isAllowToSendToReview(ArrangementProgram $entity) {
        $user = $this->getUser();
        $valid = false;
        if (($entity->getStatus() === ArrangementProgram::STATUS_DRAFT) &&
                ($entity->getCreatedBy() === $user || $this->isAllowToReview($entity) === true || $this->isAllowToApprove($entity) === true)
        ) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Evalua si el usuario logeado tiene permisos para regresar el programa de gestion a borrador
     * @param ArrangementProgram $entity
     * @return boolean
     */
    public function isAllowToSendToDraft(ArrangementProgram $entity) {
        $user = $this->getUser();
        $valid = false;
        if ((($entity->getStatus() === ArrangementProgram::STATUS_IN_REVIEW) &&
                ($entity->getCreatedBy() === $user || $this->isAllowToReview($entity) === true || $this->isAllowToApprove($entity) === true)) || ($user->isAllowSuperAdmin() || $this->isGranted(array('ROLE_SEIP_ARRANGEMENT_PROGRAM_RETURN_TO_DRAFT')))
        ) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Evalua si el usuario logeado tiene permisos para regresar el programa de gestion a borrador
     * @param ArrangementProgram $entity
     * @return boolean
     */
    public function isAllowReturnToReview(ArrangementProgram $entity) {
        $user = $this->getUser();
        $valid = false;
        if (($entity->getStatus() === ArrangementProgram::STATUS_REVISED) &&
                ($entity->getCreatedBy() === $user || $this->isAllowToReview($entity) === true || $this->isAllowToApprove($entity) === true)
        ) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Evalua si el usuario logueado tiene permisos para actualizar el programa
     * @param type $entity
     * @throws type
     */
    public function hasPermissionToUpdate(ArrangementProgram $entity) {
        //Security check
        $permission = true;
        $user = $this->getUser();
        if ($entity->getCreatedBy() !== $user && $this->isAllowToApprove($entity) === false && $this->isAllowToReview($entity) === false) {
            $permission = false;
        }
        if ($entity->getStatus() === ArrangementProgram::STATUS_APPROVED || $entity->getStatus() === ArrangementProgram::STATUS_REJECTED) {
            $permission = false;
        }
        if ($entity->getStatus() === ArrangementProgram::STATUS_APPROVED && (($this->getSecurityConext()->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS_POST_MORTEM')) || ($this->getSecurityConext()->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_MOVEMENT_GOALS')))) {
            $permission = true;
        }
//        if($this->getSecurityConext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_EDIT')){
//            $permission = true;
//        }
        if ($this->getSecurityConext()->isGranted('ROLE_SEIP_PLANNING_ARRANGEMENT_PROGRAM_EDIT')) {
            $permission = true;
        }
        return $permission;
    }

    /**
     * Evalua si el usuario logueado tiene permisos para actualizar el programa
     * @param type $entity
     * @throws type
     */
    public function hasPermissionToAddComment(ArrangementProgram $entity) {
        //Security check
        $permission = true;
        $user = $this->getUser();
        if ($entity->getCreatedBy() !== $user && $this->isAllowToApprove($entity) === false && $this->isAllowToReview($entity) === false && $this->isAllowToNotity($entity) === false) {
            $permission = false;
        }
        if ($entity->getStatus() === ArrangementProgram::STATUS_REJECTED) {
            $permission = false;
        }
        return $permission;
    }

    /**
     * Verifica que se pueba aprobar un programa de gestion
     * @param \Pequiven\ArrangementProgramBundle\Model\ArrangementProgram $entity
     * @return boolean
     */
    public function isYouCanApprove(ArrangementProgram $entity) {
        $summary = $entity->getSummary();
        $valid = false;
        if (bccomp($summary['advancesPlanned'], 100) == 0) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Verifica que se pueda enviar un programa de gestion a revision
     * @param \Pequiven\ArrangementProgramBundle\Model\ArrangementProgram $entity
     * @return boolean
     */
    public function isYouCanSendInRevision(ArrangementProgram $entity) {
        $summary = $entity->getSummary();
        $valid = false;
        if (bccomp($summary['advancesPlanned'], 100) == 0) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Evalua si el usuario logeado tiene permisos para notificar avancess en el programa de gestion
     * @param ArrangementProgram $entity
     * @return boolean
     */
    public function isAllowToNotity(\Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram $entity) {
        $configuration = $entity->getTacticalObjective()->getGerencia()->getConfiguration();
        $details = $entity->getDetails();
        $valid = false;
        if (!$configuration) {
            return $valid;
        }
        $user = $this->getUser();

        $periodService = $this->getPeriodService();
//        var_dump($periodService->isAllowNotifyArrangementProgram());die();
        if ($entity->getCategoryArrangementProgram()->getId() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {
            if (
                    $configuration->getArrangementProgramUsersToNotify()->contains($user) === true && $entity->getStatus() == ArrangementProgram::STATUS_APPROVED && $periodService->isAllowNotifyArrangementProgram() === true && ($details->getLastNotificationInProgressByUser() === null || $entity->getResult() == 0 || (($entity->getResult() > 0 || $entity->getResult() < 0) && $details->getNotificationInProgressByUser() === null) || ((($entity->getResult() > 0 || $entity->getResult() < 0) && $details->getNotificationInProgressByUser()->getId() === $user->getId())))
            ) {
                if ($periodService->isAllowNotifyArrangementProgramInClearance() === true) {
                    $valid = true;
                } elseif ($periodService->isAllowNotifyArrangementProgram() === true) {
                    $valid = true;
                }
            }
//            elseif($entity->getStatus() == ArrangementProgram::STATUS_DRAFT && $this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CHARGE_PLAN')){
//                $valid = true;
//            }
        } else {
            $gerencia = $this->container->get('pequiven.repository.gerenciafirst')->findOneBy(array('abbreviation' => 'sigco'));
            $configuration = $gerencia->getConfiguration();
            if (
                    $configuration->getArrangementProgramSigUsersToNotify()->contains($user) === true && $entity->getStatus() == ArrangementProgram::STATUS_APPROVED && ($details->getLastNotificationInProgressByUser() === null || $entity->getResult() == 0)
            ) {
                if ($periodService->isAllowNotifyArrangementProgramInClearance() === true) {
                    $valid = true;
                } elseif ($periodService->isAllowNotifyArrangementProgram() === true) {
                    $valid = true;
                }
            } elseif ($entity->getStatus() == ArrangementProgram::STATUS_DRAFT && $this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CHARGE_PLAN')) {
                $valid = true;
            }
        }
        
//        if($this->isGranted('ROLE_SEIP_PLANNING_OPERATION_ARRANGEMENT_PROGRAM_NOTIFY'))
//        {
//            $valid = true;
//        }
//        if($this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CHARGE_PLAN'))
//        {
//            $valid = true;
//        }

        return $valid;
    }

    /**
     * Evalua si el usuario logueado tiene permisos para notificar en el programa
     * @param type $entity
     * @throws type
     */
    public function hasPermissionToNotify(ArrangementProgram $entity) {
        //Security check
        $permission = true;
        $user = $this->getUser();
        if (!$this->isGranted('ROLE_SEIP_ARRANGEMENT_PROGRAM_CHARGE_PLAN')) {
            if ($entity->isNotificable() === false ||
                    ($this->isAllowToNotity($entity) === false)
            ) {
                $permission = false;
            }
        }

        return $permission;
    }

    /**
     * Evalua si el usuario logueado tiene permisos para notificar en el programa
     * @param type $entity
     * @throws type
     */
    public function hasPermissionToPlanned(ArrangementProgram $entity) {
        //Security check
        $user = $this->getUser();
        $permission = true;
        if (
                $entity->isPlanneable() === false ||
                ($this->isAllowToNotity($entity) === false &&
                $this->isAllowToApprove($entity) == false &&
                $this->isAllowToReview($entity) == false &&
                $entity->getCreatedBy() !== $user) === true) {
            $permission = false;
        }
        return $permission;
    }

    /**
     * Evalua si tiene permiso para eliminar el programa de gestion
     * 
     * @param \Pequiven\ArrangementProgramBundle\Model\ArrangementProgram $entity
     * @return boolean
     */
    function isAllowToDelete(ArrangementProgram $entity) {
        //Security check
        $user = $this->getUser();
        $valid = false;
        if (($entity->getCreatedBy() === $user && $entity->getStatus() == ArrangementProgram::STATUS_DRAFT) || ($this->getSecurityConext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_DELETE') && $entity->getStatus() == ArrangementProgram::STATUS_DRAFT)) {
            $valid = true;
        }
        return $valid;
    }

    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     */
    public function getUser() {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * 
     * @return \Symfony\Component\Security\Core\SecurityContext
     * @throws \LogicException
     */
    private function getSecurityConext() {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context');
    }

    /**
     * @return \Pequiven\SEIPBundle\Service\PeriodService
     */
    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    private function isGranted($roles) {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.context')->isGranted($roles);
    }

}
