<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\SEIPBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of UserFixture
 *
 * @author matias
 */
class UserFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        //USUARIO ADMINISTRADOR POR DEFECTO

        $user = new User();
        $user->setUsername('admin');
        $user->setPlainPassword('12345');
        $user->setFirstName('Matias');
        $user->setLastName('Jimenez');
        $user->setEmail('matei249@gmail.com');
        $user->addRole('ROLE_SUPER_ADMIN');
        $user->setEnabled(true);
            $manager->persist($user);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 4;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


