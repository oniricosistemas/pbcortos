<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name: class.permisos.php
 *
 */

class PermisosUsuarios {

    private static $instance=null;
    private $Permisos;

    /**
     * Constructor de la clase
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name __contruct
     *
     */
    public function __construct() {
        $config = Config::singleton();
        include_once($config->get('path_root').'modelos/PermisosModel.php');
        $this->Permisos = new Permisos();

    }

    /**
     * carga los nombre de los controladores existentes
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name cargarControladoresPermisos
     *
     * @param string $dir
     *
     * @return string $nombre
     *
     * Modificaciones
     */
    private function cargarControladoresPermisos($dir) {
        if(is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if($file != "." && $file != ".." && $file != 'smarty' && $file != '.svn' && $file != 'ajax' && $file != 'index' && $file != 'error404') {
                        $nombres[] = $file;
                    }
                }
                closedir($dh);
            }
        }

        return $nombres;

    }

    /**
     * carga los nombre de los metodos de un controlador existentes
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name cargarMetodosControladoresPermisos
     *
     * Modificaciones
     * @param string $ruta
     * @param string $class
     * @return array
     */
    private function cargarMetodosControladoresPermisos($ruta,$class) {
        $clase = $ruta.$class."/".strtolower($class)."Controller.php";
        $class = strtolower($class)."Controller";

        if(file_exists($clase)) {
            if(class_exists($class)) {
                $class_methods = get_class_methods($class);
            }
            else {
                include_once ($clase);
                $class_methods = get_class_methods(new $class());
            }
        }

        return $class_methods;
    }

    /**
     * lista los permisos
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name listarPermisos
     *
     * @param srting $ruta
     *
     * @return string $nombre
     *
     * Modificaciones
     */
    public function listarPermisos($ruta) {
        $controladores = $this->cargarControladoresPermisos($ruta);
        for($i=0;$i<count($controladores);$i++) {
            $nombre[$i]['nombre']=$controladores[$i];
            $metodos = $this->cargarMetodosControladoresPermisos($ruta,$controladores[$i]);
            $k=0;
            for($j=0;$j<count($metodos);$j++) {
                if($metodos[$j]!='__construct' && $metodos[$j]!='modelo' && $metodos[$j]!='guardar'.ucfirst($controladores[$i]) && $metodos[$j]!='crear'.ucfirst($controladores[$i]) && $metodos[$j]!='libreria' && $metodos[$j]!='helpers') {
                    $nombre[$i][]= $metodos[$j];
                }
                $k++;
            }
        }

        return $nombre;
    }

    /**
     * valido los permisos de un usuario
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name validarPermisos
     *
     * @param integer $user
     * @param string $accion
     *
     * Modificaciones
     */
    public function validarPermisos($user,$accion) {
        $config = Config::singleton();
        $data['id_usuario'] = $user;
        $permisos = $this->Permisos->listadoPermisosValidar($data);
        $control = unserialize($permisos[0]['permisos']);
        $seccion = explode('::', $accion);
        $seccion[0] = ucfirst(str_replace('Controller','',$seccion[0]));
        if(!isset($_SESSION['admin'.$config->get('app')])){
            echo "<script>window.open('index.php?controlador=index','_self');</script>";
            die();
        }
        if(!$this->controlPermisos($accion, $control) && $_SESSION['superadmin']!='1'){
            $_SESSION['mensaje'] = "No tiene los permisos de asignados para ingresar a la sección: ".$seccion[0]." - ".$seccion[1]."<br/>";
            echo "<script>window.open('index.php?controlador=error404','_self');</script>";
            die();
        }
    }

    /**
     * comparo los permisos del usuario con el array de permisos
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name validarPermisos
     *
     * @param integer $user
     * @param string $accion
     *
     * Modificaciones
     */
    private function controlPermisos($permisos,$control){
        $permisos = str_replace('Controller','',$permisos);
        $permisos = str_replace('::',':',$permisos);
        $permisos = str_replace('guardar','nuevo',$permisos);
        $validar = 0;
        for($i=0;$i<count($control);$i++){
            if($control[$i] == $permisos){
                $validar++;
            }            
        }
        if($validar){
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * patron singleton
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name singleton
     *
     * @return $instance
     *
     * Modificado:
     *
     */
    public static function singleton() {
        if( self::$instance == null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

?>