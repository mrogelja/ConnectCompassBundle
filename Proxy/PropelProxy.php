<?php

namespace Mr\ConnectCompassBundle\Proxy;

use Mr\ConnectCompassBundle\Model\SassVariable;

/**
 * Class PropelProxy
 * @package Mr\ConnectCompassBundle\Proxy
 */
class PropelProxy extends Proxy{
    protected $modelClass;
    protected $variableNameProperty;
    protected $variableValueProperty;
    protected $variableCommentProperty;
    protected $variableUpdatedAtProperty;

    /**
     * @var boolean is timestampable behavior enabled
     */
    protected $timestampableBehaviorEnabled;

    function __construct($model, $variableNameProperty, $variableValueProperty, $variableCommentProperty, $variableUpdatedAtProperty)
    {
        $this->modelClass = $model;
        $this->variableCommentProperty = $variableCommentProperty;
        $this->variableNameProperty = $variableNameProperty;
        $this->variableUpdatedAtProperty = $variableUpdatedAtProperty;
        $this->variableValueProperty = $variableValueProperty;
        $this->timestampableBehaviorEnabled = method_exists($this->modelClass, 'getUpdatedAt');
    }

    /**
     * Get the propel Query related to the propel model
     * @return string
     */
    protected function getModelQuery()
    {
        return $this->modelClass . 'Query';
    }

    /**
     * Get the propel Peer related to the propel model
     * @return string
     */
    protected function getModelPeer()
    {
        return $this->modelClass . 'Peer';
    }

    /**
     * {@inheritdoc}
     */
    public function getSassVariables()
    {
        $query = $this->getModelQuery();
        $peer  = $this->getModelPeer();

        $variables = array();

        foreach($query::create()->find() as $sassVariableModel) {
            $variables[] = new SassVariable(
                $sassVariableModel->{'get' . $peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}(),
                $sassVariableModel->{'get' . $peer::translateFieldName($this->variableValueProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}(),
                $sassVariableModel->{'get' . $peer::translateFieldName($this->variableCommentProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}()
            );
        }

        return $variables;
    }

    /**
     * Get SASS variable by name
     * @param $name
     * @return array
     */
    public function getSassVariableByName($name)
    {
        $peer  = $this->getModelPeer();
        $query = $this->getModelQuery();

        $sassVariableModel = $query::create()
            ->filterBy($peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME ), $name)
            ->findOne();

        return  new SassVariable(
            $sassVariableModel->{'get' . $peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}(),
            $sassVariableModel->{'get' . $peer::translateFieldName($this->variableValueProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}(),
            $sassVariableModel->{'get' . $peer::translateFieldName($this->variableCommentProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}()
        );
    }


    /**
     * {@inheritdoc}
     */
    public function saveSassVariable(SassVariable $sassVariable)
    {
        $peer  = $this->getModelPeer();
        $query = $this->getModelQuery();

        $sassVariableModel = $query::create()
            ->filterBy($peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME ), $sassVariable->getName())
            ->findOneOrCreate();

        $sassVariableModel->{'set' . $peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}($sassVariable->getName());
        $sassVariableModel->{'set' . $peer::translateFieldName($this->variableValueProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}($sassVariable->getValue());
        $sassVariableModel->{'set' . $peer::translateFieldName($this->variableCommentProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}($sassVariable->getComment());

        $sassVariableModel->save();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteSassVariable(SassVariable $sassVariable)
    {
        $peer  = $this->getModelPeer();
        $query = $this->getModelQuery();

        $sassVariableModel = $query::create()
            ->filterBy($peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME ), $sassVariable->getName())
            ->delete();
    }


    /**
     * {@inheritdoc}
     */
    public function isFresh(\DateTime $date)
    {
        $query = $this->getModelQuery();

        if ($this->timestampableBehaviorEnabled) {
            $lastModification = $query::create()
                ->recentlyUpdated()
                ->lastUpdatedFirst()
                ->findOne()
                ->getUpdatedAt();
        } else {
            $lastModification = $query::create()
                ->select($this->variableUpdatedAtProperty)
                ->orderBy($this->variableUpdatedAtProperty)
                ->findOne();
        }

        return $date > $lastModification;
    }


}