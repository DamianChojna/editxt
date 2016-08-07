<?php

namespace Editxt\ContentBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Editxt\ContentBundle\Manager\TagManager;

class TagTransformer implements DataTransformerInterface {

    public $manager;
    public $entityClass;

    public function __construct(TagManager $manager)
    {
        $this->manager = $manager;
    }

    public function transform($tags)
    {
        if (is_null($tags)) {
            return '';
        }

        $tagNames = array();
        foreach($tags as $tag){
            $tagNames[] = $tag->getName();
        }

        return implode(', ', $tagNames);
    }

    public function reverseTransform($tags)
    {
        if ($tags) {
            $explode = explode(',', $tags);
            $filterTags = array_unique($explode);
            $arrayTags = array();
            foreach ($filterTags as $tag) {
                $arrayTags[] = $tag;
            }

            return $this->manager->manageTags($arrayTags, $this->entityClass);
        }
    }
}