<?php

namespace Editxt\ContentBundle\Form;

use Editxt\ContentBundle\Form\ContentRelatedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true
            ))
            ->add('contentRelated', 'collection', array(
                'type' => 'editxt_contentbundle_contentrelated',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Text Blocks',
                'cascade_validation' => true,
                'attr' => array(
                    'class' => 'content_related'
                ),
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Editxt\ContentBundle\Entity\Content'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'editxt_contentbundle_content';
    }
}
