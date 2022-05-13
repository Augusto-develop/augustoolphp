<?php


namespace AugusToolPHP;


class ArrayTool
{
   /*
    * Procura Item no array recursivamente e retorna sua chave
    */
   public static function arraySearchRecursive($needle, $haystack, $currentKey = '')
   {
      if (!empty($haystack)) {
         foreach ($haystack as $key => $value) {
            if (is_array($value)) {
               $nextKey = self::arraySearchRecursive($needle, $value, $currentKey !== "" ? $currentKey : $key);
               if ($nextKey !== "" && $nextKey !== false)//tratamento para zero
               {
                  return $nextKey;
               }
            } else if ($value === $needle) {
               return $currentKey !== "" ? $currentKey : $key;
            }
         }
      }

      return false;
   }
}