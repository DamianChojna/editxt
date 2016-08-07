<?php

namespace Editxt\ContentBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Editxt\ContentBundle\Entity\ContentItem;


class ContentItemSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
        );
    }


    public function prePersist(LifecycleEventArgs $args)
    {
    }

}

