<?php
namespace Xml;

use Xml\Writer\AbstractBackend as AbstractBackend;
use Xml\Writer\AbstractFrontend as AbstractFrontend;

class Writer
{
    protected $_backend = null;
    
    public function __construct($backend = null)
    {
        if(null === $backend) {
            $backend = new StreamBackend("php://stdout");
        }
        
        if(!($backend instanceof AbstractBackend)) {
            throw new Exception('The specified backend doesn\'t implement: Xml\Writer\AbstractBackend');
        }
        
        $this->setBackend($backend);
    }
    
    public function setBackend(AbstractBackend $backend)
    {
        $this->_backend = $backend;
    }
    
    public function getBackend()
    {
        if($this->_backend instanceof AbstractBackend) {
            return $this->_backend;
        }

        return false;
    }
    
    public function write(AbstractFrontend $frontend)
    {
        $array = $frontend->toArray();
        $this->getBackend()->write($array);
    }
}