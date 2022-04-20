<?php

namespace Drom\Methods;

use Drom\AbstractHttpMethod;

class GET extends AbstractHttpMethod
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

?>