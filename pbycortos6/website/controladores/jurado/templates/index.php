<div id="left-col" class="terms">

    <h1><?php echo $seccion->titulo;?></h1>

    <?php echo $seccion->texto;?>

    <?php
    for($i=0;$i<count($jurado);$i++){
	$k=$i+1;
	?>
    <div class="block">

	<h4><?php echo $jurado[$i]['nombre'];?></h4>

	<img src="<?php echo $config->get('urlImagenes').$jurado[$i]['foto'];?>" alt="<?php $jurado[$i]['nombre'];?>" />

	<div class="text2">

	    <?php echo $jurado[$i]['intro'];?>
	    <?php
	    if(!empty($jurado[$i]['texto'])){?>
	    <a href="#" rel="hidden<?php echo $k;?>" class="more">seguir leyendo &raquo;</a>
	    <div class="hidden"><?php echo $jurado[$i]['texto'];?></div>
	    <?php
	    }
	    ?>
	</div><!-- End text -->

    </div><!-- End block -->

    <div class="line">&nbsp;</div>
	<?php
	}
	?>
    <p><a href="index.php" class="red">&laquo; volver</a></p>

</div><!-- End left-col -->
