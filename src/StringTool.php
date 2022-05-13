<?php


namespace AugusToolPHP;


class StringTool
{
   /*
       * Adiciona zeros a esquerda de uma string
       */
   public static function addZeroLeft($valor, $tamanho)
   {
      return str_pad($valor, $tamanho, "0", STR_PAD_LEFT);
   }

   /*
    * Formata CPF/CNPJ
    * CPF: 999.999.999-99
    * CNPJ: 99.999.999/9999-99
    */
   public static function formatCPFCNPJ($cpfcnpj)
   {
      $numero = DateTool::retiraCaracEspec($cpfcnpj);
      switch (strlen($numero)) {
         case 14:
            return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $numero);
         case 11:
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $numero);
         default:
            return $cpfcnpj;
      }
   }

   /*
    * Formata numero do telefone
    */
   public static function formatFone($recebe)
   {
      if ($recebe != "") {
         if (strlen($recebe) == 10) {
            $volta = '(' . substr($recebe, 0, 2) . ') ' . substr($recebe, 2, 4) . '-' . substr($recebe, 6, 4);
         } else if (strlen($recebe) == 11) {
            $volta = '(' . substr($recebe, 0, 2) . ') ' . substr($recebe, 2, 5) . '-' . substr($recebe, 7, 4);
         } else {
            $volta = $recebe;
         }
      } else {
         $volta = $recebe;
      }
      return $volta;
   }

   /*
    * Formata numero do CEP
    * CEP: 99.999-999
    */
   public static function formatCEP($cep)
   {
      return preg_replace("/(\d{2})(\d{3})(\d{3})/", "\$1.\$2-\$3", $cep);
   }

   /*
    * Converte string para maiusculo
    */
   public static function textUpper($texto)
   {
      return mb_strtoupper($texto, 'UTF-8');
   }

   /*
    * Converte string para minusculo
    */
   public static function textLower($texto)
   {
      return mb_strtolower($texto, 'UTF-8');
   }
}