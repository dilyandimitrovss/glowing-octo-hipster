<?php
namespace Xml\Writer;

class ArrayFrontend extends AbstractFrontend
{
    public function toArray()
    {
        return $this->getData();
    }
}