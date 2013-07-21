<h2>Bienvenido <?php echo $_SESSION['nombre'];?></h2>
<div id="file-uploader-demo1">
		<noscript>
			<p>Please enable JavaScript to use file uploader.</p>
			<!-- or put a simple form for upload here -->
		</noscript>
	</div>
<script type="text/javascript">
    //<![CDATA[
    function createUploader(){
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader-demo1'),
                action: 'http://localhost/punk_dev/admin/index.php?controlador=index&accion=subir',
                debug: true
            });
        }

        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load
        window.onload = createUploader;    
    //]]>
</script>
<!--<form id="form1" action="#" method="post" enctype="multipart/form-data">
    <div id="divSWFUploadUI">
        <div class="fieldset  flash" id="fsUploadProgress">
            <span class="legend">Estado Carga de Archivos</span>
        </div>
        <p id="divStatus">0 Archivos subidos</p>
        <p>
            <span id="spanButtonPlaceholder"></span>
            <input id="btnCancel" type="button" value="Cancelar Todas las Cargas" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" />
            <br />
        </p>
    </div>
    <div id="divLoadingContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			SWFUpload is loading. Please wait a moment...
    </div>
    <div id="divLongLoading" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			SWFUpload is taking a long time to load or the load has failed.  Please make sure that the Flash Plugin is enabled and that a working version of the Adobe Flash Player is installed.
    </div>
    <div id="divAlternateContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			We're sorry.  SWFUpload could not load.  You may need to install or upgrade Flash Player.
			Visit the <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">Adobe website</a> to get the Flash Player.
    </div>
</form>-->

