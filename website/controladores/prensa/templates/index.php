<div class="seven columns">

    <h2 class="titprensa">Prensa</h3>

    <div class="clear50">&nbsp;</div>

    <?php
	if($prensa){
		for($i=0;$i<count($prensa);$i++){?>
		<article class="block">
		<a href="<?php echo $config->get('urlImagenes').$prensa[$i]['imagen'];?>" rel="galeria" title="&nbsp;">
			<img src="<?php echo $config->get('urlImagenes').$prensa[$i]['imagen_thumb'];?>" alt="&nbsp;"/>
		</a>

		<?php
		  $pre = str_replace('<p>','',str_replace('</p>','',$prensa[$i]['texto']));
		  echo "<p>";
		  echo $pre;
		  if(!empty($prensa[$i]['fecha']) && $prensa[$i]['fecha']!='0000-00-00'){
		  echo " (".$prensa[$i]['fecha'].")";
		  }
		  echo "</p>";
		  ?>
		</article><!-- End high-block -->

		<div class="line">&nbsp;</div>
		<?php
		}
	}
    ?>

    <p class="margin"><a href="index.php" class="red">&laquo; volver</a></p>
</div>
<?php include_once($config->get('viewsFolder').'sidebar.php');?>