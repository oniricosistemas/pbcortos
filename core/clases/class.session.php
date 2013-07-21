<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name class.session.php
 */
class Session {

    /**
     * Constructor de la clase
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name Session
     *
     */
    function Session() {
        session_start();
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
    function set($name, $value) {
        $_SESSION[$name] = $value;
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
    function get($name) {
        if (isset($_SESSION[$name]))
            return $_SESSION[$name];
        else
            return false;
    }

    /**
     * borra un valor
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
    function del($name) {
        unset($_SESSION[$name]);
    }

    /**
     * destruye todas las sessiones
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name destroy
     *
     * @param string $name
     *
     * Modificado:
     *
     */
    function destroy() {
        @session_start();
        $_SESSION = array();
        session_destroy();
    }
}
?>