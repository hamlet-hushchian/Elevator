<?php
namespace Elevator\Element;

class Button
{
    private  $level;

    private $isOn = false;

    public function __construct($level)
    {
        $this->level = $level;
    }

    public function isOn()
    {
        return $this->isOn;
    }

    public function on()
    {
        $this->isOn = true;
    }

    public function off()
    {
        $this->isOn = false;
    }


}