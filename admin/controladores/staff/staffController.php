<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name staffController.php
     */

    class staffController extends Controller {
	//private $Staff;

	/**
	 * Constructor de la clase
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name __construct
	 *
	 * Modificaciones
	 */
	function __construct() {
	    //llamo al contructor de Controller.php
	    parent::__construct();

	    //instancio el modelo
	    $this->modelo(array('staff','ediciones'));
	}

	/**
	 * muestra el index del controlador
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name index
	 *
	 * Modificaciones
	 */
	public function index() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $paginador= $this->Utilidades->paginador($this->Staff->listarStaff(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.php',$data);
	}

	/**
	 * muestra el formulario para crear una Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaStaff
	 *
	 * Modificaciones
	 */
	public  function nuevaStaff() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarStaff.php',$data);
	}

	/**
	 * muestra el formulario para editar una Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarStaff
	 *
	 * Modificaciones
	 */
	public function editarStaff() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Staff->buscarPorPk($_REQUEST['id']);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarStaff.php',$data);
	}

	

	/**
	 * editar una Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarStaff
	 *
	 * Modificaciones
	 */
	public function guardarStaff() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);	   	    
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		$this->Vistas->show('editarStaff.php',$data);
	    }
	    else {			
		$this->Staff->setearCampos($_REQUEST);
		$resultado = $this->Staff->guardar();
		if($resultado) {
		    $this->Mensajes->agregarMensaje(1,'El Staff se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=staff');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Staff no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                    $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		    $this->Vistas->show('editarStaff.php',$data);
		}
	    }
	}

	/**
	 * borra una Staff
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarStaff
	 *
	 * Modificaciones
	 */
	public function borrarStaff() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Staff->borrarPorPk($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'El Staff se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=staff');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'El Staff no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=staff');
	    }
	}

	/**
	 * valida los datos del formulario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name validarDatosFormulario
	 *
	 * @param array $data
	 * @return string
	 *
	 * Modificaciones
	 */
	private function validarDatosFormulario($data) {
	    if(empty($data['nombre'])) {
		$mensaje.='El nombr del Staff esta vacío<br/>';
	    }
	    if(empty($data['cargo'])) {
		$mensaje.='El cargo del Staff esta vacío<br/>';
	    }
            if(empty($data['id_edicion'])) {
		$mensaje .= 'No ha ingresado una edición para el staff<br/>';
	    }
	    
	    return $mensaje;
	}
    }

?>