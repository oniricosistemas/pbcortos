<?php

session_start();
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name FrontController.php
 */

/**
 * Modificaciones realizadas
 *
 * 28/02/2010
 * - se modificó el código, ahora valida si la aplicación esta siendo ejecutada
 * en el servidor del cliente o en un servidor local, y a partir de esa
 * validación setear las ruta_absolutas de los directorios de la apliación.
 *
 * 07/03/2010
 * - se agrego un ruta_absoluta relativa para el directorio de las imagenes.
 *
 * 23/03/2010
 * - Se agrego el redireccionamiento error404.
 * - Se agrego el guardado de errores en un archivo errores.log
 *
 * 30/03/2010
 * - se agrego al método loader que evite los directorios .svn
 *
 * 02/04/2010
 * - Se modifico en el FrontController.php los include y la validación para el idioma.
 *
 * 31/05/2011
 * - Se reescribio el método __construct para corregir los bug que había cuando se tenia una
 * appliacación multiple.
 *
 * 31/12/2011
 * - se agrego para que se controle por base de datos si el sitio esa activo y/o en construcción
 * 
 * 21/01/2012
 * - se modifico como se muestran los errores 404
 */
class Router {

    private $servidor;
    private $ubicacion;
    private $ruta;
    private $ruta_absoluta;
    private $path;
    private $controlador_default = 'index';
    private $accion_default = 'index';
    private $routes = array();
    private $uri;
    private $subApp = '';

    /**
     * Constructor
     *
     * @name _construct
     * @param $registry
     * @access public
     * @version 0.2
     * @author Lucas M. Sastre
     *
     *
     */
    function __construct($param) {
        //seteo el servidor
        $this->servidor = $_SERVER['HTTP_HOST'];
        //separo los parametros
        $this->ubicacion = explode('/', $param);

        //defino el path root del sistema si no esta definido antes
        if (!defined('PATH_ROOT')) {
            $real = str_replace('core/clases', '', str_replace('\\', '/', realpath(dirname(__FILE__))));
            define('PATH_ROOT', $real);
        }

        //elimino el index.php
        array_pop($this->ubicacion);

        //armo el path
        $this->path = implode('/', $this->ubicacion);

        //valido si el directorio admin o no
        if (array_search('admin', $this->ubicacion)) {
            array_pop($this->ubicacion);
            $ruta = implode('/', $this->ubicacion);
            $this->ruta_absoluta = $ruta . '/';
        } else {
            $ruta = implode('/', $this->ubicacion);
            $this->ruta_absoluta = $ruta . '/';
        }

        $this->ruta = $_SERVER['DOCUMENT_ROOT'] . $ruta . '/';
    }

    /**
     *  router
     * @name router
     * @access public
     * @version 0.2
     * @author Lucas M. Sastre
     */
    public function route() {

        //llamo al archivo de configuración
        include_once(PATH_ROOT . '/configuracion.php');

        //seteo el root
        $config->set('root', $this->ruta);

        //valido si existe el archivo de testeo.
        if (file_exists($config->get('path_root') . 'test.php')) {
            // cargo el archivo para hacer el test del servidor
            return include $config->get('path_root') . 'test.php';
        }

        include_once $config->get('root') . "/core/clases/fb.php";
        $debug = firePHP::getInstance(true);

        //creo una instancia de la clase url
        $url = Url::singleton();

        //configuro la ruta_absoluta de las imagenes
        $config->set('imagenes', $config->get('root') . 'images/');
        if($config->get('entorno')=='dev'){
            $config->set('urlImagenes', $config->get('base'). 'images/');
        }
        else{
            $config->set('urlImagenes', 'http://' . $this->servidor . $this->ruta_absoluta . 'images/');
        }

        //seteo el path
        $path = $this->ruta;

        //valido si no estoy en el root y seteo el nuevo path
        if (strpos($this->path, 'admin')) {
            $path = $path . 'admin';
            $config->set('admin', 'index.php?controlador=');
            //seteo la ruta_absoluta url
            $config->set('urlRoot', 'http://' . $this->servidor . $this->ruta_absoluta);
        } else {
            $path = $path . 'website';
            //seteo la ruta_absoluta url
            $config->set('urlRoot', 'http://' . $this->servidor . $this->ruta_absoluta);
        }
        // capturo la uri
        $url->fetchUri();
        //separo los segmentos
        $url->explodeSegments();



        //cargo el lenguaje del sistema
        if ($config->get('multi') == 1) {
            $leng = Language::singleton();
            $leng->get_session_handler();
            $idiomaActual = $config->get('lenguaje');
            setcookie("leng", $idiomaActual, time () + 7 * 24 * 60 * 60);
            $_SESSION['leng'] = $idiomaActual;

            if (strlen($url->segment(0)) < 3) {
                setcookie("leng", $url->segment(0), time () + 7 * 24 * 60 * 60);
                $idiomaActual = $url->segment(0);
                $_SESSION['leng'] = $idiomaActual;
            } elseif (isset($_REQUEST['leng'])) {
                //setcookie ("leng", $_REQUEST['leng'], time () + 7*24*60*60);
                $idiomaActual = $_REQUEST['leng'];
                $_SESSION['leng'] = $idiomaActual;
            } elseif (isset($_COOKIE['leng'])) {
                if (file_exists($config->get('root') . "lenguajes/" . $_COOKIE['leng'] . ".php")) {
                    $idiomaActual = $_COOKIE['leng'];
                    $_SESSION['leng'] = $idiomaActual;
                }
            } else {
                if (file_exists($config->get('root') . "lenguajes/" . $_SESSION['leng'] . ".php")) {
                    $idiomaActual = $config->get('lenguaje');
                    $_SESSION['leng'] = $idiomaActual;
                }
            }

            // Incluimos el archivo del idioma seleccionado
            // o el archivo por defecto si no se seleccionó
            // idioma o si no se encuentra el archivo
            include $config->get('root') . "/lenguajes/" . $idiomaActual . ".php";
        } else {
            $leng = Language::singleton();
            $leng->get_session_handler();
            $idiomaActual = $config->get('lenguaje');
            setcookie("leng", $idiomaActual, time () + 7 * 24 * 60 * 60);
            session_start();

            $_SESSION['leng'] = $idiomaActual;

            include $config->get('root') . "/lenguajes/" . $config->get('lenguaje') . ".php";
        }

        //cargo todas las clases
        $this->loader($config->get('root') . $config->get('core'));

        //seteo la url
        $this->uri = str_replace('.' . $config->get('prefijo'), '', $url->fetchUri());
        //separo los segmentos de la uri
        $url->explodeSegments();
;
        //valido si existe un router.php en el root del sistema
        $subapp = $config->get('subapp');
        if (empty($subapp)) {
            if (file_exists($config->get('path_root') . 'router.php')) {
                // cargo el archivo con las reglas de ruteo
                include $config->get('path_root') . 'router.php';
            }
        } else {
            $this->subbApp($_SERVER['SCRIPT_NAME']);
            //si hay subaplicaciones valido que tengan router
            if (file_exists(PATH_ROOT . $this->subApp . '/router.php')) {
                // cargo el archivo con las reglas de ruteo
                include PATH_ROOT . $this->subApp . '/router.php';
            }
        }

        //seteo el routes
        $this->routes = (!isset($route) OR !is_array($route)) ? array() : $route;
        unset($route);

        //valido que no este vacios el arreglo routes
        if (!empty($this->routes)) {
            $this->parsearRuta();
        }

        //valido si el sitio esta activo
        $db = Database::singleton();
        $estado = $db->QuerySingleRow('select * from core_configuracion');
        if (!$estado->activo && !strpos($path, 'admin')) {
            return include $config->get('root') . '/website/template/inactivo.php';
        }
        //valido si el sitio esta en construccion
        if ($estado->construccion && !strpos($path, 'admin')) {
            return include $config->get('root') . '/website/template/construccion.php';
        }

        /* valido si la url es amigable por htaccess o no
         * esto permite tener compatibilidad con versiones
         * viejas del framework con el core nuevo
         */
        
        if (strpos($this->uri, 'index.php?') || strpos($_SERVER['REQUEST_URI'], 'index.php?') !== FALSE || !empty($_GET['controlador']) || !empty($_POST['controlador'])) {
            //obtengo el controlador que se envia por $_GET o por $_POST
            if (isset($_REQUEST['controlador'])) {
                $controller = $_REQUEST['controlador'];
            } elseif (isset($_POST['controlador'])) {
                $controller = $_POST['controlador'];
            } else {
                $controller = $_GET['controlador'];
            }
            //obtengo la accion que se envia por $_GET o por $_POST
            if (isset($_REQUEST['accion'])) {
                $action = $_REQUEST['accion'];
            } elseif (isset($_POST['accion'])) {
                $action = $_POST['accion'];
            } else {
                $action = $_GET['accion'];
            }
        } else {
            //valido si es multiaplicacion
            for ($i = 0; $i < count($partes); $i++) {
                //valido si las partes no estan vacias o no
                // son nombre de carpetas de aplicaciones
                if ($partes[$i] != '' && !in_array($partes[$i], $apps)) {
                    $segmentos[] = $partes[$i];
                } else {
                    $app = $partes[$i];
                }
            }
            // si la uri es disinto a /
            if ($this->uri != '/') {
                // separo las partes de la uri
                $seg = explode('/', $this->uri);
                //valido si es el admin o no
                if ($seg[0] != 'admin') {
                    $url->removeUrlSuffix();
                    //obtengo el  controlador que se envia por $_REQUEST
                    $controller = str_replace("." . $config->get('prefijo'), '', $seg[0]);
                    //obtengo la accion que se envia por $_REQUEST
                    if (isset($seg[1]) && !is_numeric($seg[1])) {
                        $action = str_replace("." . $config->get('prefijo'), '', $seg[1]);
                    }
                } else {
                    $url->removeUrlSuffix();
                    //si es admin seteo el path de nuevo
                    $path = $this->ruta . 'admin';
                    //obtengo el  controlador que se envia por $_REQUEST
                    $controller = str_replace($config->get('prefijo'), '', $seg[1]);
                    //obtengo la accion que se envia por $_REQUEST
                    if (isset($seg[2])) {
                        $action = str_replace("." . $config->get('prefijo'), '', $seg[2]);
                    }
                }
            } else {
                $url->removeUrlSuffix();
                //valido si es el admin o no
                if ($segmentos[1] != 'admin') {
                    //obtengo el  controlador que se envia por $_REQUEST
                    $controller = str_replace("." . $config->get('prefijo'), '', $segmentos[1]);
                }

                //obtengo la accion que se envia por $_REQUEST
                if (isset($partes[2])) {
                    $action = str_replace("." . $config->get('prefijo'), '', $segmentos[2]);
                }
            }
        }
        if (strpos($path, 'admin')) {
            $config->set('error', $config->get('base') . 'admin/');
        } else {
            $config->set('error', $config->get('base'));
        }

        //seteo el controlador si esta vacio seteo el controlador por default
        if (empty($controller)) {
            $controller = $this->controlador_default . 'Controller';
        } else {
            $controller = $controller . 'Controller';
        }

        //extraigo el nombre del controlador.
        $nombre = explode('Controller', $controller);

        //seteo la accion, si esta vacia seteo la acción por default
        if (empty($action)) {
            $action = $this->accion_default;
        } else {
            $action = $action;
        }

        //seteo el path definitivo
        $config->set('path', $path);
        $config->set('path_root', str_replace('\\', '/', PATH_ROOT) . '/');

        //seteo la ruta_absoluta del controlador
        $controllerLocation = $config->get('path') . '/controladores/' . $nombre[0] . '/' . $controller . '.php';

        //seteo la ruta absoluta de la vista
        $vista = $config->get('path') . '/controladores/' . $nombre[0] . '/templates/';
        $config->set('vista', $vista);
        //inicio la session
        session_start();

        //valido si existe el archivo sino ejecuta la excepcion
        if (file_exists($controllerLocation)) {
            include_once( $controllerLocation );
        } else {
            error_log("[" . date("F j, Y, G:i") . "] [Error: E_USER_NOTICE] [Descripcion: No se encuentra el controlador: {$controllerLocation} ]\n", 3, $config->get('root') . '/errores.log');
            $_SESSION['error'] .= "<h2>No se encuentra el controlador: {$controllerLocation}</h2>";
            return include $config->get('root') . '/website/template/error404.php';
        }

        //valido si existe la clase sino ejecuta la excepcion
        if (class_exists($controller, false)) {
            $cont = new $controller();
        } else {
            error_log("[" . date("F j, Y, G:i") . "] [Error: E_USER_NOTICE] [Descripcion: No se encuentra la clase en el controlador $controller en $controllerLocation ]\n", 3, $config->get('root') . '/errores.log');
            $_SESSION['error'] .= "<h2>No se encuentra la clase en el controlador $controller en $controllerLocation</h2>";
            return include $config->get('root') . '/website/template/error404.php';
        }

        //valido si existe el método sino ejecuta la excepcion
        if (method_exists($cont, $action)) {
            $cont->$action();
        } else {
            error_log("[" . date("F j, Y, G:i") . "] [Error: E_USER_NOTICE] [Descripcion: La Acción $action no existe $action en la clase $controller en $controllerLocation ]\n", 3, $config->get('root') . '/errores.log');
            $_SESSION['error'] .= "<h2>La Acción $action no existe $action en la clase $controller en $controllerLocation</h2>";
            return include $config->get('root') . '/website/template/error404.php';
        }
    }

    /**
     * Parsea las reglas de ruteo y devuelve la url definitiva
     * @version 0.1
     * @author Lucas M. sastre
     * @access private
     * @name parsearRuta
     *
     * @return string $this->uri
     *
     * @todo Modificaciones
     */
    private function parsearRuta() {
        //creo una instancia de la clase url
        $url = Url::singleton();
        $config = Config::singleton();
        $debug = firePHP::getInstance();

        //valido si la url es distinta a /
        if ($this->uri != '/') {
            //valido si la url es literal
            if (isset($this->routes[$this->uri])) {
                $this->uri = $this->routes[$this->uri];
                $url->uri_string = $this->uri;
                return $this->uri;
            }
            // recorro el arreglo de reglas router
            foreach ($this->routes as $key => $val) {
                // Convierto los wild-cards a RegEx
                //$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));
                //$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', str_replace(':alphanum','[a-z0-9]+',str_replace(':alpha','[a-z]+',$key))));
                if (strpos($key, ':') !== false) {
                    $wildcard = array(':any', ':alphanum', ':num', ':alpha');
                    $regex = array('(.+)', '([a-z0-9]+)', '([0-9]+)', '([a-z]+)');
                    $key = str_replace($wildcard, $regex, $key);
                }

                //valido si hay un lenguaje en la session
                if (!empty($_SESSION['leng']) && $config->get('multi')) {
                    $key = $_SESSION['leng'] . '/' . $key;
                }
                // Valido si existe coincidencia
                if (preg_match('#^' . $key . '$#', $this->uri)) {
                    // Valido si hay concidencia con las back-reference?
                    if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE) {
                        $val = preg_replace('#^' . $key . '$#', $val, $this->uri);
                    }
                    // setteo la uri final
                    $this->uri = $val;
                    $url->uri_string = $this->uri;
                    return $this->uri;
                }
                //valido si la regla esta dentro de la url
                elseif (strpos($this->uri, $key) !== FALSE) {
                    $this->uri = $val;
                    $url->uri_string = $this->uri;
                    return $this->uri;
                }
            }
        } else {
            //si no esta dentro de una regla de ruteo armo la uri
            // con los segmentos
            $this->uri = implode('/', $url->segments);
            $url->uri_string = $this->uri;
        }
    }

    /**
     *  Setea el nombre de la subaplicacion a entrar
     * @name subbApp
     * @access public
     * @version 0.2
     * @since 0.1
     * @author Lucas M. Sastre
     * @param <string> $uri
     * @return <string>
     */
    private function subbApp($uri) {
        $carpetas = explode('/', $uri);
        $debug = firePHP::getInstance();
        if (count($carpetas) == 3) {
            return $this->subApp = $carpetas[0];
        } else {
            return $this->subApp = $carpetas[2];
        }
    }

    /**
     * Cargador de clases
     *
     * @name loader
     * @access public
     * @version 0.2
     * @since 0.1
     * @author Lucas M. Sastre
     */
    public function loader() {
        $path = str_replace('\\', '/', dirname(__FILE__)) . '/';

        //leo el directorio
        $dir = scandir($path);
        //valido si es un array y que tenga algun contenido
        if ((is_array($dir)) && (count($dir) > 0))
            foreach ($dir as $k => $v)
            //recorro el directorio y valido que sea un archivo php
                if (!(is_dir($path . $v)) && ( file_exists($path . $v) ) && ($v != ".") && ($v != "FrontController.php") && ($v != "..") && (strtolower(end(explode(".", $v))) == 'php'))
                //incluyo el archivo
                    include_once($path . $v);
                elseif (is_dir($path . $v) && ($v != ".") && ($v != "..") && ($v != 'smarty') && ($v != '.svn') && ($v != 'ajax'))
                    loader($path . $v . "/");
    }

}

?>