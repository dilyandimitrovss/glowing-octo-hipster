<?php
namespace Xml;

use Xml\Reader\AbstractBackend as AbstractBackend;

class Reader
{
    protected $_backend = null;
    
    protected $_itemValidator = null;
    
    public function __construct($backend = null)
    {
        if(null !== $backend) {
            $this->setBackend($backend);
        }
        
        if(null !== $frontend) {
            $this->setFrontend($frontend);
        }
    }
    
    public function setBackend(AbstractBackend $backend)
    {
        $this->_backend = $backend;
    }
    
    public function getBackend()
    {
        if(null === $this->_backend) {
            throw new Exception('no backend set');
        }
        
        return $this->_backend;
    }
    
    public function setItemValidator(\Closure $callback = null)
    {
        $this->_itemValidator = $callback;
    }
    
    public function getItemValidator()
    {
        return $this->_itemValidator;
    }
    
    public function read()
    {
        $xml = $this->getBackend()->read();
        
        $simpleXml = simplexml_load_string($xml);
        
        $data = array();
        foreach($simpleXml as $item) {
            $attrs = (array) $item->Attributes();
            if($validator = $this->getItemValidator()) {
                $return = $validator($attrs['@attributes']);
                
                if($return === true) {
                    $data[] = $attrs['@attributes'];
                } elseif(is_array($return)) {
                    $data[] = $return;
                }
            }
        }
        
        return array($simpleXml->getName() => $data);
    }
}