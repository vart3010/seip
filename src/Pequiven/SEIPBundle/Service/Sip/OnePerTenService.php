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
        $supportAssemblyElections = array();
        $supportAssemblyElections = $this->obtainWhichSupportAssemblyElections($onePerTen);
        
        //Determinamos los Items Disponibles del tipo Compromiso para Evaluar a la persona y para ser mostrado
        if($onePerTen->getFref() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['weight'];
        }
        if($onePerTen->getPsuv() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INSCRITO_GPP]['weight'];
        }
        if($onePerTen->getEsperanza() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::DECRETO_ESPERANZA]['weight'];
        }
        if($onePerTen->getIntPsuv() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::INTERNAS_PSUV]['weight'];
        }
        if($onePerTen->getUbch() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_UBCH]['weight'];
        }
        if($onePerTen->getVanguardia() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::VANGUARDIA_PSUV]['weight'];
        }
        if($supportAssemblyElections['cutl']['evaluate'] == true){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['weight'];
        }
        if($supportAssemblyElections['sala']['evaluate'] == true){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['weight'];
        }
        if($supportAssemblyElections['cne']['evaluate'] == true){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['weight'];
        }
        if($supportAssemblyElections['cutl']['show'] == true){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['showInList'] = true;
        }
        if($supportAssemblyElections['sala']['show'] == true){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['showInList'] = true;
        }
        if($supportAssemblyElections['cne']['show'] == true){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['showInList'] = true;
        }
        if($onePerTen->getReubicado() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REUBICACION_CNE]['weight'];
        }
        if(!is_null($onePerTen)){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PQV]['weight'];
        }
        if($onePerTen->getOnePerTenPsuv() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::PATRULLA_PSUV]['weight'];
        }
        if($onePerTen->getMemberOnePerTenPsuv() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::MIEMBRO_PATRULLA_PSUV]['weight'];
        }
        if($onePerTen->getVoto() != -1){
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['total']++;
            $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] = $profileItems[OnePerTen::TYPE_COMPROMISO]['totalWeight'] + $profileItems[OnePerTen::TYPE_COMPROMISO][OnePerTen::REPORTE_VOTO]['weight'];
        }
        
        //Determinamos los Items Disponibles del tipo Participación en las Elecciones para Evaluar a la persona
        if($onePerTen->getVpresidencial1() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2012]['weight'];
        }
        if($onePerTen->getVregionales() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_REGIONALES_2012]['weight'];
        }
        if($onePerTen->getVpresidencial2() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PRESIDENCIALES_2013]['weight'];
        }
        if($onePerTen->getVmunicipales() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_MUNICIPALES_2013]['weight'];
        }
        if($onePerTen->getVasamblea6() != -1){
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['total']++;
            $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ELECCIONES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ELECCIONES][OnePerTen::ELECCIONES_PARLAMENTARIAS_2015]['weight'];
        }
        
        //Determinamos los Items Disponibles del tipo Adicional para Evaluar a la persona
        if($onePerTen->getFirmaCompromiso() != -1){
            $profileItems[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['enabled'] = true;
            $profileItems[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['showInList'] = true;
            $profileItems[OnePerTen::TYPE_ADICIONALES]['total']++;
            $profileItems[OnePerTen::TYPE_ADICIONALES]['totalWeight'] = $profileItems[OnePerTen::TYPE_ADICIONALES]['totalWeight'] + $profileItems[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['weight'];
        }
        return $profileItems;
    }
    
    
    public function obtainProfileItemsWithWeight(OnePerTen $onePerTen,$profileItemsAvailables = array()){
        
        //Determinamos los Valores Porcentuales para los Items Disponibles del tipo Compromiso para Evaluar a la persona
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
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        if($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
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
        
        //Determinamos los Valores Porcentuales para los Items Disponibles del tipo Participación en las Elecciones para Evaluar a la persona
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
        
        //Determinamos los Valores Porcentuales para los Items Disponibles del tipo Adicionales para Evaluar a la persona
        if($profileItemsAvailables[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['enabled']){
            $profileItemsAvailables[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['percentageValue'] = round(($profileItemsAvailables[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['weight']/$profileItemsAvailables[OnePerTen::TYPE_COMPROMISO]['totalWeight'])*100.0,2);
        }
        
        return $profileItemsAvailables;
    }
    
    /**
     * 
     * @param OnePerTen $onePerTen
     * @param type $profileItemsWithWeight
     * @param type $members
     * @param type $type
     * @return type
     */
    public function obtainProfileItemsWithResult(OnePerTen $onePerTen,$profileItemsWithWeight = array(), $members, $type = 'array'){
        $profileItemsWithResult = $profileItemsWithWeight;
        $supportAssemblyElections = array();
        $supportAssemblyElections = $this->obtainWhichSupportAssemblyElections($onePerTen);
        
        //Determinamos los valores a mostrar para los Items Disponibles del tipo Compromiso para Evaluar a la persona
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['enabled']){
            if($onePerTen->getFref() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['text'] = 'Sí';
            } else{
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::LISTA_SUMATE]['percentageValue'];
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
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['showInList'] == true){
            if($onePerTen->getCutl() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['text'] = 'Sí';
                if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['enabled'] == true){
                    $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['percentageValue'];
                } else{
                    $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['resultWithPercentage'] = 'N/A';
                }
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CUTL]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['showInList']){
            if($onePerTen->getSala() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['text'] = 'Sí';
                if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['enabled']){
                    $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['percentageValue'];
                } else{
                    $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['resultWithPercentage'] = 'N/A';
                }
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::SALA]['resultWithPercentage'];
        }
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['showInList']){
            if($onePerTen->getCne() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['text'] = 'Sí';
                if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['enabled']){
                    $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['percentageValue'];
                } else{
                    $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['resultWithPercentage'] = 'N/A';
                }
            }
            $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_COMPROMISO][OnePerTen::CNE]['resultWithPercentage'];
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
                $efectividad = (float)$this->obtainEfficiencyOnePerTen($members,$type);
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
        
        //Determinamos los valores a mostrar para los Items Disponibles del tipo Participación en las Elecciones para evaluar a la persona
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
        
        //Determinamos los valores a mostrar para los Items Disponibles del tipo Adicional para evaluar a la persona
        if($profileItemsWithResult[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['enabled']){
            if($onePerTen->getFirmaCompromiso() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['resultWithPercentage'] = $profileItemsWithResult[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['percentageValue'];
                $profileItemsWithResult[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['text'] = 'Sí';
            }
            $profileItemsWithResult[OnePerTen::TYPE_ADICIONALES]['totalResult'] = $profileItemsWithResult[OnePerTen::TYPE_ADICIONALES]['totalResult'] + $profileItemsWithResult[OnePerTen::TYPE_ADICIONALES][OnePerTen::FIRMA_COMPROMISO]['resultWithPercentage'];
        }
        
        //Obtenemos el Resultado Global
        if($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['activeToEvaluate'] == true){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] = $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] + round(($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult']*$profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['weightGlobal'])/100,2);
        }
        if($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['activeToEvaluate'] == true){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] = $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] + round(($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult']*$profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['weightGlobal'])/100,2);
        }
        if($profileItemsWithResult[OnePerTen::TYPE_ADICIONALES]['activeToEvaluate'] == true){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] = $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] + round(($profileItemsWithResult[OnePerTen::TYPE_ADICIONALES]['totalResult']*$profileItemsWithResult[OnePerTen::TYPE_ADICIONALES]['weightGlobal'])/100,2);
        }
//        $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] = round(($profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['totalResult']*$profileItemsWithResult[OnePerTen::TYPE_COMPROMISO]['weightGlobal'])/100,2)+round(($profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['totalResult']*$profileItemsWithResult[OnePerTen::TYPE_ELECCIONES]['weightGlobal'])/100,2);
        //Obtenemos el Puntaje del Perfil
        $profileItemsWithResult = $this->evaluateResultWithCompresionFormula($onePerTen,$profileItemsWithResult);
        $profileItemsWithResult = $this->evaluateRealProfileResult($onePerTen,$profileItemsWithResult);
        $profileItemsWithResult = $this->evaluateProfileResult($onePerTen,$profileItemsWithResult);
        
        return $profileItemsWithResult;
    }
    
    /**
     * 
     * @param OnePerTen $onePerTen
     * @param array $profileItemsWithResult
     * @return type
     */
    public function evaluateResultWithCompresionFormula(OnePerTen $onePerTen,$profileItemsWithResult = array()){
        $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] = round(0.5*(1+(($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result']/0.5)-1)*0.85),2);
        
        return $profileItemsWithResult;
    }
    
    /**
     * 
     * @param OnePerTen $onePerTen
     * @param type $profileItemsWithResult
     */
    public function evaluateRealProfileResult(OnePerTen $onePerTen,$profileItemsWithResult = array()){
        if($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] >= 80){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['realProfileValue'] = 1;
        } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] < 80 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] >= 60){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['realProfileValue'] = 2;
        } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] < 60 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] >= 40){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['realProfileValue'] = 3;
        } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] < 40 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] >= 20){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['realProfileValue'] = 4;
        } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] < 20){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['realProfileValue'] = 5;
        }
        
        return $profileItemsWithResult;
    }
    
    /**
     * 
     * @param OnePerTen $onePerTen
     * @param type $profileItemsWithResult
     * @return string
     */
    public function evaluateProfileResult(OnePerTen $onePerTen,$profileItemsWithResult = array()){
        //RANGO VIEJO: -1: x >= 95 -2: 95 > x >= 85 -3: 85 > x >= 70 -4: 70 > x >= 50 -5: x < 50
        //RANGO VIEJO: -1: x >= 80 -2: 80 > x >= 60 -3: 60 > x >= 40 -4: 40 > x >= 20 -5: x < 20
        
        
        if($onePerTen->getMarkedStatus() == 0){
            $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['realProfileValue'];
            if($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] >= 80){
            } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] < 80 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] >= 60){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['class'] = 'anthracite-bg';
            } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] < 60 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] >= 40){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['class'] = 'grey-bg';
            } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] < 40 && $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] >= 20){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['class'] = 'orange-bg';
            } elseif($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['result'] < 20){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['class'] = 'blue-bg';
            }
        } else{
            if($onePerTen->getMarkedStatus() == 1){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 1;
            } elseif($onePerTen->getMarkedStatus() == 2){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 2;
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['class'] = 'anthracite-bg';
            } elseif($onePerTen->getMarkedStatus() == 3){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 3;
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['class'] = 'grey-bg';
            } elseif($onePerTen->getMarkedStatus() == 4){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 4;
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['class'] = 'orange-bg';
            } elseif($onePerTen->getMarkedStatus() == 5){
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue'] = 5;
                $profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['class'] = 'blue-bg';
            }
        }
        
        return $profileItemsWithResult;
    }
    
    /**
     * 
     * @param type $members
     * @param type $type
     * @return string
     */
    public function obtainEfficiencyOnePerTen($members, $type='array'){
        
        $efectividad = number_format(0, 2, ',', '.') . '%';
        if(count($members) > 0){
            $contVotos = 0;
            $totalMiembros = count($members);
            foreach($members as $member){
                if($type == 'array'){
                    $contVotos = $member['voto'] == "Sí" ? $contVotos+1 : $contVotos;
                } elseif ($type == 'class'){
                    $contVotos = $member->getVasamblea6() == 1 ? $contVotos+1 : $contVotos;
                }
            }
            $efectividad = number_format(($contVotos/$totalMiembros)*100, 2, ',', '.') . '%';
        }
        
        return $efectividad;
    }
    
    /**
     * 
     * @param OnePerTen $onePerTen
     * @return boolean
     */
    public function obtainWhichSupportAssemblyElections(OnePerTen $onePerTen){
        $supportAssemblyElections = array();
        $supportAssemblyElections['cutl']['evaluate'] = false;
        $supportAssemblyElections['sala']['evaluate'] = false;
        $supportAssemblyElections['cne']['evaluate'] = false;
        $supportAssemblyElections['cutl']['show'] = false;
        $supportAssemblyElections['sala']['show'] = false;
        $supportAssemblyElections['cne']['show'] = false;
        $supportAssemblyElections['cutl']['zero'] = false;
        $supportAssemblyElections['sala']['zero'] = false;
        $supportAssemblyElections['cne']['zero'] = false;
        $next = true;
        $evaluateNext = true;
        
        if($onePerTen->getCutl() != -1){
            $supportAssemblyElections['cutl']['show'] = true;
            if($onePerTen->getCutl() == 1){
                $supportAssemblyElections['cutl']['evaluate'] = true;
                $next = false;
            } else{
                $supportAssemblyElections['cutl']['zero'] = true;
            }
        }
        
        if($onePerTen->getSala() != -1){
            $supportAssemblyElections['sala']['show'] = true;
            if($onePerTen->getSala() == 1){
                if($next == true){
                    $supportAssemblyElections['sala']['evaluate'] = true;
                    $next = false;
                }
            } else{
                $supportAssemblyElections['sala']['zero'] = true;
            }
        }
        
        if($onePerTen->getCne() != -1){
            $supportAssemblyElections['cne']['show'] = true;
            if($onePerTen->getCne() == 1){
                if($next == true){
                    $supportAssemblyElections['cne']['evaluate'] = true;
                    $next = false;
                }
            } else{
                $supportAssemblyElections['cne']['zero'] = true;
            }
        }
        
        if($supportAssemblyElections['cutl']['evaluate'] == false && $supportAssemblyElections['sala']['evaluate'] == false && $supportAssemblyElections['cne']['evaluate'] == false){
            if($supportAssemblyElections['cutl']['zero'] = true){
                $supportAssemblyElections['cutl']['evaluate'] == true;
                $evaluateNext = false;
            }
            if($evaluateNext == true){
                if($supportAssemblyElections['sala']['zero'] == true){
                    $supportAssemblyElections['sala']['evaluate'] = true;
                    $evaluateNext = false;
                }
            }
            
            if($evaluateNext == true){
                if($supportAssemblyElections['cne']['zero'] == true){
                    $supportAssemblyElections['cne']['evaluate'] = true;
                }
            }
        }
        
        return $supportAssemblyElections;
    }
    
    public function refreshProfileValue(OnePerTen $onePerTen){
        $members = array();
        
        $em = $this->getDoctrine()->getManager();
        
        $profileItemsAvailables = $this->obtainProfileItemsAvailables($onePerTen);
        $profileItemsWithWeight = $this->obtainProfileItemsWithWeight($onePerTen, $profileItemsAvailables);
        $profileItemsWithResult = $this->obtainProfileItemsWithResult($onePerTen, $profileItemsWithWeight,$members);
        $onePerTen->setRealProfileValue($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['realProfileValue']);
        
        if($onePerTen->getMarkedStatus() > 0){
            $onePerTen->setProfileValue($onePerTen->getMarkedStatus());
        } else{
            $onePerTen->setProfileValue($profileItemsWithResult[OnePerTen::TYPE_GLOBAL]['profileValue']);
        }
        
        $onePerTen->updateLastDateCalculateProfile();
        
        $em->persist($onePerTen);
        $em->flush();
    }

    /**
     * 
     * @return type
     * @throws LogicException
     */
    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
