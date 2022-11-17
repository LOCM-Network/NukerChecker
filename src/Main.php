<?php

declare(strict_types=1);

namespace phuongaz\nukerchecker;

use phuongaz\nukerchecker\user\DataPool;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase {
    use SingletonTrait;

    public function onLoad(): void {
        self::setInstance($this);
    }

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents(new EventHandler(), $this);
        DataPool::init();
    }

    public static function broadtoOps(string $message) :void {
        foreach(self::getInstance()->getServer()->getOnlinePlayers() as $player) {
            if(Server::getInstance()->isOp($player->getName())) {
                $player->sendMessage($message);
            }
        }
    }

    public function logUser(string $userName) :void {
        $file =$this->getDataFolder() . "log.txt";
        $fh = fopen($file,"a") or die("cant open file");
        fwrite($fh, $userName . " | " . date("Y-m-d H:i:s"));
        fwrite($fh,"\r\n");
        fclose($fh);
    }
}