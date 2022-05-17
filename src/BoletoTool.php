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
            return substr($nossoNumComp, 5, 13);

      }
   }

   public static function formatMoedaLinhaDigitavel($valor, $integers = 0, $decimals = 0){
      $strFormat = strpos($valor, ",") ? NumberTool::moedaToFloat($valor) : $valor;
      $strExplode = explode(".", $strFormat);
      if(empty($strExplode) || count($strExplode) > 2) return false;

      $strPart1 = $integers > 0 ? StringTool::addZeroLeft($strExplode['0'], $integers) : $strExplode['0'];
      $strPart2 = $decimals > 0 ? StringTool::addZeroRight($strExplode['1'], $decimals) : $strExplode['1'];

      return $strPart1.$strPart2;
   }
}