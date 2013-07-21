 <div class="seven columns">
    <h2 class="titediciones">Ediciones Anteriores</h2>

    <?php
	if(!empty($ediciones)){
	    for($i=0;$i<count($ediciones);$i++){?>
	<article class="block">
            <div class="edimg">
                <img src="<?php echo $config->get('urlImagenes').$ediciones[$i]['imagen'];?>" alt="<?php echo $ediciones[$i]['titulo'];?>" />
            </div>
	    

	    <section class="text">

		<h3><?php echo $ediciones[$i]['titulo'];?></h3>

		<p>Fecha: <?php echo $ediciones[$i]['fecha'];?><br />
			 Lugar: <?php echo $ediciones[$i]['lugar'];?><br />
			 Tipo de muestra: <?php echo $ediciones[$i]['tipo'];?>
		    <?php
			 if(!empty($ediciones[$i]['jurado'])){
			 echo "Jurado: ".$ediciones[$i]['titulo']."<br/>";
			 }
			 ?>
		</p>
		<?php
			 if(!empty($ediciones[$i]['link'])){?>
		<p><a href="<?php echo $ediciones[$i]['link'];?>" title="<?php echo $ediciones[$i]['titulo'];?>">Web: <?php echo $ediciones[$i]['titulo'];?></a></p>
		    <?php
			 }
			 ?>

	    </section><!-- End text -->

	</article>
	<div class="line">&nbsp;</div>
	<?php
	    }
	}	
	?>

	<p><a href="inicio.php" title="Volver">Volver</a></p>

</div>
<?php include_once($config->get('viewsFolder').'sidebar.php');?>
