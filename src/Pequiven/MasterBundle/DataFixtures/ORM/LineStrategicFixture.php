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
use Pequiven\MasterBundle\Entity\LineStrategic;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
/**
 * Description of RolFixture
 *
 * @author matias
 */
class LineStrategicFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    //put your code here
    protected $container;
    public function load(ObjectManager $manager){
        $line_data = new LineStrategic();
        $lineNameArray = $line_data->getLineNameArray();
            
        $line = new LineStrategic();
        $line->setDescription('Eficiencia y calidad de los procesos');
        $line->setLevel(LineStrategic::LINE_EFICIENCIA_CALIDAD);
        $line->setLevelName($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD]);
        $line->setPolitics('Garantizar los procesos y operaciones de forma continua y eficiente de '
                . 'acuerdo a los estándares técnicos,  de calidad y de seguridad, con la finalidad de '
                . 'satisfacer la demanda nacional y exportar los excedentes que se generen.');
        $line->setRef('1.');
        $line->setEnabled(true);
        $this->addReference($lineNameArray[LineStrategic::LINE_EFICIENCIA_CALIDAD], $line);
            $manager->persist($line);
            
        $line = new LineStrategic();
        $line->setDescription('Sostenibilidad Financiera');
        $line->setLevel(LineStrategic::LINE_SOST_FINANCIERA);
        $line->setLevelName($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA]);
        $line->setPolitics('Garantizar el uso eficiente de los recursos financieros que permitan '
                . 'el desarrollo productivo, comercial y social de la Corporación. ');
        $line->setRef('2.');
        $line->setEnabled(true);
        $this->addReference($lineNameArray[LineStrategic::LINE_SOST_FINANCIERA], $line);
            $manager->persist($line);
            
        $line = new LineStrategic();
        $line->setDescription('Comercialización');
        $line->setLevel(LineStrategic::LINE_COMERCIALIZACION);
        $line->setLevelName($lineNameArray[LineStrategic::LINE_COMERCIALIZACION]);
        $line->setPolitics('Comercializar con eficiencia y calidad productos y servicios que cumplan'
                . 'con los requerimientos del mercado, garantizando la atención prioritaria de la'
                . 'demanda nacional, con un enfoque integral que abarque las cadenas productivas y de'
                . 'suministro donde se insertan nuestros productos químicos y petroquímicos, en armonía'
                . 'con el ambiente, e identificando nuevas oportunidades de negocios');
        $line->setRef('3.');
        $line->setEnabled(true);
        $this->addReference($lineNameArray[LineStrategic::LINE_COMERCIALIZACION], $line);
            $manager->persist($line);
            
        $line = new LineStrategic();
        $line->setDescription('Crecimiento');
        $line->setLevel(LineStrategic::LINE_CRECIMIENTO);
        $line->setLevelName($lineNameArray[LineStrategic::LINE_CRECIMIENTO]);
        $line->setPolitics('Promover el aumento y la diversificación de la producción petroquímica actual,'
                . ' mediante la ejecución de proyectos sostenibles, soportados en la disponibilidad de '
                . 'materias primas, la investigación y el desarrollo científico-tecnológico de acuerdo '
                . 'a la demanda nacional y a las potencialidades que tiene la Corporación en los mercados '
                . 'estratégicos.');
        $line->setRef('4.');
        $line->setEnabled(true);
        $this->addReference($lineNameArray[LineStrategic::LINE_CRECIMIENTO], $line);
            $manager->persist($line);
            
        $line = new LineStrategic();
        $line->setDescription('Seguridad, higiene, ambiente y salud laboral');
        $line->setLevel(LineStrategic::LINE_SHA);
        $line->setLevelName($lineNameArray[LineStrategic::LINE_SHA]);
        $line->setPolitics('Preservar el ambiente en armonía con el desarrollo humano, económico, social '
                . 'y cultural con los cuales está integrado, así mismo, para proteger la salud y '
                . 'seguridad de las personas, trabajadores y trabajadoras y la integridad de las '
                . 'instalaciones.');
        $line->setRef('5.');
        $line->setEnabled(true);
        $this->addReference($lineNameArray[LineStrategic::LINE_SHA], $line);
            $manager->persist($line);
            
        $line = new LineStrategic();
        $line->setDescription('Gestión del talento humano');
        $line->setLevel(LineStrategic::LINE_GESTION_TALENTO);
        $line->setLevelName($lineNameArray[LineStrategic::LINE_GESTION_TALENTO]);
        $line->setPolitics('Garantizar el cumplimiento del proceso de Recursos Humanos para proveer '
                . 'el Talento Humano calificado, asegurando su desarrollo integral y permanencia dentro '
                . 'de la Corporación.');
        $line->setRef('6.');
        $line->setEnabled(true);
        $this->addReference($lineNameArray[LineStrategic::LINE_GESTION_TALENTO], $line);
            $manager->persist($line);
            
        $line = new LineStrategic();
        $line->setDescription('Responsabilidad Social');
        $line->setLevel(LineStrategic::LINE_RESP_SOCIAL);
        $line->setLevelName($lineNameArray[LineStrategic::LINE_RESP_SOCIAL]);
        $line->setPolitics('Promover y apoyar la organización y el desarrollo integral del Poder Popular '
                . 'en las áreas de influencia de la Corporación, que contribuya a la consolidación '
                . 'del Socialismo del Siglo XXI para el fortalecimiento del proceso revolucionario.');
        $line->setRef('7.');
        $line->setEnabled(true);
        $this->addReference($lineNameArray[LineStrategic::LINE_RESP_SOCIAL], $line);
            $manager->persist($line);
          
        $manager->flush();
    }
    
    public function getOrder(){
        return 10;
    }
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
