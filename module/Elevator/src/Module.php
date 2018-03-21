<?php
namespace Elevator;

use Elevator\Element\Button;

class Module
{
    private $countPassengers = 0;
    private $maxPassengers = 6;
    private $buttons;

    public function __construct()
    {
        $this->buttons = [
            new Button(1),
            new Button(2),
            new Button(3),
            new Button(4),
            new Button(5),
        ];
    }

    public function in()
    {
        $this->countPassengers = $this->countPassengers +1;
    }

    public function out()
    {
        $this->countPassengers = $this->countPassengers - 1;
    }

    public function getCountPassengers()
    {
        return $this->countPassengers;
    }

    public function setCountPassengers($count)
    {
        $this->countPassengers = $count;
    }

    public function getMaxPassengers()
    {
        return $this->maxPassengers;
    }

    public function getButton($number)
    {
        return $this->buttons[$number];
    }
}