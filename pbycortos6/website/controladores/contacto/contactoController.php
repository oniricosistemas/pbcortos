<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name contactoController.php
     */
    session_start();
    class contactoController extends Controller {
	private $Configuracion;
	private $Secciones;

	/**
	 * Constructor de la clase
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access
	 * @name
	 *
	 * Modificaciones
	 */
	function __construct() {
	    parent::__construct();
	    $this->Configuracion = new ConfiguracionSitio();
	    $this->Secciones = new Secciones();
	}
	
	public function index() {
	    $data['seccion'] = $this->Secciones->datosSeccion('Contacto');
	    $this->Vistas->show('index.html',$data);

	}

	public function enviar() {
	    $configuracion = $this->Configuracion->listarConfiguracion();
	    $data['seccion'] = $this->Secciones->datosSeccion('Contacto');
	    $errores = $this->validarDatosFormulario($_REQUEST);
	    $data['form'] = $this->Utilidades->arrayObjeto($_REQUEST);
	    if(count($errores)!=0) {
		$data['aError'] = $errores;
		$data['aErrorMsj']="Por favor, complete los campos marcados en rojo y vuelva a enviar el formulario.";
		$this->Vistas->show('index.html',$data);
	    }
	    else {
		$mensaje ="";
		$mensaje .= "<h1>Mensaje de Contacto</h1>\n";
		$mensaje .= "Enviado por: ".$_REQUEST['nombre']."\n <br/>";
		$mensaje .= "Fue enviado el: ".date("d-m-Y")."\n <br/>";
		if(!empty($_REQUEST['ciudad'])) {
		    $mensaje .= "Ciudad/Provincia: \n <br/>".$_REQUEST['ciudad']."\n <br/>";
		}
		if(!empty($_REQUEST['tel'])) {
		    $mensaje .= "Telefono: \n <br/>".$_REQUEST['tel']."\n <br/>";
		}
		if(!empty($_REQUEST['email'])) {
		    $mensaje .= "Email: \n <br/>".$_REQUEST['email']."\n <br/>";
		}

		if(!empty($_REQUEST['comentario'])) {
		    $mensaje .= "Comentario: \n <br/>".$_REQUEST['comentario']."\n <br/>";
		}
		
		$envio = $this->Email->enviarEmail($configuracion[0]['email'],$_REQUEST['nombre'],'Nuevo mensaje de Contacto',$mensaje);		
		if(!is_numeric($envio)) {
		    $msj="El email no se pudo enviar correctamente. ".$envio;
		    $data['aErrorMsj'] = $msj."<br/>".$envio;
		    $this->Session->del('mensaje');
		    $this->Vistas->show('index.html',$data);
		}
		else {
		    $msj="Gracias por contactarnos. En breve nos pondremos en contacto con usted.";
		    unset($data['form']);
		    $data['aErrorMsj'] = $msj;
		    $this->Vistas->show('index.html',$data);
		}
	    }
	}

	private function validarDatosFormulario($data) {

	    if(empty($data['nombre'])) {
		$error['nombre']='1';
	    }

	    if(empty($data['ciudad'])) {
		$error['ciudad']='1';
	    }

	    if(empty($data['email'])) {
		$error['email']='1';
	    }

	    if(!empty($data['email']) && !$this->Utilidades->validar_mail($data['email'])) {
		$error['email']='1';
	    }

	    if(empty($data['tel'])) {
		$error['tel']='1';
	    }

	    if(empty($data['comentario'])) {
		$error['comentario']='1';
	    }
	    return $error;
	}
    }
?>