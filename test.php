
<meta charset="utf-8"/>
 <?php
// Rescatamos el parámetro que nos llega mediante la url que invoca xmlhttp
$pais=$_POST["pais"];
$resultadoConsulta = '';
$msg = 'El pais recibido en segundo plano ahora es '.$pais;
if ($pais) {
    $link = mysqli_connect("aquiNombreServidor", "aquiUsuario", "aquiPassword");
    mysqli_select_db($link, "prueba1");
    $tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes correctamente
    $result = mysqli_query($link, "SELECT a.ciudadImportante
                FROM ciudades_importantes AS a, paises AS b
                WHERE a.idPais = b.id
                AND nombrePais = '".$pais."'");

while ($fila = mysqli_fetch_array($result)){
$resultadoConsulta .= ','.$fila['ciudadImportante'];
}

//Devolvemmos la cadena de respuesta
echo $msg.$resultadoConsulta;

mysqli_free_result($result);
mysqli_close($link);
} else {
    echo 'No se han recibido datos';
}
?>

<!DOCTYPE html><html><head><title>Cursos aprende a programar</title><meta charset="utf-8"/>

 <style type="text/css">
 *{font-family:sans-serif;} a:link {text-decoration:none;} select{font-size:18px;}
 div div {color: blue; background-color:#F1FEC6; font-size: 20px; float:left; border: solid; margin: 20px; padding:15px;}
 </style>
 
<script>
function mostrarSugerencia(str) {
var paisElegido='';
if (str=='spain') {paisElegido='España';}
else if (str=='mexico') {paisElegido='México';}
else if (str=='argentina') {paisElegido='Argentina';}
else if (str=='colombia') {paisElegido='Colombia';}
else {paisElegido='none';}

var xmlhttp;
var contenidosRecibidos = new Array();
var nodoMostrarResultados = document.getElementById('listaCiudades');
var contenidosAMostrar = '';

if (str.length==0) { document.getElementById("txtInformacion").innerHTML=""; nodoMostrarResultados.innerHTML = ''; return; }

xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    contenidosRecibidos = xmlhttp.responseText.split(",");
    document.getElementById("txtInformacion").innerHTML=contenidosRecibidos[0];
    for (var i=1; i<contenidosRecibidos.length;i++) {
    contenidosAMostrar = contenidosAMostrar+'<div id="ciudades'+i+'"> <a href="http://aprenderaprogramar.com">' + contenidosRecibidos[i]+ '</a></div>';
    }
    nodoMostrarResultados.innerHTML = contenidosAMostrar;
    }
}
var cadenaParametros = 'pais='+encodeURIComponent(paisElegido);
xmlhttp.open('POST', 'ajaxCU01216F.php'); // Método post y url invocada
xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); // Establecer cabeceras de petición
xmlhttp.send(cadenaParametros); // Envio de parámetros usando POST
}
</script>
</head>

<body style="margin:20px;">
<h2>Elige un país:</h2>
<form action="">
 <select onchange="mostrarSugerencia(this.value)">
  <option value="none">Elige</option>
  <option value="spain">España</option>
  <option value="mexico">México</option>
  <option value="argentina">Argentina</option>
  <option value="colombia">Colombia</option>
</select>
</form>
<br/>
<p>Informacion sobre operacion en segundo plano con POST y Ajax: <span style="color:brown;" id="txtInformacion"></span></p>
<div id="listaCiudades"> </div>
</body>
</html>