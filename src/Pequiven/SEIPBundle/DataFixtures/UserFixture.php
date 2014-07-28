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
        
        $user = new User();
        $user->setUsername('directive');
        $user->setPlainPassword('12345');
        $user->setFirstName('Francisco');
        $user->setLastName('Mejias');
        $user->setEmail('franmejias@pequiven.com');
        $user->addRole('ROLE_DIRECTIVE');
        $user->setEnabled(true);
        $this->addReference('directive', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('manager_first');
        $user->setPlainPassword('12345');
        $user->setFirstName('Georgina');
        $user->setLastName('Olivo');
        $user->setEmail('geolivo@pequiven.com');
        $user->setNumPersonal(10019081);
        $user->addRole('ROLE_MANAGER_FIRST');
        $user->setEnabled(true);
        $this->addReference('manager_first-10019081', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('manager_first_moron');
        $user->setPlainPassword('12345');
        $user->setFirstName('Joniel');
        $user->setLastName('Mendez');
        $user->setEmail('joniel@pequiven.com');
        $user->setNumPersonal(10016029);
        $user->addRole('ROLE_MANAGER_FIRST');
        $user->setEnabled(true);
        $this->addReference('manager_first-10016029', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('manager_second');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Escalona');
        $user->setEmail('veescalona@pequiven.com');
        $user->setNumPersonal(10016012);
        $user->addRole('ROLE_MANAGER_SECOND');
        $user->setEnabled(true);
        $this->addReference('manager_second-10016012', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('superviser');
        $user->setPlainPassword('12345');
        $user->setFirstName('Richard');
        $user->setLastName('Arias');
        $user->setEmail('riarias@pequiven.com');
        $user->addRole('ROLE_SUPERVISER');
        $user->setEnabled(true);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('worker');
        $user->setPlainPassword('12345');
        $user->setFirstName('Junior');
        $user->setEmail('junior@gmail.com');
        $user->addRole('ROLE_WORKER_PQV');
        $user->setEnabled(true);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('manager_second_adilia');
        $user->setPlainPassword('12345');
        $user->setFirstName('Adilia');
        $user->setLastName('Guararima');
        $user->setEmail('adguararima@pequiven.com');
        $user->setNumPersonal(10003393);
        $user->addRole('ROLE_MANAGER_SECOND');
        $user->setEnabled(true);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('manager_first_aux_adilia');
        $user->setPlainPassword('12345');
        $user->setFirstName('Adilia');
        $user->setLastName('Guararima');
        $user->setEmail('adguararima@pequiven.com');
        $user->setNumPersonal(10003393);
        $user->addRole('ROLE_MANAGER_FIRST_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('manager_first-10019081'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('manager_second_aux_norwis');
        $user->setPlainPassword('12345');
        $user->setFirstName('Norwis');
        $user->setLastName('Guedez');
        $user->setEmail('norwisgue@pequiven.com');
        $user->setNumPersonal(10017701);
        $user->addRole('ROLE_MANAGER_SECOND_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('manager_second-10016012'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('manager_second_aux_david');
        $user->setPlainPassword('12345');
        $user->setFirstName('David');
        $user->setLastName('Alvarado');
        $user->setEmail('davidalv@pequiven.com');
        $user->setNumPersonal(10021906);
        $user->addRole('ROLE_MANAGER_SECOND_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('manager_second-10016012'));
            $manager->persist($user);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 6;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


