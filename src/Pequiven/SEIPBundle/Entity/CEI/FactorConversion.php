<?php

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * Factores de conversion 
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_factor_conversion")
 * @ORM\Entity()
 */
class FactorConversion extends ModelBaseMaster {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Unidad del producto a convertir
     * @var \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\UnitMeasure")
     * @ORM\JoinColumn(name="productUnitFrom", referencedColumnName="id")
     */
    private $productUnitFrom;

    /**
     * Unidad del producto final
     * @var \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\UnitMeasure")
     * @ORM\JoinColumn(name="productUnitTo", referencedColumnName="id")
     */
    private $productUnitTo;

    /**
     * @var string
     *
     * @ORM\Column(name="formula", type="text")
     */
    private $formula;

    /**
     * factor de conversion
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue",mappedBy="factorConversion")
     */
    private $factorConversionValue;

    /**
     *
     * @var type 
     * @ORM\Column(name="alias", type="text")
     */
    private $alias;

    /**
     * Constructor
     */
    public function __construct() {

        $this->factorConversionValue = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue $factorConversionValue
     * @return \Pequiven\SEIPBundle\Entity\CEI\FactorConversion
     */
    public function addFactorConversionValue(FactorConversionValue $factorConversionValue) {
        $factorConversionValue->setFactorConversion($this);
        $this->factorConversionValue->add($factorConversionValue);

        return $this;
    }

    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\CEI\FactorConversionValue $factorConversionValue
     */
    public function removeFactorConversionValue(FactorConversionValue $factorConversionValue) {
        $this->factorConversionValue->removeElement($factorConversionValue);
    }

    /**
     * 
     * @return type
     */
    public function getFactorConversionValue() {
        return $this->factorConversionValue;
    }

    function getFormula() {
        return $this->formula;
    }

    function setFormula($formula) {
        $this->formula = $formula;
    }

    function getId() {
        return $this->id;
    }

    function getProductUnitFrom() {
        return $this->productUnitFrom;
    }

    function getProductUnitTo() {
        return $this->productUnitTo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProductUnitFrom(\Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $productUnitFrom) {
        $this->productUnitFrom = $productUnitFrom;
    }

    function setProductUnitTo(\Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $productUnitTo) {
        $this->productUnitTo = $productUnitTo;
    }

    function getAlias() {
        return $this->alias;
    }

    function setAlias($alias) {
        $this->alias = $alias;
    }

    public function __toString() {
        return $this->alias;
    }

}
