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
use Pequiven\MasterBundle\Entity\Cargo;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * DataFixture de los Cargos
 *
 * @author matias
 */
class CargoFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
//        // Cargos Complejo petroquímico Morón
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-01'));
//        $this->addReference('Cargo-01',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-01'));
//        $this->addReference('Cargo-02',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Apoyo Gerencia de Asuntos Legales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-01'));
//        $this->addReference('Cargo-03',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado Proyecto Paraguaná');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-01'));
//        $this->addReference('Cargo-04',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado Empresa RGARMO C.A.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-01'));
//        $this->addReference('Cargo-05',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 02
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Articulador Sociopolítico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-02'));
//        $this->addReference('Cargo-06',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Articulador Social en Pl.Endogena');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-02'));
//        $this->addReference('Cargo-07',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector Proyectos de Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-02'));
//        $this->addReference('Cargo-08',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Articulador Social en Deportes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-02'));
//        $this->addReference('Cargo-09',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Articulador Social en Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-02'));
//        $this->addReference('Cargo-10',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Articulador Social en Educación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-02'));
//        $this->addReference('Cargo-11',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Articulador Social en  Pesca, Amb.y Habi');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-02'));
//        $this->addReference('Cargo-12',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coord.Desarrollo Social Morón');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-02'));
//        $this->addReference('Cargo-13',$cargo);
//          $manager->persist($cargo);
//
//
//        // Gerencia 03
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Electricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-14',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-15',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Mecánica Rotativa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-16',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Instrumentista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-17',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Tuberías y Accesorios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-18',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Mecanica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-19',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.(E) Analisis de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-20',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-21',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-22',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-23',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Ambiente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-24',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Seguridad y Riesgo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-25',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ayudante General');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-26',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Logística');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-27',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador/Controlador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-28',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder  ACCC Proyectos Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-29',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador/Controlador de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-30',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Fuerza de Límite de Baterías');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-31',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Mecánica Estática');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-32',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Tuberías');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-33',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-34',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Control Calidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-35',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Lider de Proyectos NPAF');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-36',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Logística');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-37',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-38',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('LIDER PROYECTO PBRF/PAC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-39',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-40',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Planta Beneficio Roca Fosfática');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-41',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder de Proyecto de Infraestructura y Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-42',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-43',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Planta Sulfúrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-44',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Proyecto de Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-45',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-46',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.SHA Proyecto Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-47',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planif.Control y Estadistico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-48',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder de Proyectos Eléctricos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-49',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-50',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Ctrol.Gestión Admin.Reg.Centro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-51',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-52',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Planta Amoníaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-53',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Lider de Control de Calidad QA/QC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-54',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Planta Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-55',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de  Logística');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-56',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Proyecto Nitrogenados Pto.Nutrias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-57',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Mecanico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-58',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente General del Proyecto Morón');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-03'));
//        $this->addReference('Cargo-59',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 04
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador del SISDEM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-60',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador y Ctrol.de Estudios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-61',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Academico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-62',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Formación Continua');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-63',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Logística y Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-64',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Programación Académica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-65',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Nómina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-66',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pedidos-Llanos Occi.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-67',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-68',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista del SISDEM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-69',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('As.Integral de Planif.y Ctrol.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-70',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Atención al Jubilado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-71',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-72',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Planes y Benef.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-73',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-74',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Serv.Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-75',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.de CAPET Región Centro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-76',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Recursos Humanos Región Centro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-77',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-78',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-79',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Formación Continua');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-80',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-81',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Programación Académica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-82',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-83',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Servicios Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-84',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisora Logística y Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-85',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-04'));
//        $this->addReference('Cargo-86',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 05
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Gerencia General');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-87',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte. Proyecto Agropatria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-88',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-89',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador de Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-90',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador de Ingenieria de Proceso Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-91',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador Ing. de Proceso Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-92',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Arranque');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-93',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente General Complejo Petroquímico Morón');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-94',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.de Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-95',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Estimación de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-96',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder de AC/CC de Arranque Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-97',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder de Operaciones Arranque Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-98',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Lider Especialidades Arranque Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-99',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecanico Estatico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-100',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-101',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.  Especialidad Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-102',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Especialidad Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-103',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-104',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-105',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Espec.Mecánico Sulfúrico/ Beneficio de roca');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-106',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista planta ácido sulfúrico 219');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-107',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Amoníaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-108',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Sulfúrico/Beneficio de Roca');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-109',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Rotativos Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-05'));
//        $this->addReference('Cargo-110',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 06
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Estimación de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-06'));
//        $this->addReference('Cargo-111',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 07
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Investigaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-112',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA de P.B.I.P');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-113',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Prevención');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-114',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA DE PROTECCION');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-115',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-116',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de TecnologÍa de Protección');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-117',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista PREVENCION');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-118',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA PROTECCIÓN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-119',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista UNIR');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-120',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-121',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-122',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte. P.C.P. Region Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-123',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('OFICINISTA DE CERRAJERIA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-124',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista de Identificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-125',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de P.B.I.P');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-126',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Club La Playa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-127',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-128',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-129',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-130',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Club La Playa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-131',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Proteccion Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-132',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-133',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup de Administracion y control de Gestion (e)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-134',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Admón.y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-135',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Investigaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-136',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Proteccion Empresarial (e)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-137',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Prevencion (e)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-138',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Verificador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-07'));
//        $this->addReference('Cargo-139',$cargo);
//          $manager->persist($cargo);
//        // Gerencia 08
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-140',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Escritorio de Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-141',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Gestión Tecnologica de Red');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-142',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Ingeniería de Software');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-143',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Operaciones de Sistemas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-144',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Redes de Telecomunicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-145',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Soporte Espec.de Operaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-146',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Soporte y Atención Usuarios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-147',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente A.I.T.Centro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-148',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-149',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Atención y Soporte a Usuarios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-150',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Escritorio de Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-151',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Operac.Sistemas Centro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-08'));
//        $this->addReference('Cargo-152',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 09
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comunicaciones Externas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-153',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comunicaciones Internas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-154',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Diseño Gráfico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-155',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Protocolo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-156',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Relaciones Institucionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-157',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Camarógrafo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-158',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Asuntos Públicos CPM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-159',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector Proyectos de Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-160',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-161',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Productor Audiovisual');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-162',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Org.de Eventos y Protocolo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-163',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Soldadura Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-164',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Relaciones Públicas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-165',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico de Turno Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-166',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Servicios Generales II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-167',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Edición');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-09'));
//        $this->addReference('Cargo-168',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 10
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador Gerencias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-169',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Apoyo de Comisiones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-170',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Activo Fijo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-171',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Conciliaciones Bancarias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-172',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contrataciones Admtva.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-173',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contrataciones Proc.Técnicos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-174',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Costo/Tarifas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-175',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-176',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Cobrar-Guárico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-177',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Cobrar-Llanos O.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-178',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Pagar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-179',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Evaluaciones Financieras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-180',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Facturacion-Guárico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-181',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Inventarios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-182',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Licitaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-183',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Operaciones Bancarias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-184',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pagos al Personal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-185',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pedidos-Guárico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-186',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Presupuesto Inversiones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-187',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Presupuesto Operaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-188',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Facturador-Guárico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-189',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Informes Financieros');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-190',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Procesos Contratación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-191',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Administración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-192',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Atención a Proveedores Aplic.Factura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-193',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Contador de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-194',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de  Administración Comercial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-195',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-196',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Admón.Integral y Control Interno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-197',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Licitaciones y Eval.Financiera');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-198',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Contabilidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-199',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Contrataciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-200',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Presupuesto y Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-201',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Tesorería y Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-10'));
//        $this->addReference('Cargo-202',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 11
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-203',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planes de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-204',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Auxiliar de Laboratorio Clínico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-205',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Bioanalista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-206',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.de Enfermeras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-207',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Enfermera Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-208',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Instructor del Ctro.Educ.Física y Rehab.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-209',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-210',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Psicólogo Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-211',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-212',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planificación y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-213',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Salud Integral');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-214',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Salud Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-215',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Trabajador Social');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-11'));
//        $this->addReference('Cargo-216',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 12
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Bombero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-217',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.SHA Proyecto Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-218',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Seguridad, Higiene y Ambiente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-219',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Higienista Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-220',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Ambiental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-221',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Planif.y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-222',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Riesgos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-223',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-224',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de  Ambiente, Higiene Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-225',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Prev.Ctrl.Emerg.y Contingencias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-226',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Auxiliar de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-227',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Auxiliar encargado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-228',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-229',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno  Encargado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-230',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-12'));
//        $this->addReference('Cargo-231',$cargo);
//          $manager->persist($cargo);
//
//
//
//        // Gerencia 13
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Estandarización SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-13'));
//        $this->addReference('Cargo-232',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Mat.Prima Pta.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-13'));
//        $this->addReference('Cargo-233',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 14
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.Administración de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-234',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.Gestión de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-235',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contrato');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-236',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Procedimientos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-237',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Trafico y Herramientas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-238',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Andamiero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-239',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Apoyo a la Gran Mision Vivienda (SUVI)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-240',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ASIGNADO A TERMINAL DE BORBURATA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-241',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ASIGNADO A TRABAJOS ESPECIALES');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-242',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('AUXILIAR DE GESTION');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-243',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Chofer de Camión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-244',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador de Reingenieria PM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-245',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador Rotativo Gcia Arranque');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-246',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinadora  Proyecto  Reingenieria PM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-247',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Depositario de Trafico y Herramientas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-248',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Depositario de Tráfico y Herramientas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-249',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ENLACE PROCESO SIG MTTO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-250',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Fabricador I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-251',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Fabricador III');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-252',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-253',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.de Confiabilidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-254',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector Especialista de Obras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-255',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Insulador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-256',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('LIDER DE PLANIFICACION ARRANQUE  FOSFATADO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-257',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico de Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-258',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-259',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico de Turno Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-260',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico Serv.Industriales I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-261',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico Serv.Industriales II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-262',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico Taller Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-263',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Obrero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-264',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Montacargas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-265',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Montavargas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-266',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Personal por Reubicar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-267',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Pintor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-268',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Pintor - Arenador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-269',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Pintor - Montacarguista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-270',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Pintor-Sandblasista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-271',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-272',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Mtto. Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-273',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Mtto. Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-274',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Mtto.Extraordinario');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-275',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Parada de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-276',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Plomero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-277',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador de Mantenimiento Mina y Via Ferrea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-278',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador Mtto. Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-279',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador Mtto. Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-280',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-281',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sold./Fabric./Ayudantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-282',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Soldador/Fabric./Ayud.Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-283',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Soldador/Fabricador/Ayudante');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-284',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte. Mantenimiento Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-285',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-286',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Infraestructuras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-287',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Talleres');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-288',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Ingenieria de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-289',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mtto. de Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-290',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mtto.de Planta Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-291',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mtto.de Planta Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-292',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mtto.de Planta Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-293',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. De Inspeccion de Obras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-294',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. De seccion Obras Civiles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-295',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Eléctrica e Instalaciones Externa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-296',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Gestiòn');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-297',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Obras Externas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-298',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Equipos Estaticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-299',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Obras Civiles Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-300',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Rotativos Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-301',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Eléctricidad Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-302',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Electricidad Manejo de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-303',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Electricidad NPK/SAM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-304',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Electricidad Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-305',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Electricidad Sulfúrico/SAM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-306',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Electricidad Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-307',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-308',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Instrumentación Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-309',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Instrumentación Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-310',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Mecánica Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-311',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Mecánica Manejo de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-312',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Mecánica NPK/DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-313',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Mecánica Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-314',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Mecánica Sulfúrico/SAM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-315',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Mecanica Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-316',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Soldadura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-317',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Taller Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-318',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Tribología');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-319',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Vías Ferrias y Conj.Rodante');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-320',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Secc.Analizadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-321',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Secc.Electrónica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-322',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Secc.Neumática');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-323',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec. Aislamiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-324',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.de Obras Civiles Internas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-325',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Eq.Rot.Sulfúrico/Sulfato');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-326',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Eq.Rotativos Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-327',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Equipos Rotativos Ensacados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-328',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Equipos Rotativos Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-329',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Equpos Rotativos Amoníaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-330',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Instrumentación Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-331',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Instrumentacion Fosforico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-332',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Instrumentación Manejo Produc');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-333',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Instrumentación NPK/DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-334',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Instrumentación Sulf/SAM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-335',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Instrumentación Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-336',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Obras Civiles Internas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-337',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Soldadura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-338',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Soldadura Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-339',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Soldadura NPK/DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-340',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Soldadura Servicios Generales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-341',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Soldadura Sulfúrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-342',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Soldadura Taller');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-343',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUPERINTENDENTE DE INFRAESTRUCTURAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-344',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Planificaciòn y Gestiòn (e)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-345',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Mina de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-346',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-347',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUPERVISOR CIVIL');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-348',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Mantenimiento Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-349',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Planificaciòn y Gestiòn Fosfatado (e)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-350',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor sección mecánica de Mina de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-351',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisora de Logistica Parada');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-352',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco. Especialista Electricidad Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-353',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco. Mecánico NPK');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-354',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Conj.Rodante Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-355',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Distribución');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-356',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-357',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-358',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-359',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista Manejo de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-360',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista NPK/DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-361',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-362',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista Sulfúrico/SAM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-363',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electricista Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-364',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Eléctrico Instalaciones Externas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-365',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Electrónica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-366',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.en Motores Eléctricos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-367',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.en Protección Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-368',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Equipos Estaticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-369',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Esp.Mecánico Ajuste y Montaje');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-370',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Esp.Mecánico Máquinas y Herramientas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-371',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Esp.Tráfico y Herramientas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-372',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Espec.Electricidad Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-373',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Espec.Electricista Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-374',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Espec.Instrumentista NPK/DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-375',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Espec.Mecánico Serv.Industriales I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-376',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Espec.Mecánico Serv.Industriales II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-377',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Espec.Mecánico Sev.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-378',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Espec.Mecánico Sulfúrico/SAM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-379',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Distribución');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-380',$cargo);
//          $manager->persist($cargo);
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Equipos Estaticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-381',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Instrumentacion Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-382',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-383',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Mecánico Amoníaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-384',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Mecánico Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-385',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Mecánico NPK');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-386',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Especialista Mecánico Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-387',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-388',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-389',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-390',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista Manejo de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-391',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-392',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista NPK/DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-393',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-394',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista Sulf/SAM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-395',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Instrumentista Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-396',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-397',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecanico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-398',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-399',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Amoníaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-400',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-401',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico FOSFORICO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-402',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-403',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Manejo de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-404',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-405',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico NPK');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-406',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico NPK/DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-407',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-408',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Sulfúrico/SAM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-409',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecanico Tribología');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-410',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Tribología');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-411',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecánico Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-412',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Protec.Eléctrica Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-413',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Rotativos Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-414',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Rotativos Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-415',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-416',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-417',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-418',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador NPK/DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-419',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Servicios Generales I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-420',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Servicios Generales II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-421',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Sulfúrico I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-422',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Sulfúrico II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-423',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Taller');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-424',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Soldador Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-425',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-426',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico en Lubricación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-427',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Equipos Estáticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-428',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico Especialista Rotativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-429',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico Mayor de Fosfatado ( e )');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-430',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Soldadura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-431',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-432',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico Mecanico Tribología');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-433',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Refrigeración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-434',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-435',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tornero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-436',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tornero de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-14'));
//        $this->addReference('Cargo-437',$cargo);
//          $manager->persist($cargo);
//
//
//        // Gerencia 15
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Almacenista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-15'));
//        $this->addReference('Cargo-438',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-15'));
//        $this->addReference('Cargo-439',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-15'));
//        $this->addReference('Cargo-440',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Verificador Inventario');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-15'));
//        $this->addReference('Cargo-441',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 16
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-442',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-443',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista y Control de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-444',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ASESOR DE LA GERENCIA ARRANQUE FOSFATADOS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-445',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Sup. Transportación Ferroviaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-446',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-447',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-448',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Produccion');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-449',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-450',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Aux.Conducción Locomotora');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-451',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Conductor de Locomotora');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-452',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Enlace de Formación Gerencia de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-453',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Fabricador III');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-454',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-455',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.de Producción / Arranque Manejo de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-456',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-457',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Producción (E )');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-458',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Producción Ácido Sulfúrico/Sulfato de Amonio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-459',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Produccion en formacion');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-460',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Obrero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-461',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Obrero de Limpieza 370A Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-462',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados (GRANULADOR) RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-463',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Exportación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-464',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Lavado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-465',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Limpieza');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-466',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Mat.Prima Almacen');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-467',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Mat.Prima Pta.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-468',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Materia Prima Almacen');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-469',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Materia prima Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-470',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-471',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Granulados Secado/Cribado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-472',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Campo Materia Prima Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-473',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.de Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-474',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.de Servicio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-475',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Maquinaria Pesada');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-476',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Op.Raspadora/Cintas/Tolvas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-477',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Caldera/Aire/Nitrog.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-478',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador calderas/103A/103/Relicuefacción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-479',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Ácido Sulfúrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-480',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-481',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-482',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados (granulador) NPK');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-483',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados (SECCION LAVADO) NPK');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-484',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados (Seccion lavado) RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-485',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados Exportacion');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-486',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados Exportaciòn');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-487',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados Lavado RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-488',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-489',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Granulados Secado/Cribado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-490',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-491',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Sulfúrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-492',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Campo Sulfúrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-493',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Cintas Transportador Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-494',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de calderas/103/103A/105D/181');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-495',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Calderas/103A/103');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-496',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Campo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-497',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de campo RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-498',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-499',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('operador de planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-500',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('operador de plata');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-501',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Recep.y Man.de Roca');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-502',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Relicuefacción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-503',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Tablero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-504',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Tablero I-106/Aguas Servidas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-505',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-506',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('operador de´planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-507',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Evap.Almacen');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-508',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Evap.Efluentes Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-509',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Hitachi/SE7/112/Aguas Terciaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-510',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('operador I-106/Aguas Servidas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-511',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Inst.106/Aguas Servidas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-512',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Patio Lavado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-513',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Patio Lavado CO2');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-514',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Patio Reformación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-515',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Patio Refrigeración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-516',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Patio Sintesis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-517',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Patio Sulfato Amonio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-518',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Perlado Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-519',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Recep.Despacho Cisterna');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-520',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Tablero Inst.106/Aguas Servidas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-521',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista caldera/103/103A/105D/181');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-522',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista caldera/103A/103/105D/181');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-523',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Calderas/103A/103/Relicuefacci');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-524',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Calderas/103A/103/Relicuefacción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-525',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Hitachi/SE7/112/Aguas Terciari');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-526',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Hitachi/SE7/112/Aguas Terciaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-527',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Personal por Reubicar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-528',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Romanera');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-529',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Romanero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-530',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-531',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Granulados y Manejo de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-532',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Mina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-533',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-534',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup de Panel Inst. 215');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-535',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup Panel Sec Fosforico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-536',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Aux. Panel Sulfato');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-537',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. de Maquinaria Pesada.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-538',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. de Trituración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-539',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. de Turno Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-540',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. De Turno Sec. Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-541',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Ensacado Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-542',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. PANEL');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-543',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Panel RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-544',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Panel Sec. Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-545',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Panel Sec.Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-546',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. turno NPK/RPA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-547',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.Campo Granulados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-548',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.Campo Granulados Lavado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-549',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.Campo Sulfúrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-550',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.Compresor Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-551',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.de Explotación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-552',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.de Filtración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-553',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-554',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.de Secado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-555',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.Panel Sulfato');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-556',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.Reacción Molienda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-557',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Aux.Sintesis Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-558',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Explotación Mina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-559',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Panel Inst 215');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-560',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Panel Inst.218');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-561',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Panel NPK');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-562',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Panel Sec.Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-563',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-564',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-565',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Granulados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-566',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Roca Fosfatica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-567',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Sec.Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-568',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Sulfúrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-569',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Ensacados Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-570',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Mat.Prima y Prod.Terminados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-571',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Panel DAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-572',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Panel NPK');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-573',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Panel Reform.Lav.CO2');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-574',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Panel Sec. Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-575',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Panel Sintesis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-576',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-577',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Granulados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-578',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-579',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sección Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-580',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Servicios Generales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-581',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Transp.Ferroviario');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-582',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Turno Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-583',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Turno Sulfúrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-584',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Turno.Fosfórico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-585',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente (E) Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-586',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente (E) Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-587',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-588',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Enscado Urea / Arranque Manejo de Producto.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-589',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-590',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Secciòn Manejo de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-591',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de turno de Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-592',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Mecanico Planta y Despacho');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-593',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-594',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-16'));
//        $this->addReference('Cargo-595',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 17
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Albañil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-596',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Albañil de 2da');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-597',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comedores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-598',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Arquitecto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-599',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Carpintero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-600',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Chofer');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-601',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Chofer.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-602',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('CORDINADOR DE PROCURAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-603',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Electricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-604',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Servicios Generales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-605',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-606',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-607',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('nspector de Obras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-608',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-609',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico Transporte Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-610',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Nutricionista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-611',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Obrero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-612',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Obrero de Limpieza');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-613',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Obrero Limpieza');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-614',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-615',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista Artes Gráficas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-616',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista Servicios de Oficina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-617',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Equipo Pesado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-618',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Mantenimiento Club La Playa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-619',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-620',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Mtto. Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-621',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-622',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Planificación y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-623',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Servicios de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-624',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Transporte');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-625',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup (E) Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-626',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup (E) Obras Civiles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-627',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup (E) Saneamiento y Areas Verdes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-628',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. (E) Planificacion');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-629',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Izamiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-630',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.(E) Inspeccion de Obras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-631',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Equipos Livianos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-632',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Ingeniería y Urbanismo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-633',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Planificación y Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-634',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Transporte Minas de Riecito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-635',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Servicios de Comedores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-636',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Servicios de Oficina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-637',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Transporte Pesado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-638',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Viajes/Traslados y Correspondencias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-639',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-640',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Admón.y Mtto.Club La Playa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-641',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUPERVISOR DE EQUIPOS PESADOS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-642',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Eléctrico Instalaciones Externas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-643',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tco.Equipos de Izamiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-644',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Mantenimiento Club La Playa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-645',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-646',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Limpieza');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-647',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Refrigeración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-648',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnicos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-17'));
//        $this->addReference('Cargo-649',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 18
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Medición');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-18'));
//        $this->addReference('Cargo-650',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planificación y Programación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-18'));
//        $this->addReference('Cargo-651',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Suministro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-18'));
//        $this->addReference('Cargo-652',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Medición Contratos y Convenios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-18'));
//        $this->addReference('Cargo-653',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Topógrafo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-18'));
//        $this->addReference('Cargo-654',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 19
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administración Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-655',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-656',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-657',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Calidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-658',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Información y Documentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-659',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-660',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Medición');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-661',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-662',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Especial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-663',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Auxiliar de Archivo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-664',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Dibujante Proyectista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-665',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Gcia.Técnica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-666',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-667',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Corrosión y Materiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-668',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Automatización Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-669',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Automatización Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-670',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de CAD');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-671',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Proceso Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-672',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Procesos Nitrogenados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-673',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Procesos Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-674',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Electricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-675',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-676',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-677',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-678',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-679',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Petroquímicos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-680',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Recipientes Intercambiadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-681',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Sec.Calderas Hornos y Refor.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-682',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Sec.Electricidad e Instrum');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-683',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Sec.Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-684',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Sec.Recip.a Presión e Intc.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-685',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Sec.Talleres Almacén');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-686',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Sec.Tanques Recip.Tamb.Ductos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-687',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Sec.Tuberías');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-688',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Tuberías y Accesorios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-689',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Instrumentista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-690',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Personal por Reubicar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-691',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador de Proyecto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-692',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-693',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Automatización y Control de Proc.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-694',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Laboratorios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-695',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Proyectos Operacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-696',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Ingeniería de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-697',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Servicios Técnicos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-698',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Automatización Area Fosfatado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-699',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Automatización Area Nitrogenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-700',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Información y Documentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-701',$cargo);
//          $manager->persist($cargo);
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-702',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Obras Civiles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-703',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Rotativos Fosfatados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-704',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec. Aseg. y Control de Calidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-705',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Análisis Especiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-706',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Control Operacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-707',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.de CAD');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-708',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sec.Equipos Estáticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-709',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Subsec.Serv.Industriales I y II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-710',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-19'));
//        $this->addReference('Cargo-711',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 20
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Almacenista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-712',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Planificación Operativa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-713',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Contable');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-714',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Cuentas por Cobrar-Prod.Indus');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-715',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administracion de Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-716',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración de Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-717',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Aduana y Permisologia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-718',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Control y Gestión SAP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-719',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuenta por Cobrar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-720',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Cobrar-Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-721',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Cobrar-Guárico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-722',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Cobrar-Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-723',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Pagar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-724',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Despacho');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-725',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-726',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Gestion Administrativa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-727',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Muelles y Terminales Centro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-728',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pedidos-Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-729',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pedidos-Llanos Occi.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-730',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pedidos-Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-731',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pedidos-Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-732',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pedidos-Prod.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-733',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Facturador-Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-734',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Facturador-Llanos Occi.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-735',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Facturador-Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-736',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Facturador-Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-737',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Facturador-Prod.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-738',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Fletamento Marítimo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-739',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Flota de Transporte Terrestre');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-740',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Inventario');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-741',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Mezclado y Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-742',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Operaciones Aduaneras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-743',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Atención al Cliente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-744',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Distribución y Abastecimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-745',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Divulgación, Procesos y Calidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-746',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Esp.Análisis Económico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-747',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Esp.Divulgación, Procesos y Calid');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-748',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Esp.Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-749',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Esp.Planificación Operativa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-750',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Esp.Programación de Despacho');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-751',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Especialista de Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-752',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Especialista Olefinas y Plásticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-753',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Planifi.y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-754',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Planifi.y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-755',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Téc.Integral Reg.Guárico - Apure');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-756',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Téc.Integral Reg.Llanos Occid.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-757',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Técnico Integral Reg.Andes-Zulia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-758',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Técnico Integral Reg.Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-759',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Técnico Integral Reg.Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-760',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Técnico Integral Reg.Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-761',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-762',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Técnico Especialista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-763',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Despachador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-764',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ejecutivo de Ventas Alcoholes y Glicoles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-765',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente Abastecimiento de Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-766',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Logistica Comercial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-767',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-768',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Limitar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-769',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-770',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Administración de Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-771',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Distribución, Almacén y Despacho');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-772',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Fletamento Marítimo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-773',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Muelles,Terminales y Permisología');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-774',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Transporte Terrestre');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-775',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Administración de Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-776',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Flota Transporte Terrestre');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-777',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Mantenimiento Transp.Terrestre');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-778',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Muelles y Terminales Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-779',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Servicios Administrativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-780',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Muelles y Terminales Centro-Occid.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-781',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Programación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-782',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Región Andes - Zulia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-783',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Región Guárico - Apure');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-784',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Región Llanos Occid.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-785',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Región Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-786',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Región Oriental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-787',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Tec.y Nvos.Desarrollos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-788',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Adminis.Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-789',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Administ. Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-790',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Administrativo encargado Guarico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-791',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Admón.Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-792',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Admón.Llanos Occidentales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-793',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Admón.Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-794',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Admón.Productos Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-795',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Aduana y Permisologia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-796',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Aduanas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-797',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Contable');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-798',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Distribución y Despacho');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-799',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Fletamento Marítimo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-800',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Mezclado y Ensacado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-801',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Regional de Almacén');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-802',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 21
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Contratos de Gases');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-803',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Despacho Prod.Aromáticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-804',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Gestión y Control');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-805',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Planificación Operativa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-806',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-807',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Presupuesto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-808',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Mercadeo Prod.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-809',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Superintendente SHA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-810',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Bombero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-811',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Despachador de Producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-812',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ejecutivo de Ventas Aromáticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-813',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ejecutivo de Ventas Oxigenados y Gases');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-814',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ejecutivo de Ventas Prod.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-815',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Fabricador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-816',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Recipientes Intercambiadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-817',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Romana');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-818',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Terminal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-819',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Soldador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-820',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mantenimiento e Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-821',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planificación Operativa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-822',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Ventas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-823',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Administración y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-824',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Operaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-825',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Administración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-826',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-827',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-828',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno Terminal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-829',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor de Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-830',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-831',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Electricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-832',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Verificador Inventario');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-21'));
//        $this->addReference('Cargo-833',$cargo);
//          $manager->persist($cargo);
//
//        // Gerencia 22
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA ENLACE SIG MTTO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-834',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Gte.Proyecto Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-835',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Co.de Innovación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-836',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.General Petrocasa III');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-837',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.General(E)Monómeros');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-838',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Spte.Instrumentación-Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-839',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Auditor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-840',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('DIRECTORA DE PARQUES FUNDATRABAJO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-841',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('GERENTE DE PLANTA MEZCLADO AGROPATRIA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-842',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente Fertilizantes Agropatria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-843',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('JEFE DE INFORMATICA GOB. EDO CARABOBO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-22'));
//        $this->addReference('Cargo-844',$cargo);
//          $manager->persist($cargo);
//          
//        // COMPLEJO ANA MARIA CAMPOS
//
//        // GERENCIA 23
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-23'));
//        $this->addReference('Cargo-845',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder de Proyecto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-23'));
//        $this->addReference('Cargo-846',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 24
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador del SISDEM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-847',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Archivo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-848',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Formación Academica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-849',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Formación Continua');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-850',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Programación Académica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-851',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Formación Contínua');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-852',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Nómina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-853',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Nomina (A)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-854',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA DE PLANES Y BENEFCIOS (A)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-855',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-856',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planes y Beneficios (A)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-857',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Proyectos Sociocomunitarios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-858',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Recursos Humanos (A)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-859',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Servicios de Logística y Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-860',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Servicios Logisticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-861',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista del SISDEM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-862',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista SISDEM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-863',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('As.Integral de Planif.y Ctrol.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-864',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Jubilados (A)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-865',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Atención al Jubilado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-866',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-867',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Planes y Benef.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-868',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Planificación y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-869',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-870',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Serv.Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-871',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.(E) de CAPET Región Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-872',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('COMISION DE SERVICIO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-873',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Recursos Humanos Región Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-874',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-875',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-876',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-877',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Formación Continua');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-878',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Logística y Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-879',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-880',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Programación Académica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-881',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-882',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Servicios Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-883',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-24'));
//        $this->addReference('Cargo-884',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 25
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Estimación de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-25'));
//        $this->addReference('Cargo-885',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Estimación de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-25'));
//        $this->addReference('Cargo-886',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 26
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista  de Protección en Pralca (E)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-887',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA DE ADMINISTRACIÓN Y C. DE GESTION');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-888',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Investigaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-889',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de P.B.I.P');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-890',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA DE PROTECCION');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-891',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA DE PROTECCION EMPRESARIAL');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-892',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Tecnología de Protección');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-893',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Verificaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-894',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Protec.Activos de Información');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-895',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista UNIR');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-896',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte. P.C.P.Region Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-897',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista Identificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-898',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Cecon');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-899',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de CECON');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-900',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de P.B.I.P');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-901',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de PBIP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-902',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-903',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de PROTECCION.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-904',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Protección');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-905',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Recepcionista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-906',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-907',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor ADMINISTRACIÓN Y CONTROL DE GESTIÓN.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-908',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Investigaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-909',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Prevención');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-910',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Integral de EEMMNP (Empresas Mixtas y Nuevos Proyectos) en Navay y Puerto Nutrias.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-911',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Integral Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-912',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-26'));
//        $this->addReference('Cargo-913',$cargo);
//          $manager->persist($cargo);
//
//        //  GERENCIA 27
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Estadística e Información');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-27'));
//        $this->addReference('Cargo-914',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Personal por Reubicar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-27'));
//        $this->addReference('Cargo-915',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 28
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Atención Soporte a Usuarios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-916',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-917',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Operaciones de Sistemas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-918',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Redes de Telecomunicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-920',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Soporte Espec.de Operaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-921',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte. A.I.T.Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-922',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-923',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Atención y Soporte a Usuarios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-924',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Operac.Sistemas de Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-925',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-28'));
//        $this->addReference('Cargo-926',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 29
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración y Control');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-927',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comunicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-928',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comunicaciones Externas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-929',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Diseño Gráfico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-930',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Programación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-931',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Protocolo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-932',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Org.de Eventos y Protocolo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-933',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Emisora 88.7 FM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-934',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Operador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-29'));
//        $this->addReference('Cargo-935',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 30
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Albert Martinez');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-936',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administracion Integral y Control Interno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-937',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración Integral y Control Interno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-938',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contabilidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-939',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contrataciones Admtva');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-940',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contrataciones Admtva.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-941',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contrataciones Proc.Técnicos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-942',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-943',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Cobrar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-944',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Pagar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-945',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Evaluaciones Financieras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-946',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Licitaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-947',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-948',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-949',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Presupuesto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-950',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Procesos de Contratación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-951',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Finanzas CPAMC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-952',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista de Archivo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-953',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-954',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Admón.Integral y Control Interno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-955',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Licitación y Contratación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-956',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Contabilidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-957',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Contrataciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-958',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Tesorería y Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-959',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supv. Presupuesto y Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-960',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-30'));
//        $this->addReference('Cargo-961',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 31
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-962',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planes de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-963',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Auxiliar de Laboratorio Clínico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-964',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Bioanalista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-965',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.de Enfermeras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-966',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Enfermera Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-967',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Enfermera Ocupacional Navay');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-968',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Enfermero Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-969',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Instructor del Ctro.Educ.Física y Rehab.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-970',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Asesor Planes de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-971',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Especialista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-972',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Especialista Navay');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-973',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-974',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Obreros de Limpieza');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-975',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Psicólogo Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-976',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planificación y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-977',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Salud Integral');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-978',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Salud Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-979',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-31'));
//        $this->addReference('Cargo-980',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 32
//
//        $cargo= new Cargo();
//        $cargo->setDescription('COORD. CONVENIO PRALCA - PEQUIVEN PARA PROCURAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-32'));
//        $this->addReference('Cargo-981',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Proyectos Operacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-32'));
//        $this->addReference('Cargo-982',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Proyectos de Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-32'));
//        $this->addReference('Cargo-983',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Lider de Proyecto Clorovinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-32'));
//        $this->addReference('Cargo-984',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Lider de Proyecto Serv. Ind / RAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-32'));
//        $this->addReference('Cargo-985',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-32'));
//        $this->addReference('Cargo-986',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Implementación de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-32'));
//        $this->addReference('Cargo-987',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Ingenieria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-32'));
//        $this->addReference('Cargo-988',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 33
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Bombero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-989',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Higienista Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-990',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Ambiental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-991',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Planifi.y Ctrl.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-992',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Riesgos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-993',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-994',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Sintesis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-995',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Personal por Reubicar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-996',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-997',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Ambiente, Higiene Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-998',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Ingeniería de Riesgos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-999',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Planifi.y Ctrl.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-1000',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-1001',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-33'));
//        $this->addReference('Cargo-1002',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 34
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Logística y Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-34'));
//        $this->addReference('Cargo-1003',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Gerencia General CAMC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-34'));
//        $this->addReference('Cargo-1004',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Gral.Complejo Petroquímico A.M.C.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-34'));
//        $this->addReference('Cargo-1005',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria Ejecutiva');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-34'));
//        $this->addReference('Cargo-1006',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 35
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Reg.Desarrollo Integ.Comunit.A.M.C.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-35'));
//        $this->addReference('Cargo-1007',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder de Proyecto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-35'));
//        $this->addReference('Cargo-1008',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-35'));
//        $this->addReference('Cargo-1009',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUP. INTEGRAL PCP  PROPILVEN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-35'));
//        $this->addReference('Cargo-1010',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Gestión Técnica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-35'));
//        $this->addReference('Cargo-1011',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 36
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Estandarización SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-36'));
//        $this->addReference('Cargo-1012',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Mantenimiento SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-36'));
//        $this->addReference('Cargo-1013',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coord.SIG Región Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-36'));
//        $this->addReference('Cargo-1014',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-36'));
//        $this->addReference('Cargo-1015',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Estandarización SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-36'));
//        $this->addReference('Cargo-1016',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Mantenimiento SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-36'));
//        $this->addReference('Cargo-1017',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 37
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Materiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1018',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Procura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1019',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Apoyo Servicios Generales Reparación unidades lacustres PQV');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1020',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Gerencia de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1021',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Co.Servicios Generales-PROESCA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1022',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Corporación Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1023',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('CONTRATADOR DE BIENES Y SERVICIOS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1024',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Fabricador de Equipos Tubulares');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1025',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1026',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Confiabilidad Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1027',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Confiabilidad Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1028',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Confiabilidad Mecánica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1029',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector de Equipos Estáticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1030',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector de Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1031',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspectora Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1032',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1033',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador  PVC II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1034',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador / Prog.Intr.Central');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1035',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Almacenaje Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1036',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador de Servicios Industriales - Pta. Electrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1037',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Distr-Prot');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1038',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Fertilizantes UREA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1039',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Interplantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1040',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador LGN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1041',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Serv. Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1042',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador  UREA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1043',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador de Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1044',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador Especialidades Mecánicas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1045',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador Interplantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1046',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador MVC II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1047',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1048',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Programador Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1049',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1050',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Soldador de Equipos Tubulares');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1051',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte. Mantenimiento Rutinario Manejo de Productos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1052',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Especialidades Eléctricas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1053',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Especialidades Mecánicas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1054',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Ingeniería de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1055',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mtto. Rutinario Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1056',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mtto.Rut.Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1057',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mtto.Rut.Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1058',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Mtto.Rut.Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1059',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Planificación y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1060',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.  Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1061',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. mantenimiento manejo de producto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1062',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Taller Electromecanico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1063',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. Taller Electromecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1064',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Confiabilidad Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1065',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Electricidad Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1066',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Electricidad LGN/Etano');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1067',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Electricidad Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1068',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Electricidad Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1069',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Electricidad Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1070',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1071',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Equipos Tubulares');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1072',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Inspector Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1073',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Instrumentación  LGN/Etano');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1074',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Instrumentación Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1075',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Instrumentación Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1076',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Instrumentación Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1078',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Instrumentación Planta Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1079',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Instrumentación Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1080',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Instrumentación Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1081',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Mecánica Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1082',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Mecánica Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1083',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Mecánica Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1084',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Parada de Planta Clorovinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1085',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Parada de Planta Fert./Interp./RAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1086',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Parada de Planta Serv. Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1087',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Planificación Clorovinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1088',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Planificación Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1089',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Planificación Serv.Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1090',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Sistema Contra Incendio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1091',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1092',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Mtto Rut. LGN/Etano');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1093',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Parada de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1094',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUPERNUMERARIO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1095',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Adeol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1096',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Admón y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1097',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Analizadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1098',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Cofiabilidad  Mecánica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1099',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Confiabilidad Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1100',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUPERVISOR CONVENIO PRALCA - PQV');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1101',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Distribuciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1102',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor DSC-PLC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1103',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1104',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Electricidad Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1105',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Electricidad MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1106',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Electricidad Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1107',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Electrónica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1108',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Inspector Equipos Estáticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1109',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1110',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Instrumentación Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1111',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Instrumentación MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1112',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Instrumentación PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1113',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Mecánica LGN/Etano');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1114',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Mecánica Vinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1115',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1116',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Mecánico Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1117',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1118',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Protecciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1119',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Taller de Neumática');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1120',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Maquinado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1121',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Herramientas y  Trafico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1122',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1123',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Electricidad UREA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1124',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Sistema Contra Incendio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1125',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téc.Mayor Mecánica CTA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1126',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téc.Mayor Mecánica Planta Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1127',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téc.Menor Electricidad CTA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1128',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téc.Menor Electricidad Planta Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1129',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tec.Menor Instrumentación CTA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1130',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tec.Menor Instrumentación Planta Eléct.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1131',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téc.Menor Mecánica CTA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1132',$cargo);
//          $manager->persist($cargo);
//        $cargo= new Cargo();
//        $cargo->setDescription('Téc.Menor Mecánica Planta Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1133',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Analizadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1134',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Compresores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1135',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Distribuciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1136',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor DSC-PLC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1137',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1138',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Electricista de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1139',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Electrónica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1140',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico Mayor Equipos Tubulares');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1141',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Especialidades');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1142',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('TECNICO MAYOR GESTIÓN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1143',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1144',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Mecánica Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1145',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Mecánica Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1146',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Mecánica Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1147',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Mecánica Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1148',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Mecánico PVC II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1149',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Turbinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1150',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico Menor Ajuste');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1151',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Ajuste');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1152',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Analizadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1153',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Compresores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1154',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Distribuciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1155',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1156',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Electricidad Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1157',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Electricidad MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1158',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Electricidad Olefnas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1159',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Electricidad Olefnas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1160',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Electricidad PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1161',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Electricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1162',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico Menor en Areas Externas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1163',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico Menor en Taller');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1164',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Especialidades');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1165',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Herramientas y Trafico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1166',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1167',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1168',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1169',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación MVC II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1170',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación PVC II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1171',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Instrumentación Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1172',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Maquinado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1173',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1174',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánica Almacenaje-Adeol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1175',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánica Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1176',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánica Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1177',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánica Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1178',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánica Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1179',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1180',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecanico Adeol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1181',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánico Adeol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1182',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánico Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1183',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánico MVC II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1184',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánico Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1185',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánico PVC II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1186',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Neumático');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1187',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Protecciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1188',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Taller Motores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1189',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Turbinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1190',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Mayor Electricidad Adeol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1191',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Mayor Instrumentación Adeol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1192',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Electricidad Adeol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1193',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Electricidad Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1194',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Electricidad UREA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1195',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Instrumentación Adeol ');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1196',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Instrumentación Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1197',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Instrumentación Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1198',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Sistema Contra Incendio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1199',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Operador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-37'));
//        $this->addReference('Cargo-1200',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 38
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Almacenista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1201',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de compras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1202',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planificacion');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1203',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Ejecutiva');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1204',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Despachador de Insumos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1205',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Despachador de Materiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1206',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Despacho de Materiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1207',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista Aduana');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1208',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Recibidor de Insumos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1209',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1210',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Verificador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-38'));
//        $this->addReference('Cargo-1211',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 39
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Admón.Integral y Control Inter.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1212',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA DE LABORATORIO  MVC  II.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1213',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Despacho Maritimo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1214',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Menor Despacho Vinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1215',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado An.de Planificación y Programac');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1216',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado An.de Planificación y Programac.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1217',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Analista de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1218',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de Planificación PNOGO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1219',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Ing.de Perforación y Rehabilita');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1220',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Spte.de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1221',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Spte.de Programación Lago');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1222',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Spte.Mantenimiento Operacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1223',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Spte.Operac.Extrac.y Manejo Flu');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1224',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Spte.Recuperación y Mtto.Eq.Acu');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1225',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1226',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente de Producción Alm/Efl Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1227',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente de Producción MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1228',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ASISTENTE DE PRODUCCION SAN AGUSTIN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1229',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Producción Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1230',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Producción Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1231',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Autorización de carga');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1232',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coord.Adiestramiento Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1233',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador de Adiestramiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1234',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador de Adiestramiento Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1235',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Deschadora Terrestre');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1236',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Despachador Maritimo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1237',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Despachador Terrestre');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1238',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Despachadora Terrestre');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1239',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ducumentista Marítima');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1240',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1241',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1242',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing. Polimerización PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1243',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.de Producción Generación Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1244',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.de Producción Generación Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1245',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero  de Producción Interplantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1246',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Electrolisis Caustica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1247',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Polimerización PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1248',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Produccion');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1249',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1250',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Producción de Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1251',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Producción LGN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1252',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Producción MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1253',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Producción Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1254',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Secado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1255',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Petroquímicos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1256',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Procesos Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1257',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Producción Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1258',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Producción Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1259',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector de Buque');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1260',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector Vehiculos/Bascula');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1261',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Acondicionamiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1262',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Agua Desmineralizada');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1263',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador agua desmineralizada desmineralizada');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1264',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Aire Industrial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1265',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Almac. Rascadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1266',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Almacenaje/ Adeol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1267',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Almacenaje/ Efluente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1268',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Almacenaje/ servicio olefinas1');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1269',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Almacenaje/Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1270',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Aquatech');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1271',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Area 90');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1272',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Area Booster');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1273',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Area Compresores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1274',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Area Evaporación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1275',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Area Síntesis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1276',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Area Torre Prill');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1277',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador auxiliar de cloro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1278',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Calderas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1279',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador CELAD / SALMUERA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1280',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Celdas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1281',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Cintas y Galerias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1282',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Cloración Directa MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1283',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Cloro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1284',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Compresores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1285',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Control Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1286',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Craqueo/Almacenaje MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1287',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de area cloro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1288',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Carga / Bascula');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1289',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Carga/Bascula');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-2200',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de compresores de amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1290',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Interplantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1291',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Lavado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1292',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('OPERADOR DE PLANTA RAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1293',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1294',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Despacho Cistenas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1295',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Despacho Cloro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1296',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1297',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Electrolizadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1298',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Generación Aire industrial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1299',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Generación Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1300',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Generación Vapor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1301',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Grúa y Pala Almacen/Insumos Vi.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1302',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Grúa y Pala Despacho');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1303',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Grúa y Pala Despacho Productos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1304',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Grúa y Pala LLenado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1305',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Incineración/Efluentes MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1306',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Interplantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1307',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Lavado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1308',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Manejo de Desechos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1309',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Almacenaje/Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1310',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Area 41');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1311',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Control de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1312',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Despacho Cloro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1313',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Hidrogeno/HCL');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1314',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Hidrólisis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1315',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Interplantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1316',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Manejo de Data');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1317',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Muelles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1318',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1319',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1320',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1321',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor PPE');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1322',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Producción LGN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1323',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1324',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor RAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1325',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Salmuera/Celdas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1326',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Menor Turno Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1327',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Muelles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1328',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1329',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1330',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Oxicloración MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1331',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Patio de Sal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1332',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('OPERADOR PLANTA RAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1333',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('OPERADOR PLANTARAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1334',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Producción LGN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1335',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Producción PPE');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1336',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1337',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador RAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1338',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador reformacion');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1339',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Reformación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1340',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Salmuera');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1341',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Sintesis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1342',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Sistema Contraincendio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1343',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Soda Liquida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1344',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador TGS. A GAS/S-E 115 KV/ Y SCI');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1345',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Torre CW');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1346',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Turno Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1347',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1348',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Almacenaje/Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1349',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1350',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Cloración Directa MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1351',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Cloro Hidrogeno/HCL');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1352',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('PANELISTA DE AMONIACO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1353',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista de Polimerización PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1354',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista de Secado PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1356',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista del área de polymerización');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1357',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Generación de Vapor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1358',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Generación Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1359',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Generacion Servicios Aux');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1360',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Generación Servicios Aux');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1361',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Generación vapor-area exterior');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1362',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1363',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1364',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1365',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Oxiclor/Efluente MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1366',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Poduccion de agua desmineralizada');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1367',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Producción LGN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1368',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Producción PPE');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1369',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista RAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1370',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Panelista Salmuera/Celdas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1371',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1372',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Manejo de Productos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1373',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Vinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1374',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.RAS-Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1375',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup aux Reformacion y lavado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1376',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup Producción (A)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1377',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Almacenaje/Efluentes Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1378',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar Area 90');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1379',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar Booster');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1380',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar Compresores y Sintesis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1381',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar Compresores y Síntesis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1382',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar Evaporación Torre Prill');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1383',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar Reforma y Lavado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1384',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Interplantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1385',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Almacenaje/Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1386',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Gener. Electrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1387',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Gener. Serv. Aux');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1388',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Generación Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1389',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Interplantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1390',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1391',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Prog.y Despacho Maritimo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1392',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Despacho de Productos Vinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1393',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Generación de Vapor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1394',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Generación Servicios Auxiliares');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1395',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Manejo y Planificación de Envasado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1396',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Maniobras Eléctricas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1397',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Producción Olefinas II');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1398',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Programación y Despacho Maritimo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1399',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Trab. Prog. Pta. Elec.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1400',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Turno Generación de Vapor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1401',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Turno Generación Electrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1402',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Turno Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1403',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Turno Producción LGN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1404',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Cloro Soda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1405',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1406',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Gas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1407',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1408',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUPERINTENDENTE DE PRODUCCION');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1409',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1410',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Almacén Insumos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1411',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Aux. Almacen');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1412',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Aux. Area 41');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1413',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Aux. Hidrólisis');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1414',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Almacenes Vinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1415',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Despacho');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1416',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1417',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUPERVISOR DE PLANTA CLORO - SODA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1418',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1419',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1420',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno Almacenaje/Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1421',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1422',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1423',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno MVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1424',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno PVC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1425',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1426',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Despacho Terrestre');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1427',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Electrolisis Cáustica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1428',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Envasado Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1429',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Generación Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1430',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor General de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1431',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor General Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1432',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Manejo de Desechos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1433',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Planta Amoniaco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1434',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Planta Urea');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1435',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Producción LGN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1436',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Produccion Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1437',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Producción PPE');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1438',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor RAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1439',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Turno Efluentes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1440',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1441',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Mayor Electrolizadores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1442',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Tecnico Mayor Equipos Tubulares');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-39'));
//        $this->addReference('Cargo-1443',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 40
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Mayor Serv. de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1444',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA MENOR');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1445',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Menor Artes Gráficas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1446',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA MENOR DE SERV. DE APOYO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1447',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ANALISTA MENOR SE SERVICIO DE APOYO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1448',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Menor Serv. de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1449',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Chofer');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1450',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Electricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1451',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Servicios Generales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1452',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1453',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Obras Civiles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1454',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecanico Equipos Pesados y Livianos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1455',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mensajeria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1456',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mensajería');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1457',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Obreros de Limpieza');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1458',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Equipos Pesados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1459',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1460',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Proyectista Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1461',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte. Servicios de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1462',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1463',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Artes Gráficas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1464',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar de Turno Transporte');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1465',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Contratación y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1466',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Obras y Mtto.Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1467',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Servicios de Comedor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1468',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Servicio de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1469',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Taller Equipos Pesados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1470',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Transporte');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1471',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de transporte');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1472',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1473',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('TcMn.Mecánico Equipos Pesados y Livianos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1474',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('TcMn.Mecánico Equipos Pesados y Livianos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1475',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('TcMy.Mecánico Equipos Pesados y Livianos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1476',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Menor Mecánica Olefinas I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1477',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Mayor Taller Flota');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1478',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Mtto.Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1479',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Obras Civiles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1480',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Operador Equipos Pesados');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1481',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Menor Refrigeración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1482',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Téco.Mn.Mecánico Equipos Pesados y Liv.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-40'));
//        $this->addReference('Cargo-1483',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 41
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administración Acuerdos-Convenios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1484',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador Acuerdos y Conv.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1485',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Medición');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1486',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planificación y Programación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1487',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Medición');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1488',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Planificación y Programación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1489',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('GERENTE DE SUMINISTRO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1490',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1491',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Medición / Convenios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1492',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Planificación y Programación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1493',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisora de Planif. y Prog.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-41'));
//        $this->addReference('Cargo-1494',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 42
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Calidad Cloro Vinilo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1495',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Mayor Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1496',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Mayor Olefinas/Gas/Fertilizante');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1497',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Mayor Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1498',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Menor Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1499',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Menor de Vinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1500',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Menor Olefinas/Gas/Fertilizante');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1501',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Menor Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1502',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Menor Turno Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1503',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Co.Departamento Técnico - CEMEX');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1504',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Lab. y Deposito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1505',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Bibliotecólogo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1506',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Dibujante');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1507',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1508',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1509',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente Técnico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1510',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.de Aut. y Control de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1511',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Procesos Serv. Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1512',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Corrosión y Materiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1513',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero De Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1514',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1515',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1516',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1517',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Ingeniería de Plantas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1518',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1519',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Procesos Clorosoda');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1520',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Procesos de Gas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1521',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Procesos Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1522',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Procesos Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1523',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Procesos Vinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1524',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector de Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1525',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Instrumentista Menor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1526',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Calidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1527',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('PLANIFICADOR  SEGUIMIENTO Y CONTROL DE COMPRAS');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1528',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Proyectista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1529',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1530',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte. Automatización y Control de Proces');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1531',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Ingeniería de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1532',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1533',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Control Olefinas-Gas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1534',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Control Serv. Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1535',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Corrosión y Materiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1536',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1537',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Equipos Rotativos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1538',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1539',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Planoteca y Dibujo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1540',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Procesos Clorovinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1541',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Procesos Gas Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1542',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Procesos Olefinas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1543',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Procesos Serv. Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1544',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Proyecto Automatización');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1545',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Mtto.Rutinario Vinilos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1546',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Ing.Procesos Serv. Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1547',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-42'));
//        $this->addReference('Cargo-1548',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 43
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1549',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Evaluación de Negocios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1550',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Mercadeo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1551',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado a CORAMER');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1552',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de Ventas Polipropileno ( CORAMER)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1553',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('COORDINADOR COMERCIAL DE OLEFINAS Y PLASTICO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1554',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Evaluador de Negocios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1555',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Negocios de Olefinas y Plásticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1556',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-43'));
//        $this->addReference('Cargo-1557',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 44
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contabilidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1558',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Gte. Proyectos Pralca');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1559',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Gte.RRHH Polinter/As.EEMM Occ.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1560',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado a Adm.Serv.al Personal Polinter');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1561',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado a Proyectos - Polinter');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1562',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gerente General Propilven');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1563',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte. General de Pralca');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1564',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.(E) de RRHH Pralca');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1565',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de Manufactura PEAD/PEBD/PE');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1566',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de Petroquímica PNOGO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1567',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Técnico PEAD/PEBD/PELBD');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1568',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('ASIGNADO PROYECTO POLINTER');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1569',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Spte.de Operaciones PELBD');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1570',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('GERENTE DE MERCADEO PROPILVEN');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-44'));
//        $this->addReference('Cargo-1571',$cargo);
//          $manager->persist($cargo);
//
//        //COMPLEJO PETROQUIMICO JOSE ANTONIO ANZOATEGUI
//
//        // GERENCIA 45 
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-45'));
//        $this->addReference('Cargo-1572',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Asuntos Legales CPJAA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-45'));
//        $this->addReference('Cargo-1573',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 46
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor SHA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1574',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1575',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Evaluaciones Económicas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1576',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Financiamiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1577',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1578',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1579',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Civil y Urbanismo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1580',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder de QA / QC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1581',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder de Sistema Eléctrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1582',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Sistema Aguas/Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-46'));
//        $this->addReference('Cargo-1583',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 47
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.Integral de CAPET');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1584',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Organización Comunal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1585',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Integral de Capet');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1586',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('As.Integral de Planif.y Ctrol.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1587',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1588',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Planes y Benef.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1589',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Serv.Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1590',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.de CAPET Región Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1591',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Recursos Humanos Región Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1592',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1593',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1594',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1595',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Servicios Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1596',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1597',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Planta en proceso de formación. Gcia SHA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-47'));
//        $this->addReference('Cargo-1598',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 48
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Estimación de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-48'));
//        $this->addReference('Cargo-1599',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Estimación de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-48'));
//        $this->addReference('Cargo-1600',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 49
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Investigaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1601',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Tecnología de Protección');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1602',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista UNIR');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1603',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1604',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Cecon');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1605',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de P.B.I.P');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1606',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Proteccion Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1607',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1608',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('SUPERVISOR AUXILIAR DE TURNO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1609',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Admón.y Cont.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1610',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Investigaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1611',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Prevención');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-49'));
//        $this->addReference('Cargo-1612',$cargo);
//          $manager->persist($cargo);
//
//
//        // GERENCIA 50
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Atención Soporte a Usuarios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-50'));
//        $this->addReference('Cargo-1613',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-50'));
//        $this->addReference('Cargo-1614',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Ingeniería de Software');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-50'));
//        $this->addReference('Cargo-1615',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 51
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración y Control');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-51'));
//        $this->addReference('Cargo-1616',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comunicaciones Externas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-51'));
//        $this->addReference('Cargo-1617',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comunicaciones Internas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-51'));
//        $this->addReference('Cargo-1618',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Protocolo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-51'));
//        $this->addReference('Cargo-1619',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Relaciones con la Comunidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-51'));
//        $this->addReference('Cargo-1620',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Relaciones Institucionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-51'));
//        $this->addReference('Cargo-1621',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte. Asuntos Públicos CPJAA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-51'));
//        $this->addReference('Cargo-1622',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Org.de Eventos y Protocolo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-51'));
//        $this->addReference('Cargo-1623',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 52
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador Operaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1624',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador Unidad de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1625',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contabilidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1626',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contrataciones Técnicas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1627',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1628',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas por Cobrar');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1629',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Facturación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1630',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1631',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Presupuesto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1632',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Seguimiento y Control de Doc.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1633',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Finanzas CPJAA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1634',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Admón.Integral y Control Interno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1635',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Licitación y Evaluación Financiera');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1636',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Contabilidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1637',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Contrataciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1638',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Presupuesto y Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1639',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Tesorería y Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-52'));
//        $this->addReference('Cargo-1640',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 53
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Salud ');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1641',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planes de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1642',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Auxiliar de Laboratorio Clínico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1643',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Bioanalista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1644',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Enfermero Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1645',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Emergenciologo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1646',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Emergenciólogo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1647',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Especialista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1648',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Paramédico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1649',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Radiólogo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1650',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planificación y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1651',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Salud Integral');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1652',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Salud Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1653',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Trabajador Social');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-53'));
//        $this->addReference('Cargo-1654',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 54
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Bombero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1655',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Seguridad, Higiene y Ambiente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1656',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Higienista Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1657',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Ambiental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1658',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Planifi.y Ctrl.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1659',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Riesgos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1660',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Prev.Ctrl.Emerg.y Contingencias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1661',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Auxiliar de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1662',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-54'));
//        $this->addReference('Cargo-1663',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 55
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Gral.Complejo Petroquímico J.A.A.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-55'));
//        $this->addReference('Cargo-1664',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 56
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Gestión Técnica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-56'));
//        $this->addReference('Cargo-1665',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 57
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contratación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1666',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de información y Doc. Técnica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1667',$cargo);
//          $manager->persist($cargo);
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1668',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1669',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Técnico y Proyectos Operacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1670',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1671',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1672',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1673',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1674',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Laboratorio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1675',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Servicios Técnicos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1676',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Eléctricidad e Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1677',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Mecánica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1678',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-57'));
//        $this->addReference('Cargo-1679',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 58
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Estandarización SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-58'));
//        $this->addReference('Cargo-1680',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coord.SIG Región Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-58'));
//        $this->addReference('Cargo-1681',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 59
//
//        $cargo= new Cargo();
//        $cargo->setDescription('CONTROL Y SEGUIMIENTO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1682',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Electricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1683',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Mantenimiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1684',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Eléctrico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1685',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('INSPECTOR PREDICTIVO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1686',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Instrumentista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1687',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1688',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador-Equipo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1689',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1690',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador de Contrato');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1691',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('PROGRAMADOR');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1692',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1693',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Mecánica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1694',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-59'));
//        $this->addReference('Cargo-1695',$cargo);
//          $manager->persist($cargo);
//        // GERENCIA 60
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Almacenista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-60'));
//        $this->addReference('Cargo-1696',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Catalogador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-60'));
//        $this->addReference('Cargo-1697',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Comprador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-60'));
//        $this->addReference('Cargo-1698',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Materiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-60'));
//        $this->addReference('Cargo-1699',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Montacarga');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-60'));
//        $this->addReference('Cargo-1700',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente de  Procura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-60'));
//        $this->addReference('Cargo-1701',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Almacen');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-60'));
//        $this->addReference('Cargo-1702',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-60'));
//        $this->addReference('Cargo-1703',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 61
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador de Logística ');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1704',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Producción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1705',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Electricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1706',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1707',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Planta de Agua');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1708',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Eléctricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1709',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Turno de Operaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1710',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Muelle');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1711',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Superintendente Servicios Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1712',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Planta de Agua');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1713',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Turno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-61'));
//        $this->addReference('Cargo-1714',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 62
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comedor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1715',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Servicios de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1716',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Inspector Contratación y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1717',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Artes Graficas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1718',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Servicio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1719',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Transporte');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1720',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Infraestructura y Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1721',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1722',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Obras y Mtto de Infraestructuras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1723',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Comedor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1724',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1725',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Servicios de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1726',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Transporte');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-62'));
//        $this->addReference('Cargo-1727',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 63
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Mercadeo Oxigenados y Gases');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-63'));
//        $this->addReference('Cargo-1728',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ejecutivo de Ventas Alcoholes y Glicoles');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-63'));
//        $this->addReference('Cargo-1729',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente Planta Dist. Terminal Borburata');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-63'));
//        $this->addReference('Cargo-1730',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Ventas Nacionales y Mercadeo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-63'));
//        $this->addReference('Cargo-1731',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-63'));
//        $this->addReference('Cargo-1732',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Gestión y Control');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-63'));
//        $this->addReference('Cargo-1733',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 64
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada a Fertinitro /Confiabilidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1734',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Gte.Finanzas - Monomeros');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1735',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada PDVSA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1736',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Estimador de Costos -Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1737',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Asunt.Legales - Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1738',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de Finanzas Supermetanol');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1739',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de IT - Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1740',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de RRHH - Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1741',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de RRHH - SOCA/SUMA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1742',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de SHA - Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1743',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Finanzas - Metor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1744',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.General - Metor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1745',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.General - Super Octanos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1746',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Predict.y Conf.- Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1747',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Sup.de Tesoreria - Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1748',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Sup.Desarrollo Org.- Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1749',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Sup.Planif.e Ing.de Riesgo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1750',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Sistema Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1751',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-64'));
//        $this->addReference('Cargo-1752',$cargo);
//          $manager->persist($cargo);
//
//        // PROYECTO NAVAY
//
//        // GERENCIA 65
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado Proyecto Navay');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-65'));
//        $this->addReference('Cargo-1753',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 66
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Desarrollo Social');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1754',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1755',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Arquitectura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1756',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Desarrollo Minas de NAVAY');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1757',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.General Proyecto NAVAY');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1758',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1759',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista de Equipos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1760',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1761',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista Eléctricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1762',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista Electrónico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1763',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista Tuberías');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1764',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Especialista Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1765',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Especialista Eléctricista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1766',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Especialista Mecánica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1767',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Insp.TSU Construcción Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1768',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Insp.TSU Geología');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1769',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Insp.TSU Geología');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1770',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Insp.TSU Geología y Minas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1771',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Insp.TSU Topografía');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1772',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Lider Especialista Geología');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1773',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Lider Especialista Minas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1774',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Especialista Planta de Beneficio');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1775',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Especialista Serv. Industriales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1776',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Urbanismo y Edificaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1777',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Vialidad y Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1778',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico Especial Servicios Generales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1779',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('TSU Minas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-66'));
//        $this->addReference('Cargo-1780',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 67
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-67'));
//        $this->addReference('Cargo-1781',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Proyecto Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-67'));
//        $this->addReference('Cargo-1782',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista Tuberías');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-67'));
//        $this->addReference('Cargo-1783',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-67'));
//        $this->addReference('Cargo-1784',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Líder Plantas SSP y TCP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-67'));
//        $this->addReference('Cargo-1785',$cargo);
//          $manager->persist($cargo);
//
//        // PROYECTO PARAGUANA
//
//        // GERENCIA 68
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-68'));
//        $this->addReference('Cargo-1786',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Ambiente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-68'));
//        $this->addReference('Cargo-1787',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-68'));
//        $this->addReference('Cargo-1788',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Mecánica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-68'));
//        $this->addReference('Cargo-1789',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Procesos Químicos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-68'));
//        $this->addReference('Cargo-1790',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 69
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Integral Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-69'));
//        $this->addReference('Cargo-1791',$cargo);
//          $manager->persist($cargo);
//
//        // SEDE VALENCIA 
//
//        // GERENCIA 70
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1792',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado Proyecto Jose');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1793',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado Valencia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1794',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Archivo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1795',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Consultor Jurídico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1796',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Asuntos Legales Internacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1797',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Asuntos Legales Nacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1798',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Litigios y Reclamos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1799',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1800',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1801',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria Ejecutiva');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-70'));
//        $this->addReference('Cargo-1802',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 71
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Abogado Proyecto Pto. Nutrias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1803',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1804',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.Comercial y Logística');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1805',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Eval.y Ctrol.Finaciero/Admvo.Proy.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1806',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Financiamiento y Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1807',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Planifi.y Ctrol.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1808',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Relaciones Institucionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1809',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Tesoreria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1810',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.en Investigación y Nvos.Desarrollos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1811',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('As.de Serv.Financiero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1812',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1813',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada An.Contrataciones Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1814',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Co.Sist.Gest.de Calidad Petroca');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1815',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada MPP Ciencia, Tecnologia e Indus');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1816',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado As.del Gte.General - PETROCASA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1817',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Co.de AIT - CORAMER');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1818',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Línea de Puertas-Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1819',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Proy.Petrocasa Biruaca');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1820',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Proy.Región Occ.Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1821',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Proyecto Petrocasa Cumaná');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1822',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Proyectos Guacara III');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1823',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Líder Civil Costa Afuera en CPM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1824',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Líder Esp.Construcción - Petroc');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1825',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1826',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coord.de Catastro y Gestión Ambiental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1827',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coord.Mecánica y Materiales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1828',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coord.Relaciones Públicas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1829',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinación Proyecto Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1830',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador Electricidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1831',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador Especialista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1832',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador Proyecto Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1833',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.Ingeniería Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1834',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.Ingeniería Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1835',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing. Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1836',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Ambiente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1837',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1838',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Eléctrica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1839',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Instrumentación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1840',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Mecánica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1841',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Ing.Química');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1842',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente (E) Planificación y Nuevos Desarrollos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1843',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente (E) Relaciones Institucionales y Logística');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1844',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Ingeniería y Construcción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1845',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Proyecto Terminal Maritimo CPM');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1846',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Aseguramiento Contr.de la Calidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1847',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Ingenieria Proy.Internacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1848',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Gral.de Proy.Internacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1849',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Seg.y Ctrol.Financiero/Admvo.Proy.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1850',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Servicios Financieros Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1851',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1852',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Químico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1853',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Lider Agua Demineralizada Potable');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1854',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador/Controlador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1855',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1856',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Ctrol.Gestión Admin.Reg.Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1857',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Ctrol.Gestión Admin.Reg.Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1858',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Planifi.y Ctrol.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1859',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Relaci.Comerciales y Logística');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1860',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Tesoreria Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1861',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Enlace con Desarrollo Social');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1862',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Planif.y Ctrol.Gestión Reg.Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1863',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Planif.y Ctrol.Gestión Reg.Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1864',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Servicios Financieros Reg.Centro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1865',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Servicios Financieros Reg.Occidente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1866',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Servicios Financieros Reg.Oriente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-71'));
//        $this->addReference('Cargo-1867',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 72
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Nómina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1868',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador y Ctrol.de Estudios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1869',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Archivo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1870',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Nómina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1871',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.Integral de CAPET');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1872',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.Integral de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1873',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.Integral de Serv.Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1874',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1875',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Integral de Nómina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1876',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('As.Integral de Planif.y Ctrol.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1877',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Atención al Jubilado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1878',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1879',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1880',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1881',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Serv.Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1882',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada An.de Reclut.y Selec. Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1883',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada An.Nómina - Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1884',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada An.RRHH-Proy.Petrocasa Maracaib');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1885',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Co.Planificación Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1886',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Viceministra MPP de la Mujer');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1887',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Co.de RRHH - Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1888',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Cté.Transición Quimica Venoco');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1889',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.RRHH Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1890',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.de CAPET Sede Valencia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1891',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Directora Ejecutiva de Recursos Humanos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1892',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.Diseño Instruccional y Convenios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1893',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.en Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1894',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.en Planif.y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1895',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.en Planif.y Ctrol.de la Formación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1896',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.en Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1897',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.en Servicios Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1898',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Esp.Tecnologia Educativa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1899',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1900',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de CAPET');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1901',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1902',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Recursos Humanos Sede Principal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1903',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1904',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Planificación y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1905',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Servicios Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1906',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1907',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1908',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Relaciones Laborales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1909',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Servicios Organizacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1910',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Recursos Humanos Proy.Navay');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1911',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Recursos Humanos Proy.Paraguaná');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-72'));
//        $this->addReference('Cargo-1912',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 73
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Comercialización y Desarrollo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-73'));
//        $this->addReference('Cargo-1913',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Información y Entorno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-73'));
//        $this->addReference('Cargo-1914',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Producción y Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-73'));
//        $this->addReference('Cargo-1915',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Soporte Tecnológico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-73'));
//        $this->addReference('Cargo-1916',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Ctrol.de Gestión Ofic.Presidencia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-73'));
//        $this->addReference('Cargo-1917',$cargo);
//          $manager->persist($cargo);
//
//        //  GERENCIA 74
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Comedores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1918',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1919',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1920',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Bienes Patrimoniales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1921',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Reproducción y Artes Gráfica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1922',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Transporte');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1923',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista/Coordinador Agenciamiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1924',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Arquitecto');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1925',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada An.Seguim.y Control Corp.Petroc');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1926',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Asesor Estm.de Costo-Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1927',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado An.de Inventario Corp.Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1928',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1929',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente de Agenciamiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1930',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Técnico de Mantenimiento Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1931',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('COMISION DE SERVICIO EN FUNDATRABAJO');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1932',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Conductor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1933',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Conductor Ejecutivo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1934',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Fiscal de Obras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1935',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Apoyo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1936',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1937',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1938',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Inspector');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1939',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mensajero');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1940',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Motorizado');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1941',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1942',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Mantenimiento Infraestructur');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1943',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('PRESIDENTE CONSEJO DIRECTIVO DEL IVEC');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1944',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1945',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Agenciamiento');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1946',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Correspondencia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1947',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Mtto.Infraestructura(Ccas)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1948',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Reproducción y Artes Gráficas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1949',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Bienes Patrimoniales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1950',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Administración');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1951',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Mtto.Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1952',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Obras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1953',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1954',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Transporte');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1955',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Mantenimiento Infraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1956',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico/Operador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-74'));
//        $this->addReference('Cargo-1957',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 75
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Archivologo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1958',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Especialista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1959',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Director Ejecutivo(E)-Gob.Carab');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1960',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Auditor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1961',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Auditor Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1962',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente Corp.de Auditoría Interna');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1963',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Auditoría de Prod.Ind.y Proc.Corp.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1964',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Auditoría de Fertilizante');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1965',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Auditoría de Olefinas y Plásticos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1966',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Auditoría de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1967',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Determinación de Responsabilidades');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1968',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1969',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Auditoría de Fertilizante');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1970',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Auditoría de Prod.Ind.y Proc.Corp');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1971',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Auditoría de Proyectos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-75'));
//        $this->addReference('Cargo-1972',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 76
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Almacenista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1973',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('An.de Planif.y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1974',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comisiones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1975',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Compras Internacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1976',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Compras Nacionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1977',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contratos Alto Nivel');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1978',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contratos Mayores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1979',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contratos Menores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1980',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada An.Rel.Institucionales CORAMER');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1981',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Contrataciones Sede Valencia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1982',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup. de Control de Inventario. asignada a PDVSA YAGUA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1983',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Almacén');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1984',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Contratos Mayores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1985',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Contratos Menores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-76'));
//        $this->addReference('Cargo-1986',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 77
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Ingenieria de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-77'));
//        $this->addReference('Cargo-1987',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinación Civil');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-77'));
//        $this->addReference('Cargo-1988',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Estimación de Costos OP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-77'));
//        $this->addReference('Cargo-1989',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Estimación de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-77'));
//        $this->addReference('Cargo-1990',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Estimación de Costos de Inversión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-77'));
//        $this->addReference('Cargo-1991',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Estimación de Costos OP');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-77'));
//        $this->addReference('Cargo-1992',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 78
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Sist.Integral de Gest.Calidad');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-1993',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Tecnologia de Protección');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-1994',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integ.de Admón.y Control Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-1995',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Investigaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-1996',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Prevención');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-1997',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Protec.Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-1998',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor UNIR');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-1999',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Asesor Legal - Petrocasa Constr');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2000',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Gte.Ctrol.de Gestión - CORAMER');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2001',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado a Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2002',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Asesor Protección');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2003',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Asist.Administrativo Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2004',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.General-Petrocasa Construcc');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2005',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Planif.y Control Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2006',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Sup.de Almacén');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2007',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Prevención');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2008',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Oficinista de Cerrajeria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2009',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador Cecon');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2010',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Inteligencia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2011',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Ejecutiva');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2012',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Operador de Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2013',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Recepcionista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2014',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2015',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Integral Protección Empresarial');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2016',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Protección Empresarial ');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2017',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Integral Coramer');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2018',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Integral Fertinitro');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2019',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Integral METOR');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2020',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Integral Petrocasa I');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2021',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Integral Petroconstrucción');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2022',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Integral Super Octanos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2023',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Verificador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-78'));
//        $this->addReference('Cargo-2024',$cargo);
//          $manager->persist($cargo);
//
//
//        // GERENCIA 79
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2025',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Biblioteca Digital');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2026',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Indicadores de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2027',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Informes y Tendencias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2028',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Documental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2029',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Sala Situacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2030',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Estandarización SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2031',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignación Gcia.Planificación O y P');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2032',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Empresa Alimentos Aragua Social');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2033',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coord.de Informes y Tendencias');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2034',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista de Evaluación Económica');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2035',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista de Planif.y Nvos.Desarrollo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2036',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista Ing.de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2037',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Ingeniería (E)');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2038',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte. Estadistica e Informacion');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2039',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Planificación');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2040',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Esp.Configuración de Planes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2041',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Esp.Fertilizantes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2042',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Esp.Olefinas,Poliolefi.Polietileno');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2043',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ing.Especialista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2044',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Especialista Configuración de Planes');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2045',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2046',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Gestión Documental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-79'));
//        $this->addReference('Cargo-2047',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 80
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral de Planes y Beneficios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2048',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Coordinador de Gestión Ambiental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2049',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Ambiente, Higiene Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2050',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Prev.Cont.de Emerg.y Contingencia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2051',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Relaciones Institucionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2052',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero Ambiental');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2053',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Planif.y Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2054',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Ingeniero de Riesgo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2055',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2056',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte. de SHA Navay');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2057',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.de Ingeniería de Riesgos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2058',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Spte.Planifi.y Ctrl.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-80'));
//        $this->addReference('Cargo-2059',$cargo);
//          $manager->persist($cargo);
//
//
//        // GERENCIA 81
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración de Acceso');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2060',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Control y Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2061',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Escritorio de Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2062',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Gestión de la Plataforma');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2063',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Infraestructura y Telecom.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2064',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Ingeniería de Software');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2065',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Mejoras Cont.de Sist.Aplic.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2066',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Operaciones de Sistemas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2067',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Radiocomunicaciones y Enlace');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2068',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Redes de Telecomunicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2069',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Soporte Espec.de Operaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2070',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Planif.y Gestión de Procesos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2071',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Ctrl.y Gestión de la Seg.Inf.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2072',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado a la Gobernación del Estado Carabobo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2073',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado a la Secretaria de Insfraestructura');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2074',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Asesor en PDVSA Región Occident');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2075',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Secretario de Infraestructura(E');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2076',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente Administrativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2077',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Director Gral.de Obras Zona Naguanagua');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2078',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista de Integrac.de Aplicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2079',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Corporativo A.I.T.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2080',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Planificación y Control Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2081',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Soporte Espec.de Operaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2082',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.Mejoras Continuas de Sist y Aplic.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2083',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.y Radiocomunicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2084',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Administración de Acceso');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2085',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Gestión de la Plataforma');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2086',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Ingeniería de Software');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2087',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Operac.Sistemas Corporativo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2088',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Redes de Telecomunicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-81'));
//        $this->addReference('Cargo-2089',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 82
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración y Control');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2090',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Comunicaciones Externas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2091',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Diseño Gráfico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2092',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Invest.y Arquitectura de TI');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2093',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Protocolo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2094',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Relaciones Institucionales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2095',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Publicidad y Mercadeo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2096',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Co.Asuntos Internacionales Petr');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2097',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Camarógrafo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2098',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Comunicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2099',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Relaciones Públicas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2100',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2101',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Comunicaciones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2102',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Medios Audiovisuales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2103',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Organización de Eventos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2104',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Publicidad y Mercadeo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2105',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Relaciones Públicas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2106',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Técnico de Edición');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-82'));
//        $this->addReference('Cargo-2107',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 83
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administracion de Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2108',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Administración de Contratos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2109',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Atención a Proveedores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2110',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cobranzas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2111',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Contabilidad y Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2112',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Control de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2113',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Cuentas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2114',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Estados Financieros');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2115',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Operaciones Fiscales');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2116',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planificación Fiscal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2117',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Procesos Contables');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2118',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Procesos Externos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2119',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Riesgo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2120',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Seguros');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2121',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Evaluación de Créditos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2122',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Operaciones Financieras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2123',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista Pptos.de Inversiones');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2124',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Gestion de Empresas Mixtas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2125',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integ.de Contrat.y Pagos a Terc.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2126',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Integral Pagos al Personal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2127',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte. de Finanzas - PRALCA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2128',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Sup.Finanzas - Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2129',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Auditor');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2130',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.(A) Administración - Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2131',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Custodio de Valores');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2132',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Contraloría Financiera');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2133',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Presupuestos y Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2134',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Servicios Financieros');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2135',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Tesorería');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2136',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente Tributario');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2137',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.(E)Corporativo de Finanzas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2138',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2139',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Admón.Contrat.Admón.y Servicios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2140',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Presupuestos de Operaciones/Inv.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2141',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Riesgo y Seguros');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2142',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Administración Integral');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2143',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Cobranzas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2144',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Contabilidad y Pagos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2145',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Control de Costos');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2146',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Estados Financieros');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2147',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Evaluación de Crédito');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2148',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Operaciones Financieras');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2149',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor de Procesos Contables');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2150',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Supervisor Tributario');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-83'));
//        $this->addReference('Cargo-2151',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 84
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Administrador de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2152',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Archivo de Planes de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2153',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Archivo Médico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2154',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Planes de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2155',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Co.de Enfermera');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2156',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Enfermera Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2157',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Especialista en Calidad de Vida');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2158',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Corporativo de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2159',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.de Planificación y Ctrol.de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2160',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Instructor del Ctro.Educ.Física y Rehab.');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2161',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Médico Asesor Planes de Salud');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2162',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2163',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.(E)de Control de Gestión');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2164',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Salud Integral');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2165',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Sup.de Salud Ocupacional');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2166',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Trabajador Social');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-84'));
//        $this->addReference('Cargo-2167',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 85
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Organización Comunal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-85'));
//        $this->addReference('Cargo-2168',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista de Proyectos Sociocomunitarios');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-85'));
//        $this->addReference('Cargo-2169',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada DENNDD-PDVSA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-85'));
//        $this->addReference('Cargo-2170',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Desarrollo Social - PETROCASA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-85'));
//        $this->addReference('Cargo-2171',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Región Central - PALMICHAL');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-85'));
//        $this->addReference('Cargo-2172',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.Región Oriente - PALMICHAL');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-85'));
//        $this->addReference('Cargo-2173',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Sup.de Gestión - PETROCASA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-85'));
//        $this->addReference('Cargo-2174',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte.Desarrollo Social Oficina Principal');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-85'));
//        $this->addReference('Cargo-2175',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 86
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Estandarización SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-86'));
//        $this->addReference('Cargo-2176',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor de Mantenimiento SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-86'));
//        $this->addReference('Cargo-2177',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente Corporativo SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-86'));
//        $this->addReference('Cargo-2178',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gerente de Mantenimiento SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-86'));
//        $this->addReference('Cargo-2179',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Gte. de Estandarización SIG');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-86'));
//        $this->addReference('Cargo-2180',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-86'));
//        $this->addReference('Cargo-2181',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 87
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asistente');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-87'));
//        $this->addReference('Cargo-2182',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mecánico');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-87'));
//        $this->addReference('Cargo-2183',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Planificador');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-87'));
//        $this->addReference('Cargo-2184',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 88
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Director');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-88'));
//        $this->addReference('Cargo-2185',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('GERENTE GENERAL MCV');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-88'));
//        $this->addReference('Cargo-2186',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 89
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Analista');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2187',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Gte.de Operac.Planif.Petrocasa');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2188',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignado Sub-Comisión Informática CEMEX');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2189',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Chef');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2190',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Chef/Coordinador de Cocina');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2191',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Limpiador de Primera');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2192',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Mayordomo');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2193',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria Ejecutiva');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2194',$cargo);
//          $manager->persist($cargo);
//
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Secretaria Ejecutiva de Presidencia');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-89'));
//        $this->addReference('Cargo-2195',$cargo);
//          $manager->persist($cargo);
//
//        // GERENCIA 90
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada An.Comercialización - Polinter');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-90'));
//        $this->addReference('Cargo-2196',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('Asignada Especialista Proyecto Agropatria');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-90'));
//        $this->addReference('Cargo-2197',$cargo);
//          $manager->persist($cargo);
//
//        $cargo= new Cargo();
//        $cargo->setDescription('COORDINADOR PROYECTO AGROPATRIA');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-90'));
//        $this->addReference('Cargo-2198',$cargo);
//          $manager->persist($cargo);
//          
//        $cargo= new Cargo();
//        $cargo->setDescription('Asesor Permisos y Gestiones de Aduanas');
//        $cargo->setEnabled(1);
//        $cargo->setGerencia($this->getReference('Gerencia-20'));
//        $this->addReference('Cargo-2199',$cargo);
//            $manager->persist($cargo);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 5;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}