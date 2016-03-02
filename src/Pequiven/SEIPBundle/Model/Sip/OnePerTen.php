<?php

namespace Pequiven\SEIPBundle\Model\Sip;

use Doctrine\ORM\Mapping as ORM;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo del one del registro de 1x10
 *
 */
abstract class OnePerTen  {
    
    const LISTA_SUMATE = 1;
    const INSCRITO_GPP = 2;
    const DECRETO_ESPERANZA = 3;
    const INTERNAS_PSUV = 4;
    const MIEMBRO_UBCH = 5;
    const VANGUARDIA_PSUV = 6;
    const CUTL_SALA_CNE = 7;
    const REUBICACION_CNE = 8;
    const PATRULLA_PQV = 9;
    const PATRULLA_PSUV = 10;
    const MIEMBRO_PATRULLA_PSUV = 11;
    const REPORTE_VOTO = 12;
    const FIRMA_COMPROMISO = 13;
    
    const ELECCIONES_PRESIDENCIALES_2012 = 1;
    const ELECCIONES_REGIONALES_2012 = 2;
    const ELECCIONES_PRESIDENCIALES_2013 = 3;
    const ELECCIONES_MUNICIPALES_2013 = 4;
    const ELECCIONES_PARLAMENTARIAS_2015 = 5;
    
    const TYPE_COMPROMISO = 'compromiso';
    const TYPE_ELECCIONES = 'elecciones';
    
    protected $profileItems = array();
    
    static function getArrayOfProfile(){
        $profileItems = array();
        
        // SECCIÓN COMPROMISO REVOLUCIONARIO
        //Lista Sumate
        $profileItems[self::TYPE_COMPROMISO][self::LISTA_SUMATE]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::LISTA_SUMATE]['weight'] = 20;
        //Inscrito GPP
        $profileItems[self::TYPE_COMPROMISO][self::INSCRITO_GPP]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::INSCRITO_GPP]['weight'] = 50;
        //Decreto Esperanza
        $profileItems[self::TYPE_COMPROMISO][self::DECRETO_ESPERANZA]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::DECRETO_ESPERANZA]['weight'] = 60;
        //Voto Internas PSUV
        $profileItems[self::TYPE_COMPROMISO][self::INTERNAS_PSUV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::INTERNAS_PSUV]['weight'] = 70;
        //Miembro UBCH
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_UBCH]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_UBCH]['weight'] = 50;
        //Vanguardia PSUV
        $profileItems[self::TYPE_COMPROMISO][self::VANGUARDIA_PSUV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::VANGUARDIA_PSUV]['weight'] = 50;
        //Cutl,Sala,Cne
        $profileItems[self::TYPE_COMPROMISO][self::CUTL_SALA_CNE]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::CUTL_SALA_CNE]['weight'] = 50;
        //Reubicación CNE 2015
        $profileItems[self::TYPE_COMPROMISO][self::REUBICACION_CNE]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::REUBICACION_CNE]['weight'] = 50;
        //Carga 1x10 PQV
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['weight'] = 20;
        //Carga 1x10 PSUV
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PSUV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PSUV]['weight'] = 30;
        //Miembro 1x10 PSUV
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_PATRULLA_PSUV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_PATRULLA_PSUV]['weight'] = 20;
        //Reporte Voto
        $profileItems[self::TYPE_COMPROMISO][self::REPORTE_VOTO]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::REPORTE_VOTO]['weight'] = 20;
        //Firma Compromiso Revolucionario
        $profileItems[self::TYPE_COMPROMISO][self::FIRMA_COMPROMISO]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::FIRMA_COMPROMISO]['weight'] = 150;
        //Misceláneos
        $profileItems[self::TYPE_COMPROMISO]['total'] = 0;
        $profileItems[self::TYPE_COMPROMISO]['totalWeight'] = 0;
        
        // SECCIÓN PARTICIPACIÓN ELECCIONES
        //Presidenciales 2012 (7 OCTUBRE)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2012]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2012]['weight'] = 10;
        //Regionales 2012 (16 DICIEMBRE)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_REGIONALES_2012]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_REGIONALES_2012]['weight'] = 10;
        //Presidenciales 2013 (14 ABRIL)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2013]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2013]['weight'] = 30;
        //Municipales 2013 (8 DICIEMBRE)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_MUNICIPALES_2013]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_MUNICIPALES_2013]['weight'] = 10;
        //Parlamentarias 2015 (6 DICIEMBRE)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PARLAMENTARIAS_2015]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PARLAMENTARIAS_2015]['weight'] = 40;
        //Misceláneos
        $profileItems[self::TYPE_ELECCIONES]['total'] = 0;
        $profileItems[self::TYPE_ELECCIONES]['totalWeight'] = 0;
        
        return $profileItems;
    }
    
    
    
}
