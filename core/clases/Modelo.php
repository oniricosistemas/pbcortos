<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name Modelo.php
 */

abstract class Modelo {
    protected $table;
    protected $keyField;
    protected $db;
    protected $fields = array();
    private $_columns;
    private $Config;
    private $seteados = 0;
    public $error = '';
    public $ultimoId;

    /**
     * Contructor
     *
     * @access Public
     * @version 0.2
     */
    public function __construct() {
        $this->db = Database::singleton();
        $this->iniciar();

    }

    /**
     * inicia el ORM
     * @version 0.1
     * @author Lucas M. sastre
     * @access protected
     * @name iniciar
     *
     */
    protected function iniciar() {
        //si no hay seteada una tabla corto el proceso y muestro el error.
        $this->Config = Config::singleton();
        if( !$this->table ) {
            error_log("[".date("F j, Y, G:i")."] [E_USER_NOTICE] [tipo Modelo] No se seteo ninguna tabla para el modelo: ".get_class($this)."\n", 3,$this->Config->get('root').'/errores.log');
            die('No se seteo ninguna tabla para el modelo: '.get_class($this));
        }

        //obtengo los campos de la tabla
        $query = "SHOW FIELDS FROM ".$this->table;
        $command = $this->db->QueryArray($query);

        $fields = array();
        $primary = '';

        //recorro los campos y los guardo en un arrgeglo
        for($i=0;$i<count($command);$i++) {
            $fields[$command[$i]['Field']] = array(
                    "name" => $command[$i]['Field'],
                    "type" => $command[$i]['Type'],
                    "defaultValue" => $command[$i]['Default'],
                    "key" => $command[$i]['Key'],
            );
            //obtengo la clave primaria
            if( $command[$i]['Key'] === "PRI" ) {
                $primary = $command[$i]['Field'];
            }
            $this->fields[$command[$i]['Field']] = '';
        }

        $this->_columns = $fields;

        if( empty( $primary ) ) {
            throw new Exception( "No se encontro la columna clave para la tabla: " . $this->table );
        }

        $this->keyField = $primary;
    }

    /**
     * devuelve la info de la tabla
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name info
     *
     * @return array
     */
    public function info() {
        return array(
                "name" => $this->table,
                "columns" => $this->_columns,
                "primary" => $this->keyField,
        );
    }

    /**
     * devuelve el campo que es clave primaria de la tabla
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name traerClavePrimaria
     *
     */
    public function traerClavePrimaria() {
        return $this->keyField;
    }


    /**
     * busca un registro por la clave primaria.
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name buscarPorPk
     *
     * @param intenger/array $id
     *
     * @return object
     *
     */
    public function buscarPorPk($id) {
        //valido si el parametro es una arreglo o no
        if(is_array($id)) {
            $valor = $id[$this->keyField];
        }
        else {
            $valor = $id;
        }

        $sql = "SELECT * FROM `%s` WHERE `%s`='%s' LIMIT 1";
        $sql = sprintf($sql, $this->table, $this->keyField, $valor);
        $consulta=$this->db->QuerySingleRowArray($sql);
        if(!$consulta) {
            $consulta=$this->db->Error();
        }
        foreach ($consulta as $key => $value) {
            if(!is_numeric($key)) {
                $this->$key = $value;
                $this->fields[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * devuelve todos los registro de una tabla
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name buscarTodos
     *
     * @return array
     *
     */
    public function buscarTodos() {
        $sql = "SELECT * FROM ".$this->table;
        $consulta = $this->db->QueryArray($sql);
        if(!$consulta) {
            $this->error = $this->db->Error();
        }
        return $consulta;
    }

    /**
     * crea un nuevo registro en la tabla
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name nuevo
     *
     * @param array $valores
     * @return boolean
     *
     */
    public function nuevo($valores) {
        $vacio = 0;
        //recorro los valores enviados y los voy asignando a los campos del registro
        foreach ($valores as $key => $val) {
            if(empty ($val) && $key != $this->keyField) {
                $vacio++;
            }
            $insertar[$key] = "'".mysql_escape_string(trim($val))."'";
        }

        if($vacio == count($this->fields)) {
            $this->error = "Todos los campos estan vacios o los campos no existe en la tabla.<br/>";
            return false;
        }
        else {
            $consulta = $this->db->InsertRow($this->table, $insertar);

            if(!$consulta) {
                $this->error = $this->db->Error();
                return false;
            }
            else {
                $this->ultimoId = $this->db->GetLastInsertID();
                return true;
            }
        }

    }

    /**
     * actualiza un nuevo registro en la tabla
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name actualizar
     *
     * @param array $valores
     * @return boolean
     *
     */
    public function actualizar($valores) {
        $vacio = 0;
        //recorro los valores enviados y los voy asignando a los campos del registro
        foreach ($valores as $key => $val) {
            //valido si el campo existe en la tabla
            if($key === $this->keyField) {
                $filtro[$this->keyField] = stripslashes($val);
            }
            if(empty ($val)) {
                $vacio++;
            }
            $actualizar[$key] = "'".mysql_escape_string(trim($val))."'";
        }

        if($vacio == count($this->fields)) {
            $this->error = "Todos los campos estan vacios o los campos no existe en la tabla.<br/>";
            return false;
        }
        else {
            //actualizo el registro
            $consulta = $this->db->UpdateRows($this->table, $actualizar, $filtro);
            if(!$consulta) {
                $this->error = $this->db->Error();
                return false;
            }
            else {
                $this->ultimoId = $filtro[$this->keyField];
                return true;
            }
        }
    }

    /**
     * guarda/edita un registro
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name guardar
     *
     */
    public function guardar() {
        //valido si se seteadon los campos automaticamente.
        // si no estan seteados es porque se hizo a mano desde el controlador
        if(!$this->seteados) {
            //recorro los campos y voy asignando los valores
            foreach ($this->fields as $key => $value) {
                $this->fields[$key] = stripslashes($this->$key);
            }
        }

        // valido si en los campos seteados esta la clave primaria par saber si es
        // una actualizacion o un nuevo registro
        if(empty($this->fields[$this->keyField])) {
            return $this->nuevo($this->fields);
        }
        else {
            return $this->actualizar($this->fields);
        }
    }

    /**
     * setea de forma automatica los campos de un registros
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name setearCampos
     *
     * @param array $data
     *
     */
    public function setearCampos($data) {
        //Recorro el arreglo y lo asigno a los campos del registro
        foreach ($data as $key => $value) {
            //valido si existe la clave en el arreglo de los campos y lo asigno al campo
            if(array_key_exists($key, $this->fields)) {
                $this->fields[$key] = stripslashes($value);
            }
            //valido si existe la clave primaria en el arreglo si no existe la seteo en vacio.
            if(!array_key_exists($this->keyField, $data)) {
                $this->fields[$this->keyField] = '';
            }
        }

        //cambio el estado de la bandera seteados
        $this->seteados = 1;
    }

    /**
     * borra un registro en la tabla
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name borrar
     *
     * @param integer $id
     * @return boolean
     *
     */
    public function borrarPorPk($id) {
        $filtro[$this->keyField] = $id;
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
     * borra todos los registros en la tabla
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name borrarTodo
     *
     * @return bolean
     *
     */
    public function borrarTodo() {
        $consulta = $this->db->TruncateTable($this->table);
        if(!$consulta) {
            $this->error = $this->db->Error();
            return false;
        }
        else {
            return true;
        }
    }
}
?>