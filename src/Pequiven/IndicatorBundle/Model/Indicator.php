<?php

namespace Pequiven\IndicatorBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo del indicador
 *
 * @author matias
 */
abstract class Indicator implements IndicatorInterface
{
    /**
     * Tipo de calculo por formula y valores de las variables manuales
     */
    const TYPE_CALCULATION_FORMULA_MANUALLY = 0;
    
    /**
     * Tipo de calculo por formula y valores de las variables automaticos
     */
    const TYPE_CALCULATION_FORMULA_AUTOMATIC = 1;
    
    /**
     * Indicador con resultado
     */
    const INDICATOR_WITH_RESULT = 1;
    
    /**
     * Indicador sin resultado
     */
    const INDICATOR_WITHOUT_RESULT = 0;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="typeOfCalculation", type="integer", nullable=false)
     */
    protected $typeOfCalculation = self::TYPE_CALCULATION_FORMULA_MANUALLY;
    
    /**
     * IndicatorLevel
     * @var \Pequiven\IndicatorBundle\Entity\IndicatorLevel
     * @ORM\ManyToOne(targetEntity="\Pequiven\IndicatorBundle\Entity\IndicatorLevel")
     * @ORM\JoinColumn(name="fk_indicator_level", referencedColumnName="id",nullable = false)
     */
    protected $indicatorLevel;
    
    /**
     * Set indicatorLevel
     *
     * @param \Pequiven\IndicatorBundle\Entity\IndicatorLevel $indicatorLevel
     * @return Indicator
     */
    public function setIndicatorLevel(\Pequiven\IndicatorBundle\Entity\IndicatorLevel $indicatorLevel)
    {
        $this->indicatorLevel = $indicatorLevel;

        return $this;
    }

    /**
     * Get indicatorLevel
     *
     * @return \Pequiven\IndicatorBundle\Entity\IndicatorLevel 
     */
    public function getIndicatorLevel()
    {
        return $this->indicatorLevel;
    }
    
    /**
     * Retorna el tipo de calculo del indicador
     * @return integer
     */
    function getTypeOfCalculation() 
    {
        return $this->typeOfCalculation;
    }
    
    /**
     * Establece el tipo de calculo del indicador
     * 
     * @param integer $typeOfCalculation Indicator::TYPE_CALCULATION_*
     * @return \Pequiven\IndicatorBundle\Model\Indicator
     */
    function setTypeOfCalculation($typeOfCalculation) {
        $this->typeOfCalculation = $typeOfCalculation;
        
        return $this;
    }
    
    /**
     * Retorna los tipos de calculo disponible de los indicadores y sus etiquetas.
     * 
     * @staticvar array $typesOfCalculation
     * @return array
     */
    static function getTypesOfCalculation()
    {
        static $typesOfCalculation = array(
            self::TYPE_CALCULATION_FORMULA_MANUALLY => 'pequiven_indicator.type_calculation.formula_manually',
            self::TYPE_CALCULATION_FORMULA_AUTOMATIC => 'pequiven_indicator.type_calculation.formula_automatic',
        );
        return $typesOfCalculation;
    }
    
    function getTypeOfCalculationLabel() {
        $typesOfCalculation = self::getTypesOfCalculation();
        if(isset($typesOfCalculation[$this->typeOfCalculation]) === false){
            throw new Exception(sprintf('The type of calculation "%s" dont exist',$this->typeOfCalculation));
        }
        return $typesOfCalculation[$this->typeOfCalculation];
    }
    
    public function hasNotification()
    {
        if(count($this->getValuesIndicator()) > 0){
            return true;
        }
        return false;
    }
}
