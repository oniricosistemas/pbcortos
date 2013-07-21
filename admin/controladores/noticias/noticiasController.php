<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.3
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name noticiasController.php
     */

    class noticiasController extends Controller {
        
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
            $this->modelo(array('noticias','ediciones'));


	}

	/**
	 * index del controlador
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
	    $paginador= $this->Utilidades->paginador($this->Noticias->listarNoticias(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.php',$data);
	}

	/**
	 * Muestra la vista para editar
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarNoticias
	 *
	 * Modificaciones
	 */
	public function editarNoticias() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Noticias->buscarPorPk($_REQUEST['id']);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarNoticias.php',$data);
	}
	

	/**
	 * Muestra la vista para crear
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarNoticias
	 *
	 * Modificaciones
	 */
	public function nuevoNoticias() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Noticias->buscarPorPk($_REQUEST);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarNoticias.php',$data);
	}


	/**
	 * guarda una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarNoticias
	 *
	 * Modificaciones
	 */
	public function guardarNoticias() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $img = $_FILES['imagen'];
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		$this->Vistas->show('editarNoticias.php',$data);
	    }
	    else {
                if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."noticias/not_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(621,297);
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$_REQUEST['imagen'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
                        $ok = 1;
                        $this->Debug->log('entro');
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;
		    }
		}
                if(empty($_REQUEST['imagen'])){
                    $_REQUEST['imagen'] = $_REQUEST['imgant'];
                }
                $_REQUEST['titulo_seo'] = $_REQUEST['titulo'];
                if(empty ($_REQUEST['fecha'])){
                    $_REQUEST['fecha'] = date('Y-m-d');
                }
                $_REQUEST['url_amigable'] = addslashes(strtolower($this->Utilidades->validarNombreArchivo($_REQUEST['titulo'])));
                $this->Noticias->setearCampos($_REQUEST);
		$resultado = $this->Noticias->guardar();
		if($resultado) {
		    $this->Mensajes->agregarMensaje(1,'La noticia se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=noticias');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La noticia no se pudo guardar correctamente.<br/>'.$this->Noticias->error,'error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                    $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		    $this->Vistas->show('editarNoticias.php',$data);
		}
	    }
	}

	/**
	 * borra una noticia
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarNoticias
	 *
	 * Modificaciones
	 */
	public function borrarNoticias() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Noticias->borrarPorPk($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La noticia se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=noticias');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La noticia no se puedo borrar correctamente.<br/>'.$resultado,'error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=noticias');
	    }
	}

	/**
	 * Valida los datos enviados por el formulario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name validarDatosFormulario
	 *
	 * Modificaciones
	 */
	private function validarDatosFormulario($data) {
	    if(empty($data['titulo'])) {
		$mensaje .= 'El titulo de la noticia esta vacío<br/>';
	    }

	    if(empty($data['intro'])) {
		$mensaje .= 'No ha ingresado una texto para la noticia<br/>';
	    }

            if(empty($data['id_edicion'])) {
		$mensaje .= 'No ha ingresado una edición para la noticia<br/>';
	    }
            
            
	    return $mensaje;
	}
    }
?>