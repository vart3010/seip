<?php

namespace Pequiven\ArrangementProgramBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArrangementProgramTemplateType extends AbstractType implements \Symfony\Component\DependencyInjection\ContainerAwareInterface
{
    private $container;
    
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description',null,array(
            'label_attr' => array('class' => 'label'),
            'label' => 'pequiven.form.template_description',
            'attr' => array(
                'class' => "input input-large",
             ),
        ));
        if($this->getSeipConfiguration()->isSupportIntegratedManagementSystem() === true){
            $builder
                ->add('categoryArrangementProgram',null,array(
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
        $builder->add('timeline',new TimelineType(),array())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgramTemplate',
            'translation_domain' => 'PequivenArrangementProgramBundle',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_seip_arrangementprogram_template';
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
