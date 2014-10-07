<?php

namespace Pequiven\ArrangementProgramBundle\Form;

use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\SEIPBundle\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArrangementProgramType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryArrangementProgram',null,array(
                'label' => 'pequiven.form.category_arrangement_program',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-large",
                    "ng-model" => "model.arrangementProgram.categoryArrangementProgram",
                    "ng-change" => "getTypeGoal(model.arrangementProgram.categoryArrangementProgram)",
                ),
                'empty_value' => 'pequiven.select',
                'required' => true,
            ))
            ->add('process',null,array(
                'label' => 'pequiven.form.process',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-xlarge"
                ),
                'required' => true,
            ))
            ->add('timelines','collection',array(
                'type' => new TimelineType(),
                'allow_add' => true,
                'allow_delete' => false,
                'by_reference' => false,
                'cascade_validation' => true,
            ))
        ;
        
            $formModifier = function (\Symfony\Component\Form\FormInterface $form, \Pequiven\ObjetiveBundle\Model\Objetive $tacticalObjective = null) {
                $qb = null;
                if($tacticalObjective){
                   $qb = function (\Pequiven\ObjetiveBundle\Repository\ObjetiveRepository $repository) use ($tacticalObjective){
                       return $repository->findQueryObjetivesOperationalByObjetiveTactic($tacticalObjective);
                   };
                }
               
                $form->add('operationalObjective',null,array(
                        'label' => 'pequiven.form.operational_objective',
                        'label_attr' => array('class' => 'label'),
                        'attr' => array(
                            'class' => "select2 input-xxlarge",
//                            'disabled' => 'disabled',
//                            'ng-model' => 'model.arrangementProgram.operationalObjective',
//                            'ng-options' => 'value as value.description for (key,value) in data.operationalObjectives',
                        ),                        
                        'query_builder' => $qb,
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                    ));
            };
            
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($formModifier){
            $object = $event->getData();
            $form = $event->getForm();
            
            if($object->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                $form->add('responsible',null,array(
                        'label' => 'pequiven.form.responsible',
                        'label_attr' => array('class' => 'label'),
                        'attr' => array(
                            'class' => "select2 input-xlarge"
                        ),
                        'query_builder' => function(UserRepository $repository){
                            return $repository->findQueryToAssingTacticArrangementProgram();
                        },
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                    ))
                    ->add('tacticalObjective',null,array(
                        'label' => 'pequiven.form.tactical_objective',
                        'label_attr' => array('class' => 'label'),
                        'attr' => array(
                            'class' => "select2 input-xxlarge"
                        ),
                        'query_builder' => function(\Pequiven\ObjetiveBundle\Repository\ObjetiveRepository $repository){
                            return $repository->findQueryObjetivesTactic();
                        },
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                ))
                ;
            }elseif($object->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $form->add('responsible',null,array(
                        'label' => 'pequiven.form.responsible',
                        'label_attr' => array('class' => 'label'),
                        'attr' => array(
                            'class' => "select2 input-xlarge"
                        ),
                        'query_builder' => function(UserRepository $repository){
                            return $repository->findQueryToAssingTacticArrangementProgram();
                        },
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                    ))
                    ->add('tacticalObjective',null,array(
                        'label' => 'pequiven.form.tactical_objective',
                        'label_attr' => array('class' => 'label'),
                        'attr' => array(
                            'class' => "select2 input-xxlarge",
//                            'ng-model' => 'model.arrangementProgram.tacticalObjective',
//                            'ng-change' => 'setOperationalObjective(model.arrangementProgram.tacticalObjective)',
                        ),
                        'query_builder' => function(\Pequiven\ObjetiveBundle\Repository\ObjetiveRepository $repository){
                            return $repository->findQueryObjetivesTactic();
                        },
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                    ))
                ;
//                var_dump();die;
                $formModifier($form,$object->getTacticalObjective());
            }
            
        });
        
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use ($formModifier){
            $form = $event->getForm();
            $data = $form->getData();
            $formModifier($form,$data->getTacticalObjective());
        });
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram',
            'translation_domain' => 'PequivenArrangementProgramBundle',
            'cascade_validation' => true,
            'validation_groups' => function (\Symfony\Component\Form\FormInterface $form){
                $data = $form->getData();
                if($data->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                    return array('tacticalObjective');
                }elseif($data->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                    return array('operationalObjective');
                }
            },
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'arrangementprogram';
    }
}
