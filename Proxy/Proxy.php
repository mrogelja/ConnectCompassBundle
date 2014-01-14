<?php
/**
 * Created by IntelliJ IDEA.
 * User: hypermedia
 * Date: 09/01/14
 * Time: 14:18
 * To change this template use File | Settings | File Templates.
 */

namespace Mrogelja\ConnectCompassBundle\Proxy;


use Mrogelja\ConnectCompassBundle\Model\SassVariable;

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
        $this->sassVariables[$name] = new SassVariable($name, $value, $comment);
    }

    /**
     * Get SASS variables
     * @return array
     */
    public function getSassVariables()
    {
        $this->loadSassVariables();

        return $this->sassVariables;
    }

    /**
     * Get SASS variable by name
     * @param $name
     * @return array
     */
    public function getSassVariableByName($name)
    {
        $this->loadSassVariables();

        if (isset($this->sassVariables[$name])) {
            return $this->sassVariables[$name];
        }
    }

    /**
     * Save SASS variable
     */
    public function saveSassVariables()
    {
        foreach ($this->getSassVariables() as $sassVariable) {
            $this->saveSassVariable($sassVariable);
        }
    }

    /**
     * Is the data source fresh ?
     * @param \DateTime $date
     * @return bool
     */
    abstract public function isFresh(\DateTime $date);

    /**
     * Load SASS variables from source
     */
    abstract public function loadSassVariables();

    /**
     * Save SASS variables into source
     *
     * @param SassVariable $variable
     * @return mixed
     */
    abstract public function saveSassVariable(SassVariable $variable);
}