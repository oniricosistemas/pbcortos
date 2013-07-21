<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name UsuariosModel.php
     */

    class Usuarios extends Modelo {
        protected $table = 'core_users';
	/**
	 * Lista todos los usuarios del sistema
	 *
	 * @return <array>
	 */
	public function listarUsuarios($data=array()) {
	    $sql = "SELECT * FROM core_users WHERE 1 ";
	    if(!empty($data['usuario'])) {
		$sql .= " AND username like '{$data['usuario']}%'";
	    }

	    if(!empty($data['nombre'])) {
		$sql .= " AND nombre like '{$data['nombre']}%' OR apellido like '{$data['nombre']}%'";
	    }

	    if(!empty($data['email'])) {
		$sql .= " AND email like '{$data['email']}%'";
	    }

	    if(!empty($data['order'])) {
		switch ($data['order']) {
		    case 'email':
			$order = 'email';
			break;

		    case 'id':
			$order = 'id';
			break;

		    case 'username':
			$order = 'username';
			break;

		    case 'nombre':
			$order = 'nombre';
			break;

		    case 'apellido':
			$order = 'apellido';
			break;

		    case 'estado':
			$order = 'estado';
			break;
		}
	    }
	    else {
		$order = ' id';
	    }
	    if(!empty($data['orden'])) {
		$por = " {$data['orden']}";
	    }
	    else {
		$por = ' ASC';
	    }
	    $sql .= ' ORDER BY '.$order.$por;

	    return $sql;
	}


	/**
	 * busca un usuario
	 *
	 * @return <array>
	 */
	public function  buscarUsuarios($data) {
	    $sql = "SELECT * FROM core_users		    
		    WHERE 1 ";
	    if(!empty($data['id'])) {
		$sql .= " AND core_users.id='{$data['id']}'";
	    }
	    if(!empty($data['username'])) {
		$sql .= " AND username='{$data['username']}'";
	    }
	    $consulta = $this->db->QuerySingleRow($sql);
	    if(!$consulta) {
		$consulta = $this->db->Error();
	    }
	    return $consulta;
	}

	/**
	 * Hace el login de los usuarios
	 * @param <array> $data
	 * @return <integer>
	 */
	public function login($data) {
	    $sql = "SELECT * FROM core_users
                    WHERE username='".trim($data['username'])."'
                    AND password='".md5(trim($data['password']))."'
                    AND estado='1'";
	    $consulta = $this->db->Query($sql);

            if(!$consulta) {
		return $this->db->Error();
	    }
	    return $this->db->RowCount();
	}


    }
?>