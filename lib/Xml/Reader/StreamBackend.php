<?php
namespace Xml\Reader;

class StreamBackend extends AbstractBackend
{
    public function isValidTarget($target)
    {
        if(fopen($target, 'r')) {
            return true;
        }
        
        return false;
    }
    
    public function read()
    {
        $contents = '';
        
        $stream = fopen($this->getTarget(), 'r');
        while(!feof($stream)) {
            $contents .= fread($stream, 2048);
        }

        fclose($stream);
        
        return $contents;
    }
}