<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\IndicatorBundle\Model\Indicator\ValueIndicator as Model;

/**
 * Valor del indicador
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table(name="seip_indicator_value")
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Repository\Indicator\ValueIndicatorRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ValueIndicator extends Model {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Usuario que ingreso el valor
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * Usuario que actualizo el valor original
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     */
    private $updatedBy;

    /**
     * Valor del indicador
     * 
     * @var decimal
     * @ORM\Column(name="valueOfIndicator", type="float",precision = 3)
     */
    protected $valueOfIndicator = 0.0;

    /**
     * Indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\ManyToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",inversedBy="valuesIndicator")
     * @ORM\JoinColumn(nullable=false)
     */
    private $indicator;

    /**
     * Formula
     * @var \Pequiven\MasterBundle\Entity\Formula
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\Formula")
     * @ORM\JoinColumn(name="fk_formula", referencedColumnName="id",nullable=false)
     */
    private $formula;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Detalles de valores de los indicadores
     * @var ValueIndicator\ValueIndicatorDetail
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail",inversedBy="valueIndicator")
     */
    private $valueIndicatorDetail;

    /**
     * Relacion de la fichas que se suben en la plantilla del indicador
     * 
     * @var Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorFile
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorFile",inversedBy="valueIndicator")
     */
    private $valueIndicatorFile;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return IndicatorSimpleValue
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return IndicatorSimpleValue
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set createdBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $createdBy
     * @return IndicatorSimpleValue
     */
    public function setCreatedBy(\Pequiven\SEIPBundle\Entity\User $createdBy) {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $updatedBy
     * @return IndicatorSimpleValue
     */
    public function setUpdatedBy(\Pequiven\SEIPBundle\Entity\User $updatedBy = null) {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUpdatedBy() {
        return $this->updatedBy;
    }

    /**
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return IndicatorSimpleValue
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator) {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getIndicator() {
        return $this->indicator;
    }

    /**
     * Set valueOfIndicator
     *
     * @param string $valueOfIndicator
     * @return SimpleValueIndicator
     */
    public function setValueOfIndicator($valueOfIndicator) {
        $this->valueOfIndicator = $valueOfIndicator;

        return $this;
    }

    /**
     * Get valueOfIndicator
     *
     * @return string 
     */
    public function getValueOfIndicator() {
        return $this->valueOfIndicator;
    }

    /**
     * Set formulaParameters
     *
     * @param array $formulaParameters
     * @return ValueIndicator
     */
    public function setFormulaParameters($formulaParameters) {
        $this->formulaParameters = $formulaParameters;

        return $this;
    }

    /**
     * Get formulaParameters
     *
     * @return array 
     */
    public function getFormulaParameters() {
        return $this->formulaParameters;
    }

    /**
     * Set formula
     *
     * @param \Pequiven\MasterBundle\Entity\Formula $formula
     * @return Indicator
     */
    public function setFormula(\Pequiven\MasterBundle\Entity\Formula $formula = null) {
        $this->formula = $formula;

        return $this;
    }

    /**
     * Get formula
     *
     * @return \Pequiven\MasterBundle\Entity\Formula 
     */
    public function getFormula() {
        return $this->formula;
    }

    function getDeletedAt() {
        return $this->deletedAt;
    }

    function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    function getValueIndicatorFile() {
        return $this->valueIndicatorFile;
    }

    function setValueIndicatorFile($valueIndicatorFile) {
        $this->valueIndicatorFile = $valueIndicatorFile;
        return $this;
    }    

    public function __toString() {
        $toString = '';
        if ($this->id) {
            $toString .= $this->id . ')   ';
        }
        $toString.= ' ' . $this->valueOfIndicator . ' ';
        if (count($this->formulaParameters) > 0) {
            $toString.= '   ';
            foreach ($this->formulaParameters as $key => $value) {
                $toString.= sprintf('[%s => %s]', $key, $value);
            }
        }
        return $toString ? : '-';
    }

    /**
     * Set valueIndicatorDetail
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail $valueIndicatorDetail
     * @return ValueIndicator
     */
    public function setValueIndicatorDetail(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail $valueIndicatorDetail = null) {
        $this->valueIndicatorDetail = $valueIndicatorDetail;

        return $this;
    }

    /**
     * Get valueIndicatorDetail
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\ValueIndicatorDetail 
     */
    public function getValueIndicatorDetail() {
        return $this->valueIndicatorDetail;
    }

}
