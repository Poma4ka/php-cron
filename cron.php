<?php

namespace zcl;

class cron
{

    static private string $timezone = "Europe/Moscow";

    static public function job(string $cron, ?callable $callback = null, $onlyConsole = false)
    {
        if ($onlyConsole) {
            if (!self::checkConsole()) return;
        }

        if (!self::checkPeriod($cron)) return;
        $callback();
    }

    static public function setTimezone(string $timezone)
    {
        self::$timezone = $timezone;
    }

    static private function checkConsole() :bool
    {
        return php_sapi_name() === 'cli';
    }

    static private array $timesTable =
        [
            0 => "i",
            1 => "G",
            2 => "d",
            3 => "n",
            4 => "w",
        ];

    static private function checkPeriod(string $cron): bool
    {
        $cron = explode(" ", $cron);
        if (count($cron) !== 5) return false;

        foreach ($cron as $id => $value) {
            if ($value === "*") continue;

            $date = new DateTime("now", new DateTimeZone(self::$timezone));

            if (is_numeric($value)) {
                if ($date->format(self::$timesTable[$id]) === $value) continue;
            }

            if (count($value = explode("/", $value)) === 2) {
                if ($value[0] === "*") {
                    if (is_int(($date->format(self::$timesTable[$id]) / $value[1]))) continue;
                }
            }
            return false;
        }
        return true;
    }
}
