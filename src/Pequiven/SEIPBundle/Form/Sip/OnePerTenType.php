<?php

namespace Pequiven\SEIPBundle\Form\Sip;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class OnePerTenType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('user', null, array(
                    'query_builder' => function(\Pequiven\SEIPBundle\Repository\UserRepository $repository) {
                        return $repository->findQueryUsersByYesWorkStudyCircle();
                    },
                    'label' => 'Lider 1x10',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",
                        'style' => 'width: 270px',
                    //'multiple' => 'multiple'
                    ),
                    'empty_value' => 'Seleccione...',
                    'required' => false
                ))
            ->add('analisis', 'textarea', array(
                'label' => 'Análisis',
                'label_attr' => array('class' => 'label'),
                'attr' => array('class' => 'input input-large'),
                'required' => false))
        ;
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Sip\OnePerTen',
        ));
    }

    /**
     *
     * @return string
     */
    public function getName() {
        return 'onePerTen_search';
    }

}
