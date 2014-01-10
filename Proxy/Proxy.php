<?php
/**
 * Created by IntelliJ IDEA.
 * User: hypermedia
 * Date: 09/01/14
 * Time: 14:18
 * To change this template use File | Settings | File Templates.
 */

namespace Mrogelja\ConnectCompassBundle\Proxy;


use Mrogelja\ConnectCompassBundle\Compass\SassVariable;

/**
 * Abstract class for data proxies
 * Class Proxy
 * @package Mrogelja\ConnectCompassBundle\Proxy
 */
abstract class Proxy {
    /**
     * @var array list of SASS variables stored in proxy
     */
    protected $sassVariables = array();

    /**
     * Add a SASS variable
     * @param $name
     * @param $value
     * @param $comment
     */
    public function addSassVariable($name, $value, $comment)
    {
        $this->sassVariables[] = new SassVariable($name, $value, $comment);
    }

    /**
     * Get SASS variables
     * @return array
     */
    public function getSassVariables()
    {
        return $this->sassVariables;
    }

    /**
     * Is the data source fresh ?
     * @param \DateTime $date
     * @return bool
     */
    abstract public function isFresh(\DateTime $date);

    /**
     * Gathers SASS variables from source
     */
    abstract public function gatherSassVariables();

    /**
     * Save SASS variables into source
     */
    abstract public function saveSassVariables();
}