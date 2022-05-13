<?php

namespace AugusToolPHP;

class UtilityDate
{
   /*
    * Calcula percentual de um valor
   */
   public static function percentQuestionXdeN($valor, $percentual)
   {
      return ((float)$valor / 100) * $percentual;
   }

   /*
    * Valida data no formato brasileiro
    * $data: (dd/mm/YYYY)
   */
   public static function validateFormatDateBrasil($data)
   {
      $ano = UtilPHP::addZeroLeft(substr($data, 6, 4), 4);
      $mes = UtilPHP::addZeroLeft(substr($data, 3, 2), 2);
      $dia = UtilPHP::addZeroLeft(substr($data, 0, 2), 2);
      return checkdate((int)$mes, (int)$dia, (int)$ano);
   }

   /*
    * Valida data no formato americano
    * $data: (YYYY-mm-dd)
   */
   public static function validateFormatDateAmerica($data)
   {
      $ano = UtilPHP::addZeroLeft(substr($data, 0, 4), 4);
      $mes = UtilPHP::addZeroLeft(substr($data, 5, 2), 2);
      $dia = UtilPHP::addZeroLeft(substr($data, 8, 2), 2);
      return checkdate((int)$mes, (int)$dia, (int)$ano);
   }

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

   /*
    * Adiciona zeros a esquerda de uma string
    */
   public static function addZeroLeft($valor, $tamanho)
   {
      return str_pad($valor, $tamanho, "0", STR_PAD_LEFT);
   }

   /*
    * Soma dias a uma data
    */
   public static function sumDaysDate($dataAmerica, $qtdeDias, $format = 'Y-m-d')
   {
      return date($format, strtotime("+{$qtdeDias} days", strtotime($dataAmerica)));
   }

   /*
    * Subtrai dias de uma data
    */
   public static function subtractDaysDate($dataAmerica, $qtdeDias)
   {
      return date('Y-m-d', strtotime("-{$qtdeDias} days", strtotime($dataAmerica)));
   }

   /*
    * Soma meses a uma data
    */
   public static function sumMonthsDate($dataAmerica, $qtdeMeses)
   {
      return date('Y-m-d', strtotime("+{$qtdeMeses} month", strtotime($dataAmerica)));
   }

   /*
    * Subrai meses de uma data
    */
   public static function subtractMonthsDate($dataAmerica, $qtdeMeses)
   {
      return date('Y-m-d', strtotime("-{$qtdeMeses} month", strtotime($dataAmerica)));
   }

   /*
    * Subtrai horas da hora atual
    */
   public static function subtractHoursFromCurrentTime($qtdeHoras, $format = "")
   {
      $hora_calc = strtotime("-{$qtdeHoras} hour", UtilPHP::getCurrentMktime());
      if ($format) {
         return date($format, $hora_calc);
      }
      return $hora_calc;
   }

   /*
    * Converte data americana para brasileira
    */
   public static function convertDateAmericaToBrasil($dataAmericana)
   {
      preg_match_all("/([\d]{2}\/[\d]{2}\/[\d]{4})/", $dataAmericana, $matches);
      if (empty($matches[0]) && $dataAmericana != "") {
         $dtbra = date('d/m/Y', strtotime($dataAmericana));
         return $dtbra;
      }
      return $dataAmericana;
   }

   /*
    * Converte data brasileira para americana
    */
   public static function convertDateBrasilToAmerica($dataBrasil)
   {
      preg_match_all("/([\d]{4}-[\d]{2}-[\d]{2})/", $dataBrasil, $matches);

      if (empty($matches[0]) && $dataBrasil != "") {
         $dtamer = substr($dataBrasil, 6, 4);
         $dtamer .= "-";
         $dtamer .= substr($dataBrasil, 3, 2);
         $dtamer .= "-";
         $dtamer .= substr($dataBrasil, 0, 2);
         return $dtamer;
      }
      return $dataBrasil;
   }

   /*
    * Formata data por extenso
    * Data atual caso data nao informada
    */
   public static function dateToInFull($dataAmericana = "", $horaSaudacao = false,
                                       $descricaoSemana = true, $sufixoFeira = false)
   {
      if ($dataAmericana != "") {
         $timeData = strtotime($dataAmericana);
         $dia = (int)date('d', $timeData);
         $mes = (int)date('m', $timeData) - 1;
         $ano = date('Y', $timeData);
         $semana = (int)date('w', $timeData);
      } else {
         $dia = (int)date('d');
         $mes = (int)date('m') - 1;
         $ano = date('Y');
         $semana = (int)date('w');
      }

      $vdescricaoSemana = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira",
         "Quinta-Feira", "Sexta-Feira", "Sábado"];
      $vdescricaoMes = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
         "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

      $data_extenso = "";
      if ($descricaoSemana) {
         $data_extenso = $sufixoFeira ? "{$vdescricaoSemana[$semana]}" : str_replace('-Feira', "", "{$vdescricaoSemana[$semana]}");
         $data_extenso .= ", ";
      }

      $data_extenso .= "{$dia} de {$vdescricaoMes[$mes]} de {$ano}";

      if ($horaSaudacao) {
         $textoSaudacao = "";
         $horaAtual = $horaSaudacao;
         if (($horaAtual > 5) && ($horaAtual < 12)) {
            $textoSaudacao = "Bom Dia!";
         } else
            if (($horaAtual > 11) && ($horaAtual < 18)) {
               $textoSaudacao = "Boa Tarde!";
            } else
               if (($horaAtual > 17) && ($horaAtual < 24)) {
                  $textoSaudacao = "Boa Noite!";
               } else
                  if (($horaAtual > -1) && ($horaAtual < 6)) {
                     $textoSaudacao = "Boa Madrugada!";
                  }

         $data_extenso .= ", {$textoSaudacao}";
      }

      return $data_extenso;
   }

   /*
    * Calcula diferença de dias entre datas
    */
   public static function differenceBetweenDates($dataInicio, $dataFim)
   {
      $mktime_datainicio = UtilPHP::retornaMktime($dataInicio);
      $mktime_datafim = UtilPHP::retornaMktime($dataFim);
      $diferenca_dias = floor(($mktime_datafim - $mktime_datainicio) / 86400);
      return $diferenca_dias;
   }

   /*
    * Checar data maior que outra
    */
   public static function checkGreaterDate($dataReferencia, $dataTeste)
   {
      $mktime_datainicio = UtilPHP::retornaMktime($dataReferencia);
      $mktime_datafim = UtilPHP::retornaMktime($dataTeste);
      return $mktime_datafim > $mktime_datainicio;
   }

   /*
    * Checar data esta dentro de um periodo
    */
   public static function checkDateWithinPeriod($dataInicio, $dataFim, $dataTeste)
   {
      $mktime_datainicio = UtilPHP::retornaMktime($dataInicio);
      $mktime_datafim = UtilPHP::retornaMktime($dataFim);
      $mktime_datateste = UtilPHP::retornaMktime($dataTeste);
      return $mktime_datateste >= $mktime_datainicio && $mktime_datateste <= $mktime_datafim;
   }

   /*
    * Converte timestamp para data
    */
   public static function timestampToDate($timestamp, $format = 'Y-m-d')
   {
      return date($format, strtotime($timestamp));
   }

   /*
    * Retorna mktime atual
    */
   public static function getCurrentTimestamp()
   {
      return mktime(date('H'), date('i'), date('s'),
         date('m'), date('d'), date('Y'));
   }

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

   /*
    * Formata CPF/CNPJ
    * CPF: 999.999.999-99
    * CNPJ: 99.999.999/9999-99
    */
   public static function formatCPFCNPJ($cpfcnpj)
   {
      $numero = UtilPHP::retiraCaracEspec($cpfcnpj);
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

   /*
    * Retorna ArrayList Meses (pt)
    */
   public static function getMontshName($numeroMes)
   {
      $list_meses = [
         '01' => 'Janeiro',
         '02' => 'Fevereiro',
         '03' => 'Março',
         '04' => 'Abril',
         '05' => 'Maio',
         '06' => 'Junho',
         '07' => 'Julho',
         '08' => 'Agosto',
         '09' => 'Setembro',
         '10' => 'Outubro',
         '11' => 'Novembro',
         '12' => 'Dezembro'
      ];
      return $list_meses[UtilPHP::addZeroLeft($numeroMes, 2)];
   }

   /*
    * Retorna ArrayList UF Brasil
    */
   public static function getUFsBrasil()
   {
      return explode(';',
         "AC;AL;AP;AM;BA;CE;DF;ES;GO;MA;MT;MS;MG;PA;PB;PR;PE;PI;RJ;RN;RS;RO;RR;SC;SP;SE;TO");
   }

   /*
    * Retorna tempo aproximado entre datas ou a partir da data atual
    */
   public static function relativeTimeString($dataInicio, $datafinal = "")
   {
      $minute = 60;
      $hour = $minute * 60;
      $day = $hour * 24;
      $month = 30 * $day;
      $year = 12 * $month;

      $dataReferencia = $datafinal != "" ? strtotime($datafinal) : time();
      $prefixo = $datafinal != "" ? 'A' : "Há a";

      $delta = floor($dataReferencia - strtotime($dataInicio));
      if ($delta < 2) return 'Agorinha';
      if ($delta < 1 * $minute) return "Há $delta segundos";
      if ($delta < 2 * $minute) return 'Há um minuto';
      if ($delta < 45 * $minute) return $prefixo . 'proximadamente ' . round($delta / $minute) . ' minutos';
      if ($delta < 90 * $minute) return $prefixo . 'proximadamente uma hora';
      if ($delta < 23 * $hour) return $prefixo . 'proximadamente ' . round($delta / $hour) . ' horas';
      if ($delta < 48 * $hour) return $prefixo . 'proximadamente 1 dia';
      if ($delta < 30 * $day) return $prefixo . 'proximadamente ' . round($delta / $day) . ' dias';
      if ($delta < 45 * $day) return $prefixo . 'proximadamente um mês';
      if ($delta < 11 * $month) return $prefixo . 'proximadamente ' . round($delta / $month) . ' meses';
      if ($delta < 18 * $month) return $prefixo . 'proximadamente um ano';
      return $prefixo . round($delta / $year) . ' anos';
   }

   /*
    * Procura Item no array recursivamente e retorna sua chave
    */
   public static function arraySearchRecursive($needle, $haystack, $currentKey = '')
   {
      if (!empty($haystack)) {
         foreach ($haystack as $key => $value) {
            if (is_array($value)) {
               $nextKey = UtilPHP::array_search_recursive($needle, $value, $currentKey !== "" ? $currentKey : $key);
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


   /*
    * Mostra numero float por extenso
    */
   public static function formatValorExtenso($valor)
   {
      $maiusculas = false;
      $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
      $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
         "quatrilhões");

      $c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
         "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
      $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
         "sessenta", "setenta", "oitenta", "noventa");
      $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
         "dezesseis", "dezesete", "dezoito", "dezenove");
      $u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
         "sete", "oito", "nove");

      $z = 0;
      $rt = "";

      $valor = number_format($valor, 2, ".", ".");
      $inteiro = explode(".", $valor);
      for ($i = 0; $i < count($inteiro); $i++)
         for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
            $inteiro[$i] = "0" . $inteiro[$i];

      $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
      for ($i = 0; $i < count($inteiro); $i++) {
         $valor = $inteiro[$i];
         $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
         $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
         $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

         $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
               $ru) ? " e " : "") . $ru;
         $t = count($inteiro) - 1 - $i;
         $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
         if ($valor == "000") $z++; elseif ($z > 0) $z--;
         if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) $r .= (($z > 1) ? " de " : "") . $plural[$t];
         if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
               ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
      }

      if (!$maiusculas) {
         $texto = ucwords(($rt ? $rt : "zero"));
         $pregreplace = str_replace(" E ", " e ", $texto);
         return $pregreplace != null ? $pregreplace : $texto;
      } else {
         if ($rt) {
            $texto = ucwords($rt);
            str_replace(" E ", " e ", $texto);
            $rt = $texto;
         }
         $texto = ucwords((($rt) ? ($rt) : "Zero"));
         $pregreplace = str_replace(" E ", " e ", $texto);
         return $pregreplace != null ? $pregreplace : $texto;
      }
   }

   /*
    * Apaga diretorio recursivamente
    */
   public static function delTree($dir)
   {
      if (is_dir($dir)) {
         $files = array_diff(scandir($dir), array('.', '..'));

         if (!empty($files)) {
            foreach ($files as $file) {
               is_dir("$dir/$file") ? delTree("$dir/$file") : unlink("$dir/$file");
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

   /*
    * Requisicao via CURL
    */
   public static function curRequest($uri, $postEnv = [])
   {
      $ch = curl_init($uri);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_COOKIE, CURL_DEBUG_COOKIE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postEnv);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
      $dadosRequest = curl_exec($ch);

//      curl_setopt($ch, CURLOPT_VERBOSE, true);
//      $verbose = fopen('php://temp', 'w+');
//      curl_setopt($ch, CURLOPT_STDERR, $verbose);
//      rewind($verbose);
//      $verboseLog = stream_get_contents($verbose);
//      echo $saveArquivos."Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
//      echo $saveArquivos;

      if ($dadosRequest === false) {
         throw new Exception(curl_error($ch), curl_errno($ch));
      }
      curl_close($ch);
      return json_decode($dadosRequest, true);
   }
}