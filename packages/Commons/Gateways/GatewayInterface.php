<?php

namespace Packages\Commons\Gateways;

interface GatewayInterface
{
    public function subscribe(string $key, int $time_out): string;
}