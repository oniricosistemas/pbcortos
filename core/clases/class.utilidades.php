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

/**
 * Modificaciones realizadas
 * 05/01/2010
 * - se agregaron los metodos arrayAObjeto y objetoAArray
 *
 * 28/02/2010
 * - se agrego el método singleton a la clase para poder ser instanciada desde
 * cualquier lugar dle framework.
 *
 * 07/03/2010
 * - se agrego el método para cortar textos.
 *
 * 30/03/2010
 * - se agrego al método recursiveInclude que evite los directorios .svn
 *
 * 15/08/2010
 * - se modifico el método para cortar textos.
 *
 * 20/08/2010
 * - se agrego el método para crear los links para ordernar los resultados de una tabla
 * - se agrego el método para devolver los nombre del código de errror.
 *
 * 06/09/2010
 * - se modifico el método recursiveInclude para que cargue correctamente los archivos
 * del path pasados como parametros cuando un sistema tiene multiple aplicaciones
 *
 * * 18/01/12
 * - se agrego un nuevo formato de fecha en el método cambiarFecha
 *
 * 19/01/2012
 * - se soluciono un bug que habia en la paginación
 */

class Utilidades {
    private $tamano;
    private $tipo;
    private $fecha;
    private $formato;
    private $nombre;
    private $email;
    private $dFecIni;
    private $dFecFin;
    private $url;
    private $target;
    private $date;
    private $path;
    private $sql;
    private $items;
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
     * Creo el patron Singleton
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @return instance
     */
    public static function singleton() {
        if( self::$instance == null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Crea constraseñas al azar
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @param integer $tamano
     * @param string $tipo
     * @return string
     */
    public function crearPassword($tamano,$tipo) {
        switch ($tipo) {
            case 'a':
                $chars = "abcdefghijkmnopqrstuvwxyz023456789";
                break;
            case 'n':
                $chars = "023456789";
                break;
            case 'c':
                $chars = "abcdefghijkmnopqrstuvwxyz";
                break;
        }

        srand((double)microtime()*1000000);
        $i = 0;
        $codigo = '' ;
        while ($i <= $tamano) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $codigo = $codigo . $tmp;
            $i++;
        }
        return $codigo;
    }

    /**
     * cambia la fecha en mumeros a texto
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @param date $fecha
     * @param integer $formato
     * @return date
     */
    public function cambiarFecha($fecha,$formato=0) {
        setlocale(LC_TIME, "es_MX", "mex", "spanish-mexican", "esm");
        switch ($formato) {
            case 0:
                $fecha=strftime('%A %d de %B %Y - %H:%M hs',strtotime($fecha));
                break;

            case 1:
                $fecha=strftime('%A %d de %B %Y',strtotime($fecha));
                break;

            case 2:
                $fecha=strftime('%d de %B %Y',strtotime($fecha));
                break;

            case 3:
                $fecha=ucfirst(strftime('%B - %Y',strtotime($fecha)));
                break;
            case 4:
                $fecha=ucfirst(strftime('%d/%m/%Y',strtotime($fecha)));
                break;
        }

        //$muestra = iconv("ISO-8859-1", "UTF-8", $fecha);
        $muestra=str_replace('Ã©','é',$muestra);
        $muestra=str_replace('Ã¡','á',$muestra);
        return htmlentities($fecha);
    }

    /**
     * devuelve un nombre de archivo/directorio valido
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @param string $nombre
     * @return string
     */
    public function validarNombreCarpeta($nombre) {
        $acentos=array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ");
        $sinacentos=array("a","e","i","o","u","n","A","E","I","O","U","N");
        $value=str_replace($acentos,$sinacentos,$nombre);
        $value = preg_replace("@[^A-Za-z0-9\-]+@i","_",$value);

        return $value;
    }

    /**
     * devuelve un nombre de archivo/directorio valido
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @param string $nombre
     * @return string
     */
    public function validarNombreArchivo($nombre) {
        $acentos=array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ");
        $sinacentos=array("a","e","i","o","u","n","A","E","I","O","U","N");
        $value=str_replace($acentos,$sinacentos,$nombre);
        $value = preg_replace("@[^A-Za-z0-9\-\.]+@i","_",$value);

        return $value;
    }


    /**
     * valida un mail
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @param string $email
     * @return boolean
     */
    public function validar_mail($email) {
        if (eregi ( "^[a-z0-9\._-]+" . "@{1}" . "([a-z0-9]{1}[a-z0-9-]*[a-z0-9]{1}\.{1})+" . "([a-z]+\.){0,1}" . "([a-z]+){1}$", $email )) {
            return true;
        }
        return false;

    }

    /**
     * devulve la diferencia entre dos fechas
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @param date $dFecIni
     * @param date $dFecFin
     * @return integer
     */
    public function restaFechas($dFecIni, $dFecFin) {

        $s = strtotime($dFecIni)-strtotime($dFecFin);
        $d = intval($s/86400);
        $s -= $d*86400;
        $h = intval($s/3600);
        $s -= $h*3600;
        $m = intval($s/60);
        $s -= $m*60;

        $fecha= $d;

        return $fecha;
    }

    /**
     * Devuelve la referencia http
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @return string
     */
    public function httpReferencia() {
        $ref= getenv("HTTP_REFERER");

        return $ref;
    }

    /**
     * Redirecciona a una url
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @param string $url
     * @param string $target
     */
    public function redirect($url='', $target='_self') {
        $url = (!empty($url)) ? $url : 'index.php';
        echo "<script>window.open('".$url."', '".$target."');</script>";
        die();
    }

    /**
     * Valida si es una fecha
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access public
     * @param string $date
     * @return string
     */
    public function isFecha($date) {
        if ( strlen($date) < 10 ) return 0;
        $f1	= substr($date,2,1);
        $f2	= substr($date,5,1);
        if ( ($f1 != "-") || ($f2 != "-") ) return 0;
        list ($d,$m,$a) = explode("-",$date);
        return checkdate($m, $d, $a);
    }

    /**
     * funcion para cargar recursivamente clases.
     * @version 0.2
     * @author Lucas M. sastre
     *
     * @access  public
     * @param string $path
     */
    public function recursiveInclude($path) {
        $config = Config::singleton();
        if(!empty($path)) {
            $dir	= scandir($path);
            if ( (is_array($dir)) && (count($dir) > 0) )
                foreach($dir as $k => $v)
                    if ( !(is_dir($path.$v)) && ( file_exists($path.$v) ) && ($v != ".")  && ($v != "..") && (strtolower(end(explode(".", $v))) == 'php') )
                        include_once($path.$v);
                    elseif ( is_dir($path.$v) && ($v != ".") && ($v != "..") && ($v != 'smarty') && ($v != '.svn'))
                        recursiveInclude($path.$v."/");
        }
    }

    /**
     * crea una paginacion
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @access  public
     * @param string $sql
     * @param integer $items
     * @return paginacion
     *
     */
    public function paginador($sql,$items,$ajax=null,$frontend=null) {
        $config = Config::singleton();
        // Instanciamos el objeto
        $paging = new PHPPaging ( );

        // Indicamos la consulta al objeto
        $paging->agregarConsulta($sql);

        // Poniendo 20 resultados por pagina
        $paging->porPagina($items);

        //estableciendo si es paginador del frontend o admin
        $paging->frontEnd($frontend);

        //estableciendo si muestro el efecto de cargando
        $paging->ajax($ajax);

        // Estableciendo las paginas adyacentes
        $paging->paginasAntes(4, 5, 10);
        $paging->paginasDespues(4, 5, 10);

        // Estableciando el estilo de la clase
        $paging->linkClase('nav');

        // Estableciendo el separador general
        $paging->linkSeparador(false); //Significa que no habrá separacion

        // Separador especial
        $paging->linkSeparadorEspecial('...');

        //seteo si hay que mostrar los textos en varios lenguajes
        if(($config->get('multi')==1 && $frontend==0) || $config->get('lenguaje')!='es') {
            $lenguaje = Language::singleton();
            $leng = $lenguaje->language_convert();
            // Personalizando el link siguiente
            $paging->mostrarSiguiente($leng['siguiente']);
            // Personalizando el link anterior
            $paging->mostrarAnterior($leng['anterior']);
            // Personalizando el titulo de los links
            $paging->linkTitulo($leng['linktitulo']);
        }


        // Cambiando el texto hacia la primera y ultima paginas
        $paging->mostrarPrimera("|<", true);
        $paging->mostrarUltima(">|", true);

        // Quitando el link hacia las paginas anterior y siguiente
        $paging->mostrarAnterior(true);
        $paging->mostrarSiguiente(true);

        // Cambiando el texto de la referencia a la página actual
        $paging->mostrarActual("<span class=\"navthis\">{n}</span>");

        // Cambiando el nombre de la variable
        if(($config->get('multi')==1 && $frontend==0) || $config->get('lenguaje')!='es') {
            $pagina = $leng['pagina'];
            $paging->nombreVariable($pagina);
        }
        else{
            $paging->nombreVariable('pagina');
        }

        $config = Config::singleton();
        if($config->get('entorno')=="dev") {
            $paging->modo('desarrollo');
        }

        // Ejecutamos la Paginación
        $paging->ejecutar();


        return $paging;
    }

    /**
     * function que valida si tiene acceso a un ara del sitio
     * @version 0.1
     * @author Lucas M. sastre
     * @deprecated
     * @param string $nombre
     */
    /*public  function validar($nombre) {
	    if(empty($nombre)) {
		$this->redirect('index.php');
	    }
	}*/

    /**
     * convierte un objeto en arreglo
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @param object $object
     * @return array
     */
    public function objetoArray($object) {
        if(is_array($object) || is_object($object)) {
            $array = array();
            foreach($object as $key => $value) {
                $array[$key] = $this->objetoArray($value);
            }
            return $array;
        }
        return $object;
    }

    /**
     * concierte un arreglo en objeto
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @param array $arrelgo
     * @return object
     */
    public function arrayObjeto($arreglo) {
        return (object) $arreglo;
    }

    /**
     * corta el texto en x caracteres sin perder el cierre de los tags html
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @param <string> $text
     * @param <integer> $length
     * @param <array> $options
     * @return <string>
     */
    function cortarTexto($text, $length = 100, $options = array()) {
        $default = array(
                'ending' => '...', 'exact' => true, 'html' => false
        );
        $options = array_merge($default, $options);
        extract($options);

        if ($html) {
            if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            $totalLength = mb_strlen(strip_tags($ending));
            $openTags = array();
            $truncate = '';

            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag) {
                if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                        array_unshift($openTags, $tag[2]);
                    } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];

                $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
                if ($contentLength + $totalLength > $length) {
                    $left = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entitiesLength <= $left) {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0]);
                            } else {
                                break;
                            }
                        }
                    }

                    $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                    break;
                } else {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length) {
                    break;
                }
            }
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
            }
        }
        if (!$exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                if ($html) {
                    $bits = mb_substr($truncate, $spacepos);
                    preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                    if (!empty($droppedTags)) {
                        foreach ($droppedTags as $closingTag) {
                            if (!in_array($closingTag[1], $openTags)) {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    }
                }
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
        $truncate .= $ending;

        if ($html) {
            foreach ($openTags as $tag) {
                $truncate .= '</'.$tag.'>';
            }
        }

        return $truncate;


    }

    /**
     * Devuelve el link para hacer un ordenamiento de los resultado en una tabla
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @param <string> $url
     * @param <string> $valores
     * @param <string> $campo
     * @return <string>
     */
    public function linkOrdenar($url,$valores,$campo=null) {
        $link['url'] = $url;//'index.php?controlador=logAccesos&amp;order=nombre&amp;';
        if($valores['orden']=='desc') {
            $param .= '&amp;orden=asc';
            $link['icon'] = 'down';
            $link['por'] = "descendente";
        }
        else {
            $param .= '&amp;orden=desc';
            $link['icon'] = 'up';
            $link['por'] = "ascendente";
        }
        if(!empty($campo)) {
            if($valores['order']==$campo) {
                $link['seleccion'] = $campo;
                //$link['url'] .= '&amp;order='.trim($campo);
            }
            else {
                $param = '&amp;orden=desc';
                $link['icon'] = 'down';
                $link['por'] = "descendente";
            }
        }

        $link['url'] .= $param;

        return $link;
    }

    /**
     * Devuelve el nombre del error
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @param <string> $error
     * @return <string>
     */
    public function valorError($error) {
        switch ($error) {
            case '1':
                $valor = 'E_ERROR';
                break;
            case '2':
                $valor = 'E_WARNING';
                break;
            case '4':
                $valor = 'E_PARSE';
                break;
            case '8':
                $valor = 'E_NOTICE';
                break;
            case '16':
                $valor = 'E_CORE_ERROR';
                break;
            case '32':
                $valor = 'E_CORE_WARNING ';
                break;
            case '64':
                $valor = 'E_COMPILE_ERROR';
                break;
            case '128':
                $valor = 'E_COMPILE_WARNING';
                break;
            case '256':
                $valor = 'E_USER_ERROR';
                break;
            case '512':
                $valor = 'E_USER_WARNING ';
                break;
            case '1024':
                $valor = 'E_USER_NOTICE';
                break;
            case '2048':
                $valor = 'E_STRICT';
                break;
            case '4096':
                $valor = 'E_RECOVERABLE_ERROR ';
                break;
            case '8192':
                $valor = 'E_DEPRECATED';
                break;
            case '16384':
                $valor = 'E_USER_DEPRECATED';
                break;
            case '30719':
                $valor = 'E_ALL';
                break;
        }

        return $valor;
    }

    /**
     * Devuelve el formato en byte de un numero
     * @version 0.1
     * @author Lucas M. sastre
     *
     * @param <string> $error
     * @return <string>
     */
    public function byte_format($num, $precision = 1) {

        if ($num >= 1000000000000) {
            $num = round($num / 1099511627776, $precision);
            $unit = 'TB';
        }
        elseif ($num >= 1000000000) {
            $num = round($num / 1073741824, $precision);
            $unit = 'GB';
        }
        elseif ($num >= 1000000) {
            $num = round($num / 1048576, $precision);
            $unit = 'MB';
        }
        elseif ($num >= 1000) {
            $num = round($num / 1024, $precision);
            $unit = 'KB';
        }
        else {
            $unit = 'Bytes';
            return number_format($num).' '.$unit;
        }

        return number_format($num, $precision).' '.$unit;
    }

}
?>