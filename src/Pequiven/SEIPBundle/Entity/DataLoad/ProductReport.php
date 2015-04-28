<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\ProductReport as BaseModel;

/**
 * Producto de reporte
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_report")
 * @ORM\Entity()
 */
class ProductReport extends BaseModel
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
     * Producto
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    
    /**
     * Linea de negocio (Linea de producto)
     * 
     * @var ProductionLine
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\ProductionLine")
     */
    private $productionLine;

    /**
     * Planta que hace el producto
     * 
     * @var \Pequiven\SEIPBundle\Entity\CEI\Plant
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant")
     */
    private $plant;
    
    /**
     * ¿Es materia prima?
     * @var boolean
     * @ORM\Column(name="is_raw_material",type="boolean")
     */
    private $isRawMaterial = false;
    
    /**
     * ¿Es producto final?
     * @var boolean 
     * @ORM\Column(name="is_final_product",type="boolean")
     */
    private $isFinalProduct = false;

    /**
     * Unidad del producto
     * @var String
     * @ORM\Column(name="product_unit")
     */
    private $productUnit;
    
    /**
     * Plantilla de reporte
     * 
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate",inversedBy="productsReport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reportTemplate;

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
     * Set isRawMaterial
     *
     * @param boolean $isRawMaterial
     * @return ProductReport
     */
    public function setIsRawMaterial($isRawMaterial)
    {
        $this->isRawMaterial = $isRawMaterial;

        return $this;
    }

    /**
     * Get isRawMaterial
     *
     * @return boolean 
     */
    public function getIsRawMaterial()
    {
        return $this->isRawMaterial;
    }

    /**
     * Set isFinalProduct
     *
     * @param boolean $isFinalProduct
     * @return ProductReport
     */
    public function setIsFinalProduct($isFinalProduct)
    {
        $this->isFinalProduct = $isFinalProduct;

        return $this;
    }

    /**
     * Get isFinalProduct
     *
     * @return boolean 
     */
    public function getIsFinalProduct()
    {
        return $this->isFinalProduct;
    }

    /**
     * Set productUnit
     *
     * @param string $productUnit
     * @return ProductReport
     */
    public function setProductUnit($productUnit)
    {
        $this->productUnit = $productUnit;

        return $this;
    }

    /**
     * Get productUnit
     *
     * @return string 
     */
    public function getProductUnit()
    {
        return $this->productUnit;
    }

    /**
     * Set product
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $product
     * @return ProductReport
     */
    public function setProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set productionLine
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\ProductionLine $productionLine
     * @return ProductReport
     */
    public function setProductionLine(\Pequiven\SEIPBundle\Entity\CEI\ProductionLine $productionLine = null)
    {
        $this->productionLine = $productionLine;

        return $this;
    }

    /**
     * Get productionLine
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\ProductionLine 
     */
    public function getProductionLine()
    {
        return $this->productionLine;
    }

    /**
     * Set plant
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $plant
     * @return ProductReport
     */
    public function setPlant(\Pequiven\SEIPBundle\Entity\CEI\Plant $plant = null)
    {
        $this->plant = $plant;

        return $this;
    }

    /**
     * Get plant
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Plant 
     */
    public function getPlant()
    {
        return $this->plant;
    }

    /**
     * Set reportTemplate
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate
     * @return ProductReport
     */
    public function setReportTemplate(\Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate $reportTemplate)
    {
        $this->reportTemplate = $reportTemplate;

        return $this;
    }

    /**
     * Get reportTemplate
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\ReportTemplate 
     */
    public function getReportTemplate()
    {
        return $this->reportTemplate;
    }
}
