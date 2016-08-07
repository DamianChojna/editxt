<?php

namespace Editxt\ContentBundle\Form\DataTransformer;

use Editxt\ContentBundle\Repository\ContentItemRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Editxt\ContentBundle\Entity\ContentItem;

class ItemTransformer implements DataTransformerInterface {


    private $itemRepository;

    public function __construct(ContentItemRepository $itemRepository) {

        $this->itemRepository = $itemRepository;

    }

    public function transform($value) {


        if (null === $value) {
            return null;
        }

        return $value;
    }

    public function reverseTransform($contentItem){

        if (!$contentItem) {
            return null;
        }

        if (!empty($contentItem->getItemId())){
            $item =  $this->itemRepository->find($contentItem->getItemId());
        }
    }
}