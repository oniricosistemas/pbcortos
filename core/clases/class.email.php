<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2009 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.1
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name class.utilidades.php
 *
 *
 * Modificaciones realizadas
 * 14/03/2010
 * - Se agrego una llamada a la instancia de la clase mensaje.
 */
class Email {
    private $Config;
    private $Mensajes;

    /**
     * constructor
     *
     * @access public
     * @version 0.1
     * @author Lucas M. Sastre
     *
     */
    public function  __construct() {
        $this->Config = Config::singleton();
        $this->Mensajes = Mensajes::singleton();
    }

    /**
     * Envía un email
     * @param <string> $para
     * @param <string> $nombre
     * @param <string> $asunto
     * @param <string> $de
     * @param <string> $email
     * @param <string> $texto
     * @return <boolean>
     */
    public function enviarEmail($para,$nombre,$asunto,$texto,$de=NULL,$email=NULL,$adjunto=NULL) {

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->Host       = $this->Config->get('host');//"mail.oniricosistemas.com.ar";//"mail.websa100.com";
        $mail->Username   = $this->Config->get('usuario');//"contacto+oniricosistemas.com.ar";//"lucas.sastre+websa100.com";
        $mail->Password   = $this->Config->get('pass');//"f9f803c0";//"lucaswebsa100";
        $mail->Port       = $this->Config->get('puerto');//9026;//25;

        if(!empty($email)) {
            $mail->From       = $email;
        }
        else {
            $mail->From       = $this->Config->get('email');//"info@websa100.com";
        }

        if(!empty($de)) {
            $mail->FromName   = $de;
        }
        else {
            $mail->FromName   = $this->Config->get('nombre');//"Webs@100";
        }
        /*if(!empty($de)) {
            $nombre = $de." (".$email.")";
        }
        else{
            $nombre = "(".$this->Config->get('nombre').")";
        }*/


        //adjunto los archivo si se pasaron alguno
        if(!empty ($adjunto)) {
            for($i=0;$i<count($adjunto);$i++) {
                $mail->AddAttachment($adjunto[$i]['ruta']);      // attachment
            }
        }
        $mail->Subject    = $asunto;
        $mail->AddAddress($para,$nombre);


        $mail->MsgHTML($texto);

        $mail->IsHTML(true); // send as HTML

        if(!$mail->Send()) {
            //$this->Mensajes->agregarMensaje(1,$mail->ErrorInfo,"error");
            return $mail->ErrorInfo;
        } else {
            $respuesta = 1;
            return $respuesta;
        }
    }

}

