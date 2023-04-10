<?php

namespace Drom\Http;

interface HttpRequest
{
    public function setOption(int $name, $value);

    public function getInfo(int $name);

    public function getError();

    public function execute(): string;
}