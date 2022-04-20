<?php

namespace Drom\Methods;

interface HttpRequest
{
    public function setOption($name, $value);
    public function getInfo($name);
    public function getError();
    public function execute();
}

class Request implements HttpRequest
{
    private $handle = null;

    public function __construct($url = '')
    {
        $this->handle = curl_init($url);
    }
 
    public function setOption($name, $value)
    {
        return curl_setopt($this->handle, $name, $value);
    }

    public function getInfo($name) 
    {
        return curl_getinfo($this->handle, $name);
    }

    public function getError()
    {
        return curl_error($this->handle);
    }

    public function execute()
    {
        return curl_exec($this->handle);
    }

    public function __destruct(){
        curl_close($this->handle);
    }
}

?>