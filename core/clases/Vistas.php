<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name Vistas.php
 */

/**
 * Modificaciones realizadas
 *
 * 28/02/2010
 * - se agrego el codigo para llamar a otras clases y asignarlas para ser usadas
 * en las vistas.
 *
 * 17/04/2010
 * - se modifico la clase para que se use una estructura de template, donde en las vistas de cada controlador solo se carga el contenido del html a mostrar y en la carpeta
 * template en el archivo index.html se imprima el contenido de cada vista.
 *
 * 25/10/2010
 * - se agrego el método para mostrar vistas por ajax
 * - se cambio la extension de las vistas a .php
 *
 * 06/06/2011
 * - se modifico la forma de motrar un error al incluir la vista y como redireccionar a erro404.
 *
 * 20/10/2011
 * - se modifico el método show para que si es una llamada por ajax cargue solo la vista y si es una request normal
 * - cargue todo el template.
 *
 * 21/01/2012
 * - se modifico como se muestran los mensaje de errores cuando no existe el template en el frontend
 */
class Vistas {

    /**
     * Constructor de la clase para instanciar los modelos
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name __contruct
     *
     */
    function __construct() {
    }

    /**
     * permite mostrar una vista
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name show
     *
     * @param <string> $name
     * @param <array> $vars
     */
    public function show($name, $vars = array()) {
        //$name es el nombre de nuestra plantilla, por ej, listado.php
        //$vars es el contenedor de nuestras variables, es un arreglo del tipo llave => valor, opcional.

        //Traemos una instancia de nuestra clase de configuracion.
        $config = Config::singleton();
        $utilidades = Utilidades::singleton();
        $debug = FirePHP::getInstance(true);
        $lenguaje = Language::singleton();
        $url = Url::singleton();

        //Armamos la ruta a la plantilla
        $path = $config->get('vista') . $name;

        //asingo algunos objetos para que puedas ser usados en el frontend
        $vars['utilidades'] = $utilidades;
        $vars['config'] = $config;
        $vars['debug'] = $debug;
        $vars['leng'] = $lenguaje->language_convert();

        //Si no existe el fichero en cuestion, tiramos un 404
        if (file_exists($path) == false) {
            error_log("[".date("F j, Y, G:i")."] [E_USER_NOTICE] [tipo Vista] El Template: {$path}  no existe - \n", 3,$config->get('root').'/errores.log');
            if($config->get('entorno')=='dev') {
                $_SESSION['error'] .= "<h2>El Template: {$path}  no existe</h2>";
            }
            if(strpos($config->get('path'),'admin')) {
                header("Location:".$config->get('base')."index.php?controlador=error404");
            }
            else{
                //header("Location:"."error404");
                return include $config->get('root').'/website/template/error404.php';
            }
        }

        //Si hay variables para asignar, las pasamos una a una.
        if(is_array($vars)) {
            foreach ($vars as $key => $value) {
                $$key = $value;
            }
        }
        //valido si se quiere mostrar el login
        if($name!='login.php' && $name!='login.html') {
            //cargo la vista a mostrar
            ob_start();
            if($config->get('path')!= $config->get('root').'admin') {
                include_once($config->get('root').$config->get('viewsFolder').'header.php');
                include ($path);
                include_once($config->get('root').$config->get('viewsFolder').'footer.php');
            }
            else {
                //valido si se esta cargando por ajax o es un request normal
                if($this->isAjax()){
                    include ($path);
                    $contenido = ob_get_contents();
                    ob_end_clean();
                }
                else{
                    //si es un request normal cargo el header, el sidebar, la vista y el footer
                    include_once($config->get('root').$config->get('adminViewsFolder').'header.php');
                    include_once($config->get('root').$config->get('adminViewsFolder').'sidebar.php');
                    include ($path);
                    include_once($config->get('root').$config->get('adminViewsFolder').'footer.php');
                    $contenido = ob_get_contents();
                    ob_end_clean();
               }
                
            }
            
            //Finalmente, incluimos la plantilla validando si estoy en el admin o en el frontend
            if(strpos($config->get('path'),'admin')) {
                include($config->get('root').$config->get('adminViewsFolder').'index.php');
                
            }
            else {
                include($config->get('root').$config->get('viewsFolder').'index.php');
            }
        }
        else {
            include ($path);
        }
    }

    /**
     * permite mostrar una vista o un contenido mediante ajax
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name showAjax
     *
     * @param <string> $name
     * @param <array> $vars
     */
    public function showAjax($name, $vars = array()) {
        //Traemos una instancia de nuestra clase de configuracion.
        $config = Config::singleton();
        $utilidades = Utilidades::singleton();
        $debug = FirePHP::getInstance(true);
        $lenguaje = Language::singleton();
        $url = Url::singleton();

        //Armamos la ruta a la plantilla
        $path = $config->get('vista') . $name;


        //asigno algunos objetos para que puedas ser usados en el frontend
        $vars['utilidades'] = $utilidades;
        $vars['config'] = $config;
        $vars['debug'] = $debug;
        $vars['leng'] = $lenguaje->language_convert();

        //Si no existe el fichero en cuestion, tiramos un 404
        if (file_exists($path) == false) {

            error_log("[".date("F j, Y, G:i")."] [E_USER_NOTICE] [tipo Vista] El Template: {$path}  no existe - \n", 3,$config->get('root').'/errores.log');
            if($config->get('entorno')=='dev') {
                $_SESSION['error'] .= "<h2>El Template: {$path}  no existe</h2>";
            }
            //header("Location:".$config->get('admin')."error404");
            return include $config->get('root').'/website/template/error404.php';
        }

        //Si hay variables para asignar, las pasamos una a una.
        if(is_array($vars)) {
            foreach ($vars as $key => $value) {
                $$key = $value;
            }
        }

        //cargo la vista a mostrar
        ob_start();

        include ($path);
        $contenido = ob_get_contents();

        ob_end_clean();

        echo $contenido;
    }
    
    /**
     * devuelve si es una llamada por ajax
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name isAjax
     *
     */
    private function isAjax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}

?>