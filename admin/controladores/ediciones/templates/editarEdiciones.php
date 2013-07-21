<h2><a href="index.php?controlador=ediciones" class="ajax" title="volver">Volver</a></h2>
<?php
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
<h3><?
if ($_REQUEST['accion'] == 'nuevoEdiciones' || $_REQUEST['accion'] == 'crearEdiciones') {
    echo "Crear Ediciones";
} else {
    echo "Editar Ediciones";
}
?></h3>
<form action="index.php?controlador=ediciones&amp;accion=guardarEdiciones" id="form" method="post" class="jNice" enctype="multipart/form-data">
    <fieldset>
        <p><label>Titulo:</label>
            <input type="text" class="text-long" name="titulo" value="<?php echo $datos->titulo; ?>"/>
        </p>
        <p><label>Fecha:</label>
            <input type="text" class="text-long" name="fecha" value="<?php echo $datos->fecha; ?>"/>
        </p>
        <p><label>Lugar:</label>
            <input type="text" class="text-long" name="lugar" value="<?php echo $datos->lugar; ?>"/>
        </p>
        <p><label>Tipo de Competencia:</label>
            <input type="text" class="text-long" name="tipo" value="<? echo $datos->tipo; ?>"/>
        </p>
        <p><label>Url Sitio:</label>
            <input type="text" class="text-long" name="link" value="<? echo $datos->link; ?>"/>
        </p>
        <?php if (!empty($datos->imagen)) {?>
            <label>Imagen Actual:</label>
            <p>
                <img src="<?php echo $config->get('urlImagenes') . $datos->imagen; ?>" alt="<?php echo basename($datos->imagen); ?>"/>
            </p>
            <input type="hidden" name="imgant" value="<?php echo$datos->imagen; ?>"/>
        <?php
        }
        ?>
        <p><label>Imagen:</label>
            <input type="file" class="text-long" name="imagen" value=""/>
        </p>
        <input type="hidden" name="id"  value="<? echo $datos->id; ?>"/>
        <input type="submit" value="Guardar" />
    </fieldset>

</form>