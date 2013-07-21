<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<?php
        //$debug->log($_REQUEST);
        ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administración - <? echo ucfirst($_REQUEST['controlador']);?></title>
	<base href="<?php echo $config->get('base').'admin/';?>" />
        <script type="text/javascript">
            <?php
            echo "var baseJs = '".$config->get('base').$config->get('js')."/';";
            echo "var baseUrl = '".$config->get('base')."';";
            ?>
        </script>
	<!-- CSS -->

	<link href="<?php echo $config->get('urlRoot').$config->get('adminViewsFolder').$config->get('cssAdmin');?>transdmin.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php echo $config->get('urlRoot').$config->get('adminViewsFolder').$config->get('cssAdmin');?>jNice.css" rel="stylesheet" type="text/css"/>
        <link type="text/css" href="<? echo $config->get('urlRoot').$config->get('adminViewsFolder').$config->get('cssAdmin');?>smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
	<!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="<? echo $config->get('urlRoot').$config->get('adminViewsFolder').$config->get('cssAdmin');?>ie6.css" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="<? echo $config->get('urlRoot').$config->get('adminViewsFolder').$config->get('cssAdmin');?>ie7.css" /><![endif]-->

	<!-- JavaScripts-->
	<script type="text/javascript" src="<?php echo $config->get('base').$config->get('js');?>/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('base').$config->get('js');?>/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('base').$config->get('js');?>/ui.dialog.js" ></script>
	<script type="text/javascript" src="<?php echo $config->get('base').$config->get('js');?>/ui.core.js" ></script>
	<script type="text/javascript" src="<?php echo $config->get('base').$config->get('js');?>/i18n/ui.datepicker-es.js"></script>
        <script type="text/javascript" src="<?php echo $config->get('base').$config->get('js');?>/punk.js"></script>
        <script type="text/javascript" src="<?php echo $config->get('base').$config->get('js');?>/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<? echo $config->get('urlRoot').$config->get('adminViewsFolder').$config->get('jsAdmin');?>effects.js" ></script>
        <script type="text/javascript" src="<? echo $config->get('urlRoot').$config->get('adminViewsFolder').$config->get('jsAdmin');?>jNice.js"></script>
	<script type="text/javascript" src="<? echo $config->get('urlRoot').$config->get('adminViewsFolder').$config->get('jsAdmin');?>funciones.js" ></script>
        

	<link rel="icon" type="image/x-icon" href="<?php echo $config->get('urlRoot').$config->get('adminViewsFolder');?>images/favicon.ico" />
        <link rel="shortcut icon" href="<?php echo $config->get('urlRoot').$config->get('adminViewsFolder');?>images/favicon.ico" />
    </head>

    <body>
        <div id="dialog-confirm" title="Borrar" style="display: none;">
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">&nbsp;</span>Seguro que quiere eliminar este item?</p>
        </div>
	<div id="preloader" style="display:none;"><div id="mensaje_ajax"><span>&nbsp;</span><p>Cargando... Espere Por Favor</p></div></div>
	<div id="wrapper">

	    <!-- h1 tag stays for the logo, you can use the a tag for linking the index page -->
	    <h1><a href="index.php" class="ajax" title="Inicio"><span><? echo $ubicacion[1]."/".$ubicacion[2];?></span></a></h1>