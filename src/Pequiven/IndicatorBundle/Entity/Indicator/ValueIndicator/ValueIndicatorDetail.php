<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Detalles de valor de indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ValueIndicatorDetail
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
     * Valor de indicador
     * @var \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator",mappedBy="valueIndicatorDetail")
     */
    private $valueIndicator;

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
     * Produccion diara detallada en el mes
     * @var Detail\ProductDetailDailyMonth
     * @ORM\OneToMany(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth",mappedBy="valueIndicatorDetail",cascade={"persist","remove"})
     */
    private $productsDetailDailyMonth;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productsDetailDailyMonth = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ValueIndicatorDetail
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
     * @return ValueIndicatorDetail
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
     * Set valueIndicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valueIndicator
     * @return ValueIndicatorDetail
     */
    public function setValueIndicator(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator $valueIndicator)
    {
        $valueIndicator->setValueIndicatorDetail($this);
        $this->valueIndicator = $valueIndicator;

        return $this;
    }

    /**
     * Get valueIndicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator 
     */
    public function getValueIndicator()
    {
        return $this->valueIndicator;
    }

    /**
     * Add productsDetailDailyMonth
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $productsDetailDailyMonth
     * @return ValueIndicatorDetail
     */
    public function addProductsDetailDailyMonth(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $productsDetailDailyMonth)
    {
        $productsDetailDailyMonth->setValueIndicatorDetail($this);
        $this->productsDetailDailyMonth->add($productsDetailDailyMonth);

        return $this;
    }

    /**
     * Remove productsDetailDailyMonth
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $productsDetailDailyMonth
     */
    public function removeProductsDetailDailyMonth(\Pequiven\IndicatorBundle\Entity\Indicator\ValueIndicator\Detail\ProductDetailDailyMonth $productsDetailDailyMonth)
    {
        $this->productsDetailDailyMonth->removeElement($productsDetailDailyMonth);
    }

    /**
     * Get productsDetailDailyMonth
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductsDetailDailyMonth()
    {
        return $this->productsDetailDailyMonth;
    }
}
