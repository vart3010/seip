<?php

namespace Pequiven\SEIPBundle\Form\Politic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WorkStudyCircleType extends AbstractType {

    protected $workStudyCircle;
    
    /**
     * @author Victor Tortolero
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                //->add('ref', 'text', array('attr'=> array('class'=> 'form-control' )))
                ->add('name', 'textarea', array(
                    'label' => 'Nombre del Círculo',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-large')))
                ->add('region', 'entity', array(
                    'label' => 'Región',
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\SEIPBundle\Entity\CEI\Region',
                    'property' => 'name',
                    'empty_value' => 'Seleccione',
                    'required' => true,
                    'attr' => array(
                        'class' => 'select2 input-large form-control',)))
                ->add('complejo', 'entity', array(
                    'label' => 'Complejo',
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\MasterBundle\Entity\Complejo',
                    'property' => 'description',
                    'empty_value' => 'Seleccione',
                    'required' => true,
                    'attr' => array(
                        'class' => 'select2 input-xlarge form-control',
            )))
                ->add('gerencias', 'entity', array(
                    'label' => 'Gerencia de Primera Línea',
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\MasterBundle\Entity\Gerencia',
                    'property' => 'description',
                    'empty_value' => 'Seleccione',
                    'required' => true,
                    'multiple' => true,
                    'attr' => array(
                        'class' => 'select2 input-xlarge form-control',
                        'multiple' => 'multiple'
            )))
                ->add('gerenciaSeconds', 'entity', array(
                    'label' => 'Gerencia de Segunda Línea',
                    'label_attr' => array('class' => 'label'),
                    'class' => 'Pequiven\MasterBundle\Entity\GerenciaSecond',
                    'property' => 'description',
                    'empty_value' => 'Seleccione',
                    'required' => true,
                    'multiple' => true,
                    'attr' => array(
                        'class' => 'select2 input-xlarge form-control',
                        'multiple' => 'multiple'
            )))
                ->add('superintendencia', 'text', array(
                    'label' => 'Superintendencia',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-large '),
                    'required' => false))
                ->add('supervision', 'text', array(
                    'label' => 'Supervisión',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-large '),
                    'required' => false))
                ->add('departamento', 'text', array(
                    'label' => 'Departamento',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array('class' => 'input input-large '),
                    'required' => false))
                ->add('userWorkerId', null, array(
                    'query_builder' => function(\Pequiven\SEIPBundle\Repository\UserRepository $repository) {
                        return $repository->findQueryUsersByNoWorkStudyCircle();
                    },
                    'label' => 'Miembros',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-xlarge select2",
//                        'ng-options' => 'value as (value.firstname + " "+ value.lastname + " ("+value.numPersonal+")") for (key,value) in data.responsibleGoals',
                        'style' => 'width: 270px',
                        'multiple' => 'multiple'
                    ),
                    'empty_value' => 'Seleccione',
                    'required' => true,
                ))
                ->add('members', null, array(
                    'query_builder' => function(\Pequiven\SEIPBundle\Repository\UserRepository $repository2){
                        return $repository2->findQueryUsersCoordinatorPhaseWorkStudyCircle(array('WorkStudyCircle' => $this->workStudyCircle));
                    },
                    'label' => 'Coordinadores',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-xlarge select2",
//                        'ng-options' => 'value as (value.firstname + " "+ value.lastname + " ("+value.numPersonal+")") for (key,value) in data.responsibleGoals',
                        'style' => 'width: 270px',
                        'multiple' => 'multiple'
                    ),
                    'mapped' => false,
                    'empty_value' => 'Seleccione',
                    'required' => false,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Politic\WorkStudyCircle'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'workStudyCircle_data';
    }
    
    public function __construct ($workStudyCircle = null)
    {
        $this->workStudyCircle = $workStudyCircle;
    }

}
