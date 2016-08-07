<?php

namespace Editxt\ContentBundle\Form;

use Editxt\ContentBundle\Form\DataTransformer\ItemTransformer;
use Editxt\ContentBundle\Repository\ContentItemRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentRelatedType extends AbstractType
{

    /**
     * @var ContentItemRepository
     */
    private $itemRepository;

    public function __construct(ContentItemRepository $itemRepository) {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('weight', 'hidden', array(
            'label' => false,
            'empty_data' => 0
        ));

        $builder->add(
            $builder
                ->create('item', 'editxt_contentbundle_contentitem', array(
                    'label' => false,
                    'cascade_validation' => true,
                    'attr' => array(
                        'class' => 'content_item'
                    )
                ))
//                ->addModelTransformer(new ItemTransformer($this->itemRepository))
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Editxt\ContentBundle\Entity\ContentRelated'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'editxt_contentbundle_contentrelated';
    }
}
