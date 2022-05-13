<?php


namespace AugusToolPHP;


class EnderecoTool
{
   /*
       * Retorna ArrayList UF Brasil
       */
   public static function getUFsBrasil()
   {
      return explode(';',
         "AC;AL;AP;AM;BA;CE;DF;ES;GO;MA;MT;MS;MG;PA;PB;PR;PE;PI;RJ;RN;RS;RO;RR;SC;SP;SE;TO");
   }
}