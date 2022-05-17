<?php


namespace AugusToolPHP;


class NumberTool
{
   /*
       * Compara dois numeros float
       */
   public static function compareFloatNumbers($valor1, $valor2)
   {
      switch (bccomp($valor1, $valor2, 2)) {
         case -1:
            return 'MENOR';
         case 0:
            return 'IGUAL';
         case 1:
            return 'MAIOR';
      }
      return false;
   }

   /*
    * Converte moeda para valor float
    */
   public static function moedaToFloat($num)
   {
      if ($num != "" && strpos($num, ",")) {
         return str_replace([".", ","], ["", "."], $num);
      }
      return $num;
   }

   /*
    * Converte valor float em moeda
    */
   public static function floatToMoeda($recebe, $autonumeric = false, $simbolo = false, $isNullZero = true)
   {
      if ($recebe != "") {
         $volta = $simbolo ? "R$ " : "";
         if ($autonumeric) {
            @$volta .= number_format($recebe, 2, ',', '');
         } else {
            @$volta .= number_format($recebe, 2, ',', '.');
         }
      } else {
         $volta = $isNullZero ? "0,00" : "";
      }
      return $volta;
   }

   /*
    * Converte valor float em Aliquota
    */
   public static function floatToAliquota($recebe, $decimals = 3, $returnNull = true, $sinal = false)
   {
      if ($recebe != "") {
         @$volta = number_format($recebe, $decimals, ',', '.');
      } else {
         $volta = $returnNull ? "" : "0";
      }
      if ($volta != "" && $sinal) {
         $volta .= " %";
      }
      return $volta;
   }

   /*
    * format moeda/float sem pontucao
    */
   public static function formatMoedaNotPoint($valor, $integers = 0, $decimals = 0){
      $strFormat = strpos($valor, ",") ? NumberTool::moedaToFloat($valor) : $valor;
      $strExplode = explode(".", $strFormat);
      if(empty($strExplode) || count($strExplode) > 2) return false;

      $strPart1 = $integers > 0 ? StringTool::addZeroLeft($strExplode['0'], $integers) : $strExplode['0'];
      $strPart2 = $decimals > 0 ? StringTool::addZeroRight($strExplode['1'], $decimals) : $strExplode['1'];

      return $strPart1.$strPart2;
   }
}