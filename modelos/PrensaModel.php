<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name PrensaModel.php
     */


    class Prensa extends Modelo {
        protected $table = 'prensa';
	/**
	 * Lista todas los prensa del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarPrensa($where = array()) {
	    $sql = "SELECT *
                    FROM prensa
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
	 * Devuelve todas los prensa
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarPrensa
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoPrensa($where = array()) {
	    $sql = "SELECT *
                    FROM prensa
                    WHERE 1
                    ";
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