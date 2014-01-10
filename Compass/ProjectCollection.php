<?php

namespace Mrogelja\ConnectCompassBundle\Compass;
use Mrogelja\ConnectCompassBundle\Proxy\ProxyHandler;
use Symfony\Component\DependencyInjection\ContainerAware;

class ProjectCollection implements \ArrayAccess, \Iterator, \Countable
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
        $this->position = 0;
        foreach ($projects as $data) {
            $settings = array_merge_recursive($defaultSettings, $data['settings']);
            $project = new Project($data['path'], $proxyHandler->getProxyForSettings($settings));
            $this->compassProjects[] = $project;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->compassProjects[$this->position];
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->compassProjects[$this->position]);
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $offset An offset to check for.
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->compassProjects[$offset]);
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return isset($this->compassProjects[$offset]) ? $this->compassProjects[$offset] : null;
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value The value to set.
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->compassProjects[] = $value;
        } else {
            $this->compassProjects[$offset] = $value;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param mixed $offset The offset to unset.
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->compassProjects[$offset]);
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function count()
    {
        return count($this->compassProjects);
    }


}
