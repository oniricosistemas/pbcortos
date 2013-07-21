<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name class.errores.php
*/

class Errores  {
	
	private static $instance=null;

	/**
	* Constructor de la clase
	* @version 0.1
	* @author Lucas M. sastre
	* @access public
	* @name __contruct
	*
	*/
	public function __construct(){
		
	}
	
	/**
	* Manejador de errores
	* @version 0.1
	* @author Lucas M. sastre
	* @access public
	* @name error_handler
	*
	* @param integer $ip
	* @param integer $show_user
	* @param integer $show_developer
	* @param string $email
	* @param string $log_file
	* 
	* @example 
	* include("/home/username/global/class.errores.php");
	* $handler = new error_handler("127.0.0.1",1,6,NULL,'/home/username/global/error_logs/test.com.txt');
	* set_error_handler(array(&$handler, "handler"));    
	*/
	public function error_handler($ip=0, $show_user=1, $show_developer=1, $email=NULL, $log_file=NULL,$db_save=1)
	{
		$this->ip = $ip;
		$this->show_user = $show_user;
		$this->show_developer = $show_developer;
		$this->email = mysql_escape_string($email);
		$this->log_file = $log_file;
		$this->log_message = NULL;
		$this->email_sent = false;
		$this->db_save = $db_save;

		$this->error_codes =  E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR;
		$this->warning_codes =  E_WARNING | E_CORE_WARNING | E_COMPILE_WARNING | E_USER_WARNING;

		//associate error codes with errno...
		$this->error_names = array('E_ERROR','E_WARNING','E_PARSE','E_NOTICE','E_CORE_ERROR','E_CORE_WARNING',
		'E_COMPILE_ERROR','E_COMPILE_WARNING','E_USER_ERROR','E_USER_WARNING',
		'E_USER_NOTICE','E_STRICT','E_RECOVERABLE_ERROR');

		for($i=0,$j=1,$num=count($this->error_names); $i<$num; $i++,$j=$j*2)
		$this->error_numbers[$j] = $this->error_names[$i];
	}

	
	/**
	* error handling function
	* @version 0.1
	* @author Lucas M. sastre
	* @access public
	* @name handler
	* 
	* @param  $errno
	* @param  $errstr
	* @param  $errfile
	* @param  $errline
	* @param  $errcontext
	* 
	* @return true
	*
	*/
	public function handler($errno, $errstr, $errfile, $errline, $errcontext)
	{
		$this->errno = $errno;
		$this->errstr = $errstr;
		$this->errfile = $errfile;
		$this->errline = $errline;
		$this->errcontext = $errcontext;

		if($this->log_file)
		$this->log_error_msg();

		if($this->email)
		$this->send_error_msg();

		if($this->show_user)
		$this->error_msg_basic();

		if($this->show_developer && preg_match("/^$this->ip$/i", $_SERVER['REMOTE_ADDR'])) //REMOTE_ADDR : HTTP_X_FORWARDED_FOR
		$this->error_msg_detailed();

		/* Don't execute PHP internal error handler */
		return true;
	}


	
	/**
	* error reporting functions
	* @version 0.1
	* @author Lucas M. sastre
	* @access private
	* @name error_msg_basic
	*
	* @return string
	*/
	private function error_msg_basic()
	{
		$message = NULL;
		if($this->errno & $this->error_codes) $message .= "<b> ERROR: </ b> Ha habido un error en el código.";
		if($this->errno & $this->warning_codes) $message .= "<b> ADVERTENCIA: </ b> Ha habido un error en el código.";

		if($message) $message .= ($this->email_sent)?" El desarrollador ha sido notificado.<br />\n":"<br />\n";
		echo $message;
	}

	/**
	* muestra el detalle del error
	* @version 0.1
	* @author Lucas M. sastre
	* @access private
	* @name error_msg_detailed
	* 
	* @return string
	*/
	private function error_msg_detailed()
	{
		//settings for error display...
		$silent = (2 & $this->show_developer)?true:false;
		$context = (4 & $this->show_developer)?true:false;
		$backtrace = (8 & $this->show_developer)?true:false;

		switch(true)
		{
			case (16 & $this->show_developer): $color='white'; break;
			case (32 & $this->show_developer): $color='black'; break;
			default: $color='red';
		}

		$message =  ($silent)?"<!--\n":'';
		$message .= "<pre style='color:$color;'>\n\n";
		$message .= "archivo: ".print_r( $this->errfile, true)."\n";
		$message .= "linea: ".print_r( $this->errline, true)."\n\n";
		$message .= "código: ".print_r( $this->error_numbers[$this->errno], true)."\n";
		$message .= "mensaje: ".print_r( $this->errstr, true)."\n\n";
		$message .= ($context)?"contexto: ".print_r( $this->errcontext, true)."\n\n":'';
		$message .= ($backtrace)?"backtrace: ".print_r( debug_backtrace(), true)."\n\n":'';
		$message .= "</pre>\n";
		$message .= ($silent)?"-->\n\n":'';

		echo $message;
	}

	/**
	* envia el mensaje de error
	* @version 0.1
	* @author Lucas M. sastre
	* @access private
	* @name send_error_msg
	*
	*/
	private function send_error_msg()
	{
		$message = "archivo: ".print_r( $this->errfile, true)."\n";
		$message .= "linea: ".print_r( $this->errline, true)."\n\n";
		$message .= "código: ".print_r( $this->error_numbers[$this->errno], true)."\n";
		$message .= "mensaje: ".print_r( $this->errstr, true)."\n\n";
		$message .= "log: ".print_r( $this->log_message, true)."\n\n";
		$message .= "contexto: ".print_r( $this->errcontext, true)."\n\n";
		//$message .= "backtrace: ".print_r( $this->debug_backtrace(), true)."\n\n";

		$this->email_sent = false;
		if(mail($this->email, 'Error: '.$this->errcontext['SERVER_NAME'].$this->errcontext['REQUEST_URI'], $message, "From: error@".$this->errcontext['HTTP_HOST']."\r\n"))
		$this->email_sent = true;
	}

	/**
	* guarda los errores en el archivo de log
	* @version 0.1
	* @author Lucas M. sastre
	* @access private
	* @name log_error_msg
	*
	*/
	private function log_error_msg()
	{
		$message =  "fecha: ".date("j M y - g:i:s A (T)", mktime())."\n";
		$message .= "archivo: ".print_r( $this->errfile, true)."\n";
		$message .= "linea: ".print_r( $this->errline, true)."\n\n";
		$message .= "código: ".print_r( $this->error_numbers[$this->errno], true)."\n";
		$message .= "mensaje: ".print_r( $this->errstr, true)."\n";
		$message .= "##################################################\n\n";

		if (!$fp = fopen($this->log_file, 'a+'))
		$this->log_message = "No se puede abrir / crear el archivo: $this->log_file para log error."; $log_error = true;

		if (!fwrite($fp, $message))
		$this->log_message = "No es posible registro de errores para el archivo: $this->log_file. Error de Escritura."; $log_error = true;

		if(!$this->log_message)
		$this->log_message = "Error al registrar en el archivo: $this->log_file.";

		fclose($fp);
	}
	
	
	/**
	* Creo el patron Singleton
	* @version 0.1
	* @author Lucas M. sastre
	* @access public
	* @name Singleton
	* Mon Dec 28 23:48:23 ART 2009
	*
	* @return instan
	*/
	
	public static function singleton()
	{
		if( self::$instance == null ) {
			self::$instance = new self($ip=0, $show_user=1, $show_developer=1, $email=NULL, $log_file=NULL,$db_save=1);
		}

		return self::$instance;
	}
}
?>