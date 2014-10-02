<?php

namespace Pequiven\MasterBundle\DataFixtures\ORM\ArrangementProgram;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Data base de las categorias del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class LoadCategoryArrangementProgramData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $container;
    
    public function load(ObjectManager $manager){
        $categoryArrangementProgram = new \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram();
        $categoryArrangementProgram->setDescription("Hallazgo en el sig");
        $this->addReference("categoryArrangementProgram-hallazgo-en-el-sig", $categoryArrangementProgram);
            $manager->persist($categoryArrangementProgram);
        
        $categoryArrangementProgram = new \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram();
        $categoryArrangementProgram->setDescription("Planificación de procesos");
        $this->addReference("categoryArrangementProgram-planificacion-de-procesos", $categoryArrangementProgram);
            $manager->persist($categoryArrangementProgram);
        
        $manager->flush();
    }
    
    public function getOrder() {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

}
