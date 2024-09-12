<?php

namespace BNTFeujjj\XYZ;

use BNTFeujjj\XYZ\Command\CoordinatesCommand;
use BNTFeujjj\XYZ\Command\XyzCommand;
use pocketmine\plugin\PluginBase;
class Main extends PluginBase
{
    private static self $this;


    public function onEnable(): void
    {
        self::$this = $this;
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("", new CoordinatesCommand());
    }
    public static function getInstance(): self
    {
        return self::$this;
    }
}