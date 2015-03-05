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
 * Tipo de sede
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_TypeLocation",uniqueConstraints={@ORM\UniqueConstraint(name="code_idx",columns={"code"}) } )
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
     * @ORM\Column(name="code",type="string",length=20)
     */
    private $code;
}
