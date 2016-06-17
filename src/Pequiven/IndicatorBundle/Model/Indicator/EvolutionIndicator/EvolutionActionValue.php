<?php

namespace Pequiven\IndicatorBundle\Model\Indicator\EvolutionIndicator;

//use Doctrine\ORM\Mapping as ORM;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager as BaseManager;

/**
 * Modelo ActionValue 
 */
class EvolutionActionValue extends BaseManager
{

	protected $months = array();
    
    protected $em;
    protected $dataValue;
    protected $container;

	public function __construct(){
        $this->EvolutionActionValue();
    }
	
	public function EvolutionActionValue(){

        $this->em = $this->container->get('doctrine')->getManager();

    }

    /**
     * Retorna las Acciones Pertenecientes a la accion por month
     * 
     * @return string
     */
   	public static function getActionValues($idCons, $month){

       
       $dataValue = $this->get('pequiven.repository.sig_action_value_indicator')->findBy(array('actionValue' => $idCons, 'month' => $month));

       //var_dump(count($repository));
       return $dataValue;

    }	
		
    
}
