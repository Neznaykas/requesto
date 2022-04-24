<?php

namespace Drom\Methods;

class GET extends AbstractHttpMethod
{
   private string $params;

   function __construct()
   {
	  $this->client = new Request(); 

     $this->client->setOption(CURLOPT_RETURNTRANSFER, true);
     $this->client->setOption(CURLOPT_SSL_VERIFYPEER, false);
     $this->client->setOption(CURLOPT_HEADER, false);
   }

   function setData(array $params)
   {  
      $this->params = http_build_query($params);
      return $this;
   }

   function run(string $url)
   {  
      $this->client->setOption(CURLOPT_URL, $url . '?' . $this->params); 
	   return $this->client->execute();
   }
}

?>