<?php

namespace Drom\Methods;

class POST extends AbstractHttpMethod
{
   function __construct()
   {
	  $this->client = new Request();

     $this->client->setOption(CURLOPT_POST, true); 
     $this->client->setOption(CURLOPT_RETURNTRANSFER, true);
     $this->client->setOption(CURLOPT_SSL_VERIFYPEER, false);
     $this->client->setOption(CURLOPT_HEADER, false);
   }

   function setData(array $params)
   {  
      $this->client->setOption(CURLOPT_POSTFIELDS, http_build_query($params, '', '&')); 
      return $this;
   }

   function run(string $url)
   {  
      $this->client->setOption(CURLOPT_URL, $url); 
	   return $this->client->execute();
   }
}

?>