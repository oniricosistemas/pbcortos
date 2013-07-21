<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            @charset "utf-8";
            /* ----------------------------
		BASIC STYLES
            ------------------------------- */

            /*Change your font here */
            body 					{
                background-color: #EAEAEA;
                font-family: Arial, Helvetica, sans-serif;
            }
            h1,h2,h3,h4,h5,h6		{ color: #333333;}

            p 		{ font-size: 12px;padding: 0px;line-height: 24px;margin-top: 0px;margin-right: 0px;margin-bottom: 12px;margin-left: 0px;color: #666666;}

            ol 		{ list-style-type: lower-roman;}
            dt 		{ font-weight: bold;text-decoration: underline;font-size: 14px;margin-top: 5px;margin-bottom: 5px;}
            dd 		{
                font-size: 12px;
                color: #666666;
                padding-top: 5px;
                padding-right: 0px;
                padding-bottom: 10px;
                padding-left: 10px;
                margin-top: 0px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 10px;
            }
            #admin_wrapper {
                width: 450px;
                margin-top: 50px;
                margin-right: auto;
                margin-bottom: 10px;
                margin-left: auto;
                background-color: #FFFFFF;
                border: 10px solid #d6d6d6;
                padding-top: 15px;
                padding-right: 30px;
                padding-bottom: 15px;
                padding-left: 30px;
            }
            #admin_wrapper h1 	{ font-size: 28px;padding-bottom: 10px;}




            /* ----------------------------
		NOTIFICATIONS
            ------------------------------- */
            .success, .fail, .information, .attention {
                margin-top: 10px;
                margin-bottom: 10px;
                background-repeat: no-repeat;
                background-position: 10px center;
                padding-top: 10px;
                padding-right: 10px;
                padding-bottom: 10px;
                padding-left: 60px;
                font-size: 12px;
                height: auto;
                font-weight: bold;
                line-height: 30px;
            }

            .success 				{ background-color: #D5FFCF; border: 1px solid #97FF88; color: #009900; background-image: url(<?php echo $config->get('urlRoot').'/'.$config->get('adminViewsFolder');?>images/accept.png);}
            .fail 					{ background-color: #FFCFCF;border: 1px solid #FF9595;color: #CC3300; background-image: url<?php echo $config->get('urlRoot').'/'.$config->get('adminViewsFolder');?>images/delete.png);}
            .information 			{ background-color: #DCE3FF;border: 1px solid #93A8FF;color: #0033FF; background-image: url(<?php echo $config->get('urlRoot').'/'.$config->get('adminViewsFolder');?>images/information.png);}
            .attention 				{ background-color: #FFFBCC;border: 1px solid #FFF35E;color: #C69E00; background-image: url(<?php echo $config->get('urlRoot').'/'.$config->get('adminViewsFolder');?>images/warning.png);}

            .close-notification					{
                width: 16px;
                height: 16px;
                position: absolute;
                background: url(<?php echo $config->get('urlRoot').'/'.$config->get('adminViewsFolder');?>images/close.png) no-repeat;
                top: 5px;
                right: 5px;
                cursor: pointer;
            }

            .even					{
                background-color: #EAEAEA;
            }


            /* ----------------------------
		FORMS
            ------------------------------- */
            .small			{ width: 15%;}
            .medium 		{ width: 35%;}
            .large			{ width: 75%;}
            .full			{width: 98%;}


            form  label 	{
                font-weight: bold;
                font-size: 13px;
                margin-bottom: 12px;
                display: block;
                margin-top: 12px;
            }

            form p 			{
                padding: 0px;
                margin: 0px;
            }

            form .input {
                margin-top: 0px;
                margin-right: 10px;
                margin-bottom: 0px;
                margin-left: 0px;
                border: 1px solid #CCCCCC;
                padding: 7px;
                background-color: #F3F3F3;

            }
            form select {
                padding: 0px;
                margin: 0px;
            }

            form .button	{
                background-color: #D6D6D6;
                color: #666666;
                font-weight: bold;
                border: 1px solid #CCCCCC;
                margin-top: 7px;
                margin-bottom: 7px;
                padding-top: 5px;
                padding-right: 10px;
                padding-bottom: 5px;
                padding-left: 10px;
            }

            form .checkbox {
                padding: 0px;
                height: 15px;
                width: 18px;
                margin-top: 0px;
                margin-right: 5px;
                margin-bottom: 0px;
                margin-left: 5px;
            }
            form .select	{
                width: 20%;
                padding: 2px;
                margin: 0px;
            }
            form .radio		{
                height: 15px;
                width: 15px;
                padding: 0px;
                margin-top: 0px;
                margin-right: 5px;
                margin-bottom: 0px;
                margin-left: 5px;
            }
            .styled_textarea				{
                border: 1px solid #d6d6d6;
                padding: 3px;
                margin-bottom: 10px;
                background-color: #F3F3F3;
            }
            input:focus, textarea:focus		{
                background-color: #FFFFCC;
                border: 1px solid #999999;
            }
        </style>

        <title>Administración</title>
    </head>

    <body>

        <!-- START ADMIN WRAPPER -->
        <div id="admin_wrapper">
            <h1>Ingreso Administración</h1>

            <p>Bienvenido. Para iniciar sesión complete el formulario.</p>

            <?php
            if($mensaje['mensaje']!='') {?>
            <div class="<? echo $mensaje['tipo'];?>"><? echo $mensaje['mensaje'];?></div>
                <?php
            }
            else {?>
            <div class="<? echo $mensaje['tipo'];?>"><? echo $mensaje['mensaje'];?></div>
                <?php
            }
            ?>

            <form action="index.php?controlador=index&amp;accion=login" method="post">
                <p><label>Nombre de Usuario</label>
                    <input name="username" type="text" class="input large" value="username" />
                </p>

                <p><label>Contraseña</label>
                    <input name="password" type="password" class="input large" value="password" />

                </p>
                <p><label>código de Seguridad</label>
                <!--<img src="../librerias/captcha.php" width="100" height="30" alt="código de Seguridad"/>-->
                    <?php echo $captcha;?>
                    <input type="hidden" name="captcha2" value="<?php echo $_SESSION['phpcaptcha_codigo'];?>"/>
                </p>

                <p><br/><input type="text" value="" class="input large" name="captcha"/>
                </p>


                <p><input type="submit" name="Submit" id="button" value="Ingresar"  class="button"/></p>
            </form>
        </div>
        <!-- END ADMIN WRAPPER -->

    </body>
</html>