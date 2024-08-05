<?php

namespace Toggenation\DnsPropagationCheck;


class DnsPropagationCheck
{

    public static function execute()
    {
        $hosts = include(__DIR__ . '/../hosts.php');

        foreach ($hosts as $host) {
            self::check($host, 'NS');
            self::check($host, 'A');
            self::check($host, 'AAAA');
        }
    }

    public static function check($host, $type)
    {
        if (checkdnsrr($host, $type)) {
            echo "$type for $host found\n";
        } else {
            echo "$type for $host NOT found\n";
        }
    }
}
