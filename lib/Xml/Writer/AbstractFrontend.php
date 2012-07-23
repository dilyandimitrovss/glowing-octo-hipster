<?php
namespace Xml\Writer;

abstract class AbstractFrontend
{
    protected $_data = null;
    
    public function __construct(array $data = null)
    {
        if(null !== $data) {
            $this->setData($data);
        }        
    }
    
    final public function setData($data)
    {
        $this->_data = $data;
    }
    
    final public function getData()
    {
        return $this->_data;
    }
    
    abstract public function toArray();
}