<?php

namespace Pequiven\SEIPBundle\Form\DataLoad\Production;

use Pequiven\SEIPBundle\Form\SeipAbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CauseFailType extends SeipAbstractForm
{
    private $typeFail;
    
    function __construct($typeFail) 
    {
        $this->typeFail = $typeFail;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeFail = $this->typeFail;
        $builder
            ->add('fail',null,[
                'class' => 'Pequiven\SEIPBundle\Entity\CEI\Fail',
                'label_attr' => array('class' => 'label'),
                "empty_value" => "",
                "attr" => array("class" => "select2 input-large select-cause-fail"),
//                'required' => false,
                'query_builder' => function (\Pequiven\SEIPBundle\Repository\CEI\FailRepository $repository) use ($typeFail)
                {
                    return $repository->findQueryByType($typeFail);
                },
                ])
            ->add('mount',null,[
                'label_attr' => array('class' => 'label'),
                "attr" => array("class" => "input input-large cause-fail"),
//                'required' => false,
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail',
            "translation_domain" => "PequivenSEIPBundle",
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'production_causefail';
    }
}
