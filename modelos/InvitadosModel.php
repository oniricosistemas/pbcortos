<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name InvitadosModel.php
     */


    class Invitados extends Modelo {
        protected $table = 'invitados';
	/**
	 * Lista todas los invitados del sistema
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name listarNotcias
	 *
	 * @return string
	 *
	 * Modificaciones
	 */
	public function listarInvitados($where = array()) {
	    $sql = "SELECT invitados.*, ediciones.titulo AS edicion
                    FROM invitados
                    INNER JOIN ediciones
                    ON ediciones.id = invitados.id_edicion
                    ";

	    return $sql;
	}

	/**
	 * Devuelve todas los invitados
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarInvitados
	 *
	 * @return array
	 *
	 * Modificaciones
	 */
	public function listadoInvitados($where = array()) {
	    $sql = "SELECT invitados.*, ediciones.titulo AS edicion
                    FROM invitados
                    INNER JOIN ediciones
                    ON ediciones.id = invitados.id_edicion
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