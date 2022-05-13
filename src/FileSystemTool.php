<?php


namespace AugusToolPHP;


class FileSystemTool
{
   /*
      * Apaga diretorio recursivamente
      */
   public static function delTree($dir)
   {
      if (is_dir($dir)) {
         $files = array_diff(scandir($dir), array('.', '..'));

         if (!empty($files)) {
            foreach ($files as $file) {
               is_dir("$dir/$file") ? FileSystemTool::delTree("$dir/$file") : unlink("$dir/$file");
            }
         }
         return rmdir($dir);
      }
   }

   /*
    * Cria diretorio recursivamente
    */
   public static function mkdirExecute($dirMain, $dirPasta)
   {
      $explode_dir = explode('/', $dirPasta);
      if (!empty($explode_dir)) {
         $caminho = $dirMain;
         foreach ($explode_dir as $item_dir) {
            $caminho .= $item_dir;
            if ($item_dir != "" && !is_dir($caminho)) {
               mkdir($caminho, 0755, true);
            }
            $caminho .= '/';
         }
      }
      return $dirMain . $dirPasta;
   }

   /*
    * Escrever no arquivo .ini
   */
   public static function writeIniFileString($file, $string)
   {
      // check first argument is string
      if (!is_string($file)) {
         throw new \InvalidArgumentException('Function argument 1 must be a string.');
      }

      // check second argument is array
      if (!is_string($string)) {
         throw new \InvalidArgumentException('Function argument 2 must be an array.');
      }

      // open file pointer, init flock options
      $fp = fopen($file, 'w');
      $retries = 0;
      $max_retries = 100;

      if (!$fp) {
         return false;
      }

      // loop until get lock, or reach max retries
      do {
         if ($retries > 0) {
            usleep(Rand(1, 5000));
         }
         $retries += 1;
      } while (!flock($fp, LOCK_EX) && $retries <= $max_retries);

      // couldn't get the lock
      if ($retries == $max_retries) {
         return false;
      }

      // got lock, write data
      fwrite($fp, $string);

      // release lock
      flock($fp, LOCK_UN);
      fclose($fp);

      return true;
   }
}