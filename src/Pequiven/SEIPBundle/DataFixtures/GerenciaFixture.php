<?php
namespace Pequiven\SEIPBundle\DataFixtures;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Pequiven\SEIPBundle\Entity\Gerencia;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of ComplejoFixture
 *
 * @author matias
 */
class GerenciaFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        
        // GERENCIA COMPLEJO PETROQUIMICO MORON

        $gerencia = new Gerencia();
        $gerencia->setDescription('Consultoría Jurídica y Representante Jud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-01',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Coord.Desarrollo Social USP Morón');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-02',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Proyectos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-03',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Recursos Humanos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-04',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia. Gral. Complejo Petroquímico Morón');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-05',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Estimación de Costos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-06',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Prevención y Ctrl.de Perdid');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-07',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa A.I.T.');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-08',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Asuntos Públicos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-09',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Finanzas');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-10',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Salud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-11',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.de Seguridad, Higiene y Ambiente');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-12',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corporativa SIG');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-13',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Mantenimiento');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-14',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Materiales');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-15',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Producción');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-16',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Servicios Generales');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-17',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Suministro');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-18',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Técnica');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-19',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia UCFER');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-20',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia UNPI');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-21',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Personal Asignado');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-01'));
        $this->addReference('Gerencia-22',$gerencia);
            $manager->persist($gerencia);

        // GERENCIA COMPLEJO PETROQUIMICO ANA MARIA CAMPOS

        $gerencia = new Gerencia();
        $gerencia->setDescription('Consultoría Jurídica y Representante Jud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-23',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Recursos Humanos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-24',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Estimación de Costos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-25',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Prevención y Ctrl.de Perdid');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-26',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.Plani.Estra.y Nvos.Desarrollos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-27',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa A.I.T.');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-28',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Asuntos Públicos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-29',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Finanzas');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-30',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Salud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-31',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.de Proyectos Operacionales');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-32',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.de Seguridad, Higiene y Ambiente');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-33',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Gral.Complejo Petroquímico A.M.C.');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-34',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Reg.Desarrollo Integ.Comunit.A.M.C.');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-35',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corporativa SIG');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-36',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Mantenimiento');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-37',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Materiales');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-38',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Producción');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-39',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Servicios Generales');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-40',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Suministro');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-41',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Técnica');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-42',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia UNOP');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-43',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Personal Asignado');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-02'));
        $this->addReference('Gerencia-44',$gerencia);
            $manager->persist($gerencia);

        // GERENCIA COMPLEJO PETROQUIMICO GD JOSE ANTONIO ANZOATEGUI

        $gerencia = new Gerencia();
        $gerencia->setDescription('Consultoría Jurídica y Representante Jud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-45',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Proyectos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-46',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Recursos Humanos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-47',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Estimación de Costos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-48',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Prevención y Ctrl.de Perdid');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-49',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa A.I.T.');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-50',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Asuntos Públicos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-51',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Finanzas');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-52',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Salud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-53',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.de Seguridad, Higiene y Ambiente');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-54',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Gral.Complejo Petroquímico J.A.A.');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-55',$gerencia);
            $manager->persist($gerencia);
            
        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Reg.Desarrollo Integ.Comunit.J.A.A.');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-56',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Técnica y Proyectos Operacionales');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-57',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corporativa SIG');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-58',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Mantenimiento');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-59',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Materiales');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-60',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Producción');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-61',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Servicios Generales');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-62',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia UNPI');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-63',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Personal Asignado');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-03'));
        $this->addReference('Gerencia-64',$gerencia);
            $manager->persist($gerencia);

        // GERENCIA PROYECTO NAVAY

        $gerencia = new Gerencia();
        $gerencia->setDescription('Consultoría Jurídica y Representante Jud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-04'));
        $this->addReference('Gerencia-65',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Proyectos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-04'));
        $this->addReference('Gerencia-66',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.Plani.Estra.y Nvos.Desarrollos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-04'));
        $this->addReference('Gerencia-67',$gerencia);
            $manager->persist($gerencia);

        // GERENCIA PROYECTO PARAGUANA

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Proyectos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-05'));
        $this->addReference('Gerencia-68',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Prevención y Ctrl.de Perdid');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-05'));
        $this->addReference('Gerencia-69',$gerencia);
            $manager->persist($gerencia);

        // GERENCIA SEDE VALENCIA

        $gerencia = new Gerencia();
        $gerencia->setDescription('Consultoría Jurídica y Representante Jud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-70',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Proyectos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-71',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Dirección Ejecutiva de Recursos Humanos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-72',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Control de Gestión Ofic.Presidencia');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-73',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Administración y Servicios');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-74',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Auditoría Interna');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-75',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Contrataciones');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-76',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Estimación de Costos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-77',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.de Prevención y Ctrl.de Perdid');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-78',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.Plani.Estra.y Nvos.Desarrollos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-79',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corp.Seguridad, Higiene y Ambiente');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-80',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa A.I.T.');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-81',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Asuntos Públicos');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-82',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Finanzas');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-83',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Corporativa de Salud');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-84',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gcia.Desarrollo Social Oficina Principal');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-85',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia Corporativa SIG');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-86',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Gerencia de Transporte Aéreo');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-87',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Junta Directiva de Pequiven');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-88',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Oficina de la Presidencia');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-89',$gerencia);
            $manager->persist($gerencia);

        $gerencia = new Gerencia();
        $gerencia->setDescription('Personal Asignado');
        $gerencia->setEnabled(1);
        $gerencia->setFkComplejo($this->getReference('Complejo-06'));
        $this->addReference('Gerencia-90',$gerencia);
            $manager->persist($gerencia);
            
        $manager->flush();
    }
    
    public function getOrder(){
        return 2;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
