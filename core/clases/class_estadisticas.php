<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name class_estadisticas.php
 */

class Estadisticas {
    static private $start_microtime = array();
    static private $end_microtime = array();
    static private $duration = array();
    static private $counts = array();


    /**
     * Metodo utilizado para calcular la duracion de un proceso.
     * Una vez comenzada la cronometrizacion, se debe utilizar Estadisticas::finalizarConteo($name) para
     * terminar la medicion y obtener el resultado.
     * Se pueden llevar multiples mediciones en paralelo.
     * @param string $name Nombre representativo del proceso
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name empezarConteo
     *
     * @example
     * $d = Estadisticas::empezarConteo('proceso');
     *
     * Modificado:
     *
     */
    public function empezarConteo($name) {
        self::$start_microtime[$name] = microtime(true);
    }

    /**
     * Metodo utilizado para registrar el momento actual en que termino un proceso, hacer el calculo
     * para obtener la duracion (contra t inicial) y devolver dicho valor en segundos.
     * @param string $name Nombre del proceso cronometrado (se setea en startCount)
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name finalizarConteo
     *
     * @example
     * $d = Estadisticas::finalizarConteo('proceso');
     * echo "Duracion del proceso: $d segundos";
     *
     * Modificado:
     *
     */
    public function finalizarConteo($name) {
        echo "nom: ".$name."<br/>";
        echo "<pre>";
        print_r( self::$start_microtime );
        echo"</pre>";

        if (isset(self::$start_microtime[$name])) {
            self::$end_microtime[$name] = microtime(true);
        }


        return self::verDuracion($name);
    }

    /**
     * Obtiene y devuelve la duracion de un proceso que se dio por terminado.
     * Si no existe devuelve false. Este metodo se utiliza cuando se realizo un
     * Estadisiticas::finishCount y no se utilizo en el momento la duracion devuelta, y mas adelante
     * se quiere rescatar nuevamente esa informacion
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name verDuracion
     *
     * @param string $name
     * @return float
     *
     * Modificado:
     */
    public function verDuracion($name = null) {
        $rsp = false;
        if ($name) {
            if (isset(self::$end_microtime[$name])) {
                self::$duration[$name] = self::$end_microtime[$name] - self::$start_microtime[$name];
                $rsp =  self::$duration[$name];
            }
        } else {
            $s =  self::$start_microtime;
            foreach ($s as $name => $start) {
                if (isset(self::$end_microtime[$name])) {
                    self::$duration[$name] = self::$end_microtime[$name] - self::$start_microtime[$name];
                }
            }
            $rsp = self::$duration[$name];
        }
        return $rsp;
    }

    /**
     * Incrementa en uno la variable de conteo pasada como parametro
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name inc
     *
     * @param string $name
     * @return float
     *
     * Modificado:
     */
    public function inc($name) {
        if (isset(self::$counts[$name])) {
            ++self::$counts[$name];
        } else {
            self::$counts[$name] = 1;
        }
    }

    /**
     * Decrementa en uno la variable de conteo pasada como parametro
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name dec
     *
     * @param string $name
     * @return float
     *
     * Modificado:
     */
    public function dec($name) {
        if (isset(self::$counts[$name])) {
            --self::$counts[$name];
        }
    }

    /**
     * Obtiene y devuelve el conteo de una variable.
     * Si no existe devuelve false.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name verConteo
     *
     * @param string $name
     * @return integer
     *
     * Modificado:
     */
    public function verConteo($name = null) {
        $rsp = false;
        if ($name) {
            if (isset(self::$counts[$name])) {
                $rsp =  self::$counts[$name];
            } elseif (!is_array(self::$counts)) {
                $rsp =  self::$counts;
            }
            return $rsp;
        }
    }

    /**
     * Se encarga de hacer un log con las estadisticas y parametros de cada peticion realizada.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name logEstadisticas
     *
     * Modificado:
     */
    public function logEstadisticas() {
        $data .= "Fecha: ".date('Y:m:d')."\n";
        $data .= "Hora: ".date('H:m:s')."\n";
        echo "star<pre>";
        print_r( self::$start_microtime );
        echo"</pre>";
        echo "end<pre>";
        print_r( self::$end_microtime );
        echo"</pre>";
        echo "duracion<pre>";
        print_r( self::$duration );
        echo"</pre>";
        $items = array_keys(self::$start_microtime);
        for($i=0;$i<count($items);$i++) {
            $data .= "Proceso: ".$items[$i]."\n";
            $data .= 'Duracion: '.Estadisticas::verDuracion();
            $data .= "\n";
            $data .= "Memoria usada: ".memory_get_usage()."\n";
            $data .= "Memoria Real: ".memory_get_usage(true)."\n";
            $data .= "Memoria Peak usada: ".memory_get_peak_usage()."\n";
            $data .= "Url: ".$_SERVER['QUERY_STRING']."\n";
            $data .= "Controlador: ".$controller."\n";
            $data .= "Accion: ".$action."\n";
            $data .= "\n";
            //$data = implode(array($day,$time,$mod,$act,$dur,$mem,$real_mem,$peak_mem,$url,"\n"),',');
            $config = Config::singleton();
            error_log($data, 3,$config->get('root').'/estadisticas.log');
        }
    }

    /**
     * Se encarga de hacer un log detallado con las estadisticas y parametros de cada peticion realizada.
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name logDetallesEstadisticas
     *
     * Modificado:
     */
    public function logDetallesEstadisticas() {
        $day = date('Y:m:d');
        $time = date('H:m:s');
        $url = $_SERVER['QUERY_STRING'];
        $data = implode(array($day,$time,$url),',');
        $arr = Estadisticas::verDuracion();
        asort($arr);
        foreach ($arr as $k=>$a)
            $data .= ',"'.$k.'",'.'"'.$a;
        $data.="\n";
        $config = Config::singleton();
        error_log($data, 3,$config->get('root').'/detalles_estadisticas.log');
    }
}
?>
