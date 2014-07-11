<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\DataFixtures;

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
        
        $rol = new Rol();
        $rol->setDescription('Personal PQV');
        $rol->setLevelName($rol_data->rol_name[Rol::ROLE_WORKER_PQV]);
        $rol->setLevel(Rol::ROLE_WORKER_PQV);
        $rol->setEnabled(true);
        $this->addReference($rol_data->rol_name[Rol::ROLE_WORKER_PQV], $rol);
            $manager->persist($rol);
            
        $rol = new Rol();
        $rol->setDescription('Supervisor');
        $rol->setLevelName($rol_data->rol_name[Rol::ROLE_SUPERVISER]);
        $rol->setLevel(Rol::ROLE_SUPERVISER);
        $rol->setEnabled(true);
        $this->addReference($rol_data->rol_name[Rol::ROLE_SUPERVISER], $rol);
            $manager->persist($rol);
            
        $rol = new Rol();
        $rol->setDescription('Gerente 1ra Línea');
        $rol->setLevelName($rol_data->rol_name[Rol::ROLE_MANAGER_FIRST]);
        $rol->setLevel(Rol::ROLE_MANAGER_FIRST);
        $rol->setEnabled(true);
        $this->addReference($rol_data->rol_name[Rol::ROLE_MANAGER_FIRST], $rol);
            $manager->persist($rol);
            
        $rol = new Rol();
        $rol->setDescription('Gerente 2da Línea');
        $rol->setLevelName($rol_data->rol_name[Rol::ROLE_MANAGER_SECOND]);
        $rol->setLevel(Rol::ROLE_MANAGER_SECOND);
        $rol->setEnabled(true);
        $this->addReference($rol_data->rol_name[Rol::ROLE_MANAGER_SECOND], $rol);
            $manager->persist($rol);
            
        $rol = new Rol();
        $rol->setDescription('Directivo');
        $rol->setLevelName($rol_data->rol_name[Rol::ROLE_DIRECTIVE]);
        $rol->setLevel(Rol::ROLE_DIRECTIVE);
        $rol->setEnabled(true);
        $this->addReference($rol_data->rol_name[Rol::ROLE_DIRECTIVE], $rol);
            $manager->persist($rol);
            
        $rol = new Rol();
        $rol->setDescription('Administrador');
        $rol->setLevelName($rol_data->rol_name[Rol::ROLE_ADMIN]);
        $rol->setLevel(Rol::ROLE_ADMIN);
        $rol->setEnabled(true);
        $this->addReference($rol_data->rol_name[Rol::ROLE_ADMIN], $rol);
            $manager->persist($rol);
            
        $rol = new Rol();
        $rol->setDescription('Super Administrador');
        $rol->setLevelName($rol_data->rol_name[Rol::ROLE_SUPER_ADMIN]);
        $rol->setLevel(Rol::ROLE_SUPER_ADMIN);
        $rol->setEnabled(true);
        $this->addReference($rol_data->rol_name[Rol::ROLE_SUPER_ADMIN], $rol);
            $manager->persist($rol);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 5;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
