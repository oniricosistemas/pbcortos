 <div class="seven columns">
     <h2 class="titpeli">Películas Invitadas</h2>
    <?php
    $i = 1;
    foreach ($peliculas as $peli) {
    ?>
     <article class="block1">
        <div class="pelimg">
            <img class="peli" src="<?php echo $config->get('urlImagenes').$peli['afiche'];?>" alt="<?php echo $peli['titulo'];?>" />
        </div>
        <section class="text21">
            <h4><?php echo $peli['titulo'];?></h4>
            <?php echo $peli['intro'];?>
            <?php
            if($peli['titulo']!=''){?>
            <a href="#" rel="<?php echo $i;?>" class="more">seguir leyendo &raquo;</a>
	    <div class="hidden<?php echo $i;?>" style="display: none;">
            <?php echo $peli['texto'];?>
            </div>
            <?php
            }
            ?>
        </section><!-- End text -->
     </article>
    <?php
        $i++;
    }
    ?>
     <article>
    <p><a href="inicio.php" title="Volver">Volver</a></p>
     </article>
</div>
<?php include_once($config->get('viewsFolder').'sidebar.php');?>
