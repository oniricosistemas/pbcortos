<?
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
<style type="text/css">
    #main table{width: 630px;}
    #main fieldset {padding: 19px 5px 19px 5px;}
</style>
<h2><a href="index.php?controlador=invitados" title="volver">Volver</a></h2>
    <h3><? if($_REQUEST['accion']=='nuevaInvitados' || $_REQUEST['accion']=='crearInvitados'){ echo "Crear Invitados";}else{ echo "Editar Invitados";}?></h3>
    <form action="index.php?controlador=invitados&amp;accion=guardarInvitados" method="post" class="jNice" enctype="multipart/form-data">
          <div class="portlet2">
            <div class="portlet2-header">Opciones Invitados</div>
            <div class="portlet2-content">
                <fieldset>
                    <p><label>Nombre:</label><input type="text" class="text-long" name="nombre" value="<? echo $datos->nombre;?>"/></p>
                    <p><label>Edición a la que pertenece el Invitado:</label>
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
		    <p><label>Introducción:</label>
                        <textarea cols="0" rows="0" name="intro" id="editor1"><?php echo $datos->intro;?></textarea>
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
		    <p><label>Texto:</label>
                        <textarea cols="0" rows="0" name="texto" id="editor2"><?php echo $datos->texto;?></textarea>
                        <script type="text/javascript">
                            if (CKEDITOR.instances['editor2']) {
                                CKEDITOR.remove(CKEDITOR.instances['editor2']);
                            }
                            CKEDITOR.replace( 'editor2',
                            {
                                filebrowserBrowseUrl : '/browser/browse.php',
                                filebrowserUploadUrl : '/uploader/upload.php',
                                width : 650,
                                toolbar : 'Comun'
                            });
                        </script>
                    </p>
		    <?php
			if(!empty($datos->foto)){?>
		    <label>Imagen Actual:</label>
		    <p>
			<img src="<?php echo $config->get('urlImagenes').$datos->foto;?>" alt="<?php echo basename($datos->nombre);?>"/>
		    </p>
		    <?php
			}
			?>
		    <p><label>Imagen:</label>
			<input type="file" class="text-long" name="foto" value=""/>
		    </p>
                </fieldset>
            </div>
        </div>
        
        <fieldset>
            <input type="hidden" name="id"  value="<? echo $datos->id;?>"/>
            <input type="submit" value="Guardar" />
        </fieldset>
    </form>
