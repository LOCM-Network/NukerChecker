<?php

declare(strict_types=1);

namespace phuongaz\nukerchecker\user;

use phuongaz\core\utils\TextUtils;
use phuongaz\nukerchecker\Main;
use pocketmine\player\Player;
use pocketmine\Server;

class User {

    private int $count = 0;
    private int $maxBlock = 8;
    private int $maxVL = 10;
    private int $vl = 0;

    public function __construct(Player $player) {
        $this->player = $player;
    }

    public function getPlayer() : Player {
        return $this->player;
    }

    public function getCount() : int {
        return $this->count;
    }

    public function setCount(int $count) : void {
        $this->count = $count;
    }

    public function addCount() : void {
        $this->count++;
    }

    public function resetCount() : void {
        $this->count = 0;
    }

    public function getVL() : int {
        return $this->vl;
    }

    public function addVL() : void {
        $this->vl++;
    }

    public function trigger() :void {
        $triggerTime = microtime(true);
        if($triggerTime == microtime(true)) {
            $this->addCount();
        }else{
            $this->resetCount();
        }
        if($this->getCount() >= $this->maxBlock) {
            $this->addVL();
            if($this->getPlayer()->isClosed()) return;
            Server::getInstance()->getLogger()->info("Nuker detected for " . $this->getPlayer()->getName() . " VL: " . $this->getVL());
            Main::broadtoOps("Nuker detected for " . $this->getPlayer()->getName() . " VL: " . $this->getVL());
            if($this->getVL() >= $this->maxVL) {
                Main::getInstance()->logUser($this->getPlayer()->getName());
                $this->getPlayer()->kick(TextUtils::bigFont("§l§fLOCM - §cANTI!\n") . "§c§lYou have been kicked for using Cheat!");
            }
            $this->resetCount();
        }
    }
}