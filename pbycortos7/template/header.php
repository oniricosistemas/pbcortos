<!doctype html>
  <?php
      include($config->get('root') . 'helpers/seo_helper.php');
      include($config->get('root') . 'helpers/general_helper.php');
      $seo = seo($datos);
      $destacadas = destacada(7);
  ?>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $seo['lenguaje']; ?>" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <base href="<?php echo $config->get('base');?>"/>

  <title><?php echo $seo['titulo'];?></title>
  <meta name="description" content="<?php echo $seo['descripcion'];?>" />
  <meta name="keywords" content="<?php echo $seo['keywords']; ?>"/>

  <meta name="google-site-verification" content="_2Sum8g_zSa6eVp2Ofnm_gAosghDSe-7FWeoM31IfuI" />
  <meta name="language" content="<?php echo $seo['lenguaje']; ?>" />
  <meta http-equiv="Content-Language" content="<?php echo $seo['lenguaje']; ?>" />
  <meta name="revisit-after" content="7 days" />
  <meta name="robot" content="Index,Follow" />
  <meta name="robot" content="All" />
  <meta name="Distribution" content="Global" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta name="rating" content="general" />

  <meta name="author" http-equiv="Author" content="<?php echo $config->get('autor'); ?>"/>
  <meta name="copyright" content="Copyright Onírico Sistemas - www.oniricosistemas.com" />
  <meta name="generator" content="Framework Punk PHP <?php echo $config->get('version'); ?>" />
  
  <link rel="icon" type="image/x-icon" href="<?php echo $config->get('viewsFolder');?>images/favicon.ico" />
  <link rel="shortcut icon" href="<?php echo $config->get('viewsFolder');?>images/favicon.png" type="image/x-icon" />


  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <!-- <link rel="stylesheet" href="css/minified.css"> -->

  <!-- CSS imports non-minified for staging, minify before moving to production-->
  <link rel="stylesheet" href="<?php echo $config->get('viewsFolder');?>css/imports.css">
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="<?php echo $config->get('viewsFolder');?>js/libs/modernizr-2.0.6.min.js"></script>
  <script type="text/javascript" src="<?php echo $config->get('viewsFolder');?>js/swfobject.js"></script>
</head>

<body>

  <div class="container">
      <header>
          <div class="row">
              <div class="twelve columns head">
                  <div class="eleven columns centered">
                      <img src="<?php echo $config->get('viewsFolder');?>images/auspiciantes.jpg" alt="Auspiciantes"/>
                  </div>
                  <div class="nine columns centered">
                      <h1 class="logo">
                        <a href="index.php" title="Pizza, Birra y Cortos 7ma Edición">Pizza, Birra y Cortos 7ma Edición</a>
                      </h1>
                  </div>
              </div>
          </div>
          <nav>
            <div class="row">
                <div class="twelve columns menu">
                    <ul>
                        <li><a href="inicio.php" title="Inicio">Inicio</a></li>
                        <li><a href="basesycondiciones2012.doc" title="Bases">Bases</a></li>
                        <li><a href="jurado.php" title="Jurado">Jurado</a></li>
                        <li><a href="cortos.php" title="Cortos Selecciondos">Cortos Seleccionados</a></li>
                        <li><a href="peliculas-invitadas.php" title="Películas Invitadas">Películas Invitadas</a></li>
                        <li><a href="ediciones-anteriores.php" title="Ediciones Anteriores">Ediciones Anteriores</a></li>
                        <li><a href="prensa.php" title="Prensa">Prensa</a></li>
                        <li><a href="staff.php" title="Staff">Staff</a></li>
                        <li><a href="#contacto.php" title="Contacto">Contacto</a></li>
                    </ul>
                </div>
            </div>
          </nav>
      </header>
    </div>
        <section>
            <div class="container">
                <div class="row destacados">
                    <div class="eight columns">
                        <div id="carousel">
                            <?php
                            if(!empty($destacadas)){
                                foreach ($destacadas as $value) {?>
                            <div class="items">
                                <img src="<?php echo $config->get('urlImagenes').$value['imagen']; ?>" alt="<?php echo $value['titulo'];?>"/>
                                <div class="info">
                                    <p><a href="noticias/<?php echo $value['url_amigable'];?>.php" title="<?php echo $value['titulo'];?>"><?php echo $value['titulo'];?></a></p>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            else{?>
                               <div class="items">
                                <img src="<?php echo $config->get('urlImagenes');?>slider.jpg" alt="Proximamente mas info destacada>"/>
                                <div class="info">
                                    <p>Proximamente mas info destacada</p>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            
                        </div>
                        <div class="nav">
                            <a id="prev2" href="#"><img src="<?php echo $config->get('viewsFolder'); ?>images/prev.png" alt="Anterior"/></a>
                            <a id="next2" href="#"><img src="<?php echo $config->get('viewsFolder'); ?>images/next.png" alt="Siguiente"/></a>
                        </div>
                    </div>
                    <aside>
                        <div class="four columns">
                            <p><a href="basesycondiciones2012.doc" title="Base y Condiciones"><img src="<?php echo $config->get('viewsFolder');?>images/base_doc.png" alt="Base y Condiciones"/></a></p>
                            <p><a href="fichadeinscripcion7.pdf" title="Ficha de Inscripción"><img src="<?php echo $config->get('viewsFolder');?>images/ficha_pdf.png" alt="Ficha de Inscripción"/></a></p>
                            <p><a href="fichadeinscripcion7.jpg" title="Ficha de Inscripción"><img src="<?php echo $config->get('viewsFolder');?>images/ficha_jpg.png" alt="Ficha de Inscripción"/></a></p>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
        <div class="container contenido">

      <div class="row mainBody">
      
      