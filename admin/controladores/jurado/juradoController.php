<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name juradoController.php
     */

    class juradoController extends Controller {
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
            $this->modelo(array('jurado','ediciones'));


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
	    $paginador= $this->Utilidades->paginador($this->Jurado->listarJurado(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.php',$data);
	}

	/**
	 * muestra el formulario para crear una Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name nuevaJurado
	 *
	 * Modificaciones
	 */
	public  function nuevaJurado() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarJurado.php',$data);
	}

	/**
	 * muestra el formulario para editar una Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarJurado
	 *
	 * Modificaciones
	 */
	public function editarJurado() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Jurado->buscarPorPk($_REQUEST['id']);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarJurado.php',$data);
	}
	
	/**
	 * editar una Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarJurado
	 *
	 * Modificaciones
	 */
	public function guardarJurado() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    $img = $_FILES['foto'];
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarJurado.php',$data);
	    }
	    else {
		if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."jurado/ju_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(99,99);
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$_REQUEST['foto'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;
		    }

		}		
		$_REQUEST['foto'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
		$this->Jurado->setearCampos($_REQUEST);
		$resultado = $this->Jurado->guardar();
		if($resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Jurado se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=jurado');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Jurado no se puedo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                    $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		    $this->Vistas->show('editarJurado.php',$data);
		}
	    }
	}

	/**
	 * borra una Jurado
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarJurado
	 *
	 * Modificaciones
	 */
	public function borrarJurado() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Jurado->borrarPorPk($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La Jurado se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=jurado');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La Jurado no se puedo borrar correctamente.','error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=jurado');
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
		$mensaje.='El nombre del Jurado esta vacío<br/>';
	    }
	    if(empty($data['intro'])) {
		$mensaje.='La introducción del Jurado esta vacía<br/>';
	    }
	    if(empty($data['id_edicion'])) {
		$mensaje .= 'No ha ingresado una edición para la noticia<br/>';
	    }

	    return $mensaje;
	}
    }

?>