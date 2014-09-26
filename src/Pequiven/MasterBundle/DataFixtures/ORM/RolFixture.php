<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\Rol;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of RolFixture
 *
 * @author matias
 */
class RolFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $rol_data = new Rol();
        
        //Personal PQV
        $rol = new Rol();
        $rol->setDescription('Personal PQV')
            ->setLevel(Rol::ROLE_WORKER_PQV)
            ->addRole($rol_data->rol_name[Rol::ROLE_WORKER_PQV])
            ->setName($rol_data->rol_name[Rol::ROLE_WORKER_PQV]);
        
        $this->addReference($rol_data->rol_name[Rol::ROLE_WORKER_PQV], $rol);
            $manager->persist($rol);
        //Supervisor, Coordinador o Superintendente    
        $rol = new Rol();
        $rol->setDescription('Supervisor')
            ->setName($rol_data->rol_name[Rol::ROLE_SUPERVISER])
            ->setLevel(Rol::ROLE_SUPERVISER)
            ->addRole($rol_data->rol_name[Rol::ROLE_SUPERVISER])
                ;
        $this->addReference($rol_data->rol_name[Rol::ROLE_SUPERVISER], $rol);
            $manager->persist($rol);
        //Gerende 2da Línea
        $rol = new Rol();
        $rol->setDescription('Gerente 2da Línea')
            ->setName($rol_data->rol_name[Rol::ROLE_MANAGER_SECOND])
            ->setLevel(Rol::ROLE_MANAGER_SECOND)
            ->addRole($rol_data->rol_name[Rol::ROLE_MANAGER_SECOND]);
        $this->addReference($rol_data->rol_name[Rol::ROLE_MANAGER_SECOND], $rol);
            $manager->persist($rol);
            
        //Gerende 1ra Línea
        $rol = new Rol();
        $rol->setDescription('Gerente 1ra Línea')
            ->setName($rol_data->rol_name[Rol::ROLE_MANAGER_FIRST])
            ->setLevel(Rol::ROLE_MANAGER_FIRST)
            ->addRole($rol_data->rol_name[Rol::ROLE_MANAGER_FIRST]);
            ;
        $this->addReference($rol_data->rol_name[Rol::ROLE_MANAGER_FIRST], $rol);
            $manager->persist($rol);
        //Gerente General Complejo
        $rol = new Rol();
        $rol->setDescription('Gerente General')
             ->setName($rol_data->rol_name[Rol::ROLE_GENERAL_COMPLEJO])
             ->setLevel(Rol::ROLE_GENERAL_COMPLEJO)
            ->addRole($rol_data->rol_name[Rol::ROLE_GENERAL_COMPLEJO]);
        $this->addReference($rol_data->rol_name[Rol::ROLE_GENERAL_COMPLEJO], $rol);
            $manager->persist($rol);
            
        //Junta Directiva
        $rol = new Rol();
        $rol->setDescription('Directivo')
            ->setName($rol_data->rol_name[Rol::ROLE_DIRECTIVE])
            ->setLevel(Rol::ROLE_DIRECTIVE)
            ->addRole($rol_data->rol_name[Rol::ROLE_DIRECTIVE]);
        
        $this->addReference($rol_data->rol_name[Rol::ROLE_DIRECTIVE], $rol);
            $manager->persist($rol);
        //Administrador
        $rol = new Rol();
        $rol->setDescription('Administrador')
            ->setName($rol_data->rol_name[Rol::ROLE_ADMIN])
            ->setLevel(Rol::ROLE_ADMIN)
            ->addRole($rol_data->rol_name[Rol::ROLE_ADMIN]);
                
        $this->addReference($rol_data->rol_name[Rol::ROLE_ADMIN], $rol);
            $manager->persist($rol);
        //Super Administrador
        $rol = new Rol();
        $rol->setDescription('Super Administrador')
             ->setName($rol_data->rol_name[Rol::ROLE_SUPER_ADMIN])
             ->setLevel(Rol::ROLE_SUPER_ADMIN)
             ->addRole($rol_data->rol_name[Rol::ROLE_SUPER_ADMIN]);
        
        $this->addReference($rol_data->rol_name[Rol::ROLE_SUPER_ADMIN], $rol);
            $manager->persist($rol);
            
        //Supervisor, Coordinador o Superintendente Temporal
        $rol = new Rol();
        $rol->setDescription('Supervisor Temporal')
            ->setName($rol_data->rol_name[Rol::ROLE_SUPERVISER_AUX])
            ->setLevel(Rol::ROLE_SUPERVISER_AUX)
            ->addRole($rol_data->rol_name[Rol::ROLE_SUPERVISER_AUX]);
                
        $this->addReference($rol_data->rol_name[Rol::ROLE_SUPERVISER_AUX], $rol);
            $manager->persist($rol);
        //Gerende 2da Línea Temporal
        $rol = new Rol();
        $rol->setDescription('Gerente 2da Línea Temporal')
            ->setName($rol_data->rol_name[Rol::ROLE_MANAGER_SECOND_AUX])
            ->setLevel(Rol::ROLE_MANAGER_SECOND_AUX)
            ->addRole($rol_data->rol_name[Rol::ROLE_MANAGER_SECOND_AUX]);
        
        $this->addReference($rol_data->rol_name[Rol::ROLE_MANAGER_SECOND_AUX], $rol);
            $manager->persist($rol);
            
        //Gerende 1ra Línea Temporal
        $rol = new Rol();
        $rol->setDescription('Gerente 1ra Línea Temporal')
            ->setName($rol_data->rol_name[Rol::ROLE_MANAGER_FIRST_AUX])
            ->setLevel(Rol::ROLE_MANAGER_FIRST_AUX)
            ->addRole($rol_data->rol_name[Rol::ROLE_MANAGER_FIRST_AUX]);
        
        $this->addReference($rol_data->rol_name[Rol::ROLE_MANAGER_FIRST_AUX], $rol);
            $manager->persist($rol);
        //Gerende General Complejo Temporal
        $rol = new Rol();
        $rol->setDescription('Gerente General Temporal')
            ->setName($rol_data->rol_name[Rol::ROLE_GENERAL_COMPLEJO_AUX])
            ->setLevel(Rol::ROLE_GENERAL_COMPLEJO_AUX)
            ->addRole($rol_data->rol_name[Rol::ROLE_GENERAL_COMPLEJO_AUX]);
        
        $this->addReference($rol_data->rol_name[Rol::ROLE_GENERAL_COMPLEJO_AUX], $rol);
            $manager->persist($rol);
        //Junta Directiva Temporal
        $rol = new Rol();
        $rol->setDescription('Directivo Temporal')
            ->setName($rol_data->rol_name[Rol::ROLE_DIRECTIVE_AUX])
            ->setLevel(Rol::ROLE_DIRECTIVE_AUX)
            ->addRole($rol_data->rol_name[Rol::ROLE_DIRECTIVE_AUX]);
        
        $this->addReference($rol_data->rol_name[Rol::ROLE_DIRECTIVE_AUX], $rol);
            $manager->persist($rol);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 6;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
