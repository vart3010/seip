<?php

namespace Pequiven\ArrangementProgramBundle\Form;

use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\SEIPBundle\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArrangementProgramType extends AbstractType implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

    private $container;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        if ($this->getSeipConfiguration()->isSupportIntegratedManagementSystem() === true) {//En caso de que este habilitada la compatibilidad con el SIG
            $builder
                    ->add('categoryArrangementProgram', null, array(
                        'label_attr' => array('class' => 'label'),
                        'label' => 'pequiven.form.category_arrangement_program',
                        'attr' => array(
                            'class' => "select2 input-large",
                            "ng-model" => "model.arrangementProgram.categoryArrangementProgram",
                            "ng-change" => "getTypeGoal(model.arrangementProgram.categoryArrangementProgram)",
                        ),
                        'empty_value' => 'pequiven.select',
                        'required' => false,
            ));
        }
        $builder->add('process', null, array(
                    'label' => 'pequiven.form.process',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input input-xlarge validate[required]"
                    ),
                    'required' => true,
                ))
                ->add('timeline', new TimelineType(), array(
                    'cascade_validation' => true,
                ))
                ->add('description', null, array(
                    'label' => 'pequiven.form.nameOfProgram',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input input-xlarge"
                    ),
                    'required' => false,
                ))
        ;

        $formModifier = function (FormEvent $event, \Pequiven\ObjetiveBundle\Model\Objetive $tacticalObjective = null, \Pequiven\MasterBundle\Entity\ArrangementProgram\CategoryArrangementProgram $categoryArrangementProgram = null, $typeArrangementProgram = 0) {
            $qb = null;
            $form = $event->getForm();
            $parameters = array(
                'class' => 'Pequiven\ObjetiveBundle\Entity\Objetive',
                'property' => 'descriptionWithGerenciaSecond',
                'label' => 'pequiven.form.operational_objective',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xlarge",
//                            'disabled' => 'disabled',
//                            'ng-model' => 'model.arrangementProgram.operationalObjective',
//                            'ng-options' => 'value as value.description for (key,value) in data.operationalObjectives',
                ),
                'empty_value' => 'pequiven.select',
                'required' => true,
            );
            $parametersTactical = array(
                'class' => 'Pequiven\ObjetiveBundle\Entity\Objetive',
                'property' => 'description',
                'label' => 'pequiven.form.tactical_objective',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "select2 input-xlarge",
//                            'disabled' => 'disabled',
//                            'ng-model' => 'model.arrangementProgram.operationalObjective',
//                            'ng-options' => 'value as value.description for (key,value) in data.operationalObjectives',
                ),
                'empty_value' => 'pequiven.select',
//                        'disabled' => true,
                'required' => true,
            );
            $data = $event->getData();
            $managementSystem = null;
            if (is_array($data) && isset($data['managementSystem']) && $data['managementSystem'] != null) {
                $managementSystem = (int) $data['managementSystem'];
            }
            if ($managementSystem != null && $categoryArrangementProgram->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG) {
//                   $qb = function (\Pequiven\ObjetiveBundle\Repository\ObjetiveRepository $repository) use ($managementSystem){
//                       return $repository->findQueryObjetivesTacticByManagementSystem($managementSystem);
//                   };
//                   $parametersTactical['query_builder'] = $qb;
            } else {
//                   $parametersTactical['choices'] = array();
            }
            if (is_array($data) && isset($data['tacticalObjective']) && $data['tacticalObjective'] != null) {
                $tacticalObjective = (int) $data['tacticalObjective'];
            }
            if ($tacticalObjective) {
                if ($categoryArrangementProgram->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {
                    $qb = function (\Pequiven\ObjetiveBundle\Repository\ObjetiveRepository $repository) use ($tacticalObjective) {
                        return $repository->findQueryObjetivesOperationalByObjetiveTactic($tacticalObjective);
                    };
                    $parameters['query_builder'] = $qb;
                }
            } else {
                if ($categoryArrangementProgram->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {
                    $parameters['choices'] = array();
                }
            }
            if ($categoryArrangementProgram != null) {
                if ($categoryArrangementProgram->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG) {
                    $form->add('tacticalObjective', 'entity', $parametersTactical);
                    if ($typeArrangementProgram == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE) {
                        $form->add('operationalObjective', 'entity', $parameters);
                    }
                } else {
                    $form->add('operationalObjective', 'entity', $parameters);
                }
            }
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($formModifier) {
            $object = $event->getData();
            $form = $event->getForm();

            if ($object->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC) {
                $form->add('responsibles', null, array(
                    'label' => 'pequiven.form.responsibles',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "select2 input-xlarge",
                    ),
                    'query_builder' => function(UserRepository $repository) {
                return $repository->findQueryToAssingTacticArrangementProgram();
            },
                    'empty_value' => 'pequiven.select',
                    'required' => false,
                ));

                if ($object->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG) {
                    $form->add('managementSystem', null, array(
                        'label' => 'pequiven.form.managementSystem',
                        'label_attr' => array('class' => 'label'),
                        'attr' => array(
                            'class' => "select2 input-xlarge",
                        ),
                        'query_builder' => function(\Pequiven\SIGBundle\Repository\ManagementSystemRepository $repository) {
                    return $repository->getManagementSystemsActives();
                },
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                    ));
                    $formModifier($event, null, $object->getCategoryArrangementProgram());
                } else {
                    $form->add('tacticalObjective', null, array(
                        'label' => 'pequiven.form.tactical_objective',
                        'label_attr' => array('class' => 'label'),
                        'attr' => array(
                            'class' => "select2 input-xlarge",
                        ),
                        'query_builder' => function(\Pequiven\ObjetiveBundle\Repository\ObjetiveRepository $repository) {
                    return $repository->findQueryObjetivesTactic();
                },
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                    ));
                }
            } elseif ($object->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE) {

                $form->add('responsibles', null, array(
                    'label' => 'pequiven.form.responsibles',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "select2 input-xlarge",
                    ),
                    'query_builder' => function(UserRepository $repository) {
                return $repository->findQueryToAssingTacticArrangementProgram();
            },
                    'empty_value' => 'pequiven.select',
                    'required' => false
                ));
                if ($object->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG) {
                    $form->add('managementSystem', null, array(
                        'label_attr' => array('class' => 'label'),
                        'label' => 'pequiven.form.managementSystem',
                        'attr' => array(
                            'class' => "select2 input-xlarge",
                        ),
                        'query_builder' => function(\Pequiven\SIGBundle\Repository\ManagementSystemRepository $repository) {
                    return $repository->getManagementSystemsActives();
                },
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                    ));
                    $formModifier($event, null, $object->getCategoryArrangementProgram(), ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE);
                } else {
                    $form->add('tacticalObjective', null, array(
                        'label' => 'pequiven.form.tactical_objective',
                        'label_attr' => array('class' => 'label'),
                        'attr' => array(
                            'class' => "select2 input-xlarge",
                        ),
                        'query_builder' => function(\Pequiven\ObjetiveBundle\Repository\ObjetiveRepository $repository) {
                    return $repository->findQueryObjetivesTactic();
                },
                        'empty_value' => 'pequiven.select',
                        'required' => true,
                    ))
                    ;
                    $formModifier($event, $object->getTacticalObjective(), $object->getCategoryArrangementProgram());
                }
            }
        });

        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) use ($formModifier) {
            $object = $event->getData();
            if ($object->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE) {
//                $formModifier($event,$object->getTacticalObjective());
            }
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use ($formModifier) {
            $form = $event->getForm();
            $data = $form->getData();

            if ($data->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE && $data->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {
                $formModifier($event, $data->getTacticalObjective(), $data->getCategoryArrangementProgram());
            }
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram',
            'translation_domain' => 'PequivenArrangementProgramBundle',
            'cascade_validation' => true,
            'validation_groups' => function (\Symfony\Component\Form\FormInterface $form) {
                $data = $form->getData();
                $groups = array();
                if ($data->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC) {
//                    if($data->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG){
//                        
//                    } else{
                    $groups = array('base', 'tacticalObjective');
//                    }
                } elseif ($data->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE) {
//                    if($data->getCategoryArrangementProgram()->getId() == ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_SIG){
//                        
//                    } else{
                    $groups = array('base', 'operationalObjective');
//                    }
                }
//                if($this->getSeipConfiguration()->isSupportIntegratedManagementSystem() === true){
//                    $groups[] = 'categoryArrangementProgram';
//                }
                return $groups;
            },
                ));
            }

            /**
             * @return string
             */
            public function getName() {
                return 'arrangementprogram';
            }

            public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
                $this->container = $container;
            }

            /**
             * Configuracion global del SEIP
             * 
             * @return \Pequiven\SEIPBundle\Service\Configuration
             */
            protected function getSeipConfiguration() {
                return $this->container->get('seip.configuration');
            }

        }
        