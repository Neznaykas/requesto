<?php

namespace Drom\Methods;

abstract class AbstractHttpMethod
{
   protected $client;

   public static function request(string $method)
   {
     // $class = __NAMESPACE__ . '\\'. $class;

      $method = 'Drom\Methods\\'. $method;
      return new $method();
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

   abstract public function setData(array $data);
   abstract public function run(string $url);
}

?>