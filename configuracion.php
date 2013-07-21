<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name configuracion.php
 */

//creo una instancia del config
$config = Config::singleton();

//seteo el entorno
$config->set('entorno','dev');

//seteo el debug del paginador
$config->set('paginador','dev');

//seteo si muestra los errores o no.
ini_set('debug','1');

//seteo si un log de las consulta sql
ini_set('logSql','1');

error_reporting(~E_ALL ^ ~E_NOTICE );

//seteo la versión del framework
$config->set('version','0.3.2');

//seteo si es multilenguaje 0=no,1=si
$config->set('multi','0');

//seteo si el admin es multilenguaje 0=no,1=si
$config->set('adminmulti','0');

//seteo el protocolo uri
$config->set('uri_protocol','auto');

//autor
$config->set('autor','Onírico Sistemas');

//copyright
$config->set('copy','Onírico Sistemas - www.oniricosistemas.com');

//seteo la url base
if($config->get('entorno')=='pro') {
    $config->set('base','http://www.pbycortos.com/');
}
elseif($config->get('entorno')=='test'){
	$config->set('base','http://'.$_SERVER['HTTP_HOST'].'/punk_dev/');
}
elseif($config->get('entorno')=='dev') {
    $config->set('base','http://'.$_SERVER['HTTP_HOST'].'/pbcortos/');
}
// seteo si el sitio va a tener mas de un frontend 0=no, 1=si
$config->set('multiapp','1');

//creo el array con las carpetas que son subaplicaciones
$app = array('pbycortos5','pbycortos6');
$config->set('subapp',$app);

// seteo el prefijo de las url
$config->set('prefijo','php');

//caracteres permitidos
$config->set('permitted_uri_chars','a-z 0-9~%.:_\-');

//seteo si va a tener mas amplicaciones
$config->set('app','pbcortos');

//seto si el SEO es dinamico 1=si 0=no
$config->set('seo','0');

//seteo el lenguaje por defecto
$config->set('lenguaje','es');

/**
 * Funcion para mostrar los errores
 *
 * @since 0.1
 * @version 0.1
 * @author Lucas M. Sastre
 *
 * @param integer $num_err
 * @param string $cadena_err
 * @param string $archivo_err
 * @param integer $linea_err
 * @return bool
 */
function mostrarErrores($num_err, $cadena_err, $archivo_err, $linea_err) {
    $config = Config::singleton();
    //seteo el entorno
    $config->set('entorno','dev');

    //controlo que error se paso y lo muestro
    switch ($num_err) {
        case E_USER_ERROR:
            echo "<b>Mi ERROR</b> [$num_err] $cadena_err<br />\n";
            echo "  Error fatal en la línea $linea_err en el archivo $archivo_err";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            echo "Abortando...<br />\n";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<b>Mi ADVERTENCIA</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
            break;

        case E_USER_NOTICE:
            echo "<b>Mi NOTICe</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
            break;


    }
    //si el entorno es de testeo muestro todos los errores
    if($config->get('entorno')=='test') {
        switch ($num_err) {
            case E_ALL:
                echo "<b>TODOS ERRORES</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;

            /*case E_NOTICE:
                echo "<b>NOTICE EN TIEMPO DE EJECUCION</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;*/

            case E_ERROR:
                echo "<b>ERROR FALTA EN EJECUCION</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;

            case E_WARNING:
                echo "<b>ADVERTENCIA EN EJECUCION</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;

            case E_PARSE:
                echo "<b>ERROR DE PARSEO</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;

            case E_CORE_ERROR:
                echo "<b>ERROR FATAL EN PHP</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;

            case E_CORE_WARNING:
                echo "<b>ADVERTENCIA EN PHP</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;

            case E_COMPILE_ERROR:
                echo "<b>ERROR EN TIEMPO DE COMPILACION</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;

            case E_COMPILE_WARNING:
                echo "<b>ADVERTENCIA EN TIEMPO DE COMPILACION</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;
        }
    }
    //si el entorno es de desarrollo muestro los errores estrictos
    /*elseif ($config->get('entorno')=='dev') {
        switch ($num_err) {
            case E_STRICT:
                echo "<b>NOTICE EN EJECUCION</b> [$num_err] $cadena_err [$linea_err] en $archivo_err<br />\n";
                break;
        }
    }*/

    //creo una instancia para la base de datos
    $db = Database::singleton();

    //creo el arreglo con los datos a guardar
    $fecha = date('Y-m-d H:m');
    if($config->get('entorno')=='dev') {
        if($num_err=='2048') {
            $error['id'] = '';
            $error['fecha'] = $fecha;
            $error['error'] = $cadena_err;
            $error['cod_error'] = $num_err;
            $error['linea'] = $linea_err;
            $error['accion'] = $archivo_err;
            $error['user_id'] = 1;
        }
    }
    elseif ($config->get('entorno')=='test') {
        if($num_err!='2048') {
            $error['id'] = '';
            $error['fecha'] = $fecha;
            $error['error'] = $cadena_err;
            $error['cod_error'] = $num_err;
            $error['linea'] = $linea_err;
            $error['accion'] = $archivo_err;
            $error['user_id'] = 1;
        }
    }
    else {
        if($num_err=='256' || $num_err=='512' || $num_err='1024') {
            $error['id'] = '';
            $error['fecha'] = $fecha;
            $error['error'] = $cadena_err;
            $error['cod_error'] = $num_err;
            $error['linea'] = $linea_err;
            $error['accion'] = $archivo_err;
            $error['user_id'] = 1;
        }
    }

    $user_id="";
    if(!empty($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }

    $sql="select * from core_errores where cod_error='$num_err' and linea='$linea_err' and accion='$archivo_err' and user_id='$user_id'";
    $existe=$db->Query($sql);

    if(!$db->RowCount()) {
        $db->TransactionBegin();

        $consulta=$db->Query("insert into core_errores (fecha,error,cod_error,linea,accion,user_id) values ('$fecha','$cadena_err','$num_err','$linea_err','$archivo_err','$user_id')");
        $db->TransactionRollback();
    }

    $db->TransactionRollback();


    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}
if($config->get('entorno')!="pro") {
    //asigno el nuevo control de errores
    $gestor_errores_anterior = set_error_handler("mostrarErrores");
}

//seteo rutas de directorios website
$config->set('controllersFolder','/website/controladores/');
$config->set('viewsFolder', 'website/template/');

//seteo rutas de directorios admnistración
$config->set('adminControllerFolder','admin/controladores/');
$config->set('adminViewsFolder','admin/template/');

//seteo las rutas de los javascripts
$config->set('js','core/js');
$config->set('jsAdmin','js/');

//seteo las rutas de los css
$config->set('css',$config->get('template').'css/');
$config->set('cssAdmin','css/');

//seteo la ruta de las imagenes
$config->set('images','/images/');

//seteo ruta core
$config->set('core','core/clases/');
$config->set('librerias','/librerias/');
$config->set('helpers','helpers/');
$config->set('modelsFolder', $config->get('root').'/modelos/');

if($config->get('entorno')=='dev') {
    //configuración email
    $config->set('email','desarrollo@oniricosistemas.com.ar');
    $config->set('usuario','desarrollo+oniricosistemas.com.ar');
    $config->set('pass','f9f803c0');
    $config->set('host','mail.oniricosistemas.com.ar');
    $config->set('puerto','9025');
    $config->set('nombre','');
}
elseif($config->get('entorno')=='test') {
    //configuración email
    $config->set('email','');
    $config->set('usuario','');
    $config->set('pass','');
    $config->set('host','');
    $config->set('puerto','');
    $config->set('nombre','');
}
else {
    //configuración email
    $config->set('email','');
    $config->set('usuario','');
    $config->set('pass','');
    $config->set('host','');
    $config->set('puerto','');
    $config->set('nombre','');
}

if($config->get('entorno')=='dev') {
    //configuracion base de datos
    $config->set('dbhost', 'localhost');
    $config->set('dbname', 'pbycortos');
    $config->set('dbuser', 'root');
    $config->set('dbpass', '');
}
elseif($config->get('entorno')=='test') {
    //configuracion base de datos
    $config->set('dbhost', 'localhost');
    $config->set('dbname', 'ga000866_pbycortos');
    $config->set('dbuser', 'ga000866_pb');
    $config->set('dbpass', 'foWI82vilu');
}
else {
    //configuracion base de datos
    $config->set('dbhost', 'localhost');
    $config->set('dbname', 'ga000866_pbycortos');
    $config->set('dbuser', 'ga000866_pb');
    $config->set('dbpass', 'foWI82vilu');
}

//configuración metas
$config->set('titulo','');
$config->set('descripcion','');
$config->set('keywords','');
?>
