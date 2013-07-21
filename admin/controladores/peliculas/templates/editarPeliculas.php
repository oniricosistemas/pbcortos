<?php
if(!empty($mensaje)) {
    echo $mensaje;
}
?>
<style type="text/css">
    #main table{width: 630px;}
    #main fieldset {padding: 19px 5px 19px 5px;}
</style>
<h2><a href="index.php?controlador=peliculas" class="ajax" title="volver">Volver</a></h2>
<h3><? if($_REQUEST['accion']=='nuevoPeliculas' || $_REQUEST['accion']=='crearPeliculas') {
    echo "Crear Peliculas";
}else {
    echo "Editar Peliculas";
}?></h3>
<form action="index.php?controlador=peliculas&amp;accion=guardarPeliculas" method="post" class="jNice" enctype="multipart/form-data">
    <fieldset>
        <p><label>Titulo:</label>
            <input type="text" class="text-long" name="titulo" value="<?php echo $datos->titulo;?>"/>
        </p>
        <p><label>Edición a la que pertenece la pelicula:</label>
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
        <?php if (!empty($datos->afiche)) { ?>
        <p><label>Imagen Destacada Actual:</label></p>
        <p>
            <img src="<?php echo $config->get('urlImagenes') . $datos->afiche; ?>" alt="<?php echo basename($datos->afiche); ?>"/>
            <input type="hidden" name="imgant" value="<?php echo $datos->afiche; ?>"/>
        </p>
        <?php
            }
        ?>
        <p><label>Cargar Afiche:</label>
            <input type="file" class="text-long" name="imagen" value=""/>
        </p>        
    </fieldset>
        <br/>
    <fieldset>
        <input type="hidden" name="id"  value="<? echo $datos->id;?>"/>
        <input type="submit" value="Guardar" />
    </fieldset>

</form>