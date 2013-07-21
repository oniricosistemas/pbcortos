<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name ErroresSistemaModel.php
     */

    class ErroresSistema extends Modelo {
        protected $table = "core_errores";

	/**
	 * Lista todos los logs del sistema
	 *
	 * @return <array>
	 */
	public function listarErrores($data) {
	    $sql = "SELECT * FROM core_errores WHERE 1 ";
	    if(!empty($data['inicio']) && empty($data['fin'])) {
		$sql .= " AND DATE(fecha) ='{$data['inicio']}'";
	    }
	    if(!empty($data['fin']) && empty($data['inicio'])) {
		$sql .= " AND DATE(fecha) ='{$data['fin']}'";
	    }
	    if(!empty($data['fin']) && !empty($data['inicio'])) {
		$sql .= " AND fecha BETWEEN '{$data['inicio']}' AND '{$data['fin']}'";
	    }
	    if(!empty($data['codigo'])) {
		$sql .= " AND cod_error = '{$data['codigo']}'";
	    }

	    if(!empty($data['order'])) {
		switch ($data['order']) {
		    case 'codigo':
			$order = 'cod_error';
			break;

		    case 'id':
			$order = 'id';
			break;
		   
		    case 'fecha':
			$order = 'fecha';
			break;
		}
	    }
	    else {
		$order = ' fecha';
	    }
	    if(!empty($data['orden'])) {
		$por = " {$data['orden']}";
	    }
	    else {
		$por = ' DESC';
	    }
	    $sql .= ' ORDER BY '.$order.$por;

	    return $sql;
	}

	
	/**
	 * vacia la tabla core_errores
	 * @return <boolean>
	 */
	public function vaciarErrores() {
	    $sql = "TRUNCATE TABLE core_errores";
	    $consulta = $this->db->Query($sql);
	    if(!$consulta) {
		$consulta=$this->db->Error();
	    }

	    return $consulta;

        }
    }
?>