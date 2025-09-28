<?php

namespace App\Contracts;

interface ResponseStrategy
{
    public function send(string $message, array $payload = [], int $status = 200);
}
