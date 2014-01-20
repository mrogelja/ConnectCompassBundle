<?php
/**
 * Created by IntelliJ IDEA.
 * User: hypermedia
 * Date: 09/01/14
 * Time: 15:21
 * To change this template use File | Settings | File Templates.
 */

namespace Mr\ConnectCompassBundle\Model;


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
     * @var $type string sass variable type : color | size
     */
    protected $type;
    /**
     * @var $comment string sass variable comment
     */
    protected $comment;

    /**
     * @var $types array sass variable types
     */
    public static $types = array('color', 'size');

    /**
     * @param null $name
     * @param null $value
     * @param null $type
     * @param null $comment
     */
    public function __construct($name = NULL, $value = NULL, $type = NULL, $comment = NULL)
    {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
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

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}