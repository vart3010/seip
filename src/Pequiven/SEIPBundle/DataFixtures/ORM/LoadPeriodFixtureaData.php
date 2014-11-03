<?php

namespace Pequiven\SEIPBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Data base de los periodos
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class LoadPeriodFixtureaData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface 
{
    protected $container;
    
    public function getOrder() {
       return 1; 
    }

    public function load(ObjectManager $manager) {
        $period = new \Pequiven\SEIPBundle\Entity\Period();
        $dateStartString = "2014-01-01";
        $dateEndString = "2014-12-31";
        $format = "Y-m-d";
        
        $dateStart = \DateTime::createFromFormat($format, $dateStartString);
        $dateEnd = \DateTime::createFromFormat($format, $dateEndString);
        $period
                ->setName("P-2014")
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd)
                ;
        $manager->persist($period);
        
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
