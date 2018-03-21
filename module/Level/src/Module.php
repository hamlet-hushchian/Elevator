<?php
namespace Level;

use Core\EventManager\AbstractEventProvider;
use Level\Element\Button;
use Level\Element\Doors;

class Module extends AbstractEventProvider
{
    private $buttons = [];
    private $isButtonsActive = true;
    private $doors;
    private $levelNumber;

    public function __construct($eventManager, $levelNumber, $buttonTop = false, $buttonBot = false)
    {
        parent::__construct($eventManager);

        if ($buttonTop) {
            $this->buttons[] = new Element\Button($this, 1);
        }
        if ($buttonBot) {
            $this->buttons[] = new Element\Button($this, 0);
        }

        $this->levelNumber = $levelNumber;
        $this->doors = new Doors($this);
    }

    public function isButtonsActive()
    {
        return $this->isButtonsActive;
    }

    public function activateButtons()
    {
        $this->isButtonsActive = true;
    }

    public function deactivateButtons()
    {
        $this->isButtonsActive = false;
    }

    public function getButtons()
    {
        return $this->buttons;
    }

    public function getButtonByDirection($direction)
    {
        if($direction == 1)
        {
            return $this->buttons[0];
        }
        if($direction == 0)
        {
            return $this->buttons[1];
        }
    }

    public function getDoors()
    {
        return $this->doors;
    }

    public
    function getNumber()
    {
        return $this->levelNumber;
    }

}