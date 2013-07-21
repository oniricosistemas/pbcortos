<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
	$time = round(microtime(), 3);
        $conf = new ConfiguracionSitio();
        $configuracion = $conf->listarConfiguracion();
	$seo= new Seo();
        $metasSeo=$seo->metasSeo($_REQUEST);
        ?>
        <base href="<?php echo $config->get('base');?>pbycortos5/"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link type="text/css" rel="stylesheet" media="screen" href="<?php echo $config->get('viewsFolder');?>css/style.css" />
	<link type="text/css" rel="stylesheet" media="screen" href="<?php echo $config->get('viewsFolder');?>css/colorbox.css" />
	<!--[if IE 6]>
	<script src="<?php echo $config->get('viewsFolder');?>js/pngfix.js"></script>
	<script>

	  DD_belatedPNG.fix('div, img');

	</script>
	<![endif]-->


	<script type="text/javascript" src="<?php echo $config->get('viewsFolder');?>js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('viewsFolder');?>js/jquery.colorbox.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('viewsFolder');?>js/funciones.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('viewsFolder');?>js/swfobject.js"></script>

        <meta name="description" content="<?php if(!empty($metas->desc_seo)){echo $metas->desc_seo;}elseif(!empty($noticia->keys_seo)){echo $noticia->desc_seo;}else{echo $configuracion[0]['descripcion'];}?>" />
        <meta name="keywords" content="<?php if(!empty($metas->key_seo)){echo $metas->key_seo;}elseif(!empty($noticia->keys_seo)){echo $noticia->keys_seo;}else{echo $configuracion[0]['keywords'];}?>"/>

        <meta name="google-site-verification" content="_2Sum8g_zSa6eVp2Ofnm_gAosghDSe-7FWeoM31IfuI" />
        <meta name="language" content="es" />
        <meta http-equiv="Content-Language" content="es" />
        <meta name="revisit-after" content="7 days" />
        <meta name="robot" content="Index,Follow" />
        <meta name="robot" content="All" />
        <meta name="Distribution" content="Global" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta name="rating" content="general" />

        <meta name="author" http-equiv="Author" content="On&iacute;rico Sistemas - www.oniricosistemas.com"/>
        <meta name="copyright" content="Copyright On&iacute;rico Sistemas - www.oniricosistemas.com" />
        <meta name="generator" content="Framework Punk PHP <?php echo $config->get('version');?>" />

        <link rel="icon" type="image/x-icon" href="<?php echo $config->get('viewsFolder');?>images/favicon.ico" />
        <link rel="shortcut icon" href="<?php echo $config->get('viewsFolder');?>images/favicon.ico" />



        <title>
            Pizza, Birra y Cortos 5
	    <?php
	    /*if(!empty($metas->titulo_seo)){
	    echo $metas->titulo_seo;}else{echo $configuracion[0]['titulo'];
	    }*/

	    if(!empty($_REQUEST['controlador']) && $_REQUEST['controlador']!='secciones'){
		echo "- ".$_REQUEST['controlador'];
	    }
	    if($noticia->titulo_seo){
		echo "- ".$noticia->titulo_seo;
	    }
	    elseif($_REQUEST['controlador']=='secciones'){
		echo " - ".$seccion->titulo;
	    }
	    ?>
	</title>
	
    </head>

    <body>	
	<div id="container">

	    <div id="header">

		<div id="flash-header">
		    &nbsp;

		</div> <!-- End flash-header -->

		<ul id="menu">
		    <li><a href="index.php" <?php if($_REQUEST['controlador']=='index'){?>class="active"<?}?>>Inicio</a></li>
		    <li><a href="index.php?controlador=secciones&amp;id=1" <?php if($_REQUEST['controlador']=='bases-y-condiciones'){?>class="active"<?}?>>Bases y Condiciones</a></li>
		    <li><a href="jurado.php" <?php if($_REQUEST['controlador']=='jurado'){?>class="active"<?}?>>Jurado</a></li>
		    <li><a href="invitados.php" <?php if($_REQUEST['controlador']=='invitados'){?>class="active"<?}?>>Invitados Especiales</a></li>

		    <li><a href="ediciones.php" <?php if($_REQUEST['controlador']=='ediciones'){?>class="active"<?}?>>Ediciones anteriores</a></li>
		    <li><a href="prensa.php" <?php if($_REQUEST['controlador']=='prensa'){?>class="active"<?}?>>Prensa</a></li>
		    <li><a href="staff.php" <?php if($_REQUEST['controlador']=='staff'){?>class="active"<?}?>>Staff</a></li>
		    <!--<li><a href="contacto.php" <?php if($_REQUEST['controlador']=='contacto'){?>class="active"<?}?>>Contacto</a></li>-->
		</ul><!-- End menu -->

	    </div><!-- End header -->

	    <div id="content">


