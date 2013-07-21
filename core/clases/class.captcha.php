<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name /punk/core/clases/class.captcha.php
 * @example
 * <code>
 * $this->Captcha->confCaptcha('codigos',$this->Config->get('root').$this->Config->get('librerias').'words/es.php');
 * $this->Captcha->confCaptcha('fondos',$this->Config->get('root').$this->Config->get('librerias'));
 * $this->Captcha->confCaptcha('multiple',true);
 * $this->Captcha->confCaptcha('lineas',false);
 * $this->Captcha->confCaptcha('filtro',false);
 * $this->Captcha->confCaptcha('nlineas',0);
 * $this->Captcha->confCaptcha('dificultad',5);
 * $this->Captcha->confCaptcha('clineas',false);
 * $this->Captcha->generaCaptcha();
 * </code>
 *
 */
class Captcha {

    public $codigo;
    private $refCodigos;
    private $refFondos;
    private $refFuentes;
    private $fuentes = array();
    private $refFiltro = true;
    private $refColor = array(0, 0, 0);
    private $refTamano = 25;
    private $refLineas = true;
    private $refGradoDificultad = 8;
    private $refNLineas = 20;
    private $refCLineas = false;
    private $refLongitud = 6;
    private $refCaracteres = array();
    private $fondo;
    private $texto;
    private $ancho;
    private $alto;
    private $captcha;
    private $multiple;
    private $Session;

    /**
     * Constructor de la clase
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name __contruct
     *
     */
    public function __construct() {
        $this->Session = new Session();
    }

    /**
     * checkea si hay una session
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name checkSession
     *
     * @return boolean
     *
     * Modificado:
     *
     */
    public function checkSession() {
        if(!isset($_SESSION)) {
            @session_start();
            return false;
        }
        return true;
    }

    /**
     * genera el captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name generaCaptcha
     *
     * @param boolean $nuevo
     * @return boolean
     *
     * Modificado:
     *
     */
    public function generaCaptcha($nuevo = true) {

        if(empty($this->codigo)) {
            if($nuevo == false and !$this->Session->get('phpcaptcha_codigo')) {/*$_SESSION['phpcaptcha_codigo']*/
                $this->codigo = $this->Session->get('phpcaptcha_codigo');//$_SESSION['phpcaptcha_codigo'];
            } else {
                $this->generarCodigo();
            }
        }
        $this->guardaCaptcha($this->codigo);
        $this->generarFondo();
        if($this->refLineas == true) {
            $this->generarLineas();
        }
        $this->generarTexto();
        $this->captcha = imagecreatetruecolor($this->ancho, $this->alto);
        imagecopyresampled($this->captcha, $this->fondo, 0, 0, 0, 0, $this->ancho, $this->alto, $this->ancho, $this->alto);
        imagecopymerge($this->captcha, $this->texto, 0, 0, 0, 0, $this->ancho, $this->alto, 60);
        return true;
    }

    /**
     * verifica el captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name verificaCaptcha
     *
     * @param string $nuevo
     * @param boolean $mayus
     * @return boolean
     *
     * Modificado:
     *
     */
    public function verificaCaptcha($codigo, $mayus = false) {
        session_start();
        $sc = ($mayus == true) ? $this->Session->get('phpcaptcha_codigo')/*$_SESSION['phpcaptcha_codigo']*/ : strtolower($this->Session->get('phpcaptcha_codigo')/*$_SESSION['phpcaptcha_codigo']*/);
        $vc = ($mayus == true) ? $codigo : strtolower($codigo);
        if(!empty($sc) and $sc == $vc) {
            $this->Session->del('phpcaptcha_codigo');
            return true;
        }
        return false;
    }

    /**
     * guarda en código captcha en session
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name guardaCaptcha
     *
     * @param string $codigo
     * @return session
     *
     * Modificado:
     *
     */
    private function guardaCaptcha($codigo) {
        $this->Session->set('phpcaptcha_codigo',$codigo);
        return $this->Session->get('phpcaptcha_codigo');//$_SESSION['phpcaptcha_codigo'] = $this->codigo;
    }

    /**
     * muestra el captcha generado
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name muestraCaptcha
     *
     * @return image
     *
     * Modificado:
     *
     */
    public function muestraCaptcha() {        
        $config = Config::singleton();
        imagejpeg($this->captcha, $config->get('imagenes').'captcha.jpg', 70);
        $img = '<img src="'.$config->get('urlImagenes').'captcha.jpg" alt=" " />';
        return $img;        
    }

    /**
     * configuracion de opciones del captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Public
     * @name confCaptcha
     *
     * @param string $p
     * @param strin $v
     *
     * @return boolean
     *
     * Modificado:
     *
     */
    public function confCaptcha($p, $v) {
        switch(strtolower($p)):
            case "codigos": $this->refCodigos = $v;
                break;
            case "multiple": $this->multiple = ($v != false) ? true : false;
                break;
            case "fondos": $this->refFondos = $v;
                break;
            case "fuentes": $this->refFuentes = $v;
                break;
            case "dificultad": $this->refGradoDificultad = ((int)$v >= 1 and (int)$v <= 40) ? (int)$v : $this->refGradoDificultad;
                break;
            case "filtro": $this->refFiltro = ($v != false) ? true : false;
                break;
            case "lineas": $this->refLineas = ($v != false) ? true : false;
                break;
            case "nlineas": $this->refNLineas = ((int)$v >= 1) ? (int)$v : $this->refNLineas;
                break;
            case "clineas": $this->refCLineas = ($v != false) ? true : false;
                break;
            case "color": $this->refColor = ($c = $this->rgbhex2rgb($v)) ? $c : array(0,0,0);
                break;
            case "tamaño": $this->refTamano = (int)$v;
                break;
            case "ancho": $this->ancho = (int)$v;
                break;
            case "alto": $this->alto = (int)$v;
                break;
            case "longitud": $this->refLongitud = ((int)$v >= 1) ? (int)$v : $this->refLongitud;
                break;
            case "caracteres": if(is_array($v)) $this->confCaptcha("caracteres",implode("",$v)); else $this->refCaracteres = str_split($v);
                break;
            default: return false;
                break;
            endswitch;
        return true;
    }

    /**
     * devuelve el codigo generado del captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name generarCodigo
     *
     *
     * @return string
     *
     * Modificado:
     *
     */
    private function generarCodigo() {
        if(!empty($this->refCodigos) and file_exists($this->refCodigos)) {
            return $this->codigo = $this->generarCodigoArchivo();
        }
        return $this->codigo = $this->generarCodigoAleatorio();
    }

    /**
     * genera un codigo aleatorio para el captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name generarCodigoAleatorio
     *
     *
     * @return string
     *
     * Modificado:
     *
     */
    private function generarCodigoAleatorio() {
        $caracteres = (count($this->refCaracteres) < 1) ? array_merge(range('a', 'z'), range(0, 9)) : $this->refCaracteres;
        $n = count($caracteres);
        $codigo = '';
        while (strlen($codigo) < $this->refLongitud) {
            $codigo .= $caracteres[mt_rand(0, $n-1)];
        }
        return $codigo;
    }

    /**
     * genera el codigo del captcha a partir de un archivo
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name generarCodigoArchivo
     *
     * @return string
     *
     * Modificado:
     *
     */
    private function generarCodigoArchivo() {
        $codigo = file($this->refCodigos);
        if($this->multiple) {
            $codigo1 = trim($codigo[mt_rand(0,25300)]);
            $codigo = trim($codigo[mt_rand(0,25300)])." ".$codigo1;
        }
        else {
            $codigo = trim($codigo[array_rand($codigo)]);
        }
        return !empty($codigo) ? $codigo : $this->generarCodigoAleatorio();
    }

    /**
     * genera el fondo del captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name generarFondo
     *
     *
     * @return void
     *
     * Modificado:
     *
     */
    private function generarFondo() {
        $this->ancho = ($this->ancho > 1) ? $this->ancho : 210;
        $this->alto = ($this->alto > 1) ? $this->alto : 70;

        if(!empty($this->refFondos) and is_dir($this->refFondos)) {
            $res = opendir($this->refFondos);
            $imagenes = array();
            while($archivo = readdir($res)) {
                if(!in_array(pathinfo($archivo, PATHINFO_EXTENSION), array("gif", "jpg", "png"))) {
                    continue;
                }
                $imagenes[] = $this->refFondos.'/'.$archivo;
            }
            closedir($res);
        }
        if(count($imagenes) < 1) {
            $rs = imagecreate($this->ancho, $this->alto);
            imagecolorallocate($rs, 255, 255, 255);
        } else {
            $aleat = $imagenes[array_rand($imagenes)];
            $info = getimagesize($aleat);

            $bg = null;

            switch ($info[2]):
                case 1: $bg = imagecreatefromgif($aleat);
                    break;
                case 2: $bg = imagecreatefromjpeg($aleat);
                    break;
                case 3: $bg = imagecreatefrompng($aleat);
                    break;
                endswitch;

            $bg = imagerotate($bg,90*rand(1,4),-1);

            $rs = imagecreatetruecolor($this->ancho, $this->alto);

            imagecopyresampled($rs, $bg, 0, 0, 0, 0, $this->ancho, $this->alto, imagesx($bg), imagesy($bg));
        }

        return $this->fondo = ($this->refFiltro == true) ? $this->aplicarFiltro($rs) : $rs;
    }

    /**
     * genera lineas al captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name generarLineas
     *
     *
     * @return void
     *
     * Modificado:
     *
     */
    private function generarLineas() {
        for ($i = 0; $i < $this->refNLineas; $i++) {
            if($this->refCLineas != true) {
                $c = mt_rand(70, 250);
                $clinea = imagecolorallocate($this->fondo, $c, $c, $c);
            } else {
                $clinea = imagecolorallocate($this->fondo, mt_rand(80, 250), mt_rand(80, 250), mt_rand(80, 250));
            }
            imageline($this->fondo, mt_rand(0, $this->ancho), mt_rand(0, $this->alto), mt_rand(0, $this->ancho), mt_rand(0, $this->alto), $clinea);
        }
        return;
    }

    /**
     * aplica filtro al captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name aplicarFiltro
     *
     * @param integer $rs
     * @param integer $ligero
     *
     * @return void
     *
     * Modificado:
     *
     */
    private function aplicarFiltro($rs, $ligero = 0) {
        $extra = ($ligero == 1) ? (((int)$this->refGradoDificultad > 1) ? (int)$this->refGradoDificultad : 9 ) : rand(20, 30);
        $rsf = imagecreatetruecolor($this->ancho+$extra, $this->alto+$extra);
        $dstH = $this->ancho;
        $srcH = $this->ancho - 2 * $extra;
        $h = rand(5, 10);
        for ($i = 0; $i < $this->ancho; $i++) {
            $a = (sin(deg2rad(2*$i*$h))+sin(deg2rad($i*$h))) * 1.1;
            imagecopyresized($rsf, $rs, $i, 0, $i, 0, $extra+$i, $dstH+$extra*$a, $extra+$i, $srcH);
        }
        return $rsf;
    }

    /**
     * genera el texto del captcha
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name generarTexto
     * 
     *
     * @return string
     *
     * Modificado:
     *
     */
    private function generarTexto() {
        $t = imagecreatetruecolor($this->ancho, $this->alto);

        $fcolor = ($this->refColor[0] == 255 and $this->refColor[1] == 255 and $this->refColor[2] == 255) ? imagecolorallocate($t, 0, 0, 0) : imagecolorallocate($t, 255, 255, 255);

        imagefill($t, 0, 0, $fcolor);

        $tcolor = imagecolorallocate($t, $this->refColor[0], $this->refColor[1], $this->refColor[2]);

        if(!empty($this->refFuentes) and is_dir($this->refFuentes)) {

            $res = opendir($this->refFuentes);
            $fuentes = array();
            while($archivo = readdir($res)) {
                if(!in_array(pathinfo($archivo, PATHINFO_EXTENSION), array("ttf"))) {
                    continue;
                }
                $fuentes[] = $this->refFuentes.'/'.$archivo;
            }
            closedir($res);

            $this->fuentes = $fuentes;

            $x = 15;

            for ($i = 0; $i < strlen($this->codigo); $i++) {
                imagettftext($t, $this->refTamano, rand(-30, 30), $x, $this->refTamano+rand(5, 25), $tcolor, $this->fuenteAleatoria(), $this->codigo{$i});
                $x += $this->refTamano + 6;
            }

        } else {
            $tfont = rand(3,5);
            $tancho = imagefontwidth($tfont) * strlen($this->codigo);
            $talto = imagefontheight($tfont);
            $margen = $tancho * 0.3 + 5;
            $ttexto = imagecreatetruecolor($tancho + $margen, $talto + $margen);

            imagefill($ttexto, 0, 0, $fcolor); // For GD2+

            $tx = $margen / 2;
            $ty = $margen / 2;

            imagestring($ttexto, $tfont, $tx, $ty, $this->codigo, $tcolor);

            imagecopyresampled($t, $ttexto, 0, 0, 0, 0, $this->ancho, $this->alto, $tancho+$margen, $talto+$margen);
        }

        if ($this->refFiltro) {
            $t = $this->aplicarFiltro($t, 0);
        }

        imagecolortransparent($t, $fcolor);

        return $this->texto = $t;

    }

    /**
     * selecciona aleatoriamente un fuente
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name fuenteAleatoria
     *     
     *
     * @return string
     *
     * Modificado:
     *
     */
    private function fuenteAleatoria() {
        return $this->fuentes[array_rand($this->fuentes)];
    }

    /**
     * transforma de rgb, hex a rgb
     *
     * @version 0.1
     * @author Lucas M. Sastre
     * @access Private
     * @name rgbhex2rgb
     *
     * @param string $c
     *
     * @return string
     *
     * Modificado:
     *
     */
    private function rgbhex2rgb($c) {
        if(!$c) return false;
        $c = trim($c);
        $out = array();
        if(eregi("^[0-9ABCDEFabcdef\#]+$", $c)) {
            $c = str_replace('#','', $c);
            $l = strlen($c);
            if($l != 3 and $l != 6) return false;
            $out[0] = $out['r'] = ($l == 3) ? hexdec(substr($c,0,1).substr($c,0,1)) : hexdec(substr($c,0,2));
            $out[1] = $out['g'] = ($l == 3) ? hexdec(substr($c,1,1).substr($c,1,1)) : hexdec(substr($c,2,2));
            $out[2] = $out['b'] = ($l == 3) ? hexdec(substr($c,2,1).substr($c,2,1)) : hexdec(substr($c,4,2));
        } elseif (eregi("^[0-9]+(,| |.)+[0-9]+(,| |.)+[0-9]+$", $c)) {
            if(eregi(",", $c)) $e = explode(",",$c);
            elseif(eregi(" ", $c)) $e = explode(" ",$c);
            elseif(eregi(".", $c)) $e = explode(".",$c);
            else return false;
            if(count($e) != 3) return false;
            if(is_numeric($e[0]) and $e[0] >= 0 and $e[0] <= 255)
                $out[0] = $out['r'] = intval($e[0]);
            if(is_numeric($e[1]) and $e[1] >= 0 and $e[1] <= 255)
                $out[1] = $out['g'] = intval($e[1]);
            if(is_numeric($e[2]) and $e[2] >= 0 and $e[2] <= 255)
                $out[2] = $out['b'] = intval($e[2]);
        }
        return (count($out) != 6) ? false : $out;
    }

}
?>