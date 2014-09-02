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
use Pequiven\MasterBundle\Entity\Complejo;
use Pequiven\MasterBundle\Entity\Gerencia;
use Pequiven\MasterBundle\Entity\GerenciaSecond;
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
        $user->setUsername('directive');
        $user->setPlainPassword('12345');
        $user->setFirstName('Francisco');
        $user->setLastName('Mejias');
        $user->setEmail('franmejias@pequiven.com');
        $user->setNumPersonal(10019742);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->addRole('ROLE_DIRECTIVE');
        $user->setEnabled(true);
        $this->addReference('d-10019742', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_d');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Escalona');
        $user->setEmail('veescalona@pequiven.com');
        $user->setNumPersonal(10016012);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->addRole('ROLE_DIRECTIVE_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('d-10019742'));
            $manager->persist($user);
            
        //Usuarios Gerente 1ra Línea
        $user = new User();
        $user->setUsername('vandrades');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Andrades');
        $user->setEmail('victorandrades@pequiven.com');
        $user->setNumPersonal(10015700);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $user->addRole('ROLE_MANAGER_FIRST');
        $user->setEnabled(true);
        $this->addReference('mf-10015700', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_ggm');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Escalona');
        $user->setEmail('victorescalona@pequiven.com');
        $user->setNumPersonal(10016012);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]));
        $user->addRole('ROLE_MANAGER_FIRST_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('mf-10015700'));
            $manager->persist($user);
        
        $user = new User();
        $user->setUsername('wnavarro');
        $user->setPlainPassword('12345');
        $user->setFirstName('Wilfredo');
        $user->setLastName('Navarro');
        $user->setEmail('wilfredonavarro@pequiven.com');
        $user->setNumPersonal(10018009);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $user->addRole('ROLE_MANAGER_FIRST');
        $user->setEnabled(true);
        $this->addReference('mf-10018009', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_ggamc');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Escalona');
        $user->setEmail('victorescalona@pequiven.com');
        $user->setNumPersonal(10016012);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]));
        $user->addRole('ROLE_MANAGER_FIRST_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('mf-10018009'));
            $manager->persist($user);
        
        $user = new User();
        $user->setUsername('mgracia');
        $user->setPlainPassword('12345');
        $user->setFirstName('Manuel');
        $user->setLastName('Garcia');
        $user->setEmail('manuelgarcia@pequiven.com');
        $user->setNumPersonal(10017367);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
        $user->addRole('ROLE_MANAGER_FIRST');
        $user->setEnabled(true);
        $this->addReference('mf-10017367', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_ggjaa');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Escalona');
        $user->setEmail('victorescalona@pequiven.com');
        $user->setNumPersonal(10016012);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]));
        $user->addRole('ROLE_MANAGER_FIRST_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('mf-10017367'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('fquintero');
        $user->setPlainPassword('12345');
        $user->setFirstName('Freddy');
        $user->setLastName('Quintero');
        $user->setEmail('freddyquintero@pequiven.com');
        $user->setNumPersonal(10012577);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]));
        $user->addRole('ROLE_MANAGER_FIRST');
        $user->setEnabled(true);
        $this->addReference('mf-10012577', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_ggnavay');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Escalona');
        $user->setEmail('victorescalona@pequiven.com');
        $user->setNumPersonal(10016012);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]));
        $user->addRole('ROLE_MANAGER_FIRST_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('mf-10012577'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('golivo');
        $user->setPlainPassword('12345');
        $user->setFirstName('Georgina');
        $user->setLastName('Olivo');
        $user->setEmail('geolivo@pequiven.com');
        $user->setNumPersonal(10019081);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $user->addRole('ROLE_MANAGER_FIRST');
        $user->setEnabled(true);
        $this->addReference('mf-10019081', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona_mf');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Escalona');
        $user->setEmail('veescalona@pequiven.com');
        $user->setNumPersonal(10016012);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $user->addRole('ROLE_MANAGER_FIRST_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('d-10019742'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('aguararima_mf');
        $user->setPlainPassword('12345');
        $user->setFirstName('Adilia');
        $user->setLastName('Guararima');
        $user->setEmail('adguararima@pequiven.com');
        $user->setNumPersonal(10003393);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $user->addRole('ROLE_MANAGER_FIRST_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('mf-10019081'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('fzapata');
        $user->setPlainPassword('12345');
        $user->setFirstName('Fidel');
        $user->setLastName('Zapata');
        $user->setEmail('fidelzapata@pequiven.com');
        $user->setNumPersonal(10016450);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_UNFER]));
        $user->addRole('ROLE_MANAGER_FIRST');
        $user->setEnabled(true);
        $this->addReference('mf_10016450', $user);
            $manager->persist($user);
            
        //Usuarios Gerente 2da Línea
        $user = new User();
        $user->setUsername('jmendez');
        $user->setPlainPassword('12345');
        $user->setFirstName('Joniel');
        $user->setLastName('Mendez');
        $user->setEmail('joniel@pequiven.com');
        $user->setNumPersonal(10016029);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]));
        $user->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_AIT_CPM]));
        $user->addRole('ROLE_MANAGER_SECOND');
        $user->setEnabled(true);
        $this->addReference('ms-10016029', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('vescalona');
        $user->setPlainPassword('12345');
        $user->setFirstName('Victor');
        $user->setLastName('Escalona');
        $user->setEmail('veescalona@pequiven.com');
        $user->setNumPersonal(10016012);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $user->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]));
        $user->addRole('ROLE_MANAGER_SECOND');
        $user->setEnabled(true);
        $this->addReference('ms-10016012', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('aguararima');
        $user->setPlainPassword('12345');
        $user->setFirstName('Adilia');
        $user->setLastName('Guararima');
        $user->setEmail('adguararima@pequiven.com');
        $user->setNumPersonal(10003393);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]));
        $user->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_PLANIFICACION_Y_GESTION_SALUD_ZIV]));
        $user->addRole('ROLE_MANAGER_SECOND');
        $user->setEnabled(true);
        $this->addReference('ms-10003393', $user);
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('nguedez_ms');
        $user->setPlainPassword('12345');
        $user->setFirstName('Norwis');
        $user->setLastName('Guedez');
        $user->setEmail('norwisgue@pequiven.com');
        $user->setNumPersonal(10017701);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $user->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]));
        $user->addRole('ROLE_MANAGER_SECOND_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('ms-10016012'));
            $manager->persist($user);
            
        $user = new User();
        $user->setUsername('cchavez_ms');
        $user->setPlainPassword('12345');
        $user->setFirstName('Carmen');
        $user->setLastName('Chavez');
        $user->setEmail('riarias@pequiven.com');
        $user->setNumPersonal(10021125);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $user->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]));
        $user->addRole('ROLE_MANAGER_SECOND_AUX');
        $user->setEnabled(true);
        $user->setParent($this->getReference('ms-10016012'));
            $manager->persist($user);
            
        //Usuarios Supervisor, Coordinador o Superintendente
        $user = new User();
        $user->setUsername('rarias');
        $user->setPlainPassword('12345');
        $user->setFirstName('Richard');
        $user->setLastName('Arias');
        $user->setEmail('riarias@pequiven.com');
        $user->setNumPersonal(10019618);
        $user->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $user->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]));
        $user->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]));
        $user->addRole('ROLE_SUPERVISER');
        $user->setEnabled(true);
            $manager->persist($user);
            
        //Usuario Personal PQV
        $user = new User();
        $user->setUsername('worker');
        $user->setPlainPassword('12345');
        $user->setFirstName('Junior');
        $user->setEmail('junior@gmail.com');
        $user->addRole('ROLE_WORKER_PQV');
        $user->setEnabled(true);
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


