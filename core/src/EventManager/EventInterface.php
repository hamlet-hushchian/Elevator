<?php

namespace Core\EventManager;

interface EventInterface
{
    public function getName();
    public function getData();
}