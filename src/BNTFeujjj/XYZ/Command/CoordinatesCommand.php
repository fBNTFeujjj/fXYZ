<?php
declare(strict_types=1);

namespace BNTFeujjj\XYZ\Command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\network\mcpe\protocol\types\BoolGameRule;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use BNTFeujjj\XYZ\Main;

class CoordinatesCommand extends Command {

    public function __construct() {
        parent::__construct("coords", "Activer ou désactiver les coordonées.", "/coords <enable|disable>", ["xyz"]);
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Cette commande ne peut être utilisée que par les joueurs.");
            return;
        }

        if (count($args) === 0) {
            $this->sendUsageMessage($sender);
            return;
        }

        $action = strtolower($args[0]);
        $packet = new GameRulesChangedPacket();

        if ($action === "enable") {
            $this->setCoordinatesVisibility($sender, true, $packet);
        } elseif ($action === "disable") {
            $this->setCoordinatesVisibility($sender, false, $packet);
        } else {
            $this->sendUsageMessage($sender);
        }
    }

    private function sendUsageMessage(CommandSender $sender): void {
        $sender->sendMessage("§cUtilisation : /coords <enable|disable>");
    }

    private function setCoordinatesVisibility(Player $player, bool $visible, GameRulesChangedPacket $packet): void {
        $packet->gameRules = ["showcoordinates" => new BoolGameRule($visible, false)];
        $player->getNetworkSession()->sendDataPacket($packet);

        $config = Main::getInstance()->getConfig();
        $messageKey = $visible ? "msg-enable" : "msg-disable";
        $player->sendMessage($config->get($messageKey));
    }
}
