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
      if ($num != "") {
         $valor = str_replace(".", "", $num);
         $valorc = str_replace(",", ".", $valor);
      } else {
         $valorc = "";
      }
      return $valorc;
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
}