<?php

namespace Pequiven\SIGBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use ErrorException;
use Exception;
use LogicException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Servicios para los informes de evolución
 * 
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class EvolutionService implements ContainerAwareInterface {

	private $container;

	/**
     * Buscamos las acciones de las causas
     * @param Request $request
     * @return \Pequiven\IndicatorBundle\Entity\Indicator\EvolutionIndicator\EvolutionCauses
     * @throws type
     */
    public function findEvolutionCause($object, $request, $typeObject) {        
        $id = $object->getId();

        //Mes Consultado       
        $month = $request->get('month');

        //Carga de variable base
        $opc = false;
        $idAction = $actionResult = 0;
        $idCons = [0];

        //$results = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('indicator' => $idIndicator,'month'=> $month));
        if ($typeObject == 1) {
            $results = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('indicator' => $id));
        } elseif ($typeObject == 2) {
            $results = $this->container->get('pequiven.repository.sig_causes_report_evolution')->findBy(array('arrangementProgram' => $id));
        }

        $cause = array();
        if ($results) {
            foreach ($results as $value) {
                $idCause = $value->getId();
                $cause[] = $idCause;
            }
            $action = $this->container->get('pequiven.repository.sig_action_indicator')->findBy(array('evolutionCause' => $cause));
        }

        if (!$results) {
            $action = null;
        }

        //Carga de las acciones para sacar la verificaciones realizadas
        if ($action) {
            foreach ($action as $value) {
                $relation = $value->getRelactionValue();
                foreach ($relation as $value) {
                    $monthAction = $value->getMonth();
                    $monthGet = (int) $month;
                    if ($monthAction === $monthGet) {

                        $idAction = $value->getActionValue()->getId();
                        $idCons[] = $idAction;
                    }
                }
            }
            $actionResult = $this->container->get('pequiven.repository.sig_action_indicator')->findBy(array('id' => $idCons));
        }
//        $actionsValues = EvolutionActionValue::getActionValues($idCons, $month);          
        $actionsValues = $this->container->get('pequiven.repository.sig_action_value_indicator')->findBy(array('actionValue' => $idCons, 'month' => $month));
        $cant = count($actionResult);

        if ($opc = false) {
            $idAction = null;
        }
        if ($typeObject == 1) {
            $verification = $this->container->get('pequiven.repository.sig_action_verification')->findBy(array('indicator' => $id, 'month' => $month));
        } elseif ($typeObject == 2) {
            $verification = $this->container->get('pequiven.repository.sig_action_verification')->findBy(array('arrangementProgram' => $id, 'month' => $month));
        }

        //Carga de array con la data
        $data = [
            'action'        => $actionResult, //Pasando la data de las acciones si las hay
            'verification'  => $verification, //Pasando la data de las verificaciones            
            'actionValue'   => $actionsValues,
            'cant'          => $cant
        ];

        return $data;
    }   

    /**
     *
     *
     */
	public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
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
}