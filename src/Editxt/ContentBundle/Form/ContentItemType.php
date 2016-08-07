<?php

namespace Editxt\ContentBundle\Form;

use Editxt\ContentBundle\Repository\ContentItemRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Editxt\ContentBundle\Manager\TagManager;


class ContentItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('itemId', 'hidden', array(
            'required' => false
        ));
        $builder->add('title', 'text', array(
            'required' => false
        ));
        $builder->add('subTitles', 'editxt_contentbundle_subtitle', array(
            'required' => false,
            'by_reference' => false,
        ));
        $builder->add('body', 'ckeditor', array(
            'required' => true,
            'cascade_validation' => true,
            'label' => false,
            'config' => array(
                'toolbar' => array(
                    array(
                        'name'  => 'document',
                        'items' => array('Source', 'ShowBlocks', 'Maximize'),
                    ),
                    array(
                        'name'  => 'basicstyles',
                        'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                    ),
                    array(
                        'name'  => 'paragraph',
                        'items' => array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
                    ),
                    array(
                        'name'  => 'links',
                        'items' => array('Link', 'Unlink'),
                    ),
                    array(
                        'name'  => 'styles',
                        'items' => array('Format'),
                    ),
                    array(
                        'name'  => 'colors',
                        'items' => array('TextColor', 'BGColor'),
                    ),
                ),
                'uiColor' => '#ffffff',
//                'removePlugins' => 'elementspath',
            ),
        ));
        $builder->add('tags', 'editxt_contentbundle_tag', array(
            'required' => false,
            'by_reference' => false,
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Editxt\ContentBundle\Entity\ContentItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'editxt_contentbundle_contentitem';
    }
}
