<?php
if(!empty($mensaje)) {
    echo $mensaje;
}
?>
<style type="text/css">
    #main table{width: 630px;}
    #main fieldset {padding: 19px 5px 19px 5px;}
</style>
<h2><a href="index.php?controlador=secciones" class="ajax" title="volver">Volver</a></h2>
<h3><? if($_REQUEST['accion']=='nuevoSecciones' || $_REQUEST['accion']=='crearSecciones') {
    echo "Crear Secciones";
}else {
    echo "Editar Secciones";
}?></h3>
<form action="index.php?controlador=secciones&amp;accion=guardarSecciones" method="post" class="jNice" enctype="multipart/form-data">
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
