<?
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
<h2><a class="ajax" href="index.php?controlador=categorias&amp;accion=nuevoCategorias" title="Crear Nueva Categoría">Crear Nueva Categoría</a></h2>
<h3>Listado de Categorias </h3>
<table cellpadding="0" cellspacing="0" summary="">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <?
    $num_fila = 1;
    $info = $paginador->superArray();
    $i = 1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
    while ($categorias = $paginador->fetchResultado()) {
        $j++;
        if ($num_fila % 2 != 0) {
            $class = "class='odd'";
        } else {
            $class = "";
        } ?>
        <tr <? echo $class; ?>>
            <td><? echo $categorias['id']; ?></td>
            <td><? echo $categorias['nombre']; ?></td>
            <td class="action">
                <a class="edit ajax" href="index.php?controlador=categorias&amp;accion=editarCategorias&amp;id=<? echo $categorias['id'];?>" title="Editar Categorias">
        									Editar
                </a>
                <a class="delete" href="index.php?controlador=categorias&amp;accion=borrarCategorias&amp;id=<? echo $categorias['id'];?>" title="Borrar Categorias">
									Borrar
                </a>
        </td>
    </tr>
<?php
        $num_fila++;
    } ?>
    <tr><td colspan="7">&nbsp;</td></tr>
</table>
<? echo "<div id='navigation'>" . $paginador->fetchNavegacion() . "</div>"; ?>

