<?php

namespace Drom;

/*use Drom\Methods\GET;
use Drom\Methods\POST;
use Drom\Methods\PUT;*/

abstract class AbstractHttpMethod
{
   protected $client;

   public static function request($class)
   {
     // $class = __NAMESPACE__ . '\\'. $class;
      $class = 'Drom\Methods\\'. $class;
      return new $class();
   }

   public function setHeaders($array)
   {  
      $this->client->setOption(CURLOPT_HTTPHEADER, $array);
      return $this;
   }

   abstract public function setData($array);
   abstract public function run($url);
}

?>