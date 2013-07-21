<?
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
<h2><a class="ajax" href="index.php?controlador=ediciones&amp;accion=nuevoEdiciones" title="Crear Nueva Edición">Crear Nueva Edición</a></h2>
<h3>Listado de Ediciones </h3>
<table cellpadding="0" cellspacing="0" summary="">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <?
    $num_fila = 1;
    $info = $paginador->superArray();
    $i = 1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
    while ($ediciones = $paginador->fetchResultado()) {
        $j++;
        if ($num_fila % 2 != 0) {
            $class = "class='odd'";
        } else {
            $class = "";
        } ?>
        <tr <? echo $class; ?>>
            <td><? echo $ediciones['id']; ?></td>
            <td><? echo $ediciones['titulo']; ?></td>
            <td><? echo $ediciones['tipo']; ?></td>
            <td class="action">
                <a class="edit ajax" href="index.php?controlador=ediciones&amp;accion=editarEdiciones&amp;id=<? echo $ediciones['id'];?>" title="Editar Ediciones">
        									Editar
                </a>
                <a class="delete" href="index.php?controlador=ediciones&amp;accion=borrarEdiciones&amp;id=<? echo $ediciones['id'];?>" title="Borrar Ediciones">
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

