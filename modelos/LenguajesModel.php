<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name LenguajesModel.php
 */

class Lenguajes extends Modelo {
    protected $table = 'core_lenguajes';
    /**
     * Devuelve todos los lenguajes del sistema
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @namelistarLenguajes
     *
     * @return string
     *
     * Modificaciones
     */
    public function listarLenguajes() {
        $sql="SELECT * FROM core_lenguajes";

        return $sql;
    }

}