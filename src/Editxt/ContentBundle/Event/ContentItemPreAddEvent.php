<?php

namespace Editxt\ContentBundle\Event;

use Editxt\ContentBundle\ContentItemEvent;

class ContentItemPreAddEvent extends AbstractContentItemEvent
{
    /**
     * @return string
     */
    public function getEventName()
    {
        return ContentItemEvent::CONTENT_ITEM_PRE_ADD;
    }
}
