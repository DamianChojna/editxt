<?php

namespace Editxt\ContentBundle\Event;

use Editxt\ContentBundle\Entity\ContentItem;
use Symfony\Component\EventDispatcher\Event;

abstract class AbstractContentItemEvent extends Event
{
    /**
     * @var ContentItem
     */
    protected $contentItem;

    /**
     * @param ContentItem $contentItem
     */
    public function __construct(ContentItem $contentItem)
    {
        $this->contentItem = $contentItem;
    }


    public function getContentItem()
    {
        return $this->contentItem;
    }
}
