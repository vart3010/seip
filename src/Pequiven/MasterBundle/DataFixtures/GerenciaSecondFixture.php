<?php
namespace Pequiven\MasterBundle\DataFixtures;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\MasterBundle\Entity\GerenciaSecond;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of GerenciaSecondFixture
 *
 * @author matias
 */
class GerenciaSecondFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Control Estadístico e Información');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-79'));
        $this->addReference('GerenciaSecond-01', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Planificación');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-79'));
        $this->addReference('GerenciaSecond-02', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Ingeniería');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-79'));
        $this->addReference('GerenciaSecond-03', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Análisis y Evaluación Estratégica');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-79'));
        $this->addReference('GerenciaSecond-04', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('A.I.T. Centro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-08'));
        $this->addReference('GerenciaSecond-05', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Asuntos Legales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-01'));
        $this->addReference('GerenciaSecond-06', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Salud Región Centro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-11'));
        $this->addReference('GerenciaSecond-07', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Asuntos Públicos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-09'));
        $this->addReference('GerenciaSecond-08', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('P.C.P. Región Centro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-07'));
        $this->addReference('GerenciaSecond-09', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Proyectos Morón');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-03'));
        $this->addReference('GerenciaSecond-10', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Finanzas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-10'));
        $this->addReference('GerenciaSecond-11', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Finanzas/UCFER');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-20'));
        $this->addReference('GerenciaSecond-12', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Técnica');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-19'));
        $this->addReference('GerenciaSecond-13', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Recursos Humanos Región Centro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-04'));
        $this->addReference('GerenciaSecond-14', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Mantenimiento');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-14'));
        $this->addReference('GerenciaSecond-15', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('S.H.A.');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-12'));
        $this->addReference('GerenciaSecond-16', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Suministro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-18'));
        $this->addReference('GerenciaSecond-17', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Servicios Generales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-17'));
        $this->addReference('GerenciaSecond-18', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Estimación de Costos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-06'));
        $this->addReference('GerenciaSecond-19', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('UNPI');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-21'));
        $this->addReference('GerenciaSecond-20', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('UCFER - Logística Comercial');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-20'));
        $this->addReference('GerenciaSecond-21', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('UCFER - Planificación Comercial');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-20'));
        $this->addReference('GerenciaSecond-22', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('UCFER - Abastecimiento de Fertilizantes');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-20'));
        $this->addReference('GerenciaSecond-23', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('UCFER - IPSL/Comercio Exterior - Comercial Fertilizantes');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-20'));
        $this->addReference('GerenciaSecond-24', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Proyectos Troncal III Vía Perimetral CPM');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-05'));
        $this->addReference('GerenciaSecond-25', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Salud Región Occidente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-31'));
        $this->addReference('GerenciaSecond-26', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Asuntos Públicos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-29'));
        $this->addReference('GerenciaSecond-27', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Desarrollo Social');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-35'));
        $this->addReference('GerenciaSecond-28', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Finanzas CPAMC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-30'));
        $this->addReference('GerenciaSecond-29', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Mantenimiento');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-37'));
        $this->addReference('GerenciaSecond-30', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('P.C.P. Región Occidente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-26'));
        $this->addReference('GerenciaSecond-31', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Suministro');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-41'));
        $this->addReference('GerenciaSecond-32', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Recursos Humanos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-24'));
        $this->addReference('GerenciaSecond-33', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('SHA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-33'));
        $this->addReference('GerenciaSecond-34', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Técnica');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-42'));
        $this->addReference('GerenciaSecond-35', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('A.I.T. Occidente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-28'));
        $this->addReference('GerenciaSecond-36', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Producción');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-39'));
        $this->addReference('GerenciaSecond-37', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Servicios Generales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-40'));
        $this->addReference('GerenciaSecond-38', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Proyectos Operacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-32'));
        $this->addReference('GerenciaSecond-39', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Comercial de Olefinas y Plásticos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-43'));
        $this->addReference('GerenciaSecond-40', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Estimación de Costos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-25'));
        $this->addReference('GerenciaSecond-41', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Consultoria Jurídica');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-23'));
        $this->addReference('GerenciaSecond-42', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Recursos Humanos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-47'));
        $this->addReference('GerenciaSecond-43', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Servicios Generales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-62'));
        $this->addReference('GerenciaSecond-44', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Asuntos Públicos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-51'));
        $this->addReference('GerenciaSecond-45', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Estimación de Costos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-48'));
        $this->addReference('GerenciaSecond-46', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Salud Región Oriente');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-53'));
        $this->addReference('GerenciaSecond-47', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Finanzas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-52'));
        $this->addReference('GerenciaSecond-48', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Asuntos Legales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-45'));
        $this->addReference('GerenciaSecond-49', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('PCP');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-49'));
        $this->addReference('GerenciaSecond-50', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('SHA');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-54'));
        $this->addReference('GerenciaSecond-51', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Materiales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-60'));
        $this->addReference('GerenciaSecond-52', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Técnica y Proyectos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-57'));
        $this->addReference('GerenciaSecond-53', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Mantenimiento');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-59'));
        $this->addReference('GerenciaSecond-54', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Producción');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-61'));
        $this->addReference('GerenciaSecond-55', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Servicios Financieros Proyectos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-71'));
        $this->addReference('GerenciaSecond-56', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Ingeniería y Construcción');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-91'));
        $this->addReference('GerenciaSecond-57', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Proyectos Fosfatados Morón');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-03'));
        $this->addReference('GerenciaSecond-58', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Producción');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-03'));
        $this->addReference('GerenciaSecond-59', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Terminal Borburata');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-21'));
        $this->addReference('GerenciaSecond-60', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Ventas Nacionales y Mercadeo');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-21'));
        $this->addReference('GerenciaSecond-61', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('UCFER - IPSL/Comercio Exterior - Servicios Financieros');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-20'));
        $this->addReference('GerenciaSecond-62', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Arranque Fosfatados Nuevas Plantas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-03'));
        $this->addReference('GerenciaSecond-63', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Arranque Nitrogenados Nuevas Plantas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-03'));
        $this->addReference('GerenciaSecond-64', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('QA/QC');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-91'));
        $this->addReference('GerenciaSecond-65', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Relaciones Institucionales y Logística');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-71'));
        $this->addReference('GerenciaSecond-66', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Ingeniería Proyectos Internacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-71'));
        $this->addReference('GerenciaSecond-67', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Servicios Organizacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-72'));
        $this->addReference('GerenciaSecond-68', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Planes y Beneficios');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-72'));
        $this->addReference('GerenciaSecond-69', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Relaciones Laborales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-72'));
        $this->addReference('GerenciaSecond-70', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('CAPET');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-72'));
        $this->addReference('GerenciaSecond-71', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Planificación y Control de Gestión');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-72'));
        $this->addReference('GerenciaSecond-72', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Calidad de Vida');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-72'));
        $this->addReference('GerenciaSecond-73', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('RR.HH Oficina Principal');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-72'));
        $this->addReference('GerenciaSecond-74', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Auditoria de Olefinas y Plásticos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-75'));
        $this->addReference('GerenciaSecond-75', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Auditoria de Fertilizantes');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-75'));
        $this->addReference('GerenciaSecond-76', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Auditoria de Prod. Ind. y Proc. Corp.');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-75'));
        $this->addReference('GerenciaSecond-77', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Auditoria de Proyectos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-75'));
        $this->addReference('GerenciaSecond-78', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Responsabilidades Fiscales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-75'));
        $this->addReference('GerenciaSecond-79', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Asuntos Legales Nacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-70'));
        $this->addReference('GerenciaSecond-80', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Asuntos Legales Internacionales');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-70'));
        $this->addReference('GerenciaSecond-81', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Litigios y Reclamos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-70'));
        $this->addReference('GerenciaSecond-82', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Contrataciones Sede Valencia');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-76'));
        $this->addReference('GerenciaSecond-83', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Servicios Financieros');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-83'));
        $this->addReference('GerenciaSecond-84', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Tributario');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-83'));
        $this->addReference('GerenciaSecond-85', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Tesorería');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-83'));
        $this->addReference('GerenciaSecond-86', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Presupuesto');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-83'));
        $this->addReference('GerenciaSecond-87', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Contraloria Financiera');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-83'));
        $this->addReference('GerenciaSecond-88', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Riesgo y Seguros');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-83'));
        $this->addReference('GerenciaSecond-89', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Infraestructura y Telecomunicaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-81'));
        $this->addReference('GerenciaSecond-90', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Planificación y Control de Gestión');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-81'));
        $this->addReference('GerenciaSecond-91', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Infraestructura de Operaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-81'));
        $this->addReference('GerenciaSecond-92', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Prevención');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-78'));
        $this->addReference('GerenciaSecond-93', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Protección Empresarial');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-78'));
        $this->addReference('GerenciaSecond-94', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Planificación y Gestión');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-84'));
        $this->addReference('GerenciaSecond-95', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Infraestructura');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-74'));
        $this->addReference('GerenciaSecond-96', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Apoyo');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-74'));
        $this->addReference('GerenciaSecond-97', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Relaciones Públicas');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-82'));
        $this->addReference('GerenciaSecond-98', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Comunicaciones');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-82'));
        $this->addReference('GerenciaSecond-99', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Ingeniería de Riesgos');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-80'));
        $this->addReference('GerenciaSecond-100', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Prev. Cont. de Emerg. y Contingencia');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-80'));
        $this->addReference('GerenciaSecond-101', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Ambiente, Higiene Ocupacional');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-80'));
        $this->addReference('GerenciaSecond-102', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Estimación de Costos OP');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-77'));
        $this->addReference('GerenciaSecond-103', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Estandarización SIG');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-86'));
        $this->addReference('GerenciaSecond-104', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Infraestructura');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-67'));
        $this->addReference('GerenciaSecond-105', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Desarrollo de Minas Navay');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-66'));
        $this->addReference('GerenciaSecond-106', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $gerenciaSecond = new GerenciaSecond();
        $gerenciaSecond->setDescription('Control Estadístico e Información');
        $gerenciaSecond->setEnabled(1);
        $gerenciaSecond->setGerencia($this->getReference('Gerencia-27'));
        $this->addReference('GerenciaSecond-107', $gerenciaSecond);
            $manager->persist($gerenciaSecond);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 3;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}