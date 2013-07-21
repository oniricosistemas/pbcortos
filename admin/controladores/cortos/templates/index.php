<?
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
<h2><a class="ajax" href="index.php?controlador=cortos&amp;accion=nuevoCortos" title="Crear Nuevo Corto">Crear Nuevo Corto</a></h2>
<h3>Listado de Cortos </h3>
<table cellpadding="0" cellspacing="0" summary="">
    <thead>
        <tr>
            <th>#</th>
            <th>Titulo</th>
            <th>Categoria</th>
            <th>Edición</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <?
    $num_fila = 1;
    $info = $paginador->superArray();
    $i = 1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
    while ($cortos = $paginador->fetchResultado()) {
        $j++;
        if ($num_fila % 2 != 0) {
            $class = "class='odd'";
        } else {
            $class = "";
        } ?>
        <tr <? echo $class; ?>>
            <td><? echo $cortos['id']; ?></td>
            <td><? echo $cortos['titulo']; ?></td>
            <td><? echo $cortos['categoria']; ?></td>
            <td><? echo $cortos['edicion']; ?></td>
            <td class="action">
                <a class="edit ajax" href="index.php?controlador=cortos&amp;accion=editarCortos&amp;id=<? echo $cortos['id'];?>" title="Editar Cortos">
        									Editar
                </a>
                <a class="delete" href="index.php?controlador=cortos&amp;accion=borrarCortos&amp;id=<? echo $cortos['id'];?>" title="Borrar Cortos">
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

