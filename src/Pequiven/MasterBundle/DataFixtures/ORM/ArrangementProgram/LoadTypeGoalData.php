<?php

namespace Pequiven\MasterBundle\DataFixtures\ORM\ArrangementProgram;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Tipo de meta o actividad
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 */
class LoadTypeGoalData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $container;
    
    public function load(ObjectManager $manager){
        $typeGoal = new \Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal();
        $typeGoal
                ->setDescription("Correción")
                ->setCategoryArrangementProgram($this->getReference("categoryArrangementProgram-hallazgo-en-el-sig"))
                ;
            $this->addReference("typeGoal-correcion", $typeGoal);
            $manager->persist($typeGoal);
            
        $typeGoal = new \Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal();
        $typeGoal
                ->setDescription("Acción correctiva")
                ->setCategoryArrangementProgram($this->getReference("categoryArrangementProgram-hallazgo-en-el-sig"))
                ;
            $this->addReference("typeGoal-accion-correctiva", $typeGoal);
            $manager->persist($typeGoal);
            
        $typeGoal = new \Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal();
        $typeGoal
                ->setDescription("Acción preventiva")
                ->setCategoryArrangementProgram($this->getReference("categoryArrangementProgram-hallazgo-en-el-sig"))
                ;
            $this->addReference("typeGoal-accion-preventiva", $typeGoal);
            $manager->persist($typeGoal);
            
        $typeGoal = new \Pequiven\MasterBundle\Entity\ArrangementProgram\TypeGoal();
        $typeGoal
                ->setDescription("Mejora")
                ->setCategoryArrangementProgram($this->getReference("categoryArrangementProgram-hallazgo-en-el-sig"))
                ;
            $this->addReference("typeGoal-mejora", $typeGoal);
            $manager->persist($typeGoal);
        
        $manager->flush();
    }
    
    public function getOrder() {
        return 2;
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}
