<?php
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
<h2><a href="index.php?controlador=categorias" class="ajax" title="volver">Volver</a></h2>
<h3><?
if ($_REQUEST['accion'] == 'nuevoCategorias' || $_REQUEST['accion'] == 'crearCategorias') {
    echo "Crear Categorias";
} else {
    echo "Editar Categorias";
}
?></h3>
<form action="index.php?controlador=categorias&amp;accion=guardarCategorias" id="form" method="post" class="jNice" enctype="multipart/form-data">
    <fieldset>
        <p><label>Nombre:</label>
            <input type="text" class="text-long" name="nombre" value="<?php echo $datos->nombre; ?>"/>
        </p>
        <input type="hidden" name="id"  value="<? echo $datos->id; ?>"/>
        <input type="submit" value="Guardar" />
    </fieldset>

</form>