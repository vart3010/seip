<?php

namespace Pequiven\SEIPBundle\Form\Sip;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OnePerTenFileType extends AbstractType {

    /**
     * @author Matías Jiménez
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('nameFile', 'file', array(
                    'label' => 'Archivo',
                    'label_attr' => array('class' => 'label'),
                    'required' => true,
                    'mapped' => false,
                    'attr' => array('class' => 'input input-xlarge')))
                ->add('categoryFile', null, array(
                    'query_builder' => function(\Pequiven\SEIPBundle\Repository\Politic\CategoryFileRepository $repository) {
                        return $repository->findQueryCategoriesEXP();
                    },
                    'label' => 'Categorías',
                    'label_attr' => array('class' => 'label'),
                    'attr' => array(
                        'class' => "input-large select2",
                        'style' => 'width: 270px',
                        'multiple' => 'multiple'
                    ),
                    'empty_value' => 'Seleccione',
                    'required' => true,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\SEIPBundle\Entity\Sip\OnePerTenFile'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'onePerTenFile_data';
    }

}
