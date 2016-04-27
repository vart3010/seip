<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\BoxBundle\Model\Adapter;

/**
 * Description of BaseAdapter
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class BoxBaseAdapter implements AdapterInterface
{
    protected $container;
    
    /**
     *
     * @var \Tecnocreaciones\Bundle\BoxBundle\Service\AreaRender
     */
    protected $areaRender;
    
    function setAreaRender(\Tecnocreaciones\Bundle\BoxBundle\Service\AreaRender $areaRender) 
    {
        $this->areaRender = $areaRender;
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
    
     /**
     * Get a user from the Security Context
     *
     * @return \Tecnocreaciones\Bundle\BoxBundle\Model\UserBoxInterface
     *
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    protected function getUser()
    {
        if (null === $token = $this->getSecurityContext()->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
    
    protected function isGranted($parameters)
    {
        return $this->getSecurityContext()->isGranted($parameters);
    }
    
    protected function getSecurityContext() {
        return $this->container->get('security.context');
    }

}
