<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 */
class configuracionController extends Controller {

    /**
     * Constructor de la clase para instanciar los modelos
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name __contruct
     *
     */
    function __construct() {
        //llamo al consructor de Controller.php
        parent::__construct();
        //creo una instancia de los modelos
        $this->modelo(array('configuracionSitio'));

    }

    /**
     * Index del controlador
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name index
     *
     */
    public function index() {
        $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
        $datos = $this->validarDatos($this->ConfiguracionSitio->buscarTodos());

        if(!$datos) {
            $data['datos'] = $this->validarDatos($this->ConfiguracionSitio->buscarTodos());
        }
        else {
            $data['datos'] = $datos;
        }
        $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
        if($this->Session->get('mensaje')) {
            $data['mensaje'] = $this->Session->get('mensaje');
            $this->Session->del('mensaje');
        }
        $this->Vistas->show('index.php',$data);
    }

    /**
     * Muestra el formulario de edición
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name editar
     *
     */
    public function editarConfiguracion() {
        $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
        $data['datos'] = $this->validarDatos($this->ConfiguracionSitio->buscarTodos());
        $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
        $this->Vistas->show('editar.php',$data);
    }

    /**
     * Guarda los cambios realizados
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name guardar
     *
     */
    public function guardarConfiguracion() {
        $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
        $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
        $datos = $this->validarFormulario($_REQUEST);
        $datos['activo'] = $_REQUEST['activo'];
        $datos['construccion'] = $_REQUEST['construccion'];


        $this->ConfiguracionSitio->setearCampos($datos);
        $resultado = $this->ConfiguracionSitio->guardar();
        if($resultado==true) {
            $this->Mensajes->agregarMensaje(1,'La configuración se guardo correctamente','ok');
            $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());

            //$this->Vistas->show('index.php',$data);
            $this->Utilidades->redirect('index.php?controlador=configuracion');
        }
        else {
            $this->Mensajes->agregarMensaje(1,'La configuración no se puedo guardar correctamente '.$this->ConfiguracionSitio->error,'error');
            $this->Mensajes->agregarMensaje(1,$resultado,'error');
            $data['mensaje'] = $this->Mensajes->mostrarMensaje();
            $data['datos'] = $_REQUEST;
            $this->Vistas->show('editar.php',$data);
        }
    }

    /**
     * Valida los datos que se envian desde el formulario
     * @version 0.1
     * @author Lucas M. sastre
     * @access private
     * @name validarFormulario
     *
     */
    private function validarFormulario($data) {
        $config = Config::singleton();
        if(empty($data['id'])) {
            $dato['id'] = 1;
        }
        else{
            $dato['id'] = $data['id'];
        }

        if(empty($data['titulo'])) {
            $dato['titulo'] = $config->get('titulo');
        }
        else {
            $dato['titulo'] = $data['titulo'];
        }
        if(empty($data['descripcion'])) {
            $dato['descripcion'] = $config->get('descripcion');
        }
        else {
            $dato['descripcion'] = $data['descripcion'];
        }
        if(empty($data['keywords'])) {
            $dato['keywords'] = $config->get('keywords');
        }
        else {
            $keyword=explode(',',$data['keywords']);
            for($i=0;$i<count($keyword);$i++) {
                if($i<(count($keyword)-1)) {
                    $keywords .= trim($keyword[$i]).",";
                }
                else {
                    $keywords .= trim($keyword[$i]);
                }
            }
            $dato['keywords'] = $keywords;
        }
        if(empty($data['email'])) {
            $dato['email'] = $config->get('email');
        }
        else {
            $dato['email'] = $data['email'];
        }
        if(empty($data['useremail'])) {
            $dato['user_email'] = $config->get('usuario');
        }
        else {
            $dato['user_email'] = $data['user_email'];
        }
        if(empty($data['pass_email'])) {
            $dato['pass_email'] = $config->get('pass');
        }
        else {
            $dato['pass_email'] = $data['pass_email'];
        }
        if(empty($data['port_email'])) {
            $dato['port_email'] = $config->get('puerto');
        }
        else {
            $dato['port_email'] = $data['port_email'];
        }
        if(empty($data['host_email'])) {
            $dato['host_email'] = $config->get('host');
        }
        else {
            $dato['host_email'] = $data['host_email'];
        }
               
        return $dato;
    }

    /**
     * Valida si los datos que se pasan estan vacios, si estan vacios muestra los del archivo de configuracion
     * @version 0.1
     * @author Lucas M. sastre
     * @access private
     * @name validarDatos
     *
     */
    private function validarDatos($data) {
        $config = Config::singleton();
        if(empty($data['id'])) {
            $datos['id'] = 1;
        }
        if(empty($data[0]['titulo'])) {
            $datos['titulo'] = $config->get('titulo');
        }
        else {
            $datos['titulo'] =$data[0]['titulo'];
        }
        if(empty($data[0]['descripcion'])) {
            $datos['descripcion'] = $config->get('descripcion');
        }
        else {
            $datos['descripcion'] = $data[0]['descripcion'];
        }
        if(empty($data[0]['keywords'])) {
            $datos['keywords'] = $config->get('keywords');
        }
        else {
            $datos['keywords'] = $data[0]['keywords'];
        }
        if(empty($data[0]['email'])) {
            $datos['email'] = $config->get('email');
        }
        else {
            $datos['email'] = $data[0]['email'];
        }
        if(empty($data[0]['user_email'])) {
            $datos['user_email'] = $config->get('usuario');
        }
        else {
            $datos['user_email'] = $data[0]['user_email'];
        }
        if(empty($data[0]['pass_email'])) {
            $datos['pass_email'] = $config->get('pass');
        }
        else {
            $datos['pass_email'] = $data[0]['pass_email'];
        }
        if(empty($data[0]['port_email'])) {
            $datos['port_email'] = $config->get('puerto');
        }
        else {
            $datos['port_email'] = $data[0]['port_email'];
        }
        if(empty($data[0]['host_email'])) {
            $datos['host_email'] = $config->get('host');
        }
        else {
            $datos['host_email'] = $data[0]['host_email'];
        }
        $datos['activo'] = $data[0]['activo'];
        $datos['construccion'] = $data[0]['construccion'];

        return $datos;
    }
}
?>
