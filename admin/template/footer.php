                </div>
                <!-- // #main -->
                <div class="clear"></div>
            </div>
            <!-- // #container -->
        </div>	
        <!-- // #containerHolder -->        
        <p id="footer">	   
	    <?php
	    $time2 = round(microtime(), 3);
	    $carga = $time2 - $time;
	    echo "La pagina tardo $carga segundos en mostrarse, ";
	    $db=Database::singleton();
	    echo "se realizaron ".$db->queryTotal()." llamadas a la base de datos.";
	    echo "<br/><br/>";
	    ?>
	    2007 - <?php echo date("Y");?> &copy; Diseño &amp; Desarrollo Web
	    <a href="http://www.oniricosistemas.com.ar">Onírico Sistemas</a>
	    - Desarrollado con Punk Framework v.<?php echo $config->get('version');?>
	</p>	
    </div>
    <!-- // #wrapper -->
    
</body>
</html>