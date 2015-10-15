<?php

namespace Pequiven\ArrangementProgramBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Pequiven\ArrangementProgram\Entity\ArrangementProgram;
use ErrorException;
use Exception;
use LogicException;
use Pequiven\SEIPBundle\Model\Common\CommonObject;

/**
 * Servicios para el ArrangementProgram
 * 
 * service pequiven_indicator.service.inidicator
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class ArrangementProgramService implements ContainerAwareInterface {
	
	private $container;

	public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

	/**
     * Gráfico de Columna para informe de Evolución
     * @param Indicator $indicator
     * @return type
     */
    public function getDataChartOfArrangementProgramEvolution($ArrangementProgram) {
    	die();
    	$real = array();
        $planned = array();
        $em = $this->getDoctrine()->getManager();
        $timeline = $ArrangementProgram->getTimeline();

        foreach ($timeline->getGoals() as $timeline_goals) {

            //ENERO
            $sump = $timeline_goals->getGoalDetails()->getJanuaryPlanned();
            $sumr = $timeline_goals->getGoalDetails()->getJanuaryReal();
            $planned[1] = $sump;
            $real[1] = $sumr;

            //+FEBRERO
            $sump += $timeline_goals->getGoalDetails()->getFebruaryPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getFebruaryReal();
            $planned[2] = $sump;
            $real[2] = $sumr;

            //+MARZO
            $sump += $timeline_goals->getGoalDetails()->getMarchPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getMarchReal();
            $planned[3] = $sump;
            $real[3] = $sumr;

            //+ABRIL
            $sump += $timeline_goals->getGoalDetails()->getAprilPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getAprilReal();
            $planned[4] = $sump;
            $real[4] = $sumr;

            //+MAYO
            $sump += $timeline_goals->getGoalDetails()->getMayPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getMayReal();
            $planned[5] = $sump;
            $real[5] = $sumr;

            //+JUNIO
            $sump += $timeline_goals->getGoalDetails()->getJunePlanned();
            $sumr += $timeline_goals->getGoalDetails()->getJuneReal();
            $planned[6] = $sump;
            $real[6] = $sumr;

            //+JULIO
            $sump += $timeline_goals->getGoalDetails()->getJulyPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getJulyReal();
            $planned[7] = $sump;
            $real[7] = $sumr;

            //+AGOSTO
            $sump += $timeline_goals->getGoalDetails()->getAugustPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getAugustReal();
            $planned[8] = $sump;
            $real[8] = $sumr;

            //+SEPTIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getSeptemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getSeptemberReal();
            $planned[9] = $sump;
            $real[9] = $sumr;

            //+OCTUBRE
            $sump += $timeline_goals->getGoalDetails()->getOctoberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getOctoberReal();
            $planned[10] = $sump;
            $real[10] = $sumr;

            //+NOVIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getNovemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getNovemberReal();
            $planned[11] = $sump;
            $real[11] = $sumr;

            //+DICIEMBRE
            $sump += $timeline_goals->getGoalDetails()->getDecemberPlanned();
            $sumr += $timeline_goals->getGoalDetails()->getDecemberReal();
            $planned[12] = $sump;
            $real[12] = $sumr;
        }        
        return $data;
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
 	
 	protected function getSecurityService() {
        return $this->container->get('seip.service.security');
    }
}