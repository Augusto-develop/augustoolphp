<?php

namespace AugusToolPHP;

class DateTool
{
   /*
    * Valida data
    * $data: (dd/mm/YYYY) or (YYYY-mm-dd)
   */
   public static function validateFormatDate($date, $formatAmerica = true)
   {
      if(is_null($date) || $date === ""){
         return false;
      }
      if($formatAmerica){
         //formato americano
         preg_match_all("/([\d]{4}-[\d]{2}-[\d]{2})/", $date, $matches);
         $dateCheck = !empty($matches[0]) ? $date : "";
      }else{
         //formato brasileiro
         preg_match_all("/([\d]{2}\/[\d]{2}\/[\d]{4})/", $date, $matches);
         $dateCheck = !empty($matches[0]) ? DateTool::dateBrasilToAmerica($date) : "";
      }

      if($dateCheck !== ""){
         $explodeDate = explode('-', $dateCheck);
         //params: $mes, $dia, $ano
         return checkdate((int)$explodeDate['1'], (int)$explodeDate['2'], (int)$explodeDate[0]);
      }
      return false;
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
   public static function subtractDaysDate($dataAmerica, $qtdeDias, $format = 'Y-m-d')
   {
      return date($format, strtotime("-{$qtdeDias} days", strtotime($dataAmerica)));
   }

   /*
    * Soma meses a uma data
    */
   public static function sumMonthsDate($dataAmerica, $qtdeMeses, $format = 'Y-m-d')
   {
      return date($format, strtotime("+{$qtdeMeses} month", strtotime($dataAmerica)));
   }

   /*
    * Subrai meses de uma data
    */
   public static function subtractMonthsDate($dataAmerica, $qtdeMeses, $format = 'Y-m-d')
   {
      return date($format, strtotime("-{$qtdeMeses} month", strtotime($dataAmerica)));
   }

   /*
    * Subtrai horas da hora atual
    */
   public static function subtractHoursFromCurrentTime($qtdeHoras, $format = "")
   {
      $hora_calc = strtotime("-{$qtdeHoras} hour", DateTool::getCurrentMktime());
      if ($format) {
         return date($format, $hora_calc);
      }
      return $hora_calc;
   }

   /*
    * Converte data americana para brasileira
    */
   public static function dateAmericaToBrasil($dataAmericana)
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
   public static function dateBrasilToAmerica($dataBrasil)
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
      $mktime_datainicio = DateTool::retornaMktime($dataInicio);
      $mktime_datafim = DateTool::retornaMktime($dataFim);
      $diferenca_dias = floor(($mktime_datafim - $mktime_datainicio) / 86400);
      return $diferenca_dias;
   }

   /*
    * Checar data maior que outra
    */
   public static function checkGreaterDate($dataReferencia, $dataTeste)
   {
      $mktime_datainicio = DateTool::retornaMktime($dataReferencia);
      $mktime_datafim = DateTool::retornaMktime($dataTeste);
      return $mktime_datafim > $mktime_datainicio;
   }

   /*
    * Checar data esta dentro de um periodo
    */
   public static function checkDateWithinPeriod($dataInicio, $dataFim, $dataTeste)
   {
      $mktime_datainicio = DateTool::retornaMktime($dataInicio);
      $mktime_datafim = DateTool::retornaMktime($dataFim);
      $mktime_datateste = DateTool::retornaMktime($dataTeste);
      return $mktime_datateste >= $mktime_datainicio && $mktime_datateste <= $mktime_datafim;
   }

   /*
    * Converte data america para formato informado
    */
   public static function reformatToDate($dateAmerica, $format = 'Y-m-d')
   {
      return date($format, strtotime($dateAmerica));
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
      return $list_meses[StringTool::addZeroLeft($numeroMes, 2)];
   }

   /*
    * Retorno array com primeira data e ultima data
    */
   public static function getFirstLastDiaMes($mes, $ano){
      $firtDia = "{$ano}-{$mes}-01";
      return [$firtDia, date("Y-m-t", strtotime($firtDia))];
   }
}