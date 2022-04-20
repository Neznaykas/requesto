<?php

namespace Drom\Methods;

use Drom\AbstractHttpMethod;

class PUT extends AbstractHttpMethod
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