<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name CortosModel.php
     */


    class Cortos extends Modelo {
        protected $table = 'cortos';
	/**
	 * Lista todas los cortos del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarCortos($where = array()) {
	    $sql = "SELECT cortos.*, ediciones.titulo AS edicion, categorias.nombre AS categoria
                    FROM cortos
                    INNER JOIN ediciones
                    ON ediciones.id = cortos.id_edicion
                    INNER JOIN categorias
                    ON categorias.id = cortos.id_categorias
                    ";

	    return $sql;
	}

	/**
	 * Devuelve todas los cortos
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarCortos
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoCortos($where = array()) {
	    $sql = "SELECT cortos.*, ediciones.titulo AS edicion, categorias.nombre AS categoria
                    FROM cortos
                    INNER JOIN ediciones
                    ON ediciones.id = cortos.id_edicion
                    INNER JOIN categorias
                    ON categorias.id = cortos.id_categorias
                    WHERE 1 ";

            if(!empty($where)){
                foreach ($where as $key => $value) {
                    $sql .= " AND ".$key." = '".$value."'";
                }
            }
            $sql .= " ORDER BY categorias.id";
	    $consulta = $this->db->QueryArray($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }

	    return $consulta;
	}
    }