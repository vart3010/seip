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
        if($level > Rol::ROLE_GENERAL_COMPLEJO){
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
    
    /**
     * Retorna si tiene permiso para acceder a una plantilla de reporte, de acuerdo 
     * @param User $user
     * @param type $typeOfCompany
     * @return boolean
     */
    public function hasReportTemplatesByTypeOfCompany(User $user, $typeOfCompany = \Pequiven\SEIPBundle\Entity\CEI\Company::TYPE_OF_COMPANY_MATRIZ){
        $hasReportTemplateByTypeCompany = false;
        $reportTemplates = $user->getReportTemplates();
        foreach($reportTemplates as $reportTemplate){
            if($reportTemplate->getCompany()->getTypeOfCompany() == $typeOfCompany){
                $hasReportTemplateByTypeCompany = true;
                break;
            }
        }
        return $hasReportTemplateByTypeCompany;
    }
    
    protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
