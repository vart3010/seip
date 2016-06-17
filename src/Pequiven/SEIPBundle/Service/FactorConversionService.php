<?php

namespace Pequiven\SEIPBundle\Service;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\SEIPBundle\Entity\DataLoad\ProductReport;

/**
 * servicio factor de conversion 
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class FactorConversionService {

    /**
     * 
     * @param \Pequiven\SEIPBundle\Service\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     *  retorna si el product report tiene factor de conversion
     * @param ProductReport $productReport
     * @return boolean
     */
    public function hasFactorConversion(ProductReport $productReport) {
        $result = false;

        $factors = $productReport->getFactorConversionValue();
        foreach ($factors as $factor) {
            if ($factor->getEnabled()) {
                $result = true;
            }
        }

        return $result;
    }

    

    /**
     *  Retorna la unidad de conversion que tiene activa
     * @param ProductReport $productReport
     * @return type
     */
    public function unitToFactorConversion(ProductReport $productReport) {
        $result = false;

        $factors = $productReport->getFactorConversionValue();
        foreach ($factors as $factor) {
            if ($factor->getEnabled()) {
                $result = $factor->getFactorConversion()->getProductUnitTo()->getUnit();
            }
        }

        return $result;
    }

    /**
     * 
     * @param type $data
     * @param type $options
     * @return real
     */
    public function calculateFormulaValueFromFactor($valueProduction, ProductReport $productReport, $options = array()) {

        $data = array();
        $name = "";
        
        $factorEnable = new \Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue();
        $factors = $productReport->getFactorConversionValue();
        foreach ($factors as $factor) {
            if ($factor->getEnabled()) {
                $factorEnable = $factor;
                $formula = $factor->getFactorConversion()->getFormula();
            }
        }
        
        
        $$name = 0;
        $data['val'] = $valueProduction;
        $data['factor'] = $factorEnable->getFactor();

        foreach ($data as $key => $value) {
            $name = $key;
            $$name = 0;
            if (isset($data[$name])) {
                $$name = $data[$name];
                //var_dump($data[$name]);
            }
        }
        
        
        $cardEquation = 0.0;
        //$cardEquation = $this->parseFormulaVars('(val*factor)/1000'); //'$val/$factor/1000';
        $cardEquation = $this->parseFormulaVars($formula); //'$val/$factor/1000';
        

        $result_equation = 0.0;

        try {
            @eval(sprintf('$result_equation = %s;', $cardEquation));
        } catch (ErrorException $exc) {
//            echo 'Excepción capturada 1 : ',  $e->getMessage(), "\n";
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
//            echo 'Excepción capturada 2: ',  $e->getMessage(), "\n";
            $result_equation = 0.0;
        }

        return $result_equation;
    }

    /**
     * * Toma una ecuacion y la transforma a variales php validas en un string para evaluarlas.
     * @param type $equationReal
     * @return string
     */
    public function parseFormulaVars($equationReal) {
        $especialCaracter = array(
            '(',
            ')',
            '+',
            '-',
            '*',
            '/',
            ' ',
            '  ',
            '   ',
        );
        $numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
//        $equationReal = '6 + ( num_hoja_entrada_servicios_entregadas / num_valuaciones_solicitadas ) * 100 + casa - 1';
        $stringSplit = str_split($equationReal);
        $newEquation = $varEquation = '';
        foreach ($stringSplit as $key => $char) {
            if (in_array($char, $especialCaracter, true)) {
                $newEquation .= $char;
                continue;
            }
            $nextKey = $key + 1;
            $nextChar = isset($stringSplit[$nextKey]) ? $stringSplit[$nextKey] : null;
            $varEquation .= $char;
            if (in_array($nextChar, $especialCaracter, true)) {
                if (in_array($varEquation[0], $numbers)) {
                    
                } else {
                    $newEquation .= '$';
                }
                $newEquation .= $varEquation;
                $varEquation = '';
            }
        }
        if (strlen($varEquation) > 0) {//Se adjunta lo que queda de la formula que no contiene variable
            if (in_array($varEquation[0], $numbers)) {
                
            } else {
                $newEquation .= '$';
            }
            $newEquation .= $varEquation;
        }
        $formulaPaser = $newEquation;

        return $formulaPaser;
    }

}
