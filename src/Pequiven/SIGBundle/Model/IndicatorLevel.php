<?php

namespace Pequiven\IndicatorBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo del nivel de indicador
 *
 * @author matias
 */
abstract class IndicatorLevel extends \Pequiven\SEIPBundle\Model\Common\CommonObject {
    const LEVEL_DEFAULT = 0;
    const LEVEL_ESTRATEGICO = 1;
    const LEVEL_TACTICO = 2;
    const LEVEL_OPERATIVO = 3;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    protected $level;
    
    public $level_name = array();
    
    public function __construct() {
        $this->level_name[self::LEVEL_DEFAULT] = 'INDICADOR_ESTRATEGICO';
        $this->level_name[self::LEVEL_ESTRATEGICO] = 'INDICADOR_ESTRATEGICO';
        $this->level_name[self::LEVEL_TACTICO] = 'INDICADOR_TACTICO';
        $this->level_name[self::LEVEL_OPERATIVO] = 'INDICADOR_OPERATIVO';
    }
    
    /**
     * Set level
     *
     * @param integer $level
     * @return IndicatorLevel
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * Retorna todos los niveles
     * @return type
     */
    public function getLevelNameArray() {
        return $this->level_name;
    }
    
    /**
     * Retorna un array con las etiquetas de cada nivel
     * @staticvar array $labelLevel
     * @return string
     */
    static function getLabelLevels() 
    {
        static $labelLevels = array(
            self::LEVEL_ESTRATEGICO => 'pequiven.indicator.level.stategic',
            self::LEVEL_TACTICO => 'pequiven.indicator.level.tactic',
            self::LEVEL_OPERATIVO => 'pequiven.indicator.level.objective',
        );
        return $labelLevels;
    }
    
    /**
     * Retorna la etiqueta que corresponde al nivel
     * @param type $level
     * @return type
     * @throws \InvalidArgumentException
     */
    static function getLabelLevel($level)
    {
        $labelLevels = self::getLabelLevels();
        if(!isset($labelLevels[$level])){
            throw new \InvalidArgumentException(sprintf('Invalid argument, label for "%s" dont exist'));
        }
        return $labelLevels[$level];
    }
    
    /**
     * Retorna la etiqueta del nivel
     * @return string
     */
    function getLabelForLevel() {
        return $this->getLabelLevel($this->level);
    }
    
    public static function getPrefixRef($level)
    {
        $prefixIndicators = self::getPrefixIndicators();
        if(!isset($prefixIndicators[$level])){
            throw new \RuntimeException('Nivel del indicador invalido');
        }
        return $prefixIndicators[$level];
    }
    
    public static function getPrefixIndicators()
    {
        return array(
            self::LEVEL_ESTRATEGICO => 'IE',
            self::LEVEL_TACTICO => 'IT',
            self::LEVEL_OPERATIVO => 'IO',
        );
    }
}
