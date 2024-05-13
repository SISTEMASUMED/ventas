var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');

// Variables para guardar el estado del trazo
var drawing = false;
var lastX = 0;
var lastY = 0;

// Función para empezar a dibujar
function startDrawing(e) {
    drawing = true;
    [lastX, lastY] = [e.offsetX, e.offsetY];
}

// Función para dibujar el trazo
function draw(e) {
    if (!drawing) return; // Si no estamos dibujando, no hacer nada
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(e.offsetX, e.offsetY);
    ctx.strokeStyle = '#000';
    ctx.lineWidth = 2;
    ctx.stroke();
    [lastX, lastY] = [e.offsetX, e.offsetY];
}

// Función para dejar de dibujar
function stopDrawing() {
    drawing = false;
}


// Event listeners para detectar acciones del usuario
canvas.addEventListener('mousedown', startDrawing);
canvas.addEventListener('mousemove', draw);
canvas.addEventListener('mouseup', stopDrawing);
canvas.addEventListener('mouseout', stopDrawing);


function saveImage() {
    var canvas = document.getElementById('canvas');
    var dataURL = canvas.toDataURL(); // Obtiene la imagen del canvas como base64

    // Enviar la imagen al servidor
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajax/guardar_firma.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        console.log('imagen guardada');
        $('#guardar_firma').attr("disabled", true);
    };
    xhr.send('image=' + encodeURIComponent(dataURL));
}


function limpiar() {
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

        context.clearRect(0, 0, canvas.width, canvas.height);
  
}