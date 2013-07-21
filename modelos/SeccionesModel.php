<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * 
     * @name SeccionesModel.php
     */

    class Secciones extends Modelo {
        protected $table = 'secciones';
	/**
	 * Devuelve el listado de secciones
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarSecciones
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarSecciones() {
	    $sql = "SELECT secciones.*, ediciones.titulo AS edicion
                  FROM secciones
                  INNER JOIN ediciones
                  ON ediciones.id = secciones.id_edicion
                  WHERE 1 ";
            $sql .= " order by id ASC";

	    return $sql;
	}

	/**
	 * devuelve una seccion
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name buscarSeccion
	 *
	 * @param integer $id
	 * @return array
	 *
	 * Modificaciones
	 */
	public function buscarSeccion($id) {
	    $sql="SELECT * FROM secciones WHERE id='$id'";
	    $consulta = $this->db->QueryArray($sql);

	    return $consulta;
	}

	/**
	 * busca una seccion segun el titulo
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name datosSeccion
	 *
	 * @param string $nombre
	 * @return array
	 *
	 * Modificaciones
	 */
	public function datosSeccion($nombre,$edicion = '') {
	    $sql="SELECT *
                  FROM secciones
                  WHERE titulo like '%$nombre%'";
            if($edicion != ''){
                $sql .= " AND id_edicion = '$edicion'";
            }
	    $consulta = $this->db->QuerySingleRow($sql);

	    return $consulta;
	}
    }