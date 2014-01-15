<?php

namespace Mr\ConnectCompassBundle\Compass;
use Mr\ConnectCompassBundle\Proxy\ProxyHandler;
use Symfony\Component\DependencyInjection\ContainerAware;

class ProjectCollection extends \ArrayObject
{
    protected $proxyHandler;
    protected $compassProjects;

    /**
     * class constructor
     *
     * @param \Mr\ConnectCompassBundle\Proxy\ProxyHandler $proxyHandler
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
