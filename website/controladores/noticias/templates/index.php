 <div class="seven columns">
    <article>
            <div class="imagen">
            <?php
                $extrae = "#\<img (.*?)\/>#";
                if ($datos[0]['imagen'] && !$datos[0]['destacado']) {
                    $imagen = '<img src="' . $config->get('urlImagenes').$datos[0]['imagen'] . '" style=" width:146px; height:146px;" alt="' . $datos[0]['titulo'] . '" />';
                } else {
                    $texto = $datos[0]['intro'].$datos[0]['texto'];
                    $imagen =  imagen($texto, $datos[0]['titulo']);
                }
                echo $imagen;
           ?>
           </div>
            <section>
                <p class="fecha"><?php echo $utilidades->cambiarFecha($datos[0]['fecha'],4); ?></p>
                <h2><?php echo $datos[0]['titulo']; ?></h2>
                <?php echo preg_replace($extrae, '', $datos[0]['intro']); echo $datos[0]['texto'];?>
                <ul id="social" class="cf">
                    <li>
                        <a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=<?php echo $config->get('base'). $datos[0]['url_amigable'];?>.php" class="socialite googleplus-one" data-size="tall" data-href="<?php echo $config->get('base'). $datos[0]['url_amigable'];?>.php" rel="nofollow" target="_blank">
                            <span class="vhidden">Share on Google+</span>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo $config->get('base'). $datos[0]['url_amigable'];?>.php&amp;t=<?php echo $seo['titulo']; ?>" class="socialite facebook-like" data-href="<?php echo $config->get('base'). $datos[0]['url_amigable'];?>.php" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank">
                            <span class="vhidden">Share on Facebook</span>
                        </a>
                    </li>
                    <li class="tw">
                        <a href="http://twitter.com/share" class="socialite twitter-share" data-via="<?php echo $seo['titulo']; ?>" data-text="<?php echo $seo['titulo'] . ' - ' . str_replace('<p>', '', $utilidades->cortarTexto($datos[0]['intro_' . $_SESSION['leng']], 100)); ?>" data-url="<?php echo $config->get('base'). $datos[0]['url_amigable'];?>.php" data-count="vertical" rel="nofollow" target="_blank">
                            <span class="vhidden">Share on Twitter</span>
                        </a>
                    </li>
                </ul>
            </section>
        <p><a href="inicio.php" title="Volver">Volver</a></p>
    </article>
</div>
<?php include_once($config->get('viewsFolder').'sidebar.php');?>