<?php

namespace Editxt\ContentBundle\Form;

use Editxt\ContentBundle\Entity\Country;
use Editxt\ContentBundle\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentItemFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('title', 'text', array(
                'required' => false,
                'block_name' => '',
            ))
            ->add('body', 'text', array(
                'required' => false,
                'block_name' => '',
            ))
            ->add('tags', 'entity', array(
                'class' => 'ContentBundle:Tag',
                'property' => 'name',
                'placeholder' => '',
                'empty_data'  => null,
                'required' => false,
            ))
            ->add('subTitles', 'entity', array(
                'class' => 'ContentBundle:SubTitle',
                'property' => 'name',
                'placeholder' => '',
                'empty_data'  => null,
                'required' => false,
            ))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cnt_item_filter';
    }
}
