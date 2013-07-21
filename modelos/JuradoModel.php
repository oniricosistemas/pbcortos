<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name JuradoModel.php
     */


    class Jurado extends Modelo {
        protected $table = 'jurado';
	/**
	 * Lista todas las jurado del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarJurado($where=array()) {
	    $sql = "SELECT jurado.*,ediciones.titulo AS edicion
                    FROM jurado
                    INNER JOIN ediciones
                    ON ediciones.id = jurado.id_edicion
                    WHERE 1 
                    ";
            if(!empty($where)){
                foreach ($where as $key => $value) {
                    $sql .= " AND ".$key." = '".$value."'";
                }
            }

	    return $sql;
	}


	/**
	 * Devuelve todas las jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarJurado
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoJurado($where = array()) {
	    $sql = "SELECT jurado.*,ediciones.titulo
                    FROM jurado
                    INNER JOIN ediciones
                    ON ediciones.id = jurado.id_edicion
                    WHERE 1 ";
            if(!empty($where)){
                foreach ($where as $key => $value) {
                    $sql .= " AND ".$key." = '".$value."'";
                }
            }
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }