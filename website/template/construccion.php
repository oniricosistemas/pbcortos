<!DOCTYPE html>
<?php
include($config->get('root') . 'helpers/seo_helper.php');
$seo = seo($datos);
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

        <base href="<?php echo $config->get('base'); ?>"/>

        <title><?php echo $seo['titulo']; ?></title>
        <meta name="description" content="<?php echo $seo['descripcion']; ?>" />
        <meta name="keywords" content="<?php echo $seo['keywords']; ?>"/>

        <meta name="google-site-verification" content="" />
        <meta name="language" content="<?php echo $seo['lenguaje']; ?>" />
        <meta http-equiv="Content-Language" content="<?php echo $seo['lenguaje']; ?>" />
        <meta name="revisit-after" content="7 days" />
        <meta name="robot" content="Index,Follow" />
        <meta name="robot" content="All" />
        <meta name="Distribution" content="Global" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta name="rating" content="general" />

        <link rel="canonical" href="<?php
        if (!$url->uriString()) {
            echo $config->get('base');
        } else {
            echo $config->get('base') . $url->fetchUri();
        }
        ?>" />

        <meta name="author" http-equiv="Author" content="<?php echo $config->get('autor'); ?>"/>
        <meta name="copyright" content="Copyright On&iacute;rico Sistemas - www.oniricosistemas.com" />
        <meta name="generator" content="Framework Punk PHP <?php echo $config->get('version'); ?>" />

        <link rel="icon" type="image/x-icon" href="<?php echo $config->get('viewsFolder'); ?>images/favicon.ico" />
        <link rel="shortcut icon" href="<?php echo $config->get('viewsFolder'); ?>images/favicon.ico" type="image/x-icon" />


        <!-- start: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- end: Mobile Specific -->

        <!-- start: Facebook Open Graph -->
        <meta property="og:title" content=""/>
        <meta property="og:description" content=""/>
        <meta property="og:type" content=""/>
        <meta property="og:url" content=""/>
        <meta property="og:image" content=""/>
        <!-- end: Facebook Open Graph -->

        <!-- start: CSS -->
        <link href="<?php echo $config->get('viewsFolder'); ?>bootstrap.css" rel="stylesheet">
        <link href="<?php echo $config->get('viewsFolder'); ?>css/bootstrap-responsive.css" rel="stylesheet">
        <link href="<?php echo $config->get('viewsFolder'); ?>css/styles.css" rel="stylesheet">
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>

        <!-- end: CSS -->

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="row-fluid">
            <header>
                <div class="row-fluid">
                    <div class="span11 offset1">
                        <img src="<?php echo $config->get('viewsFolder'); ?>images/anunciantes.png" alt="Auspiciantes"/>
                    </div>
                </div>
            </header>
            <div class="row-fluid">
                <div class="span4 logo offset5"><img src="<?php echo $config->get('viewsFolder'); ?>images/logo.png" alt="logo"/></div>
            </div>
            <div class="row-fluid opciones">
                <div class="span3 offset1">
                    <a href="basesycondiciones2013.docx" title="Base y Condiciones"><img src="<?php echo $config->get('viewsFolder'); ?>images/base.png" alt="Base y Condiciones"/></a></div>
                <div class="span3">
                    <a href="fichainscripcion8.pdf" title="Ficha Inscripci&oacute;n"><img src="<?php echo $config->get('viewsFolder'); ?>images/fichapdf.png" alt="Ficha Inscripci&oacute;n"/></a></div>
                <div class="span3">
                    <a href="fichadeinscripcion8.jpg" title="Ficha Inscripci&oacute;n"><img src="<?php echo $config->get('viewsFolder'); ?>images/ficha.png" alt="Ficha Inscripci&oacute;n"/></a>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span5 offset1">
                    <h1>Pel&iacute;cula de Apertura:</h1>
                    <h2>"Ram&oacute;n Ayala" (dir: Marcos L&oacute;pez)</h2>
                    <img src="<?php echo $config->get('viewsFolder'); ?>images/ayala.jpg" alt="Ramon ayala"/>
                    <div class="columna">
                        <p>
                            <strong>Sinopsis</strong>: Para ser placentera, una pel&iacute;cula no debe ser rec&oacute;ndita. Y viceversa. Alguien se mand&oacute; esa "regla" en alg&uacute;n momento de nuestra vida, y as&iacute; pasamos a&ntilde;os y a&ntilde;os de gravedad y estupidez, hasta que Marcos L&oacute;pez cambi&oacute; de c&aacute;mara y se decidi&oacute; a contar vida, obra y colores del cantante/pr&oacute;cer misionero Ram&oacute;n Ayala, logrando meternos de cabeza en su historia, que es placentera y rec&oacute;ndita, lo que podr&iacute;a ser traducido en una palabra: portentosa. El propio Ram&oacute;n Ayala en inanimado 2D, su gruesa estampa, ya es una cosa seria, as&iacute; que imaginen lo que es tenerlo en 1000D, acerc&aacute;ndose con sigilo a los misterios de la m&uacute;sica y siendo contado por un elenco de amigos-estudiosos-fans que prescinden tanto del elogio bobo como del apunte acad&eacute;mico. "Algo se mueve en el fondo/ del Chaco Boreal/ sombras de bueyes y carro/ buscando el conf&iacute;n,/ lenta mortaja de luna/ sobre el cachap&eacute;;/ muerto el gigante del monte/ en su viaje final", escribi&oacute; Ayala cual Salgari en "El cachapecero", y Marcos L&oacute;pez consigui&oacute; –al fin– las im&aacute;genes que semejante banda sonora estaba esperando.
                        </p>
                        <p><strong>Reparto: Ram&oacute;n Ayala, Claudio Torres, V&iacute;ctor Kesselman, Liliana Herrero, Juan Fal&uacute;<br/>
                           Fotograf&iacute;a: Marcos L&oacute;pez<br/>
                           Edici&oacute;n: Andrea Kleinman<br/>
                           Direcci&oacute;n de Arte: Marcos L&oacute;pez, Yanina Moroni, Nadia Kossowski<br/>
                           Producci&oacute;n: Lena Esquenazi, Marcos L&oacute;pez, Marcelo C&eacute;spedes<br/></strong>
                        </p>
                    </div>
                </div>
                <div class="span6">
                    <h1>Pel&iacute;cula de Cierre:</h1>
                    <h2>"De martes a martes" (dir: Gustavo Trivi&ntilde;o)</h2>
                    <img src="<?php echo $config->get('viewsFolder'); ?>images/martes.jpg" alt="De martes a martes"/>
                    <div class="columna">
                        <p><strong>Sinopsis:</strong> A pesar de su tama&ntilde;o, de su f&iacute;sico macizo y hasta amenazante, Juan Ben&iacute;tez parece llevar una vida entera de tolerar sin inmutarse los maltratos que le infligen otros, asintiendo a menudo en silencio o masticando hacia adentro sus penas y humillaciones. Lo chicanea su jefe en la f&aacute;brica que lo emplea como operario abusando de su m&oacute;dico poder; lo menosprecian los petulantes chicos que asisten a las fiestas en las que junta unos pesos extra como patovica y lo presiona leve, pero persistentemente, su mujer. Sin embargo Juan Benitez tiene al menos una raz&oacute;n para tragarse su orgullo: abriga el sue&ntilde;o de montar su propio gimnasio para lo que a&uacute;n le falta reunir parte del dinero. 
                        Y en eso est&aacute;, cuando al anochecer de otro de sus rutinarios d&iacute;as, asiste a un episodio terrible ante el cual toma una decisi&oacute;n que lo 
                        pone de pronto en una encrucijada moral.</p>
                        <p>
                            <strong>Reparto: Pablo Pinto, Alejandro Awada, Malena Sanchez, Daniel Valenzuela, Roly Serrano, Jorge Sesan, Maria Paula Desch, Silvia Bayle.<br/>
                                    Director: Gustavo Fernandez Trivi&ntilde;o.<br/>
                                    Productor Ejecutivo: Gabriel Pastore<br/>
                                    Director de Fotografia: Julian Apezteguia<br/>
                                    Montaje: Pablo Faro<br/>
                                    Gui&oacute;n: Gustavo Trivi&ntilde;o<br/>
                            </strong>
                        </p>
                    </div>
                </div>
            </div>
            <footer>
                <!-- JavaScript at the bottom for fast page loading -->
<?php include_once("website/template/analyticstracking.php") ?>
                <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
                <script>window.jQuery || document.write('<script src="<?php echo $config->get('base') . $config->get('js'); ?>/jquery-1.7.2.min.js"><\/script>')</script>
                <script type="text/javascript">
<?php
echo "var baseJs = '" . $config->get('base') . $config->get('js') . "/';";
echo "var baseUrl = '" . $config->get('base') . "';";
?>
                </script>

                <script src="<?php echo $config->get('viewsFolder') . $config->get('js'); ?>/bootstrap.js"></script>

                <script type="text/javascript" src="<?php echo $config->get('base') . $config->get('js'); ?>/punk.js"></script>
                <script type="text/javascript" src="<?php echo $config->get('viewsFolder'); ?>js/funciones.js"></script>
                <!-- end scripts-->


                <!-- Prompt IE 6 users to install Chrome Frame. We suggest that you not support IE 6.
                     chromium.org/developers/how-tos/chrome-frame-getting-started -->
                <!--[if lt IE 7 ]>
                  <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
                  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
                <![endif]-->
            </footer>
        </div>
    </body>
</html>