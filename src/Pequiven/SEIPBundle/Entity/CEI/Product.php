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

/**
 * Producto
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_Product")
 * @ORM\Entity()
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
}
