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
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Linea de produccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_ProductionLine")
 * @ORM\Entity()
 */
class ProductionLine extends BaseModel
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
     * @ORM\Column(name="name",type="string",nullable=false)
     */
    private $name;
    
     /**
     * report de planta de ventas
     * @var \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery",mappedBy="productionLine",cascade={"remove"})
     */
    private $productGroupDelivery;
    
     /**
     * Constructor
     */
    public function __construct() {
        $this->productGroupDelivery = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\productGroupDelivery $productGroupDelivery
     * @return \Pequiven\SEIPBundle\Entity\CEI\ProductionLine
     */
    public function addProductGroupDelivery(\Pequiven\SEIPBundle\Entity\Delivery\productGroupDelivery $productGroupDelivery) {
        $this->productGroupDelivery[] = $productGroupDelivery;

        return $this;
    }

    
    /**
     * 
     * @param \Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $productGroupDelivery
     */
    public function removeProductGroupDelivery(\Pequiven\SEIPBundle\Entity\Delivery\ProductGroupDelivery $productGroupDelivery) {
        $this->productGroupDelivery->removeElement(productGroupDelivery);
    }

    /**
     * 
     * @return type
     */
    public function getProductGroupDelivery() {
        return $this->productGroupDelivery;
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
     * @return ProductionLine
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
    
    public function __toString() 
    {
        return $this->getName()?:'-';
    }
}
