<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name: class.log.php
 *
 */

class Log {
    private $Config;
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
     * Lista todo los registros del log
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name listarLog
     *
     * @return string
     *
     * Modificado:
     *
     */
    public function listarLog() {
        $output = file_get_contents($this->Config->get('root').'/errores.log');
        $output = explode("\n", $output);

        //Ordenamos alreves
        if(is_array($output)) {
            rsort($output);
        }

        return $output;
    }

    /**
     * devuelve una linea especifica del log
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name verLog
     *
     * @return string
     *
     * Modificado:
     *
     */
    public function verLog($linea) {
        $fp = file($this->Config->get('root').'/errores.log');
        return $fp[$linea];

    }


    /**
     * vacia el archivo log
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name vaciarLog
     *
     * @return bollean
     *
     * Modificado:
     *
     */
    public function vaciarLog() {
        if(file_put_contents($this->Config->get('root').'/errores.log', '')) {
            return 0;
        }
        else {
            return 1;
        }

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
}

?>