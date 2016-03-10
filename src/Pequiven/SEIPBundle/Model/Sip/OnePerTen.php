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
    const TYPE_GLOBAL = 'global';
    
    protected $profileItems = array();
    
    static function getArrayOfProfile(){
        $profileItems = array();
        
        // SECCIÓN COMPROMISO REVOLUCIONARIO
        //Lista Sumate
        $profileItems[self::TYPE_COMPROMISO][self::LISTA_SUMATE]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::LISTA_SUMATE]['weight'] = 20;
        $profileItems[self::TYPE_COMPROMISO][self::LISTA_SUMATE]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::LISTA_SUMATE]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::LISTA_SUMATE]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::LISTA_SUMATE]['textShow'] = 'Lista Súmate 2002';
        //Inscrito GPP
        $profileItems[self::TYPE_COMPROMISO][self::INSCRITO_GPP]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::INSCRITO_GPP]['weight'] = 50;
        $profileItems[self::TYPE_COMPROMISO][self::INSCRITO_GPP]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::INSCRITO_GPP]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::INSCRITO_GPP]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::INSCRITO_GPP]['textShow'] = 'Inscrito GPP';
        //Decreto Esperanza
        $profileItems[self::TYPE_COMPROMISO][self::DECRETO_ESPERANZA]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::DECRETO_ESPERANZA]['weight'] = 60;
        $profileItems[self::TYPE_COMPROMISO][self::DECRETO_ESPERANZA]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::DECRETO_ESPERANZA]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::DECRETO_ESPERANZA]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::DECRETO_ESPERANZA]['textShow'] = 'Firma Decreto Esperanza';
        //Voto Internas PSUV
        $profileItems[self::TYPE_COMPROMISO][self::INTERNAS_PSUV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::INTERNAS_PSUV]['weight'] = 70;
        $profileItems[self::TYPE_COMPROMISO][self::INTERNAS_PSUV]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::INTERNAS_PSUV]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::INTERNAS_PSUV]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::INTERNAS_PSUV]['textShow'] = 'Internas PSUV';
        //Miembro UBCH
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_UBCH]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_UBCH]['weight'] = 50;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_UBCH]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_UBCH]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_UBCH]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_UBCH]['textShow'] = 'Miembro UBCH';
        //Vanguardia PSUV
        $profileItems[self::TYPE_COMPROMISO][self::VANGUARDIA_PSUV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::VANGUARDIA_PSUV]['weight'] = 50;
        $profileItems[self::TYPE_COMPROMISO][self::VANGUARDIA_PSUV]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::VANGUARDIA_PSUV]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::VANGUARDIA_PSUV]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::VANGUARDIA_PSUV]['textShow'] = 'Vanguardia PSUV';
        //Cutl,Sala,Cne
        $profileItems[self::TYPE_COMPROMISO][self::CUTL_SALA_CNE]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::CUTL_SALA_CNE]['weight'] = 50;
        $profileItems[self::TYPE_COMPROMISO][self::CUTL_SALA_CNE]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::CUTL_SALA_CNE]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::CUTL_SALA_CNE]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::CUTL_SALA_CNE]['textShow'] = 'Cutl, Sala ó CNE';
        //Reubicación CNE 2015
        $profileItems[self::TYPE_COMPROMISO][self::REUBICACION_CNE]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::REUBICACION_CNE]['weight'] = 50;
        $profileItems[self::TYPE_COMPROMISO][self::REUBICACION_CNE]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::REUBICACION_CNE]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::REUBICACION_CNE]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::REUBICACION_CNE]['textShow'] = 'Reubicación para las elecciones asamblea 2015';
        //Carga 1x10 PQV
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['weight'] = 20;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PQV]['textShow'] = 'Patrulla en PQV';
        //Carga 1x10 PSUV
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PSUV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PSUV]['weight'] = 30;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PSUV]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PSUV]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PSUV]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::PATRULLA_PSUV]['textShow'] = 'Patrulla en el PSUV';
        //Miembro 1x10 PSUV
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_PATRULLA_PSUV]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_PATRULLA_PSUV]['weight'] = 20;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_PATRULLA_PSUV]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_PATRULLA_PSUV]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_PATRULLA_PSUV]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::MIEMBRO_PATRULLA_PSUV]['textShow'] = 'Miembro de Patrulla en el PSUV';
        //Reporte Voto
        $profileItems[self::TYPE_COMPROMISO][self::REPORTE_VOTO]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::REPORTE_VOTO]['weight'] = 20;
        $profileItems[self::TYPE_COMPROMISO][self::REPORTE_VOTO]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::REPORTE_VOTO]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::REPORTE_VOTO]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::REPORTE_VOTO]['textShow'] = 'Reporte Voto';
        //Firma Compromiso Revolucionario
        $profileItems[self::TYPE_COMPROMISO][self::FIRMA_COMPROMISO]['enabled'] = false;
        $profileItems[self::TYPE_COMPROMISO][self::FIRMA_COMPROMISO]['weight'] = 150;
        $profileItems[self::TYPE_COMPROMISO][self::FIRMA_COMPROMISO]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::FIRMA_COMPROMISO]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO][self::FIRMA_COMPROMISO]['text'] = 'No';
        $profileItems[self::TYPE_COMPROMISO][self::FIRMA_COMPROMISO]['textShow'] = 'Firma Compromiso Respaldo Gobierno Revolucionario';
        //Misceláneos
        $profileItems[self::TYPE_COMPROMISO]['total'] = 0;
        $profileItems[self::TYPE_COMPROMISO]['totalWeight'] = 0;
        $profileItems[self::TYPE_COMPROMISO]['valueByPercentageValue'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO]['totalResult'] = 0.0;
        $profileItems[self::TYPE_COMPROMISO]['weightGlobal'] = 50.0;
        
        // SECCIÓN PARTICIPACIÓN ELECCIONES
        //Presidenciales 2012 (7 OCTUBRE)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2012]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2012]['weight'] = 10;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2012]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2012]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2012]['text'] = 'No';
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2012]['textShow'] = 'Elecciones Presidenciales 2012';
        //Regionales 2012 (16 DICIEMBRE)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_REGIONALES_2012]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_REGIONALES_2012]['weight'] = 10;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_REGIONALES_2012]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_REGIONALES_2012]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_REGIONALES_2012]['text'] = 'No';
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_REGIONALES_2012]['textShow'] = 'Elecciones Regionales 2012';
        //Presidenciales 2013 (14 ABRIL)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2013]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2013]['weight'] = 30;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2013]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2013]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2013]['text'] = 'No';
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PRESIDENCIALES_2013]['textShow'] = 'Elecciones Presidenciales 2013';
        //Municipales 2013 (8 DICIEMBRE)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_MUNICIPALES_2013]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_MUNICIPALES_2013]['weight'] = 10;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_MUNICIPALES_2013]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_MUNICIPALES_2013]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_MUNICIPALES_2013]['text'] = 'No';
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_MUNICIPALES_2013]['textShow'] = 'Elecciones Municipales 2013';
        //Parlamentarias 2015 (6 DICIEMBRE)
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PARLAMENTARIAS_2015]['enabled'] = false;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PARLAMENTARIAS_2015]['weight'] = 40;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PARLAMENTARIAS_2015]['percentageValue'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PARLAMENTARIAS_2015]['resultWithPercentage'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PARLAMENTARIAS_2015]['text'] = 'No';
        $profileItems[self::TYPE_ELECCIONES][self::ELECCIONES_PARLAMENTARIAS_2015]['textShow'] = 'Elecciones Parlamentarias 2015';
        //Misceláneos
        $profileItems[self::TYPE_ELECCIONES]['total'] = 0;
        $profileItems[self::TYPE_ELECCIONES]['totalWeight'] = 0;
        $profileItems[self::TYPE_ELECCIONES]['valueByPercentageValue'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES]['totalResult'] = 0.0;
        $profileItems[self::TYPE_ELECCIONES]['weightGlobal'] = 50.0;
        
        //Resultados Globales
        $profileItems[self::TYPE_GLOBAL]['result'] = 0.0;
        $profileItems[self::TYPE_GLOBAL]['class'] = 'red-bg';
        $profileItems[self::TYPE_GLOBAL]['profileValue'] = 0;
        
        return $profileItems;
    }
    
    
    
}
