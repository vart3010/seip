<?php
namespace Pequiven\MasterBundle\DataFixtures\ORM;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\Complejo;
use Pequiven\MasterBundle\Entity\Direction;
use Pequiven\MasterBundle\Entity\Gerencia;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of GerenciaFixture
 *
 * @author matias
 */
class GerenciaFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        $complejo_data = new Complejo();
        $complejoNameArray = $complejo_data->getRefNameArray();
        
        $direction_data = new Direction();
        $directionNameArray = $direction_data->getRefNameArray();
        
        $gerencia_data = new Gerencia();
        $refNameArray = $gerencia_data->getRefNameArray();
        
        // GERENCIA COMPLEJO PETROQUIMICO MORON

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia. Gral. Complejo Petroquímico Morón');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_GENERAL_CPM],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia UNFER/IPSL');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_UNFER]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_UNFER],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia UNPI');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_UNPI]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_UNPI],$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Proyectos/Morón');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerencia->setDirection($this->getReference($directionNameArray[Direction::DIRECTION_PROYECTOS]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_PROYECTOS_MORON]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_PROYECTOS_MORON],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Logística Comercial');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_LOGISTICA_COMERCIAL]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_LOGISTICA_COMERCIAL],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('IPSL/Comercio Exterior');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPMORON]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_IPSL_COMERCIO_EXTERIOR],$gerencia);
            $manager->persist($gerencia);

        // GERENCIA COMPLEJO PETROQUIMICO ANA MARIA CAMPOS
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Gral.Complejo Petroquímico A.M.C.');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_GENERAL_CPAMC],$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia UNOP');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPAMC]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_UNOP]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_UNOP],$gerencia);
            $manager->persist($gerencia);

        // GERENCIA COMPLEJO PETROQUIMICO GD JOSE ANTONIO ANZOATEGUI

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Gral.Complejo Petroquímico J.A.A.');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_CPJAA]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_GENERAL_CPJAA],$gerencia);
            $manager->persist($gerencia);
            
        // GERENCIA PROYECTO NAVAY
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Gral. Navay');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_PRONAVAY]));
        $gerencia->setDirection($this->getReference($directionNameArray[Direction::DIRECTION_PROYECTOS]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_GENERAL_NAVAY],$gerencia);
            $manager->persist($gerencia);
            
        // GERENCIA PROYECTO PARAGUANA

        // GERENCIA SEDE VALENCIA

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Estimación de Costos');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_ESTIMACION_COSTOS]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_ESTIMACION_COSTOS],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Control de Gestión Oficina Presidencia');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_CONTROL_GESTION_OFIC_PRESIDENCIA],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Transporte Aéreo');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_TRANSPORTE_AEREO]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_TRANSPORTE_AEREO],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Planificación y Nvos. Desarrollos');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_PLANIFICACION_ESTRATEGICA_NUEVOS_DESARROLLOS],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Seg. Ctrol. Financiero/Admvo. Proyectos');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setDirection($this->getReference($directionNameArray[Direction::DIRECTION_PROYECTOS]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_SEG_CTROL_FINANCIERO_ADMVO_PROY],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia General de Proyectos Internacionales');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setDirection($this->getReference($directionNameArray[Direction::DIRECTION_PROYECTOS]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_PROYECTOS_INTERNACIONALES]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_PROYECTOS_INTERNACIONALES],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Proyecto Terminal Marítimo Morón');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setDirection($this->getReference($directionNameArray[Direction::DIRECTION_PROYECTOS]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_PROYECTO_TERMINAL_MARITIMO_CPM],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Recursos Humanos');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setDirection($this->getReference($directionNameArray[Direction::DIRECTION_RRHH]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_RECURSOS_HUMANOS],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Auditoria Interna');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_AUDITORIA_INTERNA]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_AUDITORIA_INTERNA],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Consultoria Jurídica y Rpte. Judicial');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_CONSULTORIA_JURIDICA_Y_RPTE_JUDICIAL],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Contrataciones');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_CONTRATACIONES]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_CONTRATACIONES],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Finanzas');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_FINANZAS]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_FINANZAS],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Automatización, Informática y Telecomunicaciones');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_AUTOMATIZACION_INFORMATICA_Y_TELECOMUNICACIONES],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Prevención y Control de Pérdidas');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_PREVENCION_Y_CONTROL_PERDIDAS],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. de Salud');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_SALUD]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_SALUD],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Administración y Servicios');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_ADMINISTRACION_Y_SERVICIOS]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_ADMINISTRACION_Y_SERVICIOS],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Asuntos Públicos');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_ASUNTOS_PUBLICOS],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Desarrollo Social');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_DESARROLLO_SOCIAL]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_DESARROLLO_SOCIAL],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Seguridad, Higiene y Ambiente');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_SEGURIDAD_HIGIENE_Y_AMBIENTE],$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corp. Sistema Integrado e Gestión');
        $gerencia->setComplejo($this->getReference($complejoNameArray[Complejo::COMPLEJO_ZIV]));
        $gerencia->setRef($refNameArray[Gerencia::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION]);
        $this->addReference($refNameArray[Gerencia::REF_GERENCIA_SISTEMA_INTEGRADO_GESTION],$gerencia);
            $manager->persist($gerencia);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 3;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}