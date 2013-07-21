<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name class.simpleImage.php
 * 
 */


class SimpleImage {

    private $_image;
    private $_imageType;
    private $_transparent;

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
     * setea si la imagen es con fondo transparente
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name setTransparent
     *
     * @param bolean $bool
     *
     * Modificado:
     *
     */
    public function setTransparent($bool) {
        $this->_transparent = (boolean)$bool;
    }

    /**
     * carga una imagen para obtener su propiedades
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name load
     *
     * @param string $filename
     *
     * Modificado:
     *
     */
    public function load($fileName) {
        ini_set("memory_limit","1024M");
        $imageInfo = getimagesize($fileName);
        $this->_imageType = $imageInfo[2];

        if($this->_imageType == IMAGETYPE_JPEG) {
            $this->_image = imagecreatefromjpeg($fileName);
        }
        elseif($this->_imageType == IMAGETYPE_GIF) {
            $this->_image = imagecreatefromgif($fileName);
        }
        elseif($this->_imageType == IMAGETYPE_PNG) {
            $this->_image = imagecreatefrompng($fileName);
        }
    }

    /**
     * guarda una imagen
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name save
     *
     * @param string $filename
     * @param integer $compression
     * @param integer $permissions
     *
     * Modificado:
     *
     */
    public function save($fileName, $compression=75, $permissions=null) {
        if($this->_imageType == IMAGETYPE_JPEG) {
            imagejpeg($this->_image, $fileName, $compression);
        }
        elseif($this->_imageType == IMAGETYPE_GIF) {
            imagegif($this->_image, $fileName);
        }
        elseif($this->_imageType == IMAGETYPE_PNG) {
            imagepng($this->_image, $fileName);
        }

        if(!is_null($permissions)) {
            chmod($fileName, $permissions);
        }
    }

    /**
     * genera la salida de la image segun su extension
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name output
     *
     * Modificado:
     *
     */
    public function output() {
        if($this->_imageType == IMAGETYPE_JPEG) {
            imagejpeg($this->_image);
        }
        elseif($this->_imageType == IMAGETYPE_GIF) {
            imagegif($this->_image);
        }
        elseif($this->_imageType == IMAGETYPE_PNG) {
            imagepng($this->_image);
        }
    }

    /**
     * recupera el ancho de la imagen
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name getWidth
     *
     * Modificado:
     *
     */
    public function getWidth() {
        return imagesx($this->_image);
    }

    /**
     * recupera el alto de la imagen
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name getHeight
     *
     * Modificado:
     *
     */
    public function getHeight() {
        return imagesy($this->_image);
    }

    /**
     * devuelve el tipo de imagen
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name getImageType
     *
     * Modificado:
     *
     */
    public function getImageType() {
        switch($this->_imageType) {
            case IMAGETYPE_JPEG:
                $imageType = 'image/jpeg';
                break;
            case IMAGETYPE_GIF:
                $imageType = 'image/gif';
                break;
            case IMAGETYPE_PNG:
                $imageType = 'image/png';
                break;
            default:
                $imageType = null;
        }
        return $imageType;
    }

    /**
     * redimenciona segun el alto
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name resizeToHeight
     *
     * @param integer $height
     *
     * Modificado:
     *
     */
    public function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width,$height);
    }

    /**
     * redimenciona segun el ancho
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name resizeToWidth
     *
     * @param integer $width
     *
     * Modificado:
     *
     */
    public function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getHeight() * $ratio;
        $this->resize($width, $height);
    }

    /**
     * escala una imagen segun el valor pasado
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name scale
     *
     * @param integer $scale
     *
     * Modificado:
     *
     */
    public function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getHeight() * $scale /  100;
        $this->resize($width, $height);
    }

    /**
     * no reduce una imagen
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name noResize
     *
     *
     * Modificado:
     *
     */
    public function noResize() {
        $newImage = imagecreatetruecolor($this->getWidth(), $this->getHeight());

        //creo la transprencia para los png y gif
        if($this->getImageType() == 'image/png' && $this->_transparent === true) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage,255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
        }

        imagecopyresampled($newImage, $this->_image, 0, 0, 0, 0, $this->getWidth(), $this->getHeight(), $this->getWidth(), $this->getHeight());
        $this->_image = $newImage;
    }

    /**
     * reduce una imagen
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name resize
     *
     * @param integer $width
     * @param integer $height
     *
     * Modificado:
     *
     */
    public function resize($width, $height) {
        $newImage = imagecreatetruecolor($width, $height);
        if($this->getImageType() == 'image/png' && $this->_transparent === true) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage,255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
        }
        imagecopyresampled($newImage, $this->_image,  0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->_image = $newImage;
    }
}
?>

