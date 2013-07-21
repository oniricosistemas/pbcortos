<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name: class.fechas.php
 *
 */

class Fechas {
    private static $instance=null;

    /**
     * Constructor de la clase
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name __contruct
     *
     */
    public function __construct() {
        $this->Config = Config::singleton();
    }

    /**
     * patron singleton
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name singleton
     *
     * @return $instance
     *
     * Modificado:
     *
     */
    public static function singleton() {
        if( self::$instance == null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * 
     * Sumarle o restarle días, meses o años a una fecha dada. Obtener la fecha resultado.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name operar
     *
     * Modificado:
     *
     * @param <string> $date
     * @param <string> $operacion
     * @param <string> $aoperar
     * @param <integer> $cantidad
     * @return <string>
     */
    public function operar($date, $operacion, $aoperar, $cantidad) {
        if(!($operacion == "-" || $operacion == "+"))
            $feedback .= "Date Class Error: Operaci&#243n no v&#225lida!!";
        else {
            // Separa dia, mes y año
            list($a_o, $mes, $dia) = explode("-",$date,3);

            // Determina la operación (Suma o resta)
            if($operacion == "-")
                $op = "-";
            else
                $op = '';

            // Determina en  donde será efectuada la operación (dia, mes, año)
            if($aoperar == "dia") $op_dia	 = $op."$cantidad";
            if($aoperar == "mes") $op_mes = $op."$cantidad";
            if($aoperar == "a_o") $op_a_o	 = $op."$cantidad";

            // Generamos la nueva fecha
            $date = mktime(0, 0, 0, $mes + $op_mes, $dia + $op_dia, $a_o + $op_a_o);

            return $date;
        }
    }


    /**
     * Convertir la fecha de formato (Y-m-d) a letras en formato (d de m de Y)
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name fechaAletras
     *
     * Modificado:
     *
     * @param <string> $fecha
     * @return <string>
     */
    public function fechaAletras($fecha) {
        list($anio,$mes,$dia) = explode("-",$fecha,3);
        $fechaletras = $dia." de ".$this->mesAletras($mes)." de ".$anio;
        return $fechaletras;
    }


    /**
     * Convertir de número a letras el mes.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name mesAletras
     *
     * Modificado:
     *
     * @param <string> $m
     * @return <string>
     */
    public function mesAletras($m) {
        if ($m == 1)
            $ms = 'Enero';
        else if ($m == 2)
            $ms = 'Febrero';
        else if ($m == 3)
            $ms = 'Marzo';
        else if ($m == 4)
            $ms = 'Abril';
        else if ($m == 5)
            $ms = 'Mayo';
        else if ($m == 6)
            $ms = 'Junio';
        else if ($m == 7)
            $ms = 'Julio';
        else if ($m == 8)
            $ms = 'Agosto';
        else if ($m == 9)
            $ms = 'Septiembre';
        else if ($m == 10)
            $ms = 'Octubre';
        else if ($m == 11)
            $ms = 'Noviembre';
        else if ($m == 12)
            $ms = 'Diciembre';

        return $ms;
    }

    /**
     * Devolver la fecha actual en el formato Y-m-d..
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name fechaAletras
     *
     * Modificado:
     *
     * @return <string>
     */
    public function fechAactual() {
        $today = getdate();
        $month = $today['mon'];
        $mday = $today['mday'];
        $year = $today['year'];
        $hoy = $year."-".$month."-".$mday;
        return $hoy;
    }


    /**
     * Devolver el día actual en número.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name dia
     *
     * Modificado:
     *
     * @param <string> $fecha
     * @return <string>
     */
    public function dia($fecha) {
        list($anio,$mes,$dia) = explode('-',$fecha,3);
        return $dia;
    }


    /**
     * Devolver el mes actual en número.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name mes
     *
     * Modificado:
     *
     * @param <string> $fecha
     * @return <string>
     */
    public function mes($fecha) {
        list($anio,$mes,$dia) = explode('-',$fecha,3);
        return $mes;
    }


    /**
     * Devolver el mes actual en número.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name anio
     *
     * Modificado:
     *
     * @param <string> $fecha
     * @return <type>
     */
    public function anio($fecha) {
        list($anio,$mes,$dia) = explode('-',$fecha,3);
        return $anio;
    }


    /**
     * Devolver el mes y año en el formato m Y.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name mesAnio
     *
     * Modificado:
     *
     * @param <string> $fecha
     * @return <string>
     */
    public function mesAnio($fecha) {
        list($anio,$mes,$dia) = explode("-",$fecha,3);
        $mesanio = $this->mesAletras($mes)." ".$anio;
        return $mesanio;
    }


    /**
     * Devolver el dia y mes en formato m d.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name diaMes
     *
     * Modificado:
     *
     * @param <string> $fecha
     * @return <string>
     */
    public function diaMes($fecha) {
        list($anio,$mes,$dia) = explode("-",$fecha,3);
        $diames = $this->mesAletras($mes)." ".$dia;
        return $diames;
    }


    /**
     * Devolver el de la semana correspondiente a la fecha.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name diaDeLaSemana
     *
     * Modificado:
     *
     * @param <string> $fecha
     * @return <string>
     */
    public function diaDeLaSemana($fecha) {
        list($y,$m,$d) = explode("-",$fecha,3);
        $timestamp = mktime(0,0,0,$m,$d,$y);
        $date = getdate ($timestamp);
        $dayofweek = $date['wday'];

        return $dayofweek;
    }


    /**
     * Convertir de número a letras el día
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name diaALetras
     *
     * Modificado:
     *
     * @param <integer> $d
     * @return <string>
     */
    public function diaALetras($d) {
        if ($d == 0)
            $ms = 'Domingo';
        else if ($d == 1)
            $ms = 'Lunes';
        else if ($d == 2)
            $ms = 'Martes';
        else if ($d == 3)
            $ms = 'Miercoles';
        else if ($d == 4)
            $ms = 'Jueves';
        else if ($d == 5)
            $ms = 'Viernes';
        else if ($d == 6)
            $ms = 'S&#225bado';

        return $ms;
    }


    /**
     * Convertir la fecha de formato DD-MM-YYYY a YYYY-MM-DD.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name machineDate
     *
     * Modificado:
     *
     * @param <string> $date
     * @return <string>
     */
    public function machineDate($date) {
        list($day, $month, $year) = split("-", $date);
        return $year . "-" . $month . "-" . $day;
    }


    /**
     * Convertir la fecha de formato YYYY-MM-DD a DD-MM-YYYY.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name humanDate
     *
     * Modificado:
     *
     * @param <string> $date
     * @return <string>
     */
    public function humanDate($date) {
        list($year, $month, $day) = split("-", $date);
        return $day . "-" . $month . "-" . $year;
    }

    /**
     * Convertir la fecha de formato MM-DD-YYYY a DD-MM-YYYY.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name localDate
     *
     * Modificado:
     *
     * @param <string> $date
     * @return <string>
     */
    public function localDate($date) {
        list($month, $day, $year) = split("-", $date);
        return $day . "-" . $month . "-" . $year;
    }


    /**
     * Convertir la fecha de formato DD-MM-YYYY a MM-DD-YYYY.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name foreingDate
     *
     * Modificado:
     *
     * @param <string> $date
     * @return <string>
     */
    public function foreignDate($date) {
        list($month, $day, $year) = split("-", $date);
        return $month . "-" . $day . "-" . $year;
    }


    /**
     * Convertir el timestamp a formato 'YYYY-MM-DD hh:mm:ss A'.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name convertTimestamp
     *
     * Modificado:
     *
     * @param <string> $timestamp
     * @return <string>
     */
    public function convertTimestamp($timestamp) {
        $year = substr($timestamp,0,4);
        $month = substr($timestamp,4,2);
        $day = substr($timestamp,6,2);
        $hour = substr($timestamp,8,2);
        $minute = substr($timestamp,10,2);
        $second = substr($timestamp,12,2);

        $date = mktime($hour, $minute, $second, $month, $day, $year);
        $date = date("Y-m-d h:i:s A", "$date");

        return $date;
    }


    /**
     * Compara la fechas de formato YYYY-MM-DD.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name compare
     *
     * Modificado:
     *
     * @param <string> $date
     * @param <string> $date2
     * @return <string>
     */
    public function compare($date,$date2) {
        list($y,$m,$d) = explode("-",$date,3);
        list($y2,$m2,$d2) = explode("-",$date2,3);

        if(strcmp($y,$y2) == 0) {
            if(strcmp($m,$m2) == 0) {
                if(strcmp($d,$d2) == 0) {
                    $comp = 0;
                }else
                    $comp = strcmp($d,$d2);
            }else
                $comp = strcmp($m,$m2);
        }else
            $comp = strcmp($y,$y2);
        return $comp;
    }


    /**
     * Devolver la diferencia de las dos fechas.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name diferencia
     *
     * Modificado:
     *
     * @param <string> $fecha
     * @param <string> $fecha2
     * @return <array>
     */
    public function diferencia($fecha,$fecha2) {

        list($year,$month,$day) = explode('-',$fecha,3);
        list($year2,$month2,$day2) = explode('-',$fecha2,3);

        $yearaux = $year - $year2;
        $monthaux = $month - $month2;
        $dayaux = $day2 - $day;

        $date = mktime(0, 0, 0, $monthaux, $dayaux, $yearaux);

        $diferencia = date("Y-m-d", "$date");

        list($year,$month,$day) = explode("-",$diferencia,3);
        $year -= 2000;
        if($year < 0) {
            $year = 0;
            $month = 0;
        }

        $diferenciaA['years'] = $year;
        $diferenciaA['months'] = $month;
        $diferenciaA['days'] = $day;

        return $diferenciaA;
    }
}

?>