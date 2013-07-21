<?php

/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name PeliculasModel.php
 */
class Peliculas extends Modelo {

    protected $table = 'peliculas';

    /**
     * Lista todas las peliculas del sistema
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name listarNotcias
     *
     * @return string
     *
     * Modificaciones
     */
    public function listarPeliculas($where = array()) {
        $sql = "SELECT ediciones.titulo as edicion, peliculas.*
                    FROM peliculas
                    INNER JOIN ediciones
                    ON ediciones.id = peliculas.id_edicion
                    WHERE 1 ";
        if (!empty($where)) {
            $sql .= " AND";
            foreach ($where as $key => $value) {
                $sql .= " " . $key . " = '" . $value . "'";
            }
        }
        $sql .= " ORDER BY fecha DESC";
        return $sql;
    }

    /**
     * Devuelve todas las peliculas
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name borrarPelicula
     *
     * @return array
     *
     * Modificaciones
     */
    public function listadoPelicula($where = array()) {
        $sql = "SELECT peliculas.*,ediciones.titulo as edicion
                    FROM peliculas
                    INNER JOIN ediciones
                    ON ediciones.id = peliculas.id_edicion
                    WHERE 1 ";
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                $sql .= " AND " . $key . " = '" . $value . "'";
            }
        }
        $sql .= "ORDER BY fecha DESC";
        $consulta = $this->db->QueryArray($sql);
        if (!$consulta) {
            $consulta = $this->db->Error();
        }

        return $consulta;
    }

    /**
     * Busca una pelicula
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name buscarPelicula
     *
     * @package integer $id
     * @return array
     *
     * Modificaciones
     */
    public function buscarPelicula($id=null, $titulo=null) {
        $sql = "SELECT *
                    FROM peliculas
                    WHERE 1";
        if ($id) {
            $sql .= ' AND id = '.$id;
        }
        if($titulo){
            $sql .= " AND url_amigable = '".$titulo."'";
        }

        $consulta = $this->db->QueryArray($sql);
        if (!$consulta) {
            $consulta = $this->db->Error();
        }

        return $consulta;
    }

}