<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name PermisosModel.php
 */

class Permisos extends Modelo {
    protected $table = 'core_permisos';
    /**
     * Devuelve todos los permisos del sistema
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @namelistarPermisos
     *
     * @return string
     *
     * Modificaciones
     */

    public function listarPermisos() {
        $sql="SELECT * FROM core_permisos";

        return $sql;
    }


    /**
     * valida si existe un usuario en la tabla permisos
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name validarExisteUsuario
     *
     * @return string
     *
     * Modificaciones
     */
    public function validarExisteUsuario($data) {
        $sql = "SELECT * FROM core_permisos WHERE id_usuario = '{$data['id']}'";
        $consulta = $this->db->Query($sql);
        if(!$consulta) {
            return $this->db->Error();
        }
        return $this->db->RowCount();
    }

    /**
     * borrar los permisos asociados a un usuario
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name borrarPermisos
     *
     * @return string
     *
     * Modificaciones
     */
    public function borrarPermisos($data) {
        $filtro['id_usuario'] = $data['id_usuario'];
        $consulta = $this->db->DeleteRows($this->table, $filtro);
        if(!$consulta) {
            $this->error = $this->db->Error();
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Lista todos los mensaje del sistema
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name listadoPermisos
     *
     * @return array
     *
     * Modificaciones
     */
    public function listadoPermisos($data) {
        $sql="SELECT * FROM core_permisos WHERE 1 ";
        if(!empty($data['id'])) {
            $sql .= "AND id='{$data['id']}'";
        }
        if(!empty($data['id_usuario'])) {
            $sql .= "AND id_usuario='{$data['id_usuario']}'";
        }
        $consulta = $this->db->QuerySingleRow($sql);
        if(!$consulta) {
            $consulta = $this->db->Error();
        }
        return $consulta;
    }

    /**
     * Lista todos los mensaje del sistema para validar con el usuario
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name listadoPermisosValidar
     *
     * @return array
     *
     * Modificaciones
     */
    public function listadoPermisosValidar($data) {
        $sql="SELECT * FROM core_permisos WHERE 1 ";
        if(!empty($data['id'])) {
            $sql .= "AND id='{$data['id']}'";
        }
        if(!empty($data['id_usuario'])) {
            $sql .= "AND id_usuario='{$data['id_usuario']}'";
        }
        $consulta = $this->db->QueryArray($sql);
        if(!$consulta) {
            $consulta = $this->db->Error();
        }
        return $consulta;
    }
}