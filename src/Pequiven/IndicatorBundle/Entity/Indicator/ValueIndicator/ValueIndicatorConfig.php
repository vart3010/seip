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

/**
 * Configuracion de detalles de valores
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ValueIndicatorConfig 
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
     * Indicador
     * @var \Pequiven\IndicatorBundle\Entity\Indicator
     * @ORM\OneToOne(targetEntity="Pequiven\IndicatorBundle\Entity\Indicator",mappedBy="valueIndicatorConfig")
     */
    private $indicator;
    
    /**
     * Productos
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     */
    private $products;
    
    /**
     * ProductReport
     * 
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport")
     */
    private $productReports;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productReports = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set indicator
     *
     * @param \Pequiven\IndicatorBundle\Entity\Indicator $indicator
     * @return IndicatorConfigDetailValue
     */
    public function setIndicator(\Pequiven\IndicatorBundle\Entity\Indicator $indicator)
    {
        $indicator->setValueIndicatorConfig($this);
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \Pequiven\IndicatorBundle\Entity\Indicator 
     */
    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * Add products
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $products
     * @return IndicatorConfigDetailValue
     */
    public function addProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $products
     */
    public function removeProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    /**
     * Add productReports
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReports
     * @return IndicatorConfigDetailValue
     */
    public function addProductReports(\Pequiven\SEIPBundle\Entity\CEI\Product $productReports)
    {
        $this->productReports[] = $productReports;

        return $this;
    }

    /**
     * Remove productReports
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReports
     */
    public function removeProductReports(\Pequiven\SEIPBundle\Entity\DataLoad\ProductReport $productReports)
    {
        $this->productReports->removeElement($productReports);
    }

    /**
     * Get productReports
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductReports()
    {
        return $this->productReports;
    }
}
