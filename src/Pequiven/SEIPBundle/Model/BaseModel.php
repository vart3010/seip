<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Campos comunes para las entitdades
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
class BaseModel implements BaseModelInterface
{
    
    /**
     * Habilitado para consultas
     * @var boolean
     * @ORM\Column(name="enabled",type="boolean")
     */
    protected $enabled = true;
    
    /**
     * Date created
     * 
     * @var \DateTime 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt",type="datetime")
     */
    protected $createdAt;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    protected $updatedAt;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    protected $deletedAt;
    
    function isEnabled() 
    {
        return $this->enabled;
    }
    
    function getCreatedAt() 
    {
        return $this->createdAt;
    }

    function getUpdatedAt() 
    {
        return $this->updatedAt;
    }

    function getDeletedAt() 
    {
        return $this->deletedAt;
    }

    function setEnabled($enabled)
    {
        $this->enabled = (boolean)$enabled;
        
        return $this;
    }
    
    function setCreatedAt(\DateTime $createdAt) 
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    function setUpdatedAt(\DateTime $updatedAt) 
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }

    function setDeletedAt(\DateTime $deletedAt) 
    {
        $this->deletedAt = $deletedAt;
        
        return $this;
    }
}
