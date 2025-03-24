<?php

namespace Toggenation\DnsPropagationCheck;

use Exception;
use ReflectionClass;

class DnsPropagationCheck
{
    public static function dnsPropagationCheck(\Composer\Script\Event $event)
    {
        if (count($event->getArguments()) < 2) {
            throw new Exception("missing args required: domain, nameserver");
        }

        [$domain, $ns] = $event->getArguments();

        $nameServers = self::getNsRecords($domain);

        if (self::hasPropogated($nameServers, $ns)) {
            echo "DNS has changed to $ns for $domain" . PHP_EOL;
        } else {

            $joined = self::joinList($nameServers);

            echo "DNS still $joined for $domain" . PHP_EOL;
        }
    }

    /**
     * Joins array as string e.g.:
     * [ 'ns1', 'ns2']
     * 
     * "ns1, ns2 & ns3"
     * 
     * @param array $nameServers 
     * @return string 
     */
    public static function joinList(array $nameServers)
    {
        $popped = array_pop($nameServers);

        $joined = join(', ', $nameServers);

        if ($popped) {
            return $joined . ' & ' . $popped;
        }

        return $joined;
    }
    public static function hasPropogated($nameServers, $ns): bool
    {
        return in_array($ns, $nameServers);
    }

    public static function getNsRecords($domain)
    {
        $records = dns_get_record($domain, DNS_NS);

        $nameServers = array_map(function ($item) {
            return $item['target'];
        }, $records);

        return $nameServers;
    }

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
            echo "$type for $host FOUND\n";
        } else {
            echo "$type for $host NOT_FOUND\n";
        }
    }
}
