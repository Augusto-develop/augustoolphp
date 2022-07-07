<?php


namespace AugusToolPHP;


class BoletoTool
{
   public static function formatNossoNumero($banco, $nossoNumComp, $dvNossoNum, $layout, $carteiraGeracao)
   {
      $explodeBanco = explode("-", $banco);
      $codBanco = $explodeBanco[0];

      switch ($codBanco){
         case '104'://CAIXA
            if($layout == 'SIGCB240' || $layout == 'SIGCB400'){
               return substr($nossoNumComp, 1, 17) . '-' .$dvNossoNum;
            }else{
               return "";
            }
            break;
         case '341'://ITAU
            return $carteiraGeracao . "/" .substr($nossoNumComp, 10, 8) . '-' .$dvNossoNum;
         case '237'://BRADESCO
            return $carteiraGeracao . "/" . substr($nossoNumComp, 7, 11) . '-' .$dvNossoNum;
         case '001'://BANCO DO BRASIL
            return substr($nossoNumComp, 1, 17);
         case '033'://SANTANDER
            return substr($nossoNumComp, -12) . '-' . $dvNossoNum;
         case '136'://UNICRED
            return $carteiraGeracao . "/" . substr($nossoNumComp, 8, 10) . '-' . $dvNossoNum;
      }
   }
}