 <div class="seven columns">
    <section>
        <div class="frase">
            <p>"Descubrir el Cine, con mayúscula, es una virtud que ya no sorprende en los argentinos. Nuestro país tiene en tal sentido una antigua tradición que le viene desde los mismos tiempos de la invención del cine. Pocos días después de ocurrido este milagro (¡!) que ha salpicado de sueños mi vida entera, salía a la luz la primera película argentina. Fue una maravillosa sorpresa el día que recibí la primera invitación de Adrián Culasso y montado en mi sueño no vacilé en correr a la iluminada Ciudad de Gálvez. Lo que encontré ahí, un singular festival de cortometrajes, me sorprendió. Sin embargo la sorpresa se esfumó cuando fui conociendo a su gente y pensé: “¿Cómo pudo Gálvez ser Gálvez solamente, sin el Cine?” Estos jóvenes apasionados, los que organizan y los organizados, los creadores de este milagro y los cortometrajes que sueltan todos los años en busca de eternidad, son hoy para mí, al mismo tiempo, sueño y realidad. Nada mejor en este mundo. Felicitaciones, siempre."</p>
            <p class="firma"><strong>Manuel Antin</strong> (Rector / Universidad del Cine)<br/>
Padrino del Festival</p>
        </div>
        <h2 class="titulo">Noticias</h2>
    </section>
<?php
    $paginador->linkEstructura('inicio/pagina/{n}.php');
    $k=1;
    while ($noticia = $paginador->fetchResultado()){
        $extrae = "#\<img (.*?)\/>#";
?>
    <article>
            <div class="imagen">
            <?php
                if ($noticia['imagen'] && !$noticia['destacado']) {
                    $imagen = '<img src="' . $config->get('urlImagenes').$noticia['imagen'] . '" style=" width:146px; height:146px;" alt="' . $noticia['titulo'] . '" />';
                } else {
                    $texto = $noticia['intro'].$noticia['texto'];
                    $imagen =  imagen($texto, $noticia['titulo']);
                }
                echo $imagen;

           ?>
           </div>
            <section>
                <p class="fecha"><?php echo $utilidades->cambiarFecha($noticia['fecha'],4); ?></p>
                <h2><?php echo $noticia['titulo']; ?></h2>
                <?php echo preg_replace($extrae, '', $noticia['intro']); ?>
                <?php
                if(!empty($noticia['texto'])){?>
                <p><a href="noticias/<?php echo $noticia['url_amigable'];?>.php" >seguir leyendo &raquo;</a></p>
                <?php
                }
                ?>
                
            </section>
    </article>
    <hr/>

<?php
    $k++;
    }
    echo "<div id='navigation'>".$paginador->fetchNavegacion()."</div>";
?>
</div>
<?php include_once($config->get('viewsFolder').'sidebar.php');?>