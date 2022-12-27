<?php

namespace Drom\Http;

//use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/*interface HInterface
{
   public function get(string $url): string;
   public function post(string $url): string;
   public function put(string $url): string;
   public function getStatusCode(): int;
}*/

class HttpMethod// implements HInterface
{
   protected Request $request;
   private $params;

   public function __construct()
   {
      $this->request = new Request();
      $this->request->setOption(CURLOPT_RETURNTRANSFER, true);
      $this->request->setOption(CURLOPT_SSL_VERIFYPEER, false);
      $this->request->setOption(CURLOPT_HEADER, false);
   }

   function setData(array $params)
   {
      $this->params = $params;
      return $this;
   }

   public function setHeaders(array $params)
   {
      $this->request->setOption(CURLOPT_HTTPHEADER, $params);
      return $this;
   }

   public function getStatusCode(): int
   {
      return $this->request->getInfo(CURLINFO_RESPONSE_CODE);
   }

   public function get(string $url): string
   {
      if ($this->params !== null)
         $this->params = http_build_query($this->params);

      $this->request->setOption(CURLOPT_URL, $url . '?' . $this->params);

      return $this->request->execute();
   }

   public function post(string $url): string
   {
      $this->params = http_build_query($this->params, '', '&');

      $this->request->setOption(CURLOPT_POST, true);
      $this->request->setOption(CURLOPT_POSTFIELDS, $this->params);
      $this->request->setOption(CURLOPT_URL, $url);

      return $this->request->execute();
   }

   public function put(string $url): string
   {
      $this->params = http_build_query($this->params);

      $this->request->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
      $this->request->setOption(CURLOPT_POSTFIELDS, $this->params);
      $this->request->setOption(CURLOPT_URL, $url);

      return $this->request->execute();
   }
}
