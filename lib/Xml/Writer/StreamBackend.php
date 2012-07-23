<?php
namespace Xml\Writer;
class StreamBackend extends AbstractBackend
{
    public function isValidTarget($target)
    {
        if(fopen($target, 'w')) {
            return true;
        }
        
        return false;
    }
    
    public function write(array $data)
    {
        $stream = fopen($this->getTarget(), 'w');
        fwrite($stream, $this->getXml($data));
        fclose($stream);
    }
}