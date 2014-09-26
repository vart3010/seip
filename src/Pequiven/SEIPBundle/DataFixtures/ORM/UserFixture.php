<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\Complejo;
use Pequiven\MasterBundle\Entity\Gerencia;
use Pequiven\MasterBundle\Entity\GerenciaSecond;
use Pequiven\MasterBundle\Entity\Rol;
use Pequiven\SEIPBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Description of UserFixture
 *
 * @author matias
 */
class UserFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    protected $container;
    public function load(ObjectManager $manager){
        
        $complejo_data = new Complejo();
        $complejoNameArray = $complejo_data->getRefNameArray();
        
        $gerencia_data = new Gerencia();
        $gerenciaNameArray = $gerencia_data->getRefNameArray();
        
        $gerenciaSecond_data = new GerenciaSecond();
        $gerenciaSecondNameArray = $gerenciaSecond_data->getRefNameArray();
        
        //USUARIO ADMINISTRADOR POR DEFECTO
        $user = new User();
        $user->setUsername('admin');
        $user->setPlainPassword('12345');
        $user->setFirstName('Matias');
        $user->setLastName('Jimenez');
        $user->setEmail('matei249@gmail.com');
        $user->addRole('ROLE_SUPER_ADMIN');
        $user->setEnabled(true);
        $this->addReference('SUPER_ADMIN', $user);
            $manager->persist($user);
            
        //Usuarios Directivo
        $user = new User();
        $user->setUsername('directive')
            ->setPlainPassword('12345')
            ->setFirstName('Francisco')
            ->setLastName('Mejias')
            ->setEmail('franmejias@pequiven.com')
            ->setNumPersonal(10019742)
            ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
            ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE)))
            ;
        $this->addReference('d-10019742', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_d')
            ->setPlainPassword('12345')
            ->setFirstName('Victor')
            ->setLastName('Escalona')
            ->setEmail('veescalona@pequiven.com')
            ->setNumPersonal(10016012)
            ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
            ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE_AUX)))
            ;
        $user->setParent($this->getReference('d-10019742'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('cchavez_d')
            ->setPlainPassword('12345')
            ->setFirstName('Carmen')
            ->setLastName('Chavez')
            ->setEmail('cchavez@pequiven.com')
            ->setNumPersonal(10021125)
            ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
            ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE_AUX)))
            ->setParent($this->getReference('d-10019742'));
            $manager->persist($user);
        
        $user = new User();
        $user->setUsername('rarias_d')
            ->setPlainPassword('12345')
            ->setFirstName('Richard')
            ->setLastName('Arias')
            ->setEmail('rarias@pequiven.com')
            ->setNumPersonal(10019618)
            ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
            ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE_AUX)))
            ->setParent($this->getReference('d-10019742'));
            $manager->persist($user);
            
        //Usuarios Gerente Generales Complejo (Análogo a Gerente 1ra línea)
        $user = new User();
        $user->setUsername('vandrades')
            ->setPlainPassword('12345')
            ->setFirstName('Victor')
            ->setLastName('Andrades')
            ->setEmail('victorandrades@pequiven.com')
            ->setNumPersonal(10015700)
            ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
            ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]))
            ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO)))
            ;
        $this->addReference('mf-10015700', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_ggm')
            ->setPlainPassword('12345')
            ->setFirstName('Victor')
            ->setLastName('Escalona')
            ->setEmail('victorescalona@pequiven.com')
            ->setNumPersonal(10016012)
            ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
            ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]))
            ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX)))
            ->setParent($this->getReference('mf-10015700'));
            $manager->persist($user);
        
        $user = new User();
        $user->setUsername('wnavarro')
             ->setPlainPassword('12345')
             ->setFirstName('Wilfredo')
             ->setLastName('Navarro')
             ->setEmail('wilfredonavarro@pequiven.com')
             ->setNumPersonal(10018009)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO)))
            ;
        $this->addReference('mf-10018009', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_ggamc')
             ->setPlainPassword('12345')
             ->setFirstName('Victor')
             ->setLastName('Escalona')
             ->setEmail('victorescalona@pequiven.com')
             ->setNumPersonal(10016012)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX)))
             ->setParent($this->getReference('mf-10018009'));
            $manager->persist($user);
        
        $user = new User();
        $user->setUsername('mgracia')
             ->setPlainPassword('12345')
             ->setFirstName('Manuel')
             ->setLastName('Garcia')
             ->setEmail('manuelgarcia@pequiven.com')
             ->setNumPersonal(10017367)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO)))
                ;
        $this->addReference('mf-10017367', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_ggjaa')
             ->setPlainPassword('12345')
             ->setFirstName('Victor')
             ->setLastName('Escalona')
             ->setEmail('victorescalona@pequiven.com')
             ->setNumPersonal(10016012)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX)));
        $user->setParent($this->getReference('mf-10017367'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('fquintero')
             ->setPlainPassword('12345')
             ->setFirstName('Freddy')
             ->setLastName('Quintero')
             ->setEmail('freddyquintero@pequiven.com')
             ->setNumPersonal(10012577)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO)));
        $this->addReference('mf-10012577', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_ggnavay')
             ->setPlainPassword('12345')
             ->setFirstName('Victor')
             ->setLastName('Escalona')
             ->setEmail('victorescalona@pequiven.com')
             ->setNumPersonal(10016012)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX)))
             ->setParent($this->getReference('mf-10012577'));
            $manager->persist($user);
            
        //Usuarios Gerente 1ra Línea
        $user = new User();
        $user->setUsername('golivo')
             ->setPlainPassword('12345')
             ->setFirstName('Georgina')
             ->setLastName('Olivo')
             ->setEmail('geolivo@pequiven.com')
             ->setNumPersonal(10019081)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)));
        $this->addReference('mf-10019081', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_mf')
             ->setPlainPassword('12345')
             ->setFirstName('Victor')
             ->setLastName('Escalona')
             ->setEmail('veescalona@pequiven.com')
             ->setNumPersonal(10016012)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST_AUX)))
             ->setParent($this->getReference('d-10019742'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('aguararima_mf')
             ->setPlainPassword('12345')
             ->setFirstName('Adilia')
             ->setLastName('Guararima')
             ->setEmail('adguararima@pequiven.com')
             ->setNumPersonal(10003393)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST_AUX)))
             ->setParent($this->getReference('mf-10019081'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('fzapata')
             ->setPlainPassword('12345')
             ->setFirstName('Fidel')
             ->setLastName('Zapata')
             ->setEmail('fidelzapata@pequiven.com')
             ->setNumPersonal(10016450)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_UNFER]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)));
                
        $this->addReference('mf_10016450', $user);
            $manager->persist($user);
            
        //Usuarios Gerente 2da Línea
        $user = new User();
        $user->setUsername('jmendez')
             ->setPlainPassword('12345')
             ->setFirstName('Joniel')
             ->setLastName('Mendez')
             ->setEmail('joniel@pequiven.com')
             ->setNumPersonal(10016029)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]))
             ->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_AIT_CPM]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND)))
                ;
        $this->addReference('ms-10016029', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona')
             ->setPlainPassword('12345')
             ->setFirstName('Victor')
             ->setLastName('Escalona')
             ->setEmail('veescalona@pequiven.com')
             ->setNumPersonal(10016012)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]))
            ->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]))
            ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND)))
                ;
        $this->addReference('ms-10016012', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('aguararima')
             ->setPlainPassword('12345')
             ->setFirstName('Adilia')
             ->setLastName('Guararima')
             ->setEmail('adguararima@pequiven.com')
             ->setNumPersonal(10003393)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]))
             ->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_GESTION_SALUD_ZIV]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND)))
                ;
        $this->addReference('ms-10003393', $user);
            $manager->persist($user);
            
//        $user = new User();
//        $user->setUsername('nguedez_ms');
//        $user->setPlainPassword('12345');
//        $user->setFirstName('Norwis');
//        $user->setLastName('Guedez');
//        $user->setEmail('norwisgue@pequiven.com');
//        $user->setNumPersonal(10017701);
//        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
//        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
//        $user->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]));
//        $user->addRole('ROLE_MANAGER_SECOND_AUX');
//        $user->setEnabled(true);
//        $user->setParent($this->getReference('ms-10016012'));
//            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('cchavez_ms')
             ->setPlainPassword('12345')
             ->setFirstName('Carmen')
             ->setLastName('Chavez')
             ->setEmail('cchavez@pequiven.com')
             ->setNumPersonal(10021125)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]))
             ->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND_AUX)))
             ->setParent($this->getReference('ms-10016012'));
            $manager->persist($user);
        
        $user = new User();
        $user->setUsername('rarias_ms')
             ->setPlainPassword('12345')
             ->setFirstName('Richard')
             ->setLastName('Arias')
             ->setEmail('rarias@pequiven.com')
             ->setNumPersonal(10019618)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]))
             ->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_SECOND_AUX)))
             ->setParent($this->getReference('ms-10016012'));
            $manager->persist($user);
            
        //Usuarios Supervisor, Coordinador o Superintendente
        $user = new User();
        $user->setUsername('rarias')
             ->setPlainPassword('12345')
             ->setFirstName('Richard')
             ->setLastName('Arias')
             ->setEmail('riarias@pequiven.com')
             ->setNumPersonal(10019618)
             ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
             ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]))
             ->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]))
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_SUPERVISER)))
                ;
            $manager->persist($user);
            
        //Usuario Personal PQV
        $user = new User();
        $user->setUsername('worker')
             ->setPlainPassword('12345')
             ->setFirstName('Junior')
             ->setEmail('junior@gmail.com')
             ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_WORKER_PQV)))
             ;
            $manager->persist($user);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 7;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


