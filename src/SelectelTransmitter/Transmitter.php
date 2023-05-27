<?php

namespace SelectelTransmitter;

class Transmitter
{
    public function preview(){
        var_dump($this->value);
    }

    public $value = null;

    function __construct($value = 'test')
    {
        $this->value = $value;
    }
}
