<?php

namespace Drom\Http;

interface HInterface
{
    public function get(string $url): string;

    public function post(string $url): string;

    public function put(string $url): string;

    public function getStatusCode(): int;
}