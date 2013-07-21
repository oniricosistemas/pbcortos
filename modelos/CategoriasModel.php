<?php

/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name CategoriasModel.php
 */
class Categorias extends Modelo {

    protected $table = 'categorias';

    /**
     * Lista todas las categorias del sistema
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name listarNotcias
     *
     * @return string
     *
     * Modificaciones
     */
    public function listarCategorias() {
        $sql = "SELECT *
                    FROM categorias
                    ORDER BY id DESC";

        return $sql;
    }


    /**
     * Devuelve todas las categorias
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name borrarCategorias
     *
     * @return array
     *
     * Modificaciones
     */
    public function listadoCategorias($where) {
        $sql = "SELECT *
                FROM categorias
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