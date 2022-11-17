<?php

declare(strict_types=1);

namespace phuongaz\nukerchecker\user;

use pocketmine\player\Player;
use WeakMap;

final class DataPool {

    /**
    * @var WeakMap
    * @phpstan-var WeakMap<Player, User>
    */
    private static WeakMap $dataPool;

    public static function init() : void {
        self::$dataPool = new WeakMap();
    }

    public static function addData(User $user) : void {
        self::$dataPool[$user->getPlayer()] = $user;
    }

    public static function getData(Player $player) : ?User {
        return self::$dataPool[$player] ?? null;
    }

    public static function removeData(Player $player) : void {
        unset(self::$dataPool[$player]);
    }

}