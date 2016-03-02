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
        
        //Determinamos los Items Disponibles del tipo compromiso para Evaluar a la persona
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
        
        //Determinamos los Items Disponibles del tipo compromiso para Evaluar a la persona
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
    
    
    public function obtainProfileItemsWithWeight(OnePerTen $onePerTen,$profileItemsAvailables = array()){
        
        //Determinamos los Valores Porcentuales para los Items Disponibles del tipo compromiso para Evaluar a la persona
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        
        //Determinamos los Valores Porcentuales para los Items Disponibles del tipo elecciones para Evaluar a la persona
        if($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['weight']/$profileItemsAvailables[OnePerTen::TYPE_ELECCIONES]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['weight']/$profileItemsAvailables[OnePerTen::TYPE_ELECCIONES]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['weight']/$profileItemsAvailables[OnePerTen::TYPE_ELECCIONES]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['weight']/$profileItemsAvailables[OnePerTen::TYPE_ELECCIONES]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['weight']/$profileItemsAvailables[OnePerTen::TYPE_ELECCIONES]['totalWeight'])*100.0,2);
        }
        
        return $profileItemsAvailables;
    }
    
    public function obtainProfileItemsWithResult(OnePerTen $onePerTen,$profileItemsWithWeight = array(), $members = array()){
        $profileItemsWithResult = $profileItemsWithWeight;
        
        //Determinamos los Valores Porcentuales para los Items Disponibles del tipo compromiso para Evaluar a la persona
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['enabled']){
            if($onePerTen->getFref() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['enabled']){
            if($onePerTen->getPsuv() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['enabled']){
            if($onePerTen->getEsperanza() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['enabled']){
            if($onePerTen->getIntPsuv() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['enabled']){
            if($onePerTen->getUbch() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['enabled']){
            if($onePerTen->getVanguardia() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['enabled']){
            if($onePerTen->getCutl() == 1 || $onePerTen->getSala() == 1 || $onePerTen->getCne() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL_SALA_CNE]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['enabled']){
            if($onePerTen->getReubicado() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['enabled']){
            if(count($members) > 0){
                $efectividad = (float)$this->obtainEfficiencyOnePerTen($members);
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['resultWithPercentage'] = round(($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['percentageValue']*$efectividad)/100,2);
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['enabled']){
            if($onePerTen->getOnePerTenPsuv() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['enabled']){
            if($onePerTen->getMemberOnePerTenPsuv() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['enabled']){
            if($onePerTen->getVoto() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['enabled']){
            if($onePerTen->getFirmaCompromiso() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::FIRMA_COMPROMISO]['resultWithPercentage'];
        }
        
        //Determinamos los Valores Porcentuales para los Items Disponibles del tipo elecciones para Evaluar a la persona
        if($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['enabled']){
            if($onePerTen->getVpresidencial1() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['enabled']){
            if($onePerTen->getVregionales() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['enabled']){
            if($onePerTen->getVpresidencial2() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['enabled']){
            if($onePerTen->getVmunicipales() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['enabled']){
            if($onePerTen->getVasamblea6() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['resultWithPercentage'];
        }
        
        //Obtenemos el Resultado Global
        $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] = round(($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult']*$profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['weightGlobal'])/100,2)+round(($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult']*$profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['weightGlobal'])/100,2);
        //Obtenemos el Puntaje del Perfil
        $profileItemsWithResult = $this->evaluateProfileResult($profileItemsWithResult);
        
        return $profileItemsWithResult;
    }
    
    public function evaluateProfileResult($profileItemsWithResult = array()){
        
        if($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] > 80){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 1;
        } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] <= 80 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] > 60){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 2;
        } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] <= 60 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] > 40){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 3;
        } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] <= 40 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] > 20){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 4;
        } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] <= 20){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 5;
        }
        
        return $profileItemsWithResult;
    }
    
    public function obtainEfficiencyOnePerTen($members = array()){
        
        $efectividad = number_format(0, 2, ',', '.') . '%';
        if(count($members) > 0){
            $contVotos = 0;
            $totalMiembros = count($members);
            foreach($members as $member){
                $contVotos = $member['voto'] == "Sí" ? $contVotos+1 : $contVotos;
            }
            $efectividad = number_format(($contVotos/$totalMiembros)*100, 2, ',', '.') . '%';
        }
        
        return $efectividad;
    }

    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
