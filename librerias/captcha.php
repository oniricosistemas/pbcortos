<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name captcha.php
* 
* @example :
* 	  <p>
* 		<label>código de Seguridad</label>
*	  	<img src="../librerias/captcha.php" width="100" height="30" alt="código de Seguridad"/>
* 	  </p>
*	  <p>
* 		<br/>
* 		<input type="text" value="" class="input large" name="captcha"/>
*	  </p>
*/
	
	/**
	 * @name : randomText.
	 * @since 0.1
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @param string $length.	 
	 * @return devuelve el texto aleatorio.
	 */
	function randomText($length) {
		$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
		for($i=0;$i<$length;$i++) {
			$key .= $pattern{mt_rand(0,35)};
		}
		return $key;
	}
	session_start();
	$_SESSION['captcha'] = randomText(4);
	$captcha = imagecreatefromgif("bgcaptcha.gif");
	$colText = imagecolorallocate($captcha, 0, 0, 0);
	imagestring($captcha, 5, 16, 7, $_SESSION['captcha'], $colText);

	header("Content-type: image/gif");
	imagegif($captcha);

?>