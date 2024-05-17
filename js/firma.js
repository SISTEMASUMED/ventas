// var miCanvas = document.getElementById('canvas');

let miCanvas = document.querySelector('#canvas');
let lineas = [];
let correccionX = 0;
let correccionY = 0;
let pintarLinea = false;
// Marca el nuevo punto
let nuevaPosicionX = 0;
let nuevaPosicionY = 0;

let posicion = miCanvas.getBoundingClientRect()
correccionX = posicion.x;
correccionY = posicion.y;

miCanvas.width = 300;
miCanvas.height = 300;

//======================================================================
// FUNCIONES
//======================================================================

/**
 * Funcion que empieza a dibujar la linea
 */
function empezarDibujo () {
    pintarLinea = true;
    lineas.push([]);
};

/**
 * Funcion que guarda la posicion de la nueva línea
 */
function guardarLinea() {
     lineas[lineas.length - 1].push({
         x: nuevaPosicionX,
         y: nuevaPosicionY
     });
}

/**
 * Funcion dibuja la linea
 */
function dibujarLinea (event) {
    event.preventDefault();
    if (pintarLinea) {
        let ctx = miCanvas.getContext('2d')
        // Estilos de linea
        ctx.lineJoin = ctx.lineCap = 'round';
        ctx.lineWidth = 10;
        // Color de la linea
        ctx.strokeStyle = '#fff';
        // Marca el nuevo punto
        if (event.changedTouches == undefined) {
            // Versión ratón
            nuevaPosicionX = event.layerX;
            nuevaPosicionY = event.layerY;
        } else {
            // Versión touch, pantalla tactil
            nuevaPosicionX = event.changedTouches[0].pageX - correccionX;
            nuevaPosicionY = event.changedTouches[0].pageY - correccionY;
        }
        // Guarda la linea
        guardarLinea();
        // Redibuja todas las lineas guardadas
        ctx.beginPath();
        lineas.forEach(function (segmento) {
            ctx.moveTo(segmento[0].x, segmento[0].y);
            segmento.forEach(function (punto, index) {
                ctx.lineTo(punto.x, punto.y);
            });
        });
        ctx.stroke();
    }
}

/**
 * Funcion que deja de dibujar la linea
 */
function pararDibujar () {
    pintarLinea = false;
    guardarLinea();
}

//======================================================================
// EVENTOS
//======================================================================

// Eventos raton
miCanvas.addEventListener('mousedown', empezarDibujo, false);
miCanvas.addEventListener('mousemove', dibujarLinea, false);
miCanvas.addEventListener('mouseup', pararDibujar, false);

// Eventos pantallas táctiles
miCanvas.addEventListener('touchstart', empezarDibujo, false);
miCanvas.addEventListener('touchmove', dibujarLinea, false);




// var ctx = canvas.getContext('2d');

// // Variables para guardar el estado del trazo
// var drawing = false;
// var lastX = 0;
// var lastY = 0;

// // Función para empezar a dibujar
// function startDrawing(e) {
//     drawing = true;
//     [lastX, lastY] = [e.offsetX, e.offsetY];
// }

// // Función para dibujar el trazo
// function draw(e) {
//     if (!drawing) return; // Si no estamos dibujando, no hacer nada
//     ctx.beginPath();
//     ctx.moveTo(lastX, lastY);
//     ctx.lineTo(e.offsetX, e.offsetY);
//     ctx.strokeStyle = '#000';
//     ctx.lineWidth = 2;
//     ctx.stroke();
//     [lastX, lastY] = [e.offsetX, e.offsetY];
// }

// // Función para dejar de dibujar
// function stopDrawing() {
//     drawing = false;
// }


// // Event listeners para detectar acciones del usuario
// canvas.addEventListener('mousedown', startDrawing);
// canvas.addEventListener('mousemove', draw);
// canvas.addEventListener('mouseup', stopDrawing);
// canvas.addEventListener('mouseout', stopDrawing);

// canvas.addEventListener('touchstart', startDrawing);
// canvas.addEventListener('touchmove', draw);
// canvas.addEventListener('touchend', stopDrawing);


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
    const miCanvas = document.getElementById('canvas');
    const context = miCanvas.getContext('2d');

        context.clearRect(0, 0, miCanvas.width, miCanvas.height);
  
}