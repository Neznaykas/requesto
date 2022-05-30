<?php

namespace Drom\Http;

interface HInterface
{
   public function get(string $url): string;
   public function post(string $url): string;
   public function put(string $url): string;
   public function getStatusCode(): int;
}

class HttpMethod implements HInterface
{
   protected $request;
   private $params;

   public function __construct()
   {
      $this->client = new Request();
      $this->client->setOption(CURLOPT_RETURNTRANSFER, true);
      $this->client->setOption(CURLOPT_SSL_VERIFYPEER, false);
      $this->client->setOption(CURLOPT_HEADER, false);

      return $this;
   }

   function setData(array $params)
   {
      $this->params = $params;
      return $this;
   }

   public function setHeaders(array $params)
   {
      $this->client->setOption(CURLOPT_HTTPHEADER, $params);
      return $this;
   }

   public function getStatusCode(): int
   {
      return $this->client->getInfo(CURLINFO_RESPONSE_CODE);
   }

   public function get(string $url): string
   {
      if ($this->params !== null)
         $this->params = http_build_query($this->params);

      $this->client->setOption(CURLOPT_URL, $url . '?' . $this->params);

      return $this->client->execute();
   }

   public function post(string $url): string
   {
      $this->params = http_build_query($this->params, '', '&');

      $this->client->setOption(CURLOPT_POST, true);
      $this->client->setOption(CURLOPT_POSTFIELDS, $this->params);
      $this->client->setOption(CURLOPT_URL, $url);

      return $this->client->execute();
   }

   public function put(string $url): string
   {
      $this->params = http_build_query($this->params);

      $this->client->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
      $this->client->setOption(CURLOPT_POSTFIELDS, $this->params);
      $this->client->setOption(CURLOPT_URL, $url);

      return $this->client->execute();
   }
}
