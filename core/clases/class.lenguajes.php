<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name class.utilidades.php
 *
 */

class Language{
    private static $instance=null;
    
    /**
     * constructor
     *
     * @access public
     * @version 0.1
     * @author Lucas M. Sastre
     *
     */
    public function __construct() {

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


    /**
     * inicializa la session y define la salida del buffer
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name get_session_handler
     *
     * Modificado:
     *
     */
    public function get_session_handler(){
        ob_start();    //output stream buffer
        
    }


    /**
     * devuleve los lenguajes con hiperlink
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name get_language_list
     *
     * Modificado:
     *
     */
    public function get_language_list(){

        $lang_list .="<table width=100% border=0><tr width=100%><td align=right>";
        $data       = array(1 => 'ENGLISH' , 'SPANISH' , 'FRENCH' );  //Assign Languages into $data Array from Key value 1.
        
        foreach($data as $k=>$v){
                $lang_list.="<a href=\"index.php?language=$v\" class=\"link1\">$v";
                $lang_list .="</a>";
                $lang_list .="&nbsp;<span class=\"pipeline\"> |</span> &nbsp;";
        }

               $lang_list .="</td></tr></table>";

        return $lang_list;
    }


    /**
     * devuelve el nombre del lenguaje cambiado en base a la session actual
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name language_convert
     *
     * Modificado:
     *
     */
    public function language_convert(){
        $config = Config::singleton();

        //Determine whether a Requested Language is set
        if(isset($_GET['leng'])){   

          //Assign Requested Language  to one variable as $lan_name;
           $lan_name = $_GET['leng'];   

          //Assign the value '$lan_name' to SESSION
           $_SESSION['leng'] = $lan_name;   

        }

        //If Requested Language is in session means goto Requested Language of PHP file  Otherwise goto english.php
        if($_SESSION['leng']) {
            //Make a SESSION value in lowercase because our language file is in lower case(EX: english.php)
      	     $lang = strtolower($_SESSION['leng']);   
      	     
      	     //Include Requested Language of PHP file
             include($config->get('root').'lenguajes/'.$lang.".php");
        }
        else{
          //Include Default Language of PHP file
            require_once($config->get('root').'lenguajes/es.php');
        }

        return $lang_array;
   }

}

?>

