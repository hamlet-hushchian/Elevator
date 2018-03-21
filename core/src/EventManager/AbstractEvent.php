<?php
namespace Core\EventManager;

abstract class AbstractEvent implements EventInterface
{
    protected $name;
    protected $data = [];

    public function getName()
    {
        return $this->name;
    }

    public function getData()
    {
        return $this->data;
    }
}