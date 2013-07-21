<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Punk Framework Instalación</title>

        <style type="text/css">
            body { width: 42em; margin: 0 auto; font-family: sans-serif; background: #fff; font-size: 1em; }
            h1 { letter-spacing: -0.04em; }
            h1 + p { margin: 0 0 2em; color: #333; font-size: 90%; font-style: italic; }
            code { font-family: monaco, monospace; }
            table { border-collapse: collapse; width: 100%; }
            table th,
            table td { padding: 0.4em; text-align: left; vertical-align: top; }
            table th { width: 12em; font-weight: normal; }
            table tr:nth-child(odd) { background: #eee; }
            table td.pass { color: #191; }
            table td.fail { color: #911; }
            #results { padding: 0.8em; color: #fff; font-size: 1.5em; }
            #results.pass { background: #191; }
            #results.fail { background: #911; }
        </style>

    </head>
    <body>

        <h1>Testeo del entorno de aplicación</h1>

        <p>
		El siguiente test, determinará si el servidor a utilizar cumple con todos los requermientos necesario para el correcto funcionamiento
            del framework
        </p>

        <?php $failed = FALSE?>

        <table cellspacing="0" summary="Opciones de Testeo">
            <tr>
                <th>Versión de PHP</th>
                <?php if (version_compare(PHP_VERSION, '5.2.3', '>=')): ?>
                <td class="pass"><?php echo PHP_VERSION;?></td>
                <?php else: $failed = TRUE ?>
                <td class="fail">Punk Framework necesita una versión superior a 5.2.3 su versión actual es: <?php echo PHP_VERSION ?>.</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>Directorio Base</th>
                <?php if (is_dir($config->get('root').'website') AND is_file($config->get('root').$config->get('viewsFolder').'index.php')): ?>
                <td class="pass"><?php echo $config->get('root').'website'; ?></td>
                <?php else: $failed = TRUE ?>
                <td class="fail">No esta configurado el directorio base "website"</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>PCRE UTF-8</th>
                <?php if ( ! @preg_match('/^.$/u', 'ñ')): $failed = TRUE ?>
                <td class="fail"><a href="http://php.net/pcre">PCRE</a> no esta compilado con soporte para UTF-8.</td>
                <?php elseif ( ! @preg_match('/^\pL$/u', 'ñ')): $failed = TRUE ?>
                <td class="fail"><a href="http://php.net/pcre">PCRE</a> no esta compilado para soporte con Unicode.</td>
                <?php else: ?>
                <td class="pass">Si</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>SPL Activado</th>
                <?php if (function_exists('spl_autoload_register')): ?>
                <td class="pass">Si</td>
                <?php else: $failed = TRUE ?>
                <td class="fail">PHP <a href="http://www.php.net/spl">SPL</a> no se puede cargar o no esta compilado.</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>Reflection Activado</th>
                <?php if (class_exists('ReflectionClass')): ?>
                <td class="pass">Si</td>
                <?php else: $failed = TRUE ?>
                <td class="fail">PHP <a href="http://www.php.net/reflection">reflection</a> no se puede cargar o no esta compilado.</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>Filters Activiado</th>
                <?php if (function_exists('filter_list')): ?>
                <td class="pass">Si</td>
                <?php else: $failed = TRUE ?>
                <td class="fail">La <a href="http://www.php.net/filter">filter</a> la extensión no se puede cargar o no esta compilado.</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>Cargar Extensión Iconv</th>
                <?php if (extension_loaded('iconv')): ?>
                <td class="pass">Si</td>
                <?php else: $failed = TRUE ?>
                <td class="fail">La <a href="http://php.net/iconv">iconv</a> la extensión no se puede cargar.</td>
                <?php endif ?>
            </tr>
            <?php if (extension_loaded('mbstring')): ?>
            <tr>
                <th>Mbstring No Overloaded</th>
                    <?php if (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING): $failed = TRUE ?>
                <td class="fail">La <a href="http://php.net/mbstring">mbstring</a> extension is overloading PHP's native string functions.</td>
                    <?php else: ?>
                <td class="pass">Si</td>
                    <?php endif ?>
            </tr>
            <?php endif ?>
            <tr>
                <th>Character Type (CTYPE) Extension</th>
                <?php if ( ! function_exists('ctype_digit')): $failed = TRUE ?>
                <td class="fail">La <a href="http://php.net/ctype">ctype</a> la extensión no se puede cargar.</td>
                <?php else: ?>
                <td class="pass">Si</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>URI Determination</th>
                <?php if (isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']) OR isset($_SERVER['PATH_INFO'])): ?>
                <td class="pass">Si</td>
                <?php else: $failed = TRUE ?>
                <td class="fail">Neither <code>$_SERVER['REQUEST_URI']</code>, <code>$_SERVER['PHP_SELF']</code>, or <code>$_SERVER['PATH_INFO']</code> esta disponible.</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>cURL Activado</th>
                <?php if (extension_loaded('curl')): ?>
                <td class="pass">Si</td>
                <?php else: ?>
                <td class="fail">Punk puede usar la extensión<a href="http://php.net/curl">cURL</a> pero no esta activada o instalada.</td>
                <?php endif ?>
            </tr>

            <tr>
                <th>GD Activado</th>
                <?php if (function_exists('gd_info')): ?>
                <td class="pass">Si</td>
                <?php else: ?>
                <td class="fail">Punk necesita <a href="http://php.net/gd">GD</a> v2 para el uso de las imágenes.</td>
                <?php endif ?>
            </tr>
            <tr>
                <th>MySQL Activado</th>
                <?php if (function_exists('mysql_connect')): ?>
                <td class="pass">Si</td>
                <?php else: ?>
                <td class="fail">Punk necesita usar la extensión <a href="http://php.net/mysql">MySQL</a> para el manejo de base de datos y no esta activada o instalada.</td>
                <?php endif ?>
            </tr>
        </table>

        <?php if ($failed === TRUE): ?>
        <p id="results" class="fail">✘ El servidor no esta correctamente configurado para usar Punk.</p>
        <?php else: ?>
        <p id="results" class="pass">✔ El servidor esta correctamente configurado para usar Punk.<br />
			Elmimine el archivo <code>test.php</code></p>
        <?php endif ?>



    </body>
</html>
