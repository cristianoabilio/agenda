<?php
/**
 * @review
 */
namespace App\Helpers;

/**
 * Date helper
 *
 */
class Date
{

    /**
     *  Verifica se é uma data válida
     *
     *  @param $dateStr
     *  @param $format
     */
    public static function isDate($dateStr, $format = 'Y-m-d')
    {
        return \DateTime::createFromFormat($format, $dateStr) !== FALSE;
    }

    public static function diffDate($start, $end, $format = '%Y') {
        return date_diff(date_create(date($end)), date_create($start))->format($format);
    }

    /**
     * @param date $date 
     * @param string $time
     */
    public function dateToSql($date, $time = null, $formatOriginal = null) {
        if ($formatOriginal == 'pt') {
            $format = explode('/', $date);
            $date = $format[2].'-'.$format[1].'-'.$format[0];
        }
        if (empty($time)) {
            return date('Y-m-d', strtotime(str_ireplace('/', '-', $date)));
        } else {
            return date('Y-m-d H:i:s', strtotime($date.' '.$time));
        }
        
    }

    /**
     * This function receives two dates and returns 
     * the different between them in minutes
     * 
     * @param date $start
     * @param date $finish
     * @return int $duration
     */
    public function duration($start, $finish) {
        $start    = new \DateTime($start);
        $finish   = new \DateTime($finish);
        $diff     = $start->diff($finish);
        $diffHour = $diff->format('%H');
        $minutes = $diff->format('%i');
        $duration = $diffHour*60+$minutes;
        return $duration;
    }

    /**
     * 
     */
    public function time($hour = 0) {
        $times = [];

        for ($i = $hour; $i < 24; $i++) {
            $times[] = str_pad($i, 2, "0", STR_PAD_LEFT).':00';
            $times[] = str_pad($i, 2, "0", STR_PAD_LEFT).':30';
        }
        return $times;
    }
}