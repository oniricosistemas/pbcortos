<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name class.url.php
 */
class Url {
    protected $url;
    protected $tipo;
    protected $leng;
    protected $base;
    protected $parametros;
    private $config;
    public $keyval = array();
    public $uri_string;
    public $segments = array();
    public $rsegments = array();
    private static $instance = null;

    /**
     * Constructor de la clase
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name __contruct
     *
     */
    public function __construct() {
        $this->url = '';
        $this->tipo = '';
        $this->leng = '';
        $this->base = '';
        $this->parametros = '';
        $this->config = Config::singleton();
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
     * setea el lenguaje si la aplicacion es multilenguaje
     * @version 0.2
     * @author Lucas M. sastre
     * @access private
     * @name setLenguaje
     *
     * Modificaciones
     */
    private function setLenguaje() {
        //Si la aplicacion es multilenguaje seteo el lenguaje actual
        if($this->config->get('multi')==1) {
            if(isset($_SESSION['leng']) && !empty($_SESSION['leng'])) {
                $this->leng = $_SESSION['leng'];
            }
        }
    }

    /**
     * setea los parametros de la url
     * @version 0.2
     * @author Lucas M. sastre
     * @access private
     * @name setParametros
     *
     * @param string $param
     *
     * Modificaciones
     */
    private function setParametros($param) {
        //limpio los parametros previos
        $this->parametros = '';
        //extraigo los parametros de la url general
        $valores = explode('index.php?',$param);
        //separo los paremtros ya sea por & o por &amp;
        $amp = explode('&amp;',$valores[1]);
        if(!empty($amp)) {
            $valores = $amp;
        }
        else {
            $valores = explode('&',$valores[1]);
        }

        //recorro los valores y voy armando la url
        foreach ($valores as $key => $val) {
            $segmento =  explode('=',$val);
            //valido si el primer segmento es el del lenguaje
            if($segmento[0]!='leng') {
                //valido si el paremetro es el controlador
                if($key=='controlador') {
                    $this->parametros .= strtolower(preg_replace('/([A-Z])/', '-$1',$segmento[1]))."/";
                }
                //valido si segmento es el de la paginacion
                elseif($segmento[0]=='verPagina') {
                    $this->parametros .= 'Pagina/'.$segmento[1]."/";
                }
                //valido que el segmento sea distinto a id
                elseif($key!='id') {
                    $acentos=array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ");
                    $sinacentos=array("a","e","i","o","u","n","A","E","I","O","U","N");
                    $value=str_replace($acentos,$sinacentos,$segmento[1]);
                    $this->parametros .= preg_replace("@[^A-Za-z0-9-]+@i","-",$value)."/";
                }
            }
        }
    }

    /**
     * crea url amigables a partir de una url no amigable
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name urlAmigables
     *
     * @param string $url
     * @param integer $tipo
     *
     * @return string
     *
     * Modificaciones
     */
    public function urlAmigables($url) {
        $this->url='';
        $config = Config::singleton();
        if($config->get('multi')==1) {
            //valido que la url tendra o no un lenguaje
            $this->setLenguaje();
            if(!empty($this->leng)) {
                $this->url .= $this->leng."/";
            }
        }


        //si es tipo 1 entro a los parametros
        //seteo si hay parametros
        $this->setParametros($url);
        if(!empty($this->parametros)) {
            $this->url .= $this->parametros;
        }

        //elimino posibles dobles barras
        $this->url = preg_replace('/\/$/', '', $this->url).".".$config->get('prefijo');

        return $this->url;

    }

    /**
     * detescta la Uri
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name detectarUri
     *
     * @return string
     *
     * Modificaciones
     */
    public function detectarUri() {
        if ( ! isset($_SERVER['REQUEST_URI'])) {
            return '';
        }

        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        }
        elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }


        if (strncmp($uri, '?/', 2) === 0) {
            $uri = substr($uri, 2);
        }
        $parts = preg_split('#\?#i', $uri, 2);
        $uri = $parts[0];
        if (isset($parts[1])) {
            $_SERVER['QUERY_STRING'] = $parts[1];
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        }
        else {
            $_SERVER['QUERY_STRING'] = '';
            $_GET = array();
        }

        if ($uri == '/' || empty($uri)) {
            return '/';
        }

        $uri = parse_url($uri, PHP_URL_PATH);

        return str_replace(array('//', '../'), '/', trim($uri, '/'));
    }

    /**
     * Ingrese Descripcion
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name fetchUri
     *
     * Modificaciones
     */
    public function fetchUri() {
        $config = Config::singleton();
        if (strtoupper($config->get('uri_protocol')) == 'AUTO') {
            // Let's try the REQUEST_URI first, this will work in most situations
            if ($uri = $this->detectarUri()) {
                return $this->uri_string = $uri;
            }

            // Is there a PATH_INFO variable?
            // Note: some servers seem to have trouble with getenv() so we'll test it two ways
            $path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
            if (trim($path, '/') != '' && $path != "/".SELF) {
                return $this->uri_string = $path;
            }

            // No PATH_INFO?... What about QUERY_STRING?
            $path =  (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
            if (trim($path, '/') != '') {
                return $this->uri_string = $path;
            }

            // As a last ditch effort lets try using the $_GET array
            if (is_array($_GET) && count($_GET) == 1 && trim(key($_GET), '/') != '') {
                return $this->uri_string = key($_GET);
            }

            // We've exhausted all our options...
            return $this->uri_string = '';
        }
        else {
            $uri = strtoupper($this->config->get('uri_protocol'));

            if ($uri == 'REQUEST_URI') {
                $this->uri_string = $this->detectarUri();
                return $this->uri_string;
            }


            return $this->uri_string = (isset($_SERVER[$uri])) ? $_SERVER[$uri] : @getenv($uri);
        }

        // If the URI contains only a slash we'll kill it
        if ($this->uri_string == '/') {
            return $this->uri_string = '';
        }
    }

    /**
     * Filtra la url de caracteres prohibidos
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name filtrarUri
     *
     * @param string $str
     * @return string
     *
     * Modificaciones
     */
    public function filtrarUri($str) {
        if ($str != '' && $this->config->get('permitted_uri_chars') != '' && $this->config->get('enable_query_strings') == FALSE) {
            // preg_quote() in PHP 5.3 escapes -, so the str_replace() and addition of - to preg_quote() is to maintain backwards
            // compatibility as many are unaware of how characters in the permitted_uri_chars will be parsed as a regex pattern
            if ( ! preg_match("|^[".str_replace(array('\\-', '\-'), '-', preg_quote($this->config->get('permitted_uri_chars'), '-'))."]+$|i", $str)) {
                $_SESSION['error'] = 'La URI contiene caractares bloqueados';
                header("Location:error404");
                //show_error('The URI you submitted has disallowed characters.', 400);
            }
        }

        // Convert programatic characters to entities
        $bad	= array('$',		'(',		')',		'%28',		'%29');
        $good	= array('&#36;',	'&#40;',	'&#41;',	'&#40;',	'&#41;');

        return str_replace($bad, $good, $str);
    }


    /**
     * Elimina el sufijo de la url si es necesario
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name removeUrlSuffix
     *
     * @param string $val
     * @return string
     * Modificaciones
     */
    public function removeUrlSuffix($val='') {
        if(empty($val)){
            if  ($this->config->get('prefijo') != "") {
                $this->uri_string = preg_replace("|.".preg_quote($this->config->get('prefijo'))."$|", "", $this->uri_string);
            }
        }
        else{
            if  ($this->config->get('prefijo') != "") {
                return preg_replace("|.".preg_quote($this->config->get('prefijo'))."$|", "", $val);
            }
        }
    }

    /**
     * Hace un explode de los segmentos de la URI
     * y los guarda en el array $this->segments
     *
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name explodeSegments
     *
     * @return array
     *
     * Modificaciones
     */
    public function explodeSegments() {
        foreach (explode("/", preg_replace("|/*(.+?)/*$|", "\\1", $this->uri_string)) as $val) {
            // Filter segments for security
            $val = trim($this->filtrarUri($val));

            if ($val != '') {
                $this->segments[] = $this->removeUrlSuffix($val);
            }
        }
    }


    /**
     * Re-index Segments
     *
     * This function re-indexes the $this->segment array so that it
     * starts at 1 rather than 0.  Doing so makes it simpler to
     * use functions like $this->uri->segment(n) since there is
     * a 1:1 relationship between the segment array and the actual segments.
     *
     * @access	private
     * @return	void
     */
    public function reindexSegments() {
        array_unshift($this->segments, NULL);
        array_unshift($this->rsegments, NULL);
        unset($this->segments[0]);
        unset($this->rsegments[0]);
    }



    /**
     * Fetch a URI Segment
     *
     * This function returns the URI segment based on the number provided.
     *
     * @access	public
     * @param	integer
     * @param	bool
     * @return	string
     */
    public function segment($n, $no_result = FALSE) {
        return ( ! isset($this->segments[$n])) ? $no_result : $this->segments[$n];
    }



    /**
     * Fetch a URI "routed" Segment
     *
     * This function returns the re-routed URI segment (assuming routing rules are used)
     * based on the number provided.  If there is no routing this function returns the
     * same result as $this->segment()
     *
     * @access	public
     * @param	integer
     * @param	bool
     * @return	string
     */
    public function rsegment($n, $no_result = FALSE) {
        return ( ! isset($this->rsegments[$n])) ? $no_result : $this->rsegments[$n];
    }



    /**
     * Generate a key value pair from the URI string
     *
     * This function generates and associative array of URI data starting
     * at the supplied segment. For example, if this is your URI:
     *
     *	example.com/user/search/name/joe/location/UK/gender/male
     *
     * You can use this function to generate an array with this prototype:
     *
     * array (
     *			name => joe
     *			location => UK
     *			gender => male
     *		 )
     *
     * @access	public
     * @param	integer	the starting segment number
     * @param	array	an array of default values
     * @return	array
     */
    public function uriToAssoc($n = 3, $default = array()) {
        return $this->privUriToAssoc($n, $default, 'segment');
    }

    /**
     * Identical to above only it uses the re-routed segment array
     *
     */
    public function ruriToAssoc($n = 3, $default = array()) {
        return $this->privUriToAssoc($n, $default, 'rsegment');
    }



    /**
     * Generate a key value pair from the URI string or Re-routed URI string
     *
     * @access	private
     * @param	integer	the starting segment number
     * @param	array	an array of default values
     * @param	string	which array we should use
     * @return	array
     */
    private function privUriToAssoc($n = 3, $default = array(), $which = 'segment') {
        if ($which == 'segment') {
            $total_segments = 'total_segments';
            $segment_array = 'segment_array';
        }
        else {
            $total_segments = 'total_rsegments';
            $segment_array = 'rsegment_array';
        }

        if ( ! is_numeric($n)) {
            return $default;
        }

        if (isset($this->keyval[$n])) {
            return $this->keyval[$n];
        }

        if ($this->totalSegments() < $n) {
            if (count($default) == 0) {
                return array();
            }

            $retval = array();
            foreach ($default as $val) {
                $retval[$val] = FALSE;
            }
            return $retval;
        }

        $segments = array_slice($this->segmentArray(), ($n - 1));

        $i = 0;
        $lastval = '';
        $retval  = array();
        foreach ($segments as $seg) {
            if ($i % 2) {
                $retval[$lastval] = $seg;
            }
            else {
                $retval[$seg] = FALSE;
                $lastval = $seg;
            }

            $i++;
        }

        if (count($default) > 0) {
            foreach ($default as $val) {
                if ( ! array_key_exists($val, $retval)) {
                    $retval[$val] = FALSE;
                }
            }
        }

        // Cache the array for reuse
        $this->keyval[$n] = $retval;
        return $retval;
    }



    /**
     * Generate a URI string from an associative array
     *
     *
     * @access	public
     * @param	array	an associative array of key/values
     * @return	array
     */
    public function assocToUri($array) {
        $temp = array();
        foreach ((array)$array as $key => $val) {
            $temp[] = $key;
            $temp[] = $val;
        }

        return implode('/', $temp);
    }



    /**
     * Fetch a URI Segment and add a trailing slash
     *
     * @access	public
     * @param	integer
     * @param	string
     * @return	string
     */
    public function slashSegment($n, $where = 'trailing') {
        return $this->privSlashSegment($n, $where, 'segment');
    }



    /**
     * Fetch a URI Segment and add a trailing slash
     *
     * @access	public
     * @param	integer
     * @param	string
     * @return	string
     */
    public function slashRsegment($n, $where = 'trailing') {
        return $this->privSlashSegment($n, $where, 'rsegment');
    }



    /**
     * Fetch a URI Segment and add a trailing slash - helper function
     *
     * @access	private
     * @param	integer
     * @param	string
     * @param	string
     * @return	string
     */
    private function privSlashSegment($n, $where = 'trailing', $which = 'segment') {
        $leading	= '/';
        $trailing	= '/';

        if ($where == 'trailing') {
            $leading	= '';
        }
        elseif ($where == 'leading') {
            $trailing	= '';
        }

        return $leading.$this->$which($n).$trailing;
    }



    /**
     * Segment Array
     *
     * @access	public
     * @return	array
     */
    public function segmentArray() {
        return $this->segments;
    }



    /**
     * Routed Segment Array
     *
     * @access	public
     * @return	array
     */
    public function rsegmentArray() {
        return $this->rsegments;
    }



    /**
     * Total number of segments
     *
     * @access	public
     * @return	integer
     */
    public function totalSegments() {
        return count($this->segments);
    }



    /**
     * Total number of routed segments
     *
     * @access	public
     * @return	integer
     */
    public function totalRsegments() {
        return count($this->rsegments);
    }



    /**
     * Fetch the entire URI string
     *
     * @access	public
     * @return	string
     */
    public function uriString() {
        return $this->uri_string;
    }




    /**
     * Fetch the entire Re-routed URI string
     *
     * @access	public
     * @return	string
     */
    public function ruriString() {
        return '/'.implode('/', $this->rsegmentArray());
    }
}
?>