<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tecnocreaciones\Bundle\BoxBundle\Service\Manager;

/**
 * Manejador del BoxORM
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class BoxManager implements \Tecnocreaciones\Bundle\BoxBundle\Model\BoxManagerInterface
{
    protected $classBox;
    
    private $container;
            
    function __construct($classBox) {
        $this->classBox = $classBox;
    }
    
    /**
     * 
     * @return \Tecnocreaciones\Bundle\BoxBundle\Model\ModelBox
     */
    public function createNew() {
        return new $this->classBox;
    }
    
    function buildModelBox($boxName, $areasName) {
        $areasName = $this->buildAreasName($areasName);
        $modelBox = $this->createNew();
        $modelBox
                ->setAreas($areasName)
                ->setBoxName($boxName)
                ;
        
        return $modelBox;
    }
    
    public function buildAreasName(array $areasName) {
        foreach ($areasName as $key => $areas) {
            $areasName[$areas] = array(
                'position' => 0,
                'template' => ''
            );
            unset($areasName[$key]);
        }
        return $areasName;
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
    
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
    
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
