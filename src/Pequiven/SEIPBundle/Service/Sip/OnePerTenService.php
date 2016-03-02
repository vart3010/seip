<?php

namespace Pequiven\SEIPBundle\Service\Sip;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\SEIPBundle\Entity\Sip\OnePerTen;

/**
 * Description of OnePerTenService
 ** service seip.service.onePerTen
 */
class OnePerTenService {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function obtainProfileItemsAvailables(OnePerTen $onePerTen){
        $profileItems = OnePerTen::getArrayOfProfile();
        
        //Determinamos los Items Disponibles del tipo compromiso para Evaluarle a la persona
        if($onePerTen->getFref() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['weight'];
        }
        if($onePerTen->getPsuv() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['weight'];
        }
        if($onePerTen->getEsperanza() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['weight'];
        }
        if($onePerTen->getIntPsuv() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['weight'];
        }
        if($onePerTen->getUbch() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['weight'];
        }
        if($onePerTen->getVanguardia() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['weight'];
        }
        if($onePerTen->getCutl() != -1 || $onePerTen->getSala() != -1 || $onePerTen->getCne() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['weight'];
        }
        if($onePerTen->getReubicado() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['weight'];
        }
        if(!is_null($onePerTen)){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['weight'];
        }
        if($onePerTen->getOnePerTenPsuv() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['weight'];
        }
        if($onePerTen->getMemberOnePerTenPsuv() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['weight'];
        }
        if($onePerTen->getVoto() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['weight'];
        }
        if($onePerTen->getFirmaCompromiso() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['weight'];
        }
        
        //Determinamos los Items Disponibles del tipo compromiso para Evaluarle a la persona
        if($onePerTen->getVpresidencial1() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['weight'];
        }
        if($onePerTen->getVregionales() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['weight'];
        }
        if($onePerTen->getVpresidencial2() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['weight'];
        }
        if($onePerTen->getVmunicipales() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['weight'];
        }
        if($onePerTen->getVasamblea6() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['weight'];
        }
        
        return $profileItems;
    }

    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
