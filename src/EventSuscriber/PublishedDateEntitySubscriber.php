<?php

namespace App\EventSuscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Interface\PublishedDateEntityInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PublishedDateEntitySubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
       return [
           KernelEvents::VIEW => ['setPublishedDate', EventPriorities::PRE_WRITE]
       ];
    }
    public function setPublishedDate(ViewEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if(!$entity instanceof PublishedDateEntityInterface || Request::METHOD_POST != $method){
            return;
        }
        $entity->setPublished(new \DateTime());
    }
}