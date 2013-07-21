<div class="seven columns">

    <h2 class="titjurado">Jurado</h2>

    <?php
    for($i=0;$i<count($jurado);$i++){
	$k=$i+1;
	?>
    <article class="block1">

	<h4><?php echo $jurado[$i]['nombre'];?></h4>

	<img src="<?php echo $config->get('urlImagenes').$jurado[$i]['foto'];?>" alt="<?php $jurado[$i]['nombre'];?>" />

	<section class="text21">

	    <?php echo $jurado[$i]['intro'];?>
	    <?php
	    if(!empty($jurado[$i]['texto'])){?>
	    <a href="#" rel="<?php echo $i;?>" class="more">seguir leyendo &raquo;</a>
	    <div class="hidden<?php echo $i;?>" style="display: none;"><?php echo $jurado[$i]['texto'];?></div>
	    <?php
	    }
	    ?>
	</section><!-- End section -->
    </article><!-- End block -->
	<?php
	}
	?>
    <article>
    <a href="inicio.php" class="volver" title="Volver">Volver</a>
    </article>
</div>
<?php include_once($config->get('viewsFolder').'sidebar.php');?>