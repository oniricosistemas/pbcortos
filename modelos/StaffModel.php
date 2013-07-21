<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name StaffModel.php
     */


    class Staff extends Modelo {
        protected $table = 'staff';
	/**
	 * Lista todas las staff del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarStaff() {
	    $sql = "SELECT staff.*, ediciones.titulo AS edicion
                    FROM staff
                    INNER JOIN ediciones
                    ON ediciones.id = staff.id_edicion
                    ";

	    return $sql;
	}

	/**
	 * Busca una staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarStaff
	 *
	 * @package integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarStaff($id,$edicion='') {
	    $sql = "SELECT staff.*, ediciones.titulo AS edicion
                    FROM staff
                    INNER JOIN ediciones
                    ON ediciones.id = staff.id_edicion
                    WHERE
                    id='$id' ";
            if($edicion){
                $sql .= " AND id_edicion = '$edicion' ";
            }

	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}

	


	/**
	 * Devuelve todas las staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarStaff
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoStaff($edicion='') {
	    $sql = "SELECT staff.*, ediciones.titulo AS edicion
                    FROM staff
                    INNER JOIN ediciones
                    ON ediciones.id = staff.id_edicion
                    WHERE 1 ";
            if($edicion){
                $sql .= " AND id_edicion = '$edicion' ";
            }
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }