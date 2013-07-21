<?php

/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name NoticiasModel.php
 */
class Noticias extends Modelo {

    protected $table = 'noticias';

    /**
     * Lista todas las noticias del sistema
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name listarNotcias
     *
     * @return string
     *
     * Modificaciones
     */
    public function listarNoticias($where = array()) {
        $sql = "SELECT ediciones.titulo as edicion, noticias.*
                    FROM noticias
                    INNER JOIN ediciones
                    ON ediciones.id = noticias.id_edicion
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
     * Devuelve todas las noticias
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name borrarNoticia
     *
     * @return array
     *
     * Modificaciones
     */
    public function listadoNoticia($where = array()) {
        $sql = "SELECT noticias.*,ediciones.titulo as edicion
                    FROM noticias
                    INNER JOIN ediciones
                    ON ediciones.id = noticias.id_edicion
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

    public function destacadas($edicion) {
        $sql = "SELECT noticias.*,ediciones.titulo as edicion
                    FROM noticias
                    INNER JOIN ediciones
                    ON ediciones.id = noticias.id_edicion
                    WHERE destacado = 1 ";
        $sql . " AND ediciones.id = $edicion";
        $sql .= "ORDER BY fecha DESC";
        $consulta = $this->db->QueryArray($sql);
        if (!$consulta) {
            $consulta = $this->db->Error();
        }
        return $consulta;
    }

    /**
     * Busca una noticia
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name buscarNoticia
     *
     * @package integer $id
     * @return array
     *
     * Modificaciones
     */
    public function buscarNoticia($id=null, $titulo=null) {
        $sql = "SELECT *
                    FROM noticias
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