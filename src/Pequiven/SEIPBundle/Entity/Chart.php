<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\SEIPBundle\Model\Chart as ModelChart;

/**
 * Chart
 *
 * @ORM\Table(name="seip_chart")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\ChartRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks()
 */
class Chart extends ModelChart
{
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
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_created_at", referencedColumnName="id")
     */
    private $userCreatedAt;

    /**
     * User
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="\Pequiven\SEIPBundle\Entity\User")
     * @ORM\JoinColumn(name="fk_user_updated_at", referencedColumnName="id")
     */
    private $userUpdatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="string", length=20)
     */
    private $shortDescription;
    
    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=25)
     */
    private $alias;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Pequiven\IndicatorBundle\Entity\Indicator", mappedBy="charts")
     */
    private $indicators;
    
    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
    /**
     * Detalles de los gráficos del Indicador
     * 
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails",mappedBy="chart",cascade={"persist","remove"})
     */
    protected $indicatorsChartDetails;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nameFunctionAngular", type="string", length=200, nullable=true)
     */
    private $nameFunctionAngular;

    /**
     * Constructor
     */
    public function __construct() {
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Chart
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Chart
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Chart
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Chart
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Chart
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Chart
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Chart
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set userCreatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userCreatedAt
     * @return Chart
     */
    public function setUserCreatedAt(\Pequiven\SEIPBundle\Entity\User $userCreatedAt = null)
    {
        $this->userCreatedAt = $userCreatedAt;

        return $this;
    }

    /**
     * Get userCreatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserCreatedAt()
    {
        return $this->userCreatedAt;
    }

    /**
     * Set userUpdatedAt
     *
     * @param \Pequiven\SEIPBundle\Entity\User $userUpdatedAt
     * @return Chart
     */
    public function setUserUpdatedAt(\Pequiven\SEIPBundle\Entity\User $userUpdatedAt = null)
    {
        $this->userUpdatedAt = $userUpdatedAt;

        return $this;
    }

    /**
     * Get userUpdatedAt
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUserUpdatedAt()
    {
        return $this->userUpdatedAt;
    }

    /**
     * Add indicators
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
     * @return Chart
     */
    public function addIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        $this->indicators[] = $indicators;

        return $this;
    }

    /**
     * Remove indicators
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicators
     */
    public function removeIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicators)
    {
        $this->indicators->removeElement($indicators);
    }

    /**
     * Get indicators
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicators()
    {
        return $this->indicators;
    }

    /**
     * Set period
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return Chart
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getPeriod()
    {
        return $this->period;
    }
    
    /**
     * Add indicatorsChartDetails
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails $indicatorsChartDetails
     * @return Chart
     */
    public function addIndicatorsChartDetails(\Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails $indicatorsChartDetails) {
        $indicatorsChartDetails->setIndicator($this);

        $this->indicatorsChartDetails->add($indicatorsChartDetails);

        return $this;
    }

    /**
     * Remove indicatorsChartDetails
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails $indicatorsChartDetails
     */
    public function removeIndicatorsChartDetails(\Pequiven\IndicatorBundle\Entity\Indicator\IndicatorChartDetails $indicatorsChartDetails) {
        $this->indicatorsChartDetails->removeElement($indicatorsChartDetails);
    }

    /**
     * Get indicatorsChartDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorsChartDetails() {
        return $this->indicatorsChartDetails;
    }
    
    /**
     * Set nameFunctionAngular
     *
     * @param string $nameFunctionAngular
     * @return Chart
     */
    public function setNameFunctionAngular($nameFunctionAngular)
    {
        $this->nameFunctionAngular = $nameFunctionAngular;

        return $this;
    }

    /**
     * Get nameFunctionAngular
     *
     * @return string 
     */
    public function getNameFunctionAngular()
    {
        return $this->nameFunctionAngular;
    }
    
    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getAlias() ? $this->getAlias().' - '.$this->getDescription() : '-';
    }
}
