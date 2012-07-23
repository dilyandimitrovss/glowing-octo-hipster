<?php
namespace Xml\Writer;

abstract class AbstractBackend
{
    protected $_target = null;

    abstract public function isValidTarget($target);
    
    abstract public function write(array $data);
    
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
    
    final public function getXml(array $data)
    {
        if(count($data) > 1) {
            throw new Exception('xml can only have one root!');
        }
        
        $key = key($data);
        
        // make sure we have a sane root tag
        if(is_int($key)) {
            $rootTag = 'items';
        } else {
            $rootTag = (string) $key;
        }
        
        $xmlwriter = new \xmlWriter;
        $xmlwriter->openMemory();
        $xmlwriter->setIndent(true);
        $xmlwriter->startDocument('1.0', 'UTF-8');
        $xmlwriter->startElement($rootTag);
        
        foreach($data[$key] as $k => $i) {
            $xmlwriter->startElement('item');
                if(is_array($i)) {
                    foreach($i as $attribute => $attributeValue) {
                        $xmlwriter->writeAttribute($attribute, $attributeValue);
                    }
                } else {
                    $xmlwriter->text($i);
                }
            $xmlwriter->endElement();
        }
        
        $xmlwriter->endElement();
        
        return $xmlwriter->flush();
    }
}