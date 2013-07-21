<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name /punk/core/clases/class.registry.php
 *
 */
class registry {

    /**
     * @access private
     * contiene todas las varaibles de registros
     * @var <array>
     */
    private $vars = array();

    /**
     * setea una variable de registro
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name __set
     *
     */
    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }

    /**
     * devuelve una variable de registro
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name __get
     *
     */
    public function __get($index) {
        return $this->vars[$index];
    }
}

?>