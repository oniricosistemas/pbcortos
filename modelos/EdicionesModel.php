<?php

/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name EdicionesModel.php
 */
class Ediciones extends Modelo {

    protected $table = 'ediciones';

    /**
     * Lista todas las ediciones del sistema
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name listarNotcias
     *
     * @return string
     *
     * Modificaciones
     */
    public function listarEdiciones() {
        $sql = "SELECT *
                    FROM ediciones
                    ORDER BY id DESC";

        return $sql;
    }


    /**
     * Devuelve todas las ediciones
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name borrarEdiciones
     *
     * @return array
     *
     * Modificaciones
     */
    public function listadoEdiciones($where) {
        $sql = "SELECT *
                FROM ediciones
                WHERE 1 ";
        if(!empty($where)){
                foreach ($where as $key => $value) {
                    $sql .= " AND ".$key.$value;
                }
            }
        $consulta = $this->db->QueryArray($sql);
        if (!$consulta) {
            $consulta = $this->db->Error();
        }

        return $consulta;
    }

}