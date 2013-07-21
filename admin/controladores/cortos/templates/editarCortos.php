<h2><a href="index.php?controlador=cortos" class="ajax" title="volver">Volver</a></h2>
<?php
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
<h3><?
if ($_REQUEST['accion'] == 'nuevoCortos' || $_REQUEST['accion'] == 'crearCortos') {
    echo "Crear Cortos";
} else {
    echo "Editar Cortos";
}
?></h3>
<form action="index.php?controlador=cortos&amp;accion=guardarCortos" id="form" method="post" class="jNice" enctype="multipart/form-data">
    <fieldset>
        <p><label>Titulo (sin comillas):</label>
            <input type="text" class="text-long" name="titulo" value="<?php echo $datos->titulo; ?>"/>
        </p>
        <p><label>Categoría a la que pertenece el corto:</label>
            <select name="id_categorias">
                <option value="">Seleccione una edición</option>
                <?php foreach ($categorias as $value) {?>
                    <option value="<?php echo $value['id']; ?>" <?php if ($datos->id_edicion == $value['id']) {
                        echo "selected='selected'";
                    } ?>><?php echo $value['nombre']; ?></option>
                <?php
                }
                ?>
            </select>
        </p>
        <p><label>Director/es (sin parentesis):</label>
            <input type="text" class="text-long" name="director" value="<?php echo $datos->director; ?>"/>
        </p>
        <p><label>Duración:</label>
            <input type="text" class="text-long" name="duracion" value="<? echo $datos->duracion; ?>"/>
        </p>
        <p><label>Lugar:</label>
            <input type="text" class="text-long" name="lugar" value="<?php echo $datos->lugar; ?>"/>
        </p>
        <p><label>Edición a la que pertenece el corto:</label>
            <select name="id_edicion">
                <option value="">Seleccione una edición</option>
                <?php foreach ($ediciones as $value) {?>
                    <option value="<?php echo $value['id']; ?>" <?php if ($datos->id_edicion == $value['id']) {
                        echo "selected='selected'";
                    } ?>><?php echo $value['titulo']; ?></option>
                <?php
                }
                ?>
            </select>
        </p>
        <input type="hidden" name="id"  value="<? echo $datos->id; ?>"/>
        <input type="submit" value="Guardar" />
    </fieldset>

</form>