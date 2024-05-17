<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>

  </title>
 
  <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link rel="stylesheet" href="css/signature-pad.css">
</head>
<body onselectstart="return false">
 

  <div id="signature-pad" class="signature-pad">
    <div id="canvas-wrapper" class="signature-pad--body">
      <canvas id="canvas_firma"></canvas>
    </div>
    <div class="signature-pad--footer">

      <div class="signature-pad--actions">
        <div class="column">
          <button type="button" class="button clear" data-action="clear">Clear</button>
          <button type="button" class="button save" id="guardar_firma" data-action="save">Guardar</button>
        </div>
        <div class="column">
         
        </div>
      </div>

      
    </div>
  </div>

  <script src="js/signature_pad.umd.min.js"></script>
  <script src="js/app.js"></script>
</body>

</html>