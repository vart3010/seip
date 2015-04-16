<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\MasterBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Administrador del periodo
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PeriodAdmin extends Admin
{
    /**
     *
     * @var \Pequiven\SEIPBundle\Service\PeriodService
     */
    private $periodService;

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show) {
         $show
            ->add('name')
            ->add('description')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('opened',null,array(
                'required' => false,
            ))
            ->add('status',null,array(
                'required' => false,
            ))
            ->add('dateStartNotificationArrangementProgram')
            ->add('dateEndNotificationArrangementProgram')
            ->add('dateStartLoadArrangementProgram')
            ->add('dateEndLoadArrangementProgram')
            ->add('dateStartClearanceNotificationArrangementProgram')
            ->add('dateEndClearanceNotificationArrangementProgram')
            ->add('percentagePenalty')
            ->add('dateStartPenalty')
            ->add('dateEndPenalty')
            ->add('parent')
            ;
    }
    
    protected function configureFormFields(FormMapper $form) {
        $object = $this->getSubject();
        $childrensParameters = array(
            'class' => 'Pequiven\SEIPBundle\Entity\Period',
            'required' => false,
        );
        if($object->getId() == null){
            $dateStart = new \DateTime();
            
            $year = $dateStart->format('Y');
            $dateStart->setDate($year, 1, 1);
            $dateStart->setTime(0, 0, 0);
            $dateEnd = clone($dateStart);
            $dateEnd->setDate($year, 12, 31);
            $dateEnd->setTime(23,59,59);
            
            $object
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd)
                ->setDateStartNotificationArrangementProgram($dateStart)
                ->setDateEndNotificationArrangementProgram($dateEnd)
                ->setDateStartLoadArrangementProgram($dateStart)
                ->setDateEndLoadArrangementProgram($dateEnd)
                ->setDateStartClearanceNotificationArrangementProgram($dateStart)
                ->setDateEndClearanceNotificationArrangementProgram($dateEnd)
                ;
        }
        if($object != null && $object->getId() !== null){
            $childrensParameters['query_builder'] = function(\Pequiven\SEIPBundle\Repository\PeriodRepository $repository) use ($object){
                $qb = $repository->createQueryBuilder('p');
                $qb
                    ->leftJoin('p.child','p_c')
                        ;
                $xor = $qb->expr()->orX($qb->expr()->isNull('p_c'));
                if($object != null && $object->getId() !== null){
                   $qb 
                    ->andWhere('p.id != :period')
                    ->setParameter('period',$object)
                   ;
                   $xor->add($qb->expr()->andX('p_c.id = :period'));
                }
                $qb
                    ->andWhere($xor)
                    ;
                return $qb;
            };
           
        }
        
        $form
            ->add('name')
            ->add('description')
            ->add('dateStart','sonata_type_date_picker',array(
            ))
            ->add('dateEnd','sonata_type_date_picker',array(
            ))
            ->add('opened',null,array(
                'required' => false,
            ))
            ->add('status',null,array(
                'required' => false,
            ))
            ->add('dateStartNotificationArrangementProgram','sonata_type_date_picker',array(
            ))
            ->add('dateEndNotificationArrangementProgram','sonata_type_date_picker',array(
            ))
            ->add('dateStartLoadArrangementProgram','sonata_type_date_picker',array(
            ))
            ->add('dateEndLoadArrangementProgram','sonata_type_date_picker',array(
            ))
            ->add('dateStartClearanceNotificationArrangementProgram','sonata_type_date_picker',array(
            ))
            ->add('dateEndClearanceNotificationArrangementProgram','sonata_type_date_picker',array())
            ->add('percentagePenalty')
            ->add('dateStartPenalty','sonata_type_date_picker',array())
            ->add('dateEndPenalty','sonata_type_date_picker',array())
            ->add('parent','entity',$childrensParameters)
            ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter) {
        $filter
            ->add('name')
            ->add('description')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('status');
    }
    
    protected function configureListFields(ListMapper $list) {
        $list
            ->addIdentifier('name')
            ->add('description')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('status', null, array('editable' => true))
            ;
    }
    
    public function prePersist($object) {
        $this->periodService->clearCachePeriodActive();
    }
    
    public function preUpdate($object) {
        $this->periodService->clearCachePeriodActive();
    }
    
    function setPeriodService(\Pequiven\SEIPBundle\Service\PeriodService $periodService) {
        $this->periodService = $periodService;
    }

}
