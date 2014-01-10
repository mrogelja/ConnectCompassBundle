<?php

namespace Mrogelja\ConnectCompassBundle\Listener;

use Mrogelja\ConnectCompassBundle\Compass\ProjectCollection;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class ConnectCompassRequestListener
 * @package Mrogelja\ConnectCompassBundle\Listener
 */
class ConnectCompassRequestListener {
    /**
     * @var \Cypress\CompassElephantBundle\Collection\CompassProjectCollection|CompassProjectCollection
     */
    public $projectCollection;

    /**
     * class constructor
     *
     * @param \Mrogelja\ConnectCompassBundle\Compass\ProjectCollection project collection
     */
    public function __construct(ProjectCollection $projectCollection)
    {
        $this->projectCollection = $projectCollection;
    }

    /**
     * update compass projects
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $getResponseEvent
     */
    public function updateCompass(GetResponseEvent $getResponseEvent)
    {
        if (HttpKernelInterface::MASTER_REQUEST !==  $getResponseEvent->getRequestType()) {
            return;
        }

        foreach ($this->projectCollection as $project) {
            $project->dump();
        }
    }
}