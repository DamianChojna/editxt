<?php

namespace Editxt\ContentBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Editxt\ContentBundle\Event\ContentItemPreAddEvent;


class ContentItemPreAddListener {

    function onPreAdd(ContentItemPreAddEvent $ContentItemPreAddEvent) {

    }

}