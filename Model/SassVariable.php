<?php
/**
 * Created by IntelliJ IDEA.
 * User: hypermedia
 * Date: 09/01/14
 * Time: 15:21
 * To change this template use File | Settings | File Templates.
 */

namespace Mrogelja\ConnectCompassBundle\Model;


class SassVariable {
    /**
     * @var $name string sass variable name
     */
    protected $name;
    /**
     * @var $value string sass variable value
     */
    protected $value;
    /**
     * @var $comment string sass variable comment
     */
    protected $comment;

    public function __construct($name = NULL, $value = NULL, $comment = NULL)
    {
        $this->name = $name;
        $this->value = $value;
        $this->comment = $comment;
    }

    /**
     * Get variable name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get variable value
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get variable comment
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set variable comment
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Set variable name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set variable value
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


}