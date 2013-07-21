<?php
if(!empty($mensaje)) {
    echo $mensaje;
}
?>
<style type="text/css">
    #main table{width: 630px;}
    #main fieldset {padding: 19px 5px 19px 5px;}
</style>
<h2><a href="index.php?controlador=noticias" class="ajax" title="volver">Volver</a></h2>
<?php
include_once($config->get('root').$config->get('js')."/fckeditor/fckeditor.php");    
?>
<h3><? if($_REQUEST['accion']=='nuevoNoticias' || $_REQUEST['accion']=='crearNoticias') {
    echo "Crear Noticias";
}else {
    echo "Editar Noticias";
}?></h3>
<form action="index.php?controlador=noticias&amp;accion=guardarNoticias" method="post" class="jNice" enctype="multipart/form-data">
    <fieldset>
        <p><label>Titulo:</label>
            <input type="text" class="text-long" name="titulo" value="<?php echo $datos->titulo;?>"/>
        </p>
        <p><label>Edición a la que pertenece la noticia:</label>
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
        <p><label>Intro:</label>
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
            <p><label>Intro:</label>
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
        <?php if (!empty($datos->imagen)) { ?>
        <p><label>Imagen Destacada Actual:</label></p>
        <p>
            <img src="<?php echo $config->get('urlImagenes') . $datos->imagen; ?>" alt="<?php echo basename($datos->imagen); ?>"/>
            <input type="hidden" name="imgant" value="<?php echo$datos->imagen; ?>"/>
        </p>
        <?php
            }
        ?>
        <p><label>Noticia Destacada:</label>
            <select name="destacado">
                <option value="1" <?php if($datos->destacado==1){echo "selected='selected'";}?>>Si</option>
                <option value="0" <?php if($datos->destacado==0){echo "selected='selected'";}?>>No</option>
            </select>
        </p>
        <p><label>Cargar Imagen Destacada:</label>
            <input type="file" class="text-long" name="imagen" value=""/>
        </p>
        <p><label>Url Video:</label>
            <input type="text" class="text-long" name="video" id="video" value="<?php echo $datos->video;?>"/>
        </p>
        <p>
            <label>Fecha:</label>
            <input type="text" value="<?php echo $datos->fecha;?>" name="fecha" id="datepicker"/>
        </p>
    </fieldset>
    <div class="portlet">
        <div class="portlet-header">Opciones SEO</div>
        <div class="portlet-content">
            <fieldset>
                <p><label>Keywords:</label>
                    <textarea name="keywords" rows="40" cols="10"><? echo $datos->keywords;?></textarea>
                </p>
                <p><label>Descripción:</label>
                    <textarea name="descripcion_seo" rows="40" cols="10"><? echo $datos->descripcion_seo;?></textarea>
                </p>
            </fieldset>
            <br/>
        </div>
    </div>

    <br/>
    <fieldset>
        <input type="hidden" name="id"  value="<? echo $datos->id;?>"/>
        <input type="submit" value="Guardar" />
    </fieldset>

</form>