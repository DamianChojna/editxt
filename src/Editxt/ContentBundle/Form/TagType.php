<?php

namespace Editxt\ContentBundle\Form;

use Editxt\ContentBundle\Form\DataTransformer\TagTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Editxt\ContentBundle\Manager\TagManager;

class TagType extends AbstractType
{

    public $manager;

    public function __construct(TagManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new TagTransformer($this->manager);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'editxt_contentbundle_tag';
    }
}
