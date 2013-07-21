    <?php
    if(!empty($mensaje)){
        echo $mensaje;
    }
    ?>
    <h2><a href="index.php?controlador=lenguajes" class="ajax" title="volver">Volver</a></h2>
    <h3><? if($_REQUEST['accion']=='nuevoLenguajes' || $_REQUEST['accion']=='crearLenguajes'){ echo "Crear Idioma";}else{ echo "Editar Idioma";}?></h3>
    <form action="#" onsubmit="submitAjax('form','index.php?controlador=lenguajes&amp;accion=guardarLenguajes','wrapper','');return false;" id="form" method="post" class="jNice" enctype="multipart/form-data">
	  <fieldset>
	    <p><label>Idioma:</label>
		<input type="text" class="text-long" name="idioma" value="<?php echo $datos->idioma;?>"/>
	    </p>
	    <p><label>Siglas:</label>
		<input type="text" class="text-long" name="siglas" value="<?php echo $datos->siglas;?>"/>
	    </p>

	    <input type="hidden" name="id"  value="<? echo $datos->id;?>"/>
	    <input type="submit" value="Guardar" />
	</fieldset>

    </form>