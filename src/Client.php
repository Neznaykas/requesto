<?php

namespace Drom;

/*interface IClient
{
    public static function request($class);
    public function setHeaders($array);
    public function setData($array);
    public function run($url);
}*/

abstract class Client //implements IClient
{
   protected $client;

   public static function request($class)
   {
      $class = __NAMESPACE__ . '\\'. $class;
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

class GET extends Client
{
   private $params;

   function __construct()
   {
	  $this->client = new Request(); 

     $this->client->setOption(CURLOPT_RETURNTRANSFER, true);
     $this->client->setOption(CURLOPT_SSL_VERIFYPEER, false);
     $this->client->setOption(CURLOPT_HEADER, false);
   }

   function setData($array)
   {  
      $this->params = http_build_query($array);
      return $this;
   }

   function run($url)
   {  
      $this->client->setOption(CURLOPT_URL, $url . '?' . $this->params); 
	   return $this->client->execute();
   }
}

class POST extends Client
{
   function __construct()
   {
	  $this->client = new Request();

     $this->client->setOption(CURLOPT_POST, true); 
     $this->client->setOption(CURLOPT_RETURNTRANSFER, true);
     $this->client->setOption(CURLOPT_SSL_VERIFYPEER, false);
     $this->client->setOption(CURLOPT_HEADER, false);
   }

   function setData($array)
   {  
      $this->client->setOption(CURLOPT_POSTFIELDS, http_build_query($array, '', '&')); 
      return $this;
   }

   function run($url)
   {  
      $this->client->setOption(CURLOPT_URL, $url); 
	   return $this->client->execute();
   }
}

class PUT extends Client
{
   function __construct()
   {
	  $this->client = new Request();

     $this->client->setOption(CURLOPT_CUSTOMREQUEST, 'PUT'); 
     $this->client->setOption(CURLOPT_RETURNTRANSFER, true);
     $this->client->setOption(CURLOPT_SSL_VERIFYPEER, false);
     $this->client->setOption(CURLOPT_HEADER, false);
   }

   function setData($array)
   {  
      $this->client->setOption(CURLOPT_POSTFIELDS, http_build_query($array));
      return $this; 
   }

   function run($url)
   {  
      $this->client->setOption(CURLOPT_URL, $url); 
	   return $this->client->execute();
   }
}

?>