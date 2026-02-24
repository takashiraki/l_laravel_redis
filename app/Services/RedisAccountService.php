<?php

declare(strict_types=1);

namespace App\Services;

class RedisAccountService
{
    public static function get(string $key): void
    {
        $key = trim($key, '"');

        $key = stripcslashes($key);

        if (preg_match('/^s:\d+:"(.*)";$/s', $key, $m)) {
            $payload = $m[1];
        } else {
            $payload = $key;
        }

        $data = unserialize($payload);

        echo "Key: {$key}\n";
        echo "Payload: {$payload}\n";
        echo 'Data: ' . print_r($data, true) . "\n";
    }
}
