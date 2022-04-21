<?php
declare(strict_types = 1);

namespace Drom\Methods;

interface HttpRequest
{
    public function setOption(int $name, $value);
    public function getInfo(int $name);
    public function getError();
    public function execute(): string;
}

class Request implements HttpRequest
{
    private $handle = null;

    public function __construct()
    {
        $this->handle = curl_init();
    }
 
    public function setOption(int $name, $value): bool
    {
        return curl_setopt($this->handle, $name, $value);
    }

    public function getInfo(int $name): mixed 
    {
        return curl_getinfo($this->handle, $name);
    }

    public function getError(): string
    {
        return curl_error($this->handle);
    }

    public function execute(): string
    {
        return curl_exec($this->handle);
    }

    public function __destruct()
    {
        curl_close($this->handle);
    }
}

?>