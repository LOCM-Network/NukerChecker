<?php

declare(strict_types=1);

namespace phuongaz\nukerchecker;

use phuongaz\nukerchecker\user\DataPool;
use phuongaz\nukerchecker\user\User;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventHandler implements Listener {

    public function onJoin(PlayerJoinEvent $event) :void {
        $user = new User($event->getPlayer());
        DataPool::addData($user);
    }

    public function onBreak(BlockBreakEvent $event) :void {
        $player = $event->getPlayer();
        $user = DataPool::getData($player);
        if($user instanceof User) {
            $user->trigger();
        }
    }

    public function onQuit(PlayerQuitEvent $event) :void {
        $player = $event->getPlayer();
        DataPool::removeData($player);
    }
}