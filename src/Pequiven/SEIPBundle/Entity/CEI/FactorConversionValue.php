<?php

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\MasterBundle\Model\Base\ModelBaseMaster;

/**
 * factores de conversion por producto
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 * @ORM\Table(name="seip_value_factor_conversion")
 * @ORM\Entity()
 */
class FactorConversionValue extends ModelBaseMaster {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Pequiven\SEIPBundle\Entity\CEI\FactorConversion
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\CEI\FactorConversion",inversedBy="factorConversionValue")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $factorConversion;

    /**
     * product report
     * 
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",inversedBy="factorConversionValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productReport;

    /**
     * @var integer
     *
     * @ORM\Column(name="factor", type="float",nullable=true)
     */
    private $factor;

    function getId() {
        return $this->id;
    }

    function getFactor() {
        return $this->factor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFactor($factor) {
        $this->factor = $factor;
    }

    function getFactorConversion() {
        return $this->factorConversion;
    }

    function setFactorConversion($factorConversion) {
        $this->factorConversion = $factorConversion;
    }

    function getProductReport() {
        return $this->productReport;
    }

    function setProductReport(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReport) {
        $this->productReport = $productReport;
    }

    public function __toString() {
        return "" . $this->factor . "";
    }

}
