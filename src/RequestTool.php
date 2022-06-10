<?php


namespace AugusToolPHP;

use Exception;

class RequestTool
{
   /*
       * Requisicao via CURL
       */
   public static function curRequest($uri, $postEnv = [], $curlDebugCookie)
   {
      $ch = curl_init($uri);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      if($curlDebugCookie != ""){
         curl_setopt($ch, CURLOPT_COOKIE, $curlDebugCookie);
      }
      if(!empty($postEnv)){
         curl_setopt($ch, CURLOPT_POST, 0);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $postEnv);
      }
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
      $dadosRequest = curl_exec($ch);

//      curl_setopt($ch, CURLOPT_VERBOSE, true);
//      $verbose = fopen('php://temp', 'w+');
//      curl_setopt($ch, CURLOPT_STDERR, $verbose);
//      rewind($verbose);
//      $verboseLog = stream_get_contents($verbose);
//      echo $saveArquivos."Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
//      echo $saveArquivos;

      if ($dadosRequest === false) {
         throw new Exception(curl_error($ch), curl_errno($ch));
      }
      curl_close($ch);
      return json_decode($dadosRequest, true);
   }
}