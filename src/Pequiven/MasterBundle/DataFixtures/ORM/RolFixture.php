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
    protected $container;
    public function load(ObjectManager $manager){
        
        $rol_data = new Rol();
        
        //Personal PQV
        $rol = new Rol();
        $rol->setDescription('Personal PQV')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_WORKER_PQV))
            ->addRole(Rol::getRoleName(Rol::ROLE_WORKER_PQV))
            ->setName(Rol::getRoleName(Rol::ROLE_WORKER_PQV));
        
        $this->addReference(Rol::getRoleName(Rol::ROLE_WORKER_PQV), $rol);
            $manager->persist($rol);
        //Supervisor
        $rol = new Rol();
        $rol->setDescription('Supervisor')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_SUPERVISER))
            ->setName(Rol::getRoleName(Rol::ROLE_SUPERVISER))
            ->addRole(Rol::getRoleName(Rol::ROLE_SUPERVISER))
                ;
        $this->addReference(Rol::getRoleName(Rol::ROLE_SUPERVISER), $rol);
            $manager->persist($rol);
        //Coordinador, Superintendente
        $rol = new Rol();
        $rol->setDescription('Coordinador')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_COORDINATOR))
            ->setName(Rol::getRoleName(Rol::ROLE_COORDINATOR))
            ->addRole(Rol::getRoleName(Rol::ROLE_COORDINATOR))
                ;
        $this->addReference(Rol::getRoleName(Rol::ROLE_COORDINATOR), $rol);
            $manager->persist($rol);
        //Gerende 2da Línea
        $rol = new Rol();
        $rol->setDescription('Gerente 2da Línea')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_MANAGER_SECOND))
            ->setName(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND))
            ->addRole(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND));
        $this->addReference(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND), $rol);
            $manager->persist($rol);
            
        //Gerende 1ra Línea
        $rol = new Rol();
        $rol->setDescription('Gerente 1ra Línea')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_MANAGER_FIRST))
            ->setName(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST))
            ->addRole(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST));
            ;
        $this->addReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST), $rol);
            $manager->persist($rol);
        //Gerente General Complejo
        $rol = new Rol();
        $rol->setDescription('Gerente General')
             ->setLevel(Rol::getRoleLevel(Rol::ROLE_GENERAL_COMPLEJO))
             ->setName(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO))
            ->addRole(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO));
        $this->addReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO), $rol);
            $manager->persist($rol);
            
        //Junta Directiva
        $rol = new Rol();
        $rol->setDescription('Directivo')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_DIRECTIVE))
            ->setName(Rol::getRoleName(Rol::ROLE_DIRECTIVE))
            ->addRole(Rol::getRoleName(Rol::ROLE_DIRECTIVE));
        
        $this->addReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE), $rol);
            $manager->persist($rol);
        //Administrador
        $rol = new Rol();
        $rol->setDescription('Administrador')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_ADMIN))
            ->setName(Rol::getRoleName(Rol::ROLE_ADMIN))
            ->addRole(Rol::getRoleName(Rol::ROLE_ADMIN));
                
        $this->addReference(Rol::getRoleName(Rol::ROLE_ADMIN), $rol);
            $manager->persist($rol);
        //Super Administrador
        $rol = new Rol();
        $rol->setDescription('Super Administrador')
             ->setLevel(Rol::getRoleLevel(Rol::ROLE_SUPER_ADMIN))
             ->setName(Rol::getRoleName(Rol::ROLE_SUPER_ADMIN))
             ->addRole(Rol::getRoleName(Rol::ROLE_SUPER_ADMIN));
        
        $this->addReference(Rol::getRoleName(Rol::ROLE_SUPER_ADMIN), $rol);
            $manager->persist($rol);
            
        //Supervisor, Coordinador o Superintendente Temporal
        $rol = new Rol();
        $rol->setDescription('Supervisor Temporal')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_SUPERVISER_AUX))
            ->setName(Rol::getRoleName(Rol::ROLE_SUPERVISER_AUX))
            ->addRole(Rol::getRoleName(Rol::ROLE_SUPERVISER_AUX))
            ->setTypeRol(Rol::TYPE_ROL_AUX)
            ;
                
        $this->addReference(Rol::getRoleName(Rol::ROLE_SUPERVISER_AUX), $rol);
            $manager->persist($rol);
        //Gerende 2da Línea Temporal
        $rol = new Rol();
        $rol->setDescription('Gerente 2da Línea Temporal')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_MANAGER_SECOND_AUX))
            ->setName(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND_AUX))
            ->addRole(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND_AUX))
            ->setTypeRol(Rol::TYPE_ROL_AUX)
        ;
        
        $this->addReference(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND_AUX), $rol);
            $manager->persist($rol);
            
        //Gerende 1ra Línea Temporal
        $rol = new Rol();
        $rol->setDescription('Gerente 1ra Línea Temporal')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_MANAGER_FIRST_AUX))
            ->setName(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST_AUX))
            ->addRole(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST_AUX))
            ->setTypeRol(Rol::TYPE_ROL_AUX)
        ;
        
        $this->addReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST_AUX), $rol);
            $manager->persist($rol);
        //Gerende General Complejo Temporal
        $rol = new Rol();
        $rol->setDescription('Gerente General Temporal')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_GENERAL_COMPLEJO_AUX))
            ->setName(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX))
            ->addRole(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX))
            ->setTypeRol(Rol::TYPE_ROL_AUX)
        ;
        
        $this->addReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX), $rol);
            $manager->persist($rol);
        //Junta Directiva Temporal
        $rol = new Rol();
        $rol->setDescription('Directivo Temporal')
            ->setLevel(Rol::getRoleLevel(Rol::ROLE_DIRECTIVE_AUX))
            ->setName(Rol::getRoleName(Rol::ROLE_DIRECTIVE_AUX))
            ->addRole(Rol::getRoleName(Rol::ROLE_DIRECTIVE_AUX))
            ->setTypeRol(Rol::TYPE_ROL_AUX)
            ;
        
        $this->addReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE_AUX), $rol);
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
