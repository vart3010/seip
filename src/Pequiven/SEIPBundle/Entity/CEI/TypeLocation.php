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
use Pequiven\SEIPBundle\Model\CEI\TypeLocation as BaseModel;

/**
 * Tipo de sede
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_TypeLocation",uniqueConstraints={@ORM\UniqueConstraint(name="typeCode_idx",columns={"code"}) } )
 * @ORM\Entity()
 */
class TypeLocation extends BaseModel
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
     * Descripcion
     * 
     * @var String 
     * @ORM\Column(name="description",type="text",nullable=false)
     */
    private $description;
    
    /**
     * Codigo unico
     * @var string
     * @ORM\Column(name="code",type="string",length=50)
     */
    private $code;

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
     * Set description
     *
     * @param string $description
     * @return TypeLocation
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
     * Set code
     *
     * @param string $code
     * @return TypeLocation
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
    
    public function __toString() 
    {
        return $this->getDescription()?:'-';
    }
}
