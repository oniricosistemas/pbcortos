<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name: class.config.php
 *
 */

class Config {
    private $vars;
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
        $this->vars = array();
    }

    /**
     * setea un valor
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name set
     *
     * @param string $name
     * @param string $value
     *
     * Modificado:
     *
     */
    public function set($name, $value) {
        if(!isset($this->vars[$name])) {
            $this->vars[$name] = $value;
        }
    }

    /**
     * recupera un valor
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name get
     *
     * @param string $name
     * 
     * Modificado:
     *
     */
    public function get($name) {
        if(isset($this->vars[$name])) {
            return $this->vars[$name];
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