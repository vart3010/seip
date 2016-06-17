<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Validator\Constraints;

use Symfony\Component\Validator\ConstraintValidator;

/**
 * Description of BaseConstraintValidator
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class BaseConstraintValidator extends ConstraintValidator implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    protected $container;
    
    protected function trans($id,array $parameters = array(), $domain = 'PequivenSEIPBundle')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * Shortcut to return the request service.
     *
     * @return \Symfony\Component\HttpFoundation\Request
     *
     */
    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }
}
