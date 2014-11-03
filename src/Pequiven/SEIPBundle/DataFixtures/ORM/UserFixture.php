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
use Pequiven\MasterBundle\Entity\Direction;
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

    public function load(ObjectManager $manager) {

        $direction_data = new Direction();
        $directionNameArray = $direction_data->getRefNameArray();
        
        $complejo_data = new Complejo();
        $complejoNameArray = $complejo_data->getRefNameArray();

        $gerencia_data = new Gerencia();
        $gerenciaNameArray = $gerencia_data->getRefNameArray();

        $gerenciaSecond_data = new GerenciaSecond();
        $gerenciaSecondNameArray = $gerenciaSecond_data->getRefNameArray();

        //USUARIO ADMINISTRADOR POR DEFECTO
        $user = new User();
        $user->setUsername('admin')
                ->setPlainPassword('12345')
                ->setFirstName('Administrador')
                ->setLastName('SEIP')
                ->setEmail('matei249@gmail.com')
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_SUPER_ADMIN)))
                ->setEnabled(true)
        ;
        $this->addReference('SUPER_ADMIN', $user);
        $manager->persist($user);

        //Usuarios Directivo
        $user = new User();
        $user->setUsername('jdepablos')
                ->setPlainPassword('12345')
                ->setFirstName('Juan Carlos')
                ->setLastName('De Pablos')
                ->setEmail('jdepablos@pequiven.com')
                ->setNumPersonal(10002520)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE)))
                ->setEnabled(true)
        ;
        $this->addReference('d-10002520', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('jlperez')
                ->setPlainPassword('12345')
                ->setFirstName('Jose Luis')
                ->setLastName('Perez')
                ->setEmail('jlperez@pequiven.com')
                ->setNumPersonal(10017424)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE)))
                ->setEnabled(true)
        ;
        $this->addReference('d-10017424', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('sencinozo')
                ->setPlainPassword('12345')
                ->setFirstName('Sonia')
                ->setLastName('Encinozo')
                ->setEmail('sencinozo@pequiven.com')
                ->setNumPersonal(10019891)
                ->setDirection($this->getReference($directionNameArray[Direction::DIRECTION_RRHH]))
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE)))
                ->setEnabled(true)
        ;
        $this->addReference('d-10019891', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('bhernandez')
                ->setPlainPassword('12345')
                ->setFirstName('Betulio')
                ->setLastName('Hernandez')
                ->setEmail('bhernandez@pequiven.com')
                ->setNumPersonal(10004813)
                ->setDirection($this->getReference($directionNameArray[Direction::DIRECTION_PROYECTOS]))
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_DIRECTIVE)))
                ->setEnabled(true)
        ;
        $this->addReference('d-10004813', $user);
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
                ->setEnabled(true)
        ;
        $user->setParent($this->getReference('d-10002520'));
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
                ->setParent($this->getReference('d-10002520'))
                ->setEnabled(true);
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
                ->setEnabled(true)
                ->setParent($this->getReference('d-10002520'));

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
                ->setEnabled(true)
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
                ->setParent($this->getReference('mf-10015700'))
                ->setEnabled(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('rpereira_ggm')
                ->setPlainPassword('12345')
                ->setFirstName('Ricardo')
                ->setLastName('Pereira')
                ->setEmail('rpereira@pequiven.com')
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX)))
                ->setParent($this->getReference('mf-10015700'))
                ->setEnabled(true);
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
                ->setEnabled(true)
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
                ->setParent($this->getReference('mf-10018009'))
                ->setEnabled(true)
        ;
        $manager->persist($user);

        $user = new User();
        $user->setUsername('mizquierdo_ggamc')
                ->setPlainPassword('12345')
                ->setFirstName('Marygher')
                ->setLastName('Izquierdo')
                ->setEmail('mizquierdo@pequiven.com')
                ->setNumPersonal(10018925)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX)))
                ->setParent($this->getReference('mf-10018009'))
                ->setEnabled(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('mgarcia')
                ->setPlainPassword('12345')
                ->setFirstName('Manuel')
                ->setLastName('Garcia')
                ->setEmail('manuelgarcia@pequiven.com')
                ->setNumPersonal(10017367)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO)))
                ->setEnabled(true)
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
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX)))
                ->setParent($this->getReference('mf-10017367'))
                ->setEnabled(true)
        ;
        $manager->persist($user);

        $user = new User();
        $user->setUsername('grojas_ggjaa')
                ->setPlainPassword('12345')
                ->setFirstName('George')
                ->setLastName('Rojas')
                ->setEmail('grojas_ggjaa@pequiven.com')
                ->setNumPersonal(10016012)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO_AUX)))
                ->setParent($this->getReference('mf-10017367'))
                ->setEnabled(true);
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
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_GENERAL_COMPLEJO)))
                ->setEnabled(true)
        ;
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
                ->setParent($this->getReference('mf-10012577'))
                ->setEnabled(true)
;
        $manager->persist($user);

        //Usuarios Gerente 1ra Línea
        $user = new User();
        $user->setUsername('lgonzalez')
                ->setPlainPassword('12345')
                ->setFirstName('Luis')
                ->setLastName('Gonzalez')
                ->setEmail('lgonzalez@pequiven.com')
                ->setNumPersonal(10017551)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_ADMINISTRACION_Y_SERVICIOS]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true);
        $this->addReference('mf-10017551', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('pvelasco')
                ->setPlainPassword('12345')
                ->setFirstName('Pedro')
                ->setLastName('Velasco')
                ->setEmail('pvelasco@pequiven.com')
                ->setNumPersonal(10018424)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true);
        $this->addReference('mf-10018424', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('ahernandez')
                ->setPlainPassword('12345')
                ->setFirstName('Aldrin')
                ->setLastName('Hernandez')
                ->setEmail('ahernandez@pequiven.com')
                ->setNumPersonal(10017405)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true);
        $this->addReference('mf-10017405', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('golivo')
                ->setPlainPassword('12345')
                ->setFirstName('Georgina')
                ->setLastName('Olivo')
                ->setEmail('geolivo@pequiven.com')
                ->setNumPersonal(10019081)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SALUD]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true);
        $this->addReference('mf-10019081', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('ssilva')
                ->setPlainPassword('12345')
                ->setFirstName('Saul')
                ->setLastName('Silva')
                ->setEmail('ssilva@pequiven.com')
                ->setNumPersonal(10018451)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true);
        $this->addReference('mf-10018451', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('acastillo')
                ->setPlainPassword('12345')
                ->setFirstName('Andrés')
                ->setLastName('Castillo')
                ->setEmail('acastillo@pequiven.com')
                ->setNumPersonal(10004527)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_FINANZAS]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true);
        $this->addReference('mf-10004527', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('jmora-contrataciones')
                ->setPlainPassword('12345')
                ->setFirstName('Jesús')
                ->setLastName('Mora (Contrataciones)')
                ->setEmail('jmora@pequiven.com')
                ->setNumPersonal(10021743)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_CONTRATACIONES]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true);
        $this->addReference('mf-10021743', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('sencinozo-mf')
                ->setPlainPassword('12345')
                ->setFirstName('Sonia')
                ->setLastName('Encinozo')
                ->setEmail('sencinozo@pequiven.com')
                ->setNumPersonal(10019891)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST_AUX)))
                ->setParent($this->getReference('d-10019891'))
                ->setEnabled(true);
        $this->addReference('mf-10019891', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('vjalvarado')
                ->setPlainPassword('12345')
                ->setFirstName('Victor José')
                ->setLastName('Alvarado')
                ->setEmail('vjalvarado@pequiven.com')
                ->setNumPersonal(10024000)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10024000', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('favinzano')
                ->setPlainPassword('12345')
                ->setFirstName('Felipe')
                ->setLastName('Avinzano')
                ->setEmail('favinzano@pequiven.com')
                ->setNumPersonal(10019814)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10019814', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('mlinares')
                ->setPlainPassword('12345')
                ->setFirstName('Medardo')
                ->setLastName('Linares')
                ->setEmail('mlinares@pequiven.com')
                ->setNumPersonal(10019082)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_ESTIMACION_COSTOS]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10019082', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('jabdouche')
                ->setPlainPassword('12345')
                ->setFirstName('José')
                ->setLastName('Abdouche')
                ->setEmail('jabdouche@pequiven.com')
                ->setNumPersonal(10017550)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10017550', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('cmonque')
                ->setPlainPassword('12345')
                ->setFirstName('Carmen')
                ->setLastName('Monque')
                ->setEmail('cmonque@pequiven.com')
                ->setNumPersonal(10020858)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10020858', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('jmora-cgpresidencia')
                ->setPlainPassword('12345')
                ->setFirstName('Jesús')
                ->setLastName('Mora (Presidencia)')
                ->setEmail('jmora-cgpresidencia@pequiven.com')
                ->setNumPersonal(10021743)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10021743', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('cdiaz')
                ->setPlainPassword('12345')
                ->setFirstName('Carlos')
                ->setLastName('Diaz')
                ->setEmail('cdiaz@pequiven.com')
                ->setNumPersonal(10019276)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10019276', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('jboulanger')
                ->setPlainPassword('12345')
                ->setFirstName('José')
                ->setLastName('Boulanger')
                ->setEmail('jboulanger@pequiven.com')
                ->setNumPersonal(10001757)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_INTERNACIONALES]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10001757', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('dmarquez')
                ->setPlainPassword('12345')
                ->setFirstName('Daniel')
                ->setLastName('Márquez')
                ->setEmail('dmarquez@pequiven.com')
                ->setNumPersonal(10020572)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_DESARROLLO_SOCIAL]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10020572', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('ngonzalez')
                ->setPlainPassword('12345')
                ->setFirstName('Nerea')
                ->setLastName('Gonzalez')
                ->setEmail('ngonzalez@pequiven.com')
                ->setNumPersonal(10002209)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTOS_MORON]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10002209', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('jmontero')
                ->setPlainPassword('12345')
                ->setFirstName('Jorge')
                ->setLastName('Montero')
                ->setEmail('jmontero@pequiven.com')
                ->setNumPersonal(10016088)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10016088', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('krangel')
                ->setPlainPassword('12345')
                ->setFirstName('Kertin')
                ->setLastName('Rangel')
                ->setEmail('krangel@pequiven.com')
                ->setNumPersonal(10016082)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_UNPI]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10016082', $user);
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
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10016450', $user);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('scasañas')
                ->setPlainPassword('12345')
                ->setFirstName('Sebastian')
                ->setLastName('Casañas')
                ->setEmail('scasañas@pequiven.com')
                ->setNumPersonal(10016111)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_UNOP]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10016111', $user);
        $manager->persist($user);
        
        $user = new User();
        $user->setUsername('jlperez-mf')
                ->setPlainPassword('12345')
                ->setFirstName('Jose Luis')
                ->setLastName('Perez')
                ->setEmail('jlperez@pequiven.com')
                ->setNumPersonal(10017424)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST_AUX)))
                ->setParent($this->getReference('d-10017424'))
                ->setEnabled(true);
        $this->addReference('mf-10017424', $user);
        $manager->persist($user);
        
        $user = new User();
        $user->setUsername('jdepablos-mf')
                ->setPlainPassword('12345')
                ->setFirstName('Juan Carlos')
                ->setLastName('De Pablos')
                ->setEmail('jdepablos@pequiven.com')
                ->setNumPersonal(10002520)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST_AUX)))
                ->setParent($this->getReference('d-10002520'))
                ->setEnabled(true);
        $this->addReference('mf-10002520', $user);
        $manager->persist($user);
        
        $user = new User();
        $user->setUsername('mavila')
                ->setPlainPassword('12345')
                ->setFirstName('Marcos')
                ->setLastName('Avila')
                ->setEmail('mavila@pequiven.com')
                ->setNumPersonal(10019266)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_LOGISTICA_COMERCIAL]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_MANAGER_FIRST)))
                ->setEnabled(true)
        ;
        $this->addReference('mf_10019266', $user);
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
                ->setParent($this->getReference('mf-10002520'))
                ->setEnabled(true);
        $manager->persist($user);

        //Usuarios Gerente 2da Línea
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
                ->setEnabled(true);
        $this->addReference('ms-10016012', $user);
        $manager->persist($user);

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
                ->setParent($this->getReference('ms-10016012'))
                ->setEnabled(true);
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
                ->setParent($this->getReference('ms-10016012'))
                ->setEnabled(true);
        $manager->persist($user);

        //Usuarios Coordinador o Superintendente
        $user = new User();
        $user->setUsername('cchavez')
                ->setPlainPassword('12345')
                ->setFirstName('Carmen')
                ->setLastName('Chavez')
                ->setEmail('cchavez@pequiven.com')
                ->setNumPersonal(10021125)
                ->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]))
                ->setGerencia($this->getReference($gerenciaNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]))
                ->setGerenciaSecond($this->getReference($gerenciaSecondNameArray[GerenciaSecond::REF_GERENCIA_CONTROL_ESTADISTICO_E_INFORMACION_ZIV]))
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_COORDINATOR)))
                ->setParent($this->getReference('ms-10016012'))
                ->setEnabled(true);
        $manager->persist($user);

        //Usuarios Supervisor
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
                ->setEnabled(true);
        $manager->persist($user);

        //Usuario Personal PQV
        $user = new User();
        $user->setUsername('worker')
                ->setPlainPassword('12345')
                ->setFirstName('Junior')
                ->setEmail('junior@gmail.com')
                ->addGroup($this->getReference(Rol::getRoleName(Rol::ROLE_WORKER_PQV)))
                ->setEnabled(true);
        $manager->persist($user);

        $manager->flush();
    }

    public function getOrder() {
        return 7;
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

}
