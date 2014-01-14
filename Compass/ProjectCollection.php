<?php

namespace Mrogelja\ConnectCompassBundle\Compass;
use Mrogelja\ConnectCompassBundle\Proxy\ProxyHandler;
use Symfony\Component\DependencyInjection\ContainerAware;

class ProjectCollection extends \ArrayObject
{
    protected $proxyHandler;
    protected $compassProjects;

    /**
     * class constructor
     *
     * @param \Mrogelja\ConnectCompassBundle\Proxy\ProxyHandler $proxyHandler
     * @param $projects an array of projects configuration
     * @param $defaultSettings
     */
    public function __construct(ProxyHandler $proxyHandler, $projects, $defaultSettings)
    {
        parent::__construct(array(), \ArrayObject::STD_PROP_LIST);

        foreach ($projects as $data) {
            $settings = array_merge_recursive($defaultSettings, $data['settings']);
            $project = new Project($data['path'], $proxyHandler->getProxyForSettings($settings));
            $this->offsetSet($data['name'], $project);
        }
    }
}
