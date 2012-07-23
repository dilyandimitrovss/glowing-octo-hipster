<?php
namespace Xml\Reader;

abstract class AbstractBackend
{
    protected $_target = null;

    abstract public function isValidTarget($target);
    
    abstract public function read();
    
    public function __construct($target = null)
    {
        if(null !== $target) {
            $this->setTarget($target);
        }
    }
    
    final public function setTarget($target)
    {
        if(!$this->isValidTarget($target)) {
            throw new Exception('Invalid target specified');
        }
        
        $this->_target = $target;
    }
    
    final public function getTarget()
    {
        if(null === $this->_target) {
            throw new Exception('No target set, use setTarget() to set one');
        }
        
        return $this->_target;
    }
}