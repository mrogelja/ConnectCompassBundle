<?php
/**
 * Created by IntelliJ IDEA.
 * User: hypermedia
 * Date: 09/01/14
 * Time: 14:18
 * To change this template use File | Settings | File Templates.
 */

namespace Mr\ConnectCompassBundle\Proxy;


use Mr\ConnectCompassBundle\Model\SassVariable;

/**
 * Abstract class for data proxies
 * Class Proxy
 * @package Mr\ConnectCompassBundle\Proxy
 */
abstract class Proxy {
    /**
     * Is the data source fresh ?
     * @param \DateTime $date
     * @return bool
     */
    abstract public function isFresh(\DateTime $date);

    /**
     * Get SASS variables from source
     */
    abstract public function getSassVariables();

    /**
     * Get SASS variable by name
     * @param $name
     * @return array
     */
    abstract public function getSassVariableByName($name);

    /**
     * Save SASS variables into source
     *
     * @param \Mr\ConnectCompassBundle\Model\SassVariable $sassVariable
     * @return mixed
     */
    abstract public function saveSassVariable(SassVariable $sassVariable);

    /**
     * Delete SASS variable
     * @param \Mr\ConnectCompassBundle\Model\SassVariable $sassVariable
     * @internal param $name
     * @return
     */
    abstract public function deleteSassVariable(SassVariable $sassVariable);
}