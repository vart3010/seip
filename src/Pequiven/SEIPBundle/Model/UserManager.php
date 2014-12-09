<?php

namespace Pequiven\SEIPBundle\Model;

use Pequiven\MasterBundle\Entity\Rol;
use Pequiven\SEIPBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Manejador de usuario
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class UserManager implements ContainerAwareInterface
{
    private $container;
    
    /**
     * Retorna true si tiene permisos de acceder al filtro de localidad
     * 
     * @param User $user
     * @return boolean
     */
    public function isAllowFilterComplejo(User $user) {
        $level = $user->getLevelRealByGroup();
        if($level >= Rol::ROLE_GENERAL_COMPLEJO){
            return true;
        }
        return false;
    }
    
    /**
     * Retorna true si tiene permisos de acceder al filtro de gerencia de primera linea
     * @param User $user
     * @return boolean
     */
    public function isAllowFilterFirstLineManagement(User $user) {
        $level = $user->getLevelRealByGroup();
        if($level > Rol::ROLE_MANAGER_FIRST){
            return true;
        }
        return false;
    }
    
    /**
     * Retorna true si tiene permisos de acceder al filtro de gerencia de segunda linea
     * @param User $user
     * @return boolean
     */
    public function isAllowFilterManagementSecondLine(User $user) {
        $level = $user->getLevelRealByGroup();
        
        if($level > Rol::ROLE_MANAGER_SECOND){
                return true;
            }
        return false;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
