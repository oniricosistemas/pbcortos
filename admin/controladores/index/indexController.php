<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name indexController.php
 */

class indexController extends Controller {

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
        $this->modelo(array('usuarios','logAccesos'));

    }

    /**
     * Funcion index que controla si el admin esta logueado o no
     *
     * @version 0.2
     * @author Lucas M. Sastre
     * @access Public
     * @name index
     *
     * Modificado:
     * 02-08-2010
     *
     */
    public function index() {
        if(!$this->Session->get('admin'.$this->Config->get('app'))) {
            //$this->Session->del('phpcaptcha_codigo');
            //$this->Session->del('captcha');
            if($this->Session->get('mensaje')!=''){
                $data['mensaje']['mensaje']=$this->Session->get('mensaje');
                $data['mensaje']['tipo']=$this->Session->get('tipo');
                $this->Session->del('mensaje');
                $this->Session->del('tipo');
            }
            else{
                $data['mensaje']['mensaje']="No estas logueado";
                $data['mensaje']['tipo']="attention";
            }
            $data['captcha'] = $this->Codigo();;
            $this->Vistas->show('login.php',$data);
        }
        else {
            $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $this->Vistas->show('index.php',$data);
        }
    }

    /**
     * realiza el login
     * @version 0.3
     * @author Lucas M. sastre
     * @access public
     * @name login
     *
     * Modificado:
     * 31-12-2009
     * 06-05-2010
     * 02-08-2010
     * 21-08-2010
     *
     */
    public function login() {
        $validacion = $this->validarFormulario($_REQUEST);
        if(!empty($validacion)) {
            $data['captcha'] = $this->Codigo();
            $this->Session->set('mensaje',$validacion);
            $this->Session->set('tipo','fail');
            //$this->Vistas->show('login.php',$data);
             $this->Utilidades->redirect('index.php');
        }
        else {
            if($_REQUEST['captcha2'] == $_REQUEST['captcha']) {
                if($this->Usuarios->login($_REQUEST)) {
                    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
                    // guardo en session en el nombre de usuario
                    $data['usuario']=$_REQUEST['username'];
                    //hashcordeo el nombre para la session admin
                    $hash = $this->Utilidades->crearPassword(3,'a');
                    $nombre = $_REQUEST['username'].$hash;
                    $this->Session->set('admin'.$this->Config->get('app'),$nombre);
                    //busco el usuario logueado
                    $user = $this->Usuarios->BuscarUsuarios($_REQUEST);

                    //seteo las variable de session
                    $this->Session->set('nombre',$user->nombre);
                    $this->Session->set('user_id',$user->id);
                    $this->Session->set('superadmin',$user->superadmin);
                    //guardo el log de acceso
                    $_REQUEST['ip'] = $_SERVER['REMOTE_ADDR'];
                    $_REQUEST['fecha'] = date('Y-m-d H:i:s');
                    
                    $this->LogAccesos->setearCampos($_REQUEST);
                    $this->LogAccesos->guardar();
                    $_REQUEST['id'] = $user->id;
                    $this->validarAdmin($_REQUEST);
                    $this->Utilidades->redirect('index.php');
                }
                else {
                    /*$data['mensaje']['tipo'] = "fail";
                    $data['mensaje']['mensaje'] = "Nombre de usuario / contraseña incorrecto<br/>";
                    $data['captcha'] = $this->Codigo();
                    $this->Vistas->show('login.php',$data);*/
                    $this->Session->set('mensaje','Nombre de usuario / contraseña incorrecto<br/>');
                    $this->Session->set('tipo','fail');
                    $this->Utilidades->redirect('index.php');
                }
            }
        }

    }

    /**
     * Valida los datos del formulario
     * @version 0.1
     * @author Lucas M. sastre
     * @access private
     * @name validaFormulario
     *
     */
    private function validarFormulario($data) {
        $this->Session->del('mensaje');
        $this->Session->del('tipo');

        if($_REQUEST['username']=='username' || $_REQUEST['username']=='') {
            $mensaje.="No ha ingresado ningún nombre de usuario<br/>";
        }
        if($_REQUEST['password']=='' || $_REQUEST['password']=='password') {
            $mensaje.="no ha ingresado ningún password<br/>";
        }
        if($_REQUEST['captcha']=='') {
            $mensaje.="No ha ingresado el código de seguridad.<br/>";
        }
        if($_REQUEST['captcha2']!=$_REQUEST['captcha'] && $_REQUEST['captcha']!='') {
            $mensaje.="El código de seguridad es incorrecto.<br/>";
        }

        return $mensaje;
    }

    /**
     * Sale de la administracion
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name salir
     *
     */
    public function salir() {
        if($this->Session->get('user_id')!='admin') {
            $this->Session->del('admin'.$this->Config->get('app'));
            $this->Session->del('user_id');
            $this->Session->del('nivel');
            $this->Session->del('superadmin');
            $this->Session->del('phpcaptcha_codigo');
            $this->Session->del('captcha');
            $this->Session->del('mensaje');
            $this->Session->del('tipo');
        }
        $this->Utilidades->redirect('index.php');
    }

    /**
     * crea el codigo se seguridad
     * @version 0.1
     * @author Lucas M. sastre
     * @access public
     * @name codigo
     *
     * @return void;
     *
     */
    private function Codigo() {
        $this->Captcha->confCaptcha('codigos',$this->Utilidades->crearPassword(6,'a'));//$this->Config->get('root').$this->Config->get('librerias').'words/es.php');
        $this->Captcha->confCaptcha('fondos',$this->Config->get('root').$this->Config->get('librerias').'/backgrounds/');
        $this->Captcha->confCaptcha('multiple',true);
        $this->Captcha->confCaptcha('lineas',false);
        $this->Captcha->confCaptcha('filtro',false);
        $this->Captcha->confCaptcha('nlineas',0);
        $this->Captcha->confCaptcha('dificultad',5);
        $this->Captcha->confCaptcha('clineas',false);
        $this->Captcha->generaCaptcha();
        return $this->Captcha->muestraCaptcha();
    }
}
?>