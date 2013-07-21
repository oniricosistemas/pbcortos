    <?
    if(!empty($mensaje)){
    echo $mensaje;
    }
    ?>
<style type="text/css">
    #main table{width: 630px;}
    #main fieldset {padding: 19px 5px 19px 5px;}
</style>
<h2><a href="index.php?controlador=prensa" title="volver">Volver</a></h2>
    <h3><? if($_REQUEST['accion']=='nuevaPrensa' || $_REQUEST['accion']=='crearPrensa'){ echo "Crear Prensa";}else{ echo "Editar Prensa";}?></h3>
    <form action="index.php?controlador=prensa&amp;accion=guardarPrensa" method="post" class="jNice" enctype="multipart/form-data">
          <div class="portlet2">
            <div class="portlet2-header">Opciones Prensa</div>
            <div class="portlet2-content">
                <fieldset>
                    <p><label>Edición a la que pertenece la prensa:</label>
                        <select name="id_edicion">
                            <option value="">Seleccione una edición</option>
                            <?php
                            foreach ($ediciones as $value) {?>
                                <option value="<?php echo $value['id'];?>" <?php if($datos->id_edicion==$value['id']){echo "selected='selected'";}?>><?php echo $value['titulo'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </p>
		   <p><label>Texto:</label>
                        <textarea cols="0" rows="0" name="texto" id="editor1"><?php echo $datos->texto;?></textarea>
                        <script type="text/javascript">
                            if (CKEDITOR.instances['editor1']) {
                                CKEDITOR.remove(CKEDITOR.instances['editor1']);
                            }
                            CKEDITOR.replace( 'editor1',
                            {
                                filebrowserBrowseUrl : '/browser/browse.php',
                                filebrowserUploadUrl : '/uploader/upload.php',
                                width : 650,
                                toolbar : 'Comun'
                            });
                        </script>
                    </p>
		    <p><label>Fecha </label><input type="text" class="text-short" readonly="readonly" id="datepicker" name="fecha" value="<?php echo $datos->fecha;?>"/></p>
		    <?php
			if(!empty($datos->imagen_thumb)){?>
		    <label>Imagen Actual:</label>
		    <p>
			<img src="<?php echo $config->get('urlImagenes').$datos->imagen_thumb;?>" alt="<?php echo basename($datos->nombre);?>"/>
		    </p>
		    <?php
			}
			?>
		    <p><label>Imagen:</label>
			<input type="file" class="text-long" name="imagen" value=""/>
		    </p>
                </fieldset>
            </div>
        </div>
        
        <fieldset>
            <input type="hidden" name="id"  value="<? echo $datos->id;?>"/>
            <input type="submit" value="Guardar" />
        </fieldset>
    </form>

