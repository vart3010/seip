<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\CEI\Product as BaseModel;
use Tpg\ExtjsBundle\Annotation as Extjs;

/**
 * Producto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_Product")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\CEI\ProductRepository")
 * @Extjs\Model()
 */
class Product extends BaseModel
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
     * Nombre
     * 
     * @var String 
     * @ORM\Column(name="name",type="text",nullable=false)
     */
    private $name;
    
    /**
     * Linea de negocio (Linea de producto)
     * 
     * @var ProductionLine
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\ProductionLine")
     */
    private $productionLine;
    
    /**
     * ¿Es materia prima?
     * @var boolean
     * @ORM\Column(name="is_raw_material",type="boolean")
     */
    private $isRawMaterial = false;
    
    /**
     * Unidad del producto
     * @var \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\UnitMeasure")
     */
    private $productUnit;
    
    /**
     * Materia prima
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     *
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     * @ORM\JoinTable(name="products_rawmaterials")
     */
    private $rawMaterials;
    
    /**
     * Tipo de producto
     * @var integer
     * @ORM\Column(name="type_product",type="integer")
     */
    private $typeProduct;
    
    /**
     * Componentes o subproductos
     * 
     * @var Product
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     */
    private $components;
    
    /**
     * Plantas a la que pertenece el producto
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Plant",mappedBy="products")
     */
    private $plants;
    
    /**
     * Reporte de productos
     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",mappedBy="product")
     */
    private $productReports;
//    
//    /**
//     * Reporte de productos
//     * @var \Pequiven\SEIPBundle\Entity\DataLoad\ProductReport
//     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\ProductReport",mappedBy="product")
//     */
//    private $productReports;
    
    /**
     * ¿va a estar en los graficos de reporte de produccion?
     * @var boolean
     * @ORM\Column(name="isCheckToReportProduction",type="boolean",nullable=false)
     */
    private $isCheckToReportProduction = false;

    public function __construct() 
    {
        $this->components = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ProductReport = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Add components
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $components
     * @return Product
     */
    public function addComponent(\Pequiven\SEIPBundle\Entity\CEI\Product $components)
    {
        $this->components->add($components);

        return $this;
    }

    /**
     * Remove components
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $components
     */
    public function removeComponent(\Pequiven\SEIPBundle\Entity\CEI\Product $components)
    {
        $this->components->removeElement($components);
    }

    /**
     * Get components
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComponents()
    {
        return $this->components;
    }
    
    /**
     * Set isRawMaterial
     *
     * @param boolean $isRawMaterial
     * @return Product
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
     * Set typeProduct
     *
     * @param integer $typeProduct
     * @return Product
     */
    public function setTypeProduct($typeProduct)
    {
        $this->typeProduct = $typeProduct;
//        $this->typeProduct = $typeProduct->add('isRawMaterial', null, array(
//                    'required' => false,
//                ));

        return $this;
    }

    /**
     * Get typeProduct
     *
     * @return integer 
     */
    public function getTypeProduct()
    {
        return $this->typeProduct;
    }

    /**
     * Set productionLine
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\ProductionLine $productionLine
     * @return Product
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
     * Set productUnit
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $productUnit
     * @return Product
     */
    public function setProductUnit(\Pequiven\SEIPBundle\Entity\CEI\UnitMeasure $productUnit = null)
    {
        $this->productUnit = $productUnit;

        return $this;
    }

    /**
     * Get productUnit
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\UnitMeasure 
     */
    public function getProductUnit()
    {
        return $this->productUnit;
    }

    /**
     * Add rawMaterials
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Productl $rawMaterials
     * @return Product
     */
    public function addRawMaterial(\Pequiven\SEIPBundle\Entity\CEI\Product $rawMaterials)
    {
        $this->rawMaterials[] = $rawMaterials;

        return $this;
    }

    /**
     * Remove rawMaterials
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $rawMaterials
     */
    public function removeRawMaterial(\Pequiven\SEIPBundle\Entity\CEI\Product $rawMaterials)
    {
        $this->rawMaterials->removeElement($rawMaterials);
    }

    /**
     * Get rawMaterials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRawMaterials()
    {
        return $this->rawMaterials;
    }
    
    /**
     * Add plants
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $plants
     * @return Product
     */
    public function addPlant(\Pequiven\SEIPBundle\Entity\CEI\Plant $plants)
    {
        $this->plants[] = $plants;

        return $this;
    }

    /**
     * Remove plants
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Plant $plants
     */
    public function removePlant(\Pequiven\SEIPBundle\Entity\CEI\Plant $plants)
    {
        $this->plants->removeElement($plants);
    }

    /**
     * Get plants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlants()
    {
        return $this->plants;
    }
    
    
    public function setIsCheckToReportProduction($isCheckToReportProduction)
    {
        $this->isCheckToReportProduction = $isCheckToReportProduction;
        
        return $this;
    }
    
    
    /**
     * 
     * @return type
     */
    public function getIsCheckToReportProduction()
    {
        return $this->isCheckToReportProduction;
    }
    
    public function getProductReports() {
        return $this->productReports;
    }
    
    
            
            
    
    public function __toString() 
    {
        return $this->getName()?:'-';
    }
}
