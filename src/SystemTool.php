<?php


namespace AugusToolPHP;


class SystemTool
{
   /*
       * Retorna nome do browser do usuario
       */
   public static function getBrowserUser()
   {
      $user_agent = $_SERVER['HTTP_USER_AGENT'];

      if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) {
         return 'OP';//OPERA
      } else if (strpos($user_agent, 'Edge')) {
         return 'EG';//Edge
      } else if (strpos($user_agent, 'Chrome')) {
         return 'CM';//chorme
      } else if (strpos($user_agent, 'Safari')) {
         return 'SF';//safari
      } else if (strpos($user_agent, 'Firefox')) {
         return 'FF';//firefox
      } else if (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) {
         return 'IE';//Internet Explorer
      } else {
         return 'OT';//outros
      }
   }

   /*
    * Retorna Ip do Usuario
    */
   public static function getIpUser()
   {
      $http_client_ip = $_SERVER['HTTP_CLIENT_IP'];
      $http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
      $remote_addr = $_SERVER['REMOTE_ADDR'];

      /* VERIFICO SE O IP REALMENTE EXISTE NA INTERNET */
      if (!empty($http_client_ip)) {
         $ip = $http_client_ip;
         /* VERIFICO SE O ACESSO PARTIU DE UM SERVIDOR PROXY */
      } elseif (!empty($http_x_forwarded_for)) {
         $ip = $http_x_forwarded_for;
      } else {
         /* CASO EU NÃO ENCONTRE NAS DUAS OUTRAS MANEIRAS, RECUPERO DA FORMA TRADICIONAL */
         $ip = $remote_addr;
      }

      return "{$ip}";
   }
}