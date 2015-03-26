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
     * Tipo (Producto o servicio)
     * @var integer
     * @ORM\Column(name="typeOf",type="integer")
     */
    private $typeOf = self::TYPE_PRODUCT;
    
    /**
     * Componentes o subproductos
     * @var Product
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     */
    private $components;
    
    public function __construct() 
    {
        $this->components = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set typeOf
     *
     * @param integer $typeOf
     * @return Product
     */
    public function setTypeOf($typeOf)
    {
        $this->typeOf = $typeOf;

        return $this;
    }

    /**
     * Get typeOf
     *
     * @return integer 
     */
    public function getTypeOf()
    {
        return $this->typeOf;
    }
    
    public function __toString() 
    {
        return $this->getName()?:'-';
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
}
