<?php

namespace Mrogelja\ConnectCompassBundle\Proxy;

/**
 * Class PropelProxy
 * @package Mrogelja\ConnectCompassBundle\Proxy
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
    public function gatherSassVariables()
    {
        $query = $this->getModelQuery();
        $peer  = $this->getModelPeer();

        foreach($query::create()->find() as $sassVariableModel) {
            $this->addSassVariable(
                $sassVariableModel->{'get' . $peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}(),
                $sassVariableModel->{'get' . $peer::translateFieldName($this->variableValueProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}(),
                $sassVariableModel->{'get' . $peer::translateFieldName($this->variableCommentProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}()
            );
        }
    }

    /**
     * {@inheritdoc
     */
    public function saveSassVariables()
    {
        $peer  = $this->getModelPeer();
        $query = $this->getModelQuery();

        foreach ($this->getSassVariables() as $sassVariable) {
            $sassVariableModel = $query::create()
                ->filterBy($peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME ), $sassVariable->getName())
                ->findOneOrCreate();

            $sassVariableModel->{'set' . $peer::translateFieldName($this->variableNameProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}($sassVariable->getName());
            $sassVariableModel->{'set' . $peer::translateFieldName($this->variableValueProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}($sassVariable->getValue());
            $sassVariableModel->{'set' . $peer::translateFieldName($this->variableCommentProperty, \BasePeer::TYPE_FIELDNAME, \BasePeer::TYPE_PHPNAME )}($sassVariable->getComment());

            $sassVariableModel->save();
        }
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