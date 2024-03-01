<?php


namespace AugusToolPHP;


class StringTool
{
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

   /*
       * Adiciona zeros a esquerda de uma string
       */
   public static function addZeroLeft($valor, $tamanho)
   {
      return str_pad($valor, $tamanho, "0", STR_PAD_LEFT);
   }

   /*
       * Adiciona zeros a direira de uma string
       */
   public static function addZeroRight($valor, $tamanho)
   {
      return str_pad($valor, $tamanho, "0", STR_PAD_RIGHT);
   }

   /*
    * Remove characteres especiais
    */
   public static function removeCharSpecial($valor)
   {
      return str_replace([".", "/", "-", "(", ")", " ", "[", "]", "_", "'"], "", trim($valor));
   }

   /*
   * Remove quebra de linha
   */
   public static function removeBreakLine($texto)
   {
      return preg_replace("/\r|\n/", " ", $texto);
   }

   /*
    * Remove characteres especiais de moeda
    */
   public static function removeCharSpecialMaskMoeda($valor)
   {
      return str_replace(["R$", "%", "$", " "], "", trim($valor));
   }


   public static function retiraCaracEspec($valor, $removeEspaco = true)
   {
      $chars = array(".", "/", "-", "(", ")", "[", "]", "_", "'", "%");
      if ($removeEspaco) {
         $chars[] = " ";
      }
      return str_replace($chars, "", trim($valor));
   }

   /*
    * Formata CPF/CNPJ
    * CPF: 999.999.999-99
    * CNPJ: 99.999.999/9999-99
    */
   public static function formatCPFCNPJ($cpfcnpj, $suppression = false)
   {
      $numero = StringTool::retiraCaracEspec($cpfcnpj);
      switch (strlen($numero)) {
         case 14:
            $replacement = "\$1.\$2.\$3/\$4-\$5";
            if ($suppression) {
               $replacement = "\$1.***.***/\$4-\$5";
            }
            return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", $replacement, $numero);
         case 11:
            $replacement = "\$1.\$2.\$3-\$4";
            if ($suppression) {
               $replacement = "\$1.***.***-\$4";
            }
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", $replacement, $numero);
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

   public static function removeAccents($string)
   {
      //return preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string ) );
      $str = $string;
      $str = preg_replace('/[áàãâä]/ui', 'a', $str);
      $str = preg_replace('/[éèêë]/ui', 'e', $str);
      $str = preg_replace('/[íìîï]/ui', 'i', $str);
      $str = preg_replace('/[óòõôö]/ui', 'o', $str);
      $str = preg_replace('/[úùûü]/ui', 'u', $str);
      $str = preg_replace('/[ç]/ui', 'c', $str);
      $str = preg_replace('/[ºª]/ui', '', $str);
      $str = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , $str);
      //$str = preg_replace('/[^a-z0-9]/i', '_', $str);
      //$str = preg_replace('/_+/', '_', $str);
      return $str;
   }
}