<?php
namespace Core\EventManager;

class LevelEvent extends AbstractEvent
{
    /*
     * @var int
     */
    protected $level;

    public function __construct($level)
    {
        $this->level = $level;
    }

    public function getData()
    {
        return [
            'level' => $this->level
        ];
    }
}